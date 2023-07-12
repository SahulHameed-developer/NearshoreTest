<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * 委員会紹介情報 編集 Controller
 *
 * 委員会紹介情報 編集を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminCommitteInfoController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common','Session');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MIinkai','MKoukai','TIinkai','TSyasin','TKaiin','MTuuci','TKaisya');
	// レイアウト無し
	public $autoLayout = false;
	/**
	 * 　画面名：委員会紹介情報編集
	 * 　機能名：委員会紹介情報の編集処理
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$this->Session->write ( "Footer.scroll_val", 0 );
		$this->set('combocommittee',$this->Common->getcommittee ($this->MIinkai));
		//公開区分のセット
		$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		//初期値のセット
		$this->set('kokaiVal', $this->Constants->INVAL);
		$this->set('iinkaicd', '');
		$this->set('committee', '');
		$this->set('disflg', 'true');
		$this->set('upflg', 'false');
		$this->set('isyasinkey', '');
		$this->set('ssyasinkey', '');
		// 画面の移動
		$this->render ('/Admin/CommitteInfo/edit');
	}
	/**
	 * 　画面名：委員会紹介情報編集
	 * 　機能名：委員会紹介情報の新規追加・更新処理
	 */
	public function insertupdate($request, $isyasinkey, $ssyasinkey, $torokuDate) {
		$getTIinkai = $this->getTIinkai ($request['iinkaicdinsert']);
		$cnt = count ( $getTIinkai );
		if ($cnt == 0) {
			$this->insertTIinkai ($request, $isyasinkey, $ssyasinkey, $torokuDate);
		} else {
			$this->updateTIinkai ($request, $isyasinkey, $ssyasinkey, $torokuDate);
		}
	}
	/**
	 *	委員会レコードを取得する。
	 **/
	public function getTIinkai($iinkaicd) {
		$filedata = $this->TIinkai->find ( 'first', array (
									'fields' => array('iinkaicd','gaiyou','syokumu','njyoken','nhouhou','bikou'),
									'conditions' => array ('iinkaicd ' => $iinkaicd)
								));
		return $filedata;
	}
	/**
	 * 　テーブル名：委員会
	 * 　機能名：委員会紹介情報登録
	 */
	private function insertTIinkai($request, $isyasinkey, $ssyasinkey, $torokuDate) {
		 try {
		 	// 項目の値セット
			$columnValue = array (
				'iinkaicd' => $request['iinkaicdinsert'],
				'gaiyou' => $request['gaiyou'],
				'syokumu' => $request['syokumu'],
				'njyoken' => $request['njyoken'],
				'nhouhou' => $request['nhouhou'],
				'bikou' => $request['bikou'],
				'isyasinkey' => $isyasinkey,
				'koukaikbn' => $request['koukaikbn'],
				'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
				'tourokudt' => $torokuDate 
			);
			if ($ssyasinkey!="") {
				$columnValue['ssyasinkey'] = $ssyasinkey;
			}
			// 委員会紹介情報作成
			$this->TIinkai->create ();
			// 委員会紹介情報に登録
			if (!$this->TIinkai->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) { 
			$db_TIinkai->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　テーブル名：委員会
	 * 　機能名：委員会紹介情報更新
	 */
	private function updateTIinkai($request, $isyasinkey, $ssyasinkey, $kousindt) {
		try {
			$db = $this->TIinkai->getDataSource ();
			$columnValue = array (
				'gaiyou' => $db->value ($request['gaiyou']),
				'syokumu' => $db->value ($request['syokumu']),
				'njyoken' => $db->value ($request['njyoken']),
				'nhouhou' => $db->value ($request['nhouhou']),
				'bikou' => $db->value ($request['bikou']),
				'isyasinkey' => $db->value ($isyasinkey),
				'koukaikbn' => $db->value ($request['koukaikbn']),
				'kousincd' => $db->value ($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']),
				'kousindt' => $db->value ($kousindt) 
			);
			if ($ssyasinkey!="") {
				$columnValue['ssyasinkey'] = $db->value ($ssyasinkey);
			}
			$conditions = array (
					'iinkaicd' => $request['iinkaicdinsert']
			);
			// ファイル情報に登録
			if (!$this->TIinkai->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TIinkai->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　画面名：委員会紹介情報編集
	 * 　機能名：委員会紹介情報編集の検索処理
	 */
	public function search() {
		$this->Session->write ( "Footer.scroll_val", 0 );
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$committee = $this->TIinkai->find ( 'all', array (
									'fields' => array (
											'gaiyou',
											'syokumu',
											'njyoken',
											'nhouhou',
											'bikou',
											'isyasinkey',
											'ssyasinkey',
											'koukaikbn',
									),
									'conditions'=>array('iinkaicd' => $this->request->data['iinkaicd']),
									'order'=> array('TIinkai.iinkaicd' => 'ASC')
							));
		$cnt = count ( $committee );
		if ($cnt == 0) {
			$this->set('upflg', 'false');
			$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
		} else {
			$this->set('upflg', 'true');
		}
		$this->set ( [ 'committee' => $committee ] );
		$syasinshousai= array();
		$syasinshousaisub= array();
		$isyasinkey="";
		$ssyasinkey="";
		if(isset($committee[0]['TIinkai']['isyasinkey'])) {
			$syasinshousai = $this->TSyasin->find ( 'all', array (
						'conditions' => array (
								'syasinkey' => $committee[0]['TIinkai']['isyasinkey'] 
						)
				) );
			$isyasinkey = $committee[0]['TIinkai']['isyasinkey'];
		}
		if(isset($committee[0]['TIinkai']['isyasinkey'])) {
			$syasinshousaisub = $this->TSyasin->find ( 'all', array (
						'conditions' => array (
								'syasinkey' => $committee[0]['TIinkai']['ssyasinkey'] 
						) 
				) );
			$ssyasinkey = $committee[0]['TIinkai']['ssyasinkey'];
		}
		$syasinData = array (
				'syasin' => '',
				'syasin1' => '',
				'syasin2' => '',
				'syasin3' => '',
				'syasin4' => '',
				'syasin5' => '',
				'syasin6' => '',
				'syasin7' => '',
				'syasin8' => '',
				'syasin9' => '',
				'title' => '',
				'title1' => '',
				'title2' => '',
				'title3' => '',
				'title4' => '',
				'title5' => '',
				'title6' => '',
				'title7' => '',
				'title8' => '',
				'title9' => ''
		);
		if(count($syasinshousai)>0) {
			$syasinData ['syasin'] = $syasinshousai [0] ['TSyasin'] ['rno'];
			$syasinData ['title'] = $syasinshousai [0] ['TSyasin'] ['title'];
		}
		foreach ( $syasinshousaisub as $syasinVal ) {
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
			if ($syasinVal ['TSyasin'] ['rno'] == 4) {
				$syasinData ['syasin4'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title4'] = $syasinVal ['TSyasin'] ['title'];
			}
			if ($syasinVal ['TSyasin'] ['rno'] == 5) {
				$syasinData ['syasin5'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title5'] = $syasinVal ['TSyasin'] ['title'];
			}
			if ($syasinVal ['TSyasin'] ['rno'] == 6) {
				$syasinData ['syasin6'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title6'] = $syasinVal ['TSyasin'] ['title'];
			}
			if ($syasinVal ['TSyasin'] ['rno'] == 7) {
				$syasinData ['syasin7'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title7'] = $syasinVal ['TSyasin'] ['title'];
			}
			if ($syasinVal ['TSyasin'] ['rno'] == 8) {
				$syasinData ['syasin8'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title8'] = $syasinVal ['TSyasin'] ['title'];
			}
			if ($syasinVal ['TSyasin'] ['rno'] == 9) {
				$syasinData ['syasin9'] = $syasinVal ['TSyasin'] ['rno'];
				$syasinData ['title9'] = $syasinVal ['TSyasin'] ['title'];
			}
		}
		$this->set('syasinData', $syasinData);
		$this->set('isyasinkey', $isyasinkey);
		$this->set('ssyasinkey', $ssyasinkey);
		// 初期化のセット
		$this->set('combocommittee',$this->Common->getcommittee ($this->MIinkai));
		//公開区分のセット
		$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		//初期値のセット
		$this->set('kokaiVal', $this->Constants->INVAL);
		if (isset($committee[0]['TIinkai']['koukaikbn'])) {
			$this->set('kokaiVal', $committee[0]['TIinkai']['koukaikbn']);
		} else {
			$this->set('kokaiVal', $this->Constants->INVAL);
		}
		$this->set('iinkaicd', $this->request->data['iinkaicd']);
		$this->set('disflg', 'false');
		$chairman = $this->TKaiin->find ( 'first', array (
									'joins' => array (
											array (
													'table' => $this->TKaisya,
													'alias' => 'TKaisya',
													'type' => 'LEFT',
													'conditions' => array ('TKaisya.kaisyacd = TKaiin.kaisyacd')),
									),
									'fields' => array ('TKaisya.kaisyanm',
													'TKaiin.kaiinnm'
									), 
									'conditions' => array(
													'TKaiin.sosikicd' => $this->request->data['iinkaicd'],
													'TKaiin.iinkaiykcd' => $this->Constants->T_KAIIN_IINKAIYKCD )
								));
		$commissioner = $this->TKaiin->find ( 'all', array (
									'joins' => array (
											array (
													'table' => $this->TKaisya,
													'alias' => 'TKaisya',
													'type' => 'LEFT',
													'conditions' => array (
															'TKaisya.kaisyacd = TKaiin.kaisyacd'
													)),
									),
									'fields' => array (
											'TKaisya.kaisyanm',
											'TKaiin.kaiinnm',
									), 
									'conditions' => array(
												'TKaiin.sosikicd' => $this->request->data['iinkaicd'],
												'TKaiin.iinkaiykcd !=' => '01')
								));
		$this->set('chairman', $chairman);
		$this->set('commissioner', $commissioner);
		// 画面の移動
		$this->render ('/Admin/CommitteInfo/edit');
	}
	/**
	 * 　画面名：委員会紹介情報編集
	 * 　機能名：委員会紹介情報の登録処理
	 */
	public function register() {
		$this->Session->write ( "Footer.scroll_val", 0 );
		try {
			$db_TIinkai = $this->TIinkai->getDataSource();
			$db_TIinkai->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$responseString = "";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			if (array_key_exists ( 'gaiyou', $this->request->data )) {
				$isyasinkey = $this->request->data['isyasinkey'];
				$ssyasinkey = $this->request->data['ssyasinkey'];
				$this->textarea_maxlength("gaiyou",$this->request->data['gaiyou'],1024,$responseString);
				$this->TIinkai->set ( $this->request->data );
				if ($this->TIinkai->validates ()) {
					$torokuDate = $this->Common->getSystemDateTime ();
					$rnoSyasin = $this->request->data ['urlsyasin'];
					$rnoSyasin1 = $this->request->data ['urlsyasin1'];
					$rnoSyasin2 = $this->request->data ['urlsyasin2'];
					$rnoSyasin3 = $this->request->data ['urlsyasin3'];
					$rnoSyasin4 = $this->request->data ['urlsyasin4'];
					$rnoSyasin5 = $this->request->data ['urlsyasin5'];
					$rnoSyasin6 = $this->request->data ['urlsyasin6'];
					$rnoSyasin7 = $this->request->data ['urlsyasin7'];
					$rnoSyasin8 = $this->request->data ['urlsyasin8'];
					$rnoSyasin9 = $this->request->data ['urlsyasin9'];
					if (! isset ( $this->request->data ['syasinTitle'] )) {
						$syasinTitle = $this->request->data ['urltitle'];
					} else {
						$syasinTitle = $this->request->data ['syasinTitle'];
					}
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
					if (! isset ( $this->request->data ['syasin4Title'] )) {
						$syasin4Title = $this->request->data ['urltitle4'];
					} else {
						$syasin4Title = $this->request->data ['syasin4Title'];
					}
					if (! isset ( $this->request->data ['syasin5Title'] )) {
						$syasin5Title = $this->request->data ['urltitle5'];
					} else {
						$syasin5Title = $this->request->data ['syasin5Title'];
					}
					if (! isset ( $this->request->data ['syasin6Title'] )) {
						$syasin6Title = $this->request->data ['urltitle6'];
					} else {
						$syasin6Title = $this->request->data ['syasin6Title'];
					}
					if (! isset ( $this->request->data ['syasin7Title'] )) {
						$syasin7Title = $this->request->data ['urltitle7'];
					} else {
						$syasin7Title = $this->request->data ['syasin7Title'];
					}
					if (! isset ( $this->request->data ['syasin8Title'] )) {
						$syasin8Title = $this->request->data ['urltitle8'];
					} else {
						$syasin8Title = $this->request->data ['syasin8Title'];
					}
					if (! isset ( $this->request->data ['syasin9Title'] )) {
						$syasin9Title = $this->request->data ['urltitle9'];
					} else {
						$syasin9Title = $this->request->data ['syasin9Title'];
					}
					// 写真
					$rno=0;
					if($this->request->data ['reset'] == "1") {
						$syasin = '';
						$this->deleteTSyasin ($isyasinkey,'1');
					} else if(!empty($_FILES ['syasin'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin'] ['tmp_name'] )) {
							$syasin = fread ( fopen ( $_FILES ['syasin'] ['tmp_name'], "r" ), $_FILES ['syasin'] ['size'] );
							if (empty ( $rnoSyasin )) {
								$rno = '1';
								$this->insertTSyasin ( $isyasinkey, $rno, $this->request->data ['syasinTitle'], $syasin, $torokuDate );
								$isyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = '1';
								$this->updateTSyasin ( $isyasinkey, $rno, $this->request->data ['syasinTitle'], $syasin, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasinTitle'])) {
						$this->updateTSyasintitle( $isyasinkey, $rnoSyasin, $syasinTitle);
					}
					$rno=0;
					if($this->request->data ['reset1'] == "1") {
						$syasin1 = '';
						$this->deleteTSyasin ($ssyasinkey,'1');
					} else if(!empty($_FILES ['syasin1'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
							$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size'] );
							if (empty ( $rnoSyasin1 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin1Title'], $syasin1, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin1;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin1Title'], $syasin1, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin1Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin1, $syasin1Title);
					}
					if(!empty($rnoSyasin1)) {
						$rno = $rnoSyasin1;
					}
					if($this->request->data ['reset2'] == "1") {
						$syasin2 = '';
						$this->deleteTSyasin ($ssyasinkey,'2');
					} else if(!empty($_FILES ['syasin2'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) {
							$syasin2 = fread ( fopen ( $_FILES ['syasin2'] ['tmp_name'], "r" ), $_FILES ['syasin2'] ['size'] );
							if (empty ( $rnoSyasin2 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin2Title'], $syasin2, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin2;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin2Title'], $syasin2, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin2Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin2, $syasin2Title);
					}
					if(!empty($rnoSyasin2)) {
						$rno = $rnoSyasin2;
					}
					if($this->request->data ['reset3'] == "1") {
						$syasin3 = '';
						$this->deleteTSyasin ($ssyasinkey,'3');
					} else if(!empty($_FILES ['syasin3'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] )) {
							$syasin3 = fread ( fopen ( $_FILES ['syasin3'] ['tmp_name'], "r" ), $_FILES ['syasin3'] ['size'] );
							if (empty ( $rnoSyasin3 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin3Title'], $syasin3, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin3;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin3Title'], $syasin3, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin3Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin3, $syasin3Title);
					}
					if(!empty($rnoSyasin3)) {
						$rno = $rnoSyasin3;
					}
					if($this->request->data ['reset4'] == "1") {
						$syasin4 = '';
						$this->deleteTSyasin ($ssyasinkey,'4');
					} else if(!empty($_FILES ['syasin4'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin4'] ['tmp_name'] )) {
							$syasin4 = fread ( fopen ( $_FILES ['syasin4'] ['tmp_name'], "r" ), $_FILES ['syasin4'] ['size'] );
							if (empty ( $rnoSyasin4 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin4Title'], $syasin4, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin4;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin4Title'], $syasin4, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin4Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin4, $syasin4Title);
					}
					if(!empty($rnoSyasin4)) {
						$rno = $rnoSyasin4;
					}
					if($this->request->data ['reset5'] == "1") {
						$syasin5 = '';
						$this->deleteTSyasin ($ssyasinkey,'5');
					} else if(!empty($_FILES ['syasin5'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin5'] ['tmp_name'] )) {
							$syasin5 = fread ( fopen ( $_FILES ['syasin5'] ['tmp_name'], "r" ), $_FILES ['syasin5'] ['size'] );
							if (empty ( $rnoSyasin5 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin5Title'], $syasin5, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin5;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin5Title'], $syasin5, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin5Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin5, $syasin5Title);
					}
					if(!empty($rnoSyasin5)) {
						$rno = $rnoSyasin5;
					}
					if($this->request->data ['reset6'] == "1") {
						$syasin6 = '';
						$this->deleteTSyasin ($ssyasinkey,'6');
					} else if(!empty($_FILES ['syasin6'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin6'] ['tmp_name'] )) {
							$syasin6 = fread ( fopen ( $_FILES ['syasin6'] ['tmp_name'], "r" ), $_FILES ['syasin6'] ['size'] );
							if (empty ( $rnoSyasin6 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin6Title'], $syasin6, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin6;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin6Title'], $syasin6, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin6Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin6, $syasin6Title);
					}
					if(!empty($rnoSyasin6)) {
						$rno = $rnoSyasin6;
					}
					if($this->request->data ['reset7'] == "1") {
						$syasin7 = '';
						$this->deleteTSyasin ($ssyasinkey,'7');
					} else if(!empty($_FILES ['syasin7'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin7'] ['tmp_name'] )) {
							$syasin7 = fread ( fopen ( $_FILES ['syasin7'] ['tmp_name'], "r" ), $_FILES ['syasin7'] ['size'] );
							if (empty ( $rnoSyasin7 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin7Title'], $syasin7, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin7;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin7Title'], $syasin7, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin7Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin7, $syasin7Title);
					}
					if(!empty($rnoSyasin7)) {
						$rno = $rnoSyasin7;
					}
					if($this->request->data ['reset8'] == "1") {
						$syasin8 = '';
						$this->deleteTSyasin ($ssyasinkey,'8');
					} else if(!empty($_FILES ['syasin8'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin8'] ['tmp_name'] )) {
							$syasin8 = fread ( fopen ( $_FILES ['syasin8'] ['tmp_name'], "r" ), $_FILES ['syasin8'] ['size'] );
							if (empty ( $rnoSyasin8 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin8Title'], $syasin8, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin8;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin8Title'], $syasin8, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin8Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin8, $syasin8Title);
					}
					if(!empty($rnoSyasin8)) {
						$rno = $rnoSyasin8;
					}
					if($this->request->data ['reset9'] == "1") {
						$syasin9 = '';
						$this->deleteTSyasin ($ssyasinkey,'9');
					} else if(!empty($_FILES ['syasin9'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin9'] ['tmp_name'] )) {
							$syasin9 = fread ( fopen ( $_FILES ['syasin9'] ['tmp_name'], "r" ), $_FILES ['syasin9'] ['size'] );
							if (empty ( $rnoSyasin9 )) {
								$rno ++;
								$this->insertTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin9Title'], $syasin9, $torokuDate );
								$ssyasinkey = $this->TSyasin->getLastInsertId();
							} else {
								$rno = $rnoSyasin9;
								$this->updateTSyasin ( $ssyasinkey, $rno, $this->request->data ['syasin9Title'], $syasin9, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasin9Title'])) {
						$this->updateTSyasintitle( $ssyasinkey, $rnoSyasin9, $syasin9Title);
					}
					$this->insertupdate ( $this->request->data, $isyasinkey, $ssyasinkey, $torokuDate);

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
								$subject_mail = '【確認・通知】　委員会紹介情報更新';
								$msg_mail = $this->mailText ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ($allmailaddrs);
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TIinkai->validationErrors;
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
						'controller' => 'AdminCommitteInfo',
						'action' => 'edit' 
				] );
			}
			$db_TIinkai->commit();
			$db_TSyasin->commit();
		} catch (Exception $e) {
			$db_TIinkai->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		exit();
	}
	/**
	 * 画面名：委員会紹介情報編集
	 * 機能名：通知メール送信
	 * 
	 * @param
	 *        	引継ぎ情報 columnValue
	 * @param
	 *        	システム日時 systemDateTime
	 * @return string
	 */
	private function mailText($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> 委員会紹介情報情報の更新を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDate ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>委　員　会　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['iinkainm'] . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
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
		try {
			// 項目の値セット
			$columnValue = array (
				'rno' => $rno,
				'bunrui' => $this->Constants->COMMITTEEINFO,
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
			$db_TIinkai->rollback();
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
	 * 　機能名：写真情報更新処理
	 */
	private function updateTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		try {
			$db = $this->TSyasin->getDataSource ();
			// 項目の値セット
			$columnValue = array (
				'title' => $db->value ($title),
				'syasin' => $db->value ($syasin),
				'kousincd' => $db->value ($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']),
				'kousindt' => $db->value ($tourokudt) 
			);
			$conditions = array (
				'syasinkey' => $syasinkey,
				'rno' => $rno
			);
			// ファイル情報に更新
			if (!$this->TSyasin->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TIinkai->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：委員会紹介情報編集
	 *　機能名：写真の削除し
	 */
	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TIinkai->rollback();
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
	 * 　機能名：写真タイトル情報更新処理
	 */
	private function updateTSyasintitle($syasinkey, $rno, $title) {
		try {
			// 項目の値セット
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
				'title' => $db->value ( $title ),
				'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
				'kousindt' => $db->value ( $this->Common->getSystemDateTime () )
			);
			$conditions = array (
				'syasinkey' => $syasinkey,
				'rno' => $rno
			);
			// 写真情報に登録
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TIinkai->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　画面名：委員会紹介情報編集
	 * 　機能名：写真情報の写真を取得
	 */
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
}
?>