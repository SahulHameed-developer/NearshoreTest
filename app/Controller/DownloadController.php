<?php
App::uses('AppController', 'Controller');
/**
 * Download Controller
 *
 * ダウンロードを表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class DownloadController extends AppController
{
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'Session', 'RequestHandler', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MDlcate', 'TSyasin', 'TFile','TDlfile');
	/**
	 *　画面名：ダウンロード
	 *　機能名：ダウンロード表示
	 */
	public function index() {
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) {
			$this->set('downloadFilePath', $this->Constants->DL_FILE_PATH);
			$this->set('fileKey', '');
			if (!empty($this->request->data)) {
				if (isset($this->request->data['catageryType'])) {
				 	$this->request->data ['rno'] = $this->request->data['catageryType'];
				 	$_FILES ['file1']= $_FILES ['file'];
					$this->request->data['title'] = $this->request->data['filetitle'];
				}
				$MDlcate = $this->MDlcate->find('all', array(
							'conditions' => array ('MDlcate.arno' => $this->request->data['rno']),
							'order'=>array ('MDlcate.hyojino' => 'ASC')));
				$this->set('Prev_Dlcatenm', $this->request->data['rno']);
				$this->set('Prev_FileData', $this->request->data);
				if($_FILES ['file1']['name']!="") {
					$previewInfo ['file'] = fread ( fopen ( $_FILES ['file1'] ['tmp_name'], "r" ), $_FILES ['file1'] ['size'] );
					$previewInfo ['fileName'] = $_FILES ['file1'] ['name'];
					$previewInfo ['fileType'] = $_FILES ['file1'] ['type'];
					$previewInfo ['fileSize'] = $_FILES ['file1'] ['size'];
			 	} else {
					$previewInfo ['fileName'] = $this->request->data['pathfile'];
			 	}
			 	if(isset($this->request->data['urlfileKey'])) {
					$this->set ( 'fileKey', $this->request->data['urlfileKey'] );
				}
				$this->set ( 'previewInfo', $previewInfo );
				$this->set('previewadmin','1');
				$this->Session->write ( "Auth.User.Download.previewInfo", $previewInfo );
				$conditions[] = array('OR' => array(
												array('TDlfile.koukaikbn' => $this->Constants->KOKAI),
												array('MDlcate.arno' => $this->request->data['rno'])
									));
			} else {
				$conditions[] = array('TDlfile.koukaikbn' => $this->Constants->KOKAI);
			}
			$conditions[] = array('MDlcate.koukaikbn' => $this->Constants->KOKAI);
			$MDlcate = $this->MDlcate->find('all', array(
											'joins' => array(
												array(
													'table' => $this->TDlfile,
													'alias' => 'TDlfile',
													'type' => 'LEFT',
													'conditions' => array('MDlcate.arno = TDlfile.cateno'))
												),
											'fields' => array(
													'MDlcate.arno',
													'MDlcate.dlcatenm'),
											'group' => array ('MDlcate.dlcatenm'),
											'conditions' => $conditions,
											'order'=>array ('MDlcate.hyojino' => 'ASC')));
			$query = $this->TDlfile->find('all', array(
												'joins' => array(
														array(
															'table' => $this->MDlcate,
															'alias' => 'MDlcate',
															'type' => 'LEFT',
															'conditions' => array(
																'MDlcate.arno = TDlfile.cateno')),
														array(
															'table' => $this->TFile,
															'alias' => 'TFile',
															'type' => 'LEFT',
															'conditions' => array(
																'TDlfile.file = TFile.filekey',
																'TFile.bunrui = 4'))
												),
												'fields' => array(
														'TDlfile.file',
														'TFile.title',
														'TFile.filepath',
														'TDlfile.cateno'
														),
												'conditions' => array ('TDlfile.koukaikbn' => $this->Constants->KOKAI),
												'order'=>array ('TDlfile.hyojino' => 'ASC')));
			$this->set('Dlcatenm', $MDlcate);
			$this->set('FileData', $query);
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}
	}
	/**
	 *　画面名：ダウンロードプレビュー
	 *　機能名：写真情報取得
	 */
	public function viewFile($fileName) {
		$previewInfo = $this->Session->read ( 'Auth.User.Download.previewInfo' );
		$this->autoRender = false;
		header ( 'Content-type: ' . $previewInfo [$fileName . 'Type'] );
		header ( 'Content-length: ' . $previewInfo [$fileName . 'Size'] );
		header ( 'Content-Disposition: attachment; filename=' . $previewInfo ['fileName'] );
		echo $previewInfo [$fileName];
	}
}
?>