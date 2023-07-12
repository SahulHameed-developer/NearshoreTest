<?php
App::uses('AppController', 'Controller');

/**
 * Privacy Controller
 *
 * 個人情報を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class PrivacyController extends AppController
{
	// helpers配列宣言
	public $helpers = array('Html', 'Form');
	// components配列宣言
	public $components = array('RequestHandler');
	/**
	 *　画面名：個人情報
	 *　機能名：個人情報の取り扱いについての表示
	 */
	public function index() {
		// 画面の移動
		$this->render('index');
	}
	/**
	 *　画面名：会議・イベント申込、　入会申込、　お問い合わせ申込
	 *　機能名：個人情報の取り扱いについての表示
	 */
	public function privacy() {
		// 画面の移動。
		$this->render('privacy');
	}
}
?>