<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('vendor', 'captcha/Captcha');
App::import('vendor', 'captcha/captchaImageSource');
/**
 * 活動カレンダーのController
 *
 * 活動カレンダー情報を表示するControllerです。【画面分類：公開】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class ActivityController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Flash', 'Common', 'Session');
	// components追加
	public $components = array('Flash', 'Session', 'RequestHandler', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MSosiki', 'MKbunrui', 'TKatudo', 'TKaiin', 'TKaisya', 'TSyasin', 'TKaigiev', 'MTuuci','TEntry','MKurabu');
	/**
	 *　画面名：活動カレンダー一覧
	 *　機能名：初期表示
	 */
	public function index() {
		// 会議種別名称のセット
		$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
		// イベント種別名称のセット
		$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
		// 活動情報 テーブルから検索

		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiincd']) && !empty($_SESSION['Auth']['User']['TKaiin']['kaiincd'])) {
			$TEntry_join = array('table' => $this->TEntry,
								'alias' => 'TEntry',
								'type' => 'LEFT',
								'conditions' => array(
										'TEntry.kkey = TKatudo.arno',
										'TEntry.kaiincd =' => $_SESSION['Auth']['User']['TKaiin']['kaiincd']));
			$katoinfo_field = array('TKatudo.*',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.torikesidt');
		} else {
			$TEntry_join = "";
			$katoinfo_field = array('TKatudo.*');
		}
		$this->set('katoinfo', $this->TKatudo->find('all', array(
							'joins' => array($TEntry_join),
							'fields' => $katoinfo_field,
							'conditions'=> array(
									'TKatudo.kaisaidate >=' => $this->Common->getSystemDate(),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
							'order'=> array(
									'TKatudo.kaisaidate' => 'ASC',
									'TKatudo.kaisaitmfrom' => 'ASC'))));
		// 会議を探すの初期表示
		$this->set('selectedSosikinm', '');
		// イベントを探すの初期表示
		$this->set('selectedKbunruinm', '');
		$this->set('srchtyp', '');
		$this->set('scroll_val', '');
		// 画面の移動
		$this->render('Event/index');
	}
	/**
	 *　画面名：活動カレンダー一覧
	 *　機能名：検索処理
	 */
	public function search() {
		if(isset($this->request->data['frmClub']['kurabucd'])) {
			$this->request->data['shosaiModoruFrm']['kbunruinm'] = $this->request->data['frmClub']['kurabucd'];
		}
		if(isset($this->request->data['frmCommittee']['iinkaicd'])) {
			$this->request->data['MSosiki']['sosikinm'] = $this->request->data['frmCommittee']['iinkaicd'];
			$this->request->data['kaigibtn'] = "";
		}
		if(isset($this->request->data['shosaiModoruFrm']['scroll_val'])) {
			$this->set('scroll_val', $this->request->data['shosaiModoruFrm']['scroll_val']);
		} else {
			$this->set('scroll_val', '');
		}
		if(isset($this->request->data['srchtyp'])) {
			$this->set('srchtyp', $this->request->data['srchtyp']);
			$srchtyp = $this->request->data['srchtyp'];
		} else {
			$srchtyp = 0;
			$this->set('srchtyp', '');
		}
		// 会議種別名称のセット
		$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
		// イベント種別名称のセット
		$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
		if(isset($_SESSION['Auth']['User']['TKaiin']['kaiincd']) && !empty($_SESSION['Auth']['User']['TKaiin']['kaiincd'])) {
			$TEntry_join = array('table' => $this->TEntry,
								'alias' => 'TEntry',
								'type' => 'LEFT',
								'conditions' => array(
										'TEntry.kkey = TKatudo.arno',
										'TEntry.kaiincd =' => $_SESSION['Auth']['User']['TKaiin']['kaiincd']));
			$katoinfo_field = array('TKatudo.*',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.torikesidt');
		} else {
			$TEntry_join = "";
			$katoinfo_field = array('TKatudo.*');
		}
		// 会議を探すクリックの場合
		if (array_key_exists('kaigibtn', $this->request->data) || !empty($this->request->data['shosaiModoruFrm']['sosikinm']) || $srchtyp == 1) {
			// 活動情報 テーブルから検索
			$sosikinm = "";
			if (!empty($this->request->data['MSosiki']['sosikinm'])) {
				$sosikinm = $this->request->data['MSosiki']['sosikinm'];
			} else if (!empty($this->request->data['shosaiModoruFrm']['sosikinm'])) {
				$sosikinm = $this->request->data['shosaiModoruFrm']['sosikinm'];
			}
			if (!empty($sosikinm)) {

				if(!isset($this->request->data['frmCommittee']['iinkaicd'])) {
					$conditions[]  = array (
						'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
						'TKatudo.sosikicd ' => $sosikinm,
					);
				} else {
					$conditions[] = array('AND' => array(
						            array('MKurabu.kurabucd IS NULL'),
						            array('TKatudo.sosikicd ' => $sosikinm),
						        ));
				}
				$conditions[]  = array (
					'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(),
					'TKatudo.koukaikbn ' => $this->Constants->KOKAI
				);

				$query = $this->TKatudo->find('all', array(
						'joins' => array( array(
								'table' => $this->MKurabu,
								'alias' => 'MKurabu',
								'type' => 'LEFT',
								'conditions' => array(
										'MKurabu.kurabucd = TKatudo.kbunruicd')), $TEntry_join),
						'fields' => $katoinfo_field,
						'conditions' => $conditions,
						'order'=>array (
								'TKatudo.kaisaidate' => 'ASC',
								'TKatudo.kaisaitmfrom' => 'ASC')));
				$this->set('katoinfo', $query);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $sosikinm);
			} else {
				$this->set('katoinfo', $this->TKatudo->find('all' ,array(
						'conditions'=>array (
								'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
								'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'joins' => array($TEntry_join),
						'fields' => $katoinfo_field,
						'order'=>array (
								'TKatudo.kaisaidate' => 'ASC',
								'TKatudo.kaisaitmfrom' => 'ASC'))));
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', '');
			}
			$this->set('selectedKbunruinm', '');
			// イベントを探すクリックの場合
		} else if ((array_key_exists('eventbtn', $this->request->data))  || !empty($this->request->data['shosaiModoruFrm']['kbunruinm']) || $srchtyp == 2 ) {
			$kbunruicd = "";
			if (! empty($this->request->data['shosaiModoruFrm']['kbunruinm'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all', array(
						'joins' => array($TEntry_join),
						'fields' => $katoinfo_field,
						'conditions' => array (
								'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
								'TKatudo.kbunruicd' => $this->request->data['shosaiModoruFrm']['kbunruinm'] ,
								'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'ASC',
								'TKatudo.kaisaitmfrom' => 'ASC'))));

				//会議を探すの初期表示
				$this->set('selectedSosikinm', '');
				$this->set('selectedKbunruinm', $this->request->data['shosaiModoruFrm']['kbunruinm']);
			} else if (!empty($this->request->data['MSosiki']['kbunruinm'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all', array(
						'joins' => array($TEntry_join),
						'fields' => $katoinfo_field,
						'conditions' => array (
								'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
								'TKatudo.kbunruicd' => $this->request->data['MSosiki']['kbunruinm'] ,
								'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'ASC',
								'TKatudo.kaisaitmfrom' => 'ASC'))));
				//会議を探すの初期表示
				$this->set('selectedSosikinm', '');
				$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
			} else {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all', array(
						'joins' => array($TEntry_join),
						'fields' => $katoinfo_field,
						'conditions' => array (
								'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
								'TKatudo.kaisaidate >=' =>$this->Common->getSystemDate(),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'ASC',
								'TKatudo.kaisaitmfrom' => 'ASC'))));
				$this->set('selectedSosikinm', '');
				$this->set('selectedKbunruinm', '');
			}
		} else {
			// 活動情報 テーブルから検索
			$this->set('katoinfo', $this->TKatudo->find('all', array(
							'joins' => array($TEntry_join),
							'fields' => $katoinfo_field,
							'conditions'=> array(
									'TKatudo.kaisaidate >=' => $this->Common->getSystemDate(),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
							'order'=> array(
									'TKatudo.kaisaidate' => 'ASC',
									'TKatudo.kaisaitmfrom' => 'ASC'))));
			// 会議を探すの初期表示
			$this->set('selectedSosikinm', '');
			// イベントを探すの初期表示
			$this->set('selectedKbunruinm', '');
		}
		//　画面の移動
		$this->render('Event/index');
	}
	/**
	 *　画面名：活動カレンダー一覧
	 *　機能名：詳細情報表示
	 */
	public function detail() {
		if(!$this->Session->read('errorMsg.errorflag')){
			// セッションメッセージを削除
			$this->Session->delete('errorMsg');
			$this->Session->delete('errorMsgs');
		}
		$this->Session->write("errorMsg.errorflag",false);
		// 要求データが空白かどうか、とチェックする。要求データ空白ではないの場合、以下の処理が動作する。
		if (!empty($this->request->data) || !empty($this->Session->read('errorMsg.shosaiShutokuFrm'))) {
			if(isset($this->request->data['shosaiShutokuFrm']['b_top'])) {
				$this->set('b_top', $this->request->data['shosaiShutokuFrm']['b_top']);
			} else {
				$this->set('b_top', '');
			}
			if(isset($this->request->data['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			if(isset($this->request->data['srchtp'])) {
				$this->set('srchtyp', $this->request->data['srchtp']);
			} else {
				$this->set('srchtyp', '');
			}
			if (!empty($this->Session->read('errorMsg.shosaiShutokuFrm'))) {
				$this->request->data['shosaiShutokuFrm'] = $this->Session->read('errorMsg.shosaiShutokuFrm');
			}
			if(!empty($this->request->data['shosaiShutokuFrm'])) {
				// ページで表示するため、データを設定する。
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=>$this->request->data['shosaiShutokuFrm']['arno']
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.mousikomidt',
								'TEntry.kaiincd',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')
					));
				$this->set('applicants', $applicants);
					$event = $this->TKatudo->find('first', array(
							'joins' => array( array(
									'table' => $this->TKaigiev,
									'alias' => 'kaigiev',
									'type' => 'LEFT',
									'conditions' => array(
											'kaigiev.bunruicd = TKatudo.bunruicd',
											'kaigiev.sosikicd = TKatudo.sosikicd',
											'kaigiev.kbunruicd = TKatudo.kbunruicd',
										))),
							'fields' => array(
									'TKatudo.*',
									'kaigiev.kaisyanm',	// 会社名称
									'kaigiev.simei',
									'kaigiev.mailaddr',
									'kaigiev.bikou'),
							'conditions'=>array (
								'TKatudo.arno ' => $this->request->data['shosaiShutokuFrm']['arno'])));
				$this->set('event_shousai', $event);
				// ページで条件を使うため、研修会の値を設定する。
				$this->set('Kenshukai', $this->Constants->KENSHUKAI);
				// ページで条件を使うため、見学会の値を設定する。
				$this->set('kengakukai', $this->Constants->KENGAKUKAI);
				// ページで条件を使うため、講演会の値を設定する。
				$this->set('kouenkai', $this->Constants->KOUENKAI);
				// ページで条件を使うため、人材育成塾の値を設定する。
				$this->set('jinzaiikusei', $this->Constants->JINZAIIKUSEI);
				// ページで条件を使うため、交流イベントの値を設定する。
				$this->set('kouryuuibento', $this->Constants->KOURYUUIBENTO);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $this->request->data['shosaiShutokuFrm']['sosikinm']);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $this->request->data ['shosaiShutokuFrm']['kbunruinm']);
				// captchaImageDataに保存されたキャプチャ画像データ
				$this->request->data['captchaImageData'] = captchaImage();
				// 画面の移動。
				$this->render('Event/detail');
			} else {
				$event['TKatudo'] = $this->request->data;
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=>$this->request->data['hdn_arno']
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')
					));
				$this->set('applicants', $applicants);
				$this->set('event_shousai', $event);
				// ページで条件を使うため、研修会の値を設定する。
				$this->set('Kenshukai', $this->Constants->KENSHUKAI);
				// ページで条件を使うため、見学会の値を設定する。
				$this->set('kengakukai', $this->Constants->KENGAKUKAI);
				// ページで条件を使うため、講演会の値を設定する。
				$this->set('kouenkai', $this->Constants->KOUENKAI);
				// ページで条件を使うため、人材育成塾の値を設定する。
				$this->set('jinzaiikusei', $this->Constants->JINZAIIKUSEI);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', '');
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', '');
				// ページで条件を使うため、交流イベントの値を設定する。
				$this->set('kouryuuibento', $this->Constants->KOURYUUIBENTO);
				// 戻るボタンを隠すためpreviewで値をセットする。
				$this->set('previewadmin', $event);
				//　画面の移動
				$this->render('Event/detail');
			}
			
		} else {
			// 要求が空白の場合、コントローラの動作をリダイレクトする。
			$this->redirect([
					'controller' => 'activity',
					'action' => 'index'
			]);
		}
	}
	/**
	 *　画面名：活動カレンダー一覧
	 *　機能名：会議詳細情報表示
	 */
	public function Kaigidetail() {
		if(!$this->Session->read('errorMsg.errorflag')){
			// セッションメッセージを削除
			$this->Session->delete('errorMsg');
			$this->Session->delete('errorMsgs');
		}
		$this->Session->write("errorMsg.errorflag",false);
		if (!empty($this->request->data) || !empty($this->Session->read('errorMsg.shosaiShutokuFrm'))) {
			if(isset($this->request->data['shosaiKaigiFrm']['b_top'])) {
				$this->set('b_top', $this->request->data['shosaiKaigiFrm']['b_top']);
			} else if(isset($this->request->data['shosaiShutokuFrm']['b_top'])) {
				$this->set('b_top', $this->request->data['shosaiKaigiFrmArno']['b_top']);
			} else {
				$this->set('b_top', '');
			}
			if(isset($this->request->data['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			if(isset($this->request->data['srchtp'])) {
				$this->set('srchtyp', $this->request->data['srchtp']);
			} else {
				$this->set('srchtyp', '');
			}
			if (!empty($this->Session->read('errorMsg.shosaiShutokuFrm'))) {
				$this->request->data['shosaiShutokuFrm'] = $this->Session->read('errorMsg.shosaiShutokuFrm');
			}
			$arno = 0;
			if(!empty($this->request->data['shosaiKaigiFrm']) || !empty($this->request->data['shosaiShutokuFrm'])) {
				$selectedSosikinm = "";
				$selectedKbunruinm = "";
				if(isset($this->request->data['shosaiKaigiFrm']['arno'])) {
					$arno = $this->request->data['shosaiKaigiFrm']['arno'];
				} else if(isset($this->request->data['shosaiShutokuFrm']['arno'])) {
					$arno = $this->request->data['shosaiShutokuFrm']['arno'];
					$selectedSosikinm = $this->request->data['shosaiShutokuFrm']['sosikinm'];
					$selectedKbunruinm = $this->request->data ['shosaiShutokuFrm']['kbunruinm'];
				} 
				// ページで表示するため、データを設定する。
				$event = $this->TKatudo->find('first', array(
							'joins' => array( array(
									'table' => $this->TKaigiev,
									'alias' => 'kaigiev',
									'type' => 'LEFT',
									'conditions' => array(
										'kaigiev.bunruicd = TKatudo.bunruicd',
										'kaigiev.sosikicd = TKatudo.sosikicd',
										'kaigiev.kbunruicd = TKatudo.kbunruicd',
									))),
							'fields' => array(
									'TKatudo.*',
									'kaigiev.kaisyanm',	// 会社名称
									'kaigiev.simei',
									'kaigiev.mailaddr',
									'kaigiev.bikou'),
							'conditions'=>array (
									'TKatudo.arno ' => $arno)));
				$this->set('event_shousai', $event);

				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $selectedSosikinm);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $selectedKbunruinm);

				// ページで表示するため、データを設定する。
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=> $arno
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')));
				$this->set('applicants', $applicants);

				// captchaImageDataに保存されたキャプチャ画像データ
				$this->request->data['captchaImageData'] = captchaImage();
				// 画面の移動。
				$this->render('Kaigi/detail');
			} else if (isset($this->request->data['previewflg']) && $this->request->data['previewflg'] == "1") {
				if (isset($this->request->data['hdn_arno'])) {
					$arno = $this->request->data['hdn_arno'];
				}
				$event['TKatudo'] = $this->request->data;
				$this->set('event_shousai', $event);

				if($arno != 0) {
				// ページで表示するため、データを設定する。
					$conditions[] = array('AND' => array(
						          		'TEntry.kkey'=> $arno
						      		));
					$conditions[] = array('OR' => array(
						          	 	array('TEntry.torikesidt' => NULL),
						          		array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						       		));
					$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')));
				$this->set('applicants', $applicants);
			} else {
				$this->set('applicants', '');
			}
			

			// 会議を探すの初期表示
			$this->set('selectedSosikinm', '');
			// イベントを探すの初期表示
			$this->set('selectedKbunruinm', '');

			// previewで値をセットする。
			$this->set('previewadmin', $arno);

			// 画面の移動。
			$this->render('Kaigi/detail');
			} else {
				// 要求が空白の場合、コントローラの動作をリダイレクトする。
				$this->redirect([
						'controller' => 'activity',
						'action' => 'index'
				]);
			}
		}
	}
	/**
	 * ReportのreportIndex 活動報告の初期表示
	 *
	 */
	public function reportIndex() {
		// 会議種別名称のセット
		$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
		// イベント種別名称のセット
		$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
		$this->set('kaigiKaisaiList', $this->loadKaisaiDate(ConstantsComponent::$KAIGI_CD));
		$this->set('eventKaisaiList', $this->loadKaisaiDate(ConstantsComponent::$EVENT_CD));
		// 会議を探すの初期表示
		$this->set('selectedSosikinm', '');
		$this->set('selectedkaigiFrom', '');
		$this->set('selectedkaigiTo', '');
		// イベントを探すの初期表示
		$this->set('selectedKbunruinm', '');
		$this->set('selectedeventFrom', '');
		$this->set('selectedeventTo', '');
		$this->set('scroll_val', '');
		$this->set('srchtyp', '');
		// 活動情報 テーブルから検索
		$this->set('katoinfo', $this->TKatudo->find('all', array(
				'conditions'=>array(
							'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
							'TKatudo.kaisaidate BETWEEN ? and ?' => array(
																$this->Common->twoYearBeforeDate(), 
																$this->Common->getYesterdayDate()) ),
				'order'=>array(
						'TKatudo.kaisaidate' => 'DESC',
						'TKatudo.kaisaitmfrom' => 'DESC'))));
		// 画面の移動
		$this->render('Report/index');
	}
	/**
	 * ReportのreportSearch 活動報告の検索表示
	 *
	 */
	public function reportSearch() {
		if(isset($this->request->data['MSosiki']['scroll_val'])) {
			$this->set('scroll_val', $this->request->data['MSosiki']['scroll_val']);
		} else {
			$this->set('scroll_val', '');
		}
		if(isset($this->request->data['srchtyp'])) {
			$this->set('srchtyp', $this->request->data['srchtyp']);
			$srchtyp = $this->request->data['srchtyp'];
		} else {
			$srchtyp = 0;
			$this->set('srchtyp', '');
		}
		if(isset($this->request->data['frmClub']['kurabucd'])) {
			$this->request->data['MSosiki']['kbunruinm'] = $this->request->data['frmClub']['kurabucd'];
		}
		if(isset($this->request->data['frmCommittee']['iinkaicd'])) {
			$this->request->data['MSosiki']['sosikinm'] = $this->request->data['frmCommittee']['iinkaicd'];
		}
		// 会議種別名称のセット
		$this->set('sosikinm', $this->Common->getKaigiShubetsuName($this->MSosiki));
		// イベント種別名称のセット
		$this->set('kbunruinm', $this->Common->getEventShubetsuName($this->MKbunrui));
		// 会議開催日の年月セット
		$this->set('kaigiKaisaiList', $this->loadKaisaiDate(ConstantsComponent::$KAIGI_CD));
		// イベント開催日の年月セット
		$this->set('eventKaisaiList', $this->loadKaisaiDate(ConstantsComponent::$EVENT_CD));
		// 会議を探すの初期表示
		$this->set('selectedSosikinm', '');
		$this->set('selectedkaigiFrom', '');
		$this->set('selectedkaigiTo', '');		
		// イベントを探すの初期表示
		$this->set('selectedKbunruinm', '');
		$this->set('selectedeventFrom', '');
		$this->set('selectedeventTo', '');
		// 会議を探すクリックの場合
		if (array_key_exists('kaigibtn', $this->request->data) || (!empty($this->request->data['MSosiki']['sosikinm'])
				|| !empty($this->request->data['MSosiki']['kaigiFrom']) || !empty($this->request->data['MSosiki']['kaigiTo'])) || $srchtyp == 1) {
			
			if (!empty($this->request->data['MSosiki']['sosikinm']) && !empty($this->request->data['MSosiki']['kaigiFrom']) 
				&& !empty($this->request->data['MSosiki']['kaigiTo'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all' ,array(
						'conditions'=>array (
								'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
								'TKatudo.sosikicd ' => $this->request->data['MSosiki']['sosikinm'],
								array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																						$this->Common->twoYearBeforeDate(), 
																						$this->Common->getYesterdayDate())),
									array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
														$this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiFrom'])), 
														$this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiTo']))))
								),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC'))));
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $this->request->data['MSosiki']['sosikinm']);
				$this->set('selectedkaigiFrom', $this->request->data['MSosiki']['kaigiFrom']);
				$this->set('selectedkaigiTo', $this->request->data['MSosiki']['kaigiTo']);
			} else if (!empty($this->request->data['MSosiki']['sosikinm']) && empty($this->request->data['MSosiki']['kaigiFrom']) 
				&& empty($this->request->data['MSosiki']['kaigiTo'])) {
				if(!isset($this->request->data['frmCommittee']['iinkaicd'])) {
					$conditions[]  = array (
						'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
						'TKatudo.sosikicd ' => $this->request->data['MSosiki']['sosikinm'],
					);
				} else {
					$conditions[] = array('AND' => array(
						            array('MKurabu.kurabucd IS NULL'),
						            array('TKatudo.sosikicd ' => $this->request->data['MSosiki']['sosikinm']),
						        ));
				}
				$conditions[]  = array (
								'TKatudo.kaisaidate BETWEEN ? and ?' => array(
																	$this->Common->twoYearBeforeDate(), 
																	$this->Common->getYesterdayDate()),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI);

				// 活動情報 テーブルから検索
				// $this->set('katoinfo', $this->TKatudo->find('all' ,array(
				// 		'conditions'=> $conditions,
				// 		'order'=>array (
				// 				'TKatudo.kaisaidate' => 'DESC',
				// 				'TKatudo.kaisaitmfrom' => 'DESC'))));

				$query = $this->TKatudo->find('all', array(
						'joins' => array( array(
								'table' => $this->MKurabu,
								'alias' => 'MKurabu',
								'type' => 'LEFT',
								'conditions' => array(
										'MKurabu.kurabucd = TKatudo.kbunruicd'))),
						'fields' => array(
								'TKatudo.*'),
						'conditions' => $conditions,
						'order'=>array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC')));
				$this->set('katoinfo', $query);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $this->request->data['MSosiki']['sosikinm']);
			} else if(!empty($this->request->data['MSosiki']['kaigiFrom']) && !empty($this->request->data['MSosiki']['kaigiTo'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all', array(
						'conditions' => array (
								array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																						$this->Common->twoYearBeforeDate(), 
																						$this->Common->getYesterdayDate())),
									array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
										$this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiFrom'])), 
										$this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiTo']))))
								),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
								'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD),
						'order' => array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC'))));
				$this->set('selectedkaigiFrom', $this->request->data['MSosiki']['kaigiFrom']);
				$this->set('selectedkaigiTo', $this->request->data['MSosiki']['kaigiTo']);
			} else if (!empty($this->request->data['MSosiki']['kaigiFrom'])) {
				// 活動情報 テーブルから検索
				if (!empty($this->request->data['MSosiki']['sosikinm'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate >=' => $this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiFrom'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.sosikicd ' => $this->request->data['MSosiki']['sosikinm'],
									'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedkaigiFrom', $this->request->data['MSosiki']['kaigiFrom']);
					$this->set('selectedSosikinm', $this->request->data['MSosiki']['sosikinm']);
				} else {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate >=' => $this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiFrom'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedkaigiFrom', $this->request->data['MSosiki']['kaigiFrom']);
				}
			} else {
				if (!empty($this->request->data['MSosiki']['sosikinm'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate <=' => $this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiTo'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.sosikicd ' => $this->request->data['MSosiki']['sosikinm'],
									'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedkaigiTo', $this->request->data['MSosiki']['kaigiTo']);
					$this->set('selectedSosikinm', $this->request->data['MSosiki']['sosikinm']);
				} else if (!empty($this->request->data['MSosiki']['kaigiTo'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate <=' => $this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['kaigiTo'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedkaigiTo', $this->request->data['MSosiki']['kaigiTo']);
				} else {
					// 活動情報 テーブルから検索
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array ('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																					$this->Common->twoYearBeforeDate(), 
																					$this->Common->getYesterdayDate()),
									'TKatudo.bunruicd ' => ConstantsComponent::$KAIGI_CD,
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
				}
			}
		// イベントを探すクリックの場合
		} else if ((array_key_exists('eventbtn', $this->request->data)) || (!empty($this->request->data['MSosiki']['kbunruinm'])
			|| !empty($this->request->data['MSosiki']['eventFrom']) || !empty($this->request->data['MSosiki']['eventTo'])) || $srchtyp == 2) {

			if (!empty($this->request->data['MSosiki']['kbunruinm']) && !empty($this->request->data['MSosiki']['eventFrom']) 
				&& !empty($this->request->data['MSosiki']['eventTo'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all' ,array(
						'conditions'=>array (
								'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD,
								'TKatudo.kbunruicd ' => $this->request->data['MSosiki']['kbunruinm'],
								array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																						$this->Common->twoYearBeforeDate(), 
																						$this->Common->getYesterdayDate())),
									array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
													$this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['eventFrom'])), 
													$this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['eventTo']))))
								),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC'))));
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
				$this->set('selectedeventFrom', $this->request->data['MSosiki']['eventFrom']);
				$this->set('selectedeventTo', $this->request->data['MSosiki']['eventTo']);
			} else if (!empty($this->request->data['MSosiki']['kbunruinm']) && empty($this->request->data['MSosiki']['eventFrom'])
				&& empty($this->request->data['MSosiki']['eventTo'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all' ,array(
						'conditions'=>array (
								'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD,
								'TKatudo.kbunruicd ' => $this->request->data['MSosiki']['kbunruinm'],
								'TKatudo.kaisaidate BETWEEN ? and ?' => array(
																	$this->Common->twoYearBeforeDate(), 
																	$this->Common->getYesterdayDate()),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
						'order'=>array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC'))));
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
			} else if(!empty($this->request->data['MSosiki']['eventFrom']) && !empty($this->request->data['MSosiki']['eventTo'])) {
				// 活動情報 テーブルから検索
				$this->set('katoinfo', $this->TKatudo->find('all', array(
						'conditions' => array (
								array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																						$this->Common->twoYearBeforeDate(), 
																						$this->Common->getYesterdayDate())),
									array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
												$this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['eventFrom'])), 
												$this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['eventTo']))))
								),
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
								'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD),
						'order' => array (
								'TKatudo.kaisaidate' => 'DESC',
								'TKatudo.kaisaitmfrom' => 'DESC'))));
				$this->set('selectedeventFrom', $this->request->data['MSosiki']['eventFrom']);
				$this->set('selectedeventTo', $this->request->data['MSosiki']['eventTo']);
			} else if (!empty($this->request->data['MSosiki']['eventFrom'])) {
				// 活動情報 テーブルから検索
				if (!empty($this->request->data['MSosiki']['kbunruinm'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate >=' => $this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['eventFrom'])))
									),
									'TKatudo.kbunruicd ' => $this->request->data['MSosiki']['kbunruinm'],
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedeventFrom', $this->request->data['MSosiki']['eventFrom']);
					$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
				} else {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate >=' => $this->Common->fromDate(str_replace('/','-',$this->request->data['MSosiki']['eventFrom'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedeventFrom', $this->request->data['MSosiki']['eventFrom']);
				}
			} else {
				if (!empty($this->request->data['MSosiki']['kbunruinm'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate <=' => $this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['eventTo'])))
									),
									'TKatudo.kbunruicd ' => $this->request->data['MSosiki']['kbunruinm'],
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedKbunruinm', $this->request->data['MSosiki']['kbunruinm']);
					$this->set('selectedeventTo', $this->request->data['MSosiki']['eventTo']);
				} else if (!empty($this->request->data['MSosiki']['eventTo'])) {
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array (
									array('AND' => array('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																							$this->Common->twoYearBeforeDate(), 
																							$this->Common->getYesterdayDate())),
										array('TKatudo.kaisaidate <=' => $this->Common->toDate(str_replace('/','-',$this->request->data['MSosiki']['eventTo'])))
									),
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
									'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
					$this->set('selectedeventTo', $this->request->data['MSosiki']['eventTo']);
				} else {
					// 活動情報 テーブルから検索
					$this->set('katoinfo', $this->TKatudo->find('all', array(
							'conditions' => array ('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																					$this->Common->twoYearBeforeDate(), 
																					$this->Common->getYesterdayDate()),
									'TKatudo.bunruicd ' => ConstantsComponent::$EVENT_CD,
									'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
							'order' => array (
									'TKatudo.kaisaidate' => 'DESC',
									'TKatudo.kaisaitmfrom' => 'DESC'))));
				}
			}
		} else {
			// 活動情報 テーブルから検索
			$this->set('katoinfo', $this->TKatudo->find('all', array(
					'conditions' => array ('TKatudo.kaisaidate BETWEEN ? and ?' => array(
																			$this->Common->twoYearBeforeDate(), 
																			$this->Common->getYesterdayDate()),
							'TKatudo.koukaikbn ' => $this->Constants->KOKAI),
					'order' => array (
							'TKatudo.kaisaidate' => 'DESC',
							'TKatudo.kaisaitmfrom' => 'DESC'))));
		}
		//　画面の移動
		$this->render('Report/index');
	}
	/**
	 * ReportのreportDetail 活動報告の詳細処理
	 *
	 */
	public function reportDetail() {
		// 要求データが空白かどうか、とチェックする。要求データ空白ではないの場合、以下の処理が動作する。
		if (!empty($this->request->data)) {
			if (!empty($this->request->data['shosaiJouhouFrm'])) {
				// ページで表示するため、データを設定する。
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=>$this->request->data['shosaiJouhouFrm']['arno']
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')
					));
				$this->set('applicants', $applicants);
				$event = $this->TKatudo->find('first' ,array(
						'conditions'=>array (
								'TKatudo.arno ' => $this->request->data['shosaiJouhouFrm']['arno'],
								'TKatudo.koukaikbn ' => $this->Constants->KOKAI)));
				$syasin_title = $this->TSyasin->find('all',
						array('conditions' => array('TSyasin.syasinkey' => $event['TKatudo']['syasinkey'],
													'TSyasin.bunrui' => $this->Constants->KATUDO)));
				$this->set('syasinInfo', $syasin_title);
				$this->set('event_shousai', $event);
				// ページで条件を使うため、研修会の値を設定する。
				$this->set('Kenshukai', $this->Constants->KENSHUKAI);
				// ページで条件を使うため、見学会の値を設定する。
				$this->set('kengakukai', $this->Constants->KENGAKUKAI);
				// ページで条件を使うため、講演会の値を設定する。
				$this->set('kouenkai', $this->Constants->KOUENKAI);
				// ページで条件を使うため、交流イベントの値を設定する。
				$this->set('kouryuuibento', $this->Constants->KOURYUUIBENTO);
				// ページで条件を使うため、人材育成塾の値を設定する。
				$this->set('jinzaiikusei', $this->Constants->JINZAIIKUSEI);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $this->request->data['shosaiJouhouFrm']['sosikinm']);
				$this->set('selectedkaigiFrom', $this->request->data['shosaiJouhouFrm']['kaigiFrom']);
				$this->set('selectedkaigiTo', $this->request->data['shosaiJouhouFrm']['kaigiTo']);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $this->request->data ['shosaiJouhouFrm']['kbunruinm']);
				$this->set('selectedeventFrom', $this->request->data['shosaiJouhouFrm']['eventFrom']);
				$this->set('selectedeventTo', $this->request->data['shosaiJouhouFrm']['eventTo']);
				$this->set('image1','');
				$this->set('image2','');
				$this->set('image3','');
				if(isset($this->request->data['scroll_val'])) {
					$this->set('scroll_val', $this->request->data['scroll_val']);
				} else {
					$this->set('scroll_val', '');
				}
				if(isset($this->request->data['srchtp'])) {
					$this->set('srchtyp', $this->request->data['srchtp']);
				} else {
					$this->set('srchtyp', '');
				}
				// 画面の移動。
				$this->render('Report/detail');
			} else {
				$event['TKatudo'] = $this->request->data;
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=> $this->request->data['id']
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')
					));
				$this->set('applicants', $applicants);
				$this->set('event_shousai', $event);
				$syasin1 = '';
				$syasin2 = '';
				$syasin3 = '';
				if (count ( $_FILES ) > 0) {
					if (isset($_FILES ['syasin1'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin1'] ['tmp_name'] )) {
							$syasin1 = fread ( fopen ( $_FILES ['syasin1'] ['tmp_name'], "r" ), $_FILES ['syasin1'] ['size']);
						}
					}
					if (isset($_FILES ['syasin2'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin2'] ['tmp_name'] )) {
							$syasin2 = fread ( fopen ( $_FILES ['syasin2'] ['tmp_name'], "r" ), $_FILES ['syasin2'] ['size'] );
						}
					}
					if (isset($_FILES ['syasin3'] ['tmp_name'])) {
						if (is_uploaded_file ( $_FILES ['syasin3'] ['tmp_name'] )) {
							$syasin3 = fread ( fopen ( $_FILES ['syasin3'] ['tmp_name'], "r" ), $_FILES ['syasin3'] ['size']);
						}
					}
					// 写真をセットする。
					$previewInfo['syasin1']=$syasin1;
					$previewInfo['syasin2']=$syasin2;
					$previewInfo['syasin3']=$syasin3;
					$this->set('previewInfo', $previewInfo);
					$this->Session->write("Auth.User.News.previewInfo",$previewInfo);
				}
				$this->set('syasinInfo', '');
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', '');
				$this->set('selectedkaigiFrom', '');
				$this->set('selectedkaigiTo', '');
				$this->set('image1',$this->request->data['image1']);
				$this->set('image2',$this->request->data['image2']);
				$this->set('image3',$this->request->data['image3']);
				// ページで条件を使うため、研修会の値を設定する。
				$this->set('Kenshukai', $this->Constants->KENSHUKAI);
				// ページで条件を使うため、見学会の値を設定する。
				$this->set('kengakukai', $this->Constants->KENGAKUKAI);
				// ページで条件を使うため、講演会の値を設定する。
				$this->set('kouenkai', $this->Constants->KOUENKAI);
				// ページで条件を使うため、交流イベントの値を設定する。
				$this->set('kouryuuibento', $this->Constants->KOURYUUIBENTO);
				// ページで条件を使うため、人材育成塾の値を設定する。
				$this->set('jinzaiikusei', $this->Constants->JINZAIIKUSEI);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', '');
				$this->set('selectedeventFrom', '');
				$this->set('selectedeventTo', '');
				// 戻るボタンを隠すためpreviewで値をセットする。
				$this->set('previewadmin', $event);
				if(isset($this->request->data['scroll_val'])) {
					$this->set('scroll_val', $this->request->data['scroll_val']);
				} else {
					$this->set('scroll_val', '');
				}
				if(isset($this->request->data['srchtp'])) {
					$this->set('srchtyp', $this->request->data['srchtp']);
				} else {
					$this->set('srchtyp', '');
				}
				// 画面の移動
				$this->render('Report/detail');
			}
		} else {
			// 要求が空白の場合、コントローラの動作をリダイレクトする。
			$this->redirect([
					'controller' => 'activity',
					'action' => 'reportIndex'
			]);
		}
	}
	/**
	 * Aboutのindex 初期表示
	 *
	 */
	public function about() {
		// 画面の移動
		$this->render('About/index');
	}
	public function gotoentry() {
		$this->redirect([
				'controller' => 'activity',
				'action' => 'entry'
		]);
	}
	/**
	 * Entryのindex 初期表示
	 *
	 */
	public function entry() {
		if($this->Session->check('previousPageInfo')) {
			$this->Session->delete('previousPageInfo');
		}
		// 戻るセット
		$this->set('buttonSel', 'modoru');
		if(!$this->Session->read('errorMsg.errorflag')){
			// セッションメッセージを削除
			$this->Session->delete('errorMsg');
			$this->Session->delete('errorMsgs');
			$this->set('buttonSel', '');
		}
		$this->set('kaiincd', '');
		$this->set('kaiinkbnmem', $this->Constants->KAIIN); // 会員
		$this->Session->write("errorMsg.errorflag",false);
		$this->set('kaiin_val', $this->Constants->KAIIN_VAL);
		$this->set('hikaiin_val', $this->Constants->HIKAIIN_VAL);
		if(!empty($this->request->data) || !empty($this->Session->read('errorMsg.arno'))) {
			// 戻るの場合
			if (array_key_exists('back_button', $this->request->data)) {
				// フォームの値セット
				$this->set([
						'hyoudai' => $this->request->data['modoruFrm']['hyoudai'],
						'meisyou' => $this->request->data['modoruFrm']['meisyou'],
						'kaisaidate' => $this->request->data['modoruFrm']['kaisaidate'],
						'kaisaitmfrom' => $this->request->data['modoruFrm']['kaisaitmfrom'],
						'kaisaitmto' => $this->request->data['modoruFrm']['kaisaitmto'],
						'taisyoukbn' => $this->request->data['modoruFrm']['taisyoukbn'],
						'bunruicd' => $this->request->data['modoruFrm']['bunruicd'],
						'sosikicd' => $this->request->data['modoruFrm']['sosikicd'],
						'kbunruicd' => $this->request->data['modoruFrm']['kbunruicd'],
						'kaiinKbn'=>$this->request->data['modoruFrm']['kaiinKbn'],
						'kaisyanm' => $this->request->data['modoruFrm']['kaisyanm'],
						'kaiinnm' => $this->request->data['modoruFrm']['simei'],
						'mailaddr'=> $this->request->data['modoruFrm']['mailaddr'],
						'arno'=> $this->request->data['modoruFrm']['arno'],
						'kaiinkbnmem'=> $this->request->data['modoruFrm']['kaiinkbnmem'],
						'kaiincd'=> $this->request->data['modoruFrm']['kaiincd'],
						'confirmVal'=> 'enable'
				]);
				if(!empty($this->request->data['modoruFrm']['bikou'])) {
					$this->set('bikou', $this->request->data['modoruFrm']['bikou']);
				} else {
					$this->set('bikou', '');
				}
				$this->set('buttonSel', 'modoru');
			} else {
				if(!empty($this->Session->read('errorMsg.arno'))) {
					$arnoVal = $this->Session->read('errorMsg.arno');
					$kaiinKbnVal=$this->Session->read('errorMsg.kaiinKbn');
				} else {
					$arnoVal = $this->request->data['moshiKomiFrm']['arno'];
					$kaiinKbnVal=$this->Constants->KAIIN;
				}
				$katudodata = $this->TKatudo->find('first' ,array(
						'fields'=>array(
								'TKatudo.bunruicd',
								'TKatudo.sosikicd',
								'TKatudo.kbunruicd',
								'TKatudo.kaisaidate',
								'TKatudo.kaisaitmfrom',
								'TKatudo.kaisaitmto',
								'TKatudo.hyoudai',
								'TKatudo.meisyou',
								'TKatudo.taisyoukbn',
								'TKatudo.hyoudai',
								'TKatudo.meisyou'),
						'conditions'=>array (
								'TKatudo.arno' => $arnoVal,
								'TKatudo.koukaikbn' => $this->Constants->KOKAI)));
				// フォームの値セット
				if(!empty($this->Session->read('errorMsg.arno'))) {
					$this->set([
							'hyoudai' => $katudodata['TKatudo']['hyoudai'],
							'meisyou' =>  $katudodata['TKatudo']['meisyou'],
							'kaisaidate' => $katudodata['TKatudo']['kaisaidate'],
							'kaisaitmfrom' => $katudodata['TKatudo']['kaisaitmfrom'],
							'kaisaitmto' => $katudodata['TKatudo']['kaisaitmto'],
							'taisyoukbn' =>  $katudodata['TKatudo']['taisyoukbn'],
							'bunruicd' => $katudodata['TKatudo']['bunruicd'],
							'sosikicd' => $katudodata['TKatudo']['sosikicd'],
							'kbunruicd' => $katudodata['TKatudo']['kbunruicd'],
							'arno'=> $arnoVal,
							'kaiinKbn'=>$kaiinKbnVal,
							'kaisyanm' => $this->Session->read('errorMsg.kaisyanms'),
							'kaiinnm' => $this->Session->read('errorMsg.simeis'),
							'mailaddr'=> $this->Session->read('errorMsg.mailaddrs'),
							'bikou'=> $this->Session->read('errorMsg.bikou'),
							'kaiincd'=> $this->Session->read('errorMsg.kaiincd'),
							'confirmVal'=> 'enable'
					]);
					$this->Session->delete('kaisyanms');
					$this->Session->delete('simeis');
					$this->Session->delete('mailaddrs');
					$this->Session->delete('bikou');
					$this->Session->delete('kaiinKbn');
				} else {
					$this->set([
							'hyoudai' => $katudodata['TKatudo']['hyoudai'],
							'meisyou' =>  $katudodata['TKatudo']['meisyou'],
							'kaisaidate' => $katudodata['TKatudo']['kaisaidate'],
							'kaisaitmfrom' => $katudodata['TKatudo']['kaisaitmfrom'],
							'kaisaitmto' => $katudodata['TKatudo']['kaisaitmto'],
							'taisyoukbn' =>  $katudodata['TKatudo']['taisyoukbn'],
							'bunruicd' => $katudodata['TKatudo']['bunruicd'],
							'sosikicd' => $katudodata['TKatudo']['sosikicd'],
							'kbunruicd' => $katudodata['TKatudo']['kbunruicd'],
							'arno'=> $arnoVal,
							'kaiinKbn'=>$kaiinKbnVal,
							'kaisyanm' => '',
							'kaiinnm' => '',
							'mailaddr'=> '',
							'bikou'=> '',
							'confirmVal'=> 'disable'
					]);
				}
			}
			$this->request->data['captchaImageData'] = captchaImage();
		} else {
			$this->redirect([
					'controller' => 'activity',
					'action' => 'index'
			]);
		}
		// 画面の移動
		$this->render('Entry/index');
	}
	/**
	 * Entryのconfirm 初期表示
	 *
	 */
	public function confirm() {
		$this->set('kaiinkbnmem', $this->request->data['kaigiEvent']['kaiinkbnmem']);
		// セッションフラグを削除
		$this->Session->delete('Message.flash');
		if (!empty($this->request->data)) {
			// システム日付
			$systemDateTime=$this->Common->getSystemDateTime();
			$columnValue = $this->request->data['kaigiEvent'];
			// 項目の値セット
			if (!array_key_exists('kaiinMailbtn', $this->request->data)) {
				if (!empty($this->request->data['free_radio'])) {
					if($this->request->data['free_radio'] == $this->Constants->HIKAIIN_VAL) {
						$columnValue['kaiinKbn'] =  $this->Constants->HIKAIIN;
						$columnValue['kaisyanm'] =  $this->request->data['kaisyanm'];
						$columnValue['simei'] =  $this->request->data['kaiinnm'];
						$columnValue['mailaddr'] =  $this->request->data['emailAddr'];
						$columnValue['bikou'] =  $this->request->data['bikou'];
					} else if($this->request->data['free_radio'] == $this->Constants->KAIIN_VAL) {
						$columnValue['kaiinKbn'] =  $this->Constants->KAIIN;
						$columnValue['kaisyanm'] =  $this->request->data['kaisyanm'];
						$columnValue['simei'] =  $this->request->data['kaiinnm'];
						$columnValue['mailaddr'] =  $this->request->data['mailaddr'];
						$columnValue['bikou'] =  $this->request->data['bikou'];
					} else {
						$columnValue['kaiinKbn'] =  $this->Constants->KAIIN;
						$columnValue['kaisyanm'] =  $this->request->data['kaigiEvent']['kaisyanm'];
						$columnValue['simei'] =  $this->request->data['kaigiEvent']['kaiinnm'];
						$columnValue['mailaddr'] =  $this->request->data['mailaddr'];
						$columnValue['bikou'] =  $this->request->data['bikou'];
					}
				} else {
					$columnValue['kaiinKbn'] =  $this->request->data['kaigiEvent']['taisyoukbn'];
					$columnValue['kaisyanm'] =  $this->request->data['kaisyanm'];
					$columnValue['simei'] =  $this->request->data['kaiinnm'];
					$columnValue['mailaddr'] =  $this->request->data['mailaddr'];
					$columnValue['bikou'] =  $this->request->data['bikou'];
				}
			}
			$columnValue['captchaCode'] =  $this->request->data['captchaCode'];
			$columnValue['tourokucd'] =  $this->Constants->SYSTEM;
			$columnValue['tourokudt'] =  $systemDateTime;
			$responseString = "";
			$responseString = $this->textarea_maxlength("bikou",$columnValue['bikou'],1024,$responseString);
			$this->TKaigiev->set($columnValue);
			// TKaigievにキャプチャコードバリデーションルールを追加します
			$validator = $this->TKaigiev->validator();
			$validator['captchaCode'] =  array(
											'notBlank' => array(
													'rule' => 'notBlank',
													'required' => true,
													'message' => "キャプチャが未入力です。"
											),
											'checkCaptcha' => array(
													'rule' => array('checkCaptcha'),
													'message' => '正しいキャプチャを入力してください。'
											));
			if ($this->TKaigiev->validates() && $responseString == "") {
				// 検索の場合
				if (array_key_exists('kaiinMailbtn', $this->request->data)) {
					// フォームの値セット
					$this->set([
							'hyoudai' => $this->request->data['kaigiEvent']['hyoudai'],
							'meisyou' => $this->request->data['kaigiEvent']['meisyou'],
							'kaisaidate' => $this->request->data['kaigiEvent']['kaisaidate'],
							'kaisaitmfrom' => $this->request->data['kaigiEvent']['kaisaitmfrom'],
							'kaisaitmto' => $this->request->data['kaigiEvent']['kaisaitmto'],
							'taisyoukbn' => $this->request->data['kaigiEvent']['taisyoukbn'],
							'bunruicd' => $this->request->data['kaigiEvent']['bunruicd'],
							'sosikicd' => $this->request->data['kaigiEvent']['sosikicd'],
							'kbunruicd' => $this->request->data['kaigiEvent']['kbunruicd'],
							'kaiinKbn'=>$this->request->data['kaigiEvent']['kaiinKbn'],
							'arno'=> $this->request->data['kaigiEvent']['arno'],
							'kaiinkbn'=> $this->request->data['kaigiEvent']['kaiinkbn'],
							'kaiincd'=> $this->request->data['kaigiEvent']['kaiincd'],
							'kaisyanm' => '',
							'kaiinnm' => '',
							'mailaddr'=> $this->request->data['mailaddr'],
							'bikou'=> $this->request->data['bikou'],
							'confirmVal'=> 'disable'
					]);
					// 会員情報と会社情報 テーブルから検索
					$query = $this->TKaisya->find('all', array(
							'joins' => array( array(
									'table' => $this->TKaiin,
									'alias' => 'tkn',
									'type' => 'INNER',
									'conditions' => array(
											'tkn.kaisyacd = TKaisya.kaisyacd'))),
							'fields' => array(
									'TKaisya.kaisyanm',	// 会社名称
									'tkn.kaiinnm'),
							'conditions' => array(
									'tkn.mailaddr' =>$this->request->data['mailaddr'])));
					$cntValue = count($query);
					if ($cntValue > 1) {
						$this->Session->setFlash("正しい会員メールアドレスを入力してください。");
					} else if ($cntValue == 0) {
						$this->Session->setFlash ("該当する会員メールアドレスが存在しません。");
					} else {
						foreach($query as $queryVal) {
							$this->set([
									'kaisyanm' => $queryVal['TKaisya']['kaisyanm'],
									'kaiinnm' => $queryVal['tkn']['kaiinnm'],
									'confirmVal' => 'enable'
							]);
							echo $ret_array = array('kaisyanm' => $queryVal['TKaisya']['kaisyanm'],
									'kaiinnm' => $queryVal['tkn']['kaiinnm'],
									'confirmVal' => 'enable');
						}
					}
					$return_val = $this->set('status', 'mailSearch');
					$this->set('buttonSel', '');
					// 画面の移動
					$this->render('Entry/index');
				} else {
					// フォームの値セット
					$this->set([
							'hyoudai' => $this->request->data['kaigiEvent']['hyoudai'],
							'meisyou' => $this->request->data['kaigiEvent']['meisyou'],
							'kaisaidate' => $this->request->data['kaigiEvent']['kaisaidate'],
							'kaisaitmfrom' => $this->request->data['kaigiEvent']['kaisaitmfrom'],
							'kaisaitmto' => $this->request->data['kaigiEvent']['kaisaitmto'],
							'taisyoukbn' => $this->request->data['kaigiEvent']['taisyoukbn'],
							'bunruicd' => $this->request->data['kaigiEvent']['bunruicd'],
							'sosikicd' => $this->request->data['kaigiEvent']['sosikicd'],
							'kbunruicd' => $this->request->data['kaigiEvent']['kbunruicd'],
							'arno'=> $this->request->data['kaigiEvent']['arno'],
							'kaiincd'=> $this->request->data['kaigiEvent']['kaiincd'],
							'bikou'=> $this->request->data['bikou']
					]);
					if (!empty($this->request->data['free_radio'])) {
						if ($this->request->data['free_radio'] == $this->Constants->HIKAIIN_VAL) {
							$this->set('kaisyanm', $this->request->data['kaisyanm']);
							$this->set('kaiinnm', $this->request->data['kaiinnm']);
							$this->set('kaiinKbn', $this->Constants->HIKAIIN);
							$this->set('emailAdd', $this->request->data['emailAddr']);
						} else {
							$this->set('kaisyanm', $this->request->data['kaisyanm']);
							$this->set('kaiinnm', $this->request->data['kaiinnm']);
							$this->set('kaiinKbn', $this->Constants->KAIIN);
							$this->set('emailAdd', $this->request->data['mailaddr']);
						}
					} else {
						$this->set('kaisyanm', $this->request->data['kaisyanm']);
						$this->set('kaiinnm', $this->request->data['kaiinnm']);
						$this->set('kaiinKbn', $this->request->data['kaigiEvent']['taisyoukbn']);
						$this->set('emailAdd', $this->request->data['mailaddr']);
					}
					$this->set('status', 'confirm');
					// 画面の移動
					$this->render('Entry/confirm');
				}
			} else {
				$errors = $this->TKaigiev->validationErrors;
				if ($responseString != "") {
					$errors = array_merge($errors, $responseString);
				}
				$this->Session->write("errorMsgs",$errors);
				$this->Session->write("errorMsg.errorflag",true);
				$this->Session->write("errorMsg.arno",$columnValue['arno']);
				$this->Session->write("errorMsg.kaiinKbn",$columnValue['kaiinKbn']);
				$this->Session->write("errorMsg.kaisyanms",$columnValue['kaisyanm']);
				$this->Session->write("errorMsg.mailaddrs",$columnValue['mailaddr']);
				$this->Session->write("errorMsg.bikou",$columnValue['bikou']);
				$this->Session->write("errorMsg.simeis",$columnValue['simei']);
				$this->Session->write("errorMsg.kaiincd",$this->request->data['kaigiEvent']['kaiincd']);
				$this->gotoentry();
			}
		} else {
			$this->gotoentry();
		}
	}
	/**
	 * 会議・イベント申込のメール送信処理
	 *
	 */
	public function sendmail() {
		try 
		{
			$db_TKaigiev = $this->TKaigiev->getDataSource();
			$db_TKaigiev->begin();
			$db_TEntry = $this->TEntry->getDataSource();
			$db_TEntry->begin();
			if (!empty($this->request->data)) {
				// フォームの値セット
				$this->set([
						'taisyoukbn' => $this->request->data['soshin']['taisyoukbn'],
						'hyoudai' => $this->request->data['soshin']['hyoudai'],
						'meisyou' => $this->request->data['soshin']['meisyou'],
						'kaisaidate' => $this->request->data['soshin']['kaisaidate'],
						'kaisaitmfrom' => $this->request->data['soshin']['kaisaitmfrom'],
						'kaisaitmto' => $this->request->data['soshin']['kaisaitmto'],
						'bunruicd' => $this->request->data['soshin']['bunruicd'],
						'sosikicd' => $this->request->data['soshin']['sosikicd'],
						'kbunruicd' => $this->request->data['soshin']['kbunruicd'],
						'arno'=> $this->request->data['soshin']['arnoVal'],
						'kaiincd'=> $this->request->data['soshin']['kaiincd'],
				]);
				// システム日付
				$systemDateTime=$this->Common->getSystemDateTime();
				// 項目の値セット
				$columnValue = $this->request->data['soshin'];
				$columnValue['kaiinkbn'] = $this->request->data['soshin']['kaiinKbn'];
				$columnValue['tourokucd'] =  $this->Constants->SYSTEM;
				$columnValue['tourokudt'] =  $systemDateTime;
				$responseString = "";
				$responseString = $this->textarea_maxlength("bikou",$columnValue['bikou'],1024,$responseString);
				$this->TKaigiev->set($columnValue);
				// TKaigievにキャプチャコードバリデーションルールを追加します
				$validator = $this->TKaigiev->validator();
				$validator['captchaCode'] = array(
												'notBlank' => array(
														'rule' => 'notBlank',
														'required' => true,
														'message' => "キャプチャが未入力です。"
												),
												'checkCaptcha' => array(
														'rule' => array('checkCaptcha'),
														'message' => '正しいキャプチャを入力してください。'
												));
				if ($this->TKaigiev->validates() && $responseString == "") {
					// 会議・イベント申込情報作成
					$this->TKaigiev->create();
					// 会議・イベント申込情報に登録
					$this->TKaigiev->save($columnValue);
					$TKaigiev_marno = $this->TKaigiev->getLastInsertId();
					// t_entryに挿入する
					$columnValue['kkey'] = $this->request->data['soshin']['arnoVal'];
					$columnValue['kaiinkbn'] = $this->request->data['soshin']['kaiinkbnmem']; // 　0：会員、1：非会員
					$columnValue['bunruicd'] = $this->request->data['soshin']['bunruicd'];
					$columnValue['mousikominm'] = $this->request->data['soshin']['simei'];
					$columnValue['marno'] = $TKaigiev_marno; //会議・イベント申込情報(T_KAIGIEV)を登録時の連番を設定
					if(isset($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'])) {
						$kaiincdsession = $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd'];
					} else {
						$kaiincdsession = "";
					}
					$columnValue['mousikomicd'] = $kaiincdsession;
					$columnValue['mousikomidt'] = $systemDateTime;
					$filedata = $this->TEntry->find ( 'first', array (
										'fields' => array('arno'),
										'conditions' => array ('kkey ' => $this->request->data['soshin']['arnoVal'], 
																'kaiincd ' => $this->request->data['soshin']['kaiincd'])
									));
					if(count($filedata)!=0 && $this->request->data['soshin']['kaiinkbnmem']!="1") {
						$db = $this->TEntry->getDataSource ();
						$columnValueup = array (
							'marno' => $db->value ($TKaigiev_marno),
							'mousikomidt' => $db->value ($systemDateTime),
							'torikesicd' => $db->value (''),
							'torikesidt' => $db->value (NULL)
						);
						$conditionsup = array (
								'kkey' => $this->request->data['soshin']['arnoVal'],
								'kaiincd' => $this->request->data['soshin']['kaiincd']
						);
						$this->TEntry->updateAll ( $columnValueup, $conditionsup );
					} else {
						$this->TEntry->create();
						$this->TEntry->save($columnValue);
					}
					
					$db_TKaigiev->commit();
					$db_TEntry->commit();

					//事務局へメール送信
					$mailInfo=$this->Common->getMailInfo($this->MTuuci);
					if (!empty($mailInfo)) {
						$filedata = $this->MKurabu->find ( 'first', array (
							'fields' => array('MKurabu.mailaddr'),
							'conditions' => array ('MKurabu.kurabucd ' => $this->request->data['soshin']['kbunruicd'])
						));
						$allmailaddrs = array();
						if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
						    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr1'];
						}
						if (!empty($mailInfo['0']['MTuuci']['mailaddr2'])) {
						    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr2'];
						}
						if (!empty($mailInfo['0']['MTuuci']['mailaddr3'])) {
						    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr3'];
						}
						// メール送信　（事務局宛）
						if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
							if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
								$subject_mail = '【会議出席連絡】' . $columnValue['hyoudai'];
							} else {
								$subject_mail = '【イベント申込】' . $columnValue['hyoudai'];
							}
							$msg_mail = $this->mailText($columnValue, $systemDateTime);
							$mail = new CakeEmail('smtp');
							$mail->from ($mailInfo['0']['MTuuci']['mailaddrsend']);
							$mail->to ($allmailaddrs);

							// CCのメールアドレス追加
							$ccMailAddrs = array();
							
							// 会議出席連絡場合
							if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
								$mailCC = $this->Common->getMailCCInfo($this->TKaiin, $columnValue['sosikicd']);
								if($mailCC != "") {
									$ccMailAddrs[] = $mailCC;
								}
							}

							if (!empty($filedata) && $filedata['MKurabu']['mailaddr']!="") {
								$ccMailAddrs[] = $filedata['MKurabu']['mailaddr'];
							}
							if(count($ccMailAddrs) > 0) {
								$mail->cc($ccMailAddrs);
							}

							// メール内容
							$mail->subject($subject_mail);
							$mail->emailFormat('html');
							$mail->send($msg_mail);
						}
						// 確認メール　（申込者宛　確認メール）
						if (!empty($columnValue['mailaddr'])) {
							if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
								$subject_kakuninMail = '【会議出席連絡受付】' . $columnValue['hyoudai'];
							} else {
								$subject_kakuninMail = '【イベント申込受付】' . $columnValue['hyoudai'];
							}
							$msg_kakuninMail = $this->kakuninMailText($columnValue, $systemDateTime);
							$kakuninMail = new CakeEmail('smtp');
							$kakuninMail->from($mailInfo ['0']['MTuuci']['mailaddrsend']);
							$kakuninMail->to($columnValue['mailaddr']);
							$kakuninMail->subject($subject_kakuninMail);
							$kakuninMail->emailFormat('html');
							$kakuninMail->send($msg_kakuninMail);
						}
					}
					$this->Session->delete('previousPageInfo');
					$this->Session->write("activity.arno",$this->request->data['soshin']['arnoVal']);
					$this->Session->write("activity.kaiinKbn",$this->request->data['soshin']['kaiinKbn']);
					$this->Session->write("activity.bunruicd", $this->request->data['soshin']['bunruicd']);
					$this->redirect([
							'controller' => 'activity',
							'action' => 'finish'
					]);
				} else {
					$errors = $this->TKaigiev->validationErrors;
					if ($responseString != "") {
						$errors = array_merge($errors, $responseString);
					}
					$this->Session->write("errorMsgs",$errors);
					$this->Session->write("errorMsg.errorflag",true);
					$this->Session->write("errorMsg.arno",$columnValue['arnoVal']);
					$this->Session->write("errorMsg.kaiinKbn",$columnValue['kaiinKbn']);
					$this->Session->write("errorMsg.kaisyanms",$columnValue['kaisyanm']);
					$this->Session->write("errorMsg.mailaddrs",$columnValue['mailaddr']);
					$this->Session->write("errorMsg.bikou",$columnValue['bikou']);
					$this->Session->write("errorMsg.simeis",$columnValue['simei']);
					$this->Session->write("errorMsg.kaiincd",$this->request->data['soshin']['kaiincd']);
					$this->gotoentry();
				}
				
			} else {
				$this->redirect([
						'controller' => 'activity',
						'action' => 'entry'
				]);
			}
		} catch (Exception $e) {
			$db_TKaigiev->rollback();
			$db_TEntry->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'ajaxRequestError' ] );
		}
	}
	/**
	 * 会議・イベント申込完了画面
	 *
	 */
	public function finish() {
		// 画面の移動
		$this->render('Entry/finish');
	}
	/**
	 *　会議の更新日付を取得する処理
	 */
	public function loadKaisaiDate($bunruicd) {
		$TKatudo = $this->TKatudo->find ( 'all', array (
				'fields' => array (
						'distinct SUBSTRING(TKatudo.kaisaidate, 1, 7) as content_short'
				),
				'conditions' => array(
						'TKatudo.bunruicd' => $bunruicd,
						'TKatudo.koukaikbn ' => $this->Constants->KOKAI,
						'TKatudo.kaisaidate BETWEEN ? and ?' => array(
															$this->Common->twoYearBeforeDate(), 
															$this->Common->getSystemDate())
				),
				'order' => array (
						'TKatudo.kaisaidate' => 'DESC'
				)
		));
		// 更新日付を追加
		$date = array();
		foreach ( $TKatudo as $row => $values ) {
			$temp = substr ( $values [0] ['content_short'], 0, 4 );
			$temp = $temp . "年" . substr ( $values [0] ['content_short'], 6, 7 ) . "月";
			$date [substr ( $values [0] ['content_short'], 0, 7 )] = $temp;
		}
		return $date;
	}
	/**
	 * 　画面名：お知らせ 編集
	 * 　機能名：写真情報の写真を取得
	 */
	public function getSyasin($syasinkey, $rno) {
		$pictImage = $this->TSyasin->find ( 'first', array (
				'conditions' => array (
						'TSyasin.rno ' => $rno,
						'TSyasin.syasinkey ' => $syasinkey,
						'TSyasin.bunrui' => $this->Constants->KATUDO
				)
		) );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $pictImage ['TSyasin'] ['syasin'] ) );
		echo $pictImage ['TSyasin'] ['syasin'];
	}
	/**
	 * 画面名：会議・イベント申込
	 * 機能名：メール送信１　（事務局宛）
	 * @param 引継ぎ情報  columnValue
	 * @param システム日時  systemDateTime
	 * @return string
	 */
	private function mailText($columnValue,$systemDateTime) {
		if ($columnValue['kaiinKbn']==$this->Constants->KAIIN) {
			$kaiinKbnVal = $this->Constants->KAIIN_VAL;
		} else {
			$kaiinKbnVal = $this->Constants->HIKAIIN_VAL;
		}
		$titleWidth = "style='vertical-align: top; text-align: center; width: 110px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> 関係者各位</p>\n";
		$message .= "\n";

		$bunruiNm = "";
		if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
			$message .= "<p>会議への出席連絡がありました。</p>\n";
			$bunruiNm = "会　　議　　名";
		} else {
			$message .= "<p>イベントへの申込がありました。</p>\n";
			$bunruiNm = "イ ベ ン ト 名";
		}

		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申　込　日　時</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>". $bunruiNm ."</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['hyoudai'].' '.$columnValue['meisyou']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　員　区　分</td><td $braceWidth>】</td>
						<td $maxwidth>".$kaiinKbnVal."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　　社　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['kaisyanm']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>氏　　　　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['simei']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>メールアドレス</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['mailaddr']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>備　　　　　考</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($columnValue['bikou'])."</td>
					</tr>";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご対応お願い致します。</p>";
		return $message;
	}

	private function mailTextcancel($columnValue,$systemDateTime) {
		if ($columnValue['kaiinKbn']==$this->Constants->KAIIN) {
			$kaiinKbnVal = $this->Constants->KAIIN_VAL;
		} else {
			$kaiinKbnVal = $this->Constants->HIKAIIN_VAL;
		}
		$titleWidth = "style='vertical-align: top; text-align: center; width: 110px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= "<p> 関係者各位</p>\n";
		$message .= "\n";

		$bunruiNm = "";
		if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
			$message .= "<p>会議への出席取消連絡がありました。</p>\n";
			$bunruiNm = "会　　議　　名";
		} else {
			$message .= "<p>イベントへの申込取消がありました。</p>\n";
			$bunruiNm = "イ ベ ン ト 名";
		}

		$message .= "\n";
		$message .= "<table style='width:100%'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>取　消　日　時</td><td $braceWidth>】</td>
						<td $maxwidth>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>". $bunruiNm ."</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['hyoudai'].' '.$columnValue['meisyou']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　員　区　分</td><td $braceWidth>】</td>
						<td $maxwidth>".$kaiinKbnVal."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>会　　社　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['kaisyanm']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>氏　　　　　名</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['simei']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>メールアドレス</td><td $braceWidth>】</td>
						<td $maxwidth>".$columnValue['mailaddr']."</td>
					</tr>";
		$message .= "</table>";
		$message .= "\n";
		$message .= "<p>ご対応お願い致します。</p>";
		return $message;
	}
	/**
	 * 画面名：会議・イベント申込
	 * 機能名：メール送信２　（申込者宛　確認メール）
	 * @param  引継ぎ情報 columnValue
	 * @param  システム日時  systemDateTime
	 * @return string
	 */
	private function kakuninMailText($columnValue,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 120px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= '<p>' .$columnValue['kaisyanm']. "</p>\n";
		$message .= '<p>' .$columnValue['simei'].'　'.'様'. "</p>\n";
		$message .= "\n";

		$bunruiNm = "";
		if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
			$message .= "<p>会議への出席連絡を承りました。</p>\n";
			$bunruiNm = "会　　議　　名";
		} else {
			$message .= "<p>イベントへの申込を承りました。</p>\n";
			$bunruiNm = "イ ベ ン ト 名";
		}

		$message .= "<table style='font-family: monospace;'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>申　込　日　時</td><td $braceWidth>】</td>
						<td>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>". $bunruiNm ."</td><td $braceWidth>】</td>
						<td>".$columnValue['hyoudai'].'　'.$columnValue['meisyou']."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>備　　　　　考</td><td $braceWidth>】</td>
						<td $maxwidth>".nl2br($columnValue['bikou'])."</td>
					</tr>";
		$message .= "</table>";
		$message .= "<p> -------------------------------------------------------------------------------------------------</p>";
		$message .= "<p>※このメールは送信専用のアドレスから配信しております。</p>\n";
		$message .= "<p>　ご返信頂きましてもお答えできませんので、予めご了承願います。</p>\n";
		return $message;
	}
	/**
	 * 画面名：会議・イベント申込
	 * 機能名：メール送信２　（申込者宛　確認メール）
	 * @param  引継ぎ情報 columnValue
	 * @param  システム日時  systemDateTime
	 * @return string
	 */
	private function kakuninMailTextcancel($columnValue,$systemDateTime) {
		$titleWidth = "style='vertical-align: top; text-align: center; width: 120px;'";
		$braceWidth = "style='vertical-align: top; width: 10px;'";
		$maxwidth = "style='max-width: 400px; word-break: break-all;'";
		$message="";
		$message .= '<p>' .$columnValue['kaisyanm']. "</p>\n";
		$message .= '<p>' .$columnValue['simei'].'　'.'様'. "</p>\n";
		$message .= "\n";

		$bunruiNm = "";
		if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
			$message .= "<p>会議への出席取消連絡がありました。</p>\n";
			$bunruiNm = "会　　議　　名";
		} else {
			$message .= "<p>イベントへの申込取消を承りました。</p>\n";
			$bunruiNm = "イ ベ ン ト 名";
		}

		$message .= "<table style='font-family: monospace;'>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>取　消　日　時</td><td $braceWidth>】</td>
						<td>".$this->Common->getJapDateTime($systemDateTime)."</td>
					</tr>";
		$message .= "<tr>
						<td $braceWidth>【</td><td $titleWidth>". $bunruiNm ."</td><td $braceWidth>】</td>
						<td>".$columnValue['hyoudai'].'　'.$columnValue['meisyou']."</td>
					</tr>";
		$message .= "</table>";
		$message .= "<p> -------------------------------------------------------------------------------------------------</p>";
		$message .= "<p>※このメールは送信専用のアドレスから配信しております。</p>\n";
		$message .= "<p>　ご返信頂きましてもお答えできませんので、予めご了承願います。</p>\n";
		return $message;
	}
	/**
	 * 　画面名：会員企業
	 * 　機能名：写真情報の写真を取得
	 */
	public function ViewSyasin($syasinName) {
		$previewInfo = $this->Session->read ( 'Auth.User.News.previewInfo' );
		$this->autoRender = false;
		header ( 'Content-type: image/jpeg' );
		header ( 'Content-length: ' . strlen ( $previewInfo [$syasinName] ) );
		echo $previewInfo [$syasinName];
	}
	/*
	 * 
	 */
	public function byAjaxCheck() {
		// イベント種別名称のセット
		// 会員情報と会社情報 テーブルから検索
		$data = $this->TKaisya->find('all', array(
				'joins' => array( array(
						'table' => $this->TKaiin,
						'alias' => 'tkn',
						'type' => 'INNER',
						'conditions' => array(
								'tkn.kaisyacd = TKaisya.kaisyacd'))),
				'fields' => array(
						'TKaisya.kaisyanm',	// 会社名称
						'tkn.kaiinnm',
						'tkn.kaiincd'),
				'conditions' => array(
						'tkn.mailaddr' =>$this->request->data['mailaddr'])));
		$responseArray = array();
		if (count($data) > 0) {
			$responseArray[0] = $data[0]['TKaisya']['kaisyanm'];
			$responseArray[1] = $data[0]['tkn']['kaiinnm'];
			$responseArray[2] = $data[0]['tkn']['kaiincd'];
		}
		echo json_encode($responseArray);exit();
	}
	private function textarea_maxlength ($fname,$dummy_str,$maxlen,$errors) {
		$dummy_str = str_replace("\r\n", "\n", $dummy_str);
		if(mb_strlen($dummy_str) > $maxlen) {
			$responseString[$fname][0] = "最大文字数を超えています。";
			if ($errors != "") {
				$responseString = array_merge($errors, $responseString);
			}
			return $responseString;
		} else {
			return $errors;
		}
	}

	// public function cancelFromIndex() {
	// 	try {
	// 		// TEntryにキャプチャコードバリデーションルールを追加します
	// 		$columnValue['captchaCode'] = $this->request->data['captchaCode'];
	// 		$this->TEntry->set($columnValue);
	// 		$validator = $this->TEntry->validator();
	// 		$validator['captchaCode'] =  array(
	// 										'notBlank' => array(
	// 												'rule' => 'notBlank',
	// 												'required' => true,
	// 												'message' => "キャプチャが未入力です。"
	// 										),
	// 										'checkCaptcha' => array(
	// 												'rule' => array('checkCaptcha'),
	// 												'message' => '正しいキャプチャを入力してください。'
	// 										));
	// 		if ($this->TEntry->validates()) {
	// 			$event = $this->TKatudo->find('first', array(
	// 					'joins' => array( array(
	// 							'table' => $this->TKaigiev,
	// 							'alias' => 'kaigiev',
	// 							'type' => 'LEFT',
	// 							'conditions' => array(
	// 									'kaigiev.bunruicd = TKatudo.bunruicd',
	// 									'kaigiev.sosikicd = TKatudo.sosikicd',
	// 									'kaigiev.kbunruicd = TKatudo.kbunruicd',
	// 								))),
	// 							'fields' => array(
	// 									'TKatudo.*',
	// 									'kaigiev.kaisyanm',	// 会社名称
	// 									'kaigiev.simei',
	// 									'kaigiev.mailaddr',
	// 									'kaigiev.kaiinKbn',
	// 									'kaigiev.bikou'),
	// 							'conditions'=>array (
	// 									'TKatudo.arno ' => $this->request->data['moshiKomitorikeshiFrm']['arno'])));

	// 			$this->request->data['moshiKomitorikeshiFrm']['hyoudai'] = $event['TKatudo']['hyoudai'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['kaiinKbn'] = $event['kaigiev']['kaiinKbn'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['meisyou'] = $event['TKatudo']['meisyou'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['kaisyanm'] = $event['kaigiev']['kaisyanm'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['simei'] = $event['kaigiev']['simei'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['mailaddr'] = $event['kaigiev']['mailaddr'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['bikou'] = $event['kaigiev']['bikou'];
	// 			$this->request->data['moshiKomitorikeshiFrm']['bunruicd'] = $event['TKatudo']['bunruicd'];
	// 			$this->cancel();
	// 		} else {
	// 			$errors = $this->TEntry->validationErrors;
	// 			$this->Session->write("errorMsgs",$errors);
	// 			$this->Session->write("errorMsg.errorflag",true);
	// 			$this->Session->write("errorMsg.arno",$this->request->data['moshiKomitorikeshiFrm']['arno']);
	// 			$this->Session->write("errorMsg.bunruicd",$this->request->data['moshiKomitorikeshiFrm']['bunruicd']);
	// 			$this->Session->write("errorMsg.sosikinm",$this->request->data['moshiKomitorikeshiFrm']['sosikinm']);
	// 			$this->Session->write("errorMsg.kbunruinm",$this->request->data['moshiKomitorikeshiFrm']['kbunruinm']);
	// 			// $this->cancelFromIndex();
	// 			$curtime = "?time=".date('dmYHis');
	// 			$this->redirect ( [
	// 				'controller' => 'activity',
	// 				'action' => 'cancelActivity'.$curtime ]  );
	// 		}
	// 	} catch (Exception $e) {
	// 		$Common = new CommonController;
	// 		$Common->systemError($e);
	// 		$this->redirect ( [
	// 				'controller' => 'Error',
	// 				'action' => 'systemError' ] );
	// 	}
	// }
	public function cancelActivity() {
		if(!$this->Session->read('errorMsg.errorflag')){
			// セッションメッセージを削除
			$this->Session->delete('errorMsg');
			$this->Session->delete('errorMsgs');
		}
		$this->Session->write("errorMsg.errorflag",false);
		if (!empty($this->request->data) || !empty($this->Session->read('errorMsg.arno'))) {
			if((isset($this->request->data['moshiKomitorikeshiFrm']['bunruicd']) && $this->request->data['moshiKomitorikeshiFrm']['bunruicd'] == 2) || $this->Session->read('errorMsg.bunruicd') == 2) {
			$arnoVal = 0;
			$selectedSosikinm = "";
			$selectedKbunruinm = "";
			if(!empty($this->Session->read('errorMsg.arno'))) {
				$arnoVal = $this->Session->read('errorMsg.arno');
				$selectedSosikinm = $this->Session->read('errorMsg.sosikinm');
				$selectedKbunruinm = $this->Session->read('errorMsg.kbunruinm');
			} else {
				$arnoVal = $this->request->data['moshiKomitorikeshiFrm']['arno'];
				$selectedSosikinm = $this->request->data['moshiKomitorikeshiFrm']['sosikinm'];
				$selectedKbunruinm = $this->request->data ['moshiKomitorikeshiFrm']['kbunruinm'];
			}
			if(isset($this->request->data['moshiKomitorikeshiFrm']['b_top'])) {
				$this->set('b_top', $this->request->data['moshiKomitorikeshiFrm']['b_top']);
			} else {
				$this->set('b_top', '');
			}
			if(isset($this->request->data['scroll_val'])) {
				$this->set('scroll_val', $this->request->data['scroll_val']);
			} else {
				$this->set('scroll_val', '');
			}
			if(isset($this->request->data['srchtp'])) {
				$this->set('srchtyp', $this->request->data['srchtp']);
			} else {
				$this->set('srchtyp', '');
			}
			// ページで表示するため、データを設定する。
			$conditions[] = array('AND' => array(
					           'TEntry.kkey'=>$arnoVal
					        ));
			$conditions[] = array('OR' => array(
					            array('TEntry.torikesidt' => NULL),
					            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
					        ));
			$applicants = $this->TEntry->find('all' ,array(
					'fields'=>array(
							'TEntry.kaiinkbn',
							'TEntry.mousikomidt',
							'TEntry.kaiincd',
							'TEntry.mousikominm'),
					'conditions'=>$conditions,
					'order'=> array('TEntry.mousikomidt' => 'ASC')
				));
			$this->set('applicants', $applicants);
				$event = $this->TKatudo->find('first', array(
						'joins' => array( array(
								'table' => $this->TKaigiev,
								'alias' => 'kaigiev',
								'type' => 'LEFT',
								'conditions' => array(
										'kaigiev.bunruicd = TKatudo.bunruicd',
										'kaigiev.sosikicd = TKatudo.sosikicd',
										'kaigiev.kbunruicd = TKatudo.kbunruicd',
									))),
						'fields' => array(
								'TKatudo.*',
								'kaigiev.kaisyanm',	// 会社名称
								'kaigiev.simei',
								'kaigiev.mailaddr',
								'kaigiev.kaiinKbn',
								'kaigiev.bikou'),
						'conditions'=>array (
							'TKatudo.arno ' => $arnoVal)));
				$this->set('event_shousai', $event);
				// ページで条件を使うため、研修会の値を設定する。
				$this->set('Kenshukai', $this->Constants->KENSHUKAI);
				// ページで条件を使うため、見学会の値を設定する。
				$this->set('kengakukai', $this->Constants->KENGAKUKAI);
				// ページで条件を使うため、講演会の値を設定する。
				$this->set('kouenkai', $this->Constants->KOUENKAI);
				// ページで条件を使うため、人材育成塾の値を設定する。
				$this->set('jinzaiikusei', $this->Constants->JINZAIIKUSEI);
				// ページで条件を使うため、交流イベントの値を設定する。
				$this->set('kouryuuibento', $this->Constants->KOURYUUIBENTO);
				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $selectedSosikinm);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $selectedKbunruinm);
				// captchaImageDataに保存されたキャプチャ画像データ
				$this->request->data['captchaImageData'] = captchaImage();
				// 画面の移動。
				$this->render('Event/cancel');
			} else {
				if(isset($this->request->data['moshiKomitorikeshiFrm']['b_top'])) {
					$this->set('b_top', $this->request->data['moshiKomitorikeshiFrm']['b_top']);
				} else {
					$this->set('b_top', '');
				}
				if(isset($this->request->data['scroll_val'])) {
					$this->set('scroll_val', $this->request->data['scroll_val']);
				} else {
					$this->set('scroll_val', '');
				}
				if(isset($this->request->data['srchtp'])) {
					$this->set('srchtyp', $this->request->data['srchtp']);
				} else {
					$this->set('srchtyp', '');
				}
				$arnoVal = 0;
				$selectedSosikinm = "";
				$selectedKbunruinm = "";
				if(!empty($this->Session->read('errorMsg.arno'))) {
					$arnoVal = $this->Session->read('errorMsg.arno');
					$selectedSosikinm = $this->Session->read('errorMsg.sosikinm');
					$selectedKbunruinm = $this->Session->read('errorMsg.kbunruinm');
				} else {
					$arnoVal = $this->request->data['moshiKomitorikeshiFrm']['arno'];
					$selectedSosikinm = $this->request->data['moshiKomitorikeshiFrm']['sosikinm'];
					$selectedKbunruinm = $this->request->data ['moshiKomitorikeshiFrm']['kbunruinm'];
				}
				// ページで表示するため、データを設定する。
				$event = $this->TKatudo->find('first', array(
							'joins' => array( array(
									'table' => $this->TKaigiev,
									'alias' => 'kaigiev',
									'type' => 'LEFT',
									'conditions' => array(
										'kaigiev.bunruicd = TKatudo.bunruicd',
										'kaigiev.sosikicd = TKatudo.sosikicd',
										'kaigiev.kbunruicd = TKatudo.kbunruicd',
									))),
							'fields' => array(
									'TKatudo.*',
									'kaigiev.kaisyanm',	// 会社名称
									'kaigiev.simei',
									'kaigiev.mailaddr',
									'kaigiev.bikou'),
							'conditions'=>array (
									'TKatudo.arno ' => $arnoVal)));
				$this->set('event_shousai', $event);

				// 会議を探すの初期表示
				$this->set('selectedSosikinm', $selectedSosikinm);
				// イベントを探すの初期表示
				$this->set('selectedKbunruinm', $selectedKbunruinm);

				// ページで表示するため、データを設定する。
				$conditions[] = array('AND' => array(
						           'TEntry.kkey'=> $arnoVal
						        ));
				$conditions[] = array('OR' => array(
						            array('TEntry.torikesidt' => NULL),
						            array('TEntry.torikesidt' => "0000-00-00 00:00:00"),
						        ));
				$applicants = $this->TEntry->find('all' ,array(
						'fields'=>array(
								'TEntry.kaiinkbn',
								'TEntry.kaiincd',
								'TEntry.mousikomidt',
								'TEntry.mousikominm'),
						'conditions'=>$conditions,
						'order'=> array('TEntry.mousikomidt' => 'ASC')));
				$this->set('applicants', $applicants);
				// captchaImageDataに保存されたキャプチャ画像データ
				$this->request->data['captchaImageData'] = captchaImage();
				// 画面の移動。
				$this->render('Kaigi/cancel');
			}
		} else {
			$curtime = "?time=".date('dmYHis');
			$this->redirect ( [ 
					'controller' => 'activity',
					'action' => 'index'.$curtime
			]);
		}
	}

	public function cancel() {
		try {
			// TEntryにキャプチャコードバリデーションルールを追加します
			$columnValue['captchaCode'] = $this->request->data['captchaCode'];
			$this->TEntry->set($columnValue);
			$validator = $this->TEntry->validator();
			$validator['captchaCode'] =  array(
											'notBlank' => array(
													'rule' => 'notBlank',
													'required' => true,
													'message' => "キャプチャが未入力です。"
											),
											'checkCaptcha' => array(
													'rule' => array('checkCaptcha'),
													'message' => '正しいキャプチャを入力してください。'
											));
			if ($this->TEntry->validates()) {
				$db_TEntry = $this->TEntry->getDataSource();
				$db_TEntry->begin();
				$mailContent = $this->TKaiin->find('first', array(
								'joins' => array( array(
										'table' => $this->TKaisya,
										'alias' => 'TKaisya',
										'type' => 'LEFT',
										'conditions' => array('TKaisya.kaisyacd = TKaiin.kaisyacd'))),
										'fields' => array(
											'TKaiin.kaiinnm',
											'TKaiin.mailaddr',
											'TKaisya.kaisyanm'),
										'conditions'=>array (
											'TKaiin.kaiincd ' => $_SESSION['Auth']['User']['TKaiin']['kaiincd'])));
				$systemDateTime=$this->Common->getSystemDateTime();
				$db = $this->TEntry->getDataSource ();
				$columnValue = array (
					'hyoudai' => $this->request->data['moshiKomitorikeshiFrm']['hyoudai'],
					'kaiinKbn' => $this->request->data['moshiKomitorikeshiFrm']['kaiinKbn'],
					'meisyou' => $this->request->data['moshiKomitorikeshiFrm']['meisyou'],
					'bunruicd' => $this->request->data['moshiKomitorikeshiFrm']['bunruicd'],
					'kaisyanm' => $mailContent['TKaisya']['kaisyanm'],
					'simei' => $mailContent['TKaiin']['kaiinnm'],
					'mailaddr' => $mailContent['TKaiin']['mailaddr'],
					'bikou' => $this->request->data['moshiKomitorikeshiFrm']['bikou'],
					'torikesicd' => $db->value ($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']),
					'torikesidt' => $db->value ($systemDateTime)
				);
				$columnValuecan = array (
					'torikesicd' => $db->value ($_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']),
					'torikesidt' => $db->value ($systemDateTime)
				);
				$conditions = array (
						'kkey' => $this->request->data['moshiKomitorikeshiFrm']['arno'],
						'kaiincd' => $_SESSION ['Auth'] ['User'] ['TKaiin'] ['kaiincd']
						
				);
				// ファイル情報に登録
				if (!$this->TEntry->updateAll ( $columnValuecan, $conditions )) {
					throw new Exception();
				}
				$db_TEntry->commit();
				$mailInfo=$this->Common->getMailInfo($this->MTuuci);
				if (!empty($mailInfo)) {
					$kurabuMailaddr = $this->TKatudo->find('first', array(
										'joins' => array( array(
											'table' => $this->MKurabu,
											'alias' => 'MKurabu',
											'type' => 'LEFT',
											'conditions' => array('MKurabu.kurabucd = TKatudo.kbunruicd'))),
										'fields' => array('MKurabu.mailaddr'),
										'conditions'=>array ('TKatudo.arno ' => $this->request->data['moshiKomitorikeshiFrm']['arno'])));
					$allmailaddrs = array();
					if (!empty($mailInfo['0']['MTuuci']['mailaddr1'])) {
					    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr1'];
					}
					if (!empty($mailInfo['0']['MTuuci']['mailaddr2'])) {
					    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr2'];
					}
					if (!empty($mailInfo['0']['MTuuci']['mailaddr3'])) {
					    $allmailaddrs[] = $mailInfo['0']['MTuuci']['mailaddr3'];
					}
					// メール送信　（事務局宛）
					if (!empty($mailInfo['0']['MTuuci']['mailaddr1']) || !empty($mailInfo['0']['MTuuci']['mailaddr2']) || !empty($mailInfo['0']['MTuuci']['mailaddr3']) ) {
						if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
							$subject_mail = '【会議出席取消連絡】' . $columnValue['hyoudai'];
						} else {
							$subject_mail = '【イベント申込取消】' . $columnValue['hyoudai'];
						}
						$msg_mail = $this->mailTextcancel($columnValue, $systemDateTime);
						$mail = new CakeEmail('smtp');
						$mail->from ($mailInfo['0']['MTuuci']['mailaddrsend']);
						$mail->to ($allmailaddrs);

						// CCのメールアドレス追加
						$ccMailAddrs = array();
							
						// 会議出席連絡場合
						if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {

							$sosikicd = $this->TKatudo->find('first', array(
											'fields' => array('TKatudo.sosikicd'),
											'conditions'=>array ('TKatudo.arno ' => $this->request->data['moshiKomitorikeshiFrm']['arno'])));
							$mailCC = $this->Common->getMailCCInfo($this->TKaiin, $sosikicd['TKatudo']['sosikicd']);
							if($mailCC != "") {
								$ccMailAddrs[] = $mailCC;
							}
						}
						if (!empty($kurabuMailaddr) && $kurabuMailaddr['MKurabu']['mailaddr']!="") {
							$ccMailAddrs[] = $kurabuMailaddr['MKurabu']['mailaddr'];
						}
						if(count($ccMailAddrs) > 0) {
								$mail->cc($ccMailAddrs);
						}

						// メール内容
						$mail->subject($subject_mail);
						$mail->emailFormat('html');
						$mail->send($msg_mail);
					}
					// 確認メール　（申込者宛　確認メール）
					if (!empty($columnValue['mailaddr'])) {
						if($columnValue['bunruicd'] == ConstantsComponent::$KAIGI_CD) {
							$subject_kakuninMail = '【会議出席取消連絡受付】' . $columnValue['hyoudai'];
						} else {
							$subject_kakuninMail = '【イベント申込取消受付】' . $columnValue['hyoudai'];
						}
						$msg_kakuninMail = $this->kakuninMailTextcancel($columnValue, $systemDateTime);
						$kakuninMail = new CakeEmail('smtp');
						$kakuninMail->from($mailInfo ['0']['MTuuci']['mailaddrsend']);
						$kakuninMail->to($columnValue['mailaddr']);
						$kakuninMail->subject($subject_kakuninMail);
						$kakuninMail->emailFormat('html');
						$kakuninMail->send($msg_kakuninMail);
					}
				}
			} else {
				$errors = $this->TEntry->validationErrors;
				$this->Session->write("errorMsgs",$errors);
				$this->Session->write("errorMsg.errorflag",true);
				// $this->cancelFromIndex();
				$curtime = "?time=".date('dmYHis');
				if(isset($this->request->data['moshiKomitorikeshiFrm']['screenName']) && $this->request->data['moshiKomitorikeshiFrm']['screenName'] == "event") {
					$this->Session->write("errorMsg.shosaiShutokuFrm",$this->request->data['moshiKomitorikeshiFrm']);

					$this->redirect ( [
						'controller' => 'activity',
						'action' => 'detail'.$curtime ] );
				} else if (isset($this->request->data['moshiKomitorikeshiFrm']['screenName']) && $this->request->data['moshiKomitorikeshiFrm']['screenName'] == "kaigi") {
					$this->Session->write("errorMsg.shosaiShutokuFrm",$this->request->data['moshiKomitorikeshiFrm']);

					$this->redirect ( [
						'controller' => 'activity',
						'action' => 'Kaigidetail'.$curtime ] );
				} else {
					$this->Session->write("errorMsg.arno",$this->request->data['moshiKomitorikeshiFrm']['arno']);
					$this->Session->write("errorMsg.bunruicd",$this->request->data['moshiKomitorikeshiFrm']['bunruicd']);
					$this->Session->write("errorMsg.sosikinm",$this->request->data['moshiKomitorikeshiFrm']['sosikinm']);
					$this->Session->write("errorMsg.kbunruinm",$this->request->data['moshiKomitorikeshiFrm']['kbunruinm']);

					$this->redirect ( [
						'controller' => 'activity',
						'action' => 'cancelActivity'.$curtime ] );
				}
			}
		} catch (Exception $e) {
			$db_TEntry->rollback();
			$Common = new CommonController;
			$Common->systemError($e);
			$this->redirect ( [
					'controller' => 'Error',
					'action' => 'systemError' ] );
		}
		$curtime = "?time=".date('dmYHis');
		$this->redirect ( [ 
				'controller' => 'activity',
				'action' => 'index'.$curtime
		]);
	}
	public function appliedcheck() {
		if($this->request->data['kaiinkbnmem'] == "1") {
			$conditions[]  = array ('kkey ' => $this->request->data['arno'], 
									'mousikominm ' => $this->request->data['kaiinnm']
			);
		} else {
			$conditions[]  = array ('kkey ' => $this->request->data['arno'], 
									'kaiincd ' => $this->request->data['kaiincd']
			);
		}
		$conditions[] = array('OR' => array(
									array('torikesidt' => NULL),
									array('torikesidt' => "0000-00-00 00:00:00"),
								));
		$filedata = $this->TEntry->find ( 'first', array (
						'fields' => array('arno'),
						'conditions' => $conditions
					));
		if(count($filedata)!=0) {
			echo "1"; exit;
		} else {
			echo "0"; exit;
		}

	}
	/**
	 *　機能名：新しいキャプチャを作る
	 */
	public function getRefreshCaptcha() {
		$captcha = array();
		$captcha['image'] = captchaImage();
		$captcha['captcha_code'] = $this->Session->read('captcha_code');
		echo json_encode($captcha); exit();
	}
}