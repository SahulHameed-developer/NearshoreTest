<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Common');
/**
 * 出欠情報一覧 Controller
 *
 * 出欠情報一覧を表示するControllerです。【画面分類：管理】
 *
 * @author MICROBIT Co. Ltd.,
 *
 */
class AdminAttendanceController extends AppController {
	// helpers追加
	public $helpers = array('Html', 'Form', 'Constants', 'Common');
	// components追加
	public $components = array('Flash', 'RequestHandler', 'auth', 'Session', 'Constants', 'Common');
	// モデル名追加
	var $uses = array('MKaiinsb','TEntry','TKatudo','TKaiin','MKbunrui','MKyaku', 'MSosiki');
	// レイアウト無し
	public $autoLayout = false;
	/**
	 *　画面名：出欠情報
	 *　機能名：出欠情報一覧の表示
	 */
	public function memberlist() {
		$attenDtFrm = date('Y/m', strtotime('-1 years +1 month'));
		$attenDtTo = date('Y/m');
		//会員種別
		$this->set('kaiinsbnm', $this->Common->getKaiinsbList($this->MKaiinsb));
		//活動分類マスタテーブル
		$this->set('kbunruinm', $this->Common->getActivity($this->MKbunrui));
		$this->set('attenDtFrm', $attenDtFrm);
		$this->set('attenDtTo', $attenDtTo);
		$this->set('kaiinsbname', '');
		$this->set('YakushokuChk1','checked');
		$this->set('YakushokuChk2','');
		$this->set('YakushokuChk3','');
		$this->set('kaiinmei','');
		$this->set('katsudoRadio1','checked');
		$this->set('katsudoRadio2','');
		$this->set('katsudo','');
		$this->set('Shussekiritsu1','');
		$this->set('Shussekiritsu2','checked');
		$this->set('Shussekikaisu','');
		$this->set('count','0');
		// 画面の移動	
		$this->render('/Admin/Attendance/list');
	}
	/* 表示順序処理
	 * 総回数（降順） ：  総回数（降順）、協会役職コード、会員名称、の順
	 */
	public function sortByTotalDESCOrder($first, $next) {
		// return $next['event']['total'] - $first['event']['total'];
		if($next['event']['total'] < $first['event']['total']) {
			return -1;
		} else if($next['event']['total'] > $first['event']['total']) {
			return 1;
		} else {
			return self::getInnerSort($first, $next);
		}
	}
	/* 表示順序処理
	 * 総回数（昇順） ：  総回数（昇順）、協会役職コード、会員名称、の順
	 */
	public function sortByTotalASCOrder($first, $next) {
		if($first['event']['total'] < $next['event']['total']) {
			return -1;
		} else if($first['event']['total'] > $next['event']['total']) {
			return 1;
		} else {
			return self::getInnerSort($first, $next);
		}
	}
	/**
	 *　インナーソート処理
	 */
	public function getInnerSort($first, $next) {
		if($first['kyoukaiykcd'] < $next['kyoukaiykcd']) {
			return -1;
		} else if($first['kyoukaiykcd'] > $next['kyoukaiykcd']) {
			return 1;
		} else {
			if($first['kaiinnmkana'] < $next['kaiinnmkana']) {
				return -1;
			} else if($first['kaiinnmkana'] > $next['kaiinnmkana']) {
				return 1;
			}
		}
		return 0;
	}
	/* 表示順序処理
	 * 役職 ： 協会役職コード、総回数（降順）、会員名称、　　の順
	 */
	public function sortByKyoukaiykCD($first, $next) {
		if($first['kyoukaiykcd'] < $next['kyoukaiykcd']) {
			return -1;
		} else if($first['kyoukaiykcd'] > $next['kyoukaiykcd']) {
			return 1;
		} else {
			if($first['event']['total'] > $next['event']['total']) {
				return -1;
			} else if($first['event']['total'] < $next['event']['total']) {
				return 1;
			} else {
				if($first['kaiinnmkana'] < $next['kaiinnmkana']) {
					return -1;
				} else if($first['kaiinnmkana'] > $next['kaiinnmkana']) {
					return 1;
				}
			}
		}
	}
	/**
	 * 　画面名：出欠情報
	 * 　機能名：出欠データの検索処理
	 */
	public function search() {
		$Katsudoucheck = array();
		$narabijun = array('1' => '会員名称','2' => '役職','3' => '総回数（降順）','4' => '総回数（昇順）');
		$selectednarabi = 2;
		$katudoCnt = "";
		$empDetails = "";
		if (!empty ( $this->request->data )) {
			$attenDtFrm = $this->request->data ['attenDtFrm'];
			$attenDtTo = $this->request->data ['attenDtTo'];
			$kaiinsbnm = $this->request->data ['kaiinsbnm'];
			$Yakushoku = $this->request->data ['Yakushoku'];
			$kaiinmei  = $this->request->data ['kaiinmei'];
			$katsudo  = $this->request->data ['katsudo'];
			$Shussekikaisu = $this->request->data['Shussekikaisu'];
			$Shussekiritsu = $this->request->data['Shussekiritsu'];
			if(empty($attenDtTo)) {
				$attenDtTo = date('Y/m');
			}
			if (empty($attenDtFrm)) {
				$attenDtFrm = date('Y/m', strtotime('-1 years +1 month'));
			}
			$selectednarabi = 3;
			if (isset($this->request->data ['narabijun']) &&  $this->request->data ['narabijun'] != "") {
				$selectednarabi = $this->request->data ['narabijun'];
			}
			if ($katsudo == 1 && isset($this->request->data ['Katsudoucheck'])) {
				$Katsudoucheck  = $this->request->data ['Katsudoucheck'];
			} else { 
				$Katsudoucheck = "";
				$katsudo = 0;
			}
			if (! empty ( $attenDtFrm )) {
				$st_date = $this->Common->fromDate ( str_replace ( '/', '-', $attenDtFrm ) );
			} else {
				$st_date =  date('Y/m', strtotime('-1 years +1 month'));
			}
			if (! empty ( $attenDtTo )) {
				$en_date = $this->Common->getLastDateOfMonth ( str_replace ( '/', '-', $attenDtTo ) );
			} else {
				$en_date = $this->Common->getLastDateOfMonth (date('Y-m'));
			}
			$flashError = false;
			if (! empty ( $en_date ) && $st_date > $en_date) {
				$this->Session->setFlash ("期間のFrom、Toを正しく入力してください。");
				$this->set ( [ 
						'attenDtFrm' => $attenDtFrm,
						'attenDtTo' => $attenDtTo
				] );
				$flashError = true;
			}
			if (! $flashError) {
				$conditions = array();
				if (! empty($kaiinsbnm)) {
					$conditions[] = array (
						'TKaiin.kaiinsbcd' => $kaiinsbnm
					);
				}
				if ( $Yakushoku == 1) {
					$conditions[] = array (
						'TKaiin.kyoukaiykcd !=' => ''
					);
				} else if ($Yakushoku == 2) {
					$conditions[] = array (
						'TKaiin.kyoukaiykcd' => ''
					);
				}
				if (!empty($kaiinmei)) {
					$conditions[]= array (
						'TKaiin.kaiinnm LIKE' => '%'.$kaiinmei.'%'
					);
				}
				$conditions[] = array (
						'TKaiin.kanrikbn <' => $this->Constants->SYS_KANRISHA
					);
				// 表示順序 
				$sorting = array();
				if($selectednarabi == 1){
					$sorting[] = array('kaiinnmkanaEmpty' => 'ASC',
										'MKaiinsb.kaiinsbcd' => 'ASC',
										'kyoukaiykcdEmpty' => 'ASC');
				} else if ($selectednarabi == 3 || $selectednarabi == 4) {
					$sorting[] = array('MKyaku.kyoukaiykcd' => 'ASC',
										'kaiinnmkanaEmpty' => 'ASC');
				} else {
					$sorting[] = array('MKyaku.kyoukaiykcd' => 'ASC');
				}
				$empDetails = $this->TKaiin->find ( 'all', array (
								'joins' => array (
										array (
											'table' => $this->MKyaku,
											'alias' => 'MKyaku',
											'type' => 'LEFT',
											'conditions' => array(
													'MKyaku.kyoukaiykcd = TKaiin.kyoukaiykcd',
													'MKyaku.fromdt <= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))',
													'MKyaku.todt >= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))')),
										array (
											'table' => $this->MKaiinsb,
											'alias' => 'MKaiinsb',
											'type' => 'LEFT',
											'conditions' => array(
													'MKaiinsb.kaiinsbcd = TKaiin.kaiinsbcd',
													'MKaiinsb.fromdt <= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))',
													'MKaiinsb.todt >= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))')),
										array (
											'table' => $this->MSosiki,
											'alias' => 'MSosiki',
											'type' => 'LEFT',
											'conditions' => array(
													'MSosiki.sosikicd = TKaiin.sosikicd',
													'MSosiki.fromdt <= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))',
													'MSosiki.todt >= IF(TKaiin.kousindt ="0000-00-00 00:00:00" OR TKaiin.kousindt IS NULL, DATE(TKaiin.tourokudt), DATE(TKaiin.kousindt))')),
								),
								'fields' => array (
											'TKaiin.kaiincd',
											'TKaiin.kaiinnm',
											'kaiinnmkanaEmpty',
											'TKaiin.kaiinsbcd',
											'kyoukaiykcdEmpty',
											'TKaiin.kyoukaiykcd',
											'TKaiin.sosikicd',
											'MKaiinsb.kaiinsbnm',
											'MKyaku.kyoukaiyknm',
											'MSosiki.sosikirs',
								), 
								'conditions' => $conditions,
								'group' => 'TKaiin.kaiincd',
								'order' => $sorting 
						));
					$cnt = count ( $empDetails );
					$kbunruicnttop = array();
					$attendanceData = array();
					$allAcvitityTotal = 0;
					$this->set('count',$cnt);
					if ($cnt == 0) {
						$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
					} else {
						for ($i=0; $i <count($empDetails) ; $i++) {
							$empCode = $empDetails[$i]['TKaiin']['kaiincd'];
							$attendanceData[$empCode]['kaiinnm'] = $empDetails[$i]['TKaiin']['kaiinnm'];
							$attendanceData[$empCode]['kaiinnmkana'] = $empDetails[$i]['TKaiin']['kaiinnmkanaEmpty'];
							$attendanceData[$empCode]['kaiinsbcd'] = $empDetails[$i]['TKaiin']['kaiinsbcd'];
							$attendanceData[$empCode]['kaiinsbnm'] = $empDetails[$i]['MKaiinsb']['kaiinsbnm'];
							$attendanceData[$empCode]['kyoukaiykcd'] = $empDetails[$i]['TKaiin']['kyoukaiykcdEmpty'];
							$attendanceData[$empCode]['kyoukaiyknm'] = $empDetails[$i]['MKyaku']['kyoukaiyknm'];
							$attendanceData[$empCode]['sosikicd'] = $empDetails[$i]['TKaiin']['sosikicd'];
							$attendanceData[$empCode]['sosikirs'] = $empDetails[$i]['MSosiki']['sosikirs'];
						}
						if(isset($this->request->data ['Katsudoucheck'])) {
							$activityList = self::getActivityField($this->TKatudo, $this->MKbunrui, $st_date, $en_date, $this->request->data ['Katsudoucheck']);
						} else {
							$checked = null;
							$activityList = self::getActivityField($this->TKatudo, $this->MKbunrui, $st_date, $en_date, $checked);
						}
						$i=0;
						foreach ($activityList as $activityListkey => $kbunruinmvalue) {
							if(empty($activityListkey)) {
								unset($activityList[$activityListkey]);
							} else {
								$evnetConditions[] = array ();
								$evnetConditions[] = array ('TKatudo.kbunruicd' => $activityListkey);
								$evnetConditions[] = array ('TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD);
								if (! empty ( $st_date )) {
									$evnetConditions[] = array ('TKatudo.kaisaidate >=' => $st_date);
								}
								if (! empty ( $en_date )) {
									$evnetConditions[]  = array ('TKatudo.kaisaidate <=' => $en_date);
								}
								$kbunruicnttop[$i] = $this->TKatudo->find('all', array(
													'fields' => array('COUNT(TKatudo.arno) AS cnt'),
													'conditions'=> $evnetConditions,
													));
								$allAcvitityTotal = $allAcvitityTotal + $kbunruicnttop[$i][0][0]['cnt'];
								$i++;
								unset($evnetConditions);
							}
						}
						if (isset($kbunruicnttot)) {
							$this->set('kbunruicnttot', $kbunruicnttot);
						} else {
							$this->set('kbunruicnttot', '');
						}
						for ($i=0; $i <count($empDetails) ; $i++) {
							$tot = 0;
							$empCode = $empDetails[$i]['TKaiin']['kaiincd'];
							foreach ($activityList as $activityListkey => $kbunruinmvalue) {
								$fetchData = $this->TEntry->find ( 'all', array (
										'joins' => array (
												array (
													'table' => $this->TKatudo,
													'alias' => 'TKatudo',
													'type' => 'LEFT',
													'conditions' => array ('TKatudo.arno = TEntry.kkey')),
										),
										'fields' => array (
													'COUNT(TKatudo.arno) AS cnt',
										),
										'conditions' => array('TEntry.kaiincd' => $empCode,
																'TKatudo.kbunruicd' => $activityListkey,
																'TKatudo.bunruicd' => ConstantsComponent::$EVENT_CD,
																'TEntry.kaiinkbn ' =>  $this->Constants->KAIIN,// 会員区分　＝　"0"[会員]
																'TKatudo.kaisaidate >=' => $st_date, 
																'TKatudo.kaisaidate <=' => $en_date,
																'OR' => array(
																	array('TEntry.torikesidt' => NULL),
																	array('TEntry.torikesidt' => "0000-00-00 00:00:00"))
															),
								));
								$tot = $tot + $fetchData[0][0]['cnt'];
								$attendanceData[$empCode]['event'][$activityListkey] = $fetchData[0][0]['cnt'];
							}
							$attendanceData[$empCode]['event']['total'] = $tot;
							// 出席率
							if(!empty($allAcvitityTotal)) {
								$attendPercentage = round(($tot/$allAcvitityTotal)*100, 2);
							} else {
								$attendPercentage = 0;
							}
							if($Shussekikaisu != "") {
								if(($Shussekiritsu == 0 && $attendPercentage < $Shussekikaisu)
									|| ($Shussekiritsu == 1 && $attendPercentage > $Shussekikaisu)) {
									unset($attendanceData[$empCode]);
								}
							}
						}
						if (count($attendanceData) == 0) {
							$empDetails = null;
							$this->Session->setFlash ($this->Constants->SEARCH_NOT_FOUND);
						} else {
							if ($selectednarabi == 2) {
								usort($attendanceData, array($this, 'sortByKyoukaiykCD'));
							} else if ($selectednarabi == 3) {
								usort($attendanceData, array($this, 'sortByTotalDESCOrder'));
							} else if ($selectednarabi == 4) {
								usort($attendanceData, array($this, 'sortByTotalASCOrder'));
							}
						}
						$this->set('attenDtFrm', $attenDtFrm);
						$this->set('attenDtTo', $attenDtTo);
						$this->set('kaiinsbname', $kaiinsbnm);
						$this->set('kaiinsbname', $kaiinsbnm);
						$this->set (['Katsudoucheck' => $Katsudoucheck]);
						$this->set('kaiinmei', $kaiinmei);
						$this->set('katsudo', $katsudo);
						$this->set (['attenInfo' => $empDetails]);
						if (isset($kbunruicnt)) {
							$this->set('kbunruicnt', $kbunruicnt);
						} else {
							$this->set('kbunruicnt', '');
						}
					}
					if (isset($activityList)) {
						$this->set('activityList', $activityList);
					} else {
						$this->set('activityList', '');
					}
					$this->set('kbunruicnttop', $kbunruicnttop);
					$this->set('attendanceData', $attendanceData);
					$this->set('katudoCnt', $allAcvitityTotal);
			} else {
				$this->set('count','0');
			}
			$this->set (['attenInfo' => $empDetails]);
			$this->set('attenDtFrm', $attenDtFrm);
			$this->set('attenDtTo', $attenDtTo);
			$this->set('kaiinsbname', $kaiinsbnm);
			$this->set('kaiinsbnm', $this->Common->getKaiinsbList($this->MKaiinsb));
			$this->set('kyoukai', $this->Common->getkyoukaiyakushokuName($this->MKyaku));
			$this->set('shozoku', $this->Common->getShozokuiinkai($this->MSosiki));
			if($Yakushoku == '0') {
				$this->set('YakushokuChk1','checked');
				$this->set('YakushokuChk2','');
				$this->set('YakushokuChk3','');
			} else if($Yakushoku == '1') {
				$this->set('YakushokuChk1','');
				$this->set('YakushokuChk2','checked');
				$this->set('YakushokuChk3','');
			} else {
				$this->set('YakushokuChk1','');
				$this->set('YakushokuChk2','');
				$this->set('YakushokuChk3','checked');
			}
			if($katsudo == '0') {
				$this->set('katsudoRadio1','checked');
				$this->set('katsudoRadio2','');
			} else {
				$this->set('katsudoRadio1','');
				$this->set('katsudoRadio2','checked');
			}
			$this->set('kaiinsbname', $kaiinsbnm);
			$this->set (['Katsudoucheck' => $Katsudoucheck]);
			$this->set('kaiinmei', $kaiinmei);
			$this->set('katsudo', $katsudo);
			$this->set('kbunruinm', $this->Common->getActivity($this->MKbunrui, $st_date, $en_date));
			if($Shussekiritsu == '0') {
				$this->set('Shussekiritsu1','checked');
				$this->set('Shussekiritsu2','');
			} else {
				$this->set('Shussekiritsu1','');
				$this->set('Shussekiritsu2','checked');
			}
			$this->set('narabijun',$narabijun);
			$this->set('Shussekikaisu',$Shussekikaisu);
			$this->set('selectednarabi',$selectednarabi);
			// 画面の移動	
			$this->render ('/Admin/Attendance/list' );
		} else {
			$this->redirect ( ['controller' => 'AdminAttendance','action' => 'memberlist' ] );
		}
	}
	/**
	 * 　画面名：出欠情報
	 * 　機能名：活動フィールドを取得する処理
	 */
	public function getActivityField($TKatudo, $MKbunrui, $st_date, $en_date, $checked = null) {
		$activityList  = array();
		if($checked != null) {
			$conditions[] = array('MKbunrui.bunruicd' => ConstantsComponent::$EVENT_CD);
			if(COUNT($checked) > 1) {
				$conditions[] = array('AND' => array('MKbunrui.kbunruicd IN ' => $checked));
			} else {
				$conditions[] = array('AND' => array('MKbunrui.kbunruicd' => $checked[0]));
			}
			$conditions[] = array('AND' => array('fromdt <= ' => $this->Common->getSystemDate()));
			$conditions[] = array('AND' => array('todt >= ' => $this->Common->getSystemDate()));
			$activityList = $MKbunrui->find('list', array(
								'fields' => array('kbunruicd','kbunruinm'),
								'conditions'=> $conditions,
								'order'=>array('hyojino' => 'ASC')));
		} else {
			$conditions[] = array('TKatudo.kaisaidate >=' => $st_date,
								'TKatudo.kaisaidate <=' => $en_date
							);
			$activityList = $TKatudo->find('list', array(
											'joins' => array (
												array ('table' => $MKbunrui,
														'alias' => 'MKbunrui',
														'type' => 'LEFT',
														'conditions' => array ('TKatudo.kbunruicd = MKbunrui.kbunruicd',
																			'TKatudo.bunruicd = MKbunrui.bunruicd',
																			'MKbunrui.bunruicd' => ConstantsComponent::$EVENT_CD,
																			'MKbunrui.fromdt <= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))',
																			'MKbunrui.todt >= IF(TKatudo.kousindt ="0000-00-00 00:00:00" OR TKatudo.kousindt IS NULL, DATE(TKatudo.tourokudt), DATE(TKatudo.kousindt))'))
											),
										'fields' => array('MKbunrui.kbunruicd','MKbunrui.kbunruinm'),
										'conditions'=> $conditions,
										'order'=>array('MKbunrui.hyojino' => 'ASC')
									));
		}
		return $activityList;
	}
}