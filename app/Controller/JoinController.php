<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('vendor', 'captcha/Captcha');
App::import('vendor', 'captcha/captchaImageSource');

/**
 * Join Controller
 *
 * 入会についての情報を表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class JoinController extends AppController
{
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash', 'Session');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler', 'Session', 'Flash', 'Constants', 'Common');
	// モデル名配列宣言
	var $uses = array('MGyosyu', 'MKaiinsb', 'TNyuukai', 'MTuuci');
	/**
	 *　画面名：入会
	 *　機能名：入会についての 初期表示
	 */
	public function index() {
		$this->redirect([
				'controller' => 'join',
				'action' => 'about'
		]);
	}
	public function gotoentry() {
		$this->redirect([
				'controller' => 'join',
				'action' => 'entry'
		]);
	}
	/**
	 *　画面名：入会
	 *　機能名：入会申込処理
	 */
	public function entry() {
		if(!$this->Session->read('errorMsg.errorflag')){
			$this->Session->delete('errorMsg');
		}
		$this->Session->write("errorMsg.errorflag",false);
		// 業種名称のセット
		$this->set('gyosyunm',$this->Common->getGyosyuName ($this->MGyosyu));
		// 会員種別名称のセット
		$this->set('kaiinsbnm',$this->Common->getKaiinShubetsuName ($this->MKaiinsb));
		if($this->Session->check('previousPageInfo')) {
			$this->request->data = $this->Session->read('previousPageInfo');
			$this->Session->delete('previousPageInfo');
		}
		$this->request->data['captchaImageData'] = captchaImage();
		if (isset($this->request->data['nyukaiTorokuFrm'])) {
			$this->set([
				'kaiinsbName' => $this->request->data['nyukaiTorokuFrm']['kaiinsbName'],
				'gyosyuName' => $this->request->data['nyukaiTorokuFrm']['gyosyuName'],
				'selectedKaiinsbnm' => $this->request->data['nyukaiTorokuFrm']['kaiinsbcd'],
				'syokaiKaisyaNm' => $this->request->data['nyukaiTorokuFrm']['syokaikaisyanm'],
				'syokaiNm' => $this->request->data['nyukaiTorokuFrm']['syokainm'],
				'kaisyaNm' => $this->request->data['nyukaiTorokuFrm']['kaisyanm'],
				'kaisyaNmKana' => $this->request->data['nyukaiTorokuFrm']['kaisyanmkana'],
				'yakuNm' => $this->request->data['nyukaiTorokuFrm']['yakunm'],
				'simei' => $this->request->data['nyukaiTorokuFrm']['simei'],
				'simeiKana' => $this->request->data['nyukaiTorokuFrm']['simeikana'],
				'telno' => $this->request->data['nyukaiTorokuFrm']['telno'],
				'mailAddr' => $this->request->data['nyukaiTorokuFrm']['mailaddr'],
				'confMailAddr'=> $this->request->data['nyukaiTorokuFrm']['confMailAddr'],
				'selectedGyosyunm'=> $this->request->data['nyukaiTorokuFrm']['gyosyucd'],
				'bikou'=> $this->request->data['nyukaiTorokuFrm']['bikou'],
				'buttonSel'=> ''
			]);
		} else if (isset($this->request->data['nyukai'])) {
			$this->set([
				'kaiinsbName' => $this->request->data['nyukai']['kaiinsbName'],
				'gyosyuName' => $this->request->data['nyukai']['gyosyuName'],
				'selectedKaiinsbnm' => $this->request->data['members_type'],
				'syokaiKaisyaNm' => $this->request->data['syokaikaisyanm'],
				'syokaiNm' => $this->request->data['syokainm'],
				'kaisyaNm' => $this->request->data['kaisyanm'],
				'kaisyaNmKana' => $this->request->data['kaisyanmkana'],
				'yakuNm' => $this->request->data['yakunm'],
				'simei' => $this->request->data['simei'],
				'simeiKana' => $this->request->data['simeikana'],
				'telno' => $this->request->data['telno'],
				'mailAddr' => $this->request->data['mailaddr'],
				'confMailAddr'=> $this->request->data['confMailaddr'],
				'selectedGyosyunm'=> $this->request->data['industry'],
				'bikou'=> $this->request->data['bikou'],
				'buttonSel'=> ''
			]);
		} else if (array_key_exists('back_button', $this->request->data)){
			// フォームの値セット
			$this->set([
				'kaiinsbName' => $this->request->data['modoruFrm']['kaiinsbName'],
				'gyosyuName' => $this->request->data['modoruFrm']['gyosyuName'],
				'selectedKaiinsbnm' => $this->request->data['modoruFrm']['selectedKaiinsbnm'],
				'syokaiKaisyaNm' => $this->request->data['modoruFrm']['syokaiKaisyaNm'],
				'syokaiNm' => $this->request->data['modoruFrm']['syokaiNm'],
				'kaisyaNm' => $this->request->data['modoruFrm']['kaisyaNm'],
				'kaisyaNmKana' => $this->request->data['modoruFrm']['kaisyaNmKana'],
				'yakuNm' => $this->request->data['modoruFrm']['yakuNm'],
				'simei' => $this->request->data['modoruFrm']['simei'],
				'simeiKana' => $this->request->data['modoruFrm']['simeiKana'],
				'telno' => $this->request->data['modoruFrm']['telno'],
				'mailAddr' => $this->request->data['modoruFrm']['mailAddr'],
				'confMailAddr'=> $this->request->data['modoruFrm']['confMailAddr'],
				'selectedGyosyunm'=> $this->request->data['modoruFrm']['selectedGyosyunm'],
				'bikou'=> $this->request->data['modoruFrm']['bikou'],
				'buttonSel'=> 'modoru'
			]);
		}else{
			// 初期表示値のセット
			$this->setInitialValue();
		}
		// 画面の移動
		$this->render('Entry/index');
	}
	/**
	 *　画面名：入会
	 *　機能名：入力内容の確認処理
	 */
	public function confirm() {
		if(!empty($this->request->data)){
			// システム日付
			$systemDateTime=$this->Common->getSystemDateTime();
			// 項目の値セット
			$columnValue = $this->request->data;
			$columnValue['tourokucd'] =  $this->Constants->SYSTEM;
			$columnValue['tourokudt'] =  $systemDateTime;
			$responseString = "";
			$responseString = $this->textarea_maxlength("bikou",$columnValue['bikou'],255,$responseString);
			$this->TNyuukai->set($columnValue);
			if($this->TNyuukai->validates() && $responseString == "")
			{
				$this->set([
					'kaiinsb' => $this->request->data['members_type'],
					'kaiinsbName' => $this->request->data['nyukai']['kaiinsbName'],
					'syokaiKaisyaNm' => $this->request->data['syokaikaisyanm'],
					'syokaiNm' => $this->request->data['syokainm'],
					'kaisyaNm' => $this->request->data['kaisyanm'],
					'kaisyaNmKana' => $this->request->data['kaisyanmkana'],
					'yakuNm' => $this->request->data['yakunm'],
					'simei' => $this->request->data['simei'],
					'simeiKana' => $this->request->data['simeikana'],
					'telno' => $this->request->data['telno'],
					'mailAddr' => $this->request->data['mailaddr'],
					'confMailAddr'=> $this->request->data['confMailaddr'],
					'gyosyu'=> isset($this->request->data['industry'])?$this->request->data['industry']:'',
					'gyosyuName' => $this->request->data['nyukai']['gyosyuName'],
					'bikou'=> $this->request->data['bikou']
				]);
				// 画面の移動
				$this->render('Entry/confirm');
			} else {
				$errors = $this->TNyuukai->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("errorMsg",$errors);
				$this->Session->write("errorMsg.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data);
				$this->gotoentry();
			}
		} else {
			$this->redirect([
					'controller' => 'join',
					'action' => 'entry'
			]);
		}
	}
	/**
	 *　画面名：入会
	 *　機能名：入会申込完了のメール送信処理
	 */
	public function sendmail() {
		if(!empty($this->request->data)){
			// システム日付
			$systemDateTime=$this->Common->getSystemDateTime();
			// 項目の値セット
			$columnValue = $this->request->data['nyukaiTorokuFrm'];
			$columnValue['tourokucd'] =  $this->Constants->SYSTEM;
			$columnValue['tourokudt'] =  $systemDateTime;
			$responseString = "";
			$responseString = $this->textarea_maxlength("bikou",$columnValue['bikou'],255,$responseString);
			$this->TNyuukai->set($columnValue);
			if($this->TNyuukai->validates() && $responseString == "")
			{
				// 会議・イベント申込情報作成
				$this->TNyuukai->create();
				// 会議・イベント申込情報に登録
				$this->TNyuukai->save($columnValue);
				//事務局へメール送信
				$mailInfo=$this->Common->getMailInfo($this->MTuuci);
				if(!empty($mailInfo)) {
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
						$subject_mail = '【入会申込】' . $columnValue['kaiinsbName'];
						$msg_mail = $this->mailText($columnValue, $systemDateTime);
						$mail = new CakeEmail('smtp');
						$mail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						$mail->to($allmailaddrs);
						$mail->subject($subject_mail);
						$mail->emailFormat('html');
						$mail->send($msg_mail);
					}
					// 確認メール　（申込者宛　確認メール）
					if (!empty($columnValue['mailaddr'])) {
						$subject_kakuninMail = '【入会申込受付】' . $columnValue['kaiinsbName'];
						$msg_kakuninMail = $this->kakuninMailText($columnValue, $systemDateTime);
						$kakuninMail = new CakeEmail('smtp');
						$kakuninMail->from($mailInfo['0']['MTuuci']['mailaddrsend']);
						$kakuninMail->to ($columnValue['mailaddr']);
						$kakuninMail->subject($subject_kakuninMail);
						$kakuninMail->emailFormat('html');
						$kakuninMail->send($msg_kakuninMail);
					}
				}
				$this->Session->delete('previousPageInfo');
				$this->redirect([
						'controller' => 'join',
						'action' => 'finish'
				]);
			} else {
				$errors = $this->TNyuukai->validationErrors;
				if($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("errorMsg",$errors);
				$this->Session->write("errorMsg.errorflag",true);
				$this->Session->write('previousPageInfo', $this->request->data);
				$this->gotoentry();
			}
		} else {
			$this->redirect([
					'controller' => 'join',
					'action' => 'entry'
			]);
		}
	}
	/**
	 *　画面名：入会
	 *　機能名：入会申込完了画面
	 */
	public function finish() {
		// 画面の移動
		$this->render('Entry/finish');
	}
	/**
	 *　画面名：入会
	 *　機能名：faq 初期表示
	 */
	public function faq() {
		// 画面の移動
		$this->render('Faq/index');
	}
	/**
	 *　画面名：入会
	 *　機能名：入会についての 初期表示
	 */
	public function about() {
		// 画面の移動
		//PDFのパス
		$filepath = $this->Constants->FILEPATH;
		$this->set('filepath', $filepath);
		//PDFの名前
		$filename = $this->Constants->FILENAME;
		$this->set('filename', $filename);
		$this->render('About/index');
	}
	/**
	 *　画面名：入会
	 *　機能名：初期値設定
	 */
	private function setInitialValue() {
		$optionVal = $this->MKaiinsb->find('first', array(
						'conditions' => array(
								'MKaiinsb.fromdt <=' =>$this->Common->getSystemDate(),
								'MKaiinsb.todt >=' =>$this->Common->getSystemDate()),
						'order'=>array(
								'MKaiinsb.kaiinsbcd' => 'ASC')));
		$selectedKaiinsbcd = $optionVal['MKaiinsb']['kaiinsbcd'];
		$selectedKaiinsbnm = $optionVal['MKaiinsb']['kaiinsbnm'];
		//会員種別名称の初期表示
		$this->set('selectedKaiinsbnm', $selectedKaiinsbcd);
		$this->set('kaiinsbName', $selectedKaiinsbnm);
		// 業種名称の初期表示
		$this->set('selectedGyosyunm', '');
		$this->set('gyosyuName', '');
		// フォームの値セット
		$this->set([
			'syokaiKaisyaNm' => '',
			'syokaiNm' => '',
			'kaisyaNm' => '',
			'kaisyaNmKana' => '',
			'yakuNm' => '',
			'simei' => '',
			'simeiKana' => '',
			'telno' => '',
			'mailAddr' => '',
			'confMailAddr'=> '',
			'bikou'=> '',
			'buttonSel'=> ''
		]);
	}
	/**
	 * 画面名：入会
	 * 機能名：メール送信１　（事務局宛）
	 * @param 引継ぎ情報  columnValue
	 * @param システム日時  systemDateTime
	 * @return string
	 */
	private function mailText($columnValue,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 120px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message ="";
		$message .= "<p> 関係者各位</p>\n";
		$message .= "\n";
		$message .= "<p> 入会申込がありました。</p>\n";
		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申　込　日　時</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申込会員種別名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['kaiinsbName']."</td></tr>";
		if(!empty($columnValue['syokaikaisyanm'])){
			$message .= "<tr>
							<td $braceWidth>【</td><td $titleWidth>紹介者　会社名</td><td $braceWidth>】</td>
							<td $maxwidth>".$columnValue['syokaikaisyanm']."</td>
						</tr>";
		}
		if(!empty($columnValue['syokainm'])){
			$message .= "<tr>
							<td $braceWidth>【</td><td $titleWidth>紹　介　者　名</td><td $braceWidth>】</td>
							<td $maxwidth>".$columnValue['syokainm']."</td>
						</tr>";
		}
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　　社　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['kaisyanm']."</td>
					</tr>";
		$message .= "<tr>
							<td $braceWidth>【</td><td $titleWidth>会 社 名　か な</td><td $braceWidth>】</td>
							<td $maxwidth>".$columnValue['kaisyanmkana']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>役　　職　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['yakunm']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>氏　　　　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['simei']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>氏　名　か　な</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['simeikana']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>電　話　番　号</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['telno']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>メールアドレス</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['mailaddr']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>業　　種　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['gyosyuName']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>備　　　　　考</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($columnValue['bikou'])."</td></tr>";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご対応お願い致します。</p>";
		return $message;
	}
	/**
	 * 画面名：入会
	 * 機能名：メール送信２　（申込者宛　確認メール）
	 * @param  引継ぎ情報 columnValue
	 * @param  システム日時  systemDateTime
	 * @return string
	 */
	private function kakuninMailText($columnValue,$systemDateTime) {
		$hrstyle = "style='display: block;margin-top: 0.5em;margin-bottom: 0.5em;margin-left: auto;margin-right: auto;border-style: dashed;border-width: 0.1px;'";
		$titleWidth = "style='vertical-align: top; text-align: center; width: 120px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= '<p>' .$columnValue['kaisyanm']. "</p>\n";
		$message .= '<p>' .$columnValue['simei'].'　'.'様'. "</p>\n";
		$message .= "\n";
		$message .= "<p> 入会の申込を承りました。</p>\n";
		$message .= "<table style='font-family: monospace;'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申　込　日　時</td><td $braceWidth>】</td>
						<td>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申込会員種別名</td><td $braceWidth>】</td>
						<td>".$columnValue['kaiinsbName']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>備　　　　　考</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($columnValue['bikou'])."</td>
					</tr>";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p> 後日、事務局よりメールにてご連絡させて頂きます。</p>\n";
		$message .= "\n";
		$message .= "<hr $hrstyle>";
		$message .= "<p>※このメールは送信専用のアドレスから配信しております。</p>\n";
		$message .= "<p>　ご返信頂きましてもお答えできませんので、予めご了承願います。</p>\n";
		return $message;
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