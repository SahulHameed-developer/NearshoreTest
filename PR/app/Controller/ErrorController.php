<?php
App::uses('AppController', 'Controller');

/**
 * エラー Controller
 *
 * システムエラーを表示するControllerです。
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class ErrorController extends AppController {

	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash', 'Session');
	
	public function systemError() {
		$this->Auth->logout();
		$this->layout = false;
		$this->render('/Error/systemError');
	}

}