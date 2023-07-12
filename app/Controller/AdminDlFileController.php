<?php
App::uses ( 'AppController', 'Controller' );
App::import('Controller', 'Common');
/**
 * ダウンロード一覧 Controller
 *
 * ダウンロード一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminDlFileController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common','Session');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MDlcate','TFile','TDlfile','MKoukai');
	// レイアウト無し
	public $autoLayout = false;
	/**
	 *　画面名：ダウンロード
	 *　機能名：ダウンロード一覧
	 */
	public function index() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		// ダウンロードタイプ名のセット
		$this->set('dlcatenm', $this->Common->getCategoryNameall($this->MDlcate));
		// 初期化のセット
		$this->setInitialValue();
		//ダウンロードを探すの初期表示
		$this->set('selecteddlcatenm', '');
		$this->set('freewordval', '');
		$this->set('catagery', '');
		$this->set('openstate', '');
		$this->render ( '/Admin/Download/list' );
	}
	/**
	 * 　画面名：ダウンロード一覧の検索
	 * 　機能名：ダウンロード一覧の検索処理
	 */
	public function search() {
		if (!empty ( $this->request->data ) || isset($_SESSION['Auth']['User']['downloadDel'])) {
			if (isset($_SESSION['Auth']['User']['downloadDel'])) {
				$this->request->data['adminDownload']['dlcatenm'] = $this->Session->read ( 'Auth.User.downloadDel.catageryType');
				$this->request->data ['catagery'] = $this->Session->read ( 'Auth.User.downloadDel.catagery');
				$this->request->data ['openstate'] = $this->Session->read ( 'Auth.User.downloadDel.openstate');
				$this->request->data ['free-word'] = $this->Session->read ( 'Auth.User.downloadDel.free_word');
				$this->Session->delete ( 'Auth.User.downloadDel' );
			}
			$free_word = $this->request->data ['free-word'];
			if (isset($this->request->data ['openstate'])) {
				$openstate = $this->request->data ['openstate'];
			} else {
				$openstate = $this->request->data['menu']['openstate'];
			}
			if (isset($this->request->data ['catagery'])) {
				$catagery = $this->request->data ['catagery'];
			} else {
				$catagery = $this->request->data['menu']['catagery'];
			}
			if (isset($this->request->data['adminDownload']['dlcatenm'])) {
				$catageryType = $this->request->data['adminDownload']['dlcatenm'];
			} else {
				$catageryType = $this->request->data ['selecteddlcatenm'];
			}
			$conditions = array();
			if (! empty ( $catageryType )) {
				$conditions [] = array ('TDlfile.cateno' => $catageryType );
			}
			if($catagery == '1' && ($openstate == '0' || $openstate == '1')) {
				$conditions[] = array('mdlcate.koukaikbn' =>$openstate);
			} else if($catagery == '2' && ($openstate == '0' || $openstate == '1')) {
				$conditions[] = array('TDlfile.koukaikbn' =>$openstate);
			} else {
				if($openstate == '0' || $openstate == '1') {
					$conditions[] = array('TDlfile.koukaikbn' =>$openstate,
										'mdlcate.koukaikbn' =>$openstate);
				}
			}
			if (!empty ( $free_word )) {
				$conditions [] = array ('OR' => array (
										array ('tfile.title LIKE ' => "%$free_word%" ),
										array ('mdlcate.dlcatenm LIKE ' => "%$free_word%"))
									);
			}
			$this->set('dlcatenm', $this->Common->getCategoryNameall($this->MDlcate));
			$this->set('selecteddlcatenm', $catageryType);
			$this->set('freewordval', $this->request->data ['free-word']);
			$this->set('catagery', $catagery);
			$this->set('openstate', $openstate);
			$query = $this->TDlfile->find ( 'all', array (
									'joins' => array (
											array (
												'table' => $this->TFile,
												'alias' => 'tfile',
												'type' => 'LEFT',
												'conditions' => array ('tfile.filekey = TDlfile.file')),
											array(
												'table' => $this->MDlcate,
												'alias' => 'mdlcate',
												'type' => 'LEFT',
												'conditions' => array('mdlcate.arno = TDlfile.cateno')),
											array(
												'table' => $this->MKoukai,
												'alias' => 'mkoukai',
												'type' => 'LEFT',
												'conditions' => array('mkoukai.koukaicd = TDlfile.koukaikbn'))
									),
									'fields' => array (
												'tfile.title',
												'mdlcate.dlcatenm',
												'mdlcate.koukaikbn',
												'mdlcate.hyojino',
												'TDlfile.arno',
												'TDlfile.file',
												'TDlfile.koukaikbn', // 公開区分
												'TDlfile.hyojino',
												'mkoukai.koukainm'
									),
									'conditions' => $conditions,
									'order'=> array('mdlcate.hyojino' => 'ASC',
													'TDlfile.hyojino' => 'ASC')
							));
			$cnt = count ( $query );
			if ($cnt == 0) {
				$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
			}
			$this->set ( [
					'download' => $query
			] );
			// 初期化のセット
			$this->setInitialValue($catageryType,$catagery,$openstate,$free_word);
			$this->render ( '/Admin/Download/list' );
		} else {
			$this->redirect ( ['controller' => 'AdminDlFile','action' => 'index' ] );
		}
	}
	/**
	 * 　画面名：ダウンロード 新規追加
	 * 　機能名：ダウンロードの 新規追加処理
	 */
	public function add() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
		//ダウンロードカテゴリ名を設定する
			$shinkicatagery = $this->Common->getCategoryNameall($this->MDlcate);
			//$catagery = array('99' => '新しいカテゴリ');
			//$shinkicatagery = $catageryType;
			$this->set('shinkicatagery', $shinkicatagery);
		//公開区分のセット
			$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
		//初期値のセット
			$this->set('kokaiVal', $this->Constants->INVAL);
			$this->render ( '/Admin/Download/add' );
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　画面名：ダウンロード 新規追加
	 * 　機能名：ダウンロードの 新規追加処理
	 */
	public function register() {
		try {
			$db_MDlcate = $this->MDlcate->getDataSource();
			$db_MDlcate->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$db_TDlfile = $this->TDlfile->getDataSource();
			$db_TDlfile->begin();
			$responseString = "";
			$requestData = $this->splitothersFields($this->request->data['otherFields']);
			$checkhyojinoexists = $this->checkhyojinoexistsTDlFile($requestData['hyojino'],$requestData['rno']);
			if($checkhyojinoexists == 1) {
				$max_consecutive = $this->checkhyojinoTDlFile($requestData['hyojino'],$requestData['rno']);
			}
			$this->TFile->set ( $requestData );
			if ($this->TFile->validates ()) {
				$torokuDate  = $this->Common->getSystemDateTime();
				$filetitle =  $requestData['title'];
				$fileKeyVal = '';
				$folderKeyVal = number_format(round(microtime(true) * 1000), 0, '', '');
				$newfolder = $this->Constants->DL_FULL_FILE_PATH.$folderKeyVal ;
				if(!is_dir($newfolder)){
					mkdir($newfolder, 0777, true);
				}
				chmod($newfolder, 0777);
				if(isset($_FILES ['file1'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
						$file1 = $folderKeyVal.'/'.$_FILES ['file1'] ['name'];
						move_uploaded_file($_FILES ['file1'] ['tmp_name'],$this->Constants->DL_FULL_FILE_PATH.$folderKeyVal.'/'.$_FILES ['file1'] ['name']);
						$this->insertTFile ( $fileKeyVal, $filetitle, $file1, $torokuDate );
						$fileKeyVal = $this->TFile->getLastInsertId();
						$this->insertTDlfile ($fileKeyVal,$requestData, $torokuDate);
						$fileKeyVal = $this->TFile->getLastInsertId();
					}
				}
				if($checkhyojinoexists == 1) {
					$this->checkhyojinoLastUp($requestData['hyojino'],$max_consecutive,$requestData['rno']);
				}
				$responseString = "1";
				echo $responseString;
			} else {
				$errors = $this->TFile->validationErrors;
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
			$db_MDlcate->commit();
			$db_TFile->commit();
			$db_TDlfile->commit();
		} catch (Exception $e) {
			$db_MDlcate->rollback();
			$db_TFile->rollback();
			$db_TDlfile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　画面名：ダウンロード 削除
	 * 　機能名：ダウンロード の削除処理
	 */
	public function delete() {
		try {
			$responseString = "";
			$arno = $this->request->data['arno'];
			$TDlfiledata = $this->TDlfile->find ( 'first', array (
								'fields' => array('file','hyojino','cateno'),
								'conditions' => array ('arno ' => $arno)
							));
			$cateno = $TDlfiledata['TDlfile']['cateno'];
			$filekey = $TDlfiledata['TDlfile']['file'];
			$hyojino = $TDlfiledata['TDlfile']['hyojino'];
			$filedata = $this->TFile->find ( 'first', array (
								'fields' => array('TFile.filepath'),
								'conditions' => array ('TFile.filekey ' => $filekey)
							));
			$max_consecutive = $this->updatehyojino($arno);
			if(!empty($arno) && $arno != null && $arno != 0 ) {
					$this->TDlfile->query("DELETE FROM t_dlfile WHERE arno = $arno ");
			}
			if(!empty($filekey) && $filekey != null && $filekey != 0 ) {
					$this->TFile->query("DELETE FROM t_file WHERE filekey = $filekey ");
			}
			$this->checkhyojinoLastUp($hyojino, $max_consecutive,$cateno);
			
			if(isset($filedata['TFile']['filepath'])) {
				$folderKeyVal  = split("/", $filedata['TFile']['filepath']);
				$dir = $this->Constants->DL_FULL_FILE_PATH.$folderKeyVal[0];
				if (is_dir($dir)) {
					$handle=opendir($dir);
					while (($file = readdir($handle))!==false) {
						@unlink($dir.'/'.$file);
					}
					rmdir($dir);
				}
			}
			$responseString = "1";
			echo $responseString; exit();
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　画面名：ダウンロード 編集
	 * 　機能名：ダウンロードの 編集処理
	 */
	public function edit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			if (! empty ( $this->request->data )) {
				$this->set('downloadFilePath', $this->Constants->DL_FILE_PATH);
				$arno = $this->request->data ['adminDownloadedit'] ['arno'];
				$filekey = $this->request->data ['adminDownloadedit'] ['filekey'];
				$openstate = $this->request->data ['adminDownloadedit'] ['openstate'];
				$catagery = $this->request->data ['adminDownloadedit'] ['catagery'];
				$catageryType = $this->request->data ['adminDownloadedit'] ['selecteddlcatenm'];
				$free_word = $this->request->data ['adminDownloadedit'] ['free_word'];
				$conditions [] = array (
			 		'TDlfile.arno' => $arno,
			 		'tfile.filekey' => $filekey
			 	);
				$result = $this->TDlfile->find ( 'first', array (
									'joins' => array (
											array (
												'table' => $this->TFile,
												'alias' => 'tfile',
												'type' => 'LEFT',
												'conditions' => array ('tfile.filekey = TDlfile.file')),
											array(
												'table' => $this->MDlcate,
												'alias' => 'mdlcate',
												'type' => 'LEFT',
												'conditions' => array('mdlcate.arno = TDlfile.cateno'))
									),
									'fields' => array (
												'tfile.rno',
												'tfile.title',
												'tfile.filepath',
												'TDlfile.arno',
												'TDlfile.cateno',
												'TDlfile.hyojino',
												'TDlfile.koukaikbn' // 公開区分
									),
									'conditions' => $conditions
							));
				$this->set ( [
						'selecteddlcatenm' => $this->request->data ['adminDownloadedit'] ['selecteddlcatenm'],
						'freewordval' => $this->request->data ['adminDownloadedit'] ['free_word'],
						'kokai' => $this->Common->getKokaiName ($this->MKoukai),
						'kokaiVal' => $result ['TDlfile'] ['koukaikbn'],
						'shinkicatagery' => $this->Common->getCategoryNameall ($this->MDlcate),
						'tdlarno' => $result ['TDlfile'] ['arno'],
						'selectedcatagery' => $result ['TDlfile'] ['cateno'],
						'file' => $result ['tfile'] ['rno'],
						'filekeyval' => $filekey,
						'filetitle' => $result ['tfile'] ['title'],
						'filepath' => $result ['tfile'] ['filepath'],
						'hyojino' => $result ['TDlfile'] ['hyojino'],
				] );
				$this->set('catagery', $catagery);
				$this->set('openstate', $openstate);
				$this->set('catageryType', $catageryType);
				$this->set('free_word', $free_word);
				$this->render ( '/Admin/Download/edit' );
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
	 * 　画面名：ダウンロード 更新
	 * 　機能名：ダウンロードの 更新処理
	 */
	public function update() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$db_MDlcate = $this->MDlcate->getDataSource();
			$db_MDlcate->begin();
			$db_TFile = $this->TFile->getDataSource();
			$db_TFile->begin();
			$db_TDlfile = $this->TDlfile->getDataSource();
			$db_TDlfile->begin();
			$responseString = "";
			if ($this->request->is ( 'post' )) {
				$requestData = $this->splitothersFields($this->request->data['otherFields']);
				$torokuDate = $this->Common->getSystemDateTime ();
				$fileTitle = $requestData ['filetitle'];
				$file = $requestData ['pathfile'];
				$rnoFile = $requestData ['urlfile'];
				$fileKeyVal = $requestData ['urlfileKey'];
				$cateno = $requestData ['catageryType'];
				$hyojino = $requestData ['hyojino'];
				$koukaikbn = $requestData ['koukaikbn'];
				$arno = $requestData ['tdlarno'];
				$checkhyojinoexists = $this->checkhyojinoexistsTDlFile($requestData ['hyojino'],$cateno);
				$filedata = $this->TFile->find ( 'first', array (
									'fields' => array('TFile.filepath'),
									'conditions' => array ('TFile.filekey ' => $requestData ['urlfileKey'])
								));
				$max_consecutive = "";
				if($hyojino != $requestData ['oldhoujino'] && $checkhyojinoexists == 1 )
				{
					$max_consecutive = $this->checkhyojinoTDlFile($hyojino,$cateno);
				}	
				if ($this->TFile->validates ()) {
					if (isset ($_FILES ['file']['tmp_name'])) {
						//　ファイルの削除
						$folderKeyVals  = split("/", $filedata['TFile']['filepath']);
						$dir = $this->Constants->DL_FULL_FILE_PATH.$folderKeyVals[0];
						if (is_dir($dir)) {
							$handle=opendir($dir);
							while (($fileDel = readdir($handle))!==false) {
								@unlink($dir.'/'.$fileDel);
							}
							// rmdir($dirDel);
						}
						// フォルダーが存在じゃない場合、作成
						if (! file_exists ($dir)) {
							mkdir ($dir, 0777, true);
						}
						
						move_uploaded_file($_FILES ['file'] ['tmp_name'],$dir.'/'.$_FILES ['file'] ['name']);
					
						$file = $folderKeyVals[0].'/'.$_FILES ['file'] ['name'];
						$this->updateTFile ( $fileKeyVal, $rnoFile, $fileTitle, $file );
					} else {
						$this->updateTFile ( $fileKeyVal, $rnoFile, $fileTitle, $file );
					}
					$this->updateTDlfile ($cateno, $koukaikbn, $hyojino, $arno);
					if($hyojino != $requestData ['oldhoujino'] && $checkhyojinoexists == 1 ) {
						$this->checkhyojinoLastUp($hyojino,$max_consecutive,$cateno);
					}
					$responseString = "1";
					echo $responseString;
				}  else {
					$errors = $this->TFile->validationErrors;
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
			$db_MDlcate->commit();
			$db_TFile->commit();
			$db_TDlfile->commit();
		} catch (Exception $e) {
			$db_MDlcate->rollback();
			$db_TFile->rollback();
			$db_TDlfile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
		exit();
	}
	/**
	 * 　テーブル名：ファイル情報
	 * 　機能名：ファイル情報を登録する
	 */
	private function insertTFile($filekey, $title, $file, $tourokudt) {
		// 項目値の設定
		try {
			$columnValue = array (
					'rno' => 1,
					'bunrui' => $this->Constants->DOWNLOAD,
					'title' => $title,
					'filepath' => $file,
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			if(!empty($filekey)) {
				$columnValue['filekey'] = $filekey;
			}
			// ファイル情報の仕事
			$this->TFile->create ();
			// ファイルの情報に登録する
			if (!$this->TFile->save($columnValue)) {
				throw new Exception();
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
	 * 　テーブル名：DLファイル情報
	 * 　機能名：DLファイル情報を登録する
	 */
	private function insertTDlfile($filekey,$requestData, $tourokudt) {
		try {
			$columnValue = array (
					'cateno' => $requestData['rno'],
					'file' => $filekey,
					'koukaikbn' => $requestData['koukaikbn'],
					'hyojino' => $requestData['hyojino'],
					'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
					'tourokudt' => $tourokudt 
			);
			// ダウンロード情報に登録
			if (!$this->TDlfile->save($columnValue)) {
				throw new Exception();
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
	 * setInitialValue 初期表示値
	 *
	 * @param catagery,radiovalue, keyWord カテゴリ－、無線値、キーワード
	 */
	private function setInitialValue( $dlcatenm = NULL, $catagery = NULL, $openstate = NULL, $freewordval = NULL, $openstateChk = NULL) {
		if(!empty($dlcatenm)) {
			//カテゴリタイプ名のセット
			$this->set('selecteddlcatenm',$dlcatenm);
		} else {
			//カテゴリタイプ名の初期表示を設定するト
			$this->set('selecteddlcatenm','');
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
		if($catagery == '1') {
			$this->set('catageryChk1','');
			$this->set('catageryChk2','checked');
			$this->set('catageryChk3','');
			$this->set('catageryChk4','');
		} else if($catagery == '2') {
			$this->set('catageryChk1','');
			$this->set('catageryChk2','');
			$this->set('catageryChk3','checked');
			$this->set('catageryChk4','');
		} else {
			$this->set('catageryChk1','checked');
			$this->set('catageryChk2','');
			$this->set('catageryChk3','');
			$this->set('catageryChk4','');
		}
		if(empty($openstateChk)) {
			$this->set('openstateChk','checked');
			$this->set('catageryChk','checked');
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
	 *　機能名：表示番号の更新処理
	 */
	public function updatehyojino($codeval) {
		$oldhyojino = $this->TDlfile->find('first', array(
						'fields'=>array('hyojino','cateno'),
						'conditions'=>array('arno' => $codeval)));
		$hyojino = $oldhyojino['TDlfile']['hyojino'];
		$cateno = $oldhyojino['TDlfile']['cateno'];
		$max_consecutive = $this->TDlfile->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM t_dlfile AS leftTbl
						LEFT OUTER JOIN t_dlfile AS rightTbl ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE leftTbl.hyojino >= $hyojino AND rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
		$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
		$this->MDlcate->query(" UPDATE t_dlfile SET hyojino = (hyojino-1) WHERE hyojino > '$hyojino' AND hyojino < '$max_consecutive' AND cateno = '$cateno' ");
		return $max_consecutive;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoLastUp($hyojino,$max_consecutive,$cateno) {
		$this->TDlfile->query(" SET @num := ($hyojino-1); UPDATE t_dlfile SET hyojino = @num := (@num+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive'AND cateno = '$cateno' order by hyojino ASC; ");
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoexistsTDlFile($hyojino,$cateno) {
		$retrunvalue = 0;
		$checkhyojino = $this->TDlfile->find('first', array(
					'fields'=>array('hyojino','cateno'),
					'conditions'=>array('hyojino' => $hyojino,
										'cateno' => $cateno)));
		if(isset($checkhyojino['TDlfile']['hyojino'])) {
			$retrunvalue = 1;
		}
		return $retrunvalue;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function checkhyojinoTDlFile($hyojino,$cateno) {
		$max_consecutive = $this->TDlfile->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM t_dlfile AS leftTbl
					  	LEFT OUTER JOIN t_dlfile AS rightTbl ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE leftTbl.hyojino >= $hyojino AND rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
		if(isset($max_consecutive[0][0]['MAX_CONSECUTIVE'])) {
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
			$this->TDlfile->query(" UPDATE t_dlfile SET hyojino = (hyojino+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive'AND cateno = '$cateno' ");
		}
		return $max_consecutive;
	}
	/**
	 * 　テーブル名：ファイル情報
	 * 　機能名：ファイル情報を更新する
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
			// ファイル情報に登録
			if (!$this->TFile->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_MDlcate->rollback();
			$db_TFile->rollback();
			$db_TDlfile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 　テーブル名：DLファイル情報
	 * 　機能名：DLファイル情報を更新する
	 */
	private function updateTDlfile($cateno, $koukaikbn, $hyojino, $arno) {
		// 項目の値セット
		try {
			$db = $this->TDlfile->getDataSource ();
			$columnValue = array (
					'cateno' => $db->value ( $cateno ),
					'koukaikbn' => $db->value ( $koukaikbn ),
					'hyojino' => $db->value ( $hyojino ),
					'kousincd' => $db->value ( $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'] ),
					'kousindt' => $db->value ( $this->Common->getSystemDateTime () )
			);
			$conditions = array (
					'TDlfile.arno ' => $arno
			);
			// DLファイル情報に登録
			if (!$this->TDlfile->updateAll ( $columnValue, $conditions )) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$db_MDlcate->rollback();
			$db_TFile->rollback();
			$db_TDlfile->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
}
?>