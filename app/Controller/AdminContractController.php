<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * ＰＲ情報一覧 Controller
 *
 * ＰＲ情報一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminContractController extends AppController {
	// helpers追加
	public $helpers = array (
			'Html',
			'Form',
			'Constants',
			'Common',
			'Session' 
	);
	// components追加
	public $components = array (
			'Flash',
			'RequestHandler',
			'auth',
			'Session',
			'Constants',
			'Common' 
	);
	// モデル名追加
	public $uses = array (
			'MKaiinsb',
			'MGyosyu',
			'MKeiyaku',
			'TKaisya',
			'TPrkeiyaku',
			'TPrkyrireki',
			'TPrsyohin',
			'TKaiin',
			'MTuuci'
	);
	// レイアウト無し
	public $autoLayout = false;
	// フリーワード検索種別
	public $searchTypeList = array(1 => "企業名", 2 => "会員名", 3 => "所在地");

	public $dispOrder = array(1 => "企業名", 2 => "会員名");

	/**
	 * 　画面名：ＰＲ情報一覧
	 * 　機能名：ＰＲ情報一覧
	 */
	public function index() {
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
		// 初期化のセット
		$this->setInitialValue();
		// 画面の移動
		$this->set('searchTypeList',$this->searchTypeList);
		$this->set('mkeiyaku',0);
		$this->set('display',$this->Constants->INITIAL);
		$this->set('mailarrmm','');
		$this->set('searchinfo','');
		$this->set('count','0');
		$this->render('/Admin/Contract/list');
	}
	/**
	 * setInitialDropdownValue ドロップダウン値のセット
	 */
	private function setInitialDropdownValue() {
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName($this->MKaiinsb));
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName ($this->MGyosyu));
		// 業種名称のセット
		$this->set('mkeiyakuList',$this->Common->getMKeiyaku ($this->MKeiyaku));

		$this->set('dispOrder',$this->dispOrder);
	}
	/**
	 * setInitialValue 初期表示値
	 *
	 * @param industry, member_type, radiovalue, keyWord 業種名、会員種別名、フリーワードのラジオボタン値、フリーワード値
	 */
	private function setInitialValue( $kaiinsbnm = NULL, $gyosyunm = NULL, $radiovalue = NULL, $mkeiyaku = NULL, $keyWord = NULL, $fromdate = NULL,$todate = NULL ,$selectedOrder = NULL) {
		if(!empty($kaiinsbnm)) {
			//会員種別名称のセット
			$this->set('selectedKaiinsbnm',$kaiinsbnm);
		} else {
			//会員種別名称の初期表示をセット
			$this->set('selectedKaiinsbnm','');
		}
		if(!empty($gyosyunm)) {
			//会員種別名称のセット
			$this->set('selectedGyosyunm',$gyosyunm);
		} else {
			//会員種別名称の初期表示をセット
			$this->set('selectedGyosyunm','');
		}
		if(!empty($radiovalue)) {
			// フリーワードのラジオボタン値のセット
			$this->set('freewordTypeChk',$radiovalue);
		} else {
			// フリーワードのラジオボタン初期化のセット
			$this->set('freewordTypeChk','1');
		}
		if(!empty($mkeiyaku)) {
			// フリーワードのラジオボタン値のセット
			$this->set('mkeiyakuChk1','checked');
			$this->set('mkeiyakuChk1','');
		} else {
			// フリーワードのラジオボタン初期化のセット
			$this->set('mkeiyakuChk1','checked');
			$this->set('mkeiyakuChk1','checked');
		}
		if(!empty($keyWord)) {
			/// フリーワード値をセット
			$this->set('keywordVal',$keyWord);
		} else {
			// フリーワード値をセット
			$this->set('keywordVal','');
		}

		if(!empty($fromdate)) {
			$this->set('fromdate',$fromdate);
		} else {
			$this->set('fromdate','');
		}
		if(!empty($todate)) {
			$this->set('todate',$todate);
		} else {
			$this->set('todate','');
		}
		// ソート順
		if(!empty($selectedOrder)) {
			$this->set('selectedOrder',$selectedOrder);
		} else {
			$this->set('selectedOrder','');
		}
	}

	public function search() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if (isset($this->request->data['ContractSearchForm'])) {
					$this->request->data = $this->request->data['ContractSearchForm'];
				}
				if(!isset($this->request->data['free_radio'])) {
					$free_radio ="";
				} else {
					$free_radio = $this->request->data['free_radio'];
				}
				$keyWord = $this->request->data['free_word'];
				$keyWord = trim($keyWord);
				$conditions = array();
				$order = array();
				$kaiinsbnm = $this->request->data['kaiinsbnm'];
				$gyosyunm = $this->request->data['gyosyunm'];
				$mkeiyaku = $this->request->data['mkeiyaku'];
				$fromdate = !empty($this->request->data['fromdate']) ? $this->request->data['fromdate'].'/01' : '';
				$todate = !empty($this->request->data['todate']) ? $this->request->data['todate'].'/01' : '';
				$Kaiinconditions = "";
				$SearchType = "LEFT";
				if(!empty($kaiinsbnm)){
					$Kaiinconditions = "t_kaiin.kaiinsbcd = '".$kaiinsbnm."' ";
					$SearchType = "RIGHT";
				}
				if(!empty($gyosyunm)){
					$conditions[] = array('TKaisya.gyosyucd' =>$gyosyunm);
				}
				if(!empty($keyWord)) {
					if($free_radio == "1") {
						$conditions[] = array('TKaisya.kaisyanm LIKE ' => "%$keyWord%");
					} else if($free_radio == "2") {
						if($Kaiinconditions != "") {
							$Kaiinconditions .= "AND t_kaiin.kaiinnm LIKE '%".$keyWord."%' ";
						} else {
							$Kaiinconditions .= "t_kaiin.kaiinnm LIKE '%".$keyWord."%' ";
						}
						$SearchType = "RIGHT";
					} else if($free_radio == "3") {
						$conditions[] = array('OR' => array(
										array('TKaisya.jyusyo1 LIKE ' => "%$keyWord%"),
										array('TKaisya.jyusyo2 LIKE ' => "%$keyWord%")));
					}
				}
				if($mkeiyaku == '9') {
					$conditions[] = array('OR' => array(
									array('tpr.g_keiyaku_to <' =>$this->Common->getSystemDate())));
				} else if($mkeiyaku != "") {
					$conditions[] = array('tpr.kykbn' => $mkeiyaku,
										'tpr.g_keiyaku_to >=' => $this->Common->getSystemDate());
				}
				if(!empty($fromdate) && !empty($todate) ) {
					$conditions[] = array('tpr.g_keiyaku_from >=' =>$fromdate,
										  'tpr.g_keiyaku_to <=' =>$todate);
				} else if(!empty($fromdate) && empty($todate) ) {
					$conditions[] = array('tpr.g_keiyaku_from >=' =>$fromdate);
				} else if(empty($fromdate) && !empty($todate) ) {
					$conditions[] = array('tpr.g_keiyaku_to <=' =>$todate);
				}
				if (!isset($this->request->data ['selectedOrder']) || isset($this->request->data['searchbtn'])) {
					$selectedOrder = "1";
				} else {
					$selectedOrder = $this->request->data ['selectedOrder'];
				}

				$order[] = array('keiyaku_sort' => 'ASC');	

				// 表示順序 
				if ($selectedOrder == "2") {
					$order[] = array('tkn.kaiinnmkana' => 'ASC',
									// 'tkn.kaiinnm' => 'ASC',
									'tpr.g_keiyaku_from' => 'ASC',
									'tpr.g_keiyaku_to' => 'ASC');
				} else {
					$order[] = array('TKaisya.kaisyanmkana' => 'ASC',
									// 'tkn.kaiinnm' => 'ASC',
									'tpr.g_keiyaku_from' => 'ASC',
									'tpr.g_keiyaku_to' => 'ASC');
				}

				if($Kaiinconditions != "") {
					$Kaiinconditions = "WHERE ".$Kaiinconditions;
				}
				$query = $this->TKaisya->find('all', array(
								'joins' => array(
									array(
											'table' => $this->TPrkeiyaku,
											'alias' => 'tpr',
											'type' => 'LEFT',
											'conditions' => array('tpr.kaisyacd = TKaisya.kaisyacd')),
									array(
											'table' => $this->MKeiyaku,
											'alias' => 'mkei',
											'type' => 'LEFT',
											'conditions' => array('mkei.keiyakucd = tpr.kykbn')),
									array(
											'table' => sprintf("(SELECT GROUP_CONCAT(kaiinnm ORDER BY kaiinsbcd ASC,kaiinnm ASC) as kaiinnmGC,t_kaiin.* FROM t_kaiin  %s  GROUP BY kaisyacd)", $Kaiinconditions),
											'alias' => 'tkn',
											'type' => $SearchType,
											'conditions' => array('tkn.kaisyacd = TKaisya.kaisyacd'))),
								'fields' => array('TKaisya.kaisyacd',
												'TKaisya.kaisyanm',
												'tkn.kaiincd',
												'tkn.kaiinnm',
												'tkn.kaiinnmGC',
												'mkei.keiyakunm',
												'mkei.keiyakurs',
												'tpr.arno',
												'tpr.kykbn',
												'tpr.ktukisuu',
												'tpr.g_keiyaku_from',
												'tpr.g_keiyaku_to',
												'tpr.g_keikin',
												'IF(tpr.g_keiyaku_from IS NULL,1,0) as keiyaku_sort'),
								'conditions' => $conditions,
								'order'=> $order ));
				$curentdate = $this->Common->getSystemDateTime ();
				foreach ($query as $key => $value) {
					if($value ['TKaisya']['kaisyacd']!="") {
						$prevaluesto = $this->TPrkeiyaku->find('first', array(
												'fields' => array('MAX(g_keiyaku_to) as g_keiyaku_to'),
												'conditions' => array('kaisyacd' => $value ['TKaisya']['kaisyacd'],
																	'g_keiyaku_to <' => $query[$key]['tpr']['g_keiyaku_from'],
												)));
						if(isset($prevaluesto[0]['g_keiyaku_to'])) {
							$query[$key]['TPrkeiyaku']['prevaluesto'] = $prevaluesto[0]['g_keiyaku_to'];
						} else {
							$query[$key]['TPrkeiyaku']['prevaluesto'] = "1970-01-01";
						}
						$nextvaluesfrom = $this->TPrkeiyaku->find('first', array(
												'fields' => array('MIN(g_keiyaku_from) as g_keiyaku_from'),
												'conditions' => array('kaisyacd' => $value ['TKaisya']['kaisyacd'],
																	'g_keiyaku_from >' => $query[$key]['tpr']['g_keiyaku_to'],
												)));
						if(isset($nextvaluesfrom[0]['g_keiyaku_from'])) {
							$query[$key]['TPrkeiyaku']['nextvaluesfrom'] = $nextvaluesfrom[0]['g_keiyaku_from'];
						} else {
							$query[$key]['TPrkeiyaku']['nextvaluesfrom'] = "9999-12-01";
						}
					}
				}
				$this->set('searchinfo',$query);
				$this->setInitialDropdownValue();
				$fromdate = $this->request->data['fromdate'];
				$todate = $this->request->data['todate'];
				$this->setInitialValue($kaiinsbnm,$gyosyunm,$free_radio,$mkeiyaku,$keyWord,$fromdate,$todate,$selectedOrder);
				$this->set('display',$this->Constants->SEARCH);
				$this->set('searchTypeList', $this->searchTypeList);
				$this->set('mkeiyaku',$mkeiyaku);
				$this->render('/Admin/Contract/list');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}

	public function rirekiList() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$order[] = array('TPrkyrireki.tourokudt' => 'ASC');	
		$gettprkyrireki = $this->TPrkyrireki->find('all', array(
											'joins' => array(
												array(
													'table' => $this->MKeiyaku,
													'alias' => 'MKeiyaku',
													'type' => 'LEFT',
													'conditions' => array('MKeiyaku.keiyakucd = TPrkyrireki.kykbn')),
												array(
													'table' => $this->TKaiin,
													'alias' => 'TKaiin',
													'type' => 'LEFT',
													'conditions' => array('TKaiin.kaiincd = TPrkyrireki.tourokucd'))),
											'fields' => array('MKeiyaku.keiyakunm',
															'TKaiin.kaiinnm',
															'TPrkyrireki.tourokudt',
															'TPrkyrireki.keiyaku_from',
															'TPrkyrireki.keiyaku_to',
															'TPrkyrireki.ktukisuu',
															'TPrkyrireki.keikin'),
											'conditions' => array( 'TPrkyrireki.kkey' => $this->request->data['Contractaddfrm']['arno']),
											'order'=> $order));
		$this->set('searchinfo',$gettprkyrireki);
		$this->set('kaisyanm',$this->request->data['Contractaddfrm']['kaisyanm']);

		$this->set('selectedGyosyunm',isset($this->request->data['Contractaddfrm']['gyosyunm']) ? $this->request->data['Contractaddfrm']['gyosyunm'] : '');
		$this->set('selectedKaiinsbnm',isset($this->request->data['Contractaddfrm']['kaiinsbnm']) ? $this->request->data['Contractaddfrm']['kaiinsbnm'] : '');
		$this->set('keywordVal',$this->request->data['Contractaddfrm']['free_word']);
		$this->set('freewordTypeChk',$this->request->data['Contractaddfrm']['free_radio']);
		$this->set('mkeiyaku',$this->request->data['Contractaddfrm']['mkeiyaku']);
		$this->set('fromdate',$this->request->data['Contractaddfrm']['fromdate']);
		$this->set('todate',$this->request->data['Contractaddfrm']['todate']);
		$this->render('/Admin/Contract/rirekiList');
	}
	public function delete() {
		try {
			$responseString = "0";
			$this->autoRender = false;
			$arno = $this->request->data['arno'];
			$kaisyacd = $this->request->data['kaisyacd'];
			$s_keiyaku_from = $this->request->data['s_keiyaku_from'];
			$s_keiyaku_to = $this->request->data['s_keiyaku_to'];
			$torokuDate = $this->Common->getSystemDateTime ();
			$conditions = array();
			$conditions[] = array('kaisyacd' =>$kaisyacd);
			$conditions[] = array('OR' => array(
												array('AND' => array(
													array('kikanfrom >=' => $s_keiyaku_from),
													array('kikanfrom <=' => $s_keiyaku_to))),
												array('AND' => array(
													array('kikanto >=' => $s_keiyaku_from),
													array('kikanto <=' => $s_keiyaku_to)))));
			// $conditions[] = array('AND' => array(
			// 							array('kikanfrom >=' => $s_keiyaku_from),
			// 							array('kikanfrom <=' => $s_keiyaku_to)));
			// $conditions[] = array('AND' => array(
			// 							array('kikanto >=' => $s_keiyaku_from),
			// 							array('kikanto <=' => $s_keiyaku_to)));
			$getTPrsyohin = $this->TPrsyohin->find('first', array(
									'fields' => array('kikanfrom','kikanto'),
									'conditions' => $conditions));
			if($getTPrsyohin) {
				// $kikanfrom = $getTPrsyohin['TPrsyohin']['kikanfrom'];
				// $kikanto = $getTPrsyohin['TPrsyohin']['kikanto'];

				// if(($s_keiyaku_from <= $kikanfrom) && ($kikanfrom <= $s_keiyaku_to)) {
				// 	echo "2";exit;
				// } else if(($s_keiyaku_from <= $kikanto) && ($kikanto <= $s_keiyaku_to)) {
					echo "2";exit;
				// } else {
				// 	$this->TPrkeiyaku->query(" DELETE FROM t_prkeiyaku WHERE arno = $arno");
				// 	$this->TPrkyrireki->query(" DELETE FROM t_prkyrireki WHERE kkey = $arno");
				// 	echo "1";exit();
				// }
			} else {
				$this->TPrkeiyaku->query(" DELETE FROM t_prkeiyaku WHERE arno = $arno");
				$this->TPrkyrireki->query(" DELETE FROM t_prkyrireki WHERE kkey = $arno");
				echo "1";exit();
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	public function add() {
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				$this->render('/Admin/Contract/add');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function register() {
		try {
			$db_TPrkeiyaku = $this->TPrkeiyaku->getDataSource();
			$db_TPrkeiyaku->begin();
			$db_TPrkyrireki = $this->TPrkyrireki->getDataSource();
			$db_TPrkyrireki->begin();
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			if (array_key_exists ( 'tantounm', $this->request->data )) {
				$this->textarea_maxlength("bikou",$this->request->data['bikou'],1024,$responseString);
				$this->request->data['s_keiyaku_from'] = str_replace('/', '-', $this->request->data['s_keiyaku_from'].'-01');
				$this->request->data['s_keiyaku_to'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['s_keiyaku_to'].'-01')));
				$this->TPrkeiyaku->set ( $this->request->data );
				$this->TPrkyrireki->set ( $this->request->data );
				// if ($this->TPrkeiyaku->validates()) {
					$torokuDate = $this->Common->getSystemDateTime ();
					$this->insertTPrkeiyaku ( $this->request->data, $torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki);
					$TPrkyrirekiKeyVal = $this->TPrkeiyaku->getLastInsertId();

					$this->insertTPrkyrireki ( $this->request->data, $torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki,$TPrkyrirekiKeyVal);

					if (! empty ( $this->request->data ['mailchk'] )) {
						// 事務局へメール送信
						$mailInfo = $this->Common->getMailInfo ( $this->MTuuci );
						if (! empty ( $mailInfo )) {
							$allmailaddrs = array();
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr1'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr2'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr2'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr3'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr3'];
							}
							// メール送信　（事務局宛）
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
								$subject_mail = '【確認・通知】　PR企業契約情報の登録';
								$msg_mail = $this->mailText ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ( $allmailaddrs );
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				// } else {
				// 	$errors = $this->TPrkeiyaku->validationErrors;
				// 	$errCount = count($errors);
				// 	$idx=0;
				// 	foreach($errors as $feild => $messages) {
				// 		$responseString .= $feild."##".$messages[0];
				// 		$idx++;
				// 		if($idx < $errCount) {
				// 			$responseString .= "$$";
				// 		}
				// 	}
				// 	echo $responseString;
				// }
			} else {
				$this->redirect ( [ 
						'controller' => 'AdminProductsite',
						'action' => 'index' 
				] );
			}
			$db_TPrkeiyaku->commit();
			$db_TPrkyrireki->commit();
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	private function insertTPrkeiyaku($request, $tourokudt,$db_TPrkeiyaku,$db_TPrkyrireki) {
		try {
			$columnValue = array (
					'kaisyacd' => $request ['kaisyacd'],
					's_keiyaku_from' => $request ['s_keiyaku_from'],
					's_keiyaku_to' => $request ['s_keiyaku_to'],
					's_keikin' => $request ['s_keikin'],
					'ktukisuu' => $request ['ktukisuu'],
					'tantounm' => $request ['tantounm'],
					'tantounmkana' => $request ['tantounmkana'],
					'telno' => $request ['telno'],
					'faxno' => $request ['faxno'],
					'mailaddr' => $request ['mailaddr'],
					'g_keiyaku_from' => $request ['s_keiyaku_from'],
					'g_keiyaku_to' => $request ['s_keiyaku_to'],
					'g_keikin' => $request ['s_keikin'],
					'kykbn' => $request ['kykbn'],
					// 'uketukedt' => $request ['uketukedt'],
					'utantounm' => $request ['utantounm'],
					// 'syounindt' => $request ['syounindt'],
					// 'tuuchidt' => $request ['tuuchidt'],
					// 'nyukindt' => $request ['nyukindt'],
					'bikou' => $request ['bikou'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if($request ['uketukedt'] != "") {
				$columnValue['uketukedt'] = $request ['uketukedt'];
			}
			if($request ['syounindt'] != "") {
				$columnValue['syounindt'] = $request ['syounindt'];
			}
			if($request ['tuuchidt'] != "") {
				$columnValue['tuuchidt'] = $request ['tuuchidt'];
			}
			if($request ['nyukindt'] != "") {
				$columnValue['nyukindt'] = $request ['nyukindt'];
			}
			/*print_r($columnValue);
			exit();*/
			// 有益情報作成
			$this->TPrkeiyaku->create ();
			// 有益情報に登録
			if (!$this->TPrkeiyaku->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	private function insertTPrkyrireki($request, $tourokudt,$db_TPrkeiyaku,$db_TPrkyrireki,$TPrkyrirekiKeyVal) {
		try {
			$columnValue = array (
					'kkey' => $TPrkyrirekiKeyVal,
					'kaisyacd' => $request ['kaisyacd'],
					'keiyaku_from' => $request ['s_keiyaku_from'],
					'keiyaku_to' => $request ['s_keiyaku_to'],
					'ktukisuu' => $request ['ktukisuu'],
					'keikin' => $request ['s_keikin'],
					'kykbn' => $request ['kykbn'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// 有益情報作成
			$this->TPrkyrireki->create ();
			// 有益情報に登録
			if (!$this->TPrkyrireki->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	private function splitothersFields ($data) {
        $dataArr = split("&", $data);
        $requestData = array();
        for($i=0; $i< count($dataArr);$i++) {
        	$fields  = split("=", $dataArr[$i]);
        	if (isset($fields[1])) {
        		$requestData[$fields[0]] = urldecode($fields[1]);
        	}
        }
		return $requestData;
	}
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$errors) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if(mb_strlen($dummy_str) > $maxlen) {
			$responseString[$fname][0] = "最大文字数を超えています。";
			if ($errors != "") {
				$responseString = array_merge($errors, $responseString);
			}
			return $responseString;
		} else {
			return $errors;
		}
	}
	private function mailText($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> PR企業契約情報の新規追加を行いました。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDate ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　社　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['kaisyanm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>担　当　者　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['tantounm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　区　分</td><td $braceWidth>】</td>
						<td $maxwidth>新規契約</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　期　間</td><td $braceWidth>】</td>
						<td $maxwidth>" . date('Y年m月d日',strtotime($request ['s_keiyaku_from']))." ～ " .date('Y年m月d日',strtotime($request ['s_keiyaku_to'])). "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　金　額</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->moneyFormatJapan($request ['s_keikin']) .'円'."</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	public function edit() {
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if(isset($this->request->data['Contracteditfrm']['arno'])) {
					$arno = $this->request->data['Contracteditfrm']['arno'];
				} else {
					$arno = $this->request->data['arno'];
				}

				$gettprkeiyaku = $this->TPrkeiyaku->find('first', array(
								'joins' => array(
									array(
											'table' => $this->MKeiyaku,
											'alias' => 'mkei',
											'type' => 'LEFT',
											'conditions' => array('mkei.keiyakucd = TPrkeiyaku.kykbn'))),
								'fields' => array('TPrkeiyaku.*',
												'mkei.keiyakunm'),
								'conditions' => array( 'TPrkeiyaku.arno' => $arno)));
				$gettprkeiyakueditto = $this->TPrkeiyaku->find('first', array(
										'fields' => array('MAX(g_keiyaku_to) as g_keiyaku_to'),
										'conditions' => array('kaisyacd' => $gettprkeiyaku['TPrkeiyaku']['kaisyacd'],
															'g_keiyaku_to <=' => $gettprkeiyaku['TPrkeiyaku']['g_keiyaku_from'],
										)));
				if(isset($gettprkeiyakueditto[0]['g_keiyaku_to'])) {
					$gettprkeiyaku['TPrkeiyaku']['g_keiyaku_to_edit'] = $gettprkeiyakueditto[0]['g_keiyaku_to'];
				} else {
					$gettprkeiyaku['TPrkeiyaku']['g_keiyaku_to_edit'] = "1970-01-01 00:00:00";
				}
				$this->set('gettprkeiyaku', $gettprkeiyaku);
				$this->render('/Admin/Contract/edit');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TPrkeiyaku = $this->TPrkeiyaku->getDataSource();
			$db_TPrkeiyaku->begin();
			$db_TPrkyrireki = $this->TPrkyrireki->getDataSource();
			$db_TPrkyrireki->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data['ContractUpdatefrm'] = $this->request->data;
				$torokuDate = $this->Common->getSystemDateTime ();
				$this->textarea_maxlength("bikou",$this->request->data['bikou'],1024,$responseString);
				$this->request->data['s_keiyaku_from'] = str_replace('/', '-', $this->request->data['s_keiyaku_from'].'-01');
				$this->request->data['s_keiyaku_to'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['s_keiyaku_to'].'-01')));
				if(isset($this->request->data['g_keiyaku_from'])) {
					$this->request->data['g_keiyaku_from'] = str_replace('/', '-', $this->request->data['g_keiyaku_from'].'-01');
					$this->request->data['g_keiyaku_to'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['g_keiyaku_to'].'-01')));
				} else {
					$this->request->data['g_keiyaku_from'] = $this->request->data['s_keiyaku_from'];
					$this->request->data['g_keiyaku_to'] = $this->request->data['s_keiyaku_to'];
					$this->request->data['g_keikin'] = $this->request->data['s_keikin'];
				}
				$nextmonthlastdate = date('Y-m-t', strtotime("+1 month", strtotime(date('Y-m-28', strtotime($this->request->data['g_keiyaku_to_hidden'].'-01')))));
				if($this->request->data['kykbn']=="1") {
					if($torokuDate > $this->request->data['s_keiyaku_to']) {
						$this->request->data['kykbn'] = 9;
						$this->request->data['keiyakunm'] = "契約終了";
					} else {
						$this->request->data['kykbn'] = $this->request->data['kykbn'];
					}
				} else if($torokuDate > $this->request->data['g_keiyaku_to']) {
					$this->request->data['kykbn'] = 9;
					$this->request->data['keiyakunm'] = "契約終了";
				} else {
					if($nextmonthlastdate < $this->request->data['g_keiyaku_from']) {
						$this->request->data['kykbn'] = 3;
						$this->request->data['keiyakunm'] = "再契約";
					} else {
						$this->request->data['kykbn'] = 2;
						$this->request->data['keiyakunm'] = "継続契約";
					}
					// if($this->request->data['kykbn']=="9") {
					// 	$this->request->data['kykbn'] = 3;
					// 	$this->request->data['keiyakunm'] = "再契約";
					// } else {
					// 	$this->request->data['kykbn'] = $this->request->data['kykbn'];
					// }
				}
				$this->TPrkeiyaku->set ( $this->request->data );
				// if ($this->TPrkeiyaku->validates()) {
					$this->updateTPrkeiyaku ( $this->request->data,$torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki);
					if($this->request->data['kykbn']!= "1") {
						$this->request->data['s_keiyaku_from'] = $this->request->data['g_keiyaku_from'];
						$this->request->data['s_keiyaku_to'] = $this->request->data['g_keiyaku_to'];
						$this->request->data['s_keikin'] = $this->request->data['g_keikin'];
					}
					$TPrkyrirekiKeyVal = $this->request->data['ContractUpdatefrm']['id'];
					$this->insertTPrkyrireki ( $this->request->data, $torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki,$TPrkyrirekiKeyVal);
					if (! empty ( $this->request->data ['mailchk'] )) {
						// 事務局へメール送信
						$mailInfo = $this->Common->getMailInfo ( $this->MTuuci );
						if (! empty ( $mailInfo )) {
							$allmailaddrs = array();
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr1'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr2'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr2'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr3'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr3'];
							}
							// メール送信　（事務局宛）
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
								$subject_mail = '【確認・通知】　PR企業契約情報の更新';
								$msg_mail = $this->mailTextUpdate ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ( $allmailaddrs );
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				// } else {
				// 	$errors = $this->TPrkeiyaku->validationErrors;
				// 	$errCount = count($errors);
				// 	$idx=0;
				// 	foreach($errors as $feild => $messages) {
				// 		$responseString .= $feild."##".$messages[0];
				// 		$idx++;
				// 		if($idx < $errCount) {
				// 			$responseString .= "$$";
				// 		}
				// 	}
				// 	echo $responseString;
				// }
			}
			$db_TPrkeiyaku->commit();
			$db_TPrkyrireki->commit();
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	private function updateTPrkeiyaku($request,$kousinDate,$db_TPrkeiyaku,$db_TPrkyrireki) {
		// 項目の値セット
		try {
			$columnValue = array (
					'arno' => $request['ContractUpdatefrm']['id'],
					'kaisyacd' => $request['kaisyacd'],
					's_keiyaku_from' => $request ['s_keiyaku_from'],
					's_keiyaku_to' => $request ['s_keiyaku_to'],
					's_keikin' => $request ['s_keikin'],
					'ktukisuu' => $request ['ktukisuu'],
					'tantounm' => $request ['tantounm'],
					'tantounmkana' => $request ['tantounmkana'],
					'telno' => $request ['telno'],
					'faxno' => $request ['faxno'],
					'mailaddr' => $request ['mailaddr'],
					'g_keiyaku_from' => $request ['g_keiyaku_from'],
					'g_keiyaku_to' => $request ['g_keiyaku_to'],
					'g_keikin' => $request ['g_keikin'],
					'kykbn' => $request ['kykbn'],
					// 'uketukedt' => $request ['uketukedt'],
					'utantounm' => $request ['utantounm'],
					// 'syounindt' => $request ['syounindt'],
					// 'tuuchidt' => $request ['tuuchidt'],
					// 'nyukindt' => $request ['nyukindt'],
					'bikou' => $request ['bikou'],
					'kousincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'kousindt' => $kousinDate 
			);
			if($request ['uketukedt'] != "") {
				$columnValue['uketukedt'] = $request ['uketukedt'];
			} else {
				$columnValue['uketukedt'] = "0000-00-00 00:00:00";
			}
			if($request ['syounindt'] != "") {
				$columnValue['syounindt'] = $request ['syounindt'];
			} else {
				$columnValue['syounindt'] = "0000-00-00 00:00:00";
			}
			if($request ['tuuchidt'] != "") {
				$columnValue['tuuchidt'] = $request ['tuuchidt'];
			} else {
				$columnValue['tuuchidt'] = "0000-00-00 00:00:00";
			}
			if($request ['nyukindt'] != "") {
				$columnValue['nyukindt'] = $request ['nyukindt'];
			} else {
				$columnValue['nyukindt'] = "0000-00-00 00:00:00";
			}
			// 有益情報に登録
			if (!$this->TPrkeiyaku->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	private function mailTextUpdate($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> PR企業契約情報の更新を行いました。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDate ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　社　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['kaisyanm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>担　当　者　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['tantounm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　区　分</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['keiyakunm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　期　間</td><td $braceWidth>】</td>
						<td $maxwidth>" . date('Y年m月d日',strtotime($request ['s_keiyaku_from']))." ～ " .date('Y年m月d日',strtotime($request ['s_keiyaku_to'])). "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　金　額</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->moneyFormatJapan($request ['s_keikin']) .'円'. "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	public function renewal() {
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if(isset($this->request->data['Contractrenewalfrm']['arno'])) {
					$arno = $this->request->data['Contractrenewalfrm']['arno'];
				} else {
					$arno = $this->request->data['arno'];
				}

				$gettprkeiyaku = $this->TPrkeiyaku->find('first', array(
								'joins' => array(
									array(
											'table' => $this->MKeiyaku,
											'alias' => 'mkei',
											'type' => 'LEFT',
											'conditions' => array('mkei.keiyakucd = TPrkeiyaku.kykbn'))),
								'fields' => array('TPrkeiyaku.*',
												'mkei.keiyakunm'),
								'conditions' => array( 'TPrkeiyaku.arno' => $arno)));
				$this->set('gettprkeiyaku', $gettprkeiyaku);
				$this->render('/Admin/Contract/renewal');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function renewalupdate() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TPrkeiyaku = $this->TPrkeiyaku->getDataSource();
			$db_TPrkeiyaku->begin();
			$db_TPrkyrireki = $this->TPrkyrireki->getDataSource();
			$db_TPrkyrireki->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data['ContractrenewalUpdatefrm'] = $this->request->data;
				$torokuDate = $this->Common->getSystemDateTime ();
				$this->textarea_maxlength("bikou",$this->request->data['bikou'],1024,$responseString);
				$this->request->data['s_keiyaku_from'] = str_replace('/', '-', $this->request->data['s_keiyaku_from'].'-01');
				$this->request->data['s_keiyaku_to'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['s_keiyaku_to'].'-01')));
				$this->request->data['g_keiyaku_from'] = str_replace('/', '-', $this->request->data['g_keiyaku_from'].'-01');
				$this->request->data['g_keiyaku_to'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['g_keiyaku_to'].'-01')));
				$this->request->data['g_keiyaku_from_hidden'] = str_replace('/', '-', $this->request->data['g_keiyaku_from_hidden'].'-01');
				$this->request->data['g_keiyaku_to_hidden'] = date("Y-m-t", strtotime(str_replace('/', '-', $this->request->data['g_keiyaku_to_hidden'].'-01')));
				$this->TPrkeiyaku->set ( $this->request->data );
				// if ($this->TPrkeiyaku->validates()) {
					$nextmonthlastdate = date('Y-m-t', strtotime("+1 month", strtotime(date('Y-m-28', strtotime($this->request->data['g_keiyaku_to_hidden'].'-01')))));
					if($nextmonthlastdate < $this->request->data['g_keiyaku_from']) {
						$this->request->data['kykbn'] = 3;
						$this->request->data['keiyakunm'] = "再契約";
					} else {
						$this->request->data['kykbn'] = 2;
						$this->request->data['keiyakunm'] = "継続契約";
					}
					$this->renewalinsertTPrkeiyaku ( $this->request->data,$torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki);
					$this->request->data['s_keiyaku_from'] = $this->request->data['g_keiyaku_from'];
					$this->request->data['s_keiyaku_to'] = $this->request->data['g_keiyaku_to'];
					$this->request->data['s_keikin'] = $this->request->data['g_keikin'];
					$TPrkyrirekiKeyVal = $this->TPrkeiyaku->getLastInsertId();
					$this->insertTPrkyrireki ( $this->request->data, $torokuDate,$db_TPrkeiyaku,$db_TPrkyrireki,$TPrkyrirekiKeyVal);
					if (! empty ( $this->request->data ['mailchk'] )) {
						// 事務局へメール送信
						$mailInfo = $this->Common->getMailInfo ( $this->MTuuci );
						if (! empty ( $mailInfo )) {
							$allmailaddrs = array();
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr1'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr2'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr2'];
							}
							if (!empty($mailInfo['0']['MTuuci']['mailaddr3'])) {
							    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr3'];
							}
							// メール送信　（事務局宛）
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
								$subject_mail = '【確認・通知】　PR企業契約情報の契約更新';
								$msg_mail = $this->mailTextrenewalUpdate ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ( $allmailaddrs );
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				// } else {
				// 	$errors = $this->TPrkeiyaku->validationErrors;
				// 	$errCount = count($errors);
				// 	$idx=0;
				// 	foreach($errors as $feild => $messages) {
				// 		$responseString .= $feild."##".$messages[0];
				// 		$idx++;
				// 		if($idx < $errCount) {
				// 			$responseString .= "$$";
				// 		}
				// 	}
				// 	echo $responseString;
				// }
			}
			$db_TPrkeiyaku->commit();
			$db_TPrkyrireki->commit();
		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	private function renewalinsertTPrkeiyaku($request,$tourokudt,$db_TPrkeiyaku,$db_TPrkyrireki) {
		// 項目の値セット
		try {
			$columnValue = array (
					'kaisyacd' => $request['kaisyacd'],
					's_keiyaku_from' => $request ['s_keiyaku_from'],
					's_keiyaku_to' => $request ['s_keiyaku_to'],
					's_keikin' => $request ['s_keikin'],
					'ktukisuu' => $request ['ktukisuu'],
					'tantounm' => $request ['tantounm'],
					'tantounmkana' => $request ['tantounmkana'],
					'telno' => $request ['telno'],
					'faxno' => $request ['faxno'],
					'mailaddr' => $request ['mailaddr'],
					'g_keiyaku_from' => $request ['g_keiyaku_from'],
					'g_keiyaku_to' => $request ['g_keiyaku_to'],
					'g_keikin' => $request ['g_keikin'],
					'kykbn' => $request ['kykbn'],
					// 'uketukedt' => $request ['uketukedt'],
					'utantounm' => $request ['utantounm'],
					// 'syounindt' => $request ['syounindt'],
					// 'tuuchidt' => $request ['tuuchidt'],
					// 'nyukindt' => $request ['nyukindt'],
					'bikou' => $request ['bikou'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if($request ['uketukedt'] != "") {
				$columnValue['uketukedt'] = $request ['uketukedt'];
			}
			if($request ['syounindt'] != "") {
				$columnValue['syounindt'] = $request ['syounindt'];
			}
			if($request ['tuuchidt'] != "") {
				$columnValue['tuuchidt'] = $request ['tuuchidt'];
			}
			if($request ['nyukindt'] != "") {
				$columnValue['nyukindt'] = $request ['nyukindt'];
			}
			$this->TPrkeiyaku->create ();
			// 有益情報に登録
			if (!$this->TPrkeiyaku->save($columnValue)) {
				throw new Exception();
			}

		} catch (Exception $e) {
			$db_TPrkeiyaku->rollback();
			$db_TPrkyrireki->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	private function mailTextrenewalUpdate($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> PR企業契約情報の契約更新を行いました。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDate ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　社　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['kaisyanm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>担　当　者　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['tantounm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　区　分</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['keiyakunm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　期　間</td><td $braceWidth>】</td>
						<td $maxwidth>" . date('Y年m月d日',strtotime($request ['g_keiyaku_from']))." ～ " .date('Y年m月d日',strtotime($request ['g_keiyaku_to'])). "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth> 契　約　金　額</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->moneyFormatJapan($request ['g_keikin']).'円'. "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	private function moneyFormatJapan($number) {
		$explrestunits = "" ;
		if(strlen($number)>3) {
		   $lastthree = substr($number, strlen($number)-3, strlen($number));
		   $restunits = substr($number, 0, strlen($number)-3); // extracts the last three digits
		   $restunits = (strlen($restunits)%3 == 1)?"00".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
		   $expunit = str_split($restunits, 3);
		   for($i=0; $i<sizeof($expunit); $i++) {
		       // creates each of the 2's group and adds a comma to the end
		       if($i==0) {
		           $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
		       } else {
		           $explrestunits .= $expunit[$i].",";
		       }
		   }
		   $thecash = $explrestunits.$lastthree;
		} else {
		   $thecash = $number;
		}
		return $thecash; // writes the final format where $currency is the currency symbol.
	}
}