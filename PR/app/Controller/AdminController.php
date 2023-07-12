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

	var $uses = array('TKaisya','TPrkeiyaku');
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
			if (array_key_exists('loginModoru', $this->request->data)) {
				$this->set('mailaddress', '');
			} else {
				if ($this->request->is('post')) {
					$this->set('mailaddress', $this->request->data['mailaddress']);
					$msg = "";
					if (empty($this->request->data['mailaddress'])) {
						$msg = "メールアドレスが未入力です。" . '<br/>';
						$login = false;
					}
					if ($login) {
						$this->Auth->logout();
						if ($this->Auth->login()) {
							$this->Session->write('Auth.User.Mailaddress', $this->request->data['mailaddress']);
							$this->redirect($this->Auth->redirect());
						} else {
							$this->set('mailaddress', '');
							$checkMailexists = $this->TKaisya->find('first',array(
											'fields' => array('TKaisya.kaisyacd'),
											'conditions' => array('OR' => array(
													array('TKaisya.prmailaddr1 ' => $this->request->data['mailaddress']),
													array('TKaisya.prmailaddr2 ' => $this->request->data['mailaddress']),
													array('TKaisya.prmailaddr3 ' => $this->request->data['mailaddress'])))
											));
							if(isset($checkMailexists['TKaisya']['kaisyacd'])) {
								$gettprsyohin = $this->TPrkeiyaku->find('first', array(
												'fields' => array('g_keiyaku_from','g_keiyaku_to'),
												'conditions' => array('kaisyacd' => $checkMailexists['TKaisya']['kaisyacd'])));
								if(isset($gettprsyohin['TPrkeiyaku']['g_keiyaku_from'])) {
									if(date("Y/m/d") < date('Y/m/d', strtotime($gettprsyohin['TPrkeiyaku']['g_keiyaku_to'])) && date("Y/m/d") > date('Y/m/d', strtotime($gettprsyohin['TPrkeiyaku']['g_keiyaku_from']))) {
										$this->Session->setFlash("　ログインできません。");
									} else {
										$this->Session->setFlash("　契約されておりません。");
									}
								} else {
									$this->Session->setFlash("　ログインできません。");
								}
							} else {
								$this->Session->setFlash("　入力されたメールアドレスは未登録です。");
							}
						}
					} else {
						$this->Session->setFlash($msg);
					}
				} else {
					$this->set('mailaddress', '');
				}
			}
			// 画面の移動
			$this->render('/login');
		} catch (Exception $e) {
			$this->systemError($e);
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

	/**
	 *　機能名：システムエラー追加処理
	 */
	public function systemError($e) {
		$kaiinno = "";
		$systemError = array('logdt' => date('Y-m-d G:i:s'), 
							'kaiinno' => $kaiinno, 
							'syubetu' => '01',
							'errurl' => Router::url($this->here, true),
							'errcd' => $e->getCode(),
							'errsyousai' => $e->getMessage()
		);
		$this->Syslog->save($systemError);
	}
	
}