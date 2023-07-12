<?php
App::uses('AppModel', 'Model');
/**
 * お問い合わせ情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TToiawase extends AppModel {
	// バリデーション
	public $validate = array(
			'kaisyanm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会社名が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'yakunm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "役職名が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'tantou' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "担当者名が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'mailaddr' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "メールアドレスが未入力です。"
					),
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => 'メールアドレスの書式で入力してください。'
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
			'cmailaddr' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "確認メールアドレスが未入力です。"
					),
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => 'メールアドレスの書式で入力してください。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					),
					'restrictCMailAddr' => array(
							'rule' => array('restrictCMailAddr'),
							'message' => 'このメールアドレスは制限されています。'
					)
			),
			'gyosyucd' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "業種が未選択です。"
					)
			),
			'naiyou' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "お問い合わせ内容が未入力です。"
					)
			),
			'captchaCode' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "キャプチャが必須です。"
					),
					'checkCaptcha' => array(
							'rule' => array('checkCaptcha'),
							'message' => '正しいキャプチャを入力してください。'
					)
			)
	);
	/**
	 *　画面名：お問い合わせ
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
	 *　画面名：お問い合わせ
	 *　機能名：メールアドレスの禁止
	 */
	function restrictCMailAddr($check) {
		$restrictMailAddrCheck = false;
		if($check['cmailaddr'] != ConstantsComponent::$RESTRICT_MAIL_ADDR){
			$restrictMailAddrCheck = true;
		}
		return $restrictMailAddrCheck;
	}
	/**
	 *　画面名：お問い合わせ
	 *　機能名：キャプチャコードチェック
	 */
	function checkCaptcha($check) {
		$captcha = new Captcha();
		$isValidCaptcha = $captcha->validateCaptcha($check['captchaCode']);
		return $isValidCaptcha;
	}
}