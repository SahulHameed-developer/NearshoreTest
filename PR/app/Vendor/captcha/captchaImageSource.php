<?php
require_once "Captcha.php";
function captchaImage()
{
	$captcha = new Captcha();
	$captcha_code = $captcha->getCaptchaCode(6);
	$captcha->setSession('captcha_code', $captcha_code);
	$imageData = $captcha->createCaptchaImage($captcha_code);
	return $captcha->renderCaptchaImage($imageData);
}
?>