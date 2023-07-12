<?php
App::uses('AppController', 'Controller');
/**
 * Top Controller
 *
 * ニアショアＩＴ協会　会員企業のPRサイトを表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class MemberController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session', 'Constants');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler','Session', 'Common', 'Constants');
	// モデル名追加
	var $uses = array('MGyosyu','TPrsyohin','TKaisya', 'TPrtantou', 'TSyasin');
	
	public function index() {
		if(!empty($this->request->data)) {
			$this->set('prsyohinKaishaDetails', $this->TPrsyohin->find('all',array(
										'joins' => array( 
											array(
												'table' => $this->TKaisya,
												'alias' => 'TKaisya',
												'type' => 'LEFT',
												'conditions' => array('TKaisya.kaisyacd = TPrsyohin.kaisyacd')),
											array(
												'table' => $this->MGyosyu,
												'alias' => 'MGyosyu',
												'type' => 'LEFT',
												'conditions' => array('MGyosyu.gyosyucd = TKaisya.gyosyucd')),
											array(
												'table' => $this->TPrtantou,
												'alias' => 'TPrtantou',
												'type' => 'LEFT',
												'conditions' => array('TPrtantou.arno = TPrsyohin.tantou'))),
										'fields' => array(
												'TPrsyohin.arno',
												'TKaisya.kaisyanm',
												'TKaisya.hpurl',
												'MGyosyu.gyosyunm',
												'TKaisya.jyusyo1',
												'TKaisya.jyusyo2',
												'TKaisya.telno',
												'TPrtantou.tantounm',
												'TPrtantou.busyo',
												'TPrtantou.tantoumsg'),
										'conditions' => array(
												'TPrsyohin.arno' => $this->request->data['arno'],
												'TPrsyohin.koukaikbn' => $this->Constants->KOKAI,
												'TPrsyohin.kikanfrom <=' =>$this->Common->getSystemDate(),
												'TPrsyohin.kikanto >=' =>$this->Common->getSystemDate()))));

			$this->set('prsyohinDetails', $this->TPrsyohin->find('all',array(
										'joins' => array( 
											array(
												'table' => $this->TKaisya,
												'alias' => 'TKaisya',
												'type' => 'LEFT',
												'conditions' => array('TKaisya.kaisyacd = TPrsyohin.kaisyacd'))),
										'fields' => array(
												'TPrsyohin.syohinnm',
												'TPrsyohin.syousai',
												'TPrsyohin.syasinkey'),
										'conditions' => array(
												'TPrsyohin.kaisyacd' => $this->request->data['kaisyacd'],
												'TPrsyohin.tantou' => $this->request->data['tantou'],
												'TPrsyohin.koukaikbn' => $this->Constants->KOKAI,
												'TPrsyohin.kikanfrom <=' =>$this->Common->getSystemDate(),
												'TPrsyohin.kikanto >=' =>$this->Common->getSystemDate()),
										'order' => 'TPrsyohin.hyojino' )));
		} else {
			$this->redirect(['controller' => 'top', 'action' => 'index']);
		}
	}

	public function detail() {
		if(!empty($this->request->data)) {
			$this->set('prsyohinKaishaDetails', $this->TKaisya->find('all',array(
										'joins' => array(
											array(
												'table' => $this->MGyosyu,
												'alias' => 'MGyosyu',
												'type' => 'LEFT',
												'conditions' => array('MGyosyu.gyosyucd = TKaisya.gyosyucd'))),
										'fields' => array(
												'TKaisya.kaisyanm',
												'TKaisya.hpurl',
												'MGyosyu.gyosyunm',
												'TKaisya.jyusyo1',
												'TKaisya.jyusyo2',
												'TKaisya.telno'),
										'conditions' => array(
												'TKaisya.kaisyacd' => $this->request->data['kaisyacd'])
									)));
			$this->set('prtantou', $this->TPrtantou->find('all',array(
										'fields' => array(
												'TPrtantou.tantounm',
												'TPrtantou.tantoumsg',
												'TPrtantou.busyo'),
										'conditions' => array(
												'TPrtantou.arno' => $this->request->data['prtantou'])
									)));
			$this->set('tantounm', isset($this->request->data['tantounm']) ? $this->request->data['tantounm'] : '' );
			$this->set('tantoumsg', isset($this->request->data['tantoumsg']) ? $this->request->data['tantoumsg'] : '' );
			$this->set('busyo', isset($this->request->data['busyo']) ? $this->request->data['busyo'] : '' );
			

			if(isset($_FILES ['syasin1'] ['tmp_name'])) {
				if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
					$syasin1 = fread(fopen($_FILES['syasin1']['tmp_name'], "r" ), $_FILES['syasin1']['size']);
					$this->set('syasin1', $syasin1);
					$previewInfo['syasin1'] = $syasin1;
					$this->set('previewInfo', $previewInfo);
					$this->Session->write("previewInfo", $previewInfo);
				}
			}
			$this->set('urlsyasinKey', isset($this->request->data['urlsyasinKey']) ? $this->request->data['urlsyasinKey'] : '' );
			$this->set('syohinnm', $this->request->data['syohinnm']);
			$this->set('syousai', $this->request->data['syousai']);
			$this->set('reset', $this->request->data['reset1']);
		} else {
			$this->redirect(['controller' => 'top', 'action' => 'index']);
		}
	}

	/**
	 *　画面名：会員企業
	 *　機能名：写真情報の写真を取得
	 */
	public function getSyasin($syasinkey) {
		$pictImage = $this->TSyasin->find('first', array(
							'conditions' => array ('TSyasin.syasinkey ' => $syasinkey,
													'TSyasin.bunrui ' => $this->Constants->PRSYOHIN)));
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($pictImage['TSyasin']['syasin'])); 
		echo $pictImage['TSyasin']['syasin'];
	}

	/**
	 *　画面名：会員企業
	 *　機能名：写真表示
	 */
	public function viewSyasin($syasinName) {
		$previewInfo = $this->Session->read('previewInfo');
		$this->Session->write ( "previewInfo", '' );
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($previewInfo[$syasinName]));
		echo $previewInfo[$syasinName];
	}
}