<?php
App::uses('AppModel', 'Model');
/**
 * 申込情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TEntry extends AppModel {
	public $virtualFields = array(
			'kyoukaiykcdEmpty' => 'IF(TKaiin.kyoukaiykcd IS NULL, 999, IF(TKaiin.kyoukaiykcd = "", 999, TKaiin.kyoukaiykcd))',
			'kaiinnmkanaEmpty' => 'IF(TKaiin.kaiinnmkana IS NULL, TKaiin.kaiinnm, IF(TKaiin.kaiinnmkana = "", TKaiin.kaiinnm, TKaiin.kaiinnmkana))'
	);
	/**
	 *　画面名：申込情報
	 *　機能名：キャプチャコードチェック
	 */
	function checkCaptcha($check) {
		$captcha = new Captcha();
		$isValidCaptcha = $captcha->validateCaptcha($check['captchaCode']);
		return $isValidCaptcha;
	}
}