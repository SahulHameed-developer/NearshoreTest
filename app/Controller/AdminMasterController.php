<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Common');
/**
 * コードマスタ Controller
 *
 * コードマスタを表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminMasterController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MBunrui','MKbunrui','MSosiki','MKaiinsb','MKyaku','MIyaku','MSyumi', 'MGyosyu','MKonin','MKoukai','MTodofuken','TKaigiev','TKatudo','TKaiin','TToiawase','TNyuukai','TKaisya','TOsirase','MIinkai','MKurabu','MKryaku','MYkbunrui','TIinkai','TKurabu','TYakulist','TIknyuukai','MKeiyaku','TPrkyrireki','TPrkeiyaku');
	// レイアウト無し
	public $autoLayout = false;
	// 表示順序
	public $masterCode = array(1 => "分類マスタ", 2 => "組織マスタ", 3 => "活動分類マスタ", 4 => "会員種別マスタ", 5 => "委員会マスタ", 6 => "倶楽部マスタ", 7 => "協会役職マスタ", 8 => "委員会役職マスタ", 9 => "倶楽部役職マスタ", 10 => "役員分類マスタ", 11 => "趣味マスタ", 12 => "業種マスタ", 13 => "婚姻マスタ", 14 => "公開区分マスタ", 15 => "都道府県マスタ", 16 => "契約区分マスタ");

	// MAX可能日付 strtotime
	public $LARGEST_DATE_STRTOTIME = "253402182000";

	/**
	 *　画面名：コードマスタ一覧
	 *　機能名：コードマスタ一覧
	 */
	public function codemasterlist() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$this->set('selectedmstcode', '');
		$this->set('masterCode',$this->masterCode);
		$this->set('selectedOrder', '');
		$bunruiarr = $this->Common->getbunruiName($this->MBunrui);
		$this->set('classOrder',$bunruiarr);
		$this->render('/Admin/CodeMaster/list');
	}

	// public function getLargestDate() {
	// 	$pos = strpos($_SERVER['SERVER_NAME'], "localhost");
	// 	if ($pos !== false) {
	// 		return date("Y-m-d", PHP_INT_MAX);
	// 	} else {
	// 		return "9999-12-31";
	// 	}
	// }
	/**
	 *　画面名：権限設定
	 *　機能名：検索処理
	 */
	public function search() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$codemasterdel = $this->Session->read('codemasterdel');
			if(isset($codemasterdel['selectedmstcode'])) {
				$this->request->data['selectedmstcode'] = $codemasterdel['selectedmstcode'];
				$this->request->data['selectedOrder'] = $codemasterdel['selectedOrder'];
				$this->Session->delete('codemasterdel');
			}
			// リクエストデータが空白の場合
			if(empty($this->request->data)){
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				$data = array();
				$query = array();
				if(isset($this->request->data['ModoruFrm']['selectedmstcode'])) {
					$masterCode = $this->request->data['ModoruFrm']['selectedmstcode'];
				} else {
					$masterCode = $this->request->data['selectedmstcode'];
				}
				if(isset($this->request->data['ModoruFrm']['selectedOrder'])) {
					$classOrder = $this->request->data['ModoruFrm']['selectedOrder'];
				} else if (isset($this->request->data['selectedOrder'])) {
					$classOrder = $this->request->data['selectedOrder'];
				} else {
					$classOrder = "";
				}
				for ($i=0; $i <16 ; $i++) {
					if (($masterCode -1 ) == $i) {
						if ($masterCode == $this->Constants->M_SOSIKI_VAL) {
							$query = $this->MSosiki->find('all', array(
										'fields' => array('MSosiki.sosikicd',
															'MSosiki.sosikinm',
															'MSosiki.sosikirs',
															'MSosiki.hyojino',
															'MSosiki.fromdt',
															'MSosiki.todt'),
										'order' => array('ABS(MSosiki.sosikicd)' => 'ASC',
														'MSosiki.fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MSosiki']['sosikicd'];
								$data[$i]['name'] = $query_val['MSosiki']['sosikinm'];
								$data[$i]['abbr_name'] = $query_val['MSosiki']['sosikirs'];
								$data[$i]['hyojino'] = $query_val['MSosiki']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MSosiki']['fromdt'];
								$data[$i]['todt'] = $query_val['MSosiki']['todt'];
								$i++;
							}
						} else if ($masterCode == $this->Constants->M_KEIYAKU_VAL) {
							$query = $this->MKeiyaku->find('all', array(
										'fields' => array('MKeiyaku.keiyakucd',
															'MKeiyaku.keiyakunm',
															'MKeiyaku.keiyakurs',
															'MKeiyaku.hyojino',
															'MKeiyaku.fromdt',
															'MKeiyaku.todt'),
										'order' => array('ABS(MKeiyaku.keiyakucd)' => 'ASC',
														'MKeiyaku.fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MKeiyaku']['keiyakucd'];
								$data[$i]['name'] = $query_val['MKeiyaku']['keiyakunm'];
								$data[$i]['abbr_name'] = $query_val['MKeiyaku']['keiyakurs'];
								$data[$i]['hyojino'] = $query_val['MKeiyaku']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MKeiyaku']['fromdt'];
								$data[$i]['todt'] = $query_val['MKeiyaku']['todt'];
								$i++;
							}
						} else if ($masterCode == $this->Constants->M_IINKAI_VAL) {
							$query = $this->MIinkai->find('all', array(
										'fields' => array('MIinkai.iinkaicd',
															'MIinkai.iinkainm',
															'MIinkai.iinkairs',
															'MIinkai.hyojino',
															'MIinkai.fromdt',
															'MIinkai.todt'),
										'order' => array('ABS(MIinkai.iinkaicd)' => 'ASC',
														'MIinkai.fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MIinkai']['iinkaicd'];
								$data[$i]['name'] = $query_val['MIinkai']['iinkainm'];
								$data[$i]['abbr_name'] = $query_val['MIinkai']['iinkairs'];
								$data[$i]['hyojino'] = $query_val['MIinkai']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MIinkai']['fromdt'];
								$data[$i]['todt'] = $query_val['MIinkai']['todt'];
								$i++;
							}
						} else if ($masterCode == $this->Constants->M_KURABU_VAL) {
							$query = $this->MKurabu->find('all', array(
										'fields' => array('MKurabu.kurabucd',
															'MKurabu.kurabunm',
															'MKurabu.kuraburs',
															'MKurabu.mailaddr',
															'MKurabu.hyojino',
															'MKurabu.fromdt',
															'MKurabu.todt'),
										'order' => array('ABS(MKurabu.kurabucd)' => 'ASC',
														'MKurabu.fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MKurabu']['kurabucd'];
								$data[$i]['name'] = $query_val['MKurabu']['kurabunm'];
								$data[$i]['abbr_name'] = $query_val['MKurabu']['kuraburs'];
								$data[$i]['mailaddr'] = $query_val['MKurabu']['mailaddr'];
								$data[$i]['hyojino'] = $query_val['MKurabu']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MKurabu']['fromdt'];
								$data[$i]['todt'] = $query_val['MKurabu']['todt'];
								$i++;
							}
						} else if ($masterCode == $this->Constants->M_YKBUNRUI_VAL) {
							$query = $this->MYkbunrui->find('all', array(
										'fields' => array('MYkbunrui.yakuincd',
															'MYkbunrui.yakuinnm',
															'MYkbunrui.kmnm1',
															'MYkbunrui.kmnm2',
															'MYkbunrui.kmnm3',
															'MYkbunrui.kmnm4',
															'MYkbunrui.hyojino',
															'MYkbunrui.fromdt',
															'MYkbunrui.todt'),
										'order' => array('ABS(MYkbunrui.yakuincd)' => 'ASC',
														'MYkbunrui.fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MYkbunrui']['yakuincd'];
								$data[$i]['name'] = $query_val['MYkbunrui']['yakuinnm'];
								$data[$i]['kmnm1'] = $query_val['MYkbunrui']['kmnm1'];
								$data[$i]['kmnm2'] = $query_val['MYkbunrui']['kmnm2'];
								$data[$i]['kmnm3'] = $query_val['MYkbunrui']['kmnm3'];
								$data[$i]['kmnm4'] = $query_val['MYkbunrui']['kmnm4'];
								$data[$i]['hyojino'] = $query_val['MYkbunrui']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MYkbunrui']['fromdt'];
								$data[$i]['todt'] = $query_val['MYkbunrui']['todt'];
								$i++;
							}
						} else if ($masterCode == $this->Constants->M_KBUNRUI_VAL) {
							$conditions = array();
							if ($classOrder != "") {
								$classOrderarr = explode('&&', $classOrder);
								$conditions[] = array('MKbunrui.bunruicd' => $classOrderarr[0],
													  'bunrui.fromdt ' => $classOrderarr[1],
													  'bunrui.todt ' => $classOrderarr[2]);
								$conditions[] = array('OR' => array(
												array('MKbunrui.fromdt <= ' => $classOrderarr[1],
													  'MKbunrui.todt > ' => $classOrderarr[1]),
												array('MKbunrui.fromdt < ' => $classOrderarr[2],
													  'MKbunrui.todt >= ' => $classOrderarr[2]),
												array('MKbunrui.fromdt >= ' => $classOrderarr[1],
													  'MKbunrui.todt <= ' => $classOrderarr[2])));
								$query = $this->MKbunrui->find('all', array(
											'joins' => array(
												array('table' => $this->MBunrui,
													'alias' => 'bunrui',
													'type' => 'LEFT',
													'conditions' => array(
														'bunrui.bunruicd = MKbunrui.bunruicd'))),
											'fields' => array('MKbunrui.kbunruicd',
																'MKbunrui.bunruicd',
																'bunrui.bunruinm',
																'MKbunrui.kbunruinm',
																'MKbunrui.hyojino',
																'MKbunrui.fromdt',
																'MKbunrui.todt',
																'bunrui.fromdt',
																'bunrui.todt'),
											'conditions' => $conditions,
											'order' => array('ABS(MKbunrui.kbunruicd)' => 'ASC',
															'MKbunrui.fromdt' => 'ASC')));
							}
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val['MKbunrui']['kbunruicd'];
								$data[$i]['bunruicd'] = $query_val['MKbunrui']['bunruicd'];
								$data[$i]['class_name'] = $query_val['bunrui']['bunruinm'];
								$data[$i]['name'] = $query_val['MKbunrui']['kbunruinm'];
								$data[$i]['hyojino'] = $query_val['MKbunrui']['hyojino'];
								$data[$i]['fromdt'] = $query_val['MKbunrui']['fromdt'];
								$data[$i]['todt'] = $query_val['MKbunrui']['todt'];
								$i++;
							}
						} else {
							$table_name = $this->Constants->MODEL_NM[$i];
							$table = $this->Constants->TABLE_NM[$i];
							$code_name = $this->Constants->TABLE_CD_NM[$i];
							$name = $this->Constants->TABLE_NM_NAME[$i];
							$query = $this->$table_name->find('all', array(
										'fields' => array($code_name,
															$name,
															'hyojino',
															'fromdt',
															'todt'),
										'order' => array('ABS('.$code_name.')' => 'ASC',
														'fromdt' => 'ASC')));
							foreach($query as $query_val) {
								$data[$i]['code'] = $query_val[$table_name][$code_name];
								$data[$i]['name'] = $query_val[$table_name][$name];
								$data[$i]['hyojino'] = $query_val[$table_name]['hyojino'];
								$data[$i]['fromdt'] = $query_val[$table_name]['fromdt'];
								$data[$i]['todt'] = $query_val[$table_name]['todt'];
								$i++;
							}
						}
					}
				}
				$this->set('selectedmstcode', $masterCode);
				$this->set('searchinfo',$data);
				$this->set('count', count($query));
				$this->set('searchval','1');
				$this->set('selectedOrder', $classOrder);
				$bunruiarr = $this->Common->getbunruiName($this->MBunrui);
				$this->set('classOrder',$bunruiarr);
				$this->set('masterCode',$this->masterCode);
				if(!empty($masterCode)) {
					$this->set('selectedmstcode',$masterCode);
				} else {
					$this->set('selectedmstcode','');
				}
				if(!empty($classOrder)) {
					$this->set('selectedOrder',$classOrder);
				} else {
					$this->set('selectedOrder','');
				}
				$this->render('/Admin/CodeMaster/list');
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
	 *　画面名：コードマスタ一覧
	 *　機能名：削除処理
	 */
	public function delete() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$this->autoRender = false;
			$code = $this->request->data ['sousai_Frm'] ['code'];
			$fromdt = $this->request->data ['sousai_Frm'] ['fromdt'];
			$todt = $this->request->data ['sousai_Frm'] ['todt'];
			$masterCode = $this->request->data ['sousai_Frm'] ['selectedmstcode'];
			for ($i=0; $i <16 ; $i++) { 
				if (($masterCode -1 ) == $i) {
					$table_name = $this->Constants->MODEL_NM[$i];
					$table = $this->Constants->TABLE_NM[$i];
					$code_name = $this->Constants->TABLE_CD_NM[$i];
					$hyojino = $this->$table_name->find('first', array(
							'fields'=>array('hyojino'),
							'conditions'=>array($code_name => $code,
												'fromdt' => $fromdt,
												'todt' => $todt)));
					if (($masterCode) == $this->Constants->M_KBUNRUI_VAL) {
						$bunruicd = $this->request->data ['sousai_Frm'] ['bunruicd'];
						$max_consecutive = $this->updatehyojino('2',$table_name,$table,$code_name,$code,$bunruicd);
						$this->$table_name->query(" DELETE FROM $table WHERE $code_name = '$code' AND bunruicd = '$bunruicd' AND fromdt = '$fromdt' AND todt = '$todt' ");
						$this->checkhyojinoLastUp($table_name,$table,$hyojino[$table_name]['hyojino'],$bunruicd,$max_consecutive);
					} else {
						$max_consecutive = $this->updatehyojino('1',$table_name,$table,$code_name,$code,'0');
						$this->$table_name->query(" DELETE FROM $table WHERE $code_name = '$code' AND fromdt = '$fromdt' AND todt = '$todt' ");
						$this->checkhyojinoLastUp($table_name,$table,$hyojino[$table_name]['hyojino'],'0',$max_consecutive);
					}
				}
			}
			$codemasterdel['selectedmstcode'] = $masterCode;
			$codemasterdel['selectedOrder'] = $this->request->data['sousai_Frm']['selectedOrder'];
			$this->Session->write ( "codemasterdel", $codemasterdel );
			$this->redirect ( ['controller' => 'AdminMaster','action' => 'search' ] );
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：コードマスタ新規追加
	 *　機能名：追加処理
	 */
	public function add() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			// リクエストデータが空白以外の場合
			if(empty($this->request->data)){
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			} else {
				$this->set('selectedmstcode',$this->request->data['sousai_Frm']['selectedmstcode']);
				$this->set('selectedOrder',$this->request->data['sousai_Frm']['selectedOrder']);
				$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
				$this->set('bunruilist',$bunruilist);
				$this->render('/Admin/CodeMaster/add');
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
	 *　画面名：コードマスタ新規追加
	 *　機能名：追加処理
	 */
	public function register() {
		try {
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$table = $this->Constants->MODEL_NM[$this->request->data['mstcode']-1];
			$tableC = $this->Constants->TABLE_NM[$this->request->data['mstcode']-1];
			$code = $this->Constants->TABLE_CD_NM[$this->request->data['mstcode']-1];
			$data_nm = $this->Constants->TABLE_NM_NAME[$this->request->data['mstcode']-1];
			$db = $this->$table->getDataSource();
			$db->begin();
			$data = $this->request->data;
			if($this->request->data['mstcode'] == $this->Constants->M_SOSIKI_VAL ) {
				$data['sosikirs'] = $this->request->data['ryakusho'];
			} else if($this->request->data['mstcode'] == $this->Constants->M_KEIYAKU_VAL ) {
				$data['keiyakurs'] = $this->request->data['ryakusho'];
			} else if($this->request->data['mstcode'] == $this->Constants->M_IINKAI_VAL ) {
				$data['iinkairs'] = $this->request->data['ryakusho'];
			} else if($this->request->data['mstcode'] == $this->Constants->M_KURABU_VAL ) {
				$data['kuraburs'] = $this->request->data['ryakusho'];
				$data['mailaddr'] = $this->request->data['mailaddr'];
			} else if($this->request->data['mstcode'] == $this->Constants->M_KBUNRUI_VAL) {
				$data['bunruicd'] = $this->request->data['bunruicd'];
			}
			if($this->request->data['mstcode'] == $this->Constants->M_BUNRUI_VAL || $this->request->data['mstcode'] == $this->Constants->M_KONIN_VAL || $this->request->data['mstcode'] == $this->Constants->M_KOUKAI_VAL || $this->request->data['mstcode'] == $this->Constants->M_KEIYAKU_VAL ) {
				$data[$code] = $this->request->data['code'];
			} else if($this->request->data['mstcode'] == $this->Constants->M_KBUNRUI_VAL) {
				$data[$code] = str_pad($this->request->data['code'],3,'0',STR_PAD_LEFT);
			} else {
				$data[$code] = str_pad($this->request->data['code'],2,'0',STR_PAD_LEFT);
			}
			$data[$data_nm] = $this->request->data['meisho'];
			if($data['todt'] == "") {
				$data['todt'] = "9999/12/31";
			}
			$data['tourokudt'] =  $this->Common->getSystemDateTime();
			$data['tourokucd'] =  $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
			if(!isset($this->request->data['bunruicd'])) {
				$this->request->data['bunruicd'] = 0;
			}
			$checkhyojinoexists = $this->checkhyojinoexists($table,$data['hyojino'],$this->request->data['bunruicd']);
			if($checkhyojinoexists == 1) {
				$max_consecutive = $this->checkhyojino($table,$tableC,$data['hyojino'],$this->request->data['bunruicd']);
			}

			// 既存データを更新処理
			$prevTodtval = date('Y-m-d', strtotime('-1 day', strtotime($data['fromdt'])));
			if($this->request->data['bunruicd'] == 0) {
				$PrevTodt = $this->$table->find('first', array(
								'fields'=>array('fromdt','todt'),
								'conditions'=>array($code => $data['code'],
													'fromdt < ' => $data['fromdt'],
													'todt >= ' => $data['fromdt'])));
			} else {
				$PrevTodt = $this->$table->find('first', array(
								'fields'=>array('fromdt','todt'),
								'conditions'=>array($code => $data['code'],
													'bunruicd' => $this->request->data['bunruicd'],
													'fromdt < ' => $data['fromdt'],
													'todt >= ' => $data['fromdt'])));
			}
			if(isset($PrevTodt[$table]['todt'])) {
				$columnValueTo = array (
					'todt' => $db->value ( $prevTodtval ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
				);
				if($this->request->data['bunruicd'] == 0) {
					$conditionsTo = array (
						$code => $this->request->data['code'],
						'fromdt' => $PrevTodt[$table]['fromdt'],
						'todt' => $PrevTodt[$table]['todt']
					);
				} else {
					$conditionsTo = array (
						$code => $this->request->data['code'],
						'bunruicd' => $this->request->data['bunruicd'],
						'fromdt' => $PrevTodt[$table]['fromdt'],
						'todt' => $PrevTodt[$table]['todt']
					);
				}
				$this->$table->updateAll ( $columnValueTo, $conditionsTo );
			}
			// 既存データを更新処理

			$this->$table->set($data);
			if ($this->$table->validates()) {
				$this->$table->create();
				$this->$table->save($data);
				if($checkhyojinoexists == 1) {
					$this->checkhyojinoLastUp($table,$tableC,$data['hyojino'],$this->request->data['bunruicd'],$max_consecutive);
				}
				$responseString = "1";
				echo $responseString;
			} else {
				$errors = $this->$table->validationErrors;
				$errCount = count($errors);
				$idx=0;
				foreach($errors as $feild => $messages) {
					if(in_array($feild, $this->Constants->TABLE_CD_NM)) {
					    $feild = "code";
					}
					if(in_array($feild, $this->Constants->TABLE_NM_NAME)) {
					    $feild = "meisho";
					}
					$responseString .= $feild."##".$messages[0];
					$idx++;
					if($idx < $errCount) {
						$responseString .= "$$";
					}
				}
				echo $responseString;
			}
			$db->commit();
			exit();
		} catch (Exception $e) {
			$db->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：コードマスタ新規更新
	 *　機能名：更新処理
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			// リクエストデータが空白以外の場合
			if(empty($this->request->data)){
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			} else {
				$table = $this->Constants->MODEL_NM[$this->request->data['sousai_Frm']['selectedmstcode']-1];
				$code = $this->Constants->TABLE_CD_NM[$this->request->data['sousai_Frm']['selectedmstcode']-1];
				$data = $this->Constants->TABLE_NM_NAME[$this->request->data['sousai_Frm']['selectedmstcode']-1];
				$this->set('kmnm1', '');
				$this->set('kmnm2', '');
				$this->set('kmnm3', '');
				$this->set('kmnm4', '');
				$this->set('mailaddr', '');
				if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_SOSIKI_VAL ) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'sosikirs','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('bunruicd', '');
					$this->set('abbr_name', $record[$table]['sosikirs']);
					$this->set('expiredradio', '');
				} else if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_KEIYAKU_VAL ) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'keiyakurs','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('bunruicd', '');
					$this->set('abbr_name', $record[$table]['keiyakurs']);
					$this->set('expiredradio', '');
				} else if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_IINKAI_VAL ) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'iinkairs','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('bunruicd', '');
					$this->set('abbr_name', $record[$table]['iinkairs']);
					$this->set('expiredradio', '');
				} else if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_KURABU_VAL ) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'kuraburs','mailaddr','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('bunruicd', '');
					$this->set('abbr_name', $record[$table]['kuraburs']);
					$this->set('mailaddr', $record[$table]['mailaddr']);
					$this->set('expiredradio', '');
				} else if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_YKBUNRUI_VAL ) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'kmnm1','kmnm2','kmnm3','kmnm4','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('bunruicd', '');
					$this->set('kmnm1', $record[$table]['kmnm1']);
					$this->set('kmnm2', $record[$table]['kmnm2']);
					$this->set('kmnm3', $record[$table]['kmnm3']);
					$this->set('kmnm4', $record[$table]['kmnm4']);
					$this->set('expiredradio', '');
				} else if($this->request->data['sousai_Frm']['selectedmstcode'] == $this->Constants->M_KBUNRUI_VAL) {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'bunruicd','fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'bunruicd' =>$this->request->data['sousai_Frm']['bunruicd'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
        			$selectedOrder_fld  = split("&&", $this->request->data['sousai_Frm']['selectedOrder']);
					$expiredradio = $this->MBunrui->find('list', array(
								'fields'=>array('bunruicd','bunruinm'),
								'conditions'=>array(
											'bunruicd' => $selectedOrder_fld[0],
											'fromdt' => $selectedOrder_fld[1],
											'todt' => $selectedOrder_fld[2],
											'todt <' => date('Y-m-d') )));
					$this->set('expiredradio', $expiredradio);
					$this->set('bunruicd', $record[$table]['bunruicd']);
					$this->set('sosikirs', '');
				} else {
					$record = $this->$table->find('first', array(
								'fields'=>array($code,$data,'fromdt','todt','hyojino'),
								'conditions'=>array($code => $this->request->data['sousai_Frm']['code'],
													'fromdt'=>$this->request->data['sousai_Frm']['fromdt'],
													'todt'=>$this->request->data['sousai_Frm']['todt'])));
					$this->set('sosikirs', '');
					$this->set('bunruicd', '');
					$this->set('expiredradio', '');
				}
				$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
				$this->set('bunruilist',$bunruilist);
				$this->set('code', $record[$table][$code]);
				$this->set('name', $record[$table][$data]);
				$this->set('fromdt', str_replace('-', '/', $record[$table]['fromdt']));
				$this->set('todt', str_replace('-', '/', $record[$table]['todt']));
				$this->set('hyojino', $record[$table]['hyojino']);
				$this->set('selectedmstcode',$this->request->data['sousai_Frm']['selectedmstcode']);
				$this->set('selectedOrder',$this->request->data['sousai_Frm']['selectedOrder']);
				$this->render('/Admin/CodeMaster/edit');
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
	 *　画面名：コードマスタ新規更新
	 *　機能名：更新処理
	 */
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$table = $this->Constants->MODEL_NM[$this->request->data['mstcode']-1];
			$tableC = $this->Constants->TABLE_NM[$this->request->data['mstcode']-1];
			$code = $this->Constants->TABLE_CD_NM[$this->request->data['mstcode']-1];
			$data_nm = $this->Constants->TABLE_NM_NAME[$this->request->data['mstcode']-1];
			$db = $this->$table->getDataSource();
			$db->begin();
			if(!isset($this->request->data['bunruicd'])) {
				$this->request->data['bunruicd'] = 0;
			}
			$checkhyojinoexists = $this->checkhyojinoexists($table,$this->request->data['hyojino'],$this->request->data['bunruicd']);
			if($this->request->data['hyojino'] != $this->request->data['hyojino_db'] && $checkhyojinoexists == 1 ) {
				$max_consecutive = $this->checkhyojino($table,$tableC,$this->request->data['hyojino'],$this->request->data['bunruicd']);
			}
			if($this->request->data['todt'] == "") {
				$this->request->data['todt'] = "9999/12/31";
			}
			$data = $this->request->data;
			if($this->request->data['mstcode'] == $this->Constants->M_YKBUNRUI_VAL ) {
				$data['yakuinnm'] = $this->request->data['meisho'];
			}
			$this->$table->set($data);
			if ($this->$table->validates()) {
				if($this->request->data['mstcode'] == $this->Constants->M_SOSIKI_VAL ) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'sosikirs' => $db->value ( $this->request->data['ryakusho'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else if($this->request->data['mstcode'] == $this->Constants->M_KEIYAKU_VAL ) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'keiyakurs' => $db->value ( $this->request->data['ryakusho'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else if($this->request->data['mstcode'] == $this->Constants->M_IINKAI_VAL ) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'iinkairs' => $db->value ( $this->request->data['ryakusho'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else if($this->request->data['mstcode'] == $this->Constants->M_KURABU_VAL ) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'kuraburs' => $db->value ( $this->request->data['ryakusho'] ),
						'mailaddr' => $db->value ( $this->request->data['mailaddr'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else if($this->request->data['mstcode'] == $this->Constants->M_YKBUNRUI_VAL ) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'kmnm1' => $db->value ( $this->request->data['kmnm1'] ),
						'kmnm2' => $db->value ( $this->request->data['kmnm2'] ),
						'kmnm3' => $db->value ( $this->request->data['kmnm3'] ),
						'kmnm4' => $db->value ( $this->request->data['kmnm4'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else if($this->request->data['mstcode'] == $this->Constants->M_KBUNRUI_VAL) {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'bunruicd' => $db->value ( $this->request->data['bunruicd'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'bunruicd' => $this->request->data['bunruicd_db'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				} else {
					$columnValue = array (
						$data_nm => $db->value ( $this->request->data['meisho'] ),
						'fromdt' => $db->value ( $this->request->data['fromdt'] ),
						'todt' => $db->value ( $this->request->data['todt'] ),
						'hyojino' => $db->value ( $this->request->data['hyojino'] ),
						'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
						'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
					);
					$conditions = array (
						$code => $this->request->data['code'],
						'fromdt' => $this->request->data['db_fromdt'],
						'todt' => $this->request->data['db_todt']
					);
				}
				$this->$table->updateAll ( $columnValue, $conditions );
				if($this->request->data['hyojino'] != $this->request->data['hyojino_db'] && $checkhyojinoexists == 1 ) {
					$this->checkhyojinoLastUp($table,$tableC,$this->request->data['hyojino'],$this->request->data['bunruicd'],$max_consecutive);
				}
				$responseString = "1";
				echo $responseString;
			} else {
				$errors = $this->$table->validationErrors;
				$errCount = count($errors);
				$idx=0;
				foreach($errors as $feild => $messages) {
					if(in_array($feild, $this->Constants->TABLE_CD_NM)) {
					    $feild = "code";
					}
					if(in_array($feild, $this->Constants->TABLE_NM_NAME)) {
					    $feild = "meisho";
					}
					$responseString .= $feild."##".$messages[0];
					$idx++;
					if($idx < $errCount) {
						$responseString .= "$$";
					}
				}
				echo $responseString;
			}
			$db->commit();
			exit();
		} catch (Exception $e) {
			$db->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
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
        		$requestData[$fields[0]] = urldecode($fields[1]);
        	}
        }
		return $requestData;
	}
	/**
	 *　機能名：コードの存在チェック処理
	 */
	public function checkcode() {
		if($this->request->data['todt'] == "") {
			$this->request->data['todt'] = "9999-12-31";
		}
		if($this->request->data['table'] == $this->Constants->M_BUNRUI_VAL || $this->request->data['table'] == $this->Constants->M_KONIN_VAL || $this->request->data['table'] == $this->Constants->M_KOUKAI_VAL || $this->request->data['table'] == $this->Constants->M_KEIYAKU_VAL ) {
			$this->request->data['checkcode'] = $this->request->data['checkcode'];
		} else if($this->request->data['table'] == $this->Constants->M_KBUNRUI_VAL) {
			$this->request->data['checkcode'] = str_pad($this->request->data['checkcode'],3,'0',STR_PAD_LEFT);
		} else {
			$this->request->data['checkcode'] = str_pad($this->request->data['checkcode'],2,'0',STR_PAD_LEFT);
		}
		$table = $this->Constants->MODEL_NM[$this->request->data['table']-1];
		$code = $this->Constants->TABLE_CD_NM[$this->request->data['table']-1];
		$checkcode = $this->$table->find('first', array(
						'fields'=>array($code),
						'conditions'=>array($code => $this->request->data['checkcode'],
											'fromdt'=>$this->request->data['fromdt'],
											'todt'=>$this->request->data['todt'])));
		echo json_encode($checkcode);exit();
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoexists($table,$hyojino,$bunruicd) {
		$retrunvalue = 0;
		if($bunruicd == 0) {
			$checkhyojino = $this->$table->find('first', array(
						'fields'=>array('hyojino'),
						'conditions'=>array('hyojino' => $hyojino)));
		} else {
			$checkhyojino = $this->$table->find('first', array(
						'fields'=>array('hyojino'),
						'conditions'=>array('hyojino' => $hyojino,'bunruicd' => $bunruicd)));
		}
		if(isset($checkhyojino[$table]['hyojino'])) {
			$retrunvalue = 1;
		}
		return $retrunvalue;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojino($table,$tableC,$hyojino,$bunruicd) {
		if($bunruicd == 0 ) {
			$max_consecutive = $this->$table->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM $tableC AS leftTbl
						  LEFT OUTER JOIN $tableC AS rightTbl 
								ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE 
							leftTbl.hyojino >= $hyojino AND 
							rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
			if(isset($max_consecutive[0][0]['MAX_CONSECUTIVE'])) {
				$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
				$this->$table->query(" UPDATE $tableC SET hyojino = (hyojino+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' ");
			}
		} else {
			$max_consecutive = $this->$table->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM $tableC AS leftTbl
						  LEFT OUTER JOIN $tableC AS rightTbl 
								ON leftTbl.hyojino+ 1 = rightTbl.hyojino AND leftTbl.bunruicd = rightTbl.bunruicd
						WHERE 
							leftTbl.bunruicd = $bunruicd AND 
							leftTbl.hyojino >= $hyojino AND 
							rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
			if(isset($max_consecutive[0][0]['MAX_CONSECUTIVE'])) {
				$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
				$this->$table->query(" UPDATE $tableC SET hyojino = (hyojino+1) WHERE bunruicd = '$bunruicd' AND hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' ");
			}
		}
		return $max_consecutive;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function updatehyojino($flg,$table,$tableC,$code,$codeval,$bunruicd) {
		if($flg == 1) {
			$oldhyojino = $this->$table->find('first', array(
							'fields'=>array('hyojino',$code),
							'conditions'=>array($code => $codeval)));
			$hyojino = $oldhyojino[$table]['hyojino'];
			$max_consecutive = $this->$table->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM $tableC AS leftTbl
						  LEFT OUTER JOIN $tableC AS rightTbl 
								ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE 
							leftTbl.hyojino >= $hyojino AND 
							rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
		} else {
			$oldhyojino = $this->$table->find('first', array(
							'fields'=>array('hyojino'),
							'conditions'=>array($code => $codeval, 'bunruicd' => $bunruicd)));
			$hyojino = $oldhyojino[$table]['hyojino'];
			$max_consecutive = $this->$table->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM $tableC AS leftTbl
						  LEFT OUTER JOIN $tableC AS rightTbl 
								ON leftTbl.hyojino+ 1 = rightTbl.hyojino AND leftTbl.bunruicd = rightTbl.bunruicd
						WHERE 
							leftTbl.bunruicd = $bunruicd AND 
							leftTbl.hyojino >= $hyojino AND 
							rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
		}
		if($flg == 1) {
			$this->$table->query(" UPDATE $tableC SET hyojino = (hyojino-1) WHERE hyojino > '$hyojino' AND hyojino < '$max_consecutive' ");
		} else {
			$this->$table->query(" UPDATE $tableC SET hyojino = (hyojino-1) WHERE bunruicd = '$bunruicd' AND hyojino > '$hyojino' AND hyojino < '$max_consecutive' ");
		}
		return $max_consecutive;
	}
	/**
	 *　機能名：分類の存在チェック処理
	 */
	public function checkbunruicd() {
		if($this->request->data['todt'] == "") {
			$this->request->data['todt'] = "9999-12-31";
		}
		$this->request->data['kbunruicd'] = str_pad($this->request->data['kbunruicd'],3,'0',STR_PAD_LEFT);
		$checkbunruicd = $this->MKbunrui->find('first', array(
						'fields'=>array('kbunruicd'),
						'conditions'=>array('kbunruicd' => $this->request->data['kbunruicd'],
											'bunruicd ' => $this->request->data['bunruicd'],
											'fromdt'=>$this->request->data['fromdt'],
											'todt'=>$this->request->data['todt'])));
		echo json_encode($checkbunruicd);exit();
	}
	/**
	 *　機能名：テーブルデタの存在チェック処理
	 */
	public function tabledatachk() {
		$masterCode = $this->request->data['masterCode'];
		$code = $this->request->data['code'];
		$fromdt = $this->request->data['fromdt'];
		$todt = $this->request->data['todt'];
		$bunruicd = $this->request->data['bunruicd'];
		$response = 0;
		if($masterCode == $this->Constants->M_BUNRUI_VAL) {
			$checkTKaigiev = $this->getval($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$this->Constants->M_BUNRUI_BUNRUICD,$code,$fromdt,$todt);
			$checkTKatudo = $this->getval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_BUNRUI_BUNRUICD,$code,$fromdt,$todt);
			$response = $checkTKaigiev + $checkTKatudo;
		} else if($masterCode == $this->Constants->M_SOSIKI_VAL) {
			$checkTKaigiev = $this->getval($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt);
			$checkTKatudo = $this->getval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt);
			$checkTKaiin = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt);
			$response = $checkTKaigiev + $checkTKatudo + $checkTKaiin;
		} else if($masterCode == $this->Constants->M_KEIYAKU_VAL) {
			$checkTPrkyrireki = $this->getval($this->Constants->T_PRKYRIREKI_TBL_NM,$this->Constants->T_PRKYRIREKI_MDL_NM,$this->Constants->T_PRKYRIREKI_KYKBN,$code,$fromdt,$todt);
			$checkTPrkeiyaku = $this->getval($this->Constants->T_PRKEIYAKU_TBL_NM,$this->Constants->T_PRKEIYAKU_MDL_NM,$this->Constants->T_PRKEIYAKU_KYKBN,$code,$fromdt,$todt);
			$response = $checkTPrkyrireki + $checkTPrkeiyaku;
		} else if($masterCode == $this->Constants->M_KBUNRUI_VAL) {
			$checkTKaigiev = $this->getval3($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$bunruicd,$code,$fromdt,$todt);
			$checkTKatudo = $this->getval3($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$bunruicd,$code,$fromdt,$todt);
			$response = $checkTKaigiev + $checkTKatudo;
		} else if($masterCode == $this->Constants->M_KAIINSB_VAL) {
			$checkTKaiin = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KAIINSB_KAIINSBCD,$code,$fromdt,$todt);
			$response = $checkTKaiin;
		} else if($masterCode == $this->Constants->M_KYAKU_VAL) {
			$checkkyoukaiykcd = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KYAKU_KYOUKAIYKCD,$code,$fromdt,$todt);
			$response = $checkkyoukaiykcd;
		} else if($masterCode == $this->Constants->M_IYAKU_VAL) {
			$checkiinkaiykcd = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_IYAKU_IINKAIYKCD,$code,$fromdt,$todt);
			$response = $checkiinkaiykcd;
		} else if($masterCode == $this->Constants->M_SYUMI_VAL) {
			$checksyumicd1 = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD1,$code,$fromdt,$todt);
			$checksyumicd2 = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD2,$code,$fromdt,$todt);
			$checksyumicd3 = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD3,$code,$fromdt,$todt);
			$response = $checksyumicd1 + $checksyumicd2 + $checksyumicd3;
		} else if($masterCode == $this->Constants->M_GYOSYU_VAL) {
			$checkgyosyucd1 = $this->getval($this->Constants->T_TOIAWASE_TBL_NM,$this->Constants->T_TOIAWASE_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt);
			$checkgyosyucd2 = $this->getval($this->Constants->T_NYUUKAI_TBL_NM,$this->Constants->T_NYUUKAI_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt);
			$checkgyosyucd3 = $this->getval($this->Constants->T_KAISYA_TBL_NM,$this->Constants->T_KAISYA_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt);
			$response = $checkgyosyucd1 + $checkgyosyucd2 + $checkgyosyucd3;
		} else if($masterCode == $this->Constants->M_KONIN_vAL) {
			$checkkonin = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KONIN_KONIN,$code,$fromdt,$todt);
			$response = $checkkonin;
		} else if($masterCode == $this->Constants->M_KOUKAI_VAL) {
			$checkkoukaikbn1 = $this->getval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt);
			$checkkoukaikbn2 = $this->getval($this->Constants->T_KAISYA_TBL_NM,$this->Constants->T_KAISYA_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt);
			$checkkoukaikbn3 = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt);
			$checkkoukaikbn4 = $this->getval($this->Constants->T_OSIRASE_TBL_NM,$this->Constants->T_OSIRASE_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt);
			$response = $checkkoukaikbn1 + $checkkoukaikbn2 + $checkkoukaikbn3 + $checkkoukaikbn4;
		} else if($masterCode == $this->Constants->M_TODOFUKEN_VAL) {
			$checkumare = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->T_KAIIN_UMARE,$code,$fromdt,$todt);
			$checksodati = $this->getval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->T_KAIIN_SODATI,$code,$fromdt,$todt);
			$response = $checkumare + $checksodati;
		} else if($masterCode == $this->Constants->M_IINKAI_VAL) {
			$response = $this->getval($this->Constants->T_IINKAI_TBL_NM,$this->Constants->T_IINKAI_MDL_NM,$this->Constants->T_IINKAI_IINKAICD,$code,$fromdt,$todt);
		} else if($masterCode == $this->Constants->M_KURABU_VAL) {
			$response = $this->getval($this->Constants->T_KURABU_TBL_NM,$this->Constants->T_KURABU_MDL_NM,$this->Constants->T_KURABU_KURABUCD,$code,$fromdt,$todt);
		}
		echo json_encode($response);exit();
	}
	public function tablestartenddate() {
		$masterCode = $this->request->data['masterCode'];
		$code = $this->request->data['code'];
		$curfromdt = date('Y-m-d', strtotime($this->request->data['fromdt']));
		if($this->request->data['todt'] == "9999/12/31") {
			$curtodt = date('Y-m-d', $this->LARGEST_DATE_STRTOTIME); //strtotime(self::getLargestDate()));
		} else {
			$curtodt = date('Y-m-d', strtotime($this->request->data['todt']));
		}
		$fromdt = date('Y-m-d', strtotime($this->request->data['dbfromdt']));
		if($this->request->data['dbtodt'] == "9999/12/31") {
			$todt = date('Y-m-d', $this->LARGEST_DATE_STRTOTIME); //strtotime(self::getLargestDate()));
		} else {
			$todt = date('Y-m-d', strtotime($this->request->data['dbtodt']));
		}
		if(isset($this->request->data['bunruicd'])) {
			$bunruicd = $this->request->data['bunruicd'];
		} else {
			$bunruicd = "";
		}
		$response = 0;
		$arr=array();
		if($masterCode == $this->Constants->M_BUNRUI_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$this->Constants->M_BUNRUI_BUNRUICD,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_BUNRUI_BUNRUICD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_SOSIKI_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SOSIKI_SOSIKICD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KEIYAKU_VAL) {
			$arr = $this->getdateval($this->Constants->T_PRKYRIREKI_TBL_NM,$this->Constants->T_PRKYRIREKI_MDL_NM,$this->Constants->T_PRKYRIREKI_KYKBN,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_PRKEIYAKU_TBL_NM,$this->Constants->T_PRKEIYAKU_MDL_NM,$this->Constants->T_PRKEIYAKU_KYKBN,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KBUNRUI_VAL) {
			$arr = $this->getdateval3($this->Constants->T_KAIGIEV_TBL_NM,$this->Constants->T_KAIGIEV_MDL_NM,$bunruicd,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval3($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$bunruicd,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KAIINSB_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KAIINSB_KAIINSBCD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KYAKU_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KYAKU_KYOUKAIYKCD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_IYAKU_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_IYAKU_IINKAIYKCD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_SYUMI_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD1,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD2,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_SYUMI_SYUMICD3,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_GYOSYU_VAL) {
			$arr = $this->getdateval($this->Constants->T_TOIAWASE_TBL_NM,$this->Constants->T_TOIAWASE_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_NYUUKAI_TBL_NM,$this->Constants->T_NYUUKAI_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAISYA_TBL_NM,$this->Constants->T_KAISYA_MDL_NM,$this->Constants->M_GYOSYU_GYOSYUCD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KONIN_vAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KONIN_KONIN,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KOUKAI_VAL) {
			$arr = $this->getdateval($this->Constants->T_KATUDO_TBL_NM,$this->Constants->T_KATUDO_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAISYA_TBL_NM,$this->Constants->T_KAISYA_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_OSIRASE_TBL_NM,$this->Constants->T_OSIRASE_MDL_NM,$this->Constants->M_KOUKAI_KOUKAIKBN,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_TODOFUKEN_VAL) {
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->T_KAIIN_UMARE,$code,$fromdt,$todt,$arr);
			$arr = $this->getdateval($this->Constants->T_KAIIN_TBL_NM,$this->Constants->T_KAIIN_MDL_NM,$this->Constants->T_KAIIN_SODATI,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_IINKAI_VAL) {
			$arr = $this->getdateval($this->Constants->T_IINKAI_TBL_NM,$this->Constants->T_IINKAI_MDL_NM,$this->Constants->T_IINKAI_IINKAICD,$code,$fromdt,$todt,$arr);
		} else if($masterCode == $this->Constants->M_KURABU_VAL) {
			$arr = $this->getdateval($this->Constants->T_KURABU_TBL_NM,$this->Constants->T_KURABU_MDL_NM,$this->Constants->T_KURABU_KURABUCD,$code,$fromdt,$todt,$arr);
		}
		usort($arr, function($a, $b) {
			$dateTimestamp1 = strtotime($a);
			$dateTimestamp2 = strtotime($b);
			return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
		});
		$fromdtstt = strtotime($curfromdt);
		$todtstt = strtotime($curtodt);
		if(isset($arr[0])) {
			$minstt = strtotime($arr[0]);
			$maxstt = strtotime($arr[count($arr) - 1]);
			if($fromdtstt <= $minstt && $todtstt >= $maxstt) {
				$response = 0;
			} else {
				$response = 1;
			}
		}
		echo json_encode($response);exit();
	}
	/**
	 *　機能名：データの取得処理
	 */
	public function getval($db_table,$table,$field,$code,$fromdt,$todt) {
		$response = 0;
		$getdtval = $this->$table->query("SELECT COUNT(*) AS CNT FROM (
											SELECT $code, LEFT(IF(kousindt = '0000-00-00 00:00:00' OR kousindt IS NULL, tourokudt, kousindt), 10) AS tou_kou_dt FROM $db_table WHERE $field = $code ) TBL
										WHERE tou_kou_dt >=  '$fromdt'
										AND tou_kou_dt <=  '$todt' ");

		if($getdtval[0][0]['CNT'] != 0) {
			$response = 1;
		}
		return $response;
	}
	public function getval3($db_table,$table,$bunruicd,$code,$fromdt,$todt) {
		$response = 0;
		$getdtval = $this->$table->query("SELECT COUNT(*) AS CNT FROM (
											SELECT $code, LEFT(IF(kousindt = '0000-00-00 00:00:00' OR kousindt IS NULL, tourokudt, kousindt), 10) AS tou_kou_dt FROM $db_table WHERE kbunruicd = $code AND bunruicd = $bunruicd) TBL
										WHERE tou_kou_dt >=  '$fromdt'
										AND tou_kou_dt <=  '$todt' ");
		if($getdtval[0][0]['CNT'] != 0) {
			$response = 1;
		}
		return $response;
	}
	public function getdateval($db_table,$table,$field,$code,$fromdt,$todt,$arr) {
		$getdtval = $this->$table->query("SELECT tou_kou_dt FROM (
											SELECT $code, LEFT(IF(kousindt = '0000-00-00 00:00:00' OR kousindt IS NULL, tourokudt, kousindt), 10) AS tou_kou_dt FROM $db_table WHERE $field = $code ) TBL
										WHERE tou_kou_dt >=  '$fromdt'
										AND tou_kou_dt <=  '$todt' ");
		foreach ($getdtval as $value ) {
			array_push($arr,$value['TBL']['tou_kou_dt']);
		}
		return $arr;
	}
	public function getdateval3($db_table,$table,$bunruicd,$code,$fromdt,$todt,$arr) {
		$getdtval = $this->$table->query("SELECT tou_kou_dt FROM (
											SELECT $code, LEFT(IF(kousindt = '0000-00-00 00:00:00' OR kousindt IS NULL, tourokudt, kousindt), 10) AS tou_kou_dt FROM $db_table WHERE kbunruicd = $code AND bunruicd = $bunruicd) TBL
										WHERE tou_kou_dt >=  '$fromdt'
										AND tou_kou_dt <=  '$todt' ");
		foreach ($getdtval as $value ) {
			array_push($arr,$value['TBL']['tou_kou_dt']);
		}
		return $arr;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoLastUp($table,$tableC,$hyojino,$bunruicd,$max_consecutive) {
		if($bunruicd == 0 ) {
			$this->$table->query(" SET @num := ($hyojino-1); UPDATE $tableC SET hyojino = @num := (@num+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' order by hyojino ASC; ");
		} else {
			$this->$table->query(" SET @num := ($hyojino-1); UPDATE $tableC SET hyojino = @num := (@num+1) WHERE bunruicd = '$bunruicd' AND hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' order by hyojino ASC; ");
		}
	}
	/**
	 *　機能名：開始日と終了日のチェック処理
	 */
	public function checkfromtodt() {
		if($this->request->data['table'] == $this->Constants->M_BUNRUI_VAL || $this->request->data['table'] == $this->Constants->M_KONIN_VAL || $this->request->data['table'] == $this->Constants->M_KOUKAI_VAL || $this->request->data['table'] == $this->Constants->M_KEIYAKU_VAL ) {
			$this->request->data['code'] = $this->request->data['code'];
		} else if($this->request->data['table'] == $this->Constants->M_KBUNRUI_VAL) {
			$this->request->data['code'] = str_pad($this->request->data['code'],3,'0',STR_PAD_LEFT);
		} else {
			$this->request->data['code'] = str_pad($this->request->data['code'],2,'0',STR_PAD_LEFT);
		}
		$table = $this->Constants->MODEL_NM[$this->request->data['table']-1];
		$code = $this->Constants->TABLE_CD_NM[$this->request->data['table']-1];
		$responseresult = "0";
		$curdate = strtotime($this->Common->getSystemDateTime());
		if($this->request->data['table'] == $this->Constants->M_KBUNRUI_VAL) {
			$getmaxtodt = $this->$table->find('first', array(
									'fields'=>array('fromdt','todt'),
									'conditions'=>array($code => $this->request->data['code'],
													'bunruicd' => $this->request->data['bunruicd']),
									'order'=>array ('todt' => 'DESC')));
		} else {
			$getmaxtodt = $this->$table->find('first', array(
									'fields'=>array('fromdt','todt'),
									'conditions'=>array($code => $this->request->data['code']),
									'order'=>array ('todt' => 'DESC')));
		}
		if(isset($getmaxtodt[$table]['todt'])) {
			if($getmaxtodt[$table]['todt'] == "9999-12-31") {
				$getmaxtodt[$table]['todt'] = date('Y-m-d', $this->LARGEST_DATE_STRTOTIME); //self::getLargestDate();
			}
			$prevfromdt = strtotime($getmaxtodt[$table]['fromdt']);
			$prevtodt = strtotime($getmaxtodt[$table]['todt']);
			$curfromdt = strtotime($this->request->data['fromdt']);
			if($prevtodt < $curdate) {
				if($curfromdt <= $prevtodt) {
					$responseresult = "1";
				}
			}
			if($prevtodt > $curdate) {
				if($curfromdt <= $prevfromdt) {
					$responseresult = "2";
				}
			}
		}
		echo json_encode($responseresult);exit();
	}
	/**
	 *　機能名：開始日と終了日のチェック処理
	 */
	public function checkfromtodtedit() {
		if($this->request->data['table'] == $this->Constants->M_BUNRUI_VAL || $this->request->data['table'] == $this->Constants->M_KONIN_VAL || $this->request->data['table'] == $this->Constants->M_KOUKAI_VAL || $this->request->data['table'] == $this->Constants->M_KEIYAKU_VAL ) {
			$this->request->data['code'] = $this->request->data['code'];
		} else if($this->request->data['table'] == $this->Constants->M_KBUNRUI_VAL) {
			$this->request->data['code'] = str_pad($this->request->data['code'],3,'0',STR_PAD_LEFT);
		} else {
			$this->request->data['code'] = str_pad($this->request->data['code'],2,'0',STR_PAD_LEFT);
		}
		$table = $this->Constants->MODEL_NM[$this->request->data['table']-1];
		$code = $this->Constants->TABLE_CD_NM[$this->request->data['table']-1];
		$responseresult = "0";
		$curdate = strtotime($this->Common->getSystemDateTime());
		$curtodt = strtotime($this->request->data['db_todt']);
		if(!$curtodt) {
			$curtodt = $this->LARGEST_DATE_STRTOTIME; //strtotime(self::getLargestDate());
		}
		$curfromdt = strtotime($this->request->data['fromdt']);
		if($curtodt < $curdate && ($this->request->data['fromdt'] != $this->request->data['db_fromdt'] || $this->request->data['todt'] != $this->request->data['db_todt']) ) {
			$getcount = $this->$table->find('all', array(
								'fields'=>array($code),
								'conditions'=>array($code => $this->request->data['code'])));
			if(count($getcount) > 1) {
				$responseresult = "1";
			}
		}
		if($curtodt >= $curdate) {
			$getprevtodt = $this->$table->find('first', array(
								'fields'=>array('fromdt','todt'),
								'conditions'=>array($code => $this->request->data['code'],
												'fromdt <' => $this->request->data['db_fromdt']),
								'order'=>array ('todt' => 'DESC')));
			if(isset($getprevtodt[$table]['todt'])) {
				$prevtodt = strtotime($getprevtodt[$table]['todt']);
				if($prevtodt >= $curfromdt && ($this->request->data['fromdt'] != $this->request->data['db_fromdt'] || $this->request->data['todt'] != $this->request->data['db_todt']) ) {
					$responseresult = "2";
				}
			}
			$getnexfromdt = $this->$table->find('first', array(
								'fields'=>array('fromdt','todt'),
								'conditions'=>array($code => $this->request->data['code'],
												'fromdt >' => $this->request->data['db_fromdt'])));
			if(isset($getnexfromdt[$table]['fromdt'])) {
				$nextfromdt = strtotime($getnexfromdt[$table]['fromdt']);
				$curentodt = strtotime($this->request->data['todt']);
				if($nextfromdt <= $curentodt && ($this->request->data['fromdt'] != $this->request->data['db_fromdt'] || $this->request->data['todt'] != $this->request->data['db_todt']) ) {
					$responseresult = "3";
				}
			}
		}
		echo json_encode($responseresult);exit();
	}
}