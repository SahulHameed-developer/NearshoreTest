<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Common');
/**
 * 会員情報一覧 Controller
 *
 * 会員情報一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminMemberController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('TKaiin','TKaisya','MGyosyu','MKaiinsb','TSyasin', 'MKonin', 'TSyasin', 'MKyaku', 'MKoukai', 'MIyaku', 'MSosiki','MTodofuken', 'MSyumi','TKengen');
	// レイアウト無し
	public $autoLayout = false;
	// フリーワード検索種別
	public $searchTypeList = array(1 => "企業名", 2 => "会員名", 3 => "所在地");
	// 企業名
	public $KIGYOMEI = 1;
	// 会員名
	public $KAIINNAME = 2;
	// 所在地
	public $SHOZAICHI = 3;
	//表示順序
	public $dispOrder = array(1 => "会員コード", 2 => "企業名", 3 => "会員名");
	/**
	 *　画面名：会員情報一覧
	 *　機能名：会員情報一覧
	 */
	public function memberlist() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		if (! $this->Session->read ( 'errorMsg.errorflag' )) {
			$this->Session->delete ( 'errorMsg' );
		}
		$this->Session->write ( "errorMsg.errorflag", false );
		// ドロップダウン値のセット
		$this->setInitialDropdownValue();
		// 検索情報のセット
		$this->set('searchinfo', '');
		// 検索一覧セット
		$this->set('display',$this->Constants->INITIAL);
		// 初期化のセット
		$this->setInitialValue ();
		// 画面の移動
		$this->render('/Admin/Member/list');
	}
	/**
	 *　画面名：会員情報 新規追加
	 *　機能名：新規追加処理
	 */
	public function add() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TKaiin = $this->TKaiin->getDataSource();
			$db_TKaisya = $this->TKaisya->getDataSource();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TKaiin->begin();
			$db_TKaisya->begin();
			$db_TSyasin->begin();
			$responseString = "";
			// リクエストデータが空白の場合
			if (empty($this->request->data)) {
				if(!$this->Session->read('errorMsg.errorflag')){
					$this->Session->delete('errorMsg');
				}
				$this->Session->write("errorMsg.errorflag",false);
				// ドロップダウン値のセット
				$this->setInitialDropdownValue();
				// 表示画面のラジオボタン値のセット
				$this->setRadioValue ();
				// 表示画面のドロップダウン値のセット
				$this->setSelectValue();
				// 画面の移動
				$this->render('/Admin/Member/add');
				// リクエストデータが空白以外の場合
			} else {
				$requestData = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data = $requestData;
				$requestData['bikou'] = $requestData['kaiinbikou'];
				$this->TKaiin->set($requestData);
				$responseString = $this->textarea_maxlength("kaiinbikou",$requestData['bikou'],255,$responseString);
				$requestData['bikou'] = $requestData['kaisyabikou'];
				$this->TKaisya->set($requestData);
				$responseString = $this->textarea_maxlength("gyoumu",$requestData['gyoumu'],2048,$responseString);
				$responseString = $this->textarea_maxlength("pr",$requestData['pr'],2048,$responseString);
				$responseString = $this->textarea_maxlength("kaisyabikou",$requestData['bikou'],1024,$responseString);
				$responseString = substr($responseString, 2);
				if($this->TKaiin->validates() && $this->TKaisya->validates() && $responseString == "" ) {
					$tkainCount = $this->TKaiin->find ( 'count', array ('conditions' => array ('TKaiin.kaiincd' => $this->request->data['kaiincd'])));
					$tkaisyaCount = $this->TKaisya->find ( 'count', array ('conditions' => array ('TKaisya.kaisyacd' => $this->request->data['kaisyacd'])));
					if ($tkainCount == 0 && $tkaisyaCount == 0) {
						$syasinKeyVal = '';
						if (isset($requestData['ksyasintitle'])) {
							$requestData['title'] = $requestData['ksyasintitle'];
						}
						$requestData['tourokucd'] = $_SESSION['Auth']['User']['TKaiin']['kaiincd'];
						$requestData['tourokudt'] = $this->Common->getSystemDateTime();
						// ドロップダウン値のセット
						$this->setInitialDropdownValue();
						// 表示画面のラジオボタン値のセット
						$this->setRadioValue ();
						// 表示画面のドロップダウン値のセット
						$this->setSelectValue();
						if (count ( $_FILES ) > 0) {
							if (isset ( $_FILES ['kaisyalogo'] ['tmp_name'] )) {
								if (is_uploaded_file ( $_FILES ['kaisyalogo'] ['tmp_name'] )) {
									$requestData['klogo'] = fread ( fopen ( $_FILES ['kaisyalogo'] ['tmp_name'], "r" ), $_FILES ['kaisyalogo'] ['size'] );
								}
							}
							if (isset ( $_FILES ['kaiinsyasin'] ['tmp_name'] )) {
								if (is_uploaded_file ( $_FILES ['kaiinsyasin'] ['tmp_name'] )) {
									$requestData['syasin'] = fread ( fopen ( $_FILES ['kaiinsyasin'] ['tmp_name'], "r" ), $_FILES ['kaiinsyasin'] ['size'] );
								}
							}
							// 写真登録
							$rno = 0;
							if(isset($_FILES ['primage1'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['primage1'] ['tmp_name'] )) {
									$syasin1 = fread ( fopen ( $_FILES ['primage1'] ['tmp_name'], "r" ), $_FILES ['primage1'] ['size'] );
									$rno ++;
									$syasinblob1 = $syasin1;
									$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasintitle1'], $syasinblob1 );
									$syasinKeyVal = $this->TSyasin->getLastInsertId();
								}
							}
							if(isset($_FILES ['primage2'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['primage2'] ['tmp_name'] )) {
									$syasin2 = fread ( fopen ( $_FILES ['primage2'] ['tmp_name'], "r" ), $_FILES ['primage2'] ['size'] );
									$rno ++;
									$syasinblob2 = $syasin2;
									$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasintitle2'], $syasinblob2 );
									$syasinKeyVal = $this->TSyasin->getLastInsertId();
								}
							}
							if(isset($_FILES ['primage3'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['primage3'] ['tmp_name'] )) {
									$syasin3 = fread ( fopen ( $_FILES ['primage3'] ['tmp_name'], "r" ), $_FILES ['primage3'] ['size'] );
									$rno ++;
									$syasinblob3 = $syasin3;
									$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasintitle3'], $syasinblob3 );
									$syasinKeyVal = $this->TSyasin->getLastInsertId();
								}
							}
							if(!isset($_FILES ['primage1'] ['tmp_name']) && !isset($_FILES ['primage2'] ['tmp_name']) && !isset($_FILES ['primage3'] ['tmp_name'])) {
								$syasinKeyVal = "0";
							}
						} else {
							$syasinKeyVal = "0";
						}
						if(empty($requestData['jyugyoin'])) {
							$requestData['jyugyoin'] = 0;
						}
						// 会社情報登録
						$columnValue = array(
								'kaisyacd' => $requestData['kaisyacd'],
								'kaisyanm' => $requestData['kaisyanm'],
								'kaisyanmkana' => $requestData['kaisyanmkana'],
								'yubinno' => $requestData['yubinno'],
								'jyusyo1' => $requestData['jyusyo1'],
								'jyusyo2' => $requestData['jyusyo2'],
								'telno' => $requestData['telno'],
								'faxno' => $requestData['faxno'],
								'gyosyucd' => $requestData['gyosyucd'],
								'daihyoyknm' => $requestData['daihyoyknm'],
								'daihyonm' => $requestData['daihyonm'],
								'seturitu' => $requestData['seturitu'],
								'jyugyoin' => $requestData['jyugyoin'],
								'hpurl' => $requestData['hpurl'],
								'klogo' 	=> $requestData['klogo'],
								'gyoumu' => $requestData['gyoumu'],
								'pr' => $requestData['pr'],
								'syasin' => $syasinKeyVal,
								'prmailaddr1' 	=> $requestData['prmailaddr1'],
								'prmailaddr2' 	=> $requestData['prmailaddr2'],
								'prmailaddr3' 	=> $requestData['prmailaddr3'],
								'bikou' 	=> $requestData['kaisyabikou'],
								'uketorikbn' 	=> $requestData['uketorikbn'],
								'koukaikbn' => $requestData['koukaikbn'],
								'tourokucd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'],
								'tourokudt' => $this->Common->getSystemDateTime()
						);
						$this->TKaisya->create();
						if (!$this->TKaisya->save($columnValue)) {
							throw new Exception();
						}
						// 会員情報登録
						$requestData['bikou'] = $requestData['kaiinbikou'];
						$requestData['koukaikbn'] = $requestData['kaiinkoukaikbn'];
						$this->TKaiin->create();
						if (!$this->TKaiin->save($requestData)) {
							throw new Exception();
						}
						$responseString = "1";
						echo $responseString;
					}
					// 検証エラーが発生された場合
				} else {
					if($this->TKaiin->validationErrors){
						$errors = $this->TKaiin->validationErrors;
						$this->set('ValidateAjay',$errors);
						$errCount = count($errors);
						$idx=0;
						if($responseString != "") {
							$responseString .= "$$";
						}
						foreach($errors as $feild => $messages) {
							$responseString .= $feild."##".$messages[0];
							$idx++;
							if($idx < $errCount) {
								$responseString .= "$$";
							}
						}
						echo $responseString;
					} else {
						$errors = $this->TKaisya->validationErrors;
						$this->set('ValidateAjay',$errors);
						$errCount = count($errors);
						$idx=0;
						if($responseString != "") {
							$responseString .= "$$";
						}
						foreach($errors as $feild => $messages) {
							$responseString .= $feild."##".$messages[0];
							$idx++;
							if($idx < $errCount) {
								$responseString .= "$$";
							}
						}
						echo $responseString;
					}
				}
				$db_TKaiin->commit();
				$db_TKaisya->commit();
				$db_TSyasin->commit();
				exit();
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員情報検索
	 *　機能名：検索処理
	 */
	public function search() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			// リクエストデータが空白の場合
			if(empty($this->request->data)){
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if (! $this->Session->read ( 'errorMsg.errorflag' )) {
					$this->Session->delete ( 'errorMsg' );
				}
				$this->Session->write ( "errorMsg.errorflag", false );
				// ドロップダウン値のセット
				$this->setInitialDropdownValue();
				// 戻る画面の値セット
				if(!empty($this->request->data ['membersModoruFrm'])) {
					$radiovalue = $this->request->data ['membersModoruFrm']['free_radio'];
					$keyWord = $this->request->data ['membersModoruFrm']['free_word'];
					$industry = $this->request->data ['membersModoruFrm']['industry'];
					$member_type = $this->request->data ['membersModoruFrm']['members_type'];
					if (!isset($this->request->data ['membersModoruFrm']['selectedOrder'])) {
						$selectedOrder = "1";
					} else {
						$selectedOrder = $this->request->data ['membersModoruFrm']['selectedOrder'];
					}
				// 検索画面の値セット
				} else {
					$radiovalue = $this->request->data ['free_radio'];
					$keyWord = $this->request->data ['free_word'];
					$industry = $this->request->data ['industry'];
					$member_type = $this->request->data ['members_type'];
					if (!isset($this->request->data ['selectedOrder'])) {
						$selectedOrder = "1";
					} else {
						$selectedOrder = $this->request->data ['selectedOrder'];
					}
				}
				$keyWord = trim($keyWord);
				$conditions = array();
				$order = array();
				// 業種名称選択の場合
				if(! empty ($industry)){
					$gyosyucd= $industry;
					$conditions[] = array('TKaisya.gyosyucd' =>$gyosyucd);
				}
				// 会員種別名称選択の場合
				if(! empty ($member_type)){
					$kaiinsbcd= $member_type;
					$conditions[] = array('tkn.kaiinsbcd' =>$kaiinsbcd);
				}
				// フリーワードが会員名の場合
				if($radiovalue == $this->KAIINNAME){
					if(!empty($keyWord)){
						$conditions[] = array('tkn.kaiinnm LIKE ' => "%$keyWord%");
					}
					$this->set('freewordTypeChk', $this->KAIINNAME);
					// フリーワードが所在地の場合
				} else if($radiovalue ==$this->SHOZAICHI){
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
				if($selectedOrder == "3") {
					$order[] = array('kaiinnmkana_sort' => 'ASC',
									'tkn.kaiinnmkana' => 'ASC',
									'tkn.kaiinnm' => 'ASC');
				} else if ($selectedOrder == "2") {
					$order[] = array('kaisyanmkana_sort' => 'ASC',
									'TKaisya.kaisyanmkana' => 'ASC',
									'TKaisya.kaisyanm' => 'ASC');
				} else {
					$order[] = array('ABS(tkn.kaiincd)' => 'ASC');
				}
				// 会員情報と会社情報 テーブルから検索
				$conditions[] = array('tkn.kanrikbn <=' => $this->Session->read('Auth.User.TKaiin.kanrikbn'));
				$query = $this->TKaisya->find('all', array(
						'fields' => array('TKaisya.kaisyacd',		// 会社コード
								'TKaisya.kaisyanm',					// 会社名称
								'TKaisya.kaisyanmkana',				// 会社名称かな
								'IF(TKaisya.kaisyanmkana = "",1,0) as kaisyanmkana_sort',
								'TKaisya.syasin',
								'TKaisya.daihyoyknm',				// 代表者役職名称
								'TKaisya.daihyonm',					// 代表者名称
								'tkn.kaiincd',						// 会員コード
								'tkn.kaisyacd',						// 会社コード
								'tkn.kaiinnm',						// 会員名称
								'tkn.kaiinnmkana',					// 会員名称かな
								'IF(tkn.kaiinnmkana = "",1,0) as kaiinnmkana_sort',
								'tkn.koukaikbn ',					// 公開区分名称
								'mgs.gyosyucd',						// 業種コード
								'mgs.gyosyunm',						// 業種名称
								'mkn.kaiinsbcd',					// 会員種別コード
								'mkou.koukainm',
								'mkn.kaiinsbnm'),					// 会員種別名称
						'joins' => array( array(
								'table' => $this->TKaiin,
								'alias' => 'tkn',
								'type' => 'INNER',
								'conditions' => array('tkn.kaisyacd = TKaisya.kaisyacd')),
								array('table' => $this->MGyosyu,
									'alias' => 'mgs',
									'type' => 'LEFT',
									'conditions' => array(
										'mgs.gyosyucd = TKaisya.gyosyucd',
										'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) >= mgs.fromdt',
										'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) <=  mgs.todt')),
								array('table' => $this->MKoukai,
									'alias' => 'mkou',
									'type' => 'LEFT',
									'conditions' => array(
										'mkou.koukaicd = tkn.koukaikbn',
										'mkou.fromdt <= IF(TKaisya.kousindt ="0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt))',
										'mkou.todt >= IF(TKaisya.kousindt ="0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt))')),
								array('table' => $this->MKaiinsb,
									'alias' => 'mkn',
									'type' => 'LEFT',
									'conditions' => array(
										'mkn.kaiinsbcd = tkn.kaiinsbcd',
										'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) >= mkn.fromdt',
										'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) <=  mkn.todt'))),
						'conditions' => $conditions,
						'order'=> $order));
				// 初期化のセット
				$this->setInitialValue ($industry, $member_type, $radiovalue, $keyWord ,$selectedOrder);
				// 検索情報のセット
				$this->set('searchinfo',$query);
				// 検索一覧セット
				$this->set('display',$this->Constants->SEARCH);
				//　画面の移動
				$this->render('/Admin/Member/list');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：「会員情報」欄全体の表示
	 *　機能名：「会員情報」欄全体の表示の処理
	 */
	public function view() {
		if($this->referer() == '/') {
			$this->redirect ( [
				'controller' => 'Error',
				'action' => 'systemError' ] );
		}
		// 初期化のセット
		$this->setInitialValue (NUll, NUll, NUll, NUll, NULL);
		$kaiininfo = $this->TKaiin->find('first', array(
					'joins' => array(
							array('table' => $this->MKaiinsb,
								'alias' => 'mko',
								'type' => 'LEFT',
								'conditions' => array('mko.kaiinsbcd = TKaiin.kaiinsbcd'))),
					'fields' => array('TKaiin.*','mko.kaiinsbnm'),
					'conditions' => array('TKaiin.kaiincd' => $this->Session->read('Auth.User.TKaiin.kaiincd'))));
		if ($kaiininfo['TKaiin']['kkanjikbn'] == 1) {
			$this->set('clubsecretary', 'checked');
			$this->set('others', '');
		} else {
			$this->set('clubsecretary', '');
			$this->set('others', 'checked');
		}
		$this->set('kaiininfo', $kaiininfo);
		$kaisyainfo = $this->TKaisya->find('first', array('conditions' => array('TKaisya.kaisyacd' => $kaiininfo ['TKaiin']['kaisyacd'])));
		$this->set('kaisyainfo', $kaisyainfo);
		// 会員イメージと会社ロゴの配列
		$images = array (
				'kaiinimage' => '',
				'kaisyalogo' => ''
		);
		// 会員イメージのコードをセット
		if(!empty($kaiininfo['TKaiin']['syasin'])) {
			$images ['kaiinimage'] = $kaiininfo ['TKaiin'] ['kaiincd'];
		}
		// 会社ロゴのコードをセット
		if (!empty($kaisyainfo['TKaisya']['klogo'])) {
			$images ['kaisyalogo'] = $kaisyainfo ['TKaisya'] ['kaisyacd'];
		}
		// 会員イメージと会社ロゴのセット
		$this->set('images', $images);
		$syasinKey = $kaisyainfo ['TKaisya'] ['syasin'];
		// 会社写真のセット
		$this->setKaisyaSyasinDetails($syasinKey);
		// ドロップダウン値のセット
		$this->setInitialDropdownValue($this->Constants->UPDATE);
		// 表示画面のラジオボタン値のセット
		$this->setRadioValue ($kaiininfo['TKaiin']);
		// パスワード用
		$this->set('password', $kaiininfo['TKaiin']['lgpass']);
		$this->render('/Admin/Member/edit');
	}
	/**
	 *　画面名：会員情報編集
	 *　機能名：会員情報の編集処理
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if (empty($this->request->data)) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			} else {
				// 	編集画面の値セット
				if(!empty($this->request->data ['kaiineditfrm'])) {
					$radiovalue = $this->request->data ['kaiineditfrm']['free_radio'];
					$keyWord = $this->request->data ['kaiineditfrm']['free_word'];
					$industry = $this->request->data ['kaiineditfrm']['industry'];
					$member_type = $this->request->data ['kaiineditfrm']['members_type'];
					$kaiincd = $this->request->data ['kaiineditfrm']['kaiincd'];
					$kaisyacd = $this->request->data ['kaiineditfrm']['kaisyacd'];
					$selectedOrder = $this->request->data ['kaiineditfrm']['selectedOrder'];
				} else if(isset($this->request->data['period'])) {
					$radiovalue = "";
					$keyWord = "";
					$industry = "";
					$member_type = "";
					$kaiincd = $this->request->data ['kaiincd'];
					$kaisyacd = $this->request->data ['kaisyacd'];
					$kaiinsbnms = $this->request->data ['kaiinsbnm'];
					$sosiki = $this->request->data ['sosiki'];
					$openstate = $this->request->data ['openstate'];
					$enrollment = $this->request->data ['enrollment'];
					$registration = $this->request->data ['registration'];
					$period = $this->request->data ['period'];
					$fromdate = $this->request->data ['fromdate'];
					$todate = $this->request->data ['todate'];
					$selectedOrder = "";
					$this->set(compact('kaiinsbnms',
							'sosiki',
							'openstate',
							'enrollment',
							'registration',
							'period',
							'fromdate',
							'todate'));
				} else {
					$radiovalue = $this->request->data ['free_radio'];
					$keyWord = $this->request->data ['free_word'];
					$industry = $this->request->data ['industry'];
					$member_type = $this->request->data ['members_type'];
					$kaiincd = $this->request->data ['kaiincd'];
					$kaisyacd = $this->request->data ['kaisyacd'];
					$selectedOrder = "";
				}
				// 会員情報をセット
				if(!empty($kaiincd)){
					$kaiininfo = $this->TKaiin->find('first', array(
						'joins' => array(
							array('table' => $this->MKaiinsb,
								'alias' => 'mko',
								'type' => 'LEFT',
								'conditions' => array(
										'mko.kaiinsbcd = TKaiin.kaiinsbcd'))),
					'fields' => array('TKaiin.*','mko.kaiinsbnm'),
					'conditions' => array('TKaiin.kaiincd' => $kaiincd)));
					if ($kaiininfo['TKaiin']['kkanjikbn'] == 1) {
						$this->set('clubsecretary', 'checked');
						$this->set('others', '');
					} else {
						$this->set('clubsecretary', '');
						$this->set('others', 'checked');
					}
					$this->set('kaiininfo', $kaiininfo);
				} else {
					$this->set('kaiininfo','');
				}
				// 会社情報をセット
				if(!empty($kaisyacd)){
					$kaisyainfo = $this->TKaisya->find('first', array('conditions' => array('TKaisya.kaisyacd' => $kaisyacd)));
					$this->set('kaisyainfo', $kaisyainfo);
				} else {
					$this->set('kaisyainfo','');
				}
				// 会員イメージと会社ロゴの配列
				$images = array (
						'kaiinimage' => '',
						'kaisyalogo' => ''
				);
				// 会員イメージのコードをセット
				if(!empty($kaiininfo['TKaiin']['syasin'])) {
					$images ['kaiinimage'] = $kaiininfo ['TKaiin'] ['kaiincd'];
				}
				// 会社ロゴのコードをセット
				if (!empty($kaisyainfo['TKaisya']['klogo'])) {
					$images ['kaisyalogo'] = $kaisyainfo ['TKaisya'] ['kaisyacd'];
				}
				// 会員イメージと会社ロゴのセット
				$this->set('images', $images);
				$syasinKey = $kaisyainfo ['TKaisya'] ['syasin'];
				// 会社写真のセット
				$this->setKaisyaSyasinDetails($syasinKey);
				// ドロップダウン値のセット
				$this->setInitialDropdownValue($this->Constants->UPDATE);
				// 表示画面のラジオボタン値のセット
				$this->setRadioValue ($kaiininfo['TKaiin']);
				// パスワード用
				$this->set('password', $kaiininfo['TKaiin']['lgpass']);
				// 初期化のセット
				$this->setInitialValue ($industry, $member_type, $radiovalue, $keyWord ,$selectedOrder);
				//　画面の移動
				$this->render('/Admin/Member/edit');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員情報編集
	 *　機能名：会員情報の編集処理
	 */
	public function memberEdit(){
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TKaiin = $this->TKaiin->getDataSource();
			$db_TKaisya = $this->TKaisya->getDataSource();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TKaiin->begin();
			$db_TKaisya->begin();
			$db_TSyasin->begin();
			$responseString="";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$this->request->data ['editfrm'] = $this->request->data;
			// 会員情報の編集
			if(!empty($this->request->data ['editfrm'])) {
				$requestData = $this->request->data;
				$requestData['bikou'] = $requestData['kaiinbikou'];
				$this->TKaiin->set($requestData);
				$responseString = $this->textarea_maxlength("kaiinbikou",$requestData['bikou'],255,$responseString);
				$requestData['bikou'] = $requestData['kaisyabikou'];
				$this->TKaisya->set($requestData);
				$responseString = $this->textarea_maxlength("gyoumu",$requestData['gyoumu'],2048,$responseString);
				$responseString = $this->textarea_maxlength("pr",$requestData['pr'],2048,$responseString);
				$responseString = $this->textarea_maxlength("kaisyabikou",$requestData['bikou'],1024,$responseString);
				$responseString = substr($responseString, 2);
				if($this->TKaiin->validates() && $this->TKaisya->validates() && $responseString == "" ) {
					$requestData = $this->request->data;
					$requestData['bikou'] = $requestData['kaiinbikou'];
					$this->updateKaiin($requestData);
					$requestData['bikou'] = $requestData['kaisyabikou'];
					$this->updateKaisya($requestData);
					$responseString = "1";
					echo $responseString;
					// 検証エラーが発生された場合
				} else {
					if($this->TKaiin->validationErrors){
						$TKaiinErrors= $this->TKaiin->validationErrors;
						$errCount = count($TKaiinErrors);
						$idx=0;
						if($responseString != "") {
							$responseString .= "$$";
						}
						foreach($TKaiinErrors as $feild => $messages) {
							$responseString .= $feild."##".$messages[0];
							$idx++;
							if($idx < $errCount) {
								$responseString .= "$$";
							}
						}
						echo $responseString;
					} else {
						$TKaisyaErrors = $this->TKaisya->validationErrors;
						$errCount = count($TKaisyaErrors);
						$idx=0;
						if($responseString != "") {
							$responseString .= "$$";
						}
						foreach($TKaisyaErrors as $feild => $messages) {
							$responseString .= $feild."##".$messages[0];
							$idx++;
							if($idx < $errCount) {
								$responseString .= "$$";
							}
						}
						echo $responseString;
					}
				}
			}
			$db_TKaiin->commit();
			$db_TKaisya->commit();
			$db_TSyasin->commit();
			exit();
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員情報追加
	 *　機能名：会員情報の追加画面が表示処理
	 */
	public function add_2() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if (!empty($this->request->data)) {
				//　会員追加画面の値セット
				if(!empty($this->request->data['kaiinaddfrm'])) {
					$radiovalue = $this->request->data ['kaiinaddfrm']['free_radio'];
					$keyWord = $this->request->data ['kaiinaddfrm']['free_word'];
					$industry = $this->request->data ['kaiinaddfrm']['industry'];
					$member_type = $this->request->data ['kaiinaddfrm']['members_type'];
					$kaiincd = $this->request->data ['kaiinaddfrm']['kaiincd'];
					$kaisyacd = $this->request->data ['kaiinaddfrm']['kaisyacd'];
					$selectedOrder = $this->request->data ['kaiinaddfrm']['selectedOrder'];
				} else {
					$radiovalue = $this->request->data ['free_radio'];
					$keyWord = $this->request->data ['free_word'];
					$industry = $this->request->data ['industry'];
					$member_type = $this->request->data ['members_type'];
					$kaisyacd = $this->request->data ['kaisyacd'];
					$selectedOrder = "";
				}
				// ドロップダウン値のセット
				$this->setInitialDropdownValue($this->Constants->INSERT);
				// 業種名称を取得する
				$gyosyunm = $this->Common->getGyosyuName ($this->MGyosyu);
				//会社情報を取得する
				if(!empty($kaisyacd)){
					// 会社情報を取得する
					$kaisyainfo = $this->TKaisya->find('first', array(
							'joins' => array( array(
									'table' => $this->MGyosyu,
									'alias' => 'mgy',
									'type' => 'LEFT',
									'conditions' => array(
											'mgy.gyosyucd = TKaisya.gyosyucd',
											'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) >= mgy.fromdt',
											'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) <=  mgy.todt'))),
							'fields' => array('mgy.gyosyunm', 'TKaisya.*'),
							'conditions' => array('TKaisya.kaisyacd' => $kaisyacd),
					));
					$this->set('kaisyainfo', $kaisyainfo);
				} else {
					$this->set('kaisyainfo','');
				}
				// 会社写真のセット
				$syasinKey = $kaisyainfo ['TKaisya'] ['syasin'];
				$this->setKaisyaSyasinDetails($syasinKey);
				// 業種名称のセット
				$this->set('gyosyunm', $kaisyainfo['mgy']['gyosyunm']);
				$message = $this->Session->read('Message');
				if(!empty($message)) {
					$this->set('Message', $message);
				} else {
					$this->set('Message', '');
				}
				// 表示画面のラジオボタン値のセット
				$this->setRadioValue();
				// 表示画面のドロップダウン値のセット
				$this->setSelectValue();
				// 初期化のセット
				$this->setInitialValue ($industry, $member_type, $radiovalue, $keyWord ,$selectedOrder);
				// 画面の移動
				$this->render('/Admin/Member/add_2');
			} else {
				$this->redirect ( [
						'controller' => 'AdminMember',
						'action' => 'memberlist' ] );
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		} 
	}
	/**
	 *　画面名：会員情報 編集
	 *　機能名：会員情報 編集画面が表示処理
	 */
	public function edit_2() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if (!empty($this->request->data)) {
				//　会員追加画面の値セット
				$kaiincd = $this->request->data['kaiincd'];
				$kaisyacd = $this->request->data['kaisyacd'];
				$this->set('selectedOrder', $this->request->data ['selectedOrder']);
				// ドロップダウン値のセット
				$this->setInitialDropdownValue($this->Constants->INSERT);
				// 業種名称を取得する
				$gyosyunm = $this->Common->getGyosyuName ($this->MGyosyu);
				//会社情報を取得する
				if(!empty($kaisyacd)){
					// 会社情報を取得する
					$kaisyainfo = $this->TKaisya->find('first', array(
							'joins' => array( array(
									'table' => $this->MGyosyu,
									'alias' => 'mgy',
									'type' => 'LEFT',
									'conditions' => array(
											'mgy.gyosyucd = TKaisya.gyosyucd',
											'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) >= mgy.fromdt',
											'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, DATE(TKaisya.tourokudt), DATE(TKaisya.kousindt)) <=  mgy.todt'))),
							'fields' => array('mgy.gyosyunm', 'TKaisya.*'),
							'conditions' => array('TKaisya.kaisyacd' => $kaisyacd),
					));
					$this->set('kaisyainfo', $kaisyainfo);
				} else {
					$this->set('kaisyainfo','');
				}
				if(!empty($kaiincd)){
					$kaiininfo = $this->TKaiin->find('first', array(
						'joins' => array(
							array('table' => $this->MKaiinsb,
								'alias' => 'mko',
								'type' => 'LEFT',
								'conditions' => array('mko.kaiinsbcd = TKaiin.kaiinsbcd'))),
						'fields' => array('TKaiin.*','mko.kaiinsbnm'),
						'conditions' => array('TKaiin.kaiincd' => $kaiincd)));
					if ($kaiininfo['TKaiin']['kkanjikbn'] == 1) {
						$this->set('clubsecretary', 'checked');
						$this->set('others', '');
					} else {
						$this->set('clubsecretary', '');
						$this->set('others', 'checked');
					}
					$this->set('kaiininfo', $kaiininfo);
				} else {
					$this->set('kaiininfo','');
				}
				// 会社写真のセット
				$images = array (
						'kaiinimage' => '',
						'kaisyalogo' => ''
				);
				// 会員イメージのコードをセット
				if(!empty($kaiininfo['TKaiin']['syasin'])) {
					$images ['kaiinimage'] = $kaiininfo ['TKaiin'] ['kaiincd'];
				}
				// 会社ロゴのコードをセット
				if (!empty($kaisyainfo['TKaisya']['klogo'])) {
					$images ['kaisyalogo'] = $kaisyainfo ['TKaisya'] ['kaisyacd'];
				}
				$this->set('images', $images);
				$this->set('backinfo',$this->request->data);
				$syasinKey = $kaisyainfo ['TKaisya'] ['syasin'];
				$this->setKaisyaSyasinDetails($syasinKey);
				// 業種名称のセット
				$this->set('gyosyunm', $kaisyainfo['mgy']['gyosyunm']);
				$this->set('password', $kaiininfo['TKaiin']['lgpass']);
				$this->set('mailarrmm', $this->request->data['mailarrmm']);
				// 表示画面のラジオボタン値のセット
				$this->setRadioValue($kaiininfo['TKaiin']);
				// 表示画面のドロップダウン値のセット
				$this->setSelectValue();
				// 画面の移動
				$this->render('/Admin/Member/edit_2');
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
				'controller' => 'Error',
				'action' => 'ajaxRequestError' ] );
		} 
	}
	/**
	 *　画面名：会員情報編集
	 *　機能名：会員情報の編集処理
	 */
	public function memberEdit2(){
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TKaiin = $this->TKaiin->getDataSource();
			$db_TKaiin->begin();
			$responseString="";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$this->request->data ['editfrm'] = $this->request->data;
			// 会員情報の編集
			if(!empty($this->request->data ['editfrm'])) {
				$requestData = $this->request->data;
				$this->TKaiin->set($requestData);
				// 検証エラーが発生されない場合
				$responseString = $this->textarea_maxlength("bikou",$this->request->data['bikou'],255,$responseString);
				$responseString = substr($responseString, 2);
				if($this->TKaiin->validates() && $responseString == "") {
					$this->autoRender = false;
					$requestData = $this->request->data;
					$requestData ['editfrm']['password'] = $requestData['data[editfrm][password]'];
					$this->updateKaiin($requestData);
					$responseString="1";
					echo $responseString;
					// 検証エラーが発生された場合
				} else {
					$errors = $this->TKaiin->validationErrors;
					$errCount = count($errors);
					$idx=0;
					if($responseString != "") {
						$responseString .= "$$";
					}
					foreach($errors as $feild => $messages) {
						$responseString .= $feild."##".$messages[0];
						$idx++;
						if($idx < $errCount) {
							$responseString .= "$$";
						}
					}
					echo $responseString;
				}
			}
			$db_TKaiin->commit();
			exit();
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 *　画面名：会員情報追加
	 *　機能名：会員情報の追加処理
	 */
	public function memberAdd()	{
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TKaiin = $this->TKaiin->getDataSource();
			$db_TKaiin->begin();
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$this->request->data ['memberAddFrm'] = $this->request->data;
			if (empty($this->request->data)) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			} else {
				$requestData = $this->request->data;
				$this->TKaiin->set($requestData);
				// 検証エラーが発生されない場合
				$responseString = $this->textarea_maxlength("bikou",$this->request->data['bikou'],255,$responseString);
				$responseString = substr($responseString, 2);
				if($this->TKaiin->validates() && $responseString == "") {
					$kaisyacd = $this->request->data ['memberAddFrm']['kaisyacd'];
					$this->insertKaiin($requestData, $kaisyacd);
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TKaiin->validationErrors;
					$errCount = count($errors);
					$idx=0;
					if($responseString != "") {
						$responseString .= "$$";
					}
					foreach($errors as $feild => $messages) {
						$responseString .= $feild."##".$messages[0];
						$idx++;
						if($idx < $errCount) {
							$responseString .= "$$";
						}
					}
					echo $responseString;
				}
			}
			$db_TKaiin->commit();
			exit();
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * getKaiinSyasin　会員写真を取得
	 *
	 * @param id 会員コード
	 */
	public function getKaiinSyasin($id) {
		try {
			$kaiinImage=$this->TKaiin->find ( 'first', array('conditions' => array ('TKaiin.kaiincd ' => $id )));
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			header('Content-length: ' . strlen($kaiinImage['TKaiin']['syasin']));
			echo $kaiinImage['TKaiin']['syasin'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * getKaisyaklogo　会社ロゴを取得
	 *
	 * @param id 会社コード
	 */
	public function getKaisyaklogo($id) {
		try {
			$kaisyaImage = $this->TKaisya->find ('first', array('conditions' => array ('TKaisya.kaisyacd ' => $id )));
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			header('Content-length: ' . strlen($kaisyaImage['TKaisya']['klogo']));
			echo $kaisyaImage['TKaisya']['klogo'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * setInitialValue 初期表示値
	 *
	 * @param industry, member_type, radiovalue, keyWord 業種名、会員種別名、フリーワードのラジオボタン値、フリーワード値
	 */
	private function setInitialValue($industry = NULL, $member_type = NULL, $radiovalue = NULL, $keyWord = NULL ,$selectedOrder = NULL) {
		if(!empty($industry)) {
			//業種名称のセット
			$this->set('selectedGyosyunm',$industry);
		} else {
			//業種名称の初期表示をセット
			$this->set('selectedGyosyunm','');
		}
		if(!empty($member_type)) {
			//会員種別名称のセット
			$this->set('selectedKaiinsbnm',$member_type);
		} else {
			//会員種別名称の初期表示をセット
			$this->set('selectedKaiinsbnm','');
		}
		if(!empty($radiovalue)) {
			// フリーワードのラジオボタン値のセット
			$this->set('freewordTypeChk',$radiovalue);
		} else {
			// フリーワードのラジオボタン初期化のセット
			$this->set('freewordTypeChk',$this->KIGYOMEI);
		}
		if(!empty($keyWord)) {
			/// フリーワード値をセット
			$this->set('keywordVal',$keyWord);
		} else {
			// フリーワード値をセット
			$this->set('keywordVal','');
		}
		// フリーワード検索種別
		$this->set('searchTypeList', $this->searchTypeList);
		// 公開をセット
		$this->set('koukai', $this->Constants->KOKAI);
		// 非公開をセット
		$this->set('hikoukai', $this->Constants->HIKOKAI);
		if(!empty($selectedOrder)) {
			$this->set('selectedOrder',$selectedOrder);
		} else {
			$this->set('selectedOrder','');
		}
	}
	/**
	 * updateKaiin　会員の情報を編集
	 *
	 * @param requestData リクエストデータ
	 */
	private function updateKaiin($requestData) {
		// 編集する会員情報
		try {
			$Kaiindata = $this->setKaiinInfo($requestData, $this->Constants->UPDATE);
			$password = $requestData ['editfrm']['password'];
			$lgpass = $Kaiindata['lgpass'];
			// パスワードはmd5にセット
			if($password != $lgpass){
				$Kaiindata['lgpass'] =$requestData['lgpass'];
			} else {
				$Kaiindata['lgpass'] = $password;
			}
			// 編集されない会員コード
			$oldkaiincd = $requestData ['editfrm']['kaiincd'];
			// 編集される会員コード
			$newkaiincd = $Kaiindata['kaiincd'];
			if (empty($Kaiindata['seinendate'])) {
				$Kaiindata['seinendate'] = NULL;
			}
			if (empty($Kaiindata['nyukaidate'])) {
				$Kaiindata['nyukaidate'] = NULL;
			}
			if (empty($Kaiindata['kyukaidate'])) {
				$Kaiindata['kyukaidate'] = NULL;
			}
			if (empty($Kaiindata['taikaidate'])) {
				$Kaiindata['taikaidate'] = NULL;
			}
			// 会員情報をStringに変換する
			$db = $this->TKaiin->getDataSource();
			$data = $db->value($Kaiindata, 'string');
			// Stringに変換された情報を会員情報と結合する
			$updateData = array_combine(array_keys($Kaiindata), $data);

			// 会員情報が編集する
			$this->TKaiin->updateAll($updateData, array('kaiincd' => $oldkaiincd));
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * updateKaisya　会社の情報を編集
	 *
	 * @param requestData リクエストデータ
	 */
	private function updateKaisya($requestData) {
		// 編集する会社情報
		try {
			$requestData ['urlsyasinKey'] =  $this->setPrimaryImage($requestData, $this->Constants->UPDATE);
			$Kaisyadata = $this->setKaisyaInfo($requestData, $this->Constants->UPDATE);
			// 		$Kaisyadata['koukaikbn'] = $requestData['kaisyakoukaikbn'];
			// 編集されない会社コード
			$oldkaisyacd = $requestData ['editfrm']['kaisyacd'];
			// 編集される会社コード
			$newkaisyacd = $Kaisyadata['kaisyacd'];
			// 会社の写真を「写真テープル」に編集する
			// 従業員数
			if (empty($Kaisyadata['jyugyoin'])) {
				$Kaisyadata['jyugyoin'] = 0;
			}
			// 会社の情報をStringに変換する
			$db = $this->TKaisya->getDataSource();
			$data = $db->value($Kaisyadata, 'string');
			// Stringに変換された情報を会社の情報と結合する
			$updateData = array_combine(array_keys($Kaisyadata), $data);
			// 会社の情報が編集する
			$this->TKaisya->updateAll($updateData, array('TKaisya.kaisyacd' => $oldkaisyacd));
			if(isset($Kaisyadata['syasin'])  &&  $Kaisyadata['syasin'] != "") {
				$this->syashinkeydelete($Kaisyadata['syasin'],$Kaisyadata['kaisyacd']);
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * setSelectValue　表示画面のドロップダウン値のセット
	 *
	 * @param kaiinDetail, kaisyaDetail 会員情報、会社情報
	 */
	private function setSelectValue($kaiinDetail = NULL, $kaisyaDetail = NULL) {
		// 会員の情報がある場合
		if(!empty($kaiinDetail)) {
			// 会員種別名称のセット
			$this->set('kaiinsbcd', $kaiinDetail['kaiinsbcd']);
			// 組織コードのセット
			$this->set('sosikicd', $kaiinDetail['sosikicd']);
			// 協会役職名称のセット
			$this->set('kyoukaiykcd', $kaiinDetail['kyoukaiykcd']);
			// 委員会役職名称のセット
			$this->set('iinkaiykcd', $kaiinDetail['iinkaiykcd']);
			// 趣味コード１のセット
			$this->set('syumicd1', $kaiinDetail['syumicd1']);
			// 趣味コード２のセット
			$this->set('syumicd2', $kaiinDetail['syumicd2']);
			// 趣味コード３のセット
			$this->set('syumicd3', $kaiinDetail['syumicd3']);
			// 出身地 生まれのセット
			$this->set('umare', $kaiinDetail['umare']);
			// 出身地 育ちのセット
			$this->set('sodati', $kaiinDetail['sodati']);
			// 会員の情報がない場合
		} else {
			// 会員種別名称のセット
			$this->set('kaiinsbcd', '');
			// 協会役職名称のセット
			$this->set('kyoukaiykcd', '');
			// 組織コードのセット
			$this->set('sosikicd','');
			// 委員会役職名称のセット
			$this->set('iinkaiykcd', '');
			// 趣味コード１のセット
			$this->set('syumicd1', '');
			// 趣味コード２のセット
			$this->set('syumicd2', '');
			// 趣味コード３のセット
			$this->set('syumicd3', '');
			// 都道府県コードのセット
			$this->set('todofukencd', '');
			// 出身地 生まれのセット
			$this->set('umare', $kaiinDetail['umare']);
			// 出身地 育ちのセット
			$this->set('sodati', $kaiinDetail['sodati']);
		}
		// 会社の情報がある場合
		if(!empty($kaisyaDetail)) {
			// 設立年のセット
			$this->set('seturitu', $kaisyaDetail['seturitu']);
			// 業種コードのセット
			$this->set('gyosyucd', $kaisyaDetail['gyosyucd']);
			// 会社の情報がない場合
		} else {
			// 設立年のセット
			$this->set('seturitu', '');
			// 業種コードのセット
			$this->set('gyosyucd', '');
		}
	}
	/**
	 * setInitialDropdownValue ドロップダウン値のセット
	 */
	private function setInitialDropdownValue() {
		// 業種名称のセット
		$this->set('sosikinm',$this->Common->getShozokuiinkai ($this->MSosiki));
		// 協会役職名称のセット
		$this->set('kyoukaiyknm',$this->Common->getkyoukaiyakushokuName ($this->MKyaku));
		// 委員会役職名称のセット
		$this->set('iinkaiyknm',$this->Common->getiinkaiyakushokuName ($this->MIyaku));
		// 委員会役職名称のセット
		$this->set('todofukennm',$this->Common->getTodofukenName ($this->MTodofuken));
		// 委員会役職名称のセット
		$this->set('todofuken', $this->Common->getMTodofuken($this->MTodofuken));
		// 趣味名称のセット
		$this->set('syuminm',$this->Common->getSyumiName ($this->MSyumi));
		// 趣味名称のセット
		$this->set('msyumi', $this->Common->getMSyumi($this->MSyumi));
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName ($this->MGyosyu));
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName ($this->MKaiinsb));
		// 婚姻区分のセット
		$this->set('konin',$this->Common->getKoninName ($this->MKonin));
		// 公開区分のセット
		$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		$this->set('dispOrder',$this->dispOrder);
	}
	/**
	 * setRadioValue　表示画面のラジオボタン値のセット
	 *
	 * @param kaiindetail 会員情報
	 */
	private function setRadioValue ($kaiindetail = NULL, $kaisyadetail = NULL) {
		// 会員の情報がある場合
		if(!empty($kaiindetail) || !empty($kaisyadetail)) {
			// 性別のセット
			if ($kaiindetail['seicd'] == $this->Constants->SEIBETSU['male']['value']) {
				$this->set('danseiChk', 'checked');
				$this->set('joseiChk', '');
			} else {
				$this->set('danseiChk', '');
				$this->set('joseiChk', 'checked');
			}
			if ($kaiindetail['uketorikbn'] == "1") {
				$this->set('uketorikbnChk', 'checked');
				$this->set('uketorikbnUnChk', '');
			} else {
				$this->set('uketorikbnChk', '');
				$this->set('uketorikbnUnChk', 'checked');
			}
			// ラジオボタン初期化のセット
		} else {
			// 男性のセット
			$this->set('danseiChk', 'checked');
			// 女性のセット
			$this->set('joseiChk', '');
		}
		// 初期値のセット
		$this->set('inval', $this->Constants->INVAL);
		// 性別のセット
		$this->set('seibetu', $this->Constants->SEIBETSU);
		// 回答値のセット
		$this->set('kaito', $this->Constants->KAITO);
		// 男性値のセット
		$this->set('dansei', $this->Constants->SEIBETSU['male']['value']);
		// 女性値のセット
		$this->set('josei', $this->Constants->SEIBETSU['female']['value']);
	}
	/**
	 * insertKaiin　会員の情報をインサートする
	 *
	 * @param requestData, kaisyacd リクエストデータ、会社コード
	 */
	private function insertKaiin($requestData, $kaisyacd = NULL) {
		try {
			// インサートする会員情報のセット
			$kaiindata = $this->setKaiinInfo($requestData, $this->Constants->INSERT, $kaisyacd);
			// 会員重複の確認
			if($this->TKaiin->beforeSave($kaiindata)) {
				if (!$this->TKaiin->save($kaiindata)) {
					throw new Exception();
				}
			} else {
				// $this->Session->setFlash('登録データが重複しています。');
			}
			return $kaiindata;
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * insertKaisya　会社の情報をインサートする
	 *
	 * @param requestData リクエストデータ
	 */
	private function insertKaisya($requestData) {
		try {
			$requestData ['urlsyasinKey'] = $this->setPrimaryImage($requestData, $this->Constants->INSERT);
			// インサートする会社情報のセット
			$kaisyadata = $this->setKaisyaInfo($requestData, $this->Constants->INSERT);
			// 会社の写真をインサートする
			// 会社の情報をインサートする
			if (!$this->TKaisya->save($kaisyadata)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * setKaiinInfo　会員の情報をセット
	 *
	 * @param requestData, option, kaisyacd リクエストデータ、オプション、会社コード
	 */
	private function setKaiinInfo($requestData, $option = NULL, $kaisyacd = NULL) {
		try {
			if(!empty($requestData)) {
				// 会員の会社コードをセット
				if(empty($kaisyacd) || $kaisyacd == "" || $kaisyacd == NULL ) {
					$kaisyacd = $requestData['kaisyacd'];
				} else {
					$kaisyacd = $kaisyacd;
				}
				// 会員写真をセット
				$kaiinsyasin = "";
				if (count ( $_FILES ) > 0) {
					if (isset($_FILES ['kaiinsyasin'] ['tmp_name']) && $requestData['resetKaiin'] != "1") {
						if (is_uploaded_file ( $_FILES ['kaiinsyasin'] ['tmp_name'] )) {
							$kaiinsyasin = fread ( fopen ( $_FILES ['kaiinsyasin'] ['tmp_name'], "r" ), $_FILES ['kaiinsyasin'] ['size'] );
						}
					}
				} else {
					$konin="0";
				}
				// 会員の情報配列
				$data = array('kaiincd' => $requestData['kaiincd'],
						'kaiinsbcd' => $requestData['kaiinsbcd'],
						'kaiinnm' => $requestData['kaiinnm'],
						'kaiinnmkana' => $requestData['kaiinnmkana'],
						'kaisyacd' => $kaisyacd,
						'kaisyayknm' => $requestData['kaisyayknm'],
						'mailaddr' => $requestData['mailaddr'],
						'seinendate' => $requestData['seinendate'],
						'seicd' => $requestData['seicd'],
						'nyukaidate' => $requestData['nyukaidate'],
						'kyukaidate' => $requestData['kyukaidate'],
						'taikaidate' => $requestData['taikaidate'],
						'kyoukaiykcd' => $requestData['kyoukaiykcd'],
						'sosikicd' => $requestData['sosikicd'],
						'iinkaiykcd' => $requestData['iinkaiykcd'],
						'kkanjikbn' => $requestData['kkanjikbn'],
						'title' => $requestData['ksyasintitle'],
						'syokaisyanm' => $requestData['syokaisyanm'],
						'bikou' => $requestData['bikou'],
						'uketorikbn' => $requestData['uketorikbn'],
						'tbusyo1' => $requestData['tbusyo1'],
						'ttantounm1' => $requestData['ttantounm1'],
						'tmailaddr1' => $requestData['tmailaddr1'],
						'tbusyo2' => $requestData['tbusyo2'],
						'ttantounm2' => $requestData['ttantounm2'],
						'tmailaddr2' => $requestData['tmailaddr2'],
						'tbusyo3' => $requestData['tbusyo3'],
						'ttantounm3' => $requestData['ttantounm3'],
						'tmailaddr3' => $requestData['tmailaddr3'],
						'lgid' => $requestData['lgid'],
						'lgpass' => $requestData['lgpass'],
						// 					'kanrikbn' => $requestData['kanrikbn'],
						'jyubinno' => $requestData['jyubinno'],
						'jjyusyo1' => $requestData['jjyusyo1'],
						'jjyusyo2' => $requestData['jjyusyo2'],
						'jtelno' => $requestData['jtelno'],
						'kttelno' => $requestData['kttelno'],
						'ktmailaddr' => $requestData['ktmailaddr'],
						'umare' => $requestData['umare'],
						'sodati' => $requestData['sodati'],
						'konin' => $requestData['konin'],
						'syumicd1' => $requestData['syumicd1'],
						'syumitxt1' => $requestData['syumitxt1'],
						'syumicd2' => $requestData['syumicd2'],
						'syumitxt2' => $requestData['syumitxt2'],
						'syumicd3' => $requestData['syumicd3'],
						'syumitxt3' => $requestData['syumitxt3'],
						'sikousyoku' => $requestData['sikousyoku'],
						'sikounomi' => $requestData['sikounomi'],
						'koukaikbn' => $requestData['koukaikbn']
				);
				if(array_key_exists('kanrikbn', $requestData)) {
					$kanridata = array('kanrikbn' => $requestData['kanrikbn']);
				} else {
					$kanridata = array();
				}
				$dataKanri = array_merge($data, $kanridata);
				// 会員写真の配列
				if(!empty($kaiinsyasin) || $kaiinsyasin != NULL || $kaiinsyasin != ""){
					$syasin = array('syasin' => $kaiinsyasin);
				} else {
					$syasin = array();
				}
				if( $requestData['resetKaiin'] == "1") {
					$syasin = array('syasin' => $kaiinsyasin);
				}
				// 会員写真の配列を会員情報の配列と結合する
				$dataSyasin = array_merge($dataKanri, $syasin);
				// 登録日時、更新日時の配列
				if($option == $this->Constants->INSERT) {
					$datadt = array('tourokucd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'], 'tourokudt' => $this->Common->getSystemDateTime());
				} else {
					$datadt = array('kousincd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'], 'kousindt' => $this->Common->getSystemDateTime());
				}
				// 登録日時、更新日時の配列を会員情報の配列と結合する
				return array_merge($dataSyasin, $datadt);
			} else {
				return $data="";
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * setKaisyaInfo　会社の情報をセット
	 *
	 * @param requestData, option リクエストデータ、オプション
	 */
	private function setKaisyaInfo($requestData, $option = NULL) {
		try {
			if(!empty($requestData)) {
				// 更新の場合写真キーのセット
				if($option == $this->Constants->UPDATE) {
					$syasinKeyVal = $requestData ['urlsyasinKey'];
					// 登録の場合写真キーのセット
				} else {
					$syasinKeyVal = empty($requestData ['urlsyasinKey'])?"":$requestData ['urlsyasinKey'];
				}
				// 会社ロゴをセット
				$kaisyalogo = "";
				if (count ( $_FILES ) > 0) {
					if (isset($_FILES ['kaisyalogo'] ['tmp_name']) && $requestData['resetLogo'] != "1") {
						if (is_uploaded_file ( $_FILES ['kaisyalogo'] ['tmp_name'] )) {
							$kaisyalogo = fread ( fopen ( $_FILES ['kaisyalogo'] ['tmp_name'], "r" ), $_FILES ['kaisyalogo'] ['size'] );
						}
					}
				}
				// 会社の情報配列
				$data = array('kaisyacd' => $requestData['kaisyacd'],
						'kaisyanm' => $requestData['kaisyanm'],
						'kaisyanmkana' => $requestData['kaisyanmkana'],
						'yubinno' => $requestData['yubinno'],
						'jyusyo1' => $requestData['jyusyo1'],
						'jyusyo2' => $requestData['jyusyo2'],
						'telno' => $requestData['telno'],
						'faxno' => $requestData['faxno'],
						'gyosyucd' => $requestData['gyosyucd'],
						'daihyoyknm' => $requestData['daihyoyknm'],
						'daihyonm' => $requestData['daihyonm'],
						'seturitu' => $requestData['seturitu'],
						'jyugyoin' => $requestData['jyugyoin'],
						'hpurl' => $requestData['hpurl'],
						'gyoumu' => $requestData['gyoumu'],
						'pr' => $requestData['pr'],
						'syasin' => $syasinKeyVal,
						'prmailaddr1' => isset($requestData['prmailaddr1']) ? $requestData['prmailaddr1'] : '',
						'prmailaddr2' => isset($requestData['prmailaddr2']) ? $requestData['prmailaddr2'] : '',
						'prmailaddr3' => isset($requestData['prmailaddr3']) ? $requestData['prmailaddr3'] : '',
						'bikou' => $requestData['kaisyabikou'],
						'koukaikbn' => $requestData['kaisyakoukaikbn']
				);
				// 会社ロゴの配列
				if(!empty($kaisyalogo) || $kaisyalogo != NULL || $kaisyalogo != ""){
					$ｌogo = array('klogo' => $kaisyalogo);
				} else {
					$ｌogo = array();
				}
				if( $requestData['resetLogo'] == "1") {
					$ｌogo = array('klogo' => $kaisyalogo);
				}
				// 会社ロゴの配列を会社情報の配列と結合する
				$dataLogo = array_merge($data, $ｌogo);
				// 登録日時、更新日時の配列
				if($option == $this->Constants->INSERT) {
					$datadt = array('tourokucd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'], 'tourokudt' => $this->Common->getSystemDateTime());
				} else {
					$datadt = array('kousincd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'], 'kousindt' => $this->Common->getSystemDateTime());
				}
				// 登録日時、更新日時の配列を会社情報の配列と結合する
				return array_merge($dataLogo, $datadt);
			} else {
				return $data = "";
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * setPrimaryImage　会社の写真をセット
	 *
	 * @param requestData, option リクエストデータ、オプション
	 */
	private function setPrimaryImage($requestData, $option = NULL){
		try {
			// 更新の場合写真キーのセット
			if($option == $this->Constants->UPDATE) {
				$syasinKeyVal = $requestData ['urlsyasinKey'];
				// 登録の場合写真キーのセット
			} else {
				$syasinKeyVal = "";
			}
			// 連番をセット
			if(!empty($requestData ['urlprimage1']) || !empty($requestData ['urlprimage2']) || !empty($requestData ['urlprimage3'])) {
				$rnoPrimage1 = $requestData ['urlprimage1'];
				$rnoPrimage2 = $requestData ['urlprimage2'];
				$rnoPrimage3 = $requestData ['urlprimage3'];
			}
			// 写真タイトル1をセット
			if(array_key_exists('syasintitle1', $requestData)) {
				$title1 = $requestData ['syasintitle1'];
			} else {
				$title1 = $requestData ['urltitle1'];
			}
			// 写真タイトル2をセット
			if(array_key_exists('syasintitle2', $requestData)) {
				$title2 = $requestData ['syasintitle2'];
			} else {
				$title2 = $requestData ['urltitle2'];
			}
			// 写真タイトル3をセット
			if(array_key_exists('syasintitle3', $requestData)) {
				$title3 = $requestData ['syasintitle3'];
			} else {
				$title3 = $requestData ['urltitle3'];
			}
			$rno = 0;
			// prイメージ１がある場合
			$primage1 = '';
			if($this->request->data ['reset1'] == "1") {
				$this->deleteTSyasin ($syasinKeyVal,'1');
			}
			if (isset($_FILES ['primage1'] ['tmp_name']) && $this->request->data ['reset1'] != "1") {
				if(!empty($rnoPrimage1) || is_uploaded_file ( $_FILES ['primage1'] ['tmp_name'] )) {
					if (isset($_FILES ['primage1'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['primage1'] ['tmp_name'] )) {
							$primage1 = fread ( fopen ( $_FILES ['primage1'] ['tmp_name'], "r" ), $_FILES ['primage1'] ['size'] );
						}
					}
					// 登録の場合
					if ($option == $this->Constants->INSERT) {
						$rno ++;
						$this->insertTSyasin ( $syasinKeyVal, $rno, $title1, $primage1 );
						$syasinKeyVal = $this->TSyasin->getLastInsertId();
						// 更新の場合
					} else {
						// 更新の条件でイメージがない場合登録する
						if(empty($rnoPrimage1) && $primage1 != NULL) {
							//$maxrno = $this->getMaxRno($syasinKeyVal);
							$maxrno = "1";
							$checkexist = $this->checkexist($syasinKeyVal, $maxrno);
							if($checkexist) {
								$this->insertTSyasin ( $syasinKeyVal, $maxrno, $title1, $primage1 );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							} else {
								$this->updateTSyasin ( $syasinKeyVal, $maxrno, $title1, $primage1 );
							}
							// 更新の条件でイメージがある場合更新する
						} else {
							if(!empty($primage1)) {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage1, $title1, $primage1);
							} else {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage1, $title1);
							}
						}
					}
				}
			} else if(isset($requestData ['syasintitle1'])) {
				$this->updateTSyasin($syasinKeyVal, $rnoPrimage1, $requestData ['syasintitle1']);
			}
			//  prイメージ２がある場合
			$primage2 = '';
			if($this->request->data ['reset2'] == "1") {
				$this->deleteTSyasin ($syasinKeyVal,'2');
			} 
			if(isset ( $_FILES ['primage2'] ['tmp_name'] ) && $this->request->data ['reset2'] != "1") {
				if(!empty($rnoPrimage2) || is_uploaded_file ( $_FILES ['primage2'] ['tmp_name'] )) {
					if (is_uploaded_file ( $_FILES ['primage2'] ['tmp_name'] )) {
						$primage2 = fread ( fopen ( $_FILES ['primage2'] ['tmp_name'], "r" ), $_FILES ['primage2'] ['size'] );
					}
					// 登録の場合
					if ($option == $this->Constants->INSERT){
						$rno ++;
						$this->insertTSyasin ( $syasinKeyVal, $rno, $title2, $primage2 );
						$syasinKeyVal = $this->TSyasin->getLastInsertId();
						// 更新の場合
					} else {
						// 更新の条件でイメージがない場合登録する
						if(empty($rnoPrimage2) && $primage2 != NULL) {
							$maxrno = "2";
							$checkexist = $this->checkexist($syasinKeyVal, $maxrno);
							if($checkexist) {
								$this->insertTSyasin ( $syasinKeyVal, $maxrno, $title2, $primage2 );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							} else {
								$this->updateTSyasin ( $syasinKeyVal, $maxrno, $title2, $primage2 );
							}
							// 更新の条件でイメージがある場合更新する
						} else {
							if(!empty($primage2)) {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage2, $title2, $primage2);
							} else {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage2, $title2);
							}
						}
					}
				}
			} else if(isset($requestData ['syasintitle2'])) {
				$this->updateTSyasin($syasinKeyVal, $rnoPrimage2, $requestData ['syasintitle2']);
			}
			//  prイメージ２がある場合
			$primage3 = '';
			if($this->request->data ['reset3'] == "1") {
				$this->deleteTSyasin ($syasinKeyVal,'3');
			}
			if(isset( $_FILES ['primage3'] ['tmp_name'] ) && $this->request->data ['reset3'] != "1") {
				if(!empty($rnoPrimage3) || is_uploaded_file ( $_FILES ['primage3'] ['tmp_name'] )) {
					if (is_uploaded_file ( $_FILES ['primage3'] ['tmp_name'] )) {
						$primage3 = fread ( fopen ( $_FILES ['primage3'] ['tmp_name'], "r" ), $_FILES ['primage3'] ['size'] );
					}
					// 登録の場合
					if ($option == $this->Constants->INSERT){
						$rno ++;
						$this->insertTSyasin ( $syasinKeyVal, $rno, $title3, $primage3 );
						$syasinKeyVal = $this->TSyasin->getLastInsertId();
						// 更新の場合
					} else {
						// 更新の条件でイメージがない場合登録する
						if(empty($rnoPrimage3)  && $primage3 != NULL) {
							$maxrno = "3";
							$checkexist = $this->checkexist($syasinKeyVal, $maxrno);
							if($checkexist) {
								$this->insertTSyasin ( $syasinKeyVal, $maxrno, $title3, $primage3 );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							} else {
								$this->updateTSyasin ( $syasinKeyVal, $maxrno, $title3, $primage3 );
							}
							// 更新の条件でイメージがある場合更新する
						} else {
							if(!empty($primage3)) {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage3, $title3, $primage3);
							} else {
								$this->updateTSyasin($syasinKeyVal, $rnoPrimage3, $title3);
							}
						}
					}
				}
			} else if(isset($requestData ['syasintitle3'])) {
				$this->updateTSyasin($syasinKeyVal, $rnoPrimage3, $requestData ['syasintitle3']);
			}
			return $syasinKeyVal;
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function insertTSyasin($syasinKey, $rno, $title, $syasin) {
		try {
			// 項目の値セット
			$columnValue = array(
					'rno' 		=> $rno,
					'bunrui' 	=> $this->Constants->KAISYA,
					'title' 	=> $title,
					'syasin' 	=> $syasin,
					'kousincd' 	=> $_SESSION['Auth']['User']['TKaiin']['kaiincd'],
					'kousindt' 	=> $this->Common->getSystemDateTime(),
					'tourokucd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'],
					'tourokudt' => $this->Common->getSystemDateTime()
			);
			if(!empty($syasinKey)) {
				$columnValue['syasinkey'] = $syasinKey;
			}
			// 写真情報作成
			$this->TSyasin->create();
			// 写真情報に登録
			if (!$this->TSyasin->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員編集
	 *　機能名：写真情報の写真を取得
	 */
	public function getSyasin($id,$syasinkey) {
		try {
			$pictImage = $this->TSyasin->find('first', array('conditions' => array ('TSyasin.rno ' => $id,'TSyasin.syasinkey ' => $syasinkey)));
			$this->autoRender = false;
			header('Content-type: image/jpeg' );
			header('Content-length: ' . strlen($pictImage['TSyasin']['syasin']));
			echo $pictImage['TSyasin']['syasin'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * setKaisyaSyasinDetails　会社の写真をセット
	 *
	 * @param syasinKey　写真キー
	 */
	private function setKaisyaSyasinDetails($syasinKey) {
		try {
			$syasinshousai = $this->TSyasin->find ( 'all', array (
					'conditions' => array (
							'syasinkey' => $syasinKey
					)
			) );
			$syasinData = array (
					'primage1' => '',
					'primage2' => '',
					'primage3' => '',
					'title1' => '',
					'title2' => '',
					'title3' => ''
			);
			foreach ( $syasinshousai as $syasinVal ) {
				if ($syasinVal ['TSyasin'] ['rno'] == 1) {
					$syasinData ['primage1'] = $syasinVal ['TSyasin'] ['rno'];
					$syasinData ['title1'] = $syasinVal ['TSyasin'] ['title'];
				}
				if ($syasinVal ['TSyasin'] ['rno'] == 2) {
					$syasinData ['primage2'] = $syasinVal ['TSyasin'] ['rno'];
					$syasinData ['title2'] = $syasinVal ['TSyasin'] ['title'];
				}
				if ($syasinVal ['TSyasin'] ['rno'] == 3) {
					$syasinData ['primage3'] = $syasinVal ['TSyasin'] ['rno'];
					$syasinData ['title3'] = $syasinVal ['TSyasin'] ['title'];
				}
			}
			$this->set ( [
					'syasinData' => $syasinData,
					'syasinKey' => $syasinKey,
					'syasinshousai' => $syasinshousai
			] );
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function updateTSyasin($syasinkey, $rno, $title, $syasin = NULL) {
		try {
			// 項目の値セット
			$db = $this->TSyasin->getDataSource();
			$columnValue = array(
					'title' 	=> $db->value($title),
					'kousincd' 	=> $db->value($_SESSION['Auth']['User']['TKaiin']['kaiincd']),
					'kousindt' 	=> $db->value($this->Common->getSystemDateTime())
			);
			if($syasin != NULL) {
				$syasinArray = array('syasin' 	=> $db->value($syasin));
			} else {
				$syasinArray = array();
			}
			$data = array_merge($columnValue, $syasinArray);
			$conditions = array(
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno
			);
			// 写真情報に登録
			$this->TSyasin->updateAll($data, $conditions);
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：お知らせ情報
	 * 　機能名：お知らせ情報更新
	 */
	private function getMaxRno($syasinKey) {
		try {
			$maxrno = $this->TSyasin->find ( 'first', array (
					'fields' => array (
							'MAX(TSyasin.rno)+1 As rno'
					),
					'conditions'=>array (
							'TSyasin.syasinkey ' => $syasinKey)
			));
			if (empty ( $maxrno ['0'] ['rno'] )) {
				$rno = 1;
			} else {
				$rno = $maxrno ['0'] ['rno'];
			}
			return $rno;
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：会員削除
	 *　機能名：会員の削除処理
	 */
	public function delete() {
		try {
			$responseString = "0";
			$this->autoRender = false;
			$kaiincd = $this->request->data['kaiincd'];
			$kaisyacd = $this->request->data['kaisyacd'];
			$syasinkey = $this->request->data['syasinkey'];
			// 同一会社の会員数
			$count = $this->TKaiin->find('count', array('conditions' => array ('TKaiin.kaisyacd ' => $kaisyacd)));
			// 同一会社の会員がいない場合
			if($count == 1) {
				// 会社情報の削除
				$this->TKaisya->delete ( $kaisyacd );
				if(!empty($syasinkey) && $syasinkey != null && $syasinkey != 0 ) {
					$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey ");
				}
			}
			// 会員情報の削除
			$this->TKaiin->delete ( $kaiincd );
			$this->TKengen->query(" DELETE FROM t_kengen WHERE kaiincd = $kaiincd ");
			//$url = array('controller' => 'AdminMember', 'action' => 'search');
			// 検索画面に戻る
			//return $this->requestAction($url, array('data' => $this->request->data['kaiindeletefrm']));
			$responseString = "1";
			echo $responseString;
			exit();
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員削除
	 *　機能名：写真の削除処理
	 */
	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TKaiin->rollback();
			$db_TKaisya->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員更新
	 *　機能名：写真キーの存在チェック処理
	 */
	private function checkexist ($syasinkey,$rno) {
		$data = $this->TSyasin->find ( 'first', array (
				'fields' => array('TSyasin.syasinkey'),
				'conditions' => array(
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno)
		));
		if(!isset($data['TSyasin']['syasinkey'])) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 *　機能名：分割処理
	 */
	private function splitothersFields ($data) {
        $dataArr = split("&", $data);
        $requestData = array();
        for($i=0; $i< count($dataArr);$i++) {
        	$fields  = split("=", $dataArr[$i]);
        	if(isset($fields[1])) {
				if($fields[0] == "lgpass") {
					$requestData[$fields[0]] = $fields[1];
				} else {
					$requestData[$fields[0]] = urldecode($fields[1]);
				}
			}
        }
		return $requestData;
	}
	/**
	 *　画面名：会員更新
	 *　機能名：会員コードの存在チェック処理
	 */
	public function checkkaincd() {
		$checkkaincd = $this->TKaiin->find('first', array(
							'fields' => array('TKaiin.kaiincd'),
							'conditions' =>array( 'TKaiin.kaiincd' => $this->request->data['kaincd'] ) ));
		echo json_encode($checkkaincd);exit();
	}
	/**
	 *　画面名：会員更新
	 *　機能名：会社コードの存在チェック処理
	 */
	public function checkkaisyacd() {
		$checkkaisyacd = $this->TKaisya->find('first', array(
							'fields' => array('TKaisya.kaisyacd'),
							'conditions' =>array( 'TKaisya.kaisyacd' => $this->request->data['kaisyacd'] ) ));
		echo json_encode($checkkaisyacd);exit();
	}
	/**
	 *　画面名：会員更新
	 *　機能名：ロギングコードの存在チェック処理
	 */
	public function checklogid() {
		$checkkaincd = $this->TKaiin->find('first', array(
							'fields' => array('TKaiin.lgid'),
							'conditions' =>array( 'TKaiin.lgid' => $this->request->data['lgid'] ) ));
		echo json_encode($checkkaincd);exit();
	}
	/**
	 *　機能名：検証チェック処理
	 */
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$responseString) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if(mb_strlen($dummy_str) > $maxlen) {
			$responseString .= "$$".$fname."##最大文字数を超えています。";
			return $responseString;
		} else {
			return $responseString;
		}
	}
	/**
	 *　機能名：写真キー削除処理
	 */
	private function syashinkeydelete($syasinkey,$kaisyacd) {
		$syashincntchk = $this->TSyasin->find ( 'all', array (
						'fields' => array('TSyasin.syasinkey'),
						'conditions' => array ('TSyasin.syasinkey ' => $syasinkey )));
		if(count($syashincntchk) == 0) {
			$columnValue = array ('syasin' => 0);
			$conditions = array ('kaisyacd' => $kaisyacd);
			$this->TKaisya->updateAll ( $columnValue, $conditions );
		}
	}
	/**
	 *　機能名：最大番号取得処理
	 */
	private function maxno($table,$field,$varname) {
		$maxKey = $this->$table->find ( 'first', array (
					'fields' => array ('MAX('.$field.')+1 As '.$varname ) 
					) );
		return $maxKey;
	}
	public function checkmailid() {
		if($this->request->data['editflg'] == '1' ) {
			$conditions = array();
			$conditions[] = array('TKaiin.kaiincd <>' => $this->request->data['kaiincd'],
								'TKaiin.mailaddr' => $this->request->data['mailaddr']);
		} else {
			$conditions = array();
			$conditions[] = array('TKaiin.mailaddr' => $this->request->data['mailaddr']);
		}
		$checkmailid = $this->TKaiin->find('first', array(
							'fields' => array('TKaiin.mailaddr'),
							'conditions' => $conditions));
		echo json_encode($checkmailid);exit();
	}
	public function checkmailidPR() {
		$conditions = array();
		if($this->request->data['editflg'] == '1' ) {
			$conditions[] = array('TKaisya.kaisyacd <>' => $this->request->data['kaisyacd']);
		}
		$conditions[] = array('OR' => array(
							array('TKaisya.prmailaddr1 ' => $this->request->data['mailaddr']),
							array('TKaisya.prmailaddr2 ' => $this->request->data['mailaddr']),
							array('TKaisya.prmailaddr3 ' => $this->request->data['mailaddr'])));
		$checkmailid = $this->TKaisya->find('first', array(
							'fields' => array('TKaisya.kaisyacd'),
							'conditions' => $conditions));
		echo json_encode($checkmailid);exit();
	}
}