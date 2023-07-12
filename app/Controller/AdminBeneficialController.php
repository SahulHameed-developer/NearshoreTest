<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * 有益一覧 Controller
 *
 * 有益一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminBeneficialController extends AppController {
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
			'TYueki',
			'TSyasin',
			'MKoukai',
			'TFile',
			'TKaiin',
			'MTuuci',
	);
	// レイアウト無し
	public $autoLayout = false;
	/**
	 * 　画面名：有益一覧
	 * 　機能名：有益一覧の表示する
	 */
	public function index() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		if ($_SESSION ['Auth'] ['User'] ['Menu'] ['yuekiInfo'] == $this->Constants->HYOJI) {
			if (! $this->Session->read ( 'errorMsg.errorflag' )) {
				$this->Session->delete ( 'errorMsg' );
			}
			$yuekiDtFrm = date('Y/m', strtotime('-2 years'));
			$this->Session->write ( "errorMsg.errorflag", false );
			$this->set ( [ 
					'yueki' => '',
					'yuekiDtFrm' => $yuekiDtFrm,
					'yuekiDtTo' => '',
					'free_word' => '' 
			] );
			// 画面の移動
			$this->render ( '/Admin/Beneficial/list' );
		} else {
			$this->redirect ( [ 
					'controller' => 'admin' 
			] );
		}
	}
	/**
	 * 　画面名：有益一覧
	 * 　機能名：有益一覧の検索処理
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
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['yuekiInfo'] == $this->Constants->HYOJI) {	
				if (! $this->Session->read ( 'Auth.User.yuekiDel.sessionFlg' )) {
					$this->Session->delete ( 'Auth.User.yuekiDel' );
				}
				$this->Session->write ( "Auth.User.yuekiDel.sessionFlg", false );
				if (! $this->Session->read ( 'errorMsg.errorflag' )) {
					$this->Session->delete ( 'errorMsg' );
				}
				$this->Session->write ( "errorMsg.errorflag", false );
				$this->Session->delete ( 'Auth.User.Beneficial.previewInfo' );
				if (! empty ( $this->request->data ) || $this->Session->read ( 'Auth.User.yuekiDel.delflg' )) {
					if (! empty ( $this->request->data ['menu'] )) {
								$yuekiDtFrm = $this->request->data ['menu'] ['yuekiDtFrm'];
								$yuekiDtTo = $this->request->data ['menu'] ['yuekiDtTo'];
								$free_word = $this->request->data ['menu'] ['free_word'];
					} else if (! empty ( $this->request->data )) {
						$yuekiDtFrm = $this->request->data ['yuekiDtFrm'];
						$yuekiDtTo = $this->request->data ['yuekiDtTo'];
						$free_word = $this->request->data ['free-word'];
					} else {
						$yuekiDtFrm = $this->Session->read ( 'Auth.User.yuekiDel.yuekiDtFrm' );
						$yuekiDtTo = $this->Session->read ( 'Auth.User.yuekiDel.yuekiDtTo' );
						$free_word = $this->Session->read ( 'Auth.User.yuekiDel.free_word' );
					}
					if (! empty ( $yuekiDtFrm )) {
						$st_date = $this->Common->fromDate ( str_replace ( '/', '-', $yuekiDtFrm ) );
					} else {
						$st_date = '';
					}
					if (! empty ( $yuekiDtTo )) {
						$en_date = $this->Common->getLastDateOfMonth ( str_replace ( '/', '-', $yuekiDtTo ) );
					} else {
						$en_date = '';
					}
					$flashError = false;
					if (! empty ( $en_date ) && $st_date > $en_date) {
						$this->Session->setFlash ("期間のFrom、Toを正しく入力してください。");
						$this->set ( [ 
								'yueki' => '',
								'yuekiDtFrm' => $yuekiDtFrm,
								'yuekiDtTo' => $yuekiDtTo,
								'free_word' => $free_word 
						] );
						$flashError = true;
					}
					if (! $flashError) {
						$conditions = array ();
						if (! empty ( $st_date )) {
							$conditions [] = array (
									'TYueki.jyohodt >=' => $st_date 
							);
						}
						if (! empty ( $en_date )) {
							$conditions [] = array (
									'TYueki.jyohodt <=' => $en_date 
							);
						}
						if (! empty ( $free_word )) {
							$conditions [] = array ('OR' => array (
													array ('TYueki.title LIKE ' => "%$free_word%" ),
													array ('TYueki.naiyo LIKE ' => "%$free_word%") ) 
							);
						}
						$query = $this->TYueki->find ( 'all', array (
								'joins' => array (
										array (
												'table' => $this->MKoukai,
												'alias' => 'mkou',
												'type' => 'LEFT',
												'conditions' => array (
														'mkou.koukaicd = TYueki.koukaikbn',
														'mkou.fromdt <= IF(TYueki.kousindt ="0000-00-00 00:00:00" OR TYueki.kousindt IS NULL, DATE(TYueki.tourokudt), DATE(TYueki.kousindt))',
														'mkou.todt >= IF(TYueki.kousindt ="0000-00-00 00:00:00" OR TYueki.kousindt IS NULL, DATE(TYueki.tourokudt), DATE(TYueki.kousindt))' 
												) 
										) 
								),
								'fields' => array (
										'mkou.koukainm', // 公開区分名称
										'TYueki.arno', // 連番
										'TYueki.kaiinnm',
										'TYueki.title', // 有益タイトル
										'TYueki.koukaikbn', // 公開区分
										'TYueki.syasin',
										'TYueki.file',
										'SUBSTRING(TYueki.jyohodt, 1, 10) AS yueki_date',
										'REPLACE(SUBSTRING(IF(TYueki.kousindt ="0000-00-00 00:00:00" OR TYueki.kousindt IS NULL, TYueki.tourokudt, TYueki.kousindt), 1, 10), "-", "/")  as koushin_date' 
								),
								'conditions' => $conditions,
								'order' => array ('TYueki.jyohodt DESC') 
						) );
						$cnt = count ( $query );
						if ($cnt == 0) {
							$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
						}
						$this->set ( [ 
								'yueki' => $query,
								'yuekiDtFrm' => $yuekiDtFrm,
								'yuekiDtTo' => $yuekiDtTo,
								'free_word' => $free_word 
						] );
					}
					// 画面の移動
					$this->render ( '/Admin/Beneficial/list' );
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
	 * 　画面名：有益編集
	 * 　機能名：有益の編集処理
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
				$arno = $this->request->data ['adminBeneficialedit'] ['id'];
				$yuekiDtFrm =  $this->request->data ['adminBeneficialedit'] ['yuekiDtFrm'];
				$yuekiDtTo =  $this->request->data ['adminBeneficialedit'] ['yuekiDtTo'];
				$free_word = $this->request->data ['adminBeneficialedit'] ['free_word'];
				$yuekishousai = $this->TYueki->find ( 'all', array (
						'conditions' => array (
								'arno' => $arno 
						) 
				) );
				if ($yuekishousai['0']['TYueki']['jyohodt'] == "0000-00-00 00:00:00") {
					$yuekishousai['0']['TYueki']['jyohodt'] = "";
				}
				$filekeyval = $yuekishousai['0']['TYueki']['file'];
				$syasinKey = $this->request->data ['adminBeneficialedit'] ['syasinKey'];
				$koukaikbnval = $yuekishousai['0']['TYueki']['koukaikbn'];
				$this->set ( 'yuekishousai', $yuekishousai );
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
						'yuekiDtFrm' => $yuekiDtFrm,
						'yuekiDtTo' => $yuekiDtTo,
						'free_word' => $free_word,
						'koukaikbnval' => $koukaikbnval,
						'path1file' => $path1file,
						'path2file' => $path2file,
						'path3file' => $path3file,
				] );

				// 画面の移動
				$this->set('yuekiFilePath', $this->Constants->YUEKI_FILE_PATH);
				$this->render ( '/Admin/Beneficial/edit' );
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
	 * 　画面名：有益変更
	 * 　機能名：有益の更新処理
	 */
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_TYueki = $this->TYueki->getDataSource();
			$db_TYueki->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->request->data['adminBeneficialregister'] = $this->request->data;
				$torokuDate = $this->Common->getSystemDateTime ();
				$syasinKeyVal = $this->request->data ['urlsyasinKey'];
				$fileKeyVal = $this->request->data ['urlfileKey'];
				$this->textarea_maxlength("naiyo",$this->request->data['naiyo'],1024,$responseString);
				$this->request->data['jyohodt'] = str_replace('/', '-', $this->request->data['yuekidate']).' '.$this->request->data['yuekitime'];
				$this->TYueki->set ( $this->request->data );
				if ($this->TYueki->validates ()) {
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
						$newfolder = $this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal ;
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
								move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
								$fileRno = "1";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file1Title'], $file1, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
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
								move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
								$fileRno = "2";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file2Title'], $file2, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
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
								move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
								$fileRno = "3";
								$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file3Title'], $file3, $torokuDate );
								$fileKeyVal = $this->TFile->getLastInsertId();
							} else {
								move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
								$this->updateTFile ( $fileKeyVal, $rnoFile3, $file3Title, $folderKeyVal.'/'.$_FILES ['file3'] ['name'] );
							}
						}
					} else if(isset($this->request->data ['file3Title'])) {
							$this->updateTFiletitle( $fileKeyVal, $rnoFile3, $file3Title);
					}
					$this->updateTYueki ( $this->request->data, $syasinKeyVal, $fileKeyVal, $torokuDate );
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
										$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,3);
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
								$subject_mail = '【確認・通知】　有益情報更新';
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
					$this->syashinkeydelete($syasinKeyVal,$this->request->data['adminBeneficialregister']['id']);
					$this->filekeydelete($fileKeyVal,$this->request->data['adminBeneficialregister']['id'],$folderKeyVal);
					$responseString = "1";
					echo $responseString;
				} else {
					$errors = $this->TYueki->validationErrors;
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
			$db_TYueki->commit();
			$db_TSyasin->commit();
			$db_TFile->commit();
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 * 　画面名：有益一覧
	 * 　機能名：有益の削除処理
	 */
	public function delete() {
		try {
			$responseString = "0";
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['yuekiInfo'] == $this->Constants->HYOJI) {
				$arno = $this->request->data['arno'];
				$syasin = $this->request->data['syasinKey'];
				$filekey = $this->request->data['filekey'];
				$this->TYueki->delete ( $arno );
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
					$dir = $this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal[0];
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
	 * 　画面名：有益新規追加
	 * 　機能名：有益の新規追加処理
	 */
	public function add() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		// 公開区分のセット
		$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		// 初期値のセット
		$this->set('kokaiVal', $this->Constants->INVAL);
		// 画面の移動
		$this->render ( '/Admin/Beneficial/add' );
	}
	/**
	 * 　画面名：有益新規追加
	 * 　機能名：有益の新規登録処理
	 */
	public function register() {
		try {
			$db_TYueki = $this->TYueki->getDataSource();
			$db_TYueki->begin();
			$db_TSyasin = $this->TSyasin->getDataSource();
			$db_TSyasin->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$responseString = "";
			if ($_SESSION ['Auth'] ['User'] ['Menu'] ['yuekiAdd'] == $this->Constants->HYOJI) {
				$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
				$this->Session->delete ( 'Auth.User.Beneficial.previewInfo' );
				if (array_key_exists ( 'naiyo', $this->request->data )) {
					$syasinKeyVal = 0;
					$fileKeyVal = 0;
					$this->textarea_maxlength("naiyo",$this->request->data['naiyo'],1024,$responseString);
					$this->request->data['jyohodt'] = str_replace('/', '-', $this->request->data['yuekidate']).' '.$this->request->data['yuekitime'];
					$this->TYueki->set ( $this->request->data );
					if ($this->TYueki->validates ()) {
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
							$newfolder = $this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal ;
							if(!is_dir($newfolder)){
								mkdir($newfolder, 0777, true);
							}
							chmod($newfolder, 0777);
							$fileRno = 0;
							if(isset($_FILES ['file1'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
									$file1 = $folderKeyVal.'/'.$_FILES ['file1'] ['name'];
									move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file1Title'], $file1, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
							if(isset($_FILES ['file2'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file2'] ['tmp_name'] )) {
									$file2 = $folderKeyVal.'/'.$_FILES ['file2'] ['name'];
									move_uploaded_file($_FILES ['file2'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file2'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file2Title'], $file2, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
							if(isset($_FILES ['file3'] ['tmp_name'])) {
								if (is_uploaded_file ( $_FILES ['file3'] ['tmp_name'] )) {
									$file3 = $folderKeyVal.'/'.$_FILES ['file3'] ['name'];
									move_uploaded_file($_FILES ['file3'] ['tmp_name'],$this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file3'] ['name']);
									$fileRno ++;
									$this->insertTFile ( $fileKeyVal, $fileRno, $this->request->data ['file3Title'], $file3, $torokuDate );
									$fileKeyVal = $this->TFile->getLastInsertId();
								}
							}
						}
						$this->insertTYueki ( $this->request->data, $syasinKeyVal, $fileKeyVal, $torokuDate);
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
											$this->Common->uketoriMailSendFunction($from,$uketoriMailInfoArray,3);
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
									$subject_mail = '【確認・通知】　有益情報登録';
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
						$errors = $this->TYueki->validationErrors;
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
							'controller' => 'AdminBeneficial',
							'action' => 'add' 
					] );
				}
			} else {
				$this->redirect ( ['controller' => 'Error','action' => 'ajaxRequestError' ] );
			}
			$db_TYueki->commit();
			$db_TSyasin->commit();
			$db_TFile->commit();
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 *  機能名：分割処理
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
	 * 　画面名：有益編集
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
			$db_TYueki->rollback();
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
	 *　 機能名：ファイルの削除処理
	 */
	public function deleteTFile ($filekey,$rno) {
		try {
			$this->TFile->query(" DELETE FROM t_file WHERE filekey = $filekey AND rno = $rno ");
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 *  テーブル名：ファイル情報
	 *　 機能名：一つファイルの削除処理
	 */
	public function deletesingleTFile ($fileKeyVal,$folderKeyVal,$rno) {
		try {
			$filedata = $this->TFile->find ( 'first', array (
							'fields' => array('TFile.filepath'),
							'conditions' => array ('TFile.filekey ' => $fileKeyVal, 'TFile.rno ' => $rno )
						));
			$dir = $this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal;
			if (is_dir($dir)) {
				$handle=opendir($dir);
				$file = readdir($handle);
				unlink($this->Constants->YUEKI_FULL_FILE_PATH.$filedata['TFile']['filepath']);
			}
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	private function insertTSyasin($syasinkey, $rno, $title, $syasin, $tourokudt ) {
		// 項目の値セット
		try {
				$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->YUEKI,
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
			$db_TYueki->rollback();
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
	 * 　機能名：ファイル情報登録
	 */
	private function insertTFile($filekey, $rno, $title, $file, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					'rno' => $rno,
					'bunrui' => $this->Constants->YUEKIFILE,
					'title' => $title,
					'filepath' => $file,
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if(!empty($filekey)) {
				$columnValue['filekey'] = $filekey;
			}
			// ファイル情報作成
			$this->TFile->create ();
			// ファイル情報に登録
			if (!$this->TFile->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
			$db_TYueki->rollback();
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
			$db_TYueki->rollback();
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
			$db_TYueki->rollback();
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
			$db_TYueki->rollback();
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
	 * 　テーブル名：有益情報
	 * 　機能名：有益情報登録
	 */
	private function insertTYueki($request, $syasin, $file, $tourokudt) {
		// 項目の値セット
		try {
			$columnValue = array (
					'kaiinnm' => $request ['kaiinnm'],
					'jyohodt' => $request ['jyohodt'],
					'title' => $request ['title'],
					'naiyo' => $request ['naiyo'],
					'syasin' => $syasin,
					'file' => $file,
					'sankourl' => $request ['sankourl'],
					'koukaikbn' => $request ['koukaikbn'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// 有益情報作成
			$this->TYueki->create ();
			// 有益情報に登録
			if (!$this->TYueki->save($columnValue)) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 * 　テーブル名：有益情報
	 * 　機能名：有益情報更新
	 */
	private function updateTYueki($request, $syasin, $file, $kousinDate) {
		// 項目の値セット
		try {
			$columnValue = array (
					'arno' => $request ['adminBeneficialregister'] ['id'],
					'kaiinnm' => $request ['kaiinnm'],
					'jyohodt' => $request ['jyohodt'],
					'title' => $request ['title'],
					'naiyo' => $request ['naiyo'],
					'syasin' => $syasin,
					'file' => $file,
					'sankourl' => $request ['sankourl'],
					'koukaikbn' => $request ['koukaikbn'],
					'kousincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'kousindt' => $kousinDate 
			);
			// 有益情報に登録
			if (!$this->TYueki->save($columnValue)) {
                throw new Exception();
            }
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 * 画面名：有益情報_新規追加
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
		$message .= "<p> 有益情報の新規追加を行いました。</p>";
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
	 * 画面名：有益_更新
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
		$message .= "<p> 有益情報の更新を行いました。</p>";
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
	 *　 機能名：写真キー削除処理
	 */
	private function syashinkeydelete($syasinkey,$arno) {
		try {
			$syashincntchk = $this->TSyasin->find ( 'all', array (
							'fields' => array('TSyasin.syasinkey'),
							'conditions' => array ('TSyasin.syasinkey ' => $syasinkey )));
			if(count($syashincntchk) == 0) {
				$columnValue = array ('syasin' => 0);
				$conditions = array ('arno' => $arno);
				$this->TYueki->updateAll ( $columnValue, $conditions );
			}
		} catch (Exception $e) {
			$db_TYueki->rollback();
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
	 *　 機能名：ファイルキー削除処理
	 */
	private function filekeydelete($fileKeyVal,$arno,$folderKeyVal) {
		try {
			$filecntchk = $this->TFile->find ( 'all', array (
							'fields' => array('TFile.filekey'),
							'conditions' => array ('TFile.filekey ' => $fileKeyVal )));
			if(count($filecntchk) == 0) {
				$columnValue = array ('file' => 0);
				$conditions = array ('arno' => $arno);
				$this->TYueki->updateAll ( $columnValue, $conditions );
				$dir = $this->Constants->YUEKI_FULL_FILE_PATH.$folderKeyVal;
				if (is_dir($dir)) {
					$handle=opendir($dir);
					while (($file = readdir($handle))!==false) {
						@unlink($dir.'/'.$file);
					}
					rmdir($dir);
				}
			}
		} catch (Exception $e) {
			$db_TYueki->rollback();
			$db_TSyasin->rollback();
			$db_TFile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
}