<?php
App::uses('AppController', 'Controller');
/**
 * Top Controller
 *
 * ニアショアＩＴ協会　会員企業のPRサイトを表示するControllerです。【画面分類：公開】
 * 
 * @author MICROBIT Co. Ltd.,
 *
 */
class AboutController extends AppController {
	// helpers配列宣言
	public $helpers = array('Html', 'Form', 'Flash');
	// components配列宣言
	public $components = array('Flash', 'RequestHandler');
	
	public function index() {}
}