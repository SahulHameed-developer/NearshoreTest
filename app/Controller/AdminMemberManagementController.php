<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Common');
/**
 * 会員情報一覧 Controller
 *
 * 会員情報一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminMemberManagementController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MKaiinsb','MSosiki','TKaiin','MIyaku', 'MKyaku','MKoukai','MTuuci');
	// レイアウト無し
	public $autoLayout = false;
	// 表示順序
	public $dispOrder = array(1 => "会員コード", 2 => "会員名", 3 => "役職");
	/**
	 *　画面名：ログイン情報送信一覧
	 *　機能名：ログイン情報送信一覧
	 */
	public function memberlist() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		if (! $this->Session->read ( 'errorMsg.errorflag' )) {
			$this->Session->delete ( 'errorMsg' );
		}
		$this->Session->write ( "errorMsg.errorflag", false );
		// ドロップダウン値のセット
		$this->setInitialDropdownValue();
		// 初期化のセット
		$this->setInitialValue();
		// 画面の移動
		$this->set('mailarrmm','');
		$this->set('searchinfo','');
		$this->set('count','0');
		$this->render('/Admin/MemberManagement/list');
	}
	/**
	 *　画面名：ログイン情報送信検索
	 *　機能名：ログイン情報送信検索処理
	 */
	public function search() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		// リクエストデータが空白の場合
		try {
			if(!$this->Session->read('errorMsg.errorflag')){
				$this->Session->delete('errorMsg');
			}
			$this->Session->write("errorMsg.errorflag",false);
			if(empty($this->request->data)){
				// 初期表示
				$this->redirect ( ['controller' => 'Error','action' => 'systemError' ] );
				// リクエストデータが空白以外の場合
			} else {
				if(isset($this->request->data['membersModoruFrm'])) {
					$this->request->data = $this->request->data['membersModoruFrm'];
					$this->set('mailarrmm',$this->request->data['mailarrmm']);
				} else {
					$this->set('mailarrmm','');
				}
				$conditions = array();
				$order = array();
				// 業種名称選択の場合
				$kaiinsbnm = $this->request->data['kaiinsbnm'];
				$sosiki = $this->request->data['sosiki'];
				$openstate = $this->request->data['openstate'];
				$enrollment = $this->request->data['enrollment'];
				$registration = $this->request->data['registration'];
				$period = $this->request->data['period'];
				$fromdate = $this->request->data['fromdate'];
				$todate = $this->request->data['todate'];
				if(!empty($kaiinsbnm)){
					$conditions[] = array('TKaiin.kaiinsbcd' =>$kaiinsbnm);
				}
				if(!empty($sosiki)){
					$conditions[] = array('TKaiin.sosikicd' =>$sosiki);
				}
				if($openstate == '0' || $openstate == '1'){
					$conditions[] = array('TKaiin.koukaikbn' =>$openstate);
				}
				if(!empty($enrollment)){
					if($enrollment == '1') {
						$conditions[] = array('OR' => array(
						            array('TKaiin.kyukaidate' => NULL),
						            array('TKaiin.kyukaidate' => "0000-00-00"),
						        ));
						$conditions[] = array('OR' => array(
						            array('TKaiin.taikaidate' => NULL),
						            array('TKaiin.taikaidate' => "0000-00-00"),
						        ));
					}
					if($enrollment == '2') {
						$conditions[] = array(array('TKaiin.kyukaidate <>' => NULL),
								array('TKaiin.kyukaidate <>' => "0000-00-00"));
						 $conditions[] = array('OR' => array(
						            array('TKaiin.taikaidate' => NULL),
						            array('TKaiin.taikaidate' => "0000-00-00"),
						        ));
					}
					if($enrollment == '3') {
						$conditions[] = array(array('TKaiin.taikaidate <>' => NULL),
								array('TKaiin.taikaidate <>' => "0000-00-00"));
					}
				}
				if(!empty($registration)){
					if($registration == '1') {
						$conditions[] = array(
								array('TKaiin.tsousindt <>' => NULL),
								array('TKaiin.tsousindt <>' => "0000-00-00"));
					}
					if($registration == '2') {
						 $conditions[] = array('OR' => array(
						            array('TKaiin.tsousindt' => NULL),
						            array('TKaiin.tsousindt' => "0000-00-00"),
						        ));
					}
				}
				if(!empty($period) && (!empty($fromdate) || !empty($todate)) ) {
					if(!empty($fromdate) && !empty($todate) ) {
						$conditions[] = array('TKaiin.'.$period.' >=' =>$fromdate,
											  'TKaiin.'.$period.' <=' =>$todate);
					} else if(!empty($fromdate) && empty($todate) ) {
						$conditions[] = array('TKaiin.'.$period.' >=' =>$fromdate);
					} else if(empty($fromdate) && !empty($todate) ) {
						$conditions[] = array('TKaiin.'.$period.' <=' =>$todate);
					}
					if ($period == "tsousindt") {
						$conditions[] = array(
										array('TKaiin.'.$period.' <>' => NULL),
										array('TKaiin.'.$period.' <>' => "0000-00-00 00:00:00"));
					} else {
						$conditions[] = array(
										array('TKaiin.'.$period.' <>' => NULL),
										array('TKaiin.'.$period.' <>' => "0000-00-00"));
					}
				}
				if (!isset($this->request->data['selectedOrder'])) {
					$selectedOrder = "1";
				} else {
					$selectedOrder = $this->request->data['selectedOrder'];
				}
				// 表示順序 
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
				$conditions[] = array('TKaiin.kanrikbn <=' => $this->Session->read('Auth.User.TKaiin.kanrikbn'));
				$query = $this->TKaiin->find('all', array(
						'joins' => array(
							array(
									'table' => $this->MKaiinsb,
									'alias' => 'tkn',
									'type' => 'LEFT',
									'conditions' => array(
											'tkn.kaiinsbcd = TKaiin.kaiinsbcd',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= tkn.fromdt',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  tkn.todt')),
							array(
									'table' => $this->MSosiki,
									'alias' => 'mso',
									'type' => 'LEFT',
									'conditions' => array(
											'mso.sosikicd = TKaiin.sosikicd',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= mso.fromdt',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  mso.todt')),
							array(
									'table' => $this->MIyaku,
									'alias' => 'miy',
									'type' => 'LEFT',
									'conditions' => array(
											'miy.iinkaiykcd = TKaiin.iinkaiykcd',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= miy.fromdt',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  miy.todt')),
							array(
									'table' => $this->MKyaku,
									'alias' => 'mky',
									'type' => 'LEFT',
									'conditions' => array(
											'mky.kyoukaiykcd = TKaiin.kyoukaiykcd',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= mky.fromdt',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  mky.todt')),
							array(
									'table' => $this->MKoukai,
									'alias' => 'mko',
									'type' => 'LEFT',
									'conditions' => array(
											'mko.koukaicd = TKaiin.koukaikbn',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) >= mko.fromdt',
											'IF(TKaiin.kousindt = "0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt)) <=  mko.todt'))),
						'fields' => array('TKaiin.kaiinnm',
								'TKaiin.kaisyacd',
								'TKaiin.kaiincd',
								'TKaiin.kaiinnmkana',
								'IF(TKaiin.kaiinnmkana = "",1,0) as kaiinnmkana_sort',
								'TKaiin.kyoukaiykcd',
								'IF(TKaiin.kyoukaiykcd = "",1,0) as kyoukaiykcd_sort',
								'TKaiin.mailaddr',
								'TKaiin.kaiinsbcd',
								'TKaiin.lgid',
								'TKaiin.lgpass',
								'TKaiin.nyukaidate',
								'TKaiin.kyukaidate',
								'TKaiin.taikaidate',
								'TKaiin.tsousindt',
								'tkn.kaiinsbnm',
								'mso.sosikinm',
								'miy.iinkaiyknm',
								'mky.kyoukaiyknm',
								'mko.koukainm'),
						'conditions' => $conditions,
						'order'=> $order ));
				// ドロップダウン値のセット
				$this->set('searchinfo',$query);
				$this->set('count',count($query));
				$this->set('searched','1');
				$this->setInitialDropdownValue();
				// 初期化のセット
				$this->setInitialValue($kaiinsbnm,$sosiki,$openstate,$enrollment,$registration,$period,$fromdate,$todate,$selectedOrder);
				$this->render('/Admin/MemberManagement/list');
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
	 * sendmail 登録情報の通知メール送信
	 */
	public function sendmail() {
		// ドロップダウン値のセット
		try {
			$this->setInitialDropdownValue();
			// 初期化のセット
			$this->setInitialValue();
			$systemDateTime=$this->Common->getSystemDateTime();
			$mailInfo=$this->Common->getMailInfo($this->MTuuci);
			$id = split(',',$this->request->data["mailidarr"]);
			$this->TKaiin->updateAll(array('tsousindt' =>"NOW()"), array('kaiincd' => $id));
			for ($i=0; $i<count($id); $i++) {
				$query = $this->TKaiin->find('all', array(
						'fields' => array('TKaiin.lgid','TKaiin.lgpass','TKaiin.kaiinnm','TKaiin.mailaddr'),
						'conditions' => array('TKaiin.kaiincd' => $id[$i])));
				if(!empty($mailInfo) && !empty($query[0]["TKaiin"]["mailaddr"])){
					// メール送信１　（事務局宛）
					$data['kaiinnm'] = $query[0]["TKaiin"]["kaiinnm"];
					$data['lgid'] = $query[0]["TKaiin"]["lgid"];
					$data['lgpass'] = $query[0]["TKaiin"]["lgpass"];
					$subject_mail = '【登録通知】　会員情報登録のお知らせ';
					$msg_mail = $this->mailText($data, $systemDateTime);
					$mail = new CakeEmail('smtp');
					$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
					$mail->to($query[0]["TKaiin"]["mailaddr"]);
					$mail->subject($subject_mail);
					$mail->emailFormat('html');
					$mail->send($msg_mail);
				}
			}
			$this->redirect ( [
					'controller' => 'AdminMemberManagement',
					'action' => 'memberlist'
			] );
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * setInitialDropdownValue ドロップダウン値のセット
	 */
	private function setInitialDropdownValue() {
		// 組織名称のセット
		$this->set('sosiki',$this->Common->getKaigiShubetsuName($this->MSosiki));
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName ($this->MKaiinsb));
		$this->set('dispOrder',$this->dispOrder);
	}
	/**
	 * setInitialValue 初期表示値
	 *
	 * @param industry, member_type, radiovalue, keyWord 業種名、会員種別名、フリーワードのラジオボタン値、フリーワード値
	 */
	private function setInitialValue( $kaiinsbnm = NULL, $sosiki = NULL, $openstate = NULL,$enrollment = NULL ,$registration = NULL,$period = NULL, $fromdate = NULL, $todate = NULL, $selectedOrder = NULL, $openstateChk = NULL) {
		if(!empty($kaiinsbnm)) {
			//会員種別名称のセット
			$this->set('selectedKaiinsbnm',$kaiinsbnm);
		} else {
			//会員種別名称の初期表示をセット
			$this->set('selectedKaiinsbnm','');
		}
		if(!empty($sosiki)) {
			//会員種別名称のセット
			$this->set('selectedSosiki',$sosiki);
		} else {
			//会員種別名称の初期表示をセット
			$this->set('selectedSosiki','');
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
		if($enrollment == '1') {
			$this->set('enrollment1Chk','');
			$this->set('enrollment2Chk','checked');
			$this->set('enrollment3Chk','');
			$this->set('enrollment4Chk','');
		} else if($enrollment == '2') {
			$this->set('enrollment1Chk','');
			$this->set('enrollment2Chk','');
			$this->set('enrollment3Chk','checked');
			$this->set('enrollment4Chk','');
		} else if($enrollment == '3') {
			$this->set('enrollment1Chk','');
			$this->set('enrollment2Chk','');
			$this->set('enrollment3Chk','');
			$this->set('enrollment4Chk','checked');
		} else {
			$this->set('enrollment1Chk','checked');
			$this->set('enrollment2Chk','');
			$this->set('enrollment3Chk','');
			$this->set('enrollment4Chk','');
		}
		if($registration == '1') {
			$this->set('registration1Chk','');
			$this->set('registration2Chk','checked');
			$this->set('registration3Chk','');
		} else if($registration == '2') {
			$this->set('registration1Chk','');
			$this->set('registration2Chk','');
			$this->set('registration3Chk','checked');
		} else {
			$this->set('registration1Chk','checked');
			$this->set('registration2Chk','');
			$this->set('registration3Chk','');
		}
		if(empty($period) || $period == "nyukaidate") {
			$this->set('nyukaiChk','checked');
			$this->set('kyukaiChk','');
			$this->set('taikaiChk','');
			$this->set('tsousinChk','');
		} else if($period == "kyukaidate") {
			$this->set('nyukaiChk','');
			$this->set('kyukaiChk','checked');
			$this->set('taikaiChk','');
			$this->set('tsousinChk','');
		} else if($period == "taikaidate") {
			$this->set('nyukaiChk','');
			$this->set('kyukaiChk','');
			$this->set('taikaiChk','checked');
			$this->set('tsousinChk','');
		} else if($period == "tsousindt") {
			$this->set('nyukaiChk','');
			$this->set('kyukaiChk','');
			$this->set('taikaiChk','');
			$this->set('tsousinChk','checked');
		}
		if(!empty($fromdate)) {
			$this->set('fromdate',$fromdate);
		} else {
			$this->set('fromdate','');
		}
		if(!empty($todate)) {
			$this->set('todate',$todate);
		} else {
			$this->set('todate','');
		}
		if(empty($openstateChk)) {
			$this->set('enrollmentChk','checked');
			$this->set('registrationChk','checked');
		}
		// ソート順
		if(!empty($selectedOrder)) {
			$this->set('selectedOrder',$selectedOrder);
		} else {
			$this->set('selectedOrder','');
		}
	}
	/**
	 * 画面名：ログイン情報送信
	 * 機能名：通知メール送信
	 */
	private function mailText($data,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 100px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> ".$data['kaiinnm']."　様</p>\n";
		$message .= "\n";
		$message .= "<p> 会員情報が登録されました。</p>";
		$message .= "<p> 会員情報は以下のＵＲＬより変更可能です。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>Ｕ　　Ｒ　　Ｌ</td><td $braceWidth>】</td>
						<td $maxwidth>".Router::url('/', true)."admin"."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>ユ　ー　ザ　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$data['lgid']."</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>パ ス ワ ー ド</td><td $braceWidth>】</td>
						<td $maxwidth>".$data['lgpass']."</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>宜しくお願い致します。</p>";
		return $message;
	}
}