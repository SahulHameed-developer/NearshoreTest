<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Common');
/**
 
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminPasswordChangeController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('TKaiin', 'MTuuci', 'Syslog');
	// レイアウト無し
	public $autoLayout = false;
	
	public function irai() {
		$this->set('mailadd', '');
		$this->set('cmailadd', '');
		// 画面の移動
		$this->render('/Admin/PasswordChange/irai');
	}
	public function saihakko() {
		if (!empty($_REQUEST['CD'])) {
			$cddata = $this->encrypt_decrypt('decrypt', $_REQUEST['CD']);
			$cddata = substr($cddata, 10);
			$kaiinname = $this->TKaiin->find ( 'first', array (
				'fields' => array('kaiinnm'),
				'conditions' => array ('kaiincd ' => $cddata)
			));
			if(!isset($kaiinname['TKaiin']['kaiinnm'])) {
				$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
			}
			$this->set('kaiinnm', $kaiinname['TKaiin']['kaiinnm']);
			$this->set('kaiincd', $cddata);
			// 画面の移動
			$this->render('/Admin/PasswordChange/saihakko');
		} else {
			$this->redirect ( [
					'controller' => 'Admin',
					'action' => 'index'
			] );
		}
	}
	/**
	 * 機能名：パスワード変更のためメール送信処理。
	 */
	public function sendMail() {
		try {
			$this->request->data = $this->splitothersFields($this->request->data['otherFields']);
			$err = $this->Validation();
			if(!empty($err)) {
				echo $err;
			} else {
				if (!empty($this->request->data)) {
					$conditions[] = array('TKaiin.mailaddr'=> $this->request->data['mailaddr']);	
					$conditions[] = array('OR' => array(
									array('TKaiin.taikaidate' => NULL),
									array('TKaiin.taikaidate' => "0000-00-00")));
					$data = $this->TKaiin->find('first',array(
									'fields' => array('TKaiin.kaiincd',
													'TKaiin.kanrikbn',
													'TKaiin.mailaddr'),
									'conditions' => $conditions ));
					if (!empty($data)) {
						//事務局へメール送信
						$mailInfo = $this->Common->getMailInfo($this->MTuuci);
						if(!empty($mailInfo)){
							// メール送信１　（事務局宛）
							$subject_mail1 = '【ご連絡】パスワード再発行について';
							$msg_mail = $this->mailGeneration($data);
							$mail = new CakeEmail('smtp');
							$mail->from ($mailInfo['0']['MTuuci']['mailaddrsend']);
							$mail->to ( $data['TKaiin']['mailaddr']);
							$mail->subject($subject_mail1);
							$mail->emailFormat('html');
							// メール送信
							if($mail->send($msg_mail)) {
								echo "1";
							} else {
								echo "Invalid Mail Id";
							} 
						}
					} else {
						echo "入力されたメールアドレスは登録されていません。 正しく入力してください。";
					}
				} else {
						echo "登録メールアドレスを入力してください。";
					}
			}
		} catch (Exception $e) {
			$Common = new CommonController;
			$Common->systemError($e);
			ob_end_clean();
			echo "SYSTEM_ERROR";
			// $this->redirect ( [
			// 		'controller' => 'Error',
			// 		'action' => 'systemError' ] );
		}
		exit();
	}
	/**
	 * 機能名：パスワード変更処理。
	 */
	public function finish() {
		try {
			$db = $this->TKaiin->getDataSource();
			$data = array(
					'TKaiin.lgpass' => $db->value( $this->request->data['pwd'], 'string'),
					'TKaiin.kousincd' => $db->value($this->request->data['kaiincd'], 'string'),
					'TKaiin.kousindt' => $db->value($this->Common->getSystemDateTime(), 'string')
			);
			$conditions[] = array('TKaiin.kaiincd'=> $this->request->data['kaiincd']);
			$conditions[] = array('OR' => array(
							array('TKaiin.taikaidate' => NULL),
							array('TKaiin.taikaidate' => "0000-00-00")));
			// 会員情報の更新
			$result = $this->TKaiin->updateAll($data, $conditions);
			$affectedRow = $db->lastAffected();
			if(!$result || $affectedRow == 0) {
				$systemError = array('logdt' => $this->Common->getSystemDateTime(), 
						'kaiinno' => $this->request->data['kaiincd'], 'syubetu' => '01', 
						'errurl' => Router::url('/', true).'adminPasswordChange/saihakko' , 'errsyousai' => '会員情報の更新が異常終了'
				);
				$this->Syslog->save($systemError);
				// 異常終了
				$this->redirect (['controller' => 'Error','action' => 'systemError' ]);
			} else {
				// 正常終了
				$this->render('/Admin/PasswordChange/finish');
			}
		} catch (Exception $e) {
			$systemError = array('logdt' => $this->Common->getSystemDateTime(),
					'kaiinno' => $this->request->data['kaiincd'], 'syubetu' => '01',
					'errurl' => Router::url('/', true).'adminPasswordChange/saihakko' , 'errsyousai' => '会員情報の更新が異常終了'
			);
			$this->Syslog->save($systemError);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
	}
	/**
	 * フォームバリデーション。
	 * @return string
	 */
	private function validation() {
		$err_msg = "";
		$this->set('mailadd', '');
		$this->set('cmailadd', '');
		if (empty($this->request->data['mailaddr'])) {
			$err_msg = "登録メールアドレスが未入力です。";
			$this->set('cmailadd', $this->request->data['cmailaddr']);
		} elseif (empty($this->request->data['cmailaddr'])) {
			$err_msg = "確認用メールアドレスが未入力です。";
			$this->set('mailadd', $this->request->data['mailaddr']);
		} elseif ($this->request->data['mailaddr'] != $this->request->data['cmailaddr']) {
			$err_msg = "メールアドレスが一致しません。";
			$this->set('cmailadd', $this->request->data['cmailaddr']);
			$this->set('mailadd', $this->request->data['mailaddr']);
		}
		return $err_msg;
	}
	/**
	 * 機能名：メール内容を作る処理。
	 * @param 引継ぎ情報  columnValue
	 * @return string
	 */
	private function mailGeneration($columnValue) {
		$kaiincd = $columnValue['TKaiin']['kaiincd'];
		$kaiincd = date('mdGis').$kaiincd;
		$url = $this->encrypt_decrypt('encrypt', $kaiincd);
		$message="";
		$message .= "<p>いつもお世話になっております。<br/>";
		$message .= "ニアショアIT協会　事務局です。</p>";
		$message .= "<p>パスワード再発行依頼を受け付けました。</p>\n";
		$message .= "\n";
		$message .= "<p>次のＵＲＬへアクセスし、パスワード再発行手続きを行ってください。</p>\n";
		$message .= "\n";
		$message .= "<p>◆パスワード再発行画面";
		$message .= '<br/>'.Router::url('/', true).'adminPasswordChange/saihakko?CD='.$url."</p>";
		return $message;
	}
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
	private function encrypt_decrypt($action, $string) {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'secretkeyshisankei';
	    $secret_iv = 'secretivshisankei';
	    // hash
	    $key = hash('sha256', $secret_key);
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    if ( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if( $action == 'decrypt' ) {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	}
}