<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * お知らせ一覧 Controller
 *
 * お知らせ一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminNewsController extends AppController {
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
			'TOsirase',
			'TSyasin',
			'MKoukai',
			'TFile',
			'TKaiin',
			'MTuuci'
	);
	// レイアウト無し
	public $autoLayout = false;
	/**
	 * 　画面名：お知らせ一覧
	 * 　機能名：お知らせ一覧
	 */
	public function index() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseInfo'] == $this->Constants->HYOJI) {
			if (! $this->Session->read ( 'errorMsg.errorflag' )) {
				$this->Session->delete ( 'errorMsg' );
			}
			$oshiraseDtFrm = date('Y/m', strtotime('-2 years'));
			$this->Session->write ( "errorMsg.errorflag", false );
			$this->set ( [ 
					'oshirasei' => '',
					'oshiraseDtFrm' => $oshiraseDtFrm,
					'oshiraseDtTo' => '',
					'free_word' => '' 
			] );
			$this->render ( '/Admin/News/list' );
		} else {
			$this->redirect ( [ 
					'controller' => 'admin' 
			] );
		}
	}
	/**
	 * 　画面名：お知らせ一覧の検索
	 * 　機能名：お知らせ一覧の検索処理
	 */
	public function search() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if($this->Session->check('previousPageInfo')) {
				$this->request->data = $this->Session->read('previousPageInfo');
				$this->request->data['free-word'] = $this->request->data['free_word']; 
				$this->Session->delete('previousPageInfo');
			}
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseInfo'] == $this->Constants->HYOJI) {	
				if (! $this->Session->read ( 'Auth.User.osiraseDel.sessionFlg' )) {
					$this->Session->delete ( 'Auth.User.osiraseDel' );
				}
				$this->Session->write ( "Auth.User.osiraseDel.sessionFlg", false );
				if (! $this->Session->read ( 'errorMsg.errorflag' )) {
					$this->Session->delete ( 'errorMsg' );
				}
				$this->Session->write ( "errorMsg.errorflag", false );
				$this->Session->delete ( 'Auth.User.News.previewInfo' );
				if (! empty ( $this->request->data ) || $this->Session->read ( 'Auth.User.osiraseDel.delflg' )) {
					if (! empty ( $this->request->data ['menu'] )) {
								$oshiraseDtFrm = $this->request->data ['menu'] ['oshiraseDtFrm'];
								$oshiraseDtTo = $this->request->data ['menu'] ['oshiraseDtTo'];
								$free_word = $this->request->data ['menu'] ['free_word'];
					} else if (! empty ( $this->request->data )) {
						$oshiraseDtFrm = $this->request->data ['oshiraseDtFrm'];
						$oshiraseDtTo = $this->request->data ['oshiraseDtTo'];
						$free_word = $this->request->data ['free-word'];
					} else {
						$oshiraseDtFrm = $this->Session->read ( 'Auth.User.osiraseDel.oshiraseDtFrm' );
						$oshiraseDtTo = $this->Session->read ( 'Auth.User.osiraseDel.oshiraseDtTo' );
						$free_word = $this->Session->read ( 'Auth.User.osiraseDel.free_word' );
					}
					if (! empty ( $oshiraseDtFrm )) {
						$st_date = $this->Common->fromDate ( str_replace ( '/', '-', $oshiraseDtFrm ) );
					} else {
						$st_date = '';
					}
					if (! empty ( $oshiraseDtTo )) {
						$en_date = $this->Common->getLastDateOfMonth ( str_replace ( '/', '-', $oshiraseDtTo ) );
					} else {
						$en_date = '';
					}
					$flashError = false;
					if (! empty ( $en_date ) && $st_date > $en_date) {
						$this->Session->setFlash ("期間のFrom、Toを正しく入力してください。");
						$this->set ( [ 
								'oshirasei' => '',
								'oshiraseDtFrm' => $oshiraseDtFrm,
								'oshiraseDtTo' => $oshiraseDtTo,
								'free_word' => $free_word 
						] );
						$flashError = true;
					}
					if (! $flashError) {
						$conditions = array ();
						if (! empty ( $st_date )) {
							$conditions [] = array (
									'TOsirase.osirasedt >=' => $st_date 
							);
						}
						if (! empty ( $en_date )) {
							$conditions [] = array (
									'TOsirase.osirasedt <=' => $en_date 
							);
						}
						if (! empty ( $free_word )) {
							$conditions [] = array ('OR' => array (
													array ('TOsirase.title LIKE ' => "%$free_word%" ),
													array ('TOsirase.naiyo LIKE ' => "%$free_word%") ) 
							);
						}
						$query = $this->TOsirase->find ( 'all', array (
								'joins' => array (
										array (
												'table' => $this->MKoukai,
												'alias' => 'mkou',
												'type' => 'LEFT',
												'conditions' => array (
														'mkou.koukaicd = TOsirase.koukaikbn',
														'mkou.fromdt <= IF(TOsirase.kousindt ="0000-00-00 00:00:00" OR TOsirase.kousindt IS NULL, DATE(TOsirase.tourokudt), DATE(TOsirase.kousindt))',
														'mkou.todt >= IF(TOsirase.kousindt ="0000-00-00 00:00:00" OR TOsirase.kousindt IS NULL, DATE(TOsirase.tourokudt), DATE(TOsirase.kousindt))' 
												) 
										) 
								),
								'fields' => array (
										'mkou.koukainm', // 公開区分名称
										'TOsirase.arno', // 連番
										'TOsirase.title', // お知らせタイトル
										'TOsirase.koukaikbn', // 公開区分
										'TOsirase.syasin',
										'TOsirase.file',
										'SUBSTRING(TOsirase.osirasedt, 1, 10) AS osirase_date',
										'REPLACE(SUBSTRING(IF(TOsirase.kousindt ="0000-00-00 00:00:00" OR TOsirase.kousindt IS NULL, TOsirase.tourokudt, TOsirase.kousindt), 1, 10), "-", "/")  as koushin_date' 
								), // 更新日時
								'conditions' => $conditions,
								'order' => array ('TOsirase.osirasedt DESC') 
						) );
						$cnt = count ( $query );
						if ($cnt == 0) {
							$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
						}
						$this->set ( [ 
								'oshirasei' => $query,
								'oshiraseDtFrm' => $oshiraseDtFrm,
								'oshiraseDtTo' => $oshiraseDtTo,
								'free_word' => $free_word 
						] );
					}
					$this->render ( '/Admin/News/list' );
				} else {
					$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
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
	 * 　画面名：お知らせ 新規追加
	 * 　機能名：お知らせの 新規追加処理
	 */
	public function add() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseAdd'] == $this->Constants->HYOJI) {
				if (! $this->Session->read ( 'errorMsg.errorflag' )) {
					$this->Session->delete ( 'errorMsg' );
				}
				$this->Session->write ( "errorMsg.errorflag", false );
				$this->Session->delete ( 'Auth.User.News.previewInfo' );
				// 公開区分のセット
				$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
				// 初期値のセット
				$this->set('kokaiVal', $this->Constants->INVAL);
				// 画面の移動
				$this->render ( '/Admin/News/add' );
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
	 * 　画面名：お知らせ 新規追加
	 * 　機能名：お知らせの 新規登録処理
	 */
	public function register() {
		try {
			$db_TOsirase = $this->TOsirase->getDataSource();
			$db_TOsirase->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$responseString = "";
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseAdd'] == $this->Constants->HYOJI) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->Session->delete ( 'Auth.User.News.previewInfo' );
				if (array_key_exists ( 'naiyo', $this->request->data )) {
					$syasinKeyVal = '';
					$fileKeyVal = '';
					$this->textarea_maxlength("naiyo",$this->request->data['naiyo'],1024,$responseString);
					$this->request->data['osirasedt'] = str_replace('/', '-', $this->request->data['osirasedate']).' '.$this->request->data['osirasetime'];
					$this->TOsirase->set ( $this->request->data );
					if ($this->TOsirase->validates ()) {
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
							if(isset($_FILES ['syasin2'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) {
									$syasin2 = fread ( fopen ( $_FILES ['syasin2'] ['tmp_name'], "r" ), $_FILES ['syasin2'] ['size'] );
									$rno ++;
									$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin2Title'], $syasin2, $torokuDate );
									$syasinKeyVal = $this->TSyasin->getLastInsertId();
								}
							}
							if(isset($_FILES ['syasin3'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] )) {
									$syasin3 = fread ( fopen ( $_FILES ['syasin3'] ['tmp_name'], "r" ), $_FILES ['syasin3'] ['size'] );
									$rno ++;
									$this->insertTSyasin ( $syasinKeyVal, $rno, $this->request->data ['syasin3Title'], $syasin3, $torokuDate );
									$syasinKeyVal = $this->TSyasin->getLastInsertId();
								}
							}
							$folderKeyVal = number_format(round(microtime(true) * 1000), 0, '', '');
							$newfolder = $this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal ;
							if(!is_dir($newfolder)){
								mkdir($newfolder, 0777, true);
							}
							chmod($newfolder, 0777);
							$fileRno = 0;
							if(isset($_FILES ['file1'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
									$file1 = $folderKeyVal.'/'.$_FILES ['file1'] ['name'];
									move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file1Title'], $file1, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
							if(isset($_FILES ['file2'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file2'] ['tmp_name'] )) {
									$file2 = $folderKeyVal.'/'.$_FILES ['file2'] ['name'];
									move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file2Title'], $file2, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
							if(isset($_FILES ['file3'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file3'] ['tmp_name'] )) {
									$file3 = $folderKeyVal.'/'.$_FILES ['file3'] ['name'];
									move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file3Title'], $file3, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
						}
						$this->insertTOsirase ( $this->request->data, $syasinKeyVal, $fileKeyVal, $torokuDate);

						$osiraseNotifyFlag = $this->fnOsiraseDateTimeExistingCheck($this->request->data['osirasedt']);

						if($this->request->data['koukaikbn'] == 0 && $osiraseNotifyFlag) {
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
											$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,2);
										}
									}
								}
							}
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
									$subject_mail = '【確認・通知】　お知らせ登録';
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
						$errors = $this->TOsirase->validationErrors;
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
							'controller' => 'adminNews',
							'action' => 'add' 
					] );
				}
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'ajaxRequestError' ] );
			}
			$db_TOsirase->commit();
			$db_TSyasin->commit();
			$db_TFile->commit();
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　画面名：お知らせ変更
	 * 　機能名：お知らせの変更処理
	 */
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TOsirase = $this->TOsirase->getDataSource();
			$db_TOsirase->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data['adminNewsregister'] = $this->request->data;
				$torokuDate = $this->Common->getSystemDateTime ();
				$syasinKeyVal = $this->request->data ['urlsyasinKey'];
				$fileKeyVal = $this->request->data ['urlfileKey'];
				$this->textarea_maxlength("naiyo",$this->request->data['naiyo'],1024,$responseString);
				$this->request->data['osirasedt'] = str_replace('/', '-', $this->request->data['osirasedate']).' '.$this->request->data['osirasetime'];
				$this->TOsirase->set ( $this->request->data );
				if ($this->TOsirase->validates ()) {
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
					if($this->request->data ['reset1'] == "1") {
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
					if($this->request->data ['reset2'] == "1") {
						$syasin2 = '';
						$this->deleteTSyasin ( $syasinKeyVal, '2');
					} else if (isset( $_FILES ['syasin2'] ['tmp_name'] )) {
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
					if($this->request->data ['reset3'] == "1") {
						$syasin3 = '';
						$this->deleteTSyasin ( $syasinKeyVal, '3');
					} else if (isset( $_FILES ['syasin3'] ['tmp_name'] )) {
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
					$rnoFile1 = $this->request->data ['urlfile1'];
					$rnoFile2 = $this->request->data ['urlfile2'];
					$rnoFile3 = $this->request->data ['urlfile3'];
					if (! isset ( $this->request->data ['file1Title'] )) {
						$file1Title = $this->request->data ['urlfiletitle1'];
					} else {
						$file1Title = $this->request->data ['file1Title'];
					}
					if (! isset ( $this->request->data ['file2Title'] )) {
						$file2Title = $this->request->data ['urlfiletitle2'];
					} else {
						$file2Title = $this->request->data ['file2Title'];
					}
					if (! isset ( $this->request->data ['file3Title'] )) {
						$file3Title = $this->request->data ['urlfiletitle3'];
					} else {
						$file3Title = $this->request->data ['file3Title'];
					}

					if(!empty($fileKeyVal)) {
						$filedata = $this->TFile->find ( 'first', array (
											'fields' => array('TFile.filepath'),
											'conditions' => array ('TFile.filekey ' => $fileKeyVal)
										));
						$foldername = split('/',$filedata['TFile']['filepath']); 
						$folderKeyVal = $foldername[0];
					} else {
						$folderKeyVal = number_format(round(microtime(true) * 1000), 0, '', '');
						$newfolder = $this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal ;
						if(!is_dir($newfolder)){
							mkdir($newfolder, 0777, true);
						}
						chmod($newfolder, 0777);
					}

					if($this->request->data ['resetfile1'] == "1") {
						$this->deletesingleTFile ($fileKeyVal,$folderKeyVal,'1');
						$file1 = '';
						$this->deleteTFile ( $fileKeyVal, '1');
					} else if (isset ( $_FILES ['file1'] ['tmp_name'] )) {
						if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
							$file1 = $folderKeyVal.'/'.$_FILES ['file1'] ['name'];
							if (empty ( $rnoFile1 )) {
								move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
								$fileRno = "1";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file1Title'], $file1, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
								$this->updateTFile ( $fileKeyVal, $rnoFile1, $file1Title, $folderKeyVal.'/'.$_FILES ['file1'] ['name'] );
							}
						}
					} else if(isset($this->request->data ['file1Title'])) {
							$this->updateTFiletitle( $fileKeyVal, $rnoFile1, $file1Title);
					}
					if($this->request->data ['resetfile2'] == "1") {
						$this->deletesingleTFile ($fileKeyVal,$folderKeyVal,'2');
						$file2 = '';
						$this->deleteTFile ( $fileKeyVal, '2');
					} else if (isset ( $_FILES ['file2'] ['tmp_name'] )) {
						if (is_uploaded_file ( $_FILES ['file2'] ['tmp_name'] )) {
							$file2 = $folderKeyVal.'/'.$_FILES ['file2'] ['name'];
							if (empty ( $rnoFile2 )) {
								move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
								$fileRno = "2";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file2Title'], $file2, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
								$this->updateTFile ( $fileKeyVal, $rnoFile2, $file2Title, $folderKeyVal.'/'.$_FILES ['file2'] ['name'] );
							}
						}
					} else if(isset($this->request->data ['file2Title'])) {
							$this->updateTFiletitle( $fileKeyVal, $rnoFile2, $file2Title);
					}
					if($this->request->data ['resetfile3'] == "1") {
						$this->deletesingleTFile ($fileKeyVal,$folderKeyVal,'3');
						$file3 = '';
						$this->deleteTFile( $fileKeyVal, '3');
					} else if (isset ( $_FILES ['file3'] ['tmp_name'] )) {
						if (is_uploaded_file ( $_FILES ['file3'] ['tmp_name'] )) {
							$file3 = $folderKeyVal.'/'.$_FILES ['file3'] ['name'];
							if (empty ( $rnoFile3 )) {
								move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
								$fileRno = "3";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file3Title'], $file3, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
								$this->updateTFile ( $fileKeyVal, $rnoFile3, $file3Title, $folderKeyVal.'/'.$_FILES ['file3'] ['name'] );
							}
						}
					} else if(isset($this->request->data ['file3Title'])) {
							$this->updateTFiletitle( $fileKeyVal, $rnoFile3, $file3Title);
					}
					$this->updateTOsirase ( $this->request->data, $syasinKeyVal, $fileKeyVal, $torokuDate );

					$osiraseNotifyFlag = $this->fnOsiraseDateTimeExistingCheck($this->request->data['osirasedt']);

					if($this->request->data['koukaikbn'] == 0 && $osiraseNotifyFlag) {
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
										$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,2);
									}
								}
							}
						}
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
								$subject_mail = '【確認・通知】　お知らせ更新';
								$msg_mail = $this->mailTextUpdate ( $this->request->data, $torokuDate );
								$mail = new CakeEmail ( 'smtp' );
								$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
								$mail->to ($allmailaddrs);
								$mail->subject ( $subject_mail );
								$mail->emailFormat ( 'html' );
								$mail->send ( $msg_mail );
							}
						}
					}
					$this->syashinkeydelete($syasinKeyVal,$this->request->data['adminNewsregister']['id']);
					$this->filekeydelete($fileKeyVal,$this->request->data['adminNewsregister']['id'],$folderKeyVal);
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TOsirase->validationErrors;
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
			$db_TOsirase->commit();
			$db_TSyasin->commit();
			$db_TFile->commit();
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　画面名：お知らせ 編集
	 * 　機能名：お知らせ の編集処理
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if (! empty ( $this->request->data )) {
				// 公開区分のセット
				$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
				// 初期値のセット
				$this->set('kokaiVal', $this->Constants->INVAL);
				// ファイルパスの変数宣言。
				$path1file = "";
				$path2file = "";
				$path3file = "";
				$arno = $this->request->data ['adminNewsedit'] ['id'];
				$oshiraseDtFrm =  $this->request->data ['adminNewsedit'] ['oshiraseDtFrm'];
				$oshiraseDtTo =  $this->request->data ['adminNewsedit'] ['oshiraseDtTo'];
				$free_word = $this->request->data ['adminNewsedit'] ['free_word'];
				$oshiraseishousai = $this->TOsirase->find ( 'all', array (
						'conditions' => array (
								'arno' => $arno 
						) 
				) );
				if ($oshiraseishousai['0']['TOsirase']['osirasedt'] == "0000-00-00 00:00:00") {
					$oshiraseishousai['0']['TOsirase']['osirasedt'] = "";
				}
				$filekeyval = $oshiraseishousai['0']['TOsirase']['file'];
				$syasinKey = $this->request->data ['adminNewsedit'] ['syasinKey'];
				$koukaikbnval = $oshiraseishousai['0']['TOsirase']['koukaikbn'];
				$this->set ( 'oshiraseishousai', $oshiraseishousai );
				$syasinshousai = $this->TSyasin->find ( 'all', array (
						'conditions' => array (
								'syasinkey' => $syasinKey 
						) 
				) );
				$fileDataval = $this->TFile->find ( 'all', array (
						'conditions' => array (
								'filekey' => $filekeyval
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
				$fileData = array (
						'file1' => '',
						'file2' => '',
						'file3' => '',
						'filetitle1' => '',
						'filetitle2' => '',
						'filetitle3' => ''
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
				foreach ( $fileDataval as $fileVal ) {
					if ($fileVal ['TFile'] ['rno'] == 1) {
						$fileData ['file1'] = $fileVal ['TFile'] ['rno'];
						$fileData ['filetitle1'] = $fileVal ['TFile'] ['title'];
						$path1file = $this->getFile($fileData ['file1'],$filekeyval);
					}
					if ($fileVal ['TFile'] ['rno'] == 2) {
						$fileData ['file2'] = $fileVal ['TFile'] ['rno'];
						$fileData ['filetitle2'] = $fileVal ['TFile'] ['title'];
						$path2file = $this->getFile($fileData ['file2'],$filekeyval);
					}
					if ($fileVal ['TFile'] ['rno'] == 3) {
						$fileData ['file3'] = $fileVal ['TFile'] ['rno'];
						$fileData ['filetitle3'] = $fileVal ['TFile'] ['title'];
						$path3file = $this->getFile($fileData ['file3'],$filekeyval);
					}
				}
				$this->set ( [ 
						'syasinData' => $syasinData,
						'syasinKey' => $syasinKey,
						'syasinshousai' => $syasinshousai,
						'fileData' => $fileData,
						'filekeyval' => $filekeyval,
						'oshiraseDtFrm' => $oshiraseDtFrm,
						'oshiraseDtTo' => $oshiraseDtTo,
						'free_word' => $free_word,
						'koukaikbnval' => $koukaikbnval,
						'path1file' => $path1file,
						'path2file' => $path2file,
						'path3file' => $path3file,
						'osiraseFilePath' => $this->Constants->OSIRASE_FILE_PATH,
				] );
				// 画面の移動
				$this->render ( '/Admin/News/edit' );
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
	 * 　画面名：お知らせ 削除
	 * 　機能名：お知らせ の削除処理
	 */
	public function delete() {
		try {
			$responseString = "0";
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseInfo'] == $this->Constants->HYOJI) {
				$arno = $this->request->data['arno'];
				$syasin = $this->request->data['syasinKey'];
				$filekey = $this->request->data['filekey'];
				$this->TOsirase->delete ( $arno );
				$filedata = $this->TFile->find ( 'first', array (
									'fields' => array('TFile.filepath'),
									'conditions' => array ('TFile.filekey ' => $filekey)
								));
				if(!empty($syasin) && $syasin != null && $syasin != 0 ) {
					$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasin ");
				}
				if(!empty($filekey) && $filekey != null && $filekey != 0 ) {
					$this->TFile->query(" DELETE FROM t_file WHERE filekey = $filekey ");
				}
				if(isset($filedata['TFile']['filepath'])) {
					$folderKeyVal  = split("/", $filedata['TFile']['filepath']);
					$dir = $this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal[0];
					if (is_dir($dir)) {
						$handle=opendir($dir);
						while (($file = readdir($handle))!==false) {
							@unlink($dir.'/'.$file);
						}
						rmdir($dir);
					}
				}
				$responseString = "1";
			}
			echo $responseString;
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　画面名：お知らせ プレビュー
	 * 　機能名：お知らせ のプレビュー処理
	 */
	public function preview() {
		if ($_SESSION ['Auth'] ['User'] ['Menu'] ['oshiraseAdd'] == $this->Constants->HYOJI) {
			// 画面の移動
			$this->render ( '/Admin/News/preview' );
		} else {
			$this->redirect ( [ 
					'controller' => 'admin',
					'action' => 'logout' 
			] );
		}
	}
	/**
	 * 　画面名：お知らせ 編集
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
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報登録
	 */
	private function insertTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		// 項目の値セット
		try {
				$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->OSHIRASE,
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
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
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
	private function insertTFile($filekey, $rno, $title, $file, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->OSHIRASE,
					'title' => $title,
					'filepath' => $file,
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if(!empty($filekey)) {
				$columnValue['filekey'] = $filekey;
			}
			// 写真情報作成
			$this->TFile->create ();
			// 写真情報に登録
			if (!$this->TFile->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報更新
	 */
	private function updateTSyasin($syasinkey, $rno, $title, $syasin) {
		// 項目の値セット
		try {
			$db = $this->TSyasin->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'syasin' => $db->value ( $syasin ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () ) 
			);
			$conditions = array (
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno 
			);
			// 写真情報に更新
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：写真情報
	 * 　機能名：写真情報タイトルの更新
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
					'TSyasin.syasinkey' => $syasinkey,
					'TSyasin.rno' => $rno
			);
			// 写真情報に更新
			$this->TSyasin->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：ファイル情報
	 * 　機能名：ファイル情報更新
	 */
	private function updateTFile($filekeyVal, $rno, $title, $filepath) {
		// 項目の値セット
		try {
			$db = $this->TFile->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'filepath' => $db->value ( $filepath ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () )
			);
			$conditions = array (
					'TFile.filekey ' => $filekeyVal,
					'TFile.rno' => $rno
			);
			// ファイル情報に更新
			$this->TFile->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：ファイル情報
	 * 　機能名：ファイル情報タイトルの更新
	 */
	private function updateTFiletitle($filekeyVal, $rno, $title) {
		// 項目の値セット
		try {
			$db = $this->TFile->getDataSource ();
			$columnValue = array (
					'title' => $db->value ( $title ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () )
			);
			$conditions = array (
					'TFile.filekey ' => $filekeyVal,
					'TFile.rno' => $rno
			);
			// ファイル情報に更新
			$this->TFile->updateAll ( $columnValue, $conditions );
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：お知らせ情報
	 * 　機能名：お知らせ情報登録
	 */
	private function insertTOsirase($request, $syasin, $file, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					'osirasedt' => $request ['osirasedt'],
					'title' => $request ['title'],
					'naiyo' => $request ['naiyo'],
					'syasin' => $syasin,
					'file' => $file,
					'koukaikbn' => $request ['koukaikbn'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// お知らせ情報作成
			$this->TOsirase->create ();
			// お知らせ情報に登録
			if (!$this->TOsirase->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
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
	private function updateTOsirase($request, $syasin, $file, $kousinDate) {
		// 項目の値セット
		try {
			$columnValue = array (
					'arno' => $request ['adminNewsregister'] ['id'],
					'osirasedt' => $request ['osirasedt'],
					'title' => $request ['title'],
					'naiyo' => $request ['naiyo'],
					'syasin' => $syasin,
					'file' => $file,
					'koukaikbn' => $request ['koukaikbn'],
					'kousincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'kousindt' => $kousinDate 
			);
			// お知らせ情報に登録
			if (!$this->TOsirase->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 画面名：お知らせ_新規追加
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
		$message .= "<p> お知らせ情報の新規追加を行いました。</p>\n";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>更　新　日　付</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDateTime ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>タ　イ　ト　ル</td><td $braceWidth>】</td>
						<td $maxwidth>" . $request ['title'] . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}
	/**
	 * 画面名：お知らせ_更新
	 * 機能名：通知メール送信
	 * 
	 * @param
	 *        	引継ぎ情報 columnValue
	 * @param
	 *        	システム日時 systemDateTime
	 * @return string
	 */
	private function mailTextUpdate($request, $systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "";
		$message .= "<p>各位</p>\n";
		$message .= "\n";
		$message .= "<p> お知らせ情報の更新を行いました。</p>\n";
		$message .= "<p> ※未公開の場合は、内容の確認をお願い致します。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td>
						<td $titleWidth>更　新　日　付</td>
						<td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDateTime ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td>
						<td $titleWidth>タ　イ　ト　ル</td>
						<td $braceWidth>】</td>
						<td $maxwidth>" . $request ['title'] . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご確認宜しくお願い致します。</p>";
		return $message;
	}

	/**
	 * 　画面名：会員企業
	 * 　機能名：写真情報の写真を取得
	 */
	public function getViewSyasin($syasinName) {
		try {
			$previewInfo = $this->Session->read ( 'Auth.User.News.previewInfo' );
			$this->autoRender = false;
			header ( 'Content-type: image/jpeg' );
			header ( 'Content-length: ' . strlen ( $previewInfo [$syasinName] ) );
			echo $previewInfo [$syasinName];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　画面名：会員企業
	 * 　機能名：写真情報の写真を取得
	 */
	public function getViewfile($fileName) {
		try {
			$previewInfo = $this->Session->read ( 'Auth.User.News.previewInfo' );
			$this->autoRender = false;
			header ( 'Content-type: ' . $previewInfo [$fileName . 'Type'] );
			header ( 'Content-length: ' . $previewInfo [$fileName . 'Size'] );
			header ( 'Content-Disposition: attachment; filename=' . $previewInfo [$fileName . 'Name'] );
			echo $previewInfo [$fileName];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * 　テーブル名：ファイル情報
	 * 　機能名：ファイルを取得処理
	 */
	public function getFile($id, $filekey) {
		try {
			$filedata = $this->TFile->find ( 'first', array (
					'fields' => array('TFile.filepath'),
					'conditions' => array (
							'TFile.rno ' => $id,
							'TFile.filekey ' => $filekey
					)
			) );
			return $filedata['TFile']['filepath'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * テーブル名：写真情報
	 *　機能名：写真の削除処理
	 */
	private function deleteTSyasin ($syasinkey,$rno) {
		try {
			$this->TSyasin->query(" DELETE FROM t_syasin WHERE syasinkey = $syasinkey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * テーブル名：ファイル情報
	 *　機能名：ファイルの削除処理
	 */
	public function deleteTFile ($filekey,$rno) {
		try {
			$this->TFile->query(" DELETE FROM t_file WHERE filekey = $filekey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　画面名：会員削除
	 *　機能名：一つファイルの削除処理
	 */
	public function deletesingleTFile ($fileKeyVal,$folderKeyVal,$rno) {
		try {
			$filedata = $this->TFile->find ( 'first', array (
							'fields' => array('TFile.filepath'),
							'conditions' => array ('TFile.filekey ' => $fileKeyVal, 'TFile.rno ' => $rno )
						));
			$dir = $this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal;
			if (is_dir($dir)) {
				$handle=opendir($dir);
				$file = readdir($handle);
				unlink($this->Constants->OSIRASE_FULL_FILE_PATH.$filedata['TFile']['filepath']);
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
	 *　機能名：検証チェック処理
	 */
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$responseString) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if(mb_strlen($dummy_str) > $maxlen) {
			$responseString .= $fname."##最大文字数を超えています。";
			print_r($responseString);
			exit();
		}
	}
	/**
	 *　機能名：写真キー削除処理
	 */
	private function syashinkeydelete($syasinkey,$arno) {
		try {
			$syashincntchk = $this->TSyasin->find ( 'all', array (
							'fields' => array('TSyasin.syasinkey'),
							'conditions' => array ('TSyasin.syasinkey ' => $syasinkey )));
			if(count($syashincntchk) == 0) {
				$columnValue = array ('syasin' => 0);
				$conditions = array ('arno' => $arno);
				$this->TOsirase->updateAll ( $columnValue, $conditions );
			}
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 *　機能名：ファイルキー削除処理
	 */
	private function filekeydelete($fileKeyVal,$arno,$folderKeyVal) {
		try {
			$filecntchk = $this->TFile->find ( 'all', array (
							'fields' => array('TFile.filekey'),
							'conditions' => array ('TFile.filekey ' => $fileKeyVal )));
			if(count($filecntchk) == 0) {
				$columnValue = array ('file' => 0);
				$conditions = array ('arno' => $arno);
				$this->TOsirase->updateAll ( $columnValue, $conditions );
				$dir = $this->Constants->OSIRASE_FULL_FILE_PATH.$folderKeyVal;
				if (is_dir($dir)) {
					$handle=opendir($dir);
					while (($file = readdir($handle))!==false) {
						@unlink($dir.'/'.$file);
					}
					rmdir($dir);
				}
			}
		} catch (Exception $e) {
			$db_TOsirase->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}

	private function fnOsiraseDateTimeExistingCheck($osiraseDateTime) {
		$currentDateTime = date('Y-m-d H:i');
		if($currentDateTime < $osiraseDateTime){
			return false;
		}
		return true;
	}
}