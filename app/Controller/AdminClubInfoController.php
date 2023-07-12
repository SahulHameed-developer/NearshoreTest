<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * 倶楽部紹介情報 Controller
 *
 * 倶楽部紹介情報を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminClubInfoController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common','Session');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MKurabu','MKoukai','TKurabu','TSyasin','MTuuci');
	// レイアウト無し
	public $autoLayout = false;

	/**
	 * 　画面名：倶楽部紹介情報編集
	 * 　機能名：倶楽部紹介情報の編集処理
	 */
	public function edit(){
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$this->Session->write ( "Footer.scroll_val", 0 );
		// 倶楽部情報の名前セット
		$this->set('clubnm', $this->Common->getClubName($this->MKurabu));
		$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		$this->set('kokaiVal', $this->Constants->INVAL);
		$this->set('kurabucd', '');
		$this->set('disflg', 'true');
		$this->set('isyasinkey', '');
		$this->set('ssyasinkey', '');
		$this->set('upflg', 'false');
		// 画面の移動
		$this->render ('/Admin/ClubInfo/edit');
	}
	/**
	 * 　画面名：倶楽部紹介情報編集
	 * 　機能名：倶楽部紹介情報の登録処理
	 */
	public function register(){
		$this->Session->write ( "Footer.scroll_val", 0 );
		try {
			$db_TKurabu = $this->TKurabu->getDataSource();
			$db_TKurabu->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$responseString = "";
			$requestData = $this->splitothersFields($this->request->data['otherFields']);
			$requestkurabu = $this->splitothersFields($this->request->data['otherFieldssearch']);
			$this->Session->delete ( 'Auth.User.News.previewInfo' );
			if (array_key_exists ( 'gaiyou', $requestData )) {
				$syasinKeyVal = $requestData['isyasinkey'];
				$ssyasinkey = $requestData['ssyasinkey'];
				$this->TKurabu->set ( $requestData );
				if ($this->TKurabu->validates ()) {
					$torokuDate = $this->Common->getSystemDateTime ();
					$rnoSyasin = $requestData['urlsyasin'];
					$rnoSyasin1 = $requestData['urlsyasin1'];
					$rnoSyasin2 = $requestData['urlsyasin2'];
					$rnoSyasin3 = $requestData['urlsyasin3'];
					$rnoSyasin4 = $requestData['urlsyasin4'];
					$rnoSyasin5 = $requestData['urlsyasin5'];
					$rnoSyasin6 = $requestData['urlsyasin6'];
					$rnoSyasin7 = $requestData['urlsyasin7'];
					$rnoSyasin8 = $requestData['urlsyasin8'];
					$rnoSyasin9 = $requestData['urlsyasin9']; 
					if (! isset ( $requestData['syasinTitle'] )) {
						$syasinTitle = $requestData['urltitle'];
					} else {
						$syasinTitle = $requestData['syasinTitle'];
					}
					if (! isset ( $requestData['syasin1Title'] )) {
						$syasin1Title = $requestData['urltitle1'];
					} else {
						$syasin1Title = $requestData['syasin1Title'];
					}
					if (! isset ( $requestData['syasin2Title'] )) {
						$syasin2Title = $requestData['urltitle2'];
					} else {
						$syasin2Title = $requestData['syasin2Title'];
					}
					if (! isset ( $requestData['syasin3Title'] )) {
						$syasin3Title = $requestData['urltitle3'];
					} else {
						$syasin3Title = $requestData['syasin3Title'];
					}
					if (! isset ( $requestData['syasin4Title'] )) {
						$syasin4Title = $requestData['urltitle4'];
					} else {
						$syasin4Title = $requestData['syasin4Title'];
					}
					if (! isset ( $requestData['syasin5Title'] )) {
						$syasin5Title = $requestData['urltitle5'];
					} else {
						$syasin5Title = $requestData['syasin5Title'];
					}
					if (! isset ( $requestData['syasin6Title'] )) {
						$syasin6Title = $requestData['urltitle6'];
					} else {
						$syasin6Title = $requestData['syasin6Title'];
					}
					if (! isset ( $requestData['syasin7Title'] )) {
						$syasin7Title = $requestData['urltitle7'];
					} else {
						$syasin7Title = $requestData['syasin7Title'];
					}
					if (! isset ( $requestData['syasin8Title'] )) {
						$syasin8Title = $requestData['urltitle8'];
					} else {
						$syasin8Title = $requestData['syasin8Title'];
					}
					if (! isset ( $requestData['syasin9Title'] )) {
						$syasin9Title = $requestData['urltitle9'];
					} else {
						$syasin9Title = $requestData['syasin9Title'];
					}
					$this->request->data = $requestData;
					// 写真
					if($this->request->data ['reset'] == "1") {
						$syasin = '';
						$this->deleteTSyasin ($syasinKeyVal,'1');
					} else if(!empty($_FILES ['syasin'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin'] ['tmp_name'] )) {
							$syasin = fread ( fopen ( $_FILES ['syasin'] ['tmp_name'], "r" ), $_FILES ['syasin'] ['size'] );
							if (empty ( $rnoSyasin )) {
								$rno = '1';
								$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasinTitle'], $syasin, $torokuDate );
								$syasinKeyVal = $this->TSyasin->getLastInsertId();
							} else {
								$rno ='1';
								$this->updateTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasinTitle'], $syasin, $torokuDate );
							}
						}
					} else if(isset($this->request->data ['syasinTitle'])) {
						$this->updateTSyasintitle( $syasinKeyVal, $rnoSyasin, $syasinTitle);
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
					$this->insertupdate ($requestData, $syasinKeyVal, $ssyasinkey , $torokuDate, $requestkurabu['kurabucd']);
					if (! empty ( $this->request->data ['mailchk'] )) {
						// 事務局へメール送信
						$mailInfo = $this->Common->getMailInfo ( $this->MTuuci );
						if (! empty ( $mailInfo )) {
							$filedata = $this->MKurabu->find ( 'first', array (
								'fields' => array('MKurabu.mailaddr'),
								'conditions' => array ('MKurabu.kurabucd ' => $requestkurabu['kurabucd'])
							));
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
								$subject_mail = '【確認・通知】　倶楽部紹介情報更新';
								$msg_mail = $this->mailText ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ($allmailaddrs);
								if (!empty($filedata) && $filedata['MKurabu']['mailaddr']!="") {
									$mail->cc($filedata['MKurabu']['mailaddr']);
								}
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TKurabu->validationErrors;
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
						'controller' => 'AdminClubInfo',
						'action' => 'edit' 
				] );
			}
			$db_TKurabu->commit();
			$db_TSyasin->commit();
		} catch (Exception $e) {
			$db_TKurabu->rollback();
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
	 * 画面名：倶楽部紹介情報編集
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
		$message .= "<p> 倶楽部紹介情報情報の更新を行いました。</p>";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDate ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>タ　イ　ト　ル</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['kurabunm'] . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	/**
	 * 　画面名：倶楽部紹介情報編集
	 * 　機能名：倶楽部紹介情報編集の検索処理
	 */
	public function search(){
		$this->Session->write ( "Footer.scroll_val", 0 );
		if($this->referer() == '/') {
				$this->redirect ( [
						'controller' => 'Error',
						'action' => 'systemError' ] );
		}
		try {
			$club = $this->TKurabu->find ( 'all', array (
										'fields' => array (
												'gaiyou',
												'syokumu',
												'kanji',
												'kmember',
												'njyoken',
												'nhouhou',
												'bikou',
												'isyasinkey',
												'ssyasinkey',
												'koukaikbn',
										),
										'conditions'=>array('kurabucd' => $this->request->data['kurabucd']),
										'order'=> array('TKurabu.kurabucd' => 'ASC')
								));
			$cnt = count ( $club );
			if ($cnt == 0) {
				$this->set('upflg', 'false');
				$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
			} else {
				$this->set('upflg', 'true');
			}
			$this->set ( ['club' => $club] );
			$syasinshousai= array();
			$syasinshousaisub= array();
			$isyasinkey="";
			$ssyasinkey="";
			if(isset($club[0]['TKurabu']['isyasinkey'])) {
				$syasinshousai = $this->TSyasin->find ( 'all', array (
							'conditions' => array (
									'syasinkey' => $club[0]['TKurabu']['isyasinkey'] 
							) 
					) );
				$isyasinkey = $club[0]['TKurabu']['isyasinkey'];
			}
			if(isset($club[0]['TKurabu']['isyasinkey'])) {
				$syasinshousaisub = $this->TSyasin->find ( 'all', array (
							'conditions' => array (
									'syasinkey' => $club[0]['TKurabu']['ssyasinkey'] 
							) 
					) );
				$ssyasinkey = $club[0]['TKurabu']['ssyasinkey'];
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
			$this->set('clubnm', $this->Common->getClubName($this->MKurabu));
			$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
			if (isset($club[0]['TKurabu']['koukaikbn'])) {
				$this->set('kokaiVal', $club[0]['TKurabu']['koukaikbn']);
			} else {
				$this->set('kokaiVal', $this->Constants->INVAL);
			}
			$this->set('kurabucd', $this->request->data['kurabucd']);
			$this->set('disflg', 'false');
			// 画面の移動
			$this->render ('/Admin/ClubInfo/edit');
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
	private function insertTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		try {
			// 項目の値セット
			$columnValue = array (
				'rno' => $rno,
				'bunrui' => $this->Constants->CLUBINFO,
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
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
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
	 * 　画面名：倶楽部紹介情報編集
	 * 　機能名：倶楽部紹介情報の新規追加・更新処理
	 */
	public function insertupdate($request, $isyasinkey, $ssyasinkey, $torokuDate, $kurabu) {
		$TKurabu = $this->TKurabu ($kurabu);
		$cnt = count ( $TKurabu );
		if ($cnt == 0) {
			$this->insertTKurabu ($request, $isyasinkey, $ssyasinkey, $torokuDate, $kurabu);
		} else {
			$this->updateTKurabu ($request, $isyasinkey, $ssyasinkey, $torokuDate, $kurabu);
		}
	}
	/**
	 *	倶楽部レコードを取得する。
	 **/
	public function TKurabu($kurabu) {
		$filedata = $this->TKurabu->find ( 'first', array (
										'fields' => array('kurabucd',
														'gaiyou',
														'syokumu',
														'kanji',
														'kmember',
														'njyoken',
														'nhouhou',
														'bikou'),
										'conditions' => array ('kurabucd ' => $kurabu)
									));
		return $filedata;
	}
	/**
	 * 　テーブル名：倶楽部
	 * 　機能名：倶楽部紹介情報登録
	 */
	private function insertTKurabu($request, $isyasinkey, $ssyasinkey, $torokuDate, $kurabu) {
		 try {
			$columnValue = array (
				'kurabucd' => $kurabu,
				'gaiyou' => $request['gaiyou'],
				'syokumu' => $request['syokumu'],
				'kanji' => $request['kanji'],
				'kmember' => $request['kmember'],
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
			// 倶楽部紹介情報作成
			$this->TKurabu->create ();
			// 倶楽部紹介情報に登録
			if (!$this->TKurabu->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) { 
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　テーブル名：倶楽部
	 * 　機能名：倶楽部紹介情報更新
	 */
	private function updateTKurabu($request, $isyasinkey, $ssyasinkey, $kousindt, $kurabu) {
		try {
			$db = $this->TKurabu->getDataSource ();
			$columnValue = array (
				'gaiyou' => $db->value ($request['gaiyou']),
				'syokumu' => $db->value ($request['syokumu']),
				'kanji' => $db->value ($request['kanji']),
				'kmember' => $db->value ($request['kmember']),
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
			$conditions = array ('kurabucd' => $kurabu);
			// 倶楽部情報に更新
			if (!$this->TKurabu->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　画面名：倶楽部紹介情報編集
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
	/**
	 *　画面名：倶楽部紹介情報編集
	 *　機能名：写真の削除処理
	 */
	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：倶楽部紹介情報編集
	 *　機能名：写真タイトルの更新処理
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
			// 写真情報に更新
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：倶楽部紹介情報編集
	 *　機能名：写真の更新処理
	 */
	private function updateTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		// 項目の値セット
		try {
			$db = $this->TSyasin->getDataSource ();
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
			// 写真情報に更新
			if (!$this->TSyasin->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TKurabu->rollback();
			$db_TSyasin->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
}
?>