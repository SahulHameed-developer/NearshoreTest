<?php
App::uses('AppController', 'Controller');

/**
 * 管理ログインController
 *
 * 管理ログインするControllerです。【画面分類：管理】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session', 'Constants');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants');
	var $uses = array('TKengen');
	// レイアウト無し
	public $autoLayout = false;
	// フィルタ追加
	public function beforeFilter() {
		parent::beforeFilter();
	}
	/**
	 *　画面名：ログイン
	 *　機能名：初期表示
	 */
	public function index() {
		try {
			$login = true;
			$this->Session->delete('Message.flash');
			$this->Session->delete('Auth.redirect');
			if (array_key_exists('loginModoru', $this->request->data)){
				$this->set('username', '');
			} else {
				if ($this->request->is('post')) {
					$this->set('username', $this->request->data['lgid']);
					$msg = "";
					if (empty($this->request->data['lgid'])) {
						$msg = "ユーザ名が未入力です。" . '<br/>';
						$login = false;
					}
					if (empty($this->request->data['lgpass'])) {
						$msg = $msg . "パスワードが未入力です。";
						$login = false;
					}
					if ($login) {
						$this->Auth->logout();
						if ($this->Auth->login()) {
							$this->redirect($this->Auth->redirect());
						} else {
							$this->set('username', $this->request->data['lgid']);
							$this->Session->setFlash("正しいユーザ名・パスワードを入力してください。");
						}
					} else {
						$this->Session->setFlash($msg);
					}
				} else {
					$this->set('username', '');
				}
			}
			// 画面の移動
			$this->render('login');
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：ホームメニュ
	 *　機能名：メニュ表示
	 */
	public function home() {
		// 管理者区分
		try {
			if($this->referer() == '/') {
				$this->redirect ( [
						'controller' => 'Error',
						'action' => 'systemError' ] );
			}
			$user = $this->TKengen->find('all', array(
					'fields' => array(
						'TKengen.kcaltouroku',
						'TKengen.kcalkoukai',
						'TKengen.khoutouroku',
						'TKengen.khoukoukai',
						'TKengen.osirasetouroku',
						'TKengen.osirasekoukai',
						'TKengen.yuekitouroku',
						'TKengen.yuekikoukai',
						'TKengen.syukketusansyo'),
					'conditions' => array(
						'TKengen.kaiincd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'])));
			if(isset($user[0]['TKengen']['kcaltouroku'])) {
				$this->Session->write('Auth.User.TKengen', $user[0]['TKengen']);
			} else {
				$this->Session->write('Auth.User.TKengen.kcaltouroku', '0');
				$this->Session->write('Auth.User.TKengen.kcalkoukai', '0');
				$this->Session->write('Auth.User.TKengen.khoutouroku', '0');
				$this->Session->write('Auth.User.TKengen.khoukoukai', '0');
				$this->Session->write('Auth.User.TKengen.osirasetouroku', '0');
				$this->Session->write('Auth.User.TKengen.osirasekoukai', '0');
				$this->Session->write('Auth.User.TKengen.yuekitouroku', '0');
				$this->Session->write('Auth.User.TKengen.yuekikoukai', '0');
				$this->Session->write('Auth.User.TKengen.syukketusansyo', '0');
			}
			$kanrikbn = $_SESSION['Auth']['User']['TKaiin']['kanrikbn'];
			// 活動カレンダー登録権限
			$kcaltouroku = $_SESSION['Auth']['User']['TKengen']['kcaltouroku'];
			// 活動カレンダー公開権限
			$kcalkoukai = $_SESSION['Auth']['User']['TKengen']['kcalkoukai'];
			// 活動報告登録権限
			$khoutouroku = $_SESSION['Auth']['User']['TKengen']['khoutouroku'];
			// 活動報告公開権限
			$khoukoukai = $_SESSION['Auth']['User']['TKengen']['khoukoukai'];
			// お知らせ情報登録権限
			$osirasetouroku = $_SESSION['Auth']['User']['TKengen']['osirasetouroku'];
			// お知らせ情報公開権限
			$osirasekoukai = $_SESSION['Auth']['User']['TKengen']['osirasekoukai'];
			// お知らせ情報登録権限
			$yuekitouroku = $_SESSION['Auth']['User']['TKengen']['yuekitouroku'];
			// お知らせ情報公開権限
			$yuekikoukai = $_SESSION['Auth']['User']['TKengen']['yuekikoukai'];
			// 活動カレンダー一覧
			$katsudoCal = array($kcaltouroku, $kcalkoukai);
			// 活動報告一覧
			$katsudoHokoku = array($khoutouroku, $khoukoukai);
			// お知らせ
			$osirase = array($osirasetouroku, $osirasekoukai);
			// 有益情報
			$yueki = array($yuekitouroku, $yuekikoukai);
			// 初期表示値のセット
			$menuInfo = array('kaiinInfo' => $this->Constants->HYOJI,
					'kaiinAdd' => '',
					'kaiinEdit' => '',
					'katsudoInfo' => '',
					'katsudoCalList'=> '',
					'katsudoHokokuList'=>'',
					'katsudoAdd'=>'',
					'oshiraseInfo' => '',
					'oshiraseAdd'=>'',
					'prInfo' => '',
					'kanrishaInfo' => '',
					'superkanrishaInfo' => '');
			$this->Session->write('Auth.User.Menu', $menuInfo);
			
			// 管理者区分はシステム管理者の場合

			if($kanrikbn >= $this->Constants->SYS_SUPER_KANRISHA){
				$this->Session->write('Auth.User.Menu.superkanrishaInfo', $this->Constants->HYOJI);
			}
			if($kanrikbn >= $this->Constants->SYS_KANRISHA){
				// 会員情報追加
				$this->Session->write('Auth.User.Menu.kaiinAdd', $this->Constants->HYOJI);
				// ニアショアIT協会の活動
				$this->Session->write('Auth.User.Menu.katsudoInfo', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.katsudoCalList', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.katsudoHokokuList', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.katsudoAdd', $this->Constants->HYOJI);
				// お知らせ
				$this->Session->write('Auth.User.Menu.oshiraseInfo', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.oshiraseAdd', $this->Constants->HYOJI);
				// 有益情報
				$this->Session->write('Auth.User.Menu.yuekiInfo', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.yuekiAdd', $this->Constants->HYOJI);
				// 管理者機能
				$this->Session->write('Auth.User.Menu.kanrishaInfo', $this->Constants->HYOJI);
				$this->Session->write('Auth.User.Menu.syukketusansyo', $this->Constants->HYOJI);
				// PR情報
				$this->Session->write('Auth.User.Menu.prInfo', $this->Constants->HYOJI);
				
			} else {
				// 会員情報編集
				$this->Session->write('Auth.User.Menu.kaiinEdit', $this->Constants->HYOJI);
				// ニアショアIT協会の活動
				if(in_array($this->Constants->KENGEN_YES, $katsudoCal) ||
						in_array($this->Constants->KENGEN_YES, $katsudoHokoku)){
					$this->Session->write('Auth.User.Menu.katsudoInfo', $this->Constants->HYOJI);
					// 活動カレンダー一覧
					if(in_array($this->Constants->KENGEN_YES, $katsudoCal)){
						$this->Session->write('Auth.User.Menu.katsudoCalList', $this->Constants->HYOJI);
					}
					// 活動カレンダー 新規追加
					if($kcaltouroku==$this->Constants->KENGEN_YES){
						$this->Session->write('Auth.User.Menu.katsudoAdd', $this->Constants->HYOJI);
					}
					// 活動報告一覧
					if(in_array($this->Constants->KENGEN_YES, $katsudoHokoku)){
						$this->Session->write('Auth.User.Menu.katsudoHokokuList', $this->Constants->HYOJI);
					}
				}
				// お知らせ一覧
				if (in_array($this->Constants->KENGEN_YES, $osirase)){
					$this->Session->write('Auth.User.Menu.oshiraseInfo', $this->Constants->HYOJI);
				}
				// お知らせ　新規追加
				if($osirasetouroku==$this->Constants->KENGEN_YES){
					$this->Session->write('Auth.User.Menu.oshiraseAdd', $this->Constants->HYOJI);
				}
				// 有益情報一覧
				if (in_array($this->Constants->KENGEN_YES, $yueki)){
					$this->Session->write('Auth.User.Menu.yuekiInfo', $this->Constants->HYOJI);
				}
				// 有益情報　新規追加
				if($yuekitouroku==$this->Constants->KENGEN_YES){
					$this->Session->write('Auth.User.Menu.yuekiAdd', $this->Constants->HYOJI);
				}
			}
			// 画面の移動
			$this->render('home');
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：ログイン
	 *　機能名：初期表示
	 */
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function sessionTimeout() {
		$this->Auth->logout();	
		$this->redirect ( [
				'controller' => 'Admin',
				'action' => 'index' ] );
	}
	
}