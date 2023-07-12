<?php
App::uses('AppController', 'Controller');

/**
 * Beneficial Controller
 *
 * 有益一を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class BeneficialController extends AppController
{
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('RequestHandler', 'Constants', 'Common', 'Session');
	// モデル名追加
	var $uses = array('TYueki', 'TSyasin', 'TFile');
	/**
	 *　画面名：有益一覧
	 *　機能名：有益一覧表示
	 */
	public function index() {
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
			if(isset($this->request->data['beneficialIndexfrm']['recCountBack']) && !empty($this->request->data['beneficialIndexfrm']['recCountBack'])) {
				$this->set('count', $this->request->data['beneficialIndexfrm']['recCountBack']);
			} else {
				$this->set('count', '8');
			}
			if(isset($this->request->data['beneficialIndexfrm']['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['beneficialIndexfrm']['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			$this->set('totalcount', sizeof($this->TYueki->find('all', array('conditions' =>array('TYueki.koukaikbn' => $this->Constants->KOKAI),
																				'order' =>array('TYueki.jyohodt' => 'DESC')))));
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}
	}
	/**
	 *　画面名：有益詳細
	 *　機能名：有益詳細表示
	 */
	public function detail() {
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
			if(isset($this->request->data['Detailfrm'])) {
				$this->request->data['beneficialDetailfrm']['arno'] = $this->request->data['Detailfrm']['arno'];
				$this->set('pageCount', "top");
			} else if(isset($this->request->data['beneficialDetailfrm'])) {
				$this->set('pageCount', $this->request->data['beneficialDetailfrm']['recCount']);
			} else {
				$this->set('pageCount', '');
			}
			if(isset($this->request->data['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			if (!empty($this->request->data)) {
				if (!empty($this->request->data['beneficialDetailfrm'])) {
					//有益詳細
					$yuekiinfo = $this->TYueki->find('first',array(
													'fields' => array(
															'TYueki.arno',
															'TYueki.kaiinnm',
															'TYueki.jyohodt',
															'TYueki.naiyo',
															'TYueki.title',
															'TYueki.syasin',
															'TYueki.file',
															'TYueki.sankourl',
															'TYueki.syasin',
															'kousinTourokudt'),
													'conditions'=>array(
															'TYueki.arno' => $this->request->data['beneficialDetailfrm']['arno'])));
					//写真詳細
					$syasininfo = $this->TSyasin->find('all',array(
													'conditions' => array(
															'TSyasin.syasinkey' => $yuekiinfo['TYueki']['syasin'],
															'TSyasin.bunrui' => $this->Constants->YUEKI)));
					//ファイル詳細
					$fileinfo = $this->TFile->find('all',array(
													'conditions' => array(
															'TFile.filekey' => $yuekiinfo['TYueki']['file'],
															'TFile.bunrui' => $this->Constants->YUEKIFILE)));
					$this->set('syasin_info', $syasininfo);
					$this->set('file_info', $fileinfo);
					$this->set('yuekiInfo', $yuekiinfo);
					$this->set('yuekiFilePath', $this->Constants->YUEKI_FILE_PATH);
					$this->set('image1','');
					$this->set('image2','');
					$this->set('image3','');
					$this->set('path1file', '');
					$this->set('path2file', '');
					$this->set('path3file', '');
				} else {
					$yuekiinfo['TYueki'] = $this->request->data;
					$yuekiinfo['TYueki']['jyohodt'] = $yuekiinfo['TYueki']['yuekidate'];
					$yuekiinfo['TYueki']['kousinTourokudt'] = $this->Common->getSystemDate();
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
					$this->Session->write ( "Auth.User.Beneficial.previewInfo", $previewInfo );
					$this->set('syasin_info', '');
					$this->set('file_info', '');
					$this->set('yuekiInfo', $yuekiinfo);
					$this->set('previewadmin','1');
					$this->set('pageCount', '');
					$this->set('yuekiFilePath', $this->Constants->YUEKI_FILE_PATH);
					$this->set('image1', $this->request->data['image1']);
					$this->set('image2', $this->request->data['image2']);
					$this->set('image3', $this->request->data['image3']);
					$this->set('path1file', $this->request->data['path1file']);
					$this->set('path2file', $this->request->data['path2file']);
					$this->set('path3file', $this->request->data['path3file']);
				}
			} else {
				$this->redirect([
						'controller' => 'Beneficial',
						'action' => 'index'
				]);
			}
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}	
	}
	/**
	 *　画面名：有益詳細
	 *　機能名：写真情報の写真を取得
	 */
	public function getSyasin($syasinkey, $rno)	{
		//写真画像
		$syasinImage = $this->TSyasin->find ('first', array(
										'conditions' => array (
												'TSyasin.syasinkey ' => $syasinkey, 
												'TSyasin.rno' => $rno,
												'TSyasin.bunrui' => $this->Constants->YUEKI)));
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($syasinImage['TSyasin']['syasin']));
		echo $syasinImage['TSyasin']['syasin'];
	}
	/**
	 *　画面名：有益詳細
	 *　機能名：写真表示
	 */
	public function viewSyasin($syasinName) {
		$previewInfo = $this->Session->read('Auth.User.Beneficial.previewInfo');
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($previewInfo[$syasinName]));
		echo $previewInfo[$syasinName];
	}
	/**
	 *　画面名：有益詳細
	 *　機能名：添付ファイル情報取得
	 */
	public function viewFile($fileName) {
		$previewInfo = $this->Session->read ( 'Auth.User.Beneficial.previewInfo' );
		$this->autoRender = false;
		header ( 'Content-type: ' . $previewInfo [$fileName . 'Type'] );
		header ( 'Content-length: ' . $previewInfo [$fileName . 'Size'] );
		header ( 'Content-Disposition: attachment; filename=' . $previewInfo [$fileName . 'Name'] );
		echo $previewInfo [$fileName];
	}
	/**
	 *　画面名：有益詳細
	 *　機能名：写真情報取得
	 */
	public function getSyasinImage($id, $syasinkey) {
		$pictImage = $this->TSyasin->find ( 'first', array (
				'conditions' => array (
						'TSyasin.rno ' => $id,
						'TSyasin.syasinkey ' => $syasinkey,
						'TSyasin.bunrui' => $this->Constants->YUEKI
				)
		) );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
		echo $pictImage ['TSyasin'] ['syasin'];
	}
	/**
	 *　画面名：有益一覧
	 *　機能名：もっと見る処理
	 */
	public function getMoreRecords() {
		$yuekiinfo = $this->TYueki->find('all', array(
							'fields' => array(
									'TYueki.arno',
									'TYueki.jyohodt',
									'TYueki.title',
									'TYueki.sankourl',
									'kousinTourokudt'),
							'conditions' =>array('TYueki.jyohodt <=' =>$this->Common->getSystemDateTime(), 
									'TYueki.koukaikbn' => $this->Constants->KOKAI),
							'order' =>array(
											'TYueki.jyohodt' => 'DESC'),
							'limit' => $this->request->data['reccount']));
		echo json_encode($yuekiinfo);exit();
	}
}
?>