<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Committee Controller
 *
 * 委員会の紹介を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class CommitteeController extends AppController
{
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'Session', 'RequestHandler', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MIinkai','TIinkai', 'TSyasin', 'TKaiin','TIknyuukai','MTuuci','TKaisya','MKaiinsb');
	/**
	 *　画面名：委員会の紹介
	 *　機能名：委員会の紹介表示
	 */
	public function index() {
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
			$syasinData = $this->getsyasinData ();
			
			$this->set ( [ 
					'syasinData' => $syasinData
			] );
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}
	}
	/**
	 *	写真レコードを取得する。
	 **/
	public function getsyasinData() {
		$query = $this->TIinkai->find ( 'all', array (
									'joins' => array (
											array(
												'table' => $this->TSyasin,
												'alias' => 'TSyasin',
												'type' => 'LEFT',
												'conditions' => array('TIinkai.isyasinkey = TSyasin.syasinkey')),
											array(
												'table' => $this->MIinkai,
												'alias' => 'MIinkai',
												'type' => 'LEFT',
												'conditions' => array('TIinkai.iinkaicd = MIinkai.iinkaicd'))
									),
									'fields' => array (
											'TIinkai.iinkaicd',
											'TIinkai.gaiyou',
											'TIinkai.syokumu',
											'TIinkai.njyoken',
											'TIinkai.nhouhou',
											'TIinkai.bikou',
											'TIinkai.isyasinkey',
											'TIinkai.ssyasinkey', 
											'TSyasin.syasinkey',
											'TSyasin.rno',
											'TSyasin.bunrui',
											'TSyasin.title',
											'TSyasin.syasin'
									), 
									'conditions' => array ('TIinkai.iinkaicd !=' => '',
															'TIinkai.koukaikbn' => $this->Constants->KOKAI ),
									'order'=> array('MIinkai.hyojino' => 'ASC')
							));
		return $query;
	}
	/**
	 *　画面名：委員会紹介情報詳細
	 *　機能名：委員会紹介情報詳細表示
	 */
	public function detail() {
		if($this->referer() == '/') {
			$this->redirect ( [
					'controller' => 'committee',
					'action' => 'index' ] );
		}
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
			if(isset($this->request->data['previewflg'])) {
				$TIinkai[0]['TIinkai']['iinkaicd'] = $this->request->data['iinkaicdinsert'];
				$TIinkai[0]['TIinkai']['gaiyou'] = $this->request->data['gaiyou'];
				$TIinkai[0]['TIinkai']['syokumu'] = $this->request->data['syokumu'];
				$TIinkai[0]['TIinkai']['njyoken'] = $this->request->data['njyoken'];
				$TIinkai[0]['TIinkai']['nhouhou'] = $this->request->data['nhouhou'];
				$TIinkai[0]['TIinkai']['bikou'] = $this->request->data['bikou'];
				$this->request->data['iinkaicd'] = $this->request->data['iinkaicdinsert'];
				$TIinkai[0]['MIinkai']['iinkainm'] = $this->request->data['iinkainm'];
				$syasinData=array();
				$committeeinfo['TIinkai'] = $this->request->data;
				$syasin1 = '';
				$syasin2 = '';
				$syasin3 = '';
				$syasin4 = '';
				$syasin5 = '';
				$syasin6 = '';
				$syasin7 = '';
				$syasin8 = '';
				$syasin9 = '';
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
				if(isset($_FILES ['syasin4'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin4'] ['tmp_name'] )) {
						$syasin4 = fread ( fopen ( $_FILES ['syasin4'] ['tmp_name'], "r" ), $_FILES ['syasin4'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin5'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin5'] ['tmp_name'] )) {
						$syasin5 = fread ( fopen ( $_FILES ['syasin5'] ['tmp_name'], "r" ), $_FILES ['syasin5'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin6'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin6'] ['tmp_name'] )) {
						$syasin6 = fread ( fopen ( $_FILES ['syasin6'] ['tmp_name'], "r" ), $_FILES ['syasin6'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin7'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin7'] ['tmp_name'] )) {
						$syasin7 = fread ( fopen ( $_FILES ['syasin7'] ['tmp_name'], "r" ), $_FILES ['syasin7'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin8'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin8'] ['tmp_name'] )) {
						$syasin8 = fread ( fopen ( $_FILES ['syasin8'] ['tmp_name'], "r" ), $_FILES ['syasin8'] ['size'] );
					} 
				}
				if(isset($_FILES ['syasin9'] ['tmp_name'])) {
					if (is_uploaded_file ( $_FILES ['syasin9'] ['tmp_name'] )) {
						$syasin9 = fread ( fopen ( $_FILES ['syasin9'] ['tmp_name'], "r" ), $_FILES ['syasin9'] ['size'] );
					} 
				}
				$previewInfo ['syasin1'] = $syasin1;
				$previewInfo ['syasin2'] = $syasin2;
				$previewInfo ['syasin3'] = $syasin3;
				$previewInfo ['syasin4'] = $syasin4;
				$previewInfo ['syasin5'] = $syasin5;
				$previewInfo ['syasin6'] = $syasin6;
				$previewInfo ['syasin7'] = $syasin7;
				$previewInfo ['syasin8'] = $syasin8;
				$previewInfo ['syasin9'] = $syasin9;
				$this->set ( 'previewInfo', $previewInfo );
				$this->set ( 'committeeinfo', $committeeinfo );
				$this->Session->write ( "Auth.User.Committee.previewInfo", $previewInfo );
				$this->set('image1', $this->request->data['image1']);
				$this->set('image2', $this->request->data['image2']);
				$this->set('image3', $this->request->data['image3']);
				$this->set('image4', $this->request->data['image4']);
				$this->set('image5', $this->request->data['image5']);
				$this->set('image6', $this->request->data['image6']);
				$this->set('image7', $this->request->data['image7']);
				$this->set('image8', $this->request->data['image8']);
				$this->set('image9', $this->request->data['image9']);
				$this->set('previewadmin','1');
			} else {
				$TIinkai = $this->getTIinkai ($this->request->data);
				$syasinData = $this->getsubsyasinData ($this->request->data);
				$this->set('image1','');
				$this->set('image2','');
				$this->set('image3','');
				$this->set('image4','');
				$this->set('image5','');
				$this->set('image6','');
				$this->set('image7','');
				$this->set('image8','');
				$this->set('image9','');
			}
			$this->Session->write ( "titlename", $TIinkai[0]['MIinkai']['iinkainm'] );
			$chairman = $this->TKaiin->find ( 'first', array (
											'joins' => array (
													array (
														'table' => $this->TKaisya,
														'alias' => 'TKaisya',
														'type' => 'LEFT',
														'conditions' => array ('TKaisya.kaisyacd = TKaiin.kaisyacd'))
											),
											'fields' => array (
													'TKaisya.kaisyanm',
													'TKaiin.kaiinnm'
											), 
											'conditions' => array(
													'TKaiin.sosikicd' => $this->request->data['iinkaicd'],
													'TKaiin.iinkaiykcd' => $this->Constants->T_KAIIN_IINKAIYKCD )
										));
			$commissioner = $this->TKaiin->find ( 'all', array (
											'joins' => array (
													array (
														'table' => $this->TKaisya,
														'alias' => 'TKaisya',
														'type' => 'LEFT',
														'conditions' => array ('TKaisya.kaisyacd = TKaiin.kaisyacd'))
											),
											'fields' => array (
													'TKaisya.kaisyanm',
													'TKaiin.kaiinnm'
											), 
											'conditions' => array(
													'TKaiin.sosikicd' => $this->request->data['iinkaicd'],
													'TKaiin.iinkaiykcd !=' => $this->Constants->T_KAIIN_IINKAIYKCD )
										));
			$this->set('chairman', $chairman);
			$this->set('commissioner', $commissioner);
			$this->set ( [ 
					'TIinkai' => $TIinkai,
					'syasinData' => $syasinData,
					'disflg' => 'false'
			] );
		} else {
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index'
			] );
		}
	}
	/**
	 *	委員会レコードを取得する。
	 **/
	public function getTIinkai($request) {
		$filedata = $this->TIinkai->find ( 'all', array (
									'joins' => array (
											array (
													'table' => $this->MIinkai,
													'alias' => 'MIinkai',
													'type' => 'LEFT',
													'conditions' => array('MIinkai.iinkaicd = TIinkai.iinkaicd'))
									),
									'fields' => array(
													'TIinkai.iinkaicd',
													'TIinkai.gaiyou',
													'TIinkai.syokumu',
													'TIinkai.njyoken',
													'TIinkai.nhouhou',
													'TIinkai.bikou',
													'MIinkai.iinkainm'),
									'conditions' => array ('TIinkai.iinkaicd' => $request['iinkaicd'])
							));
		return $filedata;
	}
	/**
	 *	写真レコードを取得する。
	 **/
	public function getsubsyasinData($request) {
		$filedata = $this->TSyasin->find ( 'all', array (
										'fields' => array('syasinkey',
														'rno',
														'bunrui',
														'title',
														'syasin'),
										'conditions' => array ('syasinkey ' => $request['ssyasinkey'])
									));
		return $filedata;
	}
	/**
	 * 　画面名：委員会の紹介 詳細
	 * 　機能名：写真情報の写真を取得
	 */
	public function getSyasin($id, $syasinkey) {
		try {
			$pictImage = $this->TSyasin->find ( 'first', array (
										'conditions' => array (
														'TSyasin.rno ' => $id,
														'TSyasin.syasinkey ' => $syasinkey) 
									));
			$this->autoRender = false;
			header ( 'Content-type: image/jpeg' );
			header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
			echo $pictImage ['TSyasin'] ['syasin'];
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index' ] );
		}
	}
	/**
	 *　画面名：委員会の紹介 詳細
	 *　機能名：写真表示
	 */
	public function viewSyasin($syasinName) {
		$previewInfo = $this->Session->read('Auth.User.Committee.previewInfo');
		$this->autoRender = false;
		header('Content-type: image/jpeg' );
		header('Content-length: ' . strlen($previewInfo[$syasinName]));
		echo $previewInfo[$syasinName];
	}
	/**
	 *	活動カレンダー画面に移動する。
	 **/
	public function katsudocalander() {
		$this->redirect ( [
					'controller' => 'Activity',
					'action' => 'index'
			] );
	}
	/**
	 *	活動報告画面に移動する。
	 **/
	public function activityreport(){
		$this->redirect ( [
					'controller' => 'Activity',
					'action' => 'reportIndex'
			] );
	}
	/**
	 *	事務局へメール送信処理する。
	 **/
	public function mailsend() {
		$responseString = "";
		$torokuDate = $this->Common->getSystemDateTime ();
		$iinkainm = $this->request->data['iinkainm'];
		$iinkaicd = $this->request->data['iinkaicd'];
		$checkTIknyuukai = $this->insertTIknyuukai ($torokuDate, $iinkaicd);
		if ($checkTIknyuukai == 0) {	
			// 事務局へメール送信
			$mailInfo = $this->Common->getMailInfo ( $this->MTuuci );
			if (! empty ( $mailInfo )) {
				if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
					// メール送信１　（事務局宛）
					$subject_mail = '【委員会申込】' . $iinkainm . '';
					$res = $this->TKaiin->find ( 'all', array (
											'joins' => array (
													array (
															'table' => $this->TKaisya,
															'alias' => 'TKaisya',
															'type' => 'LEFT',
															'conditions' => array ('TKaisya.kaisyacd = TKaiin.kaisyacd')),
													array (
															'table' => $this->MKaiinsb,
															'alias' => 'MKaiinsb',
															'type' => 'LEFT',
															'conditions' => array ('MKaiinsb.kaiinsbcd = TKaiin.kaiinsbcd'))
											),
											'fields' => array('TKaisya.kaisyanm',
															'TKaiin.kaiinsbcd',
															'MKaiinsb.kaiinsbnm',
															'TKaiin.mailaddr'),
											'conditions' => array ('TKaiin.kaiincd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'])
									));
					$msg_mail = $this->CommitteemailText ( $this->request->data, $torokuDate, $iinkainm,$res[0]['TKaisya']['kaisyanm'],$res[0]['MKaiinsb']['kaiinsbnm'],$res[0]['TKaiin']['mailaddr']);
					$mail = new CakeEmail('smtp');
					$mail->from ( $mailInfo ['0'] ['MTuuci'] ['mailaddrsend'] );
					$mail->to ( $mailInfo ['0'] ['MTuuci'] ['mailaddr1'] );
					$mail->subject ( $subject_mail );
					$mail->emailFormat ( 'html' );
					$mail->send ( $msg_mail );
					$conformMail = true;
				}
				if ($conformMail == true) {
					$subject_mail = '【委員会入会申込受付】　' . $iinkainm . '';
					$res = $this->TKaiin->find ( 'all', array (
											'joins' => array (
													array (
															'table' => $this->TKaisya,
															'alias' => 'TKaisya',
															'type' => 'LEFT',
															'conditions' => array ('TKaisya.kaisyacd = TKaiin.kaisyacd'))
											),
											'fields' => array('TKaisya.kaisyanm',
															'TKaiin.mailaddr'),
											'conditions' => array ('TKaiin.kaiincd' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'])
										));
					$msg_mail = $this->ConfirmCommitteemail ( $this->request->data, $iinkainm, $res[0]['TKaisya']['kaisyanm']);
					$mail = new CakeEmail('smtp');
					$mail->from ( $mailInfo ['0']['MTuuci']['mailaddrsend'] );   
					$mail->to ( $res[0]['TKaiin']['mailaddr'] );
					$mail->subject ( $subject_mail );
					$mail->emailFormat ( 'html' );
					$mail->send ( $msg_mail );
				}
			}
			$responseString = $checkTIknyuukai;
			echo $responseString;
		} else {
			$responseString .= "$$";
			echo $responseString;
		}
		exit();
	}
	/**
	 * 　テーブル名：委員会
	 * 　機能名：委員会紹介情報登録
	 */
	private function insertTIknyuukai($torokuDate, $iinkaicd) {
		 try {
			$columnValue = array (
				'mousikomidt' => $torokuDate,
				'msbcd' => 1,
				'ikcd' => $iinkaicd,
				'kaiincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
				'kousincd' => '',
				'kousindt' => '',
				'tourokucd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'],
				'tourokudt' => $torokuDate
			);
			$this->TIknyuukai->create ();
			if (!$this->TIknyuukai->save($columnValue)) {
				throw new Exception();
			}
			$responceVal = 0;
			return $responceVal;
		} catch (Exception $e) { 
			$responceVal = 1;
			return $responceVal;
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Top',
					'action' => 'index' ] );
		}
	}
	/**
	 * 画面名：委員会紹介情報_新規追加
	 * 機能名：通知メール送信
	 * 
	 * @param
	 *        	引継ぎ情報 columnValue
	 * @param
	 *        	システム日時 systemDateTime
	 * @return string
	 */
	private function CommitteemailText($request, $systemDateTime, $iinkainm, $kaisyanm, $kaiinsbnm, $mailaddr){
		$titleWidth = "style='vertical-align: top; text-align: center; width: 120px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$fontsize = "style='font-size:11pt;'";
		$message = "";
		$message .= "<p $fontsize;>関係者各位</p>\n";
		$message .= "\n";
		$message .= "<p $fontsize;> " .$iinkainm. "への入会申込がありました。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%;font-size:11pt;'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申　込　日　時</td><td $braceWidth>】</td>
						<td $maxwidth>" . $this->Common->getJapDateTime ( $systemDateTime ) . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申込会員種別名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $kaiinsbnm . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　　社　　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $kaisyanm . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>氏　　　　　名</td><td $braceWidth>】</td>
						<td $maxwidth>" . $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiinnm'] . "</td>
					</tr>\n";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>メールアドレス</td><td $braceWidth>】</td>
						<td $maxwidth>" . $mailaddr . "</td>
					</tr>\n";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p $fontsize;>ご対応お願い致します。</p>";
		return $message;
	}
	/**
	 * 画面名：委員会紹介情報_新規追加
	 * 機能名：通知メール送信
	 * 
	 * @param
	 *        	引継ぎ情報 columnValue
	 * @param
	 *        	システム日時 systemDateTime
	 * @return string
	 */
	private function ConfirmCommitteemail($request, $iinkainm, $kaisyanm) {
		$hrstyle = "style='display: block;margin-bottom: 0.5em;margin-left: auto;margin-right: auto;border-style: dashed;border-width: 0.1px;'";
		$tableStyle = "style='width:100%;font-size:11pt !important;'";
		$fontsize11 = "style='font-size:11pt !important;'";
		$fontsize9 = "style='font-size:9pt !important;'";
		$message = "";
		$message .= "<table $tableStyle>";
		$message .= "<tr><td>" . $kaisyanm . "</td></tr>";
		$message .= "<tr><td>" . $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiinnm'] ." 様</td></tr>";
		$message .= "<tr><td><br/></td></tr>";
		$message .= "<tr><td>" .$iinkainm. "への入会申込を承りました。</td></tr>";
		$message .= "<tr><td>後日、事務局よりメールにてご連絡させて頂きます。</td></tr>";
		$message .= "<tr><td><br/></td></tr>";
		$message .= "<hr $hrstyle>";
		$message .= "<tr><td $fontsize9>※このメールは送信専用のアドレスから配信しております。</td></tr>";
		$message .= "<tr><td $fontsize9>　ご返信頂きましてもお答えできませんので、予めご了承願います。</td></tr>";
		$message .= "</table>";
		return $message;
	}
}
?>