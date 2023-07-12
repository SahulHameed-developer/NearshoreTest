<?php

App::uses ( 'FormAuthenticate', 'Controller/Component/Auth' );

class KaiinAuthenticate extends FormAuthenticate {
	
	/**
	 * authenticate フォーム
	 * @param CakeRequest $request
	 * @param CakeResponse $response
	 * @return string|NULL
	 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		
		// ユーザー名
		$username = $request->data ['lgid'];
		// パスワード
		$password = $request->data ['lgpass'];
		
		App::import ('Model', 'TKaiin');
		
		$TKaiinModel = new TKaiin ();
		
		$user = $TKaiinModel->find('all', array(
				'fields' => array(
						'TKaiin.kaiincd', 			// 会員コード
						'TKaiin.kanrikbn',			// 管理者区分
						'TKaiin.lgid',				// ログインID
						'TKaiin.kaiinnm',			// ログインID
						'TKaiin.sosikicd',			// 所属組織コード
						'TKaiin.kkanjikbn'),		// 倶楽部幹事区分
				'conditions' => array(
						'TKaiin.lgid' => $username,
						'TKaiin.lgpass'=> $password,
						'(TKaiin.taikaidate IS NULL OR TKaiin.taikaidate = "0000-00-00")')));
		
		if(!empty($user)){
			return $user[0];
		}
		return null;
	}
};