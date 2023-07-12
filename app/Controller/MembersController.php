<?php

App::uses('AppController', 'Controller');

/**
 * Members Controller
 *
 * 会員企業を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class MembersController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler', 'Constants', 'Session', 'Common');
	// モデル名配列宣言
	var $uses = array('TKaiin', 'TKaisya', 'MGyosyu', 'MKaiinsb', 'TSyasin');
	// フリーワード検索種別
	public $searchTypeList = array(1 => "企業名", 2 => "連絡窓口", 3 => "所在地");
	// 企業名
	public $KIGYOMEI = 1;
	// 連絡窓口
	public $KAIINNAME = 2;
	// 所在地
	public $SHOZAICHI = 3;
	/**
	 *　画面名：会員企業
	 *　機能名：初期表示
	 */
	public function index() {
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName ($this->MGyosyu));
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName ($this->MKaiinsb));
		// 会員情報と会社情報 テーブルから検索
		$query = $this->TKaisya->find('all', array(
									'joins' => array( array(
										'table' => sprintf("(SELECT koukaikbn, kaiincd, syasin, kaisyacd, kaiinnm, kaiinsbcd, taikaidate FROM t_kaiin ORDER BY tourokudt)"),
										'alias' => 'tkn',
										'type' => 'INNER',
										'conditions' => array(
										'tkn.kaisyacd = TKaisya.kaisyacd'))),
									'fields' => array(
										'tkn.koukaikbn',
										'tkn.kaiincd',
										'TKaisya.kaisyacd',		// 会社コード
										'TKaisya.kaisyanm',		// 会社名称 
										'TKaisya.kaisyanmkana',	// 会社名称かな 
										'TKaisya.daihyoyknm',	// 代表者役職名称
										'TKaisya.daihyonm',		// 代表者名称
										'TKaisya.yubinno',		// 郵便番号
										'TKaisya.jyusyo1',		// 住所１
										'TKaisya.jyusyo2',		// 住所２
										'TKaisya.telno',		// 電話番号
										'TKaisya.faxno',		// FAX番号
										'TKaisya.hpurl',		// ホームページURL
										'TKaisya.gyoumu',		// 業務内容
										'TKaisya.pr',			// PR内容
										'TKaisya.syasin',		// 写真キー
										'tkn.syasin',			// 写真
										'tkn.kaisyacd',			// 会社コード
										'tkn.kaiinnm'),
									'conditions' => array(
										'tkn.kaiinsbcd' =>$this->Constants->SEIKAIIN,
										'tkn.taikaidate ' => NULL,
										'TKaisya.koukaikbn' => $this->Constants->KOKAI),
									'group' => 'TKaisya.kaisyacd',
									'order' => array(
										'TKaisya.kaisyanmkana')));
		// 検索情報のセット
		$this->set('searchinfo', $query);
		// 検索会社件数取得
		$conditions = array('tkn.kaiinsbcd' =>$this->Constants->SEIKAIIN,
							'TKaisya.koukaikbn' => $this->Constants->KOKAI,
							'tkn.taikaidate ' => NULL);
		// 検索一覧カウントをセット
		$this->set('searchcount',$this->getKaisyaCount($conditions));
		// フリーワード検索種別
		$this->set('searchTypeList', $this->searchTypeList);
		// 初期表示値のセット
		$this->setInitialValue();
	}
	/**
	 *　画面名：会員企業
	 *　機能名：検索処理
	 */
	public function search() {
		if(empty($this->request->data)){
			// 初期表示
			$this->redirect([ 
					'controller' => 'members',
					'action' => 'index']);
		} else {
			if(isset($this->request->data['membersModoruFrm']['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['membersModoruFrm']['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			// 業種名称のセット
			$this->set('gyosyunm',$this->Common->getGyosyuName($this->MGyosyu));
			// 会員種別名称のセット
			$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName($this->MKaiinsb));
			if (array_key_exists('searchbtn', $this->request->data)){
				$radiovalue = $this->request->data['free_radio'];
				$keyWord = trim($this->request->data['free_word']);
				if(!empty($this->request->data['industry'])){
					$industry = $this->request->data['industry'];
				} else {
					$industry = "";
				}
				$member_type = $this->request->data['members_type'];
			} else {
				$radiovalue = $this->request->data['membersModoruFrm']['free_radio'];
				$keyWord = trim($this->request->data['membersModoruFrm']['free_word']);
				$industry = $this->request->data['membersModoruFrm']['industry'];
				$member_type = $this->request->data['membersModoruFrm']['members_type'];
			}
			$conditions = array();
			$order = array();
			// 業種名称選択の場合
			if(!empty($industry)){
				$conditions[] = array('TKaisya.gyosyucd' =>$industry);
			}
			// 会員種別名称選択の場合
			if(!empty($member_type)){
				$conditions[] = array('tkn.kaiinsbcd' =>$member_type);
			}
			if($radiovalue == $this->KAIINNAME && !empty($keyWord)){
				$order[] = array('tkn.kaiinnmkana');
			} else {
				$order[] = array('TKaisya.kaisyanmkana');
			}
			// フリーワードが連絡窓口の場合
			if($radiovalue == $this->KAIINNAME){
				if(!empty($keyWord)){
					$conditions[] = array('tkn.kaiinnm LIKE ' => "%$keyWord%");
				}
				$this->set('freewordTypeChk', $this->KAIINNAME);
			// フリーワードが所在地の場合
			} else if($radiovalue == $this->SHOZAICHI){
				if(!empty($keyWord)){
					$conditions[] = array('OR' => array(
							array('TKaisya.jyusyo1 LIKE ' => "%$keyWord%"),
							array('TKaisya.jyusyo2 LIKE ' => "%$keyWord%")));
				}
				$this->set('freewordTypeChk', $this->SHOZAICHI);
			// フリーワードが企業名の場合
			} else {
				if(!empty($keyWord)){
					$conditions[] = array('TKaisya.kaisyanm LIKE ' => "%$keyWord%");
				}
				$this->set('freewordTypeChk', $this->KIGYOMEI);
			}
			// 公開区分
			$conditions[] = array('TKaisya.koukaikbn' => $this->Constants->KOKAI,'tkn.taikaidate ' => NULL);
			// 会員情報と会社情報 テーブルから検索
			$query = $this->TKaisya->find('all', array(
									'joins' => array( array(
											'table' => sprintf("(SELECT koukaikbn, kaiincd, syasin, kaisyacd, kaiinnm, kaiinnmkana, kaiinsbcd, taikaidate FROM t_kaiin ORDER BY tourokudt)"),
											'alias' => 'tkn',
											'type' => 'INNER',
											'conditions' => array(
												'tkn.kaisyacd = TKaisya.kaisyacd'))),
									'fields' => array(
											'tkn.koukaikbn',
											'tkn.kaiincd',
											'TKaisya.kaisyacd',		// 会社コード
											'TKaisya.kaisyanm',		// 会社名称 
											'TKaisya.kaisyanmkana',		// 会社名称かな 
											'TKaisya.daihyoyknm',	// 代表者役職名称
											'TKaisya.daihyonm',		// 代表者名称
											'TKaisya.yubinno',		// 郵便番号
											'TKaisya.jyusyo1',		// 住所１
											'TKaisya.jyusyo2',		// 住所２
											'TKaisya.telno',		// 電話番号
											'TKaisya.faxno',		// FAX番号
											'TKaisya.hpurl',		// ホームページURL
											'TKaisya.gyoumu',		// 業務内容
											'TKaisya.pr',			// PR内容
											'TKaisya.syasin',		// 写真キー
											'tkn.kaisyacd',			// 会社コード
											'tkn.kaiinnm',			// 会員名称
											'tkn.kaiinnmkana'),		// 会員名称かな
									'conditions' => $conditions,
									'group' => 'TKaisya.kaisyacd',
									'order' => $order ));
			// フリーワード値をセット
			$this->set('keywordVal',$keyWord);
			//業種名称の初期表示
			$this->set('selectedGyosyunm',$industry);
			//会員種別名称の初期表示
			$this->set('selectedKaiinsbnm',$member_type);
			// 検索情報のセット
			$this->set('searchinfo',$query);
			// 検索会社件数取得
			$conditions[] = array('tkn.taikaidate ' => NULL);
			$this->set('searchcount',$this->getKaisyaCount($conditions));
			// フリーワード検索種別
			$this->set('searchTypeList', $this->searchTypeList);
			//　画面の移動
			$this->render('index');
		}
	}
	/**
	 *　画面名：会員企業
	 *　機能名：会員企業の詳細的な表示
	 */
	public function detail() {
		// データが空白ではないの場合、以下の処理が動作する。
		if (!empty($this->request->data)) {
			$this->Session->delete('Auth.User.News.previewMemberInfo');
			if (!empty($this->request->data['kaishaShosaifrm'])) {
				// 会員情報と会社情報 テーブルから検索
				$query = $this->TKaisya->find('first', array(
						'joins' => array( array(
								'table' => $this->TKaiin,
								'alias' => 'tkn',
								'type' => 'INNER',
								'conditions' => array(
										'tkn.kaisyacd = TKaisya.kaisyacd'))),
						'fields' => array(
								'tkn.koukaikbn',
								'tkn.kaiincd',
								'TKaisya.kaisyacd',		// 会社コード
								'TKaisya.kaisyanm',		// 会社名称
								'TKaisya.daihyoyknm',	// 代表者役職名称
								'TKaisya.daihyonm',		// 代表者名称
								'TKaisya.yubinno',		// 郵便番号
								'TKaisya.jyusyo1',		// 住所１
								'TKaisya.jyusyo2',		// 住所２
								'TKaisya.telno',		// 電話番号
								'TKaisya.faxno',		// FAX番号
								'TKaisya.hpurl',		// ホームページURL
								'TKaisya.gyoumu',		// 業務内容
								'TKaisya.pr',			// PR内容
								'TKaisya.syasin',		// 写真キー
								'TKaisya.kaisyanm',
								'tkn.kaisyacd',			// 会社コード
								'tkn.kaiinnm'),
						'conditions' => array(
								'tkn.kaiincd' => $this->request->data['kaishaShosaifrm']['kaiincd'],
								'tkn.taikaidate' => NULL,
								'TKaisya.kaisyacd' => $this->request->data['kaishaShosaifrm']['kaisyacd']),
						'order' => array(
								'TKaisya.kaisyanm')));
						// 詳細情報
				$this->set('detailinfo', $query);
				if (!empty($query['TKaisya']['yubinno'])) {
					$yubinStr = $query['TKaisya']['yubinno'];
					// 郵便番号（上3桁
					$yubincd = substr($yubinStr, 0, 3);
					// 郵便番号（下4桁）
					$yubinno = substr($yubinStr, 3, 4);
					// 郵便番号
					$this->set('yubinno', '〒' . $yubincd . '-' . $yubinno);
				} else {
					$this->set('yubinno', '');
				}
				if (!empty($this->request->data['kaishaShosaifrm']['kaisyacd'])) {
					// 会員情報テーブルから検索
					$this->set('kaiininfo', $this->TKaiin->find('all' , array(
							'conditions' => array (
									'TKaiin.kaisyacd' => $this->request->data ['kaishaShosaifrm']['kaisyacd'],
									'TKaiin.taikaidate' => NULL),
							'order'=> array (
									'TKaiin.kaiinsbcd' => 'ASC'))));
				} else {
					$this->set('kaiininfo', '');
				}
				if (!empty($query['TKaisya']['syasin'])) {
					$this->set('syasinInfo', $this->TSyasin->find('all', array(
							'conditions' => array(
									'TSyasin.syasinkey ' => $query['TKaisya']['syasin'],
									'TSyasin.bunrui ' => $this->Constants->KAISYA),
							'order' => array(
									'TSyasin.rno' => 'ASC'))));
				}else{
					$this->set('syasinInfo', '');
				}
				// 会員種別名称の初期表示
				$this->set('selectedKaiinsbnm', $this->request->data['kaishaShosaifrm']['members_type']);
				// 業種名称の初期表示
				$this->set('selectedGyosyunm', $this->request->data['kaishaShosaifrm']['industry']);
				// フリーワード値をセット
				$this->set('keywordVal', $this->request->data['kaishaShosaifrm']['free_word']);
				$this->set('radiovalue', $this->request->data['kaishaShosaifrm']['free_radio']);
			} else {
				$this->request->data['yubinno'];
				$dataof['TKaisya'] = $this->request->data;
				if(isset($dataof['TKaisya']['kaiinkoukaikbn'])) {
					$dataof['TKaisya']['koukaikbn'] = $dataof['TKaisya']['kaiinkoukaikbn'];
				}
				$dataof['TKaisya']['kaisyacd'] = '';
				$dataof['TKaisya']['kaiincd'] = '';
				$this->set('detailinfo', $dataof);
				if ($this->request->data['yubinno']) {
					$yubinStr = $this->request->data['yubinno'];
					// 郵便番号（上3桁
					$yubincd = substr($yubinStr, 0, 3);
					// 郵便番号（下4桁）
					$yubinno = substr($yubinStr, 3, 4);
					// 郵便番号
					$this->set('yubinno', '〒' . $yubincd . '-' . $yubinno);
				} else {
					$this->set('yubinno', '');
				}
				$syasin1 = "";
				if (count ( $_FILES ) > 0) {
					if(isset($_FILES ['kaiinsyasin'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['kaiinsyasin'] ['tmp_name'] )) {
							$syasin1 = fread ( fopen ( $_FILES ['kaiinsyasin'] ['tmp_name'], "r" ), $_FILES ['kaiinsyasin'] ['size']);
						}
					}
					if (!isset($this->request->data['memberAddFrm'])) {
						$syasin2 = "";
						$syasin3 = "";
						$syasin4 = "";
						$syasin5 = "";
						if(isset($_FILES ['kaisyalogo'] ['tmp_name'])) {
							if (is_uploaded_file ( $_FILES ['kaisyalogo'] ['tmp_name'] )) {
								$syasin2 = fread ( fopen ( $_FILES ['kaisyalogo'] ['tmp_name'], "r" ), $_FILES ['kaisyalogo'] ['size'] );
							}
						}
						if(isset($_FILES ['primage1'] ['tmp_name'])) {
							if (is_uploaded_file ( $_FILES ['primage1'] ['tmp_name'] )) {
								$syasin3 = fread ( fopen ( $_FILES ['primage1'] ['tmp_name'], "r" ), $_FILES ['primage1'] ['size']);
							}
						}
						if(isset($_FILES ['primage2'] ['tmp_name'])) {
							if (is_uploaded_file ( $_FILES ['primage2'] ['tmp_name'] )) {
								$syasin4 = fread ( fopen ( $_FILES ['primage2'] ['tmp_name'], "r" ), $_FILES ['primage2'] ['size'] );
							}
						}
						if(isset($_FILES ['primage3'] ['tmp_name'])) {
							if (is_uploaded_file ( $_FILES ['primage3'] ['tmp_name'] )) {
								$syasin5 = fread ( fopen ( $_FILES ['primage3'] ['tmp_name'], "r" ), $_FILES ['primage3'] ['size']);
							}
						}
						// 写真をセットする。
						$previewMemberInfo['syasin2']=$syasin2;
						$previewMemberInfo['syasin3']=$syasin3;
						$previewMemberInfo['syasin4']=$syasin4;
						$previewMemberInfo['syasin5']=$syasin5;
					}
					$previewMemberInfo['syasin1']=$syasin1;
					$this->set('previewMemberInfo', $previewMemberInfo);
					$this->Session->write("Auth.User.News.previewMemberInfo",$previewMemberInfo);
				}
				// 会員種別名称の初期表示
				$this->set('selectedKaiinsbnm', '');
				// 業種名称の初期表示
				$this->set('selectedGyosyunm', '');
				// フリーワード値をセット
				$this->set('keywordVal', '');
				$this->set('radiovalue', '');
				// 戻るボタンを隠すためpreviewで値をセットする。
				$this->set('previewadmin', $dataof);
			}
			if(isset($this->request->data['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
		} else {
			// 要求が空白の場合、コントローラの動作をリダイレクトする。
			$this->redirect([ 
					'controller' => 'members',
					'action' => 'index' 
			]);
		}
	}	
	/**
	 *　画面名：会員企業
	 *　機能名：初期値設定
	 */
	private function setInitialValue() {	
		$optionVal = $this->MKaiinsb->find('first', array(
						'conditions' => array(
							'MKaiinsb.fromdt <=' =>$this->Common->getSystemDate(),
							'MKaiinsb.todt >=' =>$this->Common->getSystemDate()),
						'order'=>array('MKaiinsb.kaiinsbcd' => 'ASC')));
		$selectedKaiinsbnm = $optionVal['MKaiinsb']['kaiinsbcd'];
		//会員種別名称の初期表示
		$this->set('selectedKaiinsbnm', $selectedKaiinsbnm);
		// 業種名称の初期表示
		$this->set('scroll_val', '');
		$this->set('selectedGyosyunm', '');
		// フリーワード種別	 初期値：企業名
		$this->set('freewordTypeChk', $this->KIGYOMEI);
		// フリーワード値をセット
		$this->set('keywordVal', '');
	}
	/**
	 *　画面名：会員企業
	 *　機能名：会員情報の写真を取得
	 */
	public function getKaiinSyasin($id)	{
		$kaiinImage = $this->TKaiin->find('first', array('conditions' => array ('TKaiin.kaiincd ' => $id )));
		if (!empty($kaiinImage['TKaiin']['syasin'])) {
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			header('Content-length: ' . strlen($kaiinImage['TKaiin']['syasin']));
			echo $kaiinImage['TKaiin']['syasin'];
		} else {
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			readfile('app/webroot/img/members/no_image.jpg');
		}
	}
	/**
	 *　画面名：会員企業
	 *　機能名：写真情報の写真を取得
	 */
	public function getSyasin($syasinkey, $id) {
		$pictImage = $this->TSyasin->find('first', array('conditions' => array ('TSyasin.syasinkey ' => $syasinkey,'TSyasin.rno ' => $id,'TSyasin.bunrui ' => $this->Constants->KAISYA)));
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($pictImage['TSyasin']['syasin'])); 
		echo $pictImage['TSyasin']['syasin'];
	}
	/**
	 *　画面名：会員企業
	 *　機能名：会社情報の会社ロゴを取得
	 */
	public function getKaisyaklogo($id)	{
		$kaisyaImage = $this->TKaisya->find ('first', array('conditions' => array ('TKaisya.kaisyacd ' => $id)));
		if (!empty($kaisyaImage['TKaisya']['klogo'])) {
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			header('Content-length: ' . strlen($kaisyaImage['TKaisya']['klogo'])); 
			echo $kaisyaImage['TKaisya']['klogo'];
		} else {
			$this->autoRender = false;
			header('Content-Type: image/jpeg');
			readfile('app/webroot/img/members/no_image.jpg');
		}
	}
	/**
	 *　画面名：会員企業
	 *　機能名：会員企業一覧件数
	 */
	public function getKaisyaCount($conditions) {
		$countquery = $this->TKaisya->find('all', array(
									'joins' => array( array(
											'table' => $this->TKaiin,
											'alias' => 'tkn',
											'type' => 'INNER',
											'conditions' => array(
												'tkn.kaisyacd = TKaisya.kaisyacd'))),
									'conditions' => $conditions,
									'group' => array('tkn.kaisyacd')));
		return count($countquery);
	}
	/**
	 *　画面名：会員企業
	 *　機能名：会員の写真をピレビュー
	 */
	public function viewMemberSyasin($syasinName) {
		$previewMemberInfo = $this->Session->read('Auth.User.News.previewMemberInfo');
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($previewMemberInfo[$syasinName]));
		echo $previewMemberInfo[$syasinName];
	}
	/**
	 *　画面名：会員企業
	 *　機能名：PRイメージをピレビュー
	 */
	public function getSyasinImage($id, $syasinkey) {
		$pictImage = $this->TSyasin->find ( 'first', array (
				'conditions' => array (
						'TSyasin.rno ' => $id,
						'TSyasin.syasinkey ' => $syasinkey,
						'TSyasin.bunrui ' => $this->Constants->KAISYA
				)
		) );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
		echo $pictImage ['TSyasin'] ['syasin'];
	}
}