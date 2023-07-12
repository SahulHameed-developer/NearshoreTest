<?php
App::uses('AppModel', 'Model');
/**
 * 入会申込情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TNyuukai extends AppModel {
	// バリデーション
	public $validate = array(
			'kaiinsbcd' =>  array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会員種別が未選択です。"
					)
			),
			'syokaikaisyanm' =>  array(
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'syokainm' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaisyanm' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会社名が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaisyanmkana' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会社名かなが未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'yakunm' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "役職名が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'simei' => array(
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
			'simeikana' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "氏名かなが未入力です。"
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
			'telno' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "会員種別が未選択です。"
					),
					'starthyphens' => array(
							'rule' => array('starthyphens'),
							'message' => '正しい番号を入力してください。'
					),
					'hyphensnecessary' => array(
							'rule' => array('hyphensnecessary'),
							'message' => 'ハイフン（-）を含めた電話番号を入力してください。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 15),
							'message' => '最大文字数を超えています。'
					)
			),
			'mailaddr' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "メールアドレスが未入力です。"
					),
					'required' => array(
							'rule' => array('email'),
							'message' => 'メールアドレスの形式が不正です'
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
			),
			'gyosyucd' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "業種が未選択です。"
					)
			),
			'captchaCode' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "キャプチャが未入力です。"
					),
					'checkCaptcha' => array(
							'rule' => array('checkCaptcha'),
							'message' => '正しいキャプチャを入力してください。'
					)
			)
	);
	/**
	 *　画面名：入会申込
	 *　機能名：全角スペースがあるチェックの処理。
	 */
	function withTwoString($fields) {
		if (isset($fields['simei'])) {
			$twoStringValue = trim($this->data['TNyuukai']['simei']);
		} else {
			$twoStringValue = trim($this->data['TNyuukai']['simeikana']);
		}
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
	 *　機能名：ハイフンを含めた電話番号、市外局番の省略無しするチェックのの処理。
	 */
	function phone() {
		$phoneNumber = trim($this->data['TNyuukai']['telno']);
		$phoneNumber = preg_replace('/\s+/', '', $phoneNumber);
		return strlen($phoneNumber) > 9 &&
		preg_match('/^\(?[\d\s]{3}-[\d\s]{3}-[\d\s]{4}$/',$phoneNumber);
	}
	function starthyphens() {
		$phoneNumber = trim($this->data['TNyuukai']['telno']);
		$phoneNumber = preg_replace('/\s+/', '', $phoneNumber);
		return strlen($phoneNumber) > 9 &&
		preg_match('/^(?:\d{10}|\d{3}-\d{3}-\d{4}|\d{2}-\d{4}-\d{4}|\d{3}-\d{4}-\d{4}|\d{4}-\d{2}-\d{4})$/',$phoneNumber);
	}
	function hyphensnecessary() {
		$phoneNumber = trim($this->data['TNyuukai']['telno']);
		$phoneNumber = preg_replace('/\s+/', '', $phoneNumber);
		return strlen($phoneNumber) > 9 &&
		preg_match('/[-]/',$phoneNumber);
	}
	/**
	 *　画面名：入会申込
	 *　機能名：英数、ハイフン(-)、アンダーバー(_)、ピリオド(.)、@の文字チェックの処理。
	 */
	function specialChar() {
		$specialCharVal = trim($this->data['TNyuukai']['mailaddr']);
		return preg_match('/^[a-zA-Z0-9-_.@]*$/',$specialCharVal);
	}
	/**
	 *　画面名：入会申込
	 *　機能名：メールアドレスの禁止
	 */
	function restrictMailAddr($check) {
		$restrictMailAddrCheck = false;
		if($check['mailaddr'] != ConstantsComponent::$RESTRICT_MAIL_ADDR){
			$restrictMailAddrCheck = true;
		}
		return $restrictMailAddrCheck;
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