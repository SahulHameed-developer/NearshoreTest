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
class LoginController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session', 'Constants');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants');
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
			if (isset($this->request->data['lgid'])) {
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
						// $this->redirect($this->Auth->redirect());
						$this->redirect ( [
							'controller' => 'Top',
							'action' => 'index' ] );
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
			// 画面の移動
			$this->render('/Login/index');
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function home() {
		try {
			print_r($_SESSION['Auth']['User']['TKaiin']['kaiinnm']);
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index' ] );
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
		$this->Session->destroy('Auth'); 
		$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index' ] );
		// return $this->redirect($this->Auth->logout());
	}

	public function sessionTimeout() {
		$this->Auth->logout();
		exit;
	}

	public function checkSession() {
		$sessionFlg = 0;
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm']) && 
			!empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
			$sessionFlg = 1;
		}
		echo json_encode($sessionFlg);exit();
	}

}