<?php
class Captcha
{
    function getCaptchaCode($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $output = '';
        for ($i = 0; $i < $length; $i++) {
            $output .= $characters[rand(0, $characters_length - 1)];
        }
        $random_alpha = md5($output);
        $captcha_code = substr($random_alpha, 0, $length);
        return $captcha_code;
    }
    
    function setSession($key, $value) {
        $_SESSION["$key"] = $value;
    }
    
    function getSession($key) {
        $value = "";
        if(!empty($key) && !empty($_SESSION["$key"]))
        {            
            $value = $_SESSION["$key"];
        }
        return $value;
    }

    function createCaptchaImage($captcha_code)
    {
        $target_layer = imagecreatetruecolor(72,28);
        $captcha_background = imagecolorallocate($target_layer, 204, 204, 204);
        imagefill($target_layer,0,0,$captcha_background);
        $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
        imagestring($target_layer, 5, 10, 5, $captcha_code, $captcha_text_color);
        return $target_layer;
    }

    function renderCaptchaImage($imageData)
    {
        ob_start();
        imagejpeg($imageData, NULL, 100);
        // finally retrieve the byte stream
        $rawImageBytes = ob_get_clean();
        return base64_encode( $rawImageBytes );
    }
    
    function validateCaptcha($formData) {
        $isValid = false;
        $capchaSessionData = $this-> getSession("captcha_code");
        if($capchaSessionData == $formData) 
        {
            $isValid = true;
        }
        return $isValid;
    }
}
?>