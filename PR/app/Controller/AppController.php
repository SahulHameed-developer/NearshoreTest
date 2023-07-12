<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $uses = array ('Syslog');
	
	public $components = array(
			'Auth' => array(
					'authenticate' => array('Kaisya'),
					'loginAction' => array(),
					'loginRedirect' => array('controller' => 'AdminProductsite','action' => 'indexredirect'),
					'logoutRedirect' => array('controller' => 'Top','action' => 'index'),
					'authorize' => 'Controller'
			),
			'Constants'
	);
	function _setErrorLayout() {
		if ($this->name == 'CakeError') {
			$systemError = array('logdt' => date('Y-m-d G:i:s'), 
								'kaiinno' => '',
								'syubetu' => '01',
								'errurl' => Router::url($this->here, true),
								'errcd' => $this->viewVars['code'],
								'errsyousai' => str_replace("&#039;", ' ', $this->viewVars['message'])
							);
			$this->Syslog->save($systemError);
			$this->redirect ( [
				'controller' => 'Top',
				'action' => 'index' ] );
		}
	}
	function beforeRender () {
		$deniedIPs = ConstantsComponent::$RESTRICT_IP_ADDR;
		// ビジターIP
		$visitorIP = $this->getUserIP();
		// このIPがブラックリストに登録されているかどうかを検索しましょう。
		$status = array_search($visitorIP, $deniedIPs);
		// $statusの値が真か偽かを確認してみましょう。
		if($status !== false) {
			$this->layout = false;
			echo '
				<!doctype html>
				<html lang="ja">
					<head>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<title>悪用でエラー</title>
					<link rel="stylesheet" type="text/css" href="'.$this->base.'/app/webroot/css/admin/normalize.css?1613714081"/><link rel="stylesheet" type="text/css" href="'.$this->base.'/app/webroot/css/admin/main.css?1613714081"/></head>
					<body>
					<!-- ========== header ========== -->
					<header>
						<h1 class="login-logo"><img src="'.$this->base.'/app/webroot/img/admin/logo-login.png?1613714091" alt="ニアショアIT協会 一般社団法人ニアショアＩＴ協会"/></h1>
					</header>
					<!-- ========== /header ========== -->
					<!-- ========== main ========== -->
					<section class="login-main">
						<div class="container">
							<main>
								<div class="login-box">
									<h2>悪用でエラー</h2>
									<p class="login-txt">悪用でエラーが発生しました。<br>
										<div class="fnt15 displayBlock" style="vertical-align: top;margin-left:7px;">※</div>
										<div class="fnt15 displayBlock txtAlign-left" style="margin-bottom: 30px;">このサイトをアクセスすることができません。<br>それ以外の操作でエラーとなった場合、管理者へ連絡してください。</div>
									</p>
								</div><!-- /.login-box -->
							</main>
						</div><!-- /.container -->
					</section>
					<!-- ========== /main ========== -->

					<!-- ========== footer ========== -->
					<footer>
						<div class="container footer-container">
						<a class="footer-copyright" href="https://www.hts-act.com/" target="_blank">
							<p>Copyright &copy; 2017 Hts Act Co.,Ltd. All rights reserved.</p>
						</a>
					</div><!-- /.footer-container --></footer>
					<!-- ========== /footer ========== -->
					</body>
				</html>';exit();
		}
		$this->_setErrorLayout();
	}
	public function beforeFilter() {
		Security::setHash('md5');
	}
	// 訪問者のIPを取得する関数。
	function getUserIP() {
		// 共有インターネットからIPを確認します。
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		// プロキシからIPを確認します。
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}
