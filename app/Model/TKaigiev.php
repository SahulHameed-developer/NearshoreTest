<?php
App::uses('AppModel', 'Model');
/**
 * 会議・イベント申込情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TKaigiev extends AppModel {
	// バリデーション
	public $validate = array(
			'kaisyanm' =>  array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会社名が未入力です"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'simei' =>  array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "氏名が未入力です。"
					),
					'withTwoString' => array(
							'rule' => array('withTwoString'),
							'message' => '姓と名の間に全角スペースを入力してください。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'mailaddr' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会員メールアドレスが未入力です。"
					),
					'required' => array(
							'rule' => array('email'),
							'message' => 'メールアドレスの形式が不正です。'
					),
					'specialChar' => array(
							'rule' => array('specialChar'),
							'message' => 'メールアドレスに使用できない文字が含まれています。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					),
					'restrictMailAddr' => array(
							'rule' => array('restrictMailAddr'),
							'message' => 'このメールアドレスは制限されています。'
					)
			)
	);
	/**
	 *　画面名：入会申込
	 *　機能名：英数、ハイフン(-)、アンダーバー(_)、ピリオド(.)、@の文字チェックの処理。
	 */
	function specialChar() {
		$specialCharVal = trim($this->data['TKaigiev']['mailaddr']);
		return preg_match('/^[a-zA-Z0-9-_.@]*$/',$specialCharVal);
	}
	/**
	 *　画面名：入会申込
	 *　機能名：全角スペースがあるチェックの処理。
	 */
	function withTwoString($fields) {
		$twoStringValue = trim($this->data['TKaigiev']['simei']);
		$twoStringValue = preg_replace('/\s{2,}/', '　', $twoStringValue);
		$twoStringValue = explode('　', $twoStringValue);
		if (sizeof($twoStringValue) == 2) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 *　画面名：入会申込
	 *　機能名：メールアドレスの禁止
	 */
	function restrictMailAddr($check) {
		$restrictEmailCheck = false;
		if($check['mailaddr'] != ConstantsComponent::$RESTRICT_MAIL_ADDR){
			$restrictEmailCheck = true;
		}
		return $restrictEmailCheck;
	}
	/**
	 *　画面名：入会申込
	 *　機能名：キャプチャコードチェック
	 */
	function checkCaptcha($check) {
		$captcha = new Captcha();
		$isValidCaptcha = $captcha->validateCaptcha($check['captchaCode']);
		return $isValidCaptcha;
	}
}