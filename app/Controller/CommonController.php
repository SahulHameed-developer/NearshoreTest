<?php
App::uses('AppController', 'Controller');
/**
 * 活動カレンダーのController
 *
 * 活動カレンダー情報を表示するControllerです。【画面分類：公開】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class CommonController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');

	// components追加
	public $components = array('Flash', 'Session', 'RequestHandler', 'Constants', 'Common');
	// model追加
	public $uses = array ('Syslog');
	/**
	 *　機能名：ダブルバイト変換
	 */
	public function doublebyte() {
		echo mb_convert_kana($this->request->data['val'],'AKS');exit();
	}
	/**
	 *　機能名：システムエラー追加処理
	 */
	public function systemError($e) {
		$kaiinno = "";
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiincd'])) {
			$kaiinno = $_SESSION['Auth']['User']['TKaiin']['kaiincd'];
		}
		$systemError = array('logdt' => date('Y-m-d G:i:s'), 
							'kaiinno' => $kaiinno, 
							'syubetu' => '01',
							'errurl' => Router::url($this->here, true),
							'errcd' => $e->getCode(),
							'errsyousai' => $e->getMessage()
		);
		$this->Syslog->save($systemError);
	}
	/**
	 *　機能名：セッションでのスクロール値の保存
	 */
	public function scrollsession() {
		$this->Session->write('Footer.scroll_val', $this->request->data['scroll_val']);
		exit;
	}
}