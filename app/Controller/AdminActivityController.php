<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Common');
/**
 * 活動カレンダー一覧 Controller
 *
 * 活動カレンダー一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminActivityController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MSosiki', 'MKbunrui', 'TKatudo', 'MKoukai' ,'TSyasin','MTuuci','MBunrui','MKurabu','MKaiinsb','TKaiin','TEntry','TKaigiev','TKaisya');
	// レイアウト無し
	public $autoLayout = false;
	/**
	 *　画面名：活動カレンダー 新規追加
	 *　機能名：活動カレンダー 新規追加
	 */
	public function add() {
		if ($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if ($_SESSION['Auth']['User']['Menu']['katsudoAdd'] == $this->Constants->HYOJI) {
				if (!empty ( $this->request->data )) {
					// ページで表示するため、データを設定する。
					$event = $this->TKatudo->find ( 'first' ,array(
							'conditions'=>array (
									'TKatudo.arno ' => $this->request->data ['shosaiShutokuFrm']['arno'])));
					if ($event['TKatudo']['teiin'] == 0) { 
						$event['TKatudo']['teiin'] = "";
					}
					if ($event['TKatudo']['kigendate'] == "0000-00-00") {
						$event['TKatudo']['kigendate'] = "";
					}
					if ($event['TKatudo']['kigentm'] == "00:00:00") {
						$event['TKatudo']['kigentm'] = "";
					}
					$event = $event['TKatudo'];
					$event['hdn_arno'] = $this->request->data ['shosaiShutokuFrm']['arno'];
					$event['hdn_bunruicd'] = $event['bunruicd'];
					$event['hdn_sosikicd'] = $this->request->data ['shosaiShutokuFrm']['sosikinm'];
					$event['hdn_kbunruicd'] = $this->request->data ['shosaiShutokuFrm']['kbunruinm'];
					$event['hdn_kaisaidate'] = $event['kaisaidate'];
					$event['hdn_kaisaitmfrom'] = $event['kaisaitmfrom'];
					$event['hdn_kaisaitmto'] = $event['kaisaitmto'];
					// 会議種別名称のセット
					$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
					// イベント種別名称のセット
					$this->set('kbunruinm', $this->Common->getEventShubetsu($this->MKbunrui, $event['bunruicd']));
					$this->set ( 'event_shousai',$event);
					// ページで条件を使うため、研修会の値を設定する。
					$this->set ( 'Kenshukai', $this->Constants->KENSHUKAI );
					// ページで条件を使うため、見学会の値を設定する。
					$this->set ( 'kengakukai', $this->Constants->KENGAKUKAI );
					// ページで条件を使うため、講演会の値を設定する。
					$this->set ( 'kouenkai', $this->Constants->KOUENKAI );
					//// ページで条件を使うため、交流イベントの値を設定する。
					$this->set ( 'kouryuuibento', $this->Constants->KOURYUUIBENTO );
					// 会議を探すの初期表示
					$this->set ( 'selectedsosikinm', $this->request->data['shosaiShutokuFrm'] ['sosikinm'] );
					// イベントを探すの初期表示
					$this->set ( 'selectedKbunruinm', $this->request->data ['shosaiShutokuFrm']['kbunruinm'] );
					$this->set('inval', $this->Constants->INVAL);
					$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
					$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
					$this->set('bunruilist',$bunruilist);
					$this->set('bunruicd', $event['hdn_bunruicd']);
					// 画面の移動。
					$this->render('/Admin/Activity/add');
				} else {
					// 会議種別名称のセット
					$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
					// イベント種別名称のセット
					$this->set('kbunruinm', $this->Common->getEventShubetsuKaigi($this->MKbunrui));
					// 会議を探すの初期表示
					$this->set('selectedsosikinm', '');
					// イベントを探すの初期表示
					$this->set('selectedKbunruinm', '');
					$this->set('inval', $this->Constants->INVAL);
					$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
					if(!$this->Session->read('errorMsg.errorflag')){
						$this->Session->delete('errorMsg');
					}
				 	$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
					$this->set('bunruilist',$bunruilist);
					$this->set('bunruicd', '');
					$this->Session->write("errorMsg.errorflag",false);
					$this->set('ValidateAjay',array());
					// 画面の移動
					$this->render('/Admin/Activity/add');
				}
			}else{
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
	 *　画面名： 活動カレンダー一覧
	 *　機能名： 活動カレンダー一覧の表示
	 */
	public function calender() {
		if ($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if ($_SESSION['Auth']['User']['Menu']['katsudoCalList'] == $this->Constants->HYOJI) {
				// 会議種別名称のセット
				$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
				// イベント種別名称のセット
				$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
				// 会議を探すの初期表示
				$this->set('selectedsosikinm', '');
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', '');
				// 活動情報 テーブルから検索
				$this->set('katoinfo', '');
				// 画面の移動	
				$this->render('/Admin/Activity/calender');
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
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
	 *　画面名：活動カレンダー一覧
	 *　機能名：検索処理
	 */
	public function search() {
	
		if ($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$srchcondition = "";
			//  activity calendar list search condition
			if (isset($this->request->data['katsudoModoruFrm']['srch']) && !empty($this->request->data['katsudoModoruFrm']['srch'])) {
				$this->request->data['MSosiki']['srch'] = $this->request->data['katsudoModoruFrm']['srch'];
			}

			if(isset($this->request->data['MSosiki']['srch'])){
				$this->Session->write("srchcondition",$this->request->data['MSosiki']['srch']);
				$srchcondition = $this->Session->read('srchcondition');
			}
			$del_activity = $this->Session->read('del_activity');
			$this->Session->delete('del_activity');
			if (isset($this->request->data['katsudoModoruFrm'])) {
				if ($this->request->data['katsudoModoruFrm']['hdn_bunruicd'] == 1) {
					$this->request->data['MSosiki']['sosikinm'] = $this->request->data['katsudoModoruFrm']['hdn_sosikicd'];
					$hdn_searchback = 1;
				} else if ($this->request->data['katsudoModoruFrm']['hdn_bunruicd'] == 2) {
					$this->request->data['MSosiki']['kbunruinm'] = $this->request->data['katsudoModoruFrm']['hdn_kbunruicd'];
					$this->request->data['MSosiki']['sosikinm'] = "";
					$hdn_searchback = 2;
				} else {
					$hdn_searchback = "";
				} 
			} else {
				$hdn_searchback = 0;
			}
			if ($_SESSION['Auth']['User']['Menu']['katsudoCalList'] == $this->Constants->HYOJI) {
				if (!$this->Session->read('Auth.User.katsudoDel.sessionFlg')) {
					$this->Session->delete('Auth.User.katsudoDel');
				}
				$this->Session->write("Auth.User.katsudoDel.sessionFlg",false);
				// 会議種別名称のセット
				$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
				// イベント種別名称のセット
				$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
				$conditions = array();
				// 会議を探すクリックの場合
				if (array_key_exists('kaigibtn', $this->request->data) || !empty($this->Session->read('Auth.User.katsudoDel.sosikinm')) || $hdn_searchback == 1 || $del_activity == 1 ) {
					if (!empty($this->request->data['MSosiki']['sosikinm'])) {
						$this->set('selectedKbunruinm', '');
						$this->set('selectedsosikinm', $this->request->data['MSosiki']['sosikinm']);
						$sosikinm = $this->request->data['MSosiki']['sosikinm'];
						$conditions = array (
												'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
												'TKatudo.sosikicd ' => $sosikinm ,
												'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else if (!empty($this->Session->read('Auth.User.katsudoDel.sosikinm' ))) {
						$this->set('selectedKbunruinm', '');
						$this->set('selectedsosikinm', $this->Session->read('Auth.User.katsudoDel.sosikinm'));
						$sosikinm = $this->Session->read('Auth.User.katsudoDel.sosikinm');
						$conditions = array (
												'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
												'TKatudo.sosikicd ' => $sosikinm ,
												'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else if ( $hdn_searchback == 1 && !empty($this->request->data['MSosiki']['sosikinm']) ) {
						$this->set('selectedKbunruinm', '');
						$this->set('selectedsosikinm', $this->request->data['MSosiki']['sosikinm']);
						$sosikinm = $this->request->data['MSosiki']['sosikinm'];
						$conditions = array (
												'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
												'TKatudo.sosikicd ' => $sosikinm ,
												'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else {
						$this->set('selectedKbunruinm', '');
						$this->set('selectedsosikinm', '');
						$conditions = array (
												'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
												'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					}
					// 活動情報 テーブルから検索
					$query = $this->TKatudo->find('all', array(
											'joins' => array( 
													array(
														'table' => $this->MSosiki,
														'alias' => 'mkbun',
														'type' => 'LEFT',
														'conditions' => array(
															'mkbun.sosikicd = TKatudo.sosikicd',
															'mkbun.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
															'mkbun.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))')),
													array(
														'table' => $this->MKoukai,
														'alias' => 'mkou',
														'type' => 'LEFT',
														'conditions' => array(
															'mkou.koukaicd = TKatudo.koukaikbn',
															'mkou.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
															'mkou.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))'))
											),
											'fields' => array(			
													'TKatudo.arno',
													'TKatudo.bunruicd',
													'TKatudo.sosikicd',
													'TKatudo.kbunruicd',
													'TKatudo.kaisaidate',
													'TKatudo.kaisaitmfrom',
													'TKatudo.kaisaitmto',
													'TKatudo.hyoudai',
													'TKatudo.meisyou',
													'mkou.koukainm',
													'mkbun.sosikinm'
													),
											'conditions' => $conditions,
											'order'=>array (
												'TKatudo.kaisaidate' => 'DESC',
												'TKatudo.kaisaitmfrom' => 'DESC',
												'TKatudo.kaisaitmto' => 'DESC')));
					$cnt=count($query);
					if ($cnt==0) {
						$this->Session->setFlash($this->Constants->SEARCH_NOT_FOUND);
					}
					$this->set('katoinfo', $query);
				// イベントを探すクリックの場合
				} else if ((array_key_exists('eventbtn', $this->request->data)) || !empty($this->Session->read('Auth.User.katsudoDel.Kbunruinm'))  || $hdn_searchback == 2 || $del_activity == 2 ) {
					if (!empty($this->request->data['MSosiki']['kbunruinm'])) {
						//会議を探すの初期表示
						$this->set('selectedsosikinm', '');
						$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
						$kbunruicd = $this->request->data['MSosiki']['kbunruinm'];
						$conditions = array (
											'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
											'TKatudo.kbunruicd' => $kbunruicd ,
											'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else if (!empty($this->Session->read('Auth.User.katsudoDel.Kbunruinm' ))) {
						//会議を探すの初期表示
						$this->set('selectedsosikinm', '');
						$this->set('selectedKbunruinm', $this->Session->read('Auth.User.katsudoDel.Kbunruinm'));
						$kbunruicd = $this->Session->read('Auth.User.katsudoDel.Kbunruinm');
						$conditions = array (
											'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
											'TKatudo.kbunruicd' => $kbunruicd ,
											'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else if ( $hdn_searchback == 1 && !empty($this->request->data['MSosiki']['Kbunruinm']) ) {
						//会議を探すの初期表示
						$this->set('selectedsosikinm', '');
						$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
						$kbunruicd = $this->request->data['MSosiki']['kbunruinm'];
						$conditions = array (
											'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
											'TKatudo.kbunruicd' => $kbunruicd ,
											'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					} else {
						$this->set('selectedsosikinm', '');
						$this->set('selectedKbunruinm','');
						$conditions = array (
											'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
											'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate());
					}
					$query = $this->TKatudo->find('all', array(
									'joins' => array(
											array(
												'table' => $this->MKbunrui,
												'alias' => 'mkbun',
												'type' => 'LEFT',
												'conditions' => array(
													'mkbun.kbunruicd = TKatudo.kbunruicd',
													'mkbun.bunruicd' => ConstantsComponent::$EVENT_CD,
													'mkbun.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
													'mkbun.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))')),
											array(
												'table' => $this->MKoukai,
												'alias' => 'mkou',
												'type' => 'LEFT',
												'conditions' => array(
													'mkou.koukaicd = TKatudo.koukaikbn',
													'mkou.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
													'mkou.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))'))
									),
									'fields' => array(
											'TKatudo.arno',
											'TKatudo.bunruicd',
											'TKatudo.sosikicd',
											'TKatudo.kbunruicd',
											'TKatudo.kaisaidate',
											'TKatudo.kaisaitmfrom',
											'TKatudo.kaisaitmto',
											'TKatudo.hyoudai',
											'TKatudo.meisyou',
											'mkou.koukainm',
											'mkbun.kbunruinm'
									),
									'conditions' => $conditions,
									'order'=>array (
											'TKatudo.kaisaidate' => 'DESC',
											'TKatudo.kaisaitmfrom' => 'DESC',
											'TKatudo.kaisaitmto' => 'DESC')));
			 		$cnt=count($query);
					if ($cnt==0) {
						$this->Session->setFlash($this->Constants->SEARCH_NOT_FOUND);
					}
					$this->set('katoinfo', $query);
				// 初期表示
				} else {
					// 活動情報 テーブルから検索
					$this->set('katoinfo','');
					// 会議を探すの初期表示
					$this->set('selectedsosikinm', '');
					// イベントを探すの初期表示
					$this->set('selectedKbunruinm', '');
					$this->Session->setFlash($this->Constants->SEARCH_NOT_FOUND);
				}
				//　画面の移動
				$this->render('/Admin/Activity/calender');
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
			$this->set('srchcondition',$srchcondition);
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名： 活動カレンダー 編集
	 *　機能名： 活動カレンダー 編集
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if ($_SESSION['Auth']['User']['Menu']['katsudoCalList'] == $this->Constants->HYOJI) {
				if (!empty ( $this->request->data )) {
					// ページで表示するため、データを設定する。
					$event = $this->TKatudo->find ( 'first' ,array(
							'conditions'=>array (
									'TKatudo.arno ' => $this->request->data ['shosaiShutokuFrm']['arno'])));
					if ($event['TKatudo']['teiin'] == 0) { 
						$event['TKatudo']['teiin'] = "";
					}
					if ($event['TKatudo']['kigendate'] == "0000-00-00") {
						$event['TKatudo']['kigendate'] = "";
					}
					if ($event['TKatudo']['kigentm'] == "00:00:00") {
						$event['TKatudo']['kigentm'] = "";
					}
					$event = $event['TKatudo'];
					$event['hdn_arno'] = $this->request->data ['shosaiShutokuFrm']['arno'];
					$event['hdn_bunruicd'] = $event['bunruicd'];
					$event['hdn_sosikicd'] = $this->request->data ['shosaiShutokuFrm']['sosikinm'];
					$event['hdn_kbunruicd'] = $this->request->data ['shosaiShutokuFrm']['kbunruinm'];
					$event['hdn_kaisaidate'] = $event['kaisaidate'];
					$event['hdn_kaisaitmfrom'] = $event['kaisaitmfrom'];
					$event['hdn_kaisaitmto'] = $event['kaisaitmto'];
					// 会議種別名称のセット
					$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
					// イベント種別名称のセット
					$this->set('kbunruinm', $this->Common->getEventShubetsu($this->MKbunrui, $event['bunruicd']));
					$this->set ( 'event_shousai',$event);
					// ページで条件を使うため、研修会の値を設定する。
					$this->set ( 'Kenshukai', $this->Constants->KENSHUKAI );
					// ページで条件を使うため、見学会の値を設定する。
					$this->set ( 'kengakukai', $this->Constants->KENGAKUKAI );
					// ページで条件を使うため、講演会の値を設定する。
					$this->set ( 'kouenkai', $this->Constants->KOUENKAI );
					//// ページで条件を使うため、交流イベントの値を設定する。
					$this->set ( 'kouryuuibento', $this->Constants->KOURYUUIBENTO );
					// 会議を探すの初期表示
					$this->set ( 'selectedsosikinm', $this->request->data['shosaiShutokuFrm'] ['sosikinm'] );
					// イベントを探すの初期表示
					$this->set ( 'selectedKbunruinm', $this->request->data ['shosaiShutokuFrm']['kbunruinm'] );
					// 画面の移動。
					$this->set('inval', $this->Constants->INVAL);
					$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
					$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
					$this->set('bunruilist',$bunruilist);
					$this->set('bunruicd', $event['hdn_bunruicd']);
					//　画面の移動
					$this->render('/Admin/Activity/edit');
				} else {
					// 要求が空白の場合、コントローラの動作をリダイレクトする。
					$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				}
			} else {
				$this->redirect([
						'controller' => 'admin',
						'action' => 'logout'
				]);
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
	 *　画面名：活動カレンダー一覧
	 *　機能名：削除処理
	 */
	public function delete() {
		try {
			$responseString = "0";
			if ($_SESSION['Auth']['User']['Menu']['katsudoCalList'] == $this->Constants->HYOJI) {
				$arno = $this->request->data['arno'];
				$filedata = $this->TKatudo->find ( 'first', array (
					'fields' => array('TKatudo.bunruicd'),
					'conditions' => array ('arno ' => $arno )
				));
				$this->TKatudo->delete( $arno );
				$responseString = "1";
				echo $responseString;
				exit();
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
	 *　画面名： 活動カレンダー一覧 編集
	 *　機能名： 活動カレンダー一覧 編集
	 */
	public function update() {
		try {
			$db_TKatudo = $this->TKatudo->getDataSource();
			$db_TKatudo->begin();
			$responseString = "";
			if ($_SESSION['Auth']['User']['Menu']['katsudoCalList'] == $this->Constants->HYOJI) {
				$systemDateTime = $this->Common->getSystemDateTime();
				$responseString = $this->textarea_maxlength("basyo",$this->request->data['basyo'],100,$responseString);
				$responseString = $this->textarea_maxlength("naiyou",$this->request->data['naiyou'],1024,$responseString);
				$responseString = $this->textarea_maxlength("gidai",$this->request->data['gidai'],255,$responseString);
				$responseString = $this->textarea_maxlength("kousi",$this->request->data['kousi'],100,$responseString);
				$responseString = $this->textarea_maxlength("taisyou",$this->request->data['taisyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("teiincom",$this->request->data['teiincom'],60,$responseString);
				$responseString = $this->textarea_maxlength("hiyou",$this->request->data['hiyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("syugoubasyo",$this->request->data['syugoubasyo'],255,$responseString);
				$responseString = $this->textarea_maxlength("bikou",$this->request->data['bikou'],1024,$responseString);
				$responseString = substr($responseString, 2);
				// データ設定
				$data['bunruicd'] =  $this->request->data['bunruicd'];
				$data['koukaikbn'] =  $this->request->data['koukaikbn'];
				if(isset($this->request->data['taisyoukbn'])) {
					$data['taisyoukbn'] =  $this->request->data['taishoukbn'];
				} else {
					$data['taisyoukbn'] = 1;
				}
				if(isset($this->request->data['teiin']) && $this->request->data['teiin'] != "") {
					$data['teiin'] =  $this->request->data['teiin'];
				} else {
					$data['teiin'] = 0;
				}
				$data['taishoukbn'] =  $this->request->data['taishoukbn'];
				if(!isset($this->request->data['taishoukbn'])) {
						$data['taishoukbn'] = 1;
				}
				$data['arno'] = $this->request->data['hdn_arno'];
				$data['bunruicd'] = $this->request->data['bunruicd'];
				$data['sosikicd'] = $this->request->data['sosikicd'];
				$data['kbunruicd'] = $this->request->data['kbunruicd'];
				$data['kaisaidate'] = $this->request->data['kaisaidate'];
				$data['kaisaitmfrom'] = $this->request->data['kaisaitmfrom'];
				$data['kaisaitmto'] = $this->request->data['kaisaitmto'];
				$data['hyoudai'] = $this->request->data['hyoudai'];
				$data['meisyou'] = $this->request->data['meisyou'];
				$data['basyo'] = $this->request->data['basyo'];
				$data['naiyou'] = $this->request->data['naiyou'];
				$data['gidai'] = $this->request->data['gidai'];
				$data['kousi'] = $this->request->data['kousi'];
				$data['taisyou'] = $this->request->data['taisyou'];
				$data['teiincom'] =  $this->request->data['teiincom'];
				$data['hiyou'] = $this->request->data['hiyou'];
				$data['syugoubasyo'] = $this->request->data['syugoubasyo'];
				$data['kigendate'] = $this->request->data['kigendate'];
				$data['kigentm'] = $this->request->data['kigentm'];
				$data['bikou'] = $this->request->data['bikou'];
				$data['koukaikbn'] = $this->request->data['koukaikbn'];
				$data['taisyoukbn'] = $this->request->data['taishoukbn'];
				$data['kousincd'] =  $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
				$data['kousindt'] =  $systemDateTime;
				$this->TKatudo->set($data);
				if ($this->TKatudo->validates() && $responseString == "") {
					// 更新処理
					if (!$this->TKatudo->save($data)) {
						throw new Exception();
					}
					if($this->request->data['koukaikbn'] == 0) {
						if ($this->request->data['hdn_soushin'] == 1) {
							// 更新通知メールの受取へメール送信
							$uketoriMailInfo = $this->Common->getUketoriMailInfo($this->TKaiin);
							if (!empty($uketoriMailInfo)) {
								$uketoriMailInfoArray = array();
								foreach($uketoriMailInfo as $value) {
									if($value['TKaiin']['mailaddr'] != "" && $value['TKaiin']['mailaddr'] != null){
										$uketoriMailInfoArray[] = $value['TKaiin']['mailaddr'];
									}
								}
								$mailInfo = $this->Common->getMailInfo($this->MTuuci);
								if (!empty($mailInfo)) {
									if (!empty($mailInfo['0']['MTuuci']['mailaddrsend'])) {
										$from = $mailInfo['0']['MTuuci']['mailaddrsend'];
										$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,1);
									}
								}
							}
						}
					}
					if(!empty($this->request->data['mailcheck'])) {
						//事務局へメール送信
						$mailInfo=$this->Common->getMailInfo($this->MTuuci);
						if (!empty($mailInfo)) {
							if(isset($data['kbunruicd']) && !empty($data['kbunruicd'])) {
								$filedata = $this->MKurabu->find ( 'first', array (
									'fields' => array('MKurabu.mailaddr'),
									'conditions' => array ('MKurabu.kurabucd ' => $data['kbunruicd'])
								));
							}
							$data['hyoudai'] = $this->request->data['hyoudai'];
							$data['kaisaidate'] = $this->request->data['kaisaidate'];
							$data['kaisaitmfrom'] = $this->request->data['kaisaitmfrom'];
							$data['kaisaitmto'] = $this->request->data['kaisaitmto'];
							$data['meisyou'] = $this->request->data['meisyou'];
							$data['basyo'] = $this->request->data['basyo'];
							$systemDateTime=$this->Common->getSystemDateTime();
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
								$subject_mail = '【確認・通知】' . $data['hyoudai'];
								$msg_mail = $this->mailTextupdate($data, $systemDateTime);
								$mail = new CakeEmail('smtp');
								$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
								$mail->to($allmailaddrs);
								if (isset($data['kbunruicd']) && !empty($data['kbunruicd']) && !empty($filedata['MKurabu']['mailaddr'])) {
									$mail->cc($filedata['MKurabu']['mailaddr']);
								}
								$mail->subject($subject_mail);
								$mail->emailFormat('html');
								$mail->send($msg_mail);
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TKatudo->validationErrors;
					$errCount = count($errors);
					$idx=0;
					foreach($errors as $feild => $messages) {
						if ($responseString != "") {
							$responseString .= "$$";
						}
						$responseString .= $feild."##".$messages[0];
						$idx++;
						if ($idx < $errCount) {
							$responseString .= "$$";
						}
					}
					echo $responseString;
				}
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
			$db_TKatudo->commit();
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 *　画面名：活動カレンダー一覧 新規追加
	 *　機能名：活動カレンダー一覧の 新規追加処理
	 */
	public function register() {
		try {
			$db_TKatudo = $this->TKatudo->getDataSource();
			$db_TKatudo->begin();
			$responseString = "";
			if ($_SESSION['Auth']['User']['Menu']['katsudoAdd'] == $this->Constants->HYOJI) {
				$systemDateTime=$this->Common->getSystemDateTime();
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$data = $this->request->data;
				$data['bikou'] = $data['bikou'];
				$data['naiyou'] = $data['naiyou'];
				$data['taisyoukbn'] = $data['taishoukbn'];
				$data['tourokudt'] =  $systemDateTime;
				$data['tourokucd'] =  $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
				$responseString = $this->textarea_maxlength("basyo",$data['basyo'],100,$responseString);
				$responseString = $this->textarea_maxlength("naiyou",$data['naiyou'],1024,$responseString);
				$responseString = $this->textarea_maxlength("gidai",$data['gidai'],255,$responseString);
				$responseString = $this->textarea_maxlength("kousi",$data['kousi'],100,$responseString);
				$responseString = $this->textarea_maxlength("taisyou",$data['taisyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("teiincom",$data['teiincom'],60,$responseString);
				$responseString = $this->textarea_maxlength("hiyou",$data['hiyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("syugoubasyo",$data['syugoubasyo'],255,$responseString);
				$responseString = $this->textarea_maxlength("bikou",$data['bikou'],1024,$responseString);
				$responseString = substr($responseString, 2);
				// 定員
				if(!isset($data['teiin']) || $data['teiin'] == "") {
					$data['teiin'] = 0;
				}
				$this->TKatudo->set($data);
				if ($this->TKatudo->validates() && $responseString == "") {
					$this->TKatudo->create();
					if (!$this->TKatudo->save($data)) {
						throw new Exception();
					}
					if($this->request->data['koukaikbn'] == 0) {
						if ($this->request->data['hdn_soushin'] == 1) {
							// 更新通知メールの受取へメール送信
							$uketoriMailInfo = $this->Common->getUketoriMailInfo($this->TKaiin);
							if (!empty($uketoriMailInfo)) {
								$uketoriMailInfoArray = array();
								foreach($uketoriMailInfo as $value) {
									if($value['TKaiin']['mailaddr'] != "" && $value['TKaiin']['mailaddr'] != null){
										$uketoriMailInfoArray[] = $value['TKaiin']['mailaddr'];
									}
								}
								$mailInfo = $this->Common->getMailInfo($this->MTuuci);
								if (!empty($mailInfo)) {
									if (!empty($mailInfo['0']['MTuuci']['mailaddrsend'])) {
										$from = $mailInfo['0']['MTuuci']['mailaddrsend'];
										$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,1);
									}
								}
							}
						}
					}
					if (!empty($this->request->data['mailcheck'])) {
						//事務局へメール送信
						$mailInfo=$this->Common->getMailInfo($this->MTuuci);
						if (!empty($mailInfo)) {
							if(isset($data['kbunruicd']) && !empty($data['kbunruicd'])) {
								$filedata = $this->MKurabu->find ( 'first', array (
									'fields' => array('MKurabu.mailaddr'),
									'conditions' => array ('MKurabu.kurabucd ' => $data['kbunruicd'])
								));
							}
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
								$subject_mail = '【確認・通知】' . $data['hyoudai'];
								$msg_mail = $this->mailText($data, $systemDateTime);
								$mail = new CakeEmail('smtp');
								$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
								$mail->to($allmailaddrs);
								if (isset($data['kbunruicd']) && !empty($data['kbunruicd']) && !empty($filedata['MKurabu']['mailaddr'])) {
									$mail->cc($filedata['MKurabu']['mailaddr']);
								}
								$mail->subject($subject_mail);
								$mail->emailFormat('html');
								$mail->send($msg_mail);
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TKatudo->validationErrors;
					$errCount = count($errors);
					$idx=0;
					if ($responseString != "") {
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
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
			$db_TKatudo->commit();
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 *　画面名： 活動報告一覧
	 *　機能名： 活動報告一覧
	 */
	public function report() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		if (! $this->Session->read ( 'errorMsg.errorflag' )) {
			$this->Session->delete ( 'errorMsg' );
		}
		$this->Session->write ( "errorMsg.errorflag", false );
		try {
			if ($_SESSION['Auth']['User']['Menu']['katsudoHokokuList'] == $this->Constants->HYOJI){
				// 会議種別名称のセット
				$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
				// イベント種別名称のセット
				$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
				// 会議を探すの初期表示
				$this->set('selectedsosikinm', '');
				$this->set('koushindt1', '');
				$this->set('koushindt2', '');
				$this->set('eventdt1', '');
				$this->set('eventdt2', '');
				$this->set('searchcon', '');
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', '');
				// 画面の移動
				$this->render('/Admin/Activity/report');
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
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
	 *　画面名：活動報告一覧検索
	 *　機能名：活動報告一覧検索処理
	 */
	public function activityReportSearch() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if($this->Session->check('previousPageInforeport')) {
				$this->request->data= $this->Session->read('previousPageInforeport');
				$this->Session->delete('previousPageInforeport');
			}
			if(!isset($this->request->data['MSosiki']) && !isset($this->request->data['searchcon'])) {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
			if (! $this->Session->read ( 'errorMsg.errorflag' )) {
				$this->Session->delete ( 'errorMsg' );
			}
			$this->Session->write ( "errorMsg.errorflag", false );
			if(isset($this->request->data['searchcon'])) {
				$this->request->data['MSosiki']['searchcon'] = $this->request->data['searchcon'];
				$this->request->data['MSosiki']['kbunruinm'] = $this->request->data['kbunruinm'];
				$this->request->data['MSosiki']['sosikinm'] = $this->request->data['sosikinm'];
			} else if(!isset($this->request->data['MSosiki']['searchcon'])) {
				$this->request->data['kaigiFrom'] = $this->request->data['MSosiki']['kaigiFrom'];
				$this->request->data['kaigiTo'] = $this->request->data['MSosiki']['kaigiTo'];
				$this->request->data['eventFrom'] = $this->request->data['MSosiki']['eventFrom'];
				$this->request->data['eventTo'] = $this->request->data['MSosiki']['eventTo'];
				$this->request->data['MSosiki']['searchcon'] = $this->request->data['MSosiki']['searchcons'];
			}
			if ($_SESSION['Auth']['User']['Menu']['katsudoHokokuList'] == $this->Constants->HYOJI){
				if (!$this->Session->read('Auth.User.katsudoReportDel.sessionFlg')) {
					$this->Session->delete('Auth.User.katsudoReportDel');
				}
				$this->Session->write("Auth.User.katsudoReportDel.sessionFlg",false);
				// 会議種別名称のセット
				if (!empty($this->request->data) || !$this->Session->read('Auth.User.katsudoReportDel.sessionFlg')) {
					if (!empty($this->request->data['kaigiFrom']) || !empty($this->Session->read('Auth.User.katsudoReportDel.kaigiFrom'))) {
						if (!empty($this->request->data['kaigiFrom'])) {
							$koushindt1 = $this->request->data['kaigiFrom'];
							$st_date = $this->Common->fromDate(str_replace('/','-',$this->request->data['kaigiFrom']));
						} else {
							$koushindt1 = $this->Session->read('Auth.User.katsudoReportDel.kaigiFrom');
							$st_date = $this->Common->fromDate(str_replace('/','-',$this->Session->read('Auth.User.katsudoReportDel.kaigiFrom')));
						}
					} else {
						$koushindt1 = '';
						$st_date = '';
					}
					if (!empty($this->request->data['kaigiTo']) || !empty($this->Session->read('Auth.User.katsudoReportDel.kaigiTo'))) {
						if (!empty($this->request->data['kaigiTo'])) {
							$koushindt2 = $this->request->data['kaigiTo'];
							$en_date = $this->Common->getLastDateOfMonth(str_replace('/','-',$this->request->data['kaigiTo']));
						} else {
							$koushindt2 = $this->Session->read('Auth.User.katsudoReportDel.kaigiTo');
							$en_date = $this->Common->getLastDateOfMonth(str_replace('/','-',$this->Session->read('Auth.User.katsudoReportDel.kaigiTo')));
						}
					} else {
						$koushindt2 = '';
						$en_date = '';
					}
					if (!empty($this->request->data['eventFrom']) || !empty($this->Session->read('Auth.User.katsudoReportDel.eventFrom'))) {
						if (!empty($this->request->data['eventFrom'])) {
							$eventdt = $this->request->data['eventFrom'];
							$st_date1 = $this->Common->fromDate(str_replace('/','-',$this->request->data['eventFrom']));
						} else {
							$eventdt = $this->Session->read('Auth.User.katsudoReportDel.eventFrom');
							$st_date1 = $this->Common->fromDate(str_replace('/','-',$this->Session->read('Auth.User.katsudoReportDel.eventFrom')));
						}
					} else {
						$eventdt = '';
						$st_date1 = '';
					}
					if (!empty($this->request->data['eventTo']) || !empty($this->Session->read('Auth.User.katsudoReportDel.eventTo'))) {
						if (!empty($this->request->data['eventTo'])) {
							$eventdt1 = $this->request->data['eventTo'];
							$en_date1 = $this->Common->getLastDateOfMonth(str_replace('/','-',$this->request->data['eventTo']));
						} else {
							$eventdt1 = $this->Session->read('Auth.User.katsudoReportDel.eventTo');
							$en_date1 = $this->Common->getLastDateOfMonth(str_replace('/','-',$this->Session->read('Auth.User.katsudoReportDel.eventTo')));
						}
					} else {
						$eventdt1 = '';
						$en_date1 = '';
					}
					$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
					// イベント種別名称のセット
					$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
					$this->set('selectedsosikinm','');
					$this->set('eventdt1', $eventdt);
					$this->set('eventdt2', $eventdt1);
					$this->set('koushindt1', $koushindt1);
					$this->set('koushindt2', $koushindt2);
					$this->set('searchcon', $this->request->data['MSosiki']['searchcon']);
					// 会議を探すクリックの場合
					if ($this->request->data['MSosiki']['searchcon'] == '1') {
						if (!empty($this->request->data['MSosiki']['sosikinm'])) {
							$sosikinm = $this->request->data['MSosiki']['sosikinm'];
						} else {
							$sosikinm = $this->Session->read('Auth.User.katsudoReportDel.sosikinm');
						}
						$conditions = array();
						if(!empty($this->request->data['MSosiki']['sosikinm'])){
							$conditions[] = array(
									'TKatudo.sosikicd ' => $sosikinm);
						}						
						if(!empty($st_date)){
							$conditions[] = array(
									'TKatudo.kaisaidate >=' =>$st_date);
						}
						if(!empty($en_date)){
							$conditions[] = array(
									'TKatudo.kaisaidate <=' =>$en_date);
						}
						$conditions[] = array(
								'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD);
						
						$conditions[] = array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => 
										array($this->Common->twoYearBeforeDate(), $this->Common->getYesterdayDate())));
						//活動情報 テーブルから検索
						$query = $this->TKatudo->find('all', array(
								'joins' => array(
										array(
												'table' => $this->MSosiki,
												'alias' => 'mkbun',
												'type' => 'LEFT',
												'conditions' => array(
														'mkbun.sosikicd = TKatudo.sosikicd',
														'mkbun.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
														'mkbun.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))')),
										array(
												'table' => $this->MKoukai,
												'alias' => 'mkou',
												'type' => 'LEFT',
												'conditions' => array(
														'mkou.koukaicd = TKatudo.koukaikbn',
														'mkou.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
														'mkou.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))'))
								),
								'fields' => array(
										'TKatudo.arno',
										'TKatudo.bunruicd',
										'TKatudo.sosikicd',
										'TKatudo.kbunruicd',
										'TKatudo.kaisaidate',
										'TKatudo.kaisaitmfrom',
										'TKatudo.kaisaitmto',
										'TKatudo.hyoudai',
										'TKatudo.meisyou',
										'TKatudo.koukaikbn',
										'TKatudo.syasinkey',
										'mkou.koukainm',
										'mkbun.sosikinm'
								),
								'conditions' => $conditions,
								'order'=>array (
										'TKatudo.kaisaidate' => 'DESC',
										'TKatudo.kaisaitmfrom' => 'DESC',
										'TKatudo.kaisaitmto' => 'DESC')));
						// 会議を探すの初期表示
						$this->set('selectedsosikinm', $this->request->data['MSosiki']['sosikinm']);
						$this->set('selectedKbunruinm', '');
						$cnt=count($query);
						if ($cnt==0) {
							$this->Session->setFlash($this->Constants->SEARCH_NOT_FOUND);
						}
						$this->set('katoinfo', $query);
					// イベントを探すクリックの場合
					} else if ($this->request->data['MSosiki']['searchcon'] == '2') {
						if (isset($this->request->data['MSosiki']['kbunruinm'])) {
							$kbunruicd = $this->request->data['MSosiki']['kbunruinm'];
						} else {
							$kbunruicd = $this->Session->read('Auth.User.katsudoReportDel.kbunruinm');
						}
						$conditions = array();
						if(!empty($this->request->data['MSosiki']['kbunruinm'])){
							$conditions[] = array(
									'TKatudo.kbunruicd ' => $kbunruicd);
						}
						if(!empty($st_date1)){
							$conditions[] = array(
									'TKatudo.kaisaidate >=' =>$st_date1);
						}
						if(!empty($en_date1)){
							$conditions[] = array(
									'TKatudo.kaisaidate <=' =>$en_date1);
						}
						$conditions[] = array(
								'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD);
						
						$conditions[] = array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' =>
								array($this->Common->twoYearBeforeDate(), $this->Common->getYesterdayDate())));
						// 活動情報 テーブルから検索
						$query = $this->TKatudo->find('all', array(
								'joins' => array(
										array(
												'table' => $this->MKbunrui,
												'alias' => 'mkbun',
												'type' => 'LEFT',
												'conditions' => array(
														'mkbun.kbunruicd = TKatudo.kbunruicd',
														'mkbun.bunruicd' => ConstantsComponent::$EVENT_CD,
														'mkbun.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
														'mkbun.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))')),
										array(
												'table' => $this->MKoukai,
												'alias' => 'mkou',
												'type' => 'LEFT',
												'conditions' => array(
														'mkou.koukaicd = TKatudo.koukaikbn',
														'mkou.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
														'mkou.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))'))
								),
								'fields' => array(
										'TKatudo.arno',
										'TKatudo.bunruicd',
										'TKatudo.sosikicd',
										'TKatudo.kbunruicd',
										'TKatudo.kaisaidate',
										'TKatudo.kaisaitmfrom',
										'TKatudo.kaisaitmto',
										'TKatudo.hyoudai',
										'TKatudo.meisyou',
										'TKatudo.koukaikbn',
										'TKatudo.syasinkey',
										'mkou.koukainm',
										'mkbun.kbunruinm'
								),
								'conditions' => $conditions,
								'order'=>array (
										'TKatudo.kaisaidate <>' => '0000-00-00',
										'TKatudo.kaisaidate' => 'DESC',
										'TKatudo.kaisaitmfrom' => 'DESC',
										'TKatudo.kaisaitmto' => 'DESC')));
						// 初期表示
						$this->set('selectedsosikinm', '');
						$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
						$cnt=count($query);
						if($cnt==0){
							$this->Session->setFlash($this->Constants->SEARCH_NOT_FOUND);
						}
						$this->set('katoinfo', $query);
					}
					//　画面の移動
					$this->render('/Admin/Activity/report');
				} else {
					$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				}
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
	 *　画面名： 活動報告 編集
	 *　機能名： 活動報告 編集
	 */
	public function editreport() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if(!isset($this->request->data['adminActivityeditFrm'])) {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
			}
			if ($_SESSION['Auth']['User']['Menu']['katsudoHokokuList'] == $this->Constants->HYOJI) {
				if (! empty ( $this->request->data )) {
					// 会議種別名称のセット
					$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
					// 会議を探すの初期表示
					$this->set('selectedsosikinm', $this->request->data['adminActivityeditFrm']['sosikinm']);
					// イベントを探すの初期表示
					$this->set('selectedKbunruinm', $this->request->data['adminActivityeditFrm']['kbunruinm']);
					// 活動情報 テーブルから検索
					$katoinfo = $this->TKatudo->find('first', array(
							'conditions' => array (
									'TKatudo.arno' => $this->request->data['adminActivityeditFrm']['arno'])));
					$this->set('katoinfo',$katoinfo);
					$syasinshousai = $this->TSyasin->find('all', array (
							'conditions' => array (
									'TSyasin.syasinkey' => $this->request->data['adminActivityeditFrm']['syasinkey']
							)
					) );
					$syasinData = array (
							'syasin1' => '',
							'syasin2' => '',
							'syasin3' => '',
							'title1' => '',
							'title2' => '',
							'title3' => ''
					);
					foreach ( $syasinshousai as $syasinVal ) {
						if ($syasinVal ['TSyasin'] ['rno'] == 1) {
							$syasinData ['syasin1'] = $syasinVal ['TSyasin'] ['rno'];
							$syasinData ['title1'] = $syasinVal ['TSyasin'] ['title'];
						}
						if ($syasinVal ['TSyasin'] ['rno'] == 2) {
							$syasinData ['syasin2'] = $syasinVal ['TSyasin'] ['rno'];
							$syasinData ['title2'] = $syasinVal ['TSyasin'] ['title'];
						}
						if ($syasinVal ['TSyasin'] ['rno'] == 3) {
							$syasinData ['syasin3'] = $syasinVal ['TSyasin'] ['rno'];
							$syasinData ['title3'] = $syasinVal ['TSyasin'] ['title'];
						}
					}
					$this->set ( [
							'syasinData' => $syasinData,
							'syasinKey' => $this->request->data['adminActivityeditFrm']['syasinkey'],
							'syasinshousai' => $syasinshousai
					] );
					$this->set('kbunruinm', $this->Common->getEventShubetsu($this->MKbunrui, $katoinfo['TKatudo']['bunruicd']));
					$this->set('inval', $this->Constants->INVAL);
					$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
					$bunruilist = $this->Common->getbunruiNameList($this->MBunrui);
					$this->set('bunruilist',$bunruilist);
					$this->set('bunruicd', $katoinfo['TKatudo']['bunruicd']);
					//　画面の移動
					$this->render('/Admin/Activity/editreport');
				}	
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
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
	 *　画面名： 出欠情報編集
	 *　機能名： 出欠情報編集 初期表示
	 */
	public function attendancereport() {
		try {
			$this->set('kaiinsbnm', $this->Common->getKaiinsbList($this->MKaiinsb));
			$this->set('sosiki', $this->Common->getKaigiShubetsuName($this->MSosiki));
			$this->set('kaiinsbname','');
			$this->set('sosikinm','');

			$this->set('count',"");
			$this->set('empDetails',"");

			$this->set('YakushokuChk1','checked');
			$this->set('YakushokuChk2','');
			$this->set('YakushokuChk3','');
			$this->set('meisyou', $this->request->data['adminActivityAttendanceFrm']['meisyou']);
			$this->set('kkey', $this->request->data['adminActivityAttendanceFrm']['arno']);

			//  活動報告一覧や活動カレンダー一覧の検索条件
			if ($this->request->data['adminActivityAttendanceFrm']['calenderType'] == 0) {
				$this->set('srch', $this->request->data['adminActivityAttendanceFrm']['srch']);
				$this->set('kaigiFrom','');
				$this->set('kaigiTo', '');
				$this->set('eventFrom','');
				$this->set('eventTo', '');
				$this->set('searchcon','');
			} else {
				$this->set('srch','');
				$this->set('kaigiFrom', $this->request->data['adminActivityAttendanceFrm']['kaigiFrom']);
				$this->set('kaigiTo', $this->request->data['adminActivityAttendanceFrm']['kaigiTo']);
				$this->set('eventFrom', $this->request->data['adminActivityAttendanceFrm']['eventFrom']);
				$this->set('eventTo', $this->request->data['adminActivityAttendanceFrm']['eventTo']);
				$this->set('searchcon', $this->request->data['adminActivityAttendanceFrm']['searchcon']);
			}

			$this->set('calenderType', $this->request->data['adminActivityAttendanceFrm']['calenderType']);
			$this->set('hdn_sosikicd', $this->request->data['adminActivityAttendanceFrm']['sosikinm']);
			$this->set('hdn_kbunruicd', $this->request->data['adminActivityAttendanceFrm']['kbunruinm']);
			$this->set('hdn_bunruicd', $this->request->data['adminActivityAttendanceFrm']['hdn_bunruicd']);
			
			$this->render('/Admin/Activity/attendancereport');
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}

	/**
	 *　画面名： 出欠情報編集
	 *　機能名： 出欠情報編集 検索
	 */
	public function attandancesearch() {
		try {	
			$db_TKaigiev = $this->TKaigiev->getDataSource();
			$db_TKaigiev->begin();
			$db_TEntry = $this->TEntry->getDataSource();
			$db_TEntry->begin();
			$byAjaxCheckFlg = 0;//inisialize the byAjaxCheckFlg
			if (!empty ( $this->request->data )) {
				$systemDateTime = $this->Common->getSystemDateTime();
				$kkey = $this->request->data ['kkey'];
				// 更新ボタンをクリック
				if ($this->request->data['adminAttendanceFrm']['koushinbtn'] == 1) {
					//insert or update attantance botton array get
					$hnd_attantance = $this->request->data['hnd_attantance'];
					$hnd_kaiincd = $this->request->data['hnd_kaiincd'];
					$loginCD = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
					$selectedOnly = array_intersect($hnd_attantance, [1]);
					$kaiincdSelectedOnly=array_intersect_key($hnd_kaiincd,$selectedOnly);
					//only get the cliked botton array
					$kaiincdArry = array_values($kaiincdSelectedOnly);
					foreach ($kaiincdArry as $key => $kaiincd) {
						$arno = "";
						$arnoArry = $this->TEntry->find ( 'all', array (
											'fields' => array('arno','torikesicd','torikesidt'),
											'conditions' => array (
												'kkey ' => $kkey, 
												'kaiincd ' => $kaiincd
											)
									));
						if (isset($arnoArry) && !empty($arnoArry)) {
							$arno = $arnoArry['0']['TEntry']['arno'];
						}
						if(!empty($arno)) {
							// 初期化 (参加)
							$torikesicd = null;
							$torikesidt = null;
							if (isset($arnoArry) && !empty($arnoArry)) {
								$checkTorikesidt = $arnoArry['0']['TEntry']['torikesidt'];
							}
							if ($checkTorikesidt == "") {
							// 参加 ⇒　不参加
								$torikesicd = $loginCD;
								$torikesidt = $systemDateTime;
							}

							$db = $this->TEntry->getDataSource ();
							$columnValue = array (
								'torikesicd' => $db->value ($torikesicd),
								'torikesidt' => $db->value ($torikesidt)
							);
							$updCondition = array (
								'arno' => $arno
							);
							//　更新処理
							$this->TEntry->updateAll ( $columnValue, $updCondition );
						} else {
							$getTKatudoValue = $this->TKatudo->find('first',array(
														'fields' => array(
															'TKatudo.bunruicd',
															'TKatudo.sosikicd',
															'TKatudo.kbunruicd',
															'TKatudo.kaisaidate',
															'TKatudo.kaisaitmfrom',
															'TKatudo.kaisaitmto'
														),
														'conditions' => array (
															'TKatudo.arno ='.$kkey
													)));
							// get the TKaiin fileds for 登録
							$kaisyacdArry = $this->TKaiin->find ( 'first', array (
											'fields' => array(
												'kaisyacd',
												'kaiinnm',
												'mailaddr'
											),
											'conditions' => array (
												'kaiincd ' => $kaiincd
											)
									));
							if (isset($kaisyacdArry) && !empty($kaisyacdArry)) {
								$kaisyacd = $kaisyacdArry['TKaiin']['kaisyacd'];
								$kaiinnm = $kaisyacdArry['TKaiin']['kaiinnm'];
								$mailaddr = $kaisyacdArry['TKaiin']['mailaddr'];
							}
							$getKaisyanm = $this->TKaisya->find('first', array(
									'fields' => array(
											'TKaisya.kaisyanm'// 会社名称
										),
									'conditions' => array(
											'TKaisya.kaisyacd' =>$kaisyacd)));
							// TKaigiev　登録処理
							$columnValueTKaigiev = array();
							$columnValueTKaigiev['kaisyanm'] = "";
							if (isset($getKaisyanm['TKaisya']['kaisyanm'])){
								$columnValueTKaigiev['kaisyanm'] = $getKaisyanm['TKaisya']['kaisyanm'];
							}
							$columnValueTKaigiev['bunruicd'] = $getTKatudoValue['TKatudo']['bunruicd'];
							$columnValueTKaigiev['sosikicd'] = $getTKatudoValue['TKatudo']['sosikicd'];
							$columnValueTKaigiev['kbunruicd'] = $getTKatudoValue['TKatudo']['kbunruicd'];
							$columnValueTKaigiev['kaisaidate'] = $getTKatudoValue['TKatudo']['kaisaidate'];
							$columnValueTKaigiev['kaisaitmfrom'] = $getTKatudoValue['TKatudo']['kaisaitmfrom'];
							$columnValueTKaigiev['kaisaitmto'] = $getTKatudoValue['TKatudo']['kaisaitmto'];
							$columnValueTKaigiev['kaiinkbn'] = $this->Constants->KAIIN; // 　0：会員
							$columnValueTKaigiev['simei'] = $kaiinnm;
							$columnValueTKaigiev['mailaddr'] = $mailaddr;
							$columnValueTKaigiev['tourokucd'] = $loginCD;
							$columnValueTKaigiev['tourokudt'] = $systemDateTime;
							
							if ($this->TKaigiev->validates()) {
								$this->TKaigiev->create();
								$this->TKaigiev->save($columnValueTKaigiev, array('validate' => false));
								// clear the TKaigiev table for the continuous insert
								$this->TKaigiev->clear();
								//　TEntry　登録処理
								$TKaigiev_marno = $this->TKaigiev->getLastInsertId();
								if(!empty($TKaigiev_marno)) {
									$columnValue = array();
									$columnValue['kkey'] = $kkey;
									$columnValue['kaiinkbn'] = $this->Constants->KAIIN; // 　0：会員
									$columnValue['kaiincd'] = $kaiincd;
									$columnValue['mousikominm'] = $kaiinnm;
									$columnValue['marno'] = $TKaigiev_marno; //会議・イベント申込情報(T_KAIGIEV)を登録時の連番を設定
									if(isset($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'])) {
										$kaiincdsession = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
									} else {
										$kaiincdsession = "";
									}
									$columnValue['mousikomicd'] = $kaiincdsession;
									$columnValue['mousikomidt'] = $systemDateTime;
									$filedata = $this->TEntry->find ( 'first', array (
											'fields' => array('arno'),
											'conditions' => array ('kkey ' => $kkey, 
																	'kaiincd ' => $kaiincd)
										));
									if(count($filedata)!=0) {
										$db = $this->TEntry->getDataSource ();
										$columnValueup = array (
											'marno' => $db->value ($TKaigiev_marno),
											'mousikomidt' => $db->value ($systemDateTime),
											'torikesicd' => $db->value (''),
											'torikesidt' => $db->value (NULL)
										);
										$conditionsup = array (
											'kkey' => $kkey,
											'kaiincd' => $kaiincd
										);
										$this->TEntry->updateAll ( $columnValueup, $conditionsup );
									} else {
										//　登録処理
										$this->TEntry->create();
										if (!$this->TEntry->save($columnValue)) {
											$byAjaxCheckFlg = 1; //set the  byAjaxCheckFlg 1 for the error through the ajax
											throw new Exception();
										}
										// clear the TEntry table for the continuous insert
										$this->TEntry->clear();
									}
								}
							} else {
								$errors = $this->TKaigiev->validationErrors;
								$this->Session->write("errorMsgs",$errors);
								$this->Session->write("errorMsg.errorflag",true);
							}
							
						}
					}
					$db_TKaigiev->commit();
					$db_TEntry->commit();
					echo 1;exit; // for the succssefull register
				}

				// 検索処理
				$empDetails = "";
				$kaiinsbnm = $this->request->data ['kaiinsbnm'];
				$Yakushoku = $this->request->data ['Yakushoku'];
				$sosiki = $this->request->data ['sosikicd'];
				$meisyou = $this->request->data ['meisyou'];
				$conditions[] = array (
						'TKaiin.kanrikbn <' => $this->Constants->SYS_KANRISHA
					);
				if (! empty($kaiinsbnm)) {
					$conditions[] = array (
						'TKaiin.kaiinsbcd' => $kaiinsbnm
					);
				}
				if (! empty($sosiki)) {
					$conditions[] = array (
						'TKaiin.sosikicd' => $sosiki
					);
				}
				if ( $Yakushoku == 1) {
					$conditions[] = array (
						'TKaiin.kyoukaiykcd !=' => ''
					);
				} else if ($Yakushoku == 2) {
					$conditions[] = array (
						'TKaiin.kyoukaiykcd' => ''
					);
				}
				$empDetails = $this->TKaiin->find('all',array(
													'joins' => array (
														array (
															'table' => $this->TEntry,
															'alias' => 'TEntry',
															'type' => 'LEFT',
															'conditions' => array (
																				'TKaiin.kaiincd = TEntry.kaiincd',
																				'TEntry.kaiinkbn = '.$this->Constants->KAIIN, 
																				'TEntry.kkey = '.$kkey
																			)),
													),
													'fields' => array(
															'TKaiin.kaiincd',
															'TKaiin.kaiinnmkana',
															'TKaiin.kaiinnm',
															'TEntry.arno',
															'TEntry.mousikomicd',
															'TEntry.mousikomidt',
															'TEntry.torikesicd',
															'TEntry.torikesidt'
														),
													'conditions' => $conditions,
													'order' => array('IF(TEntry.arno IS NULL, 0, IF(TEntry.torikesidt != "", 0, 1))' => 'DESC', 'TKaiin.kaiinnmkana' => 'ASC', 'TKaiin.kaiincd' => 'ASC')
											));

				$cnt = count ( $empDetails );
				$this->set('count',$cnt);
				if ($cnt == 0) {
					$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
					$this->set('empDetails', '');
				} else {
					$this->set('empDetails', $empDetails);
				}

				//  活動報告一覧や活動カレンダー一覧の検索条件
				if ($this->request->data ['calenderType'] == 0) {
					$this->set('srch', $this->request->data['srch']);
					$this->set('kaigiFrom','');
					$this->set('kaigiTo', '');
					$this->set('eventFrom','');
					$this->set('eventTo', '');
					$this->set('searchcon','');
				} else {
					$this->set('srch','');
					$this->set('kaigiFrom', $this->request->data['adminAttendanceFrm']['kaigiFrom']);
					$this->set('kaigiTo', $this->request->data['adminAttendanceFrm']['kaigiTo']);
					$this->set('eventFrom', $this->request->data['adminAttendanceFrm']['eventFrom']);
					$this->set('eventTo', $this->request->data['adminAttendanceFrm']['eventTo']);
					$this->set('searchcon', $this->request->data['searchcon']);

				}
				$this->set('calenderType', $this->request->data ['calenderType']);
				$this->set('hdn_sosikicd', $this->request->data ['hdn_sosikicd']);
				$this->set('hdn_kbunruicd', $this->request->data ['hdn_kbunruicd']);
				$this->set('hdn_bunruicd', $this->request->data ['hdn_bunruicd']);
				
				$this->set('kkey', $kkey);
				$this->set('kaiinsbnm', $this->Common->getKaiinsbList($this->MKaiinsb));
				$this->set('sosiki',$this->Common->getKaigiShubetsuName($this->MSosiki));

				$this->set('kaiinsbname', $kaiinsbnm);
				$this->set('meisyou', $meisyou);
				$this->set('sosikinm', $sosiki);
				if($Yakushoku == '0') {
						$this->set('YakushokuChk1','checked');
						$this->set('YakushokuChk2','');
						$this->set('YakushokuChk3','');
					} else if($Yakushoku == '1') {
						$this->set('YakushokuChk1','');
						$this->set('YakushokuChk2','checked');
						$this->set('YakushokuChk3','');
					} else {
						$this->set('YakushokuChk1','');
						$this->set('YakushokuChk2','');
						$this->set('YakushokuChk3','checked');
					}
					
				$this->render('/Admin/Activity/attendancereport');
			} else {
					$this->redirect ( ['controller' => 'AdminActivity','action' => 'report' ] );
			}
		} catch (Exception $e) {
			$db_TKaigiev->rollback();
			$db_TEntry->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			if ($byAjaxCheckFlg) {
				echo 0;exit; // for the Unsuccssefull register
			} else {
				$this->redirect ( [
						'controller' => 'Error',
						'action' => 'systemError' ] );
			}
		}
	}

	/**
	 *　画面名：活動報告一覧
	 *　機能名：活動報告一覧 の更新日
	 */
	public function loadKoushinDate($bunruicd) {
		try {
			$TKatudo = $this->TKatudo->find ( 'all', array (
					'fields' => array (
							'distinct SUBSTRING(TKatudo.kousindt, 1, 7) as content_short'
					),
					'conditions' => array(
							'TKatudo.bunruicd' => $bunruicd
					),
					'order' => array (
							'TKatudo.kousindt' => 'ASC'
					)
			));
			foreach ( $TKatudo as $row => $values ) {
				$temp = substr ( $values [0] ['content_short'], 0, 4 );
				$temp = $temp . "年" . substr ( $values [0] ['content_short'], 5, 7 ) . "月";
				$date [substr ( $values [0] ['content_short'], 0, 7 )] = $temp;
			}
			// 更新日時を追加
			return $date;
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	public function byAjaxCheck() {
		// イベント種別名称のセット
		$returnArray = $this->Common->getEventShubetsu($this->MKbunrui, $this->request->data['bunruicd']);
		$returnArray = json_encode($returnArray);
		echo $returnArray;exit;
	}
	/**
	 *　画面名：活動カレンダー一覧
	 *　機能名：削除処理
	 */
	public function deletereport() {
		try {
			if ($_SESSION['Auth']['User']['Menu']['katsudoHokokuList'] == $this->Constants->HYOJI) {
				$arno = $this->request->data['arno'];
				$syasinkey = $this->request->data['syasinkey'];
				$this->TKatudo->delete( $arno );
				if(!empty($syasinkey) && $syasinkey != null && $syasinkey != 0 ) {
					$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey ");
				}
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
	 * 画面名：入会
	 * 機能名：メール送信１　（事務局宛）
	 * @param 引継ぎ情報  columnValue
	 * @param システム日時  systemDateTime
	 * @return string
	 */
	private function mailText($data,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 130px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> 各位</p>\n";
		$message .= "\n";
		$message .= "<p> 活動カレンダーの新規追加を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDate($data['kaisaidate'])."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　時　間</td><td $braceWidth>】</td>
						<td $maxwidth>".date("G:i", strtotime($data['kaisaitmfrom']))."〜".date("G:i", strtotime($data['kaisaitmto']))."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会議 ・ イベント名</td><td $braceWidth>】</td>
						<td $maxwidth>".$data['hyoudai'].' '.$data['meisyou']."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>場　　　　　所</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($data['basyo'])."</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	/**
	 *　画面名： 活動カレンダー一覧 編集
	 *　機能名： 活動カレンダー一覧 編集
	 */
	public function reportupdate() {
		try {
			$db_TKatudo = $this->TKatudo->getDataSource();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TKatudo->begin();
			$db_TSyasin->begin();

			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$this->request->data['reportedit'] = $this->request->data;
			if (! empty ( $this->request->data )) {
				$torokuDate = $this->Common->getSystemDateTime ();
				$syasinKeyVal = $this->request->data ['urlsyasinKey'];
				// 写真キー取得
				if($this->request->data['divert'] == "1" && 
					(isset ( $_FILES ['syasin1'] ['tmp_name'] ) || isset ( $_FILES ['syasin2'] ['tmp_name'] ) || isset ( $_FILES ['syasin3'] ['tmp_name'] ) || !empty($this->request->data ['divrstsyashin1']) || !empty($this->request->data ['divrstsyashin2']) || !empty($this->request->data ['divrstsyashin3']) ) ) {
					$maxSyasinKey = $this->TSyasin->find ('first', 
							array('fields' => array ('MAX(TSyasin.syasinkey)+1 As syasinKey')));
					if (empty ( $maxSyasinKey ['0'] ['syasinKey'] )) {
						$syasinKeyVal = 1;
					} else {
						$syasinKeyVal = $maxSyasinKey ['0'] ['syasinKey'];
					}
				} else if($this->request->data['divert'] == "1") {
					$syasinKeyVal = 0;
				}
				if ($this->request->data['divert'] == "1" && $this->request->data ['urlsyasinKey'] != 0) {
					$oldSyasin = $this->request->data ['urlsyasinKey'];
					$this->TSyasin->query(" INSERT into t_syasin (syasinkey,rno,bunrui,title,syasin,kousincd,kousindt,tourokucd,tourokudt) SELECT $syasinKeyVal AS syasinkey,rno,bunrui,title,syasin,kousincd,kousindt,tourokucd,tourokudt FROM t_syasin WHERE syasinkey = $oldSyasin ");
				}
				$isUploaded = false;
				if (isset ( $_FILES ['syasin1'] ['tmp_name'] )) { 
					if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) { 
						$isUploaded = true;
					}
				}
				if (isset ( $_FILES ['syasin2'] ['tmp_name'] )) { 
					if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) { 
						$isUploaded = true;
					}
				}
				if (isset ( $_FILES ['syasin3'] ['tmp_name'] )) { 
					if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] ))  { 
						$isUploaded = true;
					}
				}
				if(!$isUploaded && ($syasinKeyVal == "0" || $syasinKeyVal == NULL || $syasinKeyVal == "")) {
					$syasinKeyVal = "0";
				}
				$rnoSyasin1 = $this->request->data ['urlsyasin1'];
				$rnoSyasin2 = $this->request->data ['urlsyasin2'];
				$rnoSyasin3 = $this->request->data ['urlsyasin3'];
				if (! isset ( $this->request->data ['syasin1Title'] )) {
					$syasin1Title = $this->request->data ['urltitle1'];
				} else {
					$syasin1Title = $this->request->data ['syasin1Title'];
				}
				if (! isset ( $this->request->data ['syasin2Title'] )) {
					$syasin2Title = $this->request->data ['urltitle2'];
				} else {
					$syasin2Title = $this->request->data ['syasin2Title'];
				}
				if (! isset ( $this->request->data ['syasin3Title'] )) {
					$syasin3Title = $this->request->data ['urltitle3'];
				} else {
					$syasin3Title = $this->request->data ['syasin3Title'];
				}
				// 写真１
				if ($this->request->data ['reset1'] == "1") {
					$syasin1 = '';
					$this->deleteTSyasin ($syasinKeyVal,'1');
				} else if (isset ( $_FILES ['syasin1'] ['tmp_name'] )) {
					if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
						$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size'] );
						if (empty ( $rnoSyasin1 )) {
							$rno = "1";
							$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin1Title'], $syasin1, $torokuDate );
							$syasinKeyVal = $this->TSyasin->getLastInsertId();
						} else {
							$this->updateTSyasin ( $syasinKeyVal, $rnoSyasin1, $syasin1Title, $syasin1 );
						}
					}
				} else if(isset($this->request->data ['syasin1Title'])) {
					$this->updateTSyasintitle( $syasinKeyVal, $rnoSyasin1, $syasin1Title);
				}
				// 写真２
				if ($this->request->data ['reset2'] == "1") {
					$syasin2 = '';
					$this->deleteTSyasin ($syasinKeyVal,'2');
				} else if (isset ( $_FILES ['syasin2'] ['tmp_name'] )) {
					if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) {
						$syasin2 = fread ( fopen ( $_FILES ['syasin2'] ['tmp_name'], "r" ), $_FILES ['syasin2'] ['size'] );
						if (empty ( $rnoSyasin2 )) {
							$rno = "2";
							$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin2Title'], $syasin2, $torokuDate );
							$syasinKeyVal = $this->TSyasin->getLastInsertId();
						} else {
							$this->updateTSyasin ( $syasinKeyVal, $rnoSyasin2, $syasin2Title, $syasin2 );
						}
					}
				} else if(isset($this->request->data ['syasin2Title'])) {
					$this->updateTSyasintitle( $syasinKeyVal, $rnoSyasin2, $syasin2Title);
				}
				// 写真３
				if ($this->request->data ['reset3'] == "1") {
					$syasin3 = '';
					$this->deleteTSyasin ($syasinKeyVal,'3');
				} else if (isset ( $_FILES ['syasin3'] ['tmp_name'] )) {
					if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] )) {
						$syasin3 = fread ( fopen ( $_FILES ['syasin3'] ['tmp_name'], "r" ), $_FILES ['syasin3'] ['size'] );
						if (empty ( $rnoSyasin3 )) {
							$rno = "3";
							$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin3Title'], $syasin3, $torokuDate );
							$syasinKeyVal = $this->TSyasin->getLastInsertId();
						} else {
							$this->updateTSyasin ( $syasinKeyVal, $rnoSyasin3, $syasin3Title, $syasin3 );
						}
					}
				} else if(isset($this->request->data ['syasin3Title'])) {
					$this->updateTSyasintitle( $syasinKeyVal, $rnoSyasin3, $syasin3Title);
				}
				$responseString = $this->textarea_maxlength("basyo",$this->request->data['basyo'],100,$responseString);
				$responseString = $this->textarea_maxlength("naiyou",$this->request->data['naiyou'],1024,$responseString);
				$responseString = $this->textarea_maxlength("gidai",$this->request->data['gidai'],255,$responseString);
				$responseString = $this->textarea_maxlength("kousi",$this->request->data['kousi'],100,$responseString);
				$responseString = $this->textarea_maxlength("taisyou",$this->request->data['taisyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("teiincom",$this->request->data['teiincom'],60,$responseString);
				$responseString = $this->textarea_maxlength("hiyou",$this->request->data['hiyou'],100,$responseString);
				$responseString = $this->textarea_maxlength("syugoubasyo",$this->request->data['syugoubasyo'],255,$responseString);
				$responseString = $this->textarea_maxlength("bikou",$this->request->data['bikou'],1024,$responseString);
				$responseString = $this->textarea_maxlength("comment",$this->request->data['comment'],1024,$responseString);
				$responseString = substr($responseString, 2);
				$this->TKatudo->set($this->request->data);
				if($this->TKatudo->validates() && $responseString == "") {
					$data['arno'] = $this->request->data['reportedit']['id'];
					$data['bunruicd'] =  $this->request->data['bunruicd'];
					$data['sosikicd'] = $this->request->data['sosikicd'];
					$data['kbunruicd'] = $this->request->data['kbunruicd'];
					$data['kaisaidate'] = $this->request->data['kaisaidate'];
					$data['kaisaitmfrom'] = $this->request->data['kaisaitmfrom'];
					$data['kaisaitmto'] = $this->request->data['kaisaitmto'];
					$data['hyoudai'] = $this->request->data['hyoudai'];
					$data['meisyou'] = $this->request->data['meisyou'];
					$data['basyo'] = $this->request->data['basyo'];
					$data['naiyou'] = $this->request->data['naiyou'];
					$data['gidai'] = $this->request->data['gidai'];
					$data['kousi'] = $this->request->data['kousi'];
					$data['taisyou'] = $this->request->data['taisyou'];
					$data['taisyoukbn'] = $this->request->data['scategory_radio'];
					$data['teiin'] = $this->request->data['teiin'];
					$data['teiincom'] = $this->request->data['teiincom'];
					$data['hiyou'] = $this->request->data['hiyou'];
					$data['syugoubasyo'] = $this->request->data['syugoubasyo'];
					$data['syasinkey'] = $syasinKeyVal;
					$data['kigendate'] = $this->request->data['kigendate'];
					$data['kigentm'] = $this->request->data['kigentm'];
					$data['comment'] = $this->request->data['comment'];
					$data['koukaikbn'] = $this->request->data['koukaikbn'];
					$data['bikou'] = $this->request->data['bikou'];
					if ($this->request->data['divert'] == "1") {
						$data['tourokucd'] = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
						$data['tourokudt'] = $this->Common->getSystemDateTime();
					} else {
						$data['kousincd'] = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
						$data['kousindt'] = $this->Common->getSystemDateTime();
					}
					if(empty($data['teiin'])) {
							$data['teiin'] = 0;
					}
					if (!$this->TKatudo->save($data)) {
						throw new Exception();
					}
					if($this->request->data['koukaikbn'] == 0) {
						if ($this->request->data['hdn_soushin'] == 1) {
							// 更新通知メールの受取へメール送信
							$uketoriMailInfo = $this->Common->getUketoriMailInfo($this->TKaiin);
							if (!empty($uketoriMailInfo)) {
								$uketoriMailInfoArray = array();
								foreach($uketoriMailInfo as $value) {
									if($value['TKaiin']['mailaddr'] != "" && $value['TKaiin']['mailaddr'] != null){
										$uketoriMailInfoArray[] = $value['TKaiin']['mailaddr'];
									}
								}
								$mailInfo = $this->Common->getMailInfo($this->MTuuci);
								if (!empty($mailInfo)) {
									if (!empty($mailInfo['0']['MTuuci']['mailaddrsend'])) {
										$from = $mailInfo['0']['MTuuci']['mailaddrsend'];
										$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,4);
									}
								}
							}
						}
					}
					if (!empty($this->request->data['mailcheck'])) {
						//事務局へメール送信
						$mailInfo=$this->Common->getMailInfo($this->MTuuci);
						$systemDateTime=$this->Common->getSystemDateTime();
						$data['hyoudai'] = $this->request->data['hyoudai'];
						$data['kaisaidate'] = $this->request->data['kaisaidate'];
						$data['kaisaitmfrom'] = $this->request->data['kaisaitmfrom'];
						$data['kaisaitmto'] = $this->request->data['kaisaitmto'];
						$data['meisyou'] = $this->request->data['meisyou'];
						$data['basyo'] = $this->request->data['basyo'];
						if (!empty($mailInfo)) {
							if(isset($data['kbunruicd']) && !empty($data['kbunruicd'])) {
								$filedata = $this->MKurabu->find ( 'first', array (
									'fields' => array('MKurabu.mailaddr'),
									'conditions' => array ('MKurabu.kurabucd ' => $data['kbunruicd'])
								));
							}
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
							if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
								// メール送信　（事務局宛）
								$subject_mail = '【確認・通知】' . $data['hyoudai'];
								$msg_mail = $this->mailTextReportupdate($data, $systemDateTime);
								$mail = new CakeEmail('smtp');
								$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
								$mail->to($allmailaddrs);
								if (isset($data['kbunruicd']) && !empty($data['kbunruicd']) && !empty($filedata['MKurabu']['mailaddr'])) {
									$mail->cc($filedata['MKurabu']['mailaddr']);
								}
								$mail->subject($subject_mail);
								$mail->emailFormat('html');
								$mail->send($msg_mail);
							}
						}
					}
					$report['reportedit'] = $this->request->data;
					$this->set('event_report', $report);
					$this->syashinkeydelete($syasinKeyVal,$this->request->data['reportedit']['id']);
					$responseString = "1";
					echo $responseString;
				} else {
					// 検証エラーが発生されない場合
					$errors = $this->TKatudo->validationErrors;
					$errCount = count($errors);
					$idx=0;
					if ($responseString != "") {
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

			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
	 		}
			$db_TKatudo->commit();
			$db_TSyasin->commit();
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function updateTSyasin($syasinkey, $rno, $title, $syasin) {
		try {
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'syasin' => $db->value ( $syasin ),
					'bunrui' => $db->value ( $this->Constants->KATUDO ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
			);
			$conditions = array (
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno 
			);
			// 写真情報に登録
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TKatudo->rollback();
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
	 * 　機能名：最大数を取得処理
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
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function insertTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt) {
		try {
			// 項目の値セット
			$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->KATUDO,
					'title' => $title,
					'syasin' => $syasin,
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if(!empty($syasinkey)) {
				$columnValue['syasinkey'] = $syasinkey;
			}
			// 写真情報作成
			$this->TSyasin->create();
			// 写真情報に登録
			if (!$this->TSyasin->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	private function mailTextupdate($data,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 130px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> 各位</p>\n";
		$message .= "\n";
		$message .= "<p> 活動カレンダーの更新を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDate($data['kaisaidate'])."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　時　間</td><td $braceWidth>】</td>
						<td $maxwidth>".date("G:i", strtotime($data['kaisaitmfrom']))."〜".date("G:i", strtotime($data['kaisaitmto']))."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会議・イベント名</td><td $braceWidth>】</td>
						<td $maxwidth>".$data['hyoudai'].' '.$data['meisyou']."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>場　　　　　所</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($data['basyo'])."</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	
	private function mailTextReportupdate($data,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 130px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> 各位</p>\n";
		$message .= "\n";
		$message .= "<p> 活動報告の更新を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDate($data['kaisaidate'])."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>開　催　時　間</td><td $braceWidth>】</td>
						<td $maxwidth>".date("G:i", strtotime($data['kaisaitmfrom']))."〜".date("G:i", strtotime($data['kaisaitmto']))."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会議・イベント名</td><td $braceWidth>】</td>
						<td $maxwidth>".$data['hyoudai'].' '.$data['meisyou']."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>場　　　　　所</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($data['basyo'])."</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	/**
	 *　テーブル名：写真情報
	 *　機能名：写真の削除処理
	 */
	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			if(!empty($syasinkey) && $syasinkey != null && $syasinkey != 0 ) {
				$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
			}
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真の更新処理
	 */
	private function updateTSyasintitle($syasinkey, $rno, $title) {
		try {
			// 項目の値セット
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'bunrui' => $db->value ( $this->Constants->KATUDO ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
			);
			$conditions = array (
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno 
			);
			// 写真情報に登録
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
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
        	if (isset($fields[1])) {
        		$requestData[$fields[0]] = urldecode($fields[1]);
        	}
        }
		return $requestData;
	}
	/**
	 *　機能名：検証チェック処理
	 */
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$responseString) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if (mb_strlen($dummy_str) > $maxlen) {
			$responseString .= "$$".$fname."##最大文字数を超えています。";
			return $responseString;
		} else {
			return $responseString;
		}
	}
	private function syashinkeydelete($syasinkey,$arno) {
		try {
			$syashincntchk = $this->TSyasin->find ( 'all', array (
							'fields' => array('TSyasin.syasinkey'),
							'conditions' => array ('TSyasin.syasinkey ' => $syasinkey )));
			if(count($syashincntchk) == 0) {
				$columnValue = array ('syasinkey' => 0);
				$conditions = array ('arno' => $arno);
				$this->TKatudo->updateAll ( $columnValue, $conditions );
			}
		} catch (Exception $e) {
			$db_TKatudo->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
}