<?php
App::uses('AppController', 'Controller');

/**
 * Banner Controller
 *
 * 会員の方へ（バナー）を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class BannerController extends AppController
{
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'Session', 'RequestHandler', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MDlcate', 'TSyasin', 'TFile','TDlfile');
	/**
	 *　画面名：会員の方へ（バナー）
	 *　機能名：会員の方へ（バナー）表示
	 */
	public function index() {
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}
	}
}
?>