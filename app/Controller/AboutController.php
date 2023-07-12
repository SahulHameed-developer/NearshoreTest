<?php
App::uses('AppController', 'Controller');
/**
 * ニアショアIT協会とはの Controller
 *
 * ニアショアIT協会とはの情報を表示するControllerです。【画面分類：公開】
 *
 * @author MICROBIT Co.Ltd.,
 *
 */
class AboutController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form');
	// components追加
	public $components = array('RequestHandler');
	/**
	 *　画面名　：　協会概要
	 *　機能処理　：　協会概要画面へ遷移する
	 */
	public function index() {
		// 画面の移動
		$this->render('Outline/index');
	}
	/**
	 *　画面名　：　組織図
	 *　機能処理　：　組織図画面へ遷移する
	 */
	public function organization() {
		// 画面の移動
		$this->render('Organization/index');
	}
	/**
	 *　画面名　：　ご挨拶
	 *　機能処理　：　ご挨拶画面へ遷移する
	 */
	public function message() {
		// 画面の移動
		$this->render('Message/index');
	}
	/**
	 *　画面名　：　役員紹介
	 *　機能処理　：　役員紹介画面へ遷移する
	 */
	public function executive() {
		// 画面の移動
		$this->render('Executive/index');
	}
	/**
	 *　画面名　：　定款
	 *　機能処理　：　定款画面へ遷移する
	 */
	public function statute() {
		// 画面の移動
		$this->render('Statute/index');
	}
	/**
	 *　画面名　：　アクセス
	 *　機能処理　：　アクセス画面へ遷移する
	 */
	public function access() {
		// 画面の移動
		$this->render('Access/index');
	}
}
?>