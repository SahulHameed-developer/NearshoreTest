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
class AdminProductsiteController extends AppController {
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
			'TKaisya',
			'TPrsyohin',
			'TPrtantou',
			'MKoukai',
			'TSyasin',
			'TKaiin',
			'MTuuci',
			'TPrkeiyaku'
	);
	// レイアウト無し
	public $autoLayout = false;
	// フリーワード検索種別
	public $searchTypeList = array(1 => "企業名", 2 => "会員名", 3 => "所在地", 4 => "商品名");

	public $dispOrder = array(1 => "企業名", 2 => "会員名", 3 => "商品名", 4 => "公開期間_From", 5 => "公開期間_To");
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
		$this->set('display',$this->Constants->INITIAL);
		$this->set('mailarrmm','');
		$this->set('searchinfo','');
		$this->set('count','0');
		$this->render('/Admin/Product/list');
	}
	/**
	 * setInitialDropdownValue ドロップダウン値のセット
	 */
	private function setInitialDropdownValue() {
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName($this->MKaiinsb));
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName ($this->MGyosyu));

		$this->set('dispOrder',$this->dispOrder);
	}
	/**
	 * setInitialValue 初期表示値
	 *
	 * @param industry, member_type, radiovalue, keyWord 業種名、会員種別名、フリーワードのラジオボタン値、フリーワード値
	 */
	private function setInitialValue( $kaiinsbnm = NULL, $gyosyunm = NULL, $radiovalue = NULL, $keyWord = NULL, $openstate = NULL, $registrationstate = NULL,$fromdate = NULL,$todate = NULL ,$selectedOrder = NULL,$Kikanjoutai = NULL) {
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
		if(!empty($keyWord)) {
			/// フリーワード値をセット
			$this->set('keywordVal',$keyWord);
		} else {
			// フリーワード値をセット
			$this->set('keywordVal','');
		}
		if($openstate == '0') {
			$this->set('openstateChk1','');
			$this->set('openstateChk2','checked');
			$this->set('openstateChk3','');
		} else if($openstate == '1') {
			$this->set('openstateChk1','');
			$this->set('openstateChk2','');
			$this->set('openstateChk3','checked');
		} else {
			$this->set('openstateChk1','checked');
			$this->set('openstateChk2','');
			$this->set('openstateChk3','');
		}
		if($registrationstate == '0') {
			$this->set('registrationstateChk1','');
			$this->set('registrationstateChk2','checked');
			$this->set('registrationstateChk3','');
		} else if($registrationstate == '1') {
			$this->set('registrationstateChk1','');
			$this->set('registrationstateChk2','');
			$this->set('registrationstateChk3','checked');
		} else {
			$this->set('registrationstateChk1','checked');
			$this->set('registrationstateChk2','');
			$this->set('registrationstateChk3','');
		}
		if($Kikanjoutai == '0') {
			$this->set('KikanjoutaiChk1','');
			$this->set('KikanjoutaiChk2','checked');
			$this->set('KikanjoutaiChk3','');
		} else if($Kikanjoutai == '1') {
			$this->set('KikanjoutaiChk1','');
			$this->set('KikanjoutaiChk2','');
			$this->set('KikanjoutaiChk3','checked');
		} else {
			$this->set('KikanjoutaiChk1','checked');
			$this->set('KikanjoutaiChk2','');
			$this->set('KikanjoutaiChk3','');
		}
		$this->set('openstate',$openstate);
		$this->set('registrationstate',$registrationstate);
		$this->set('Kikanjoutai',$Kikanjoutai);

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
				$openstate = $this->request->data['openstate'];
				$registrationstate = $this->request->data['registrationstate'];
				$Kikanjoutai = $this->request->data['Kikanjoutai'];
				$fromdate = $this->request->data['fromdate'];
				$todate = $this->request->data['todate'];

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
					} else if($free_radio == "4") {
						$conditions[] = array('tpr.syohinnm LIKE ' => "%$keyWord%");
					}
				}

				if($openstate == '0' || $openstate == '1') {
					$conditions[] = array('tpr.koukaikbn' =>$openstate);
				}
				if($registrationstate == '0') {
					$conditions[] = array('tpr.arno !=' => NULL);
				}
				if($registrationstate == '1') {
					$conditions[] = array('tpr.arno ' => NULL);
				}
				if($Kikanjoutai == '0') {
					$conditions[] = array('tpr.kikanfrom <=' =>$this->Common->getSystemDate(),
										'tpr.kikanto >=' =>$this->Common->getSystemDate());
				}
				if($Kikanjoutai == '1') {
					$conditions[] = array('OR' => array(
								array('tpr.kikanfrom >=' =>$this->Common->getSystemDate()),
								array('tpr.kikanto <=' =>$this->Common->getSystemDate())));
				}
				if(!empty($fromdate) && !empty($todate) ) {
					$conditions[] = array('tpr.kikanfrom >=' =>$fromdate,
										  'tpr.kikanto <=' =>$todate);
				} else if(!empty($fromdate) && empty($todate) ) {
					$conditions[] = array('tpr.kikanfrom >=' =>$fromdate);
				} else if(empty($fromdate) && !empty($todate) ) {
					$conditions[] = array('tpr.kikanto <=' =>$todate);
				}
				if (!isset($this->request->data ['selectedOrder']) || isset($this->request->data['searchbtn'])) {
					$selectedOrder = "1";
				} else {
					$selectedOrder = $this->request->data ['selectedOrder'];
				}

				$order[] = array('syohinnm_sort' => 'ASC',
								't_prke.arno  IS NULL' => 'ASC',
								'kaisyanmkana_sort' => 'ASC',
								'kaiinnmGC_sort' => 'ASC');	

				// 表示順序 
				if($selectedOrder == "5") {
					$order[] = array('tpr.kikanto' => 'DESC',
									'tpr.kikanfrom' => 'ASC',
									'TKaisya.kaisyanmkana' => 'ASC');
				} else if($selectedOrder == "4") {
					$order[] = array('tpr.kikanfrom' => 'ASC',
									'tpr.kikanto' => 'ASC',
									'TKaisya.kaisyanmkana' => 'ASC');
				} else if($selectedOrder == "3") {
					$order[] = array('tpr.syohinnm' => 'ASC',
									'tpr.kikanfrom' => 'ASC',
									'tpr.kikanto' => 'ASC');
				} else if ($selectedOrder == "2") {
					$order[] = array('tkn.kaiinnmkana' => 'ASC',
									//'tkn.kaiinnmGC' => 'ASC',
									'tpr.kikanfrom' => 'ASC',
									'tpr.kikanto' => 'ASC');
				} else {
					$order[] = array('TKaisya.kaisyanmkana' => 'ASC',
									'tpr.kikanfrom' => 'ASC',
									'tpr.kikanto' => 'ASC');
				}

				if($Kaiinconditions != "") {
					$Kaiinconditions = "WHERE ".$Kaiinconditions;
				}

				$query = $this->TKaisya->find('all', array(
								'joins' => array(
									array(
											'table' => $this->TPrsyohin,
											'alias' => 'tpr',
											'type' => 'LEFT',
											'conditions' => array('tpr.kaisyacd = TKaisya.kaisyacd')),
									array(
											'table' => $this->TPrtantou,
											'alias' => 'TPrtantou',
											'type' => 'LEFT',
											'conditions' => array('TPrtantou.arno = tpr.tantou')),
									array(
											'table' => $this->MKoukai,
											'alias' => 'mkou',
											'type' => 'LEFT',
											'conditions' => array('mkou.koukaicd = tpr.koukaikbn')),
									array(
											'table' => sprintf("(SELECT kaisyacd,arno FROM t_prkeiyaku GROUP BY kaisyacd)"),
											'alias' => 't_prke',
											'type' => 'LEFT',
											'conditions' => array('t_prke.kaisyacd = TKaisya.kaisyacd')
									),
									array(
											'table' => sprintf("(SELECT GROUP_CONCAT(kaiinnm ORDER BY kaiinsbcd ASC,kaiinnm ASC) as kaiinnmGC,t_kaiin.* FROM t_kaiin  %s  GROUP BY kaisyacd)", $Kaiinconditions),
											'alias' => 'tkn',
											'type' => $SearchType,
											'conditions' => array('tkn.kaisyacd = TKaisya.kaisyacd'))),
								'fields' => array('TKaisya.kaisyacd',
												'TKaisya.kaisyanm',
												'TKaisya.syasin',
												'tpr.syohinnm',
												'tpr.arno',
												'tpr.koukaikbn',
												'tpr.hyojino',
												'tpr.kikanfrom',
												'tpr.kikanto',
												'mkou.koukainm',
												'tkn.kaiincd',
												'tkn.kaiinnm',
												'tkn.kaiinnmGC',
												'TPrtantou.tantounm',
												'IF(tpr.syohinnm IS NULL,1,0) as syohinnm_sort',
												'IF(tkn.kaiinnmGC IS NULL,1,0) as kaiinnmGC_sort',
												'IF(TKaisya.kaisyanmkana = "",1,0) as kaisyanmkana_sort'),
								'conditions' => $conditions,
								'order'=> $order ));
				$curentdate = $this->Common->getSystemDateTime ();
				foreach ($query as $key => $value) {
					if($value ['TKaisya']['kaisyacd']!="") {
						$gettprkeiyaku = $this->TPrkeiyaku->find('first', array(
												'fields' => array('MIN(g_keiyaku_from) as g_keiyaku_from','MAX(g_keiyaku_to) as g_keiyaku_to'),
												'conditions' => array('kaisyacd' => $value ['TKaisya']['kaisyacd'],
																	'g_keiyaku_to >=' => $curentdate,
												)));
						if(isset($gettprkeiyaku[0]['g_keiyaku_from'])) {
							$query[$key]['TPrkeiyaku']['foradd'] = "1";
							$query[$key]['TPrkeiyaku']['g_keiyaku_from'] = $gettprkeiyaku[0]['g_keiyaku_from'];
							$query[$key]['TPrkeiyaku']['g_keiyaku_to'] = $gettprkeiyaku[0]['g_keiyaku_to'];
						} else {
							$query[$key]['TPrkeiyaku']['foradd'] = "0";
						}
						$gettprkeiyakueditfrom = $this->TPrkeiyaku->find('first', array(
												'fields' => array('MAX(g_keiyaku_from) as g_keiyaku_from'),
												'conditions' => array('kaisyacd' => $value ['TKaisya']['kaisyacd'],
																	'g_keiyaku_from <=' => $query[$key]['tpr']['kikanfrom'],
												)));
						if(isset($gettprkeiyakueditfrom[0]['g_keiyaku_from'])) {
							$query[$key]['TPrkeiyaku']['g_keiyaku_from_edit'] = $gettprkeiyakueditfrom[0]['g_keiyaku_from'];
						}
						$gettprkeiyakueditto = $this->TPrkeiyaku->find('first', array(
												'fields' => array('MAX(g_keiyaku_to) as g_keiyaku_to'),
												'conditions' => array('kaisyacd' => $value ['TKaisya']['kaisyacd'],
												)));
						if(isset($gettprkeiyakueditto[0]['g_keiyaku_to'])) {
							$query[$key]['TPrkeiyaku']['g_keiyaku_to_edit'] = $gettprkeiyakueditto[0]['g_keiyaku_to'];
						}
					}
				}
				$this->set('searchinfo',$query);
				$this->setInitialDropdownValue();
				$this->setInitialValue($kaiinsbnm,$gyosyunm,$free_radio,$keyWord,$openstate,$registrationstate,$fromdate,$todate,$selectedOrder,$Kikanjoutai);
				$this->set('display',$this->Constants->SEARCH);
				$this->set('searchTypeList', $this->searchTypeList);
				$this->render('/Admin/Product/list');
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
	 *　画面名：会員削除
	 *　機能名：会員の削除処理
	 */
	public function delete() {
		try {
			$responseString = "0";
			$this->autoRender = false;
			$arno = $this->request->data['arno'];
			$this->TPrsyohin->query(" DELETE FROM t_prsyohin WHERE arno = $arno");
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

	public function add() {
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				$this->set('prtantou',$this->Common->getTPrtantouName($this->TPrtantou,$this->request->data['Productaddfrm']['kaisyacd']));
				// 公開区分のセット
				$this->set('kokai',$this->Common->getKokaiName($this->MKoukai));
				// 初期値のセット
				$this->set('kokaiVal', $this->Constants->INVAL);

				// $gettprkeiyaku = $this->TPrkeiyaku->find('first', array(
				// 							'fields' => array('MIN(g_keiyaku_from) as g_keiyaku_from','MAX(g_keiyaku_to) as g_keiyaku_to'),
				// 							'conditions' => array('kaisyacd' => $this->request->data['Productaddfrm']['kaisyacd'])));
				// $this->set('gettprkeiyaku', $gettprkeiyaku);
				$this->render('/Admin/Product/add');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function edit() {
		try {
			if(empty($this->request->data) || empty($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if(isset($this->request->data['Producteditfrm']['arno'])) {
					$arno = $this->request->data['Producteditfrm']['arno'];
				} else {
					$arno = $this->request->data['arno'];
				}
				$this->set('prtantou',$this->Common->getTPrtantouName($this->TPrtantou,$this->request->data['Producteditfrm']['kaisyacd']));
				// 公開区分のセット
				$this->set('kokai',$this->Common->getKokaiName($this->MKoukai));
				// 初期値のセット
				$this->set('kokaiVal', $this->Constants->INVAL);

				$gettprsyohin = $this->TPrsyohin->find('first', array(
								'joins' => array(
									array(
											'table' => $this->TPrtantou,
											'alias' => 'tpt',
											'type' => 'LEFT',
											'conditions' => array('tpt.arno = TPrsyohin.tantou')),
									array(
											'table' => $this->TSyasin,
											'alias' => 'tsy',
											'type' => 'LEFT',
											'conditions' => array('tsy.syasinkey = TPrsyohin.syasinkey'))),
								'fields' => array('TPrsyohin.*',
												'tpt.*',
												'tsy.rno',
												'tsy.title',
												'tsy.syasinkey'),
								'conditions' => array( 'TPrsyohin.arno' => $arno)));
				$this->set('gettprsyohin', $gettprsyohin);
				// $gettprkeiyaku = $this->TPrkeiyaku->find('first', array(
				// 							'fields' => array('MIN(g_keiyaku_from) as g_keiyaku_from','MAX(g_keiyaku_to) as g_keiyaku_to'),
				// 							'conditions' => array('kaisyacd' => $this->request->data['Producteditfrm']['kaisyacd'])));
				// $this->set('gettprkeiyaku', $gettprkeiyaku);

				$this->render('/Admin/Product/edit');
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}

	public function gettantoudata() {
		$gettantoudata = $this->TPrtantou->find('first', array(
							'fields' => array('TPrtantou.busyo',
											'TPrtantou.tantounm',
											'TPrtantou.tantoumsg'),
							'conditions' => array('TPrtantou.arno' => $this->request->data['arno']),
							'order' => array('TPrtantou.arno' => 'ASC')));
		echo json_encode($gettantoudata);exit();
	}
	
	public function deletetantoudata() {
		$deletetantoudata = $this->TPrsyohin->find('first', array(
							'fields' => array('TPrsyohin.arno'),
							'conditions' =>array( 'TPrsyohin.tantou' => $this->request->data['arno'] ) ));
		if(!empty($deletetantoudata)) {
			$responseString = "0";
			echo json_encode($responseString);exit();

		} else {
			$arno = $this->request->data['arno'];
			$this->TPrtantou->query(" DELETE FROM t_prtantou WHERE arno = $arno");
			$prtantou =$this->Common->getTPrtantouName($this->TPrtantou,$this->request->data['kaisyacd']);
			echo json_encode($prtantou);exit();

		}
	}
	/**
	 * 　画面名：有益新規追加
	 * 　機能名：有益の新規登録処理
	 */
	public function register() {
		try {
			$db_TPrsyohin = $this->TPrsyohin->getDataSource();
			$db_TPrsyohin->begin();
			$db_TPrtantou = $this->TPrtantou->getDataSource();
			$db_TPrtantou->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			if (array_key_exists ( 'syohinnm', $this->request->data )) {
				$syasinKeyVal = 0;
				$this->textarea_maxlength("syohinnm",$this->request->data['syohinnm'],1024,$responseString);
				$this->textarea_maxlength("syousai",$this->request->data['syousai'],1024,$responseString);
				$this->request->data['kikanfrom'] = str_replace('/', '-', $this->request->data['kikanfrom']);
				$this->request->data['kikanto'] = str_replace('/', '-', $this->request->data['kikanto']);
				$this->TPrsyohin->set ( $this->request->data );
				$this->TPrtantou->set ( $this->request->data );
				if ($this->TPrsyohin->validates()) {
					$torokuDate = $this->Common->getSystemDateTime ();
					if (count ( $_FILES ) > 0) {
						// 写真
						$rno = 0;
						if(isset($_FILES ['syasin1'] ['tmp_name'])) {
							if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
								$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size'] );
								$rno ++;
								$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin1Title'], $syasin1, $torokuDate );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							}
						}
					}
					if($this->request->data['prtantou'] == "") {
						$this->insertTPrtantou ( $this->request->data,$torokuDate );
						$tantouval = $this->TPrtantou->getLastInsertId();
					} else {
						$this->updateTPrtantou ( $this->request->data,$torokuDate );
						$tantouval = $this->request->data['prtantou'];
					}
					$checkhyojinoexists = $this->checkhyojinoexistsTPrsyohin($this->request->data['hyojino'],$this->request->data['kaisyacd']);
					if($checkhyojinoexists == 1) {
						$max_consecutive = $this->checkhyojinoTPrsyohin($this->request->data['hyojino'],$this->request->data['kaisyacd']);
					}
					$this->insertTPrsyohin ( $this->request->data, $syasinKeyVal, $tantouval, $torokuDate);
					if($checkhyojinoexists == 1) {
						$this->checkhyojinoLastUp($this->request->data['hyojino'],$max_consecutive,$this->request->data['kaisyacd']);
					}
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
								$subject_mail = '【確認・通知】　PRサイト商品情報の登録';
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
				} else {
					$errors = $this->TPrsyohin->validationErrors;
					$errCount = count($errors);
					$idx=0;
					foreach($errors as $feild => $messages) {
						$responseString .= $feild."##".$messages[0];
						$idx++;
						if($idx < $errCount) {
							$responseString .= "$$";
						}
					}
					echo $responseString;
				}
			} else {
				$this->redirect ( [ 
						'controller' => 'AdminProductsite',
						'action' => 'index' 
				] );
			}
			$db_TPrsyohin->commit();
			$db_TSyasin->commit();
			$db_TPrtantou->commit();
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TPrsyohin = $this->TPrsyohin->getDataSource();
			$db_TPrsyohin->begin();
			$db_TPrtantou = $this->TPrtantou->getDataSource();
			$db_TPrtantou->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data['adminPRshohinupdate'] = $this->request->data;
				$torokuDate = $this->Common->getSystemDateTime ();
				$syasinKeyVal = $this->request->data ['urlsyasinKey'];
				$this->textarea_maxlength("syohinnm",$this->request->data['syohinnm'],1024,$responseString);
				$this->textarea_maxlength("syousai",$this->request->data['syousai'],1024,$responseString);
				$this->TPrsyohin->set ( $this->request->data );
				$checkhyojinoexists = $this->checkhyojinoexistsTPrsyohin($this->request->data['hyojino'],$this->request->data['kaisyacd']);
				$max_consecutive = "";
				if($this->request->data['hyojino'] != $this->request->data['oldhoujino'] && $checkhyojinoexists == 1 )
				{
					$max_consecutive = $this->checkhyojinoTPrsyohin($this->request->data['hyojino'],$this->request->data['kaisyacd']);
				}
				if ($this->TPrsyohin->validates()) {
					$rnoSyasin1 = $this->request->data ['urlsyasin1'];
					if (! isset ( $this->request->data ['syasin1Title'] )) {
						$syasin1Title = $this->request->data ['urltitle1'];
					} else {
						$syasin1Title = $this->request->data ['syasin1Title'];
					}
					if($this->request->data ['reset1'] == "1") {
						$syasin1 = '';
						$this->deleteTSyasin ($syasinKeyVal,'1');
						$syasinKeyVal = '0';
					} else if (isset ( $_FILES ['syasin1'] ['tmp_name'] )) {
						if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
							$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size'] );
							if (empty ( $rnoSyasin1 )) {
								$rno = "1";
								$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin1Title'], $syasin1, $torokuDate );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							} else {
								$this->updateTSyasin ( $syasinKeyVal, $rnoSyasin1, $syasin1Title, $syasin1, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin1Title'])) {
						$this->updateTSyasintitle( $syasinKeyVal, $rnoSyasin1, $syasin1Title, $torokuDate);
					}
					$hyojino = 1; //it will asign later 
					if($this->request->data['prtantou'] == "") {
						$this->insertTPrtantou ( $this->request->data,$torokuDate );
						$tantouval = $this->TPrtantou->getLastInsertId();
					} else {
						$this->updateTPrtantou ( $this->request->data,$torokuDate );
						$tantouval = $this->request->data['prtantou'];
					}
					$this->updateTPrsyohin ( $this->request->data, $syasinKeyVal, $tantouval, $torokuDate);
					if($this->request->data['hyojino'] != $this->request->data['oldhoujino'] && $checkhyojinoexists == 1 ) {
						$this->checkhyojinoLastUp($this->request->data['hyojino'],$max_consecutive,$this->request->data['kaisyacd']);
					}
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
								$subject_mail = '【確認・通知】　PRサイト商品情報の更新';
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
				} else {
					$errors = $this->TPrsyohin->validationErrors;
					$errCount = count($errors);
					$idx=0;
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
			$db_TPrsyohin->commit();
			$db_TSyasin->commit();
			$db_TPrtantou->commit();
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 *  機能名：分割処理
	 */
	public function getSyasinImage($id, $syasinkey) {
		$pictImage = $this->TSyasin->find ( 'first', array (
				'conditions' => array (
						'TSyasin.rno ' => $id,
						'TSyasin.syasinkey ' => $syasinkey,
						'TSyasin.bunrui' => $this->Constants->PRSYOHIN
				)
		) );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
		echo $pictImage ['TSyasin'] ['syasin'];
	}

	public function getSyasin($id, $syasinkey) {
		try {
			$pictImage = $this->TSyasin->find ( 'first', array (
					'conditions' => array (
							'TSyasin.rno ' => $id,
							'TSyasin.syasinkey ' => $syasinkey 
					) 
			) );
			$this->autoRender = false;
			header ( 'Content-type: image/jpeg' );
			header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
			echo $pictImage ['TSyasin'] ['syasin'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}

	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
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

	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function insertTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		// 項目の値セット
		try {
				$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->PRSYOHIN,
					'title' => $title,
					'syasin' => $syasin,
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
				);
				if(!empty($syasinkey)) {
					$columnValue['syasinkey'] = $syasinkey;
				}
			// 写真情報作成
			$this->TSyasin->create ();
			// 写真情報に登録
			if (!$this->TSyasin->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function updateTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt) {
		// 項目の値セット
		try {
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'syasin' => $db->value ( $syasin ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $tourokudt ) 
			);
			$conditions = array (
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno 
			);
			// 写真情報に更新
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function updateTSyasintitle($syasinkey, $rno, $title, $kousinDate) {
		try {
			// 項目の値セット
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $kousinDate )
			);
			$conditions = array (
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno
			);
			// 写真情報に更新
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function insertTPrtantou($request, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					'arno' => '',
					'kaisyacd' => $request ['kaisyacd'],
					'tantounm' => $request ['tantounm'],
					'busyo' => $request ['busyo'],
					'yakusyoku' => "", // it will asign later
					'tantoumsg' => $request ['tantoumsg'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// PR企業担当情報
			$this->TPrtantou->create ();
			// PR企業担当情報登録
			if (!$this->TPrtantou->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function updateTPrtantou($request, $kousinDate) {
		try {
			$columnValue = array (
					'arno' => $request['prtantou'],
					'tantounm' => $request['tantounm'],
					'tantoumsg' => $request['tantoumsg'],
					'busyo' => $request['busyo'],
					'kousindt' => $kousinDate 
			);
			//PR企業担当情報更新
			if (!$this->TPrtantou->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function insertTPrsyohin($request, $syasin, $tantou, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					// 'kkey' => $request ['TPrkeiyakuarno'],
					'kaisyacd' => $request ['kaisyacd'],
					'syohinnm' => $request ['syohinnm'],
					'syousai' => $request ['syousai'],
					'syasinkey' => $syasin,
					'tantou' => $tantou,
					'hyojino' => $request ['hyojino'],
					'koukaikbn' => $request ['koukaikbn'],
					'kikanfrom' => $request ['kikanfrom'],
					'kikanto' => $request ['kikanto'],
					'prkbn' => $request ['prkbn'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// PR商品情報
			$this->TPrsyohin->create ();
			// PR商品情報登録
			if (!$this->TPrsyohin->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function updateTPrsyohin($request, $syasin, $tantou, $kousinDate) {
		// 項目の値セット
		try {
			$columnValue = array (
					'arno' => $request ['adminPRshohinupdate'] ['id'],
					'kaisyacd' => $request['kaisyacd'],
					'syohinnm' => $request ['syohinnm'],
					'syousai' => $request ['syousai'],
					'syasinkey' => $syasin,
					'tantou' => $tantou,
					'hyojino' => $request ['hyojino'],
					'koukaikbn' => $request ['koukaikbn'],
					'kikanfrom' => $request ['kikanfrom'],
					'kikanto' => $request ['kikanto'],
					'prkbn' => $request ['prkbn'],
					'kousincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'kousindt' => $kousinDate 
			);
			// PR商品情報更新
			if (!$this->TPrsyohin->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TPrsyohin->rollback();
			$db_TSyasin->rollback();
			$db_TPrtantou->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function mailText($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> PRサイト商品情報の新規追加を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
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
						<td $braceWidth>【</td><td $titleWidth>商　品　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . nl2br($request ['syohinnm']) . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}

	private function mailTextUpdate($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> PRサイト商品情報の更新を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
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
						<td $braceWidth>【</td><td $titleWidth>商　品　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . nl2br($request ['syohinnm']) . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoLastUp($hyojino,$max_consecutive,$kaisyacd) {
		$this->TPrsyohin->query(" SET @num := ($hyojino-1); UPDATE t_prsyohin SET hyojino = @num := (@num+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive'AND kaisyacd = '$kaisyacd' order by hyojino ASC; ");
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoexistsTPrsyohin($hyojino,$kaisyacd) {
		$retrunvalue = 0;
		$checkhyojino = $this->TPrsyohin->find('first', array(
					'fields'=>array('hyojino','kaisyacd'),
					'conditions'=>array('hyojino' => $hyojino,
										'kaisyacd' => $kaisyacd)));
		if(isset($checkhyojino['TPrsyohin']['hyojino'])) {
			$retrunvalue = 1;
		}
		return $retrunvalue;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoTPrsyohin($hyojino,$kaisyacd) {
		$max_consecutive = $this->TPrsyohin->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM t_prsyohin AS leftTbl
					  	LEFT OUTER JOIN t_prsyohin AS rightTbl ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE leftTbl.hyojino >= $hyojino AND rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
		if(isset($max_consecutive[0][0]['MAX_CONSECUTIVE'])) {
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
			$this->TPrsyohin->query(" UPDATE t_prsyohin SET hyojino = (hyojino+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive'AND kaisyacd = '$kaisyacd' ");
		}
		return $max_consecutive;
	}
}