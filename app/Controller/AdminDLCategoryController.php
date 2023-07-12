<?php
App::uses ( 'AppController', 'Controller' );
App::uses ( 'CakeEmail', 'Network/Email' );
App::import('Controller', 'Common');
/**
 * ダウンロードカテゴリー編集 Controller
 *
 * ダウンロードカテゴリー編集を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *        
 */
class AdminDLCategoryController extends AppController {

	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MDlcate','MKoukai','TDlfile');

	// レイアウト無し
	public $autoLayout = false;


	// 初期化
	public $CATEGORY_ADD = "1";
	public $CATEGORY_UPD = "2";
	public $CATEGORY_DEL = "3";


	/**
	 *　画面名：ダウンロードカテゴリー_編集
	 *　機能名：ダウンロードカテゴリー_編集
	 */
	public function categoryedit() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$this->set('dlcatenm', $this->Common->getCategoryNameall($this->MDlcate));
			// 公開区分のセット
			$this->set('kokai',$this->Common->getKokaiName ($this->MKoukai));
			// 初期値のセット
			$this->set('kokaiVal', $this->Constants->INVAL);
			$this->set('inval', $this->Constants->INVAL);
			$this->set('CATEGORY_ADD', $this->CATEGORY_ADD);
			$this->set('CATEGORY_UPD', $this->CATEGORY_UPD);
			$this->set('CATEGORY_DEL', $this->CATEGORY_DEL);
			$this->render ( '/Admin/Download/categoryedit');
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 *　画面名：ダウンロードカテゴリー_編集
	 *　機能名：編集処理
	 */
	public function register() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		try {
			$responseString = "0";
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			if($this->request->data['category'] == $this->CATEGORY_ADD) {
				$this->request->data['dlcatenm'] = $this->request->data['categoryname'];
			} else if($this->request->data['category'] != $this->CATEGORY_ADD) {
				$this->request->data['dlcatenm'] = $this->request->data['dlcatename'];
			}
			$this->MDlcate->set ( $this->request->data );
			if ($this->MDlcate->validates ()) {
				$data = array();
				if($this->request->data['category'] == $this->CATEGORY_ADD) {
					$data['dlcatenm'] = $this->request->data['categoryname'];
					$data['koukaikbn'] = $this->request->data['koukaikbn'];
					$data['hyojino'] = $this->request->data['hyojino'];
					$data['tourokucd'] = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
					$data['tourokudt'] = $this->Common->getSystemDateTime();
					$checkhyojinoexists = $this->checkHyojiNoExists($data['hyojino']);
					if($checkhyojinoexists == 1) {
						$max_consecutive = $this->updateHyojiNoIncrement($data['hyojino']);
					}
					$this->MDlcate->create();
					$this->MDlcate->save($data);
					if($checkhyojinoexists == 1) {
						$this->updateHyojiNoUptoLast($data['hyojino'],$max_consecutive);
					}
					$responseString = "1";
				} else if($this->request->data['category'] == $this->CATEGORY_UPD) {
					$hyojino = $this->MDlcate->find('first', array(
								'fields'=>array('hyojino'),
								'conditions'=>array('arno' => $this->request->data['dlcatename'])));
					$checkhyojinoexists = $this->checkHyojiNoExists($this->request->data['hyojino']);
					if($this->request->data['hyojino'] != $hyojino['MDlcate']['hyojino'] && $checkhyojinoexists == 1 ) {
						$max_consecutive = $this->updateHyojiNoIncrement($this->request->data['hyojino']);
					}
					$columnValue = array (
						'dlcatenm' => '"'.$this->request->data['categoryname_edit'].'"',
						'koukaikbn' => $this->request->data['koukaikbn'],
						'hyojino' => $this->request->data['hyojino'],
						'kousincd' => "'".$_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']."'",
						'kousindt' => "'".$this->Common->getSystemDateTime()."'"
					);
					$conditions = array (
						'arno' => $this->request->data['dlcatename']
					);
					$this->MDlcate->updateAll ( $columnValue, $conditions );
					if($this->request->data['hyojino'] != $hyojino['MDlcate']['hyojino'] && $checkhyojinoexists == 1 ) {
						$this->updateHyojiNoUptoLast($this->request->data['hyojino'],$max_consecutive);
					}
					$responseString = "1";
				} else if($this->request->data['category'] == $this->CATEGORY_DEL) {
					$dlcatename = $this->request->data['dlcatename'];
					$hyojino = $this->MDlcate->find('first', array(
								'fields'=>array('hyojino'),
								'conditions'=>array('arno' => $dlcatename)));
					$max_consecutive = $this->updateHyojiNoDecrement($dlcatename);
					$this->MDlcate->query(" DELETE FROM m_dlcate WHERE arno = '$dlcatename' ");
					$this->updateHyojiNoUptoLast($hyojino['MDlcate']['hyojino'],$max_consecutive);
					$responseString = "1";
				}
			} else {
				$errors = $this->MDlcate->validationErrors;
				$errCount = count($errors);
				$idx=0;
				foreach($errors as $feild => $messages) {
					$responseString .= $feild."##".$messages[0];
					$idx++;
					if($idx < $errCount) {
						$responseString .= "$$";
					}
				}
			}
			echo $responseString;
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError'
				]);
		}
		exit();
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
	 *　機能名：表示番号のチェック処理
	 */
	public function checkHyojiNoExists($hyojino) {
		$retrunvalue = 0;
		$checkhyojino = $this->MDlcate->find('first', array(
					'fields'=>array('hyojino'),
					'conditions'=>array('hyojino' => $hyojino)));
		if(isset($checkhyojino['MDlcate']['hyojino'])) {
			$retrunvalue = 1;
		}
		return $retrunvalue;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function updateHyojiNoIncrement($hyojino) {
		$max_consecutive = $this->MDlcate->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
					FROM m_dlcate AS leftTbl
					  LEFT OUTER JOIN m_dlcate AS rightTbl 
							ON leftTbl.hyojino+ 1 = rightTbl.hyojino
					WHERE 
						leftTbl.hyojino >= $hyojino AND 
						rightTbl.hyojino IS NULL
					ORDER BY MAX_CONSECUTIVE
					LIMIT 1 ");
		if(isset($max_consecutive[0][0]['MAX_CONSECUTIVE'])) {
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
			$this->MDlcate->query(" UPDATE m_dlcate SET hyojino = (hyojino+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' ");
		}
		return $max_consecutive;
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function updateHyojiNoUptoLast($hyojino, $max_consecutive) {
		$this->MDlcate->query(" SET @num := ($hyojino-1); UPDATE m_dlcate SET hyojino = @num := (@num+1) WHERE hyojino >= '$hyojino' AND hyojino <= '$max_consecutive' order by hyojino ASC; ");
	}
	/**
	 *　機能名：表示番号の更新処理
	 */
	public function updateHyojiNoDecrement($arno) {
			$oldhyojino = $this->MDlcate->find('first', array(
							'fields'=>array('hyojino'),
							'conditions'=>array('arno' => $arno)));
			$hyojino = $oldhyojino['MDlcate']['hyojino'];
			$max_consecutive = $this->MDlcate->query(" SELECT leftTbl.hyojino + 1 AS MAX_CONSECUTIVE
						FROM m_dlcate AS leftTbl
						  LEFT OUTER JOIN m_dlcate AS rightTbl 
								ON leftTbl.hyojino+ 1 = rightTbl.hyojino
						WHERE 
							leftTbl.hyojino >= $hyojino AND 
							rightTbl.hyojino IS NULL
						ORDER BY MAX_CONSECUTIVE
						LIMIT 1 ");
			$max_consecutive = $max_consecutive[0][0]['MAX_CONSECUTIVE'];
			$this->MDlcate->query(" UPDATE m_dlcate SET hyojino = (hyojino-1) WHERE hyojino > '$hyojino' AND hyojino < '$max_consecutive' ");
		return $max_consecutive;
	}
	/**
	 *　機能名：登録データを取得
	 */
	public function getRegData() {
		$data = $this->MDlcate->find('first', array(
							'fields'=>array('hyojino','koukaikbn'),
							'conditions'=>array('arno' => $this->request->data['arno'])));
		echo json_encode($data);exit();
	}
	public function getdlcatenm() {
		$returnArray = $this->Common->getCategoryNameallajax($this->MDlcate);
		$returnArray = json_encode($returnArray);
		echo $returnArray;exit;
	}
	public function deleteCategorycheck(){
		$data = $this->TDlfile->find('first', array(
							'fields'=>array('*'),
							'conditions'=>array('cateno' => $this->request->data['arno'])));
		echo json_encode(count($data));exit();
	}
}
?>