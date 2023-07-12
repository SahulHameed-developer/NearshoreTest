<?php

App::uses ( 'FormAuthenticate', 'Controller/Component/Auth' );

class KaisyaAuthenticate extends FormAuthenticate {
	
	/**
	 * authenticate フォーム
	 * @param CakeRequest $request
	 * @param CakeResponse $response
	 * @return string|NULL
	 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		
		// ユーザー名
		$mailaddress = $request->data ['mailaddress'];

		App::import ('Model', 'TKaisya');
		
		$TKaishaModel = new TKaisya();
		
		$user = $TKaishaModel->find('all', array(
				'joins' => array( 
					array(
						'table' => sprintf("(SELECT * FROM t_kaiin WHERE t_kaiin.taikaidate IS NULL OR t_kaiin.taikaidate = '0000-00-00' GROUP BY kaisyacd)"),
						'alias' => 'TKaiin',
						'type' => 'RIGHT',
						'conditions' => array('TKaiin.kaisyacd = TKaisya.kaisyacd')),
					array(
						'table' => 't_prkeiyaku',
						'alias' => 'TPrkeiyaku',
						'type' => 'RIGHT',
						'conditions' => array('TPrkeiyaku.kaisyacd = TKaisya.kaisyacd',
											'TPrkeiyaku.g_keiyaku_from <= CURDATE()',
											'TPrkeiyaku.g_keiyaku_to >= CURDATE()' ))),
				'fields' => array('TKaisya.kaisyacd',
								'TKaisya.kaisyanm'),
				'conditions' => array('OR' => array(
							array('TKaisya.prmailaddr1 ' => $mailaddress),
							array('TKaisya.prmailaddr2 ' => $mailaddress),
							array('TKaisya.prmailaddr3 ' => $mailaddress)))
				));
		
		if(!empty($user)){
			return $user[0];
		}
		return null;
	}
};