<?php
App::uses('AppController', 'Controller');

/**
 * Top Controller
 *
 * ニアショアIT協会トップページを表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class TopController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler', 'Constants', 'Common');
	// モデル名配列宣言
	var $uses = array('TKatudo', 'TOsirase', 'TYueki');
	/**
	 * 画面名　：　ニアショアIT協会トップページ
	 * 機能処理　：　初期表示
	 */
	public function index() {
		// お知らせ情報を取得
		$this->set('oshiraseDetails', $this->TOsirase->find('all', array(
												'fields' => array(
														'TOsirase.arno',
														'TOsirase.osirasedt',
														'TOsirase.title',
														'kousinTourokudt'),
												'limit' => 5,
												'conditions' => array ('TOsirase.osirasedt <=' =>$this->Common->getSystemDateTime(), 
														'TOsirase.koukaikbn ' => $this->Constants->KOKAI),
												'order' => array ('TOsirase.osirasedt DESC')
										)));
		// 有益情報を取得
		$this->set('yuekiDetails', $this->TYueki->find('all', array(
												'fields' => array(
														'TYueki.arno',
														'TYueki.jyohodt',
														'TYueki.title',
														'kousinTourokudt'),
												'limit' => 5,
												'conditions' => array ('TYueki.jyohodt <=' =>$this->Common->getSystemDateTime(), 
														'TYueki.koukaikbn ' => $this->Constants->KOKAI),
												'order' => array ('TYueki.jyohodt DESC')
										)));
		// 活動カレンダー情報を取得
		$this->set('katudoDetails', $this->TKatudo->find('all',array(
												'fields' => array(
														'TKatudo.arno',
														'TKatudo.bunruicd',
														'TKatudo.kaisaidate',
														'TKatudo.hyoudai',
														'TKatudo.meisyou'),
												'limit' => 5,
												'conditions' => array ('TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(), 
														'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
												'order' => array ('kaisaidate ASC', 'kaisaitmfrom ASC')
										)));
	}
}