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
class TopController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler', 'Common', 'Constants');
	// モデル名追加
	var $uses = array('MGyosyu','TPrsyohin','TKaisya', 'TSyasin', 'TKaiin','TPrkeiyaku');

	public function index() {
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName($this->MGyosyu));
		
		// 初期価値のセット
		$this->set('gyosyucd', '');
		$this->set('company', '');
		$this->set('location', '');
		$this->set('member', '');
		$this->set('product', '');

		$conditions = array();
		$Kaiinconditions = array();

		// 初期表示の条件
		$conditions[] = array('TPrsyohin.prkbn' => $this->Constants->SLIDE_YES,
							'TPrsyohin.koukaikbn' => $this->Constants->KOKAI,
							'TPrsyohin.kikanfrom <=' =>$this->Common->getSystemDate(),
							'TPrsyohin.kikanto >=' =>$this->Common->getSystemDate());

		// 業種選択の場合
		if(!empty($this->request->data['gyosyucd'])) {
			$conditions[] = array('TKaisya.gyosyucd' => $this->request->data['gyosyucd']);
			$this->set('gyosyucd', $this->request->data['gyosyucd']);
		}
		// 会社名の場合
		if(!empty($this->request->data['company'])) {
			$conditions[] = array('TKaisya.kaisyanm LIKE ' => "%".$this->request->data['company']."%");
			$this->set('company', $this->request->data['company']);
		}
		// 所在地の場合
		if(!empty($this->request->data['location'])) {
			$conditions[] = array('OR' => array(
							array('TKaisya.jyusyo1 LIKE ' => "%".$this->request->data['location']."%"),
							array('TKaisya.jyusyo2 LIKE ' => "%".$this->request->data['location']."%")));
			$this->set('location', $this->request->data['location']);
		}
		// 会員名の場合
		if(!empty($this->request->data['member'])) {
			$Kaiinconditions = "t_kaiin.kaiinnm LIKE '%".$this->request->data['member']."%' AND ";
			$this->set('member', $this->request->data['member']);
		} else {
			$Kaiinconditions = "";
		}
		// 商品名の場合
		if(!empty($this->request->data['product'])) {
			$conditions[] = array('TPrsyohin.syohinnm LIKE ' => "%".$this->request->data['product']."%");
			$this->set('product', $this->request->data['product']);
		}

		$this->set('prsyohinDetails', $this->TPrsyohin->find('all',array(
										'joins' => array( 
											array(
												'table' => $this->TKaisya,
												'alias' => 'TKaisya',
												'type' => 'LEFT',
												'conditions' => array('TKaisya.kaisyacd = TPrsyohin.kaisyacd')),
											array(
												'table' => $this->TPrkeiyaku,
												'alias' => 'TPrkeiyaku',
												'type' => 'RIGHT',
												'conditions' => array('TPrkeiyaku.kaisyacd = TKaisya.kaisyacd',
																	'TPrkeiyaku.g_keiyaku_from <= CURDATE()',
																	'TPrkeiyaku.g_keiyaku_to >= CURDATE()' )),
											array(
												'table' => sprintf("(SELECT * FROM t_kaiin WHERE %s (t_kaiin.taikaidate IS NULL OR t_kaiin.taikaidate = '0000-00-00') GROUP BY kaisyacd)", $Kaiinconditions),
												'alias' => 'TKaiin',
												'type' => 'RIGHT',
												'conditions' => array('TKaiin.kaisyacd = TKaisya.kaisyacd'))),
										'fields' => array(
												'TPrsyohin.arno',
												'TPrsyohin.kaisyacd',
												'TPrsyohin.tantou',
												'TPrsyohin.syohinnm',
												'TPrsyohin.syousai',
												'TPrsyohin.syasinkey',
												'TKaisya.jyusyo1',
												'TKaisya.jyusyo2',
												'TKaisya.gyosyucd',
												'TKaisya.kaisyanm',
												'TKaiin.kaiinnm'),
										'conditions' => $conditions,
										'order' => 'rand()' )));
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

}