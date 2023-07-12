<?php
App::uses('AppController', 'Controller');

/**
 * News Controller
 *
 * お知らせ一を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class NewsController extends AppController
{
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('RequestHandler', 'Constants', 'Common', 'Session');
	// モデル名追加
	var $uses = array('TOsirase', 'TSyasin', 'TFile');
	/**
	 *　画面名：お知らせ一覧
	 *　機能名：お知らせ一覧表示
	 */
	public function index() {
		if(isset($this->request->data['newsIndexfrm']['recCountBack']) && !empty($this->request->data['newsIndexfrm']['recCountBack'])) {
			$this->set('count', $this->request->data['newsIndexfrm']['recCountBack']);
		} else {
			$this->set('count', '8');
		}
		if(isset($this->request->data['newsIndexfrm']['scroll_val'])) {
			$this->set('scroll_val', $this->request->data['newsIndexfrm']['scroll_val']);
		} else {
			$this->set('scroll_val', '');
		}
		$this->set('totalcount', sizeof($this->TOsirase->find('all', array('conditions' =>array('TOsirase.koukaikbn' => $this->Constants->KOKAI)))));
	}
	/**
	 *　画面名：お知らせ詳細
	 *　機能名：お知らせ詳細表示
	 */
	public function detail() {
			// 画面の移動
		if(isset($this->request->data['Detailfrm'])) {
			$this->request->data['newsDetailfrm']['arno'] = $this->request->data['Detailfrm']['arno'];
			$this->set('pageCount', "top");
		} else if(isset($this->request->data['newsDetailfrm'])) {
			$this->set('pageCount', $this->request->data['newsDetailfrm']['recCount']);
		} else {
			$this->set('pageCount', '');
		}
		if(isset($this->request->data['scroll_val'])) {
			$this->set('scroll_val', $this->request->data['scroll_val']);
		} else {
			$this->set('scroll_val', '');
		}
		if (!empty($this->request->data)) {
			if (!empty($this->request->data['newsDetailfrm'])) {
					//お知らせ詳細
				$osiraseinfo = $this->TOsirase->find('first',array(
												'fields' => array(
														'TOsirase.arno',
														'TOsirase.osirasedt',
														'TOsirase.naiyo',
														'TOsirase.title',
														'TOsirase.syasin',
														'TOsirase.file',
														'TOsirase.syasin',
														'kousinTourokudt'),
												'conditions'=>array(
														'TOsirase.arno' => $this->request->data['newsDetailfrm']['arno'])));
				//写真詳細
				$syasininfo = $this->TSyasin->find('all',array(
												'conditions' => array(
														'TSyasin.syasinkey' => $osiraseinfo['TOsirase']['syasin'],
														'TSyasin.bunrui' => $this->Constants->OSHIRASE)));
				//ファイル詳細
				$fileinfo = $this->TFile->find('all',array(
												'conditions' => array(
														'TFile.filekey' => $osiraseinfo['TOsirase']['file'],
														'TFile.bunrui' => $this->Constants->OSHIRASE)));
				$this->set('syasin_info', $syasininfo);
				$this->set('file_info', $fileinfo);
				$this->set('osiraseInfo', $osiraseinfo);
				$this->set('osiraseFilePath', $this->Constants->OSIRASE_FILE_PATH);
				$this->set('image1','');
				$this->set('image2','');
				$this->set('image3','');
				$this->set('path1file', '');
				$this->set('path2file', '');
				$this->set('path3file', '');
			} else {
				$osiraseinfo['TOsirase'] = $this->request->data;
				$osiraseinfo['TOsirase']['osirasedt'] = $osiraseinfo['TOsirase']['osirasedate'];
				$osiraseinfo['TOsirase']['kousinTourokudt'] = $this->Common->getSystemDate();
				$syasin1 = '';
				$syasin2 = '';
				$syasin3 = '';
				if(isset($_FILES ['syasin1'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
						$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size'] );
					} 
				} 
				if(isset($_FILES ['syasin2'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) {
						$syasin2 = fread ( fopen ( $_FILES ['syasin2'] ['tmp_name'], "r" ), $_FILES ['syasin2'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin3'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] )) {
						$syasin3 = fread ( fopen ( $_FILES ['syasin3'] ['tmp_name'], "r" ), $_FILES ['syasin3'] ['size'] );
					} 
				} 
				$previewInfo ['syasin1'] = $syasin1;
				$previewInfo ['syasin2'] = $syasin2;
				$previewInfo ['syasin3'] = $syasin3;
				$file1 = '';
				$file1Name = '';
				$file1Type = '';
				$file1Size = '';
				$file2 = '';
				$file2Name = '';
				$file2Type = '';
				$file2Size = '';
				$file3 = '';
				$file3Name = '';
				$file3Type = '';
				$file3Size = '';
				if(isset($_FILES ['file1'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
						$file1 = fread ( fopen ( $_FILES ['file1'] ['tmp_name'], "r" ), $_FILES ['file1'] ['size'] );
						$file1Name = $_FILES ['file1'] ['name'];
						$file1Type = $_FILES ['file1'] ['type'];
						$file1Size = $_FILES ['file1'] ['size'];
					} 
				}
				if(isset($_FILES ['file2'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['file2'] ['tmp_name'] )) {
						$file2 = fread ( fopen ( $_FILES ['file2'] ['tmp_name'], "r" ), $_FILES ['file2'] ['size'] );
						$file2Name = $_FILES ['file2'] ['name'];
						$file2Type = $_FILES ['file2'] ['type'];
						$file2Size = $_FILES ['file2'] ['size'];
					} 
				}
				if(isset($_FILES ['file3'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['file3'] ['tmp_name'] )) {
						$file3 = fread ( fopen ( $_FILES ['file3'] ['tmp_name'], "r" ), $_FILES ['file3'] ['size'] );
						$file3Name = $_FILES ['file3'] ['name'];
						$file3Type = $_FILES ['file3'] ['type'];
						$file3Size = $_FILES ['file3'] ['size'];
					} 
				}
				$previewInfo ['file1'] = $file1;
				$previewInfo ['file2'] = $file2;
				$previewInfo ['file3'] = $file3;
				$previewInfo ['file1Name'] = $file1Name;
				$previewInfo ['file1Type'] = $file1Type;
				$previewInfo ['file1Size'] = $file1Size;
				$previewInfo ['file2Name'] = $file2Name;
				$previewInfo ['file2Type'] = $file2Type;
				$previewInfo ['file2Size'] = $file2Size;
				$previewInfo ['file3Name'] = $file3Name;
				$previewInfo ['file3Type'] = $file3Type;
				$previewInfo ['file3Size'] = $file3Size;
				$this->set ( 'previewInfo', $previewInfo );
				$this->Session->write ( "Auth.User.News.previewInfo", $previewInfo );
				$this->set('syasin_info', '');
				$this->set('file_info', '');
				$this->set('osiraseInfo', $osiraseinfo);
				$this->set('previewadmin','1');
				$this->set('pageCount', '');
				$this->set('osiraseFilePath', $this->Constants->OSIRASE_FILE_PATH);
				$this->set('image1', $this->request->data['image1']);
				$this->set('image2', $this->request->data['image2']);
				$this->set('image3', $this->request->data['image3']);
				$this->set('path1file', $this->request->data['path1file']);
				$this->set('path2file', $this->request->data['path2file']);
				$this->set('path3file', $this->request->data['path3file']);
			}
		} else {
			$this->redirect([
					'controller' => 'news',
					'action' => 'index'
			]);
		}
	}
	/**
	 *　画面名：お知らせ詳細
	 *　機能名：写真情報の写真を取得
	 */
	public function getSyasin($syasinkey, $rno)	{
		//写真画像
		$syasinImage = $this->TSyasin->find ('first', array(
										'conditions' => array (
												'TSyasin.syasinkey ' => $syasinkey, 
												'TSyasin.rno' => $rno,
												'TSyasin.bunrui' => $this->Constants->OSHIRASE)));
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($syasinImage['TSyasin']['syasin']));
		echo $syasinImage['TSyasin']['syasin'];
	}
	/**
	 *　画面名：お知らせ詳細
	 *　機能名：写真表示
	 */
	public function viewSyasin($syasinName) {
		$previewInfo = $this->Session->read('Auth.User.News.previewInfo');
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($previewInfo[$syasinName]));
		echo $previewInfo[$syasinName];
	}
	/**
	 *　画面名：お知らせ詳細
	 *　機能名：添付ファイル情報取得
	 */
	public function viewFile($fileName) {
		$previewInfo = $this->Session->read ( 'Auth.User.News.previewInfo' );
		$this->autoRender = false;
		header ( 'Content-type: ' . $previewInfo [$fileName . 'Type'] );
		header ( 'Content-length: ' . $previewInfo [$fileName . 'Size'] );
		header ( 'Content-Disposition: attachment; filename=' . $previewInfo [$fileName . 'Name'] );
		echo $previewInfo [$fileName];
	}
	/**
	 *　画面名：お知らせ詳細
	 *　機能名：写真情報取得
	 */
	public function getSyasinImage($id, $syasinkey) {
		$pictImage = $this->TSyasin->find ( 'first', array (
				'conditions' => array (
						'TSyasin.rno ' => $id,
						'TSyasin.syasinkey ' => $syasinkey,
						'TSyasin.bunrui' => $this->Constants->OSHIRASE
				)
		) );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
		echo $pictImage ['TSyasin'] ['syasin'];
	}
	/**
	 *　画面名：お知らせ一覧
	 *　機能名：もっと見る処理
	 */
	public function getMoreRecords() {
		$osiraseinfo = $this->TOsirase->find('all', array(
							'fields' => array(
									'TOsirase.arno',
									'TOsirase.osirasedt',
									'TOsirase.title',
									'kousinTourokudt'),
							'conditions' =>array('TOsirase.osirasedt <=' =>$this->Common->getSystemDateTime(), 
									'TOsirase.koukaikbn' => $this->Constants->KOKAI),
							'order' =>array(
											'TOsirase.osirasedt' => 'DESC'),
							'limit' => $this->request->data['reccount']));
		echo json_encode($osiraseinfo);exit();
	}
}
?>