<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('vendor', 'captcha/Captcha');
App::import('vendor', 'captcha/captchaImageSource');
/**
 * Top Controller
 *
 * ニアショアＩＴ協会お問い合わせのPRサイトを表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class ContactController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MGyosyu','TToiawase', 'MTuuci');
	
	public function index() {
		$this->request->data['captchaImageData'] = captchaImage();
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName($this->MGyosyu));
		// 検証エラーのクリアする
		if(!$this->Session->read('ValidateToiawasei.errorflag')){
			$this->Session->delete('ValidateToiawasei');
		}
		$this->Session->write("ValidateToiawasei.errorflag",false);
		if (!empty($this->request->data['toiawaseiConfirm'])) {
			$this->set('backdata',$this->request->data['toiawaseiConfirm']);
		} else if($this->Session->check('previousPageInfo')) {
			$this->set('backdata', $this->Session->read('previousPageInfo'));
			$this->Session->delete('previousPageInfo');
		} else {
			$this->set('backdata',array('kaisyanm'=>'', 
										'yakunm'=>'', 
										'tantou'=>'', 
										'mailaddr'=>'', 
										'cmailaddr'=>'', 
										'gyosyunm'=>'', 
										'gyosyucd'=>'',
										'naiyou'=>''));
		}
	}

	public function confirm() {
		if (!empty($this->request->data)) {
			// 業種の初期化
			if(!isset($this->request->data['gyosyucd'])) {
				$this->request->data['gyosyucd'] = "";
			}
			$responseString = "";
			$responseString = $this->textarea_maxlength("naiyou",$this->request->data['naiyou'],1024,$responseString);
			$this->TToiawase->set($this->request->data);
			if($this->TToiawase->validates() && $responseString == "") {
				if (!isset($this->request->data['gyosyunm'])) {
					$this->request->data['gyosyunm'] = '';
				}
				$this->set('gyosyunm', $this->MGyosyu->find('first',array(
										'fields' => array('MGyosyu.gyosyunm'),
										'conditions' => array(
													'MGyosyu.gyosyucd' => $this->request->data['gyosyucd'],
													'MGyosyu.fromdt <=' =>$this->Common->getSystemDate(),
													'MGyosyu.todt >=' =>$this->Common->getSystemDate()))));
				$this->set('confirmInfo',$this->request->data);
			} else {
				$errors = $this->TToiawase->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("ValidateToiawasei",$errors);
				$this->Session->write("ValidateToiawasei.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data);
				$this->redirect([
					'controller' => 'contact',
					'action' => 'index'
				]);
			}
		} else {
			$this->redirect([
				'controller' => 'contact',
				'action' => 'index'
			]);
		}
	}

	public function finish() {}

	/**
	 *　画面名：お問い合わせ
	 *　機能名：お問い合わせのメール送信処理
	 */
	public function sendmail() {
		$systemDateTime=$this->Common->getSystemDateTime();
		if (!empty($this->request->data)) {
			$responseString = "";
			$responseString = $this->textarea_maxlength("naiyou",$this->request->data['toiawaseiConfirm']['naiyou'],1024,$responseString);
			$this->TToiawase->set($this->request->data['toiawaseiConfirm']);
			if($this->TToiawase->validates() && $responseString == "")
			{
				$data = $this->request->data['toiawaseiConfirm'];
				$data['tourokucd'] = $this->Constants->SYSTEM;
				$data['tourokudt'] = $systemDateTime;
				$data['naiyouttl'] = "";
				$this->TToiawase->create();
				$this->TToiawase->save($data);
				// 業種の名称取得
				$gyosyu = $this->MGyosyu->find('first', array(
								'fields' => array('MGyosyu.gyosyunm'),
								'conditions' => array('MGyosyu.gyosyucd' => $data['gyosyucd'],
													'MGyosyu.fromdt <=' =>$this->Common->getSystemDate(),
													'MGyosyu.todt >=' =>$this->Common->getSystemDate())));
				$data['gyosyunm'] = $gyosyu['MGyosyu']['gyosyunm'];
				//事務局へメール送信
				$mailInfo=$this->Common->getMailInfo($this->MTuuci);
				if(!empty($mailInfo)){
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
						$subject_mail = '【ＰＲサイトお問い合わせ】';
						$msg_mail = $this->mailText($data, $systemDateTime,'1');
						$mail = new CakeEmail('smtp');
						$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						$mail->to($allmailaddrs);
						$mail->subject($subject_mail);
						$mail->emailFormat('html');
						$mail->send($msg_mail);
					}
					if (!empty($data['mailaddr'])) {
						// 確認メール　（申込者宛　確認メール）
						 $subject_kakuninMail = '【ＰＲサイトお問い合わせ】';
						 $msg_kakuninMail = $this->kakuninMailText($data, $systemDateTime,'1');
						 $kakuninMail = new CakeEmail('smtp');
						 $kakuninMail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						 $kakuninMail->to($data['mailaddr']);
						 $kakuninMail->subject($subject_kakuninMail);
						 $kakuninMail->emailFormat('html');
						 $kakuninMail->send($msg_kakuninMail);
					}
				}
				$this->Session->delete('previousPageInfo');
				$this->redirect([
						'controller' => 'contact',
						'action' => 'finish'
				]);
			} else {
				$errors = $this->TToiawase->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("ValidateToiawasei",$errors);
				$this->Session->write("ValidateToiawasei.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data['toiawaseiConfirm']);
				// $this->index();
				$this->redirect([
						'controller' => 'contact',
						'action' => 'index'
				]);
			}
		} else {
			$this->index();
		}
	}

	public function index2() {
		if (!empty($this->request->data)) {
			// 業種名称のセット
			$this->set('gyosyunm',$this->Common->getGyosyuName($this->MGyosyu));
			// 検証エラーのクリアする
			if(!$this->Session->read('ValidateToiawasei.errorflag')){
				$this->Session->delete('ValidateToiawasei');
			}
			$this->Session->write("ValidateToiawasei.errorflag",false);
			
			if (!empty($this->request->data['toiawaseiConfirm'])) {
				$this->set('backdata',$this->request->data['toiawaseiConfirm']);
				$this->set('toikaisyanm',$this->request->data['toiawaseiConfirm']['toikaisyanm']);
			} else if($this->Session->check('previousPageInfo')) {
				$this->set('backdata', $this->Session->read('previousPageInfo'));
				$this->set('toikaisyanm',$this->Session->read('previousPageInfo.toikaisyanm'));
				$this->Session->delete('previousPageInfo');
			} else {
				// 企業名のセット
				$this->set('toikaisyanm',$this->request->data('toikaisyanm'));
				$this->set('backdata',array('toikaisyanm'=>'', 
											'kaisyanm'=>'', 
											'yakunm'=>'', 
											'tantou'=>'', 
											'mailaddr'=>'', 
											'cmailaddr'=>'', 
											'telno'=>'', 
											'gyosyunm'=>'', 
											'gyosyucd'=>'',
											'naiyou'=>''));
			}
		} else {
			$this->redirect([
				'controller' => 'contact',
				'action' => 'index'
			]);
		}
	}
	
	public function confirm2() {
		if (!empty($this->request->data)) {
			// 業種の初期化
			if(!isset($this->request->data['gyosyucd'])) {
				$this->request->data['gyosyucd'] = "";
			}
			$responseString = "";
			$responseString = $this->textarea_maxlength("naiyou",$this->request->data['naiyou'],1024,$responseString);
			$this->TToiawase->set($this->request->data);
			if($this->TToiawase->validates() && $responseString == "") {
				if (!isset($this->request->data['gyosyunm'])) {
					$this->request->data['gyosyunm'] = '';
				}
				$this->set('gyosyunm', $this->MGyosyu->find('first',array(
										'fields' => array('MGyosyu.gyosyunm'),
										'conditions' => array(
													'MGyosyu.gyosyucd' => $this->request->data['gyosyucd'],
													'MGyosyu.fromdt <=' =>$this->Common->getSystemDate(),
													'MGyosyu.todt >=' =>$this->Common->getSystemDate()))));
				$this->set('confirmInfo',$this->request->data);
			} else {
				$errors = $this->TToiawase->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("ValidateToiawasei",$errors);
				$this->Session->write("ValidateToiawasei.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data);
				$this->redirect([
					'controller' => 'contact',
					'action' => 'index2'
				]);
			}
		} else {
			$this->redirect([
				'controller' => 'contact',
				'action' => 'index'
			]);
		}
	}

	/**
	 *　画面名：お問い合わせ
	 *　機能名：お問い合わせの完了処理
	 */
	public function finish2() {}


	/**
	 *　画面名：お問い合わせ
	 *　機能名：お問い合わせのメール送信処理
	 */
	public function sendmail2() {
		$systemDateTime=$this->Common->getSystemDateTime();
		if (!empty($this->request->data)) {
			$responseString = "";
			$responseString = $this->textarea_maxlength("naiyou",$this->request->data['toiawaseiConfirm']['naiyou'],1024,$responseString);
			$this->TToiawase->set($this->request->data['toiawaseiConfirm']);
			if($this->TToiawase->validates() && $responseString == "")
			{
				$data = $this->request->data['toiawaseiConfirm'];
				$data['tourokucd'] = $this->Constants->SYSTEM;
				$data['tourokudt'] = $systemDateTime;
				$data['naiyouttl'] = "";
				$this->TToiawase->create();
				$this->TToiawase->save($data);
				// 業種の名称取得
				$gyosyu = $this->MGyosyu->find('first', array(
								'fields' => array('MGyosyu.gyosyunm'),
								'conditions' => array('MGyosyu.gyosyucd' => $data['gyosyucd'],
													'MGyosyu.fromdt <=' =>$this->Common->getSystemDate(),
													'MGyosyu.todt >=' =>$this->Common->getSystemDate())));
				$data['gyosyunm'] = $gyosyu['MGyosyu']['gyosyunm'];
				//事務局へメール送信
				$mailInfo=$this->Common->getMailInfo($this->MTuuci);
				if(!empty($mailInfo)){
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
						$subject_mail = '【ＰＲサイト企業へのお問い合わせ】';
						$msg_mail = $this->mailText($data, $systemDateTime,'2');
						$mail = new CakeEmail('smtp');
						$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						$mail->to($allmailaddrs);
						$mail->subject($subject_mail);
						$mail->emailFormat('html');
						$mail->send($msg_mail);
					}
					if (!empty($data['mailaddr'])) {
						// 確認メール　（申込者宛　確認メール）
						 $subject_kakuninMail = '【ＰＲサイト企業へのお問い合わせ】';
						 $msg_kakuninMail = $this->kakuninMailText($data, $systemDateTime,'2');
						 $kakuninMail = new CakeEmail('smtp');
						 $kakuninMail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						 $kakuninMail->to($data['mailaddr']);
						 $kakuninMail->subject($subject_kakuninMail);
						 $kakuninMail->emailFormat('html');
						 $kakuninMail->send($msg_kakuninMail);
					}
				}
				$this->Session->delete('previousPageInfo');
				$this->redirect([
						'controller' => 'contact',
						'action' => 'finish2'
				]);
			} else {
				$errors = $this->TToiawase->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("ValidateToiawasei",$errors);
				$this->Session->write("ValidateToiawasei.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data['toiawaseiConfirm']);
				$this->index();
			}
		} else {
			$this->index();
		}
	}

	/**
	 * 画面名：会議・イベント申込
	 * 機能名：メール送信１　（事務局宛）
	 * @param 引継ぎ情報  columnValue
	 * @param システム日時  systemDateTime
	 * @return string
	 */
	private function mailText($columnValue,$systemDateTime,$flg) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 140px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8>";
		$message .= "<div style='font-family: Lucida Console !important;'>";
		$message .= "関係者各位<br/><br/>";
		if($flg == 1) {
			$message .= "ＰＲサイトよりお問い合わせがありました。<br/><br/>";
		} else {
			$message .= "ＰＲサイト掲載企業へのお問い合わせがありました。<br/><br/>";
		}
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>お問い合わせ日時</td><td $braceWidth>】</td>
		<td $maxwidth>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		if($flg == 2) {
			$message .= "<tr>
			<td $braceWidth>【</td><td $titleWidth>お問い合わせ企業</td><td $braceWidth>】</td>
			<td $maxwidth>".$columnValue['toikaisyanm']."</td>
						</tr>";
		}
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth >会　　社　　名</td><td $braceWidth>】</td>
		<td $maxwidth>".$columnValue['kaisyanm']."</td>
					</tr>";
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>役　　職　　名</td><td $braceWidth>】</td>
		<td $maxwidth>".$columnValue['yakunm']."</td>
					</tr>";
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>担　　当　　者</td><td $braceWidth>】</td>
		<td $maxwidth>".$columnValue['tantou']."</td>
					</tr>";
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>メール アドレス</td><td $braceWidth>】</td>
		<td $maxwidth>".$columnValue['mailaddr']."</td>
					</tr>";
		if($flg == 2) {
			$message .= "<tr>
			<td $braceWidth>【</td><td $titleWidth>電　話　番　号</td><td $braceWidth>】</td>
			<td $maxwidth>".$columnValue['telno']."</td>
						</tr>";
		}
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>業　　種　　名</td><td $braceWidth>】</td>
		<td $maxwidth>".$columnValue['gyosyunm']."</td>
					</tr>";
		$message .= "<tr>
		<td $braceWidth>【</td><td $titleWidth>お問い合わせ内容</td><td $braceWidth>】</td>
		<td $maxwidth>".nl2br($columnValue['naiyou'])."</td>
					</tr>";
		$message .= "</table>";
		$message .= "<br/>";
		$message .= "ご対応お願い致します。";
		$message .= "</div>";
		return $message;
	}

	/**
	 * 画面名：会議・イベント申込
	 * 機能名：メール送信２　（申込者宛　確認メール）
	 * @param  引継ぎ情報 columnValue
	 * @param  システム日時  systemDateTime
	 * @return string
	 */
	private function kakuninMailText($columnValue,$systemDateTime,$flg) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 140px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p>" .$columnValue['kaisyanm']. "</p>\n";
		$message .= "<p>" .$columnValue['tantou'].'　'.'様'. "</p>\n";
		$message .= "\n";
		if($flg == 1) {
			$message .= "<p>ＰＲサイトよりお問い合わせを承りました。</p>\n";
		} else {
			$message .= "<p>ＰＲサイト掲載企業へのお問い合わせを承りました。</p>\n";
		}
		$message .= "<table style='width:100%;font-family: monospace;'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>お問い合わせ日時</td><td $braceWidth>】</td>
						<td>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .="<tr>
						<td $braceWidth>【</td><td $titleWidth>お問い合わせ内容</td><td $braceWidth>】</td>
						<td>".nl2br($columnValue['naiyou']). "</td>
					</tr>";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>後日、事務局よりメールにてご連絡させて頂きます。</p>\n";
		$message .= "\n";
		$message .= "<p> -------------------------------------------------------------------------------------------------</p>";
		$message .= "<p>※このメールは送信専用のアドレスから配信しております。</p>\n";
		$message .= "<p>　　ご返信頂きましてもお答えできませんので、予めご了承願います。</p>\n";
		return $message;
	}

	/**
	 *　機能名：ダブルバイト変換
	 */
	public function doublebyte() {
		echo mb_convert_kana($this->request->data['val'],'AKS');exit();
	}
	/**
	 *　機能名：検証チェック処理
	 */
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$errors) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if(mb_strlen($dummy_str) > $maxlen) {
			$responseString[$fname][0] = "最大文字数を超えています。";
			if($errors != "") {
				$responseString = array_merge($errors, $responseString);
			}
			return $responseString;
		} else {
			return $errors;
		}
	}
	/**
	 *　機能名：新しいキャプチャを作る
	 */
	public function getRefreshCaptcha() {
		$captcha = array();
		$captcha['image'] = captchaImage();
		$captcha['captcha_code'] = $this->Session->read('captcha_code');
		echo json_encode($captcha); exit();
	}

}