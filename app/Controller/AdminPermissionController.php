<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Common');
/**
 * 権限設定 Controller
 *
 * 権限設定を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminPermissionController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MKaiinsb','MSosiki','TKaiin','MIyaku', 'MKyaku','MKoukai','TKengen');
	// レイアウト無し
	public $autoLayout = false;
	// 表示順序
	public $dispOrder = array(1 => "会員コード", 2 => "会員名", 3 => "役職");
	/**
	 *　画面名：権限設定
	 *　機能名：権限設定
	 */
	public function permissionlist() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		// 組織名称のセット
		$this->set('sosiki',$this->Common->getKaigiShubetsuName($this->MSosiki));
		$this->set('selectedSosiki', '');
		$this->set('searchinfo','');
		$this->set('count','0');
		$this->set('dispOrder',$this->dispOrder);
		$this->render('/Admin/Permission/list');
	}
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
			// リクエストデータが空白の場合
			if(empty($this->request->data)){
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				$sosiki = $this->request->data['sosiki'];
				$conditions = array();
				$order = array();
				if(!empty($sosiki)){
					$conditions[] = array('TKaiin.sosikicd' =>$sosiki,
											'TKaiin.kanrikbn < ' => $this->Constants->SYS_KANRISHA);
				} else {
					$conditions[] = array('TKaiin.kanrikbn < ' => $this->Constants->SYS_KANRISHA);
				}
				if (!isset($this->request->data['selectedOrder'])) {
					$selectedOrder = "1";
				} else {
					$selectedOrder = $this->request->data['selectedOrder'];
				}
				if($selectedOrder == "3") {
					$order[] = array('kyoukaiykcd_sort' => 'ASC',
								'TKaiin.kyoukaiykcd' => 'ASC',
								'TKaiin.kaiinnmkana' => 'ASC',
								'TKaiin.kaiinnm' => 'ASC');
				} else if ($selectedOrder == "2") {
					$order[] = array('kaiinnmkana_sort' => 'ASC',
								'TKaiin.kaiinnmkana' => 'ASC',
								'TKaiin.kaiinnm' => 'ASC');
				} else {
					$order[] = array('ABS(TKaiin.kaiincd)' => 'ASC');
				}
				$query = $this->TKaiin->find('all', array(
						'joins' => array(
								array('table' => $this->MKaiinsb,
										'alias' => 'tkn',
										'type' => 'LEFT',
										'conditions' => array('tkn.kaiinsbcd = TKaiin.kaiinsbcd',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= tkn.fromdt',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  tkn.todt')),
								array('table' => $this->MSosiki,
										'alias' => 'mso',
										'type' => 'LEFT',
										'conditions' => array('mso.sosikicd = TKaiin.sosikicd',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= mso.fromdt',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  mso.todt')),
								array('table' => $this->MIyaku,
										'alias' => 'miy',
										'type' => 'LEFT',
										'conditions' => array('miy.iinkaiykcd = TKaiin.iinkaiykcd',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= miy.fromdt',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  miy.todt')),
								array('table' => $this->MKyaku,
										'alias' => 'mky',
										'type' => 'LEFT',
										'conditions' => array('mky.kyoukaiykcd = TKaiin.kyoukaiykcd',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= mky.fromdt',
															'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  mky.todt')),
								array('table' => $this->TKengen,
										'alias' => 'tgen',
										'type' => 'LEFT',
										'conditions' => array('tgen.kaiincd = TKaiin.kaiincd'))),
						'fields' => array(
								'TKaiin.kaiincd',
								'TKaiin.kaiinnm',
								'TKaiin.kaiinnmkana',
								'IF(TKaiin.kaiinnmkana = "",1,0) as kaiinnmkana_sort',
								'TKaiin.kyoukaiykcd',
								'IF(TKaiin.kyoukaiykcd = "",1,0) as kyoukaiykcd_sort',
								'tkn.kaiinsbnm',
								'mso.sosikinm',
								'miy.iinkaiyknm',
								'mky.kyoukaiyknm',
								'tgen.kcaltouroku',
								'tgen.kcalkoukai',
								'tgen.khoutouroku',
								'tgen.khoukoukai',
								'tgen.osirasetouroku',
								'tgen.osirasekoukai',
								'tgen.yuekitouroku',
								'tgen.yuekikoukai',
								'tgen.syukketusansyo'),
						'conditions' => $conditions,
						'order' => $order ));
							$this->set('selectedSosiki', $sosiki);
							$this->set('searchinfo',$query);
							$this->set('count', count($query));
							$this->set('searchval','1');
							$this->set('sosiki',$this->Common->getKaigiShubetsuName($this->MSosiki));
							$this->set('dispOrder',$this->dispOrder);
							if(!empty($selectedOrder)) {
								$this->set('selectedOrder',$selectedOrder);
							} else {
								$this->set('selectedOrder','');
							}
							$this->render('/Admin/Permission/list');
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
	 *　画面名：権限設定
	 *　機能名：登録。更新処理
	 */
	public function regupdate() {
		try {
			if(empty($this->request->data)){
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				$this->updateTkengen("kcaltouroku",$this->request->data["kcaltouroku_val"],'1');
				$this->updateTkengen("kcaltouroku",$this->request->data["kcaltouroku_ncval"],'0');
				$this->updateTkengen("kcalkoukai",$this->request->data["kcalkoukai_val"],'1');
				$this->updateTkengen("kcalkoukai",$this->request->data["kcalkoukai_ncval"],'0');
				$this->updateTkengen("khoutouroku",$this->request->data["khoutouroku_val"],'1');
				$this->updateTkengen("khoutouroku",$this->request->data["khoutouroku_ncval"],'0');
				$this->updateTkengen("khoukoukai",$this->request->data["khoukoukai_val"],'1');
				$this->updateTkengen("khoukoukai",$this->request->data["khoukoukai_ncval"],'0');
				$this->updateTkengen("osirasetouroku",$this->request->data["osirasetouroku_val"],'1');
				$this->updateTkengen("osirasetouroku",$this->request->data["osirasetouroku_ncval"],'0');
				$this->updateTkengen("osirasekoukai",$this->request->data["osirasekoukai_val"],'1');
				$this->updateTkengen("osirasekoukai",$this->request->data["osirasekoukai_ncval"],'0');
				$this->updateTkengen("yuekitouroku",$this->request->data["yuekitouroku_val"],'1');
				$this->updateTkengen("yuekitouroku",$this->request->data["yuekitouroku_ncval"],'0');
				$this->updateTkengen("yuekikoukai",$this->request->data["yuekikoukai_val"],'1');
				$this->updateTkengen("yuekikoukai",$this->request->data["yuekikoukai_ncval"],'0');
				$this->updateTkengen("syukketusansyo",$this->request->data["syukketusansyo_val"],'1');
				$this->updateTkengen("syukketusansyo",$this->request->data["syukketusansyo_ncval"],'0');
				$this->redirect ( [
						'controller' => 'adminPermission',
						'action' => 'permissionlist'
				] );
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
	 * 　テーブル名：権限情報
	 * 　機能名：権限情報追加処理
	 */
	private function insertTKengen($value) {
		$date = $this->Common->getSystemDateTime();
		$filedata = $this->TKengen->find ( 'first', array (
				'fields' => array('TKengen.kaiincd'),
				'conditions' => array ('TKengen.kaiincd ' => $value)
		));
		if(!isset($filedata['TKengen']['kaiincd']) && $value != "" ) {
			$this->TKengen->save(array (
					'kaiincd' => $value,
					'kcaltouroku' => '0',
					'kcalkoukai' => '0',
					'khoutouroku' => '0',
					'khoukoukai' => '0',
					'osirasetouroku' => '0',
					'osirasekoukai' => '0',
					'yuekitouroku' => '0',
					'yuekikoukai' => '0',
					'syukketusansyo' => '0',
					'tourokucd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'],
					'tourokudt' => $date
			));
		}
	}
	/**
	 * 　テーブル名：権限情報
	 * 　機能名：権限情報更新処理
	 */
	private function updateTkengen($field,$arrvalue,$status) {
		$kaiinid_array = split(',',$arrvalue);
		for ($i=0; $i<count($kaiinid_array); $i++) {
			$this->insertTKengen($kaiinid_array[$i]);
			$filedata = $this->TKengen->find ( 'first', array (
				'fields' => array($field),
				'conditions' => array ('kaiincd ' => $kaiinid_array[$i])
			));
			if(isset($filedata['TKengen'][$field])) {
				if($filedata['TKengen'][$field] != $status ) {
					$conditions = array('kaiincd' => $kaiinid_array[$i]);
					$fields = array($field => $status,
							'kousincd' => "'".$_SESSION['Auth']['User']['TKaiin']['kaiincd']."'",
							'kousindt' => "'".$this->Common->getSystemDateTime()."'"
							);
					$this->TKengen->updateAll($fields, $conditions);
				}
			}
		}
	}
}