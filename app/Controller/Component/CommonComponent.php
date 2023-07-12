<?php
App::uses('Component', 'Controller');

class CommonComponent extends Component
{
	
	// components追加
	public $components = array('Flash', 'RequestHandler', 'Session', 'Constants', 'Common');

	/**
	 * getSystemDate
	 *
	 * @return $curdate システム日付
	 *
	 */
	public static function getSystemDate() {
		$curdate = date('Y-m-d');
		return $curdate;
	}
	/**
	 * getYesterdayDate
	 *
	 * @return $yesterdaydate システム日付
	 *
	 */
	public static function getYesterdayDate() {
		$yesterdaydate = date("Y-m-d",strtotime("-1 day"));
		return $yesterdaydate;
	}
	
	/**
	 * getJapDateTime
	 *
	 * $date 日付
	 *
	 * @return $jpdate
	 *
	 */
	public static function getJapDateTime($date) {
		if (! empty ( $date )) {
			$day  = date("w",strtotime($date));
			$jpdays = array("日","月","火","水","木","金","土");
			$jpdayVal = $jpdays[$day];
			$jpdate = date('Y年m月d日',strtotime($date)) . '  (' . $jpdayVal . ')  '.date("G:i", strtotime($date));
		} else {
			$jpdate = "";
		}
		return $jpdate;
	}

	/**
	 * getJapDate
	 *
	 * $date 日付
	 *
	 * @return $jpdate
	 *
	 */
	public static function getJapDate($date) {
		if (! empty ( $date )) {
			$day  = date("w",strtotime($date));
			$jpdays = array("日","月","火","水","木","金","土");
			$jpdayVal = $jpdays[$day];
			$jpdate =date('Y年m月d日',strtotime($date)) . '  (' . $jpdayVal . ')  ';
		} else {
			$jpdate = "";
		}
		return $jpdate;
	}

	/**
	 * ２年前の日付取得
	 *
	 * @return $twoYearBefore ２年前の日付
	 *
	 */
	public static function twoYearBeforeDate() {
		$twoYearBefore = date("Y-m-d",strtotime("-2 year"));
		return $twoYearBefore;
	}
	/**
	 * toDate
	 *
	 * @return $endDate システム日付
	 *
	 */
	public static function toDate($dt) {
		$endDate = $dt;
		$endDate = strtotime($endDate);
		$endDate = strtotime("+1 month", $endDate);
		$endDate = date('Y-m-d', $endDate);
		return $endDate;
	}
	/**
	 * fromDate
	 *
	 * @return $endDate システム日付
	 *
	 */
	public static function fromDate($dt) {
		$startdate = $dt."-01";
		return $startdate;
	}
	/**
	 * getSystemDateTime
	 *
	 * @return $curdateTime システム日付
	 *
	 */
	public static function getSystemDateTime() {
		$curdateTime = date('Y-m-d G:i:s');
		return $curdateTime;
	}
	
	/**
	 * getLastDateOfMonth
	 *
	 * @return $lastDateOfMonth 月初日
	 *
	 */
	public static function getLastDateOfMonth($date) {
		$lastDateOfMonth = date("Y-m-t", strtotime($date));
		return $lastDateOfMonth;
	}
	/**
	 * 画面名：活動カレンダー
	 * 機能名： 会議種別名称の取得
	 */
	public function getKaigiShubetsuName($MSosiki) {
		// 会議種別の一覧
		$msosiki = $MSosiki->find('list', array(
										'fields' => array(
											'sosikicd',
											'sosikinm'),
										'conditions'=>array(
												'MSosiki.fromdt <=' =>$this->Common->getSystemDate(),
												'MSosiki.todt >=' =>$this->Common->getSystemDate()),
										'order'=>array(
											'MSosiki.hyojino' => 'ASC',
											'MSosiki.sosikicd' => 'ASC')));
		return $msosiki;
	}
	
	/**
	 * 画面名：活動カレンダー
	 * 機能名： イベント種別名称の取得
	 */
	public function getEventShubetsuName($MKbunrui) {
		// イベント種別の一覧
		$mkbunrui = $MKbunrui->find('list',  array(
										'fields' => array(
											'kbunruicd',
											'kbunruinm'),
										'conditions'=>array(
											'MKbunrui.bunruicd' => ConstantsComponent::$EVENT_CD,
											'MKbunrui.fromdt <=' =>$this->Common->getSystemDate(),
											'MKbunrui.todt >=' =>$this->Common->getSystemDate()),
										'order'=>array(
											'MKbunrui.hyojino' => 'ASC',
											'MKbunrui.kbunruicd' => 'ASC')));
		return $mkbunrui;
	}
	public function getkaigibunruiName($MKbunrui) {
		// イベント種別の一覧
		$mkbunrui = $MKbunrui->find('list',  array(
				'fields' => array(
						'kbunruicd',
						'kbunruinm'),
				'conditions'=>array(
						'MKbunrui.bunruicd' => ConstantsComponent::$KAIGI_CD,
						'MKbunrui.fromdt <=' =>$this->Common->getSystemDate(),
						'MKbunrui.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKbunrui.hyojino' => 'ASC',
						'MKbunrui.kbunruicd' => 'ASC')));
		return $mkbunrui;
	}
	
	/**
	 *　画面名：会員企業
	 *　機能名：業種名称の取得
	 */
	public function getGyosyuName($MGyosyu) {
		// 業種名称の一覧
		$gyosyunm_list = $MGyosyu->find('list', array(
										'fields' => array(
												'gyosyucd',
												'gyosyunm'),
										'conditions'=>array(
												'MGyosyu.fromdt <=' =>$this->Common->getSystemDate(),
												'MGyosyu.todt >=' =>$this->Common->getSystemDate()),
										'order'=>array(
												'MGyosyu.hyojino' => 'ASC',
												'MGyosyu.gyosyucd' => 'ASC')));
		return $gyosyunm_list;
	}
	
	public function getMKeiyaku($MKeiyaku) {
		// 業種名称の一覧
		$gyosyunm_list = $MKeiyaku->find('list', array(
										'fields' => array(
												'keiyakucd',
												'keiyakurs'),
										'conditions'=>array(
												'MKeiyaku.fromdt <=' =>$this->Common->getSystemDate(),
												'MKeiyaku.todt >=' =>$this->Common->getSystemDate()),
										'order'=>array(
												'MKeiyaku.hyojino' => 'ASC',
												'MKeiyaku.keiyakucd' => 'ASC')));
		return $gyosyunm_list;
	}
	
	/**
	 *　画面名：会員企業
	 *　機能名：会員種別名称の取得
	 */
	public function getKaiinShubetsuName($MKaiinsb) {
		// 会員種別名称の一覧
		$kaiinsbnm_list = $MKaiinsb->find('list', array(
										'fields' => array(
												'kaiinsbcd',
												'kaiinsbnm'),
										'conditions'=>array(
												'MKaiinsb.fromdt <=' =>$this->Common->getSystemDate(),
												'MKaiinsb.todt >=' =>$this->Common->getSystemDate()),
										'order'=>array(
												'MKaiinsb.hyojino' => 'ASC',
												'MKaiinsb.kaiinsbcd' => 'ASC')));
		return $kaiinsbnm_list;
	}
	/**
	 * 画面名：活動カレンダー
	 * 機能名： イベント種別名称の取得
	 */
	public function getEventShubetsu($MKbunrui, $bunruicd) {
		// イベント種別の一覧
		$mkbunrui = $MKbunrui->find('list',  array(
				'fields' => array(
						'kbunruicd',
						'kbunruinm'),
				'conditions'=>array(
						'MKbunrui.bunruicd' => $bunruicd,
						'MKbunrui.fromdt <=' =>$this->Common->getSystemDate(),
						'MKbunrui.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKbunrui.hyojino' => 'ASC',
						'MKbunrui.kbunruicd' => 'ASC')));
		return $mkbunrui;
	}
	
	/**
	 * 画面名：活動カレンダー
	 * 機能名： イベント種別名称の取得
	 */
	public function getEventShubetsuKaigi($MKbunrui) {
		// イベント種別の一覧
		$mkbunrui = $MKbunrui->find('list',  array(
				'fields' => array(
						'kbunruicd',
						'kbunruinm'),
				'conditions'=>array(
						'MKbunrui.bunruicd' => ConstantsComponent::$KAIGI_CD,
						'MKbunrui.fromdt <=' =>$this->Common->getSystemDate(),
						'MKbunrui.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKbunrui.hyojino' => 'ASC',
						'MKbunrui.kbunruicd' => 'ASC')));
		return $mkbunrui;
	}

	/**
	 * 
	 * 画面名：入会申込確認,会議・イベント申込確認
	 * 機能名： メール送信専用アドレスの取得
	 */
	public function getMailInfo($MTuuci) {
		// イベント種別の一覧
		$mailInfo=$MTuuci->find('all', array(
				'fields' => array(
						'MTuuci.mailaddrsend',
						'MTuuci.mailaddr1',
						'MTuuci.mailaddr2',
						'MTuuci.mailaddr3'),
				'conditions' => array(
						'MTuuci.sosikicd ' => $this->Constants->SOSIKICD_KOTEI,
						'MTuuci.bunruicd ' => $this->Constants->BUNRUICD_KOTEI,
						'MTuuci.kbunruicd ' => $this->Constants->KBUNRUICD_KOTEI)));
		return $mailInfo;
	}

	/**
	 * 
	 * 画面名：活動カレンダー,お知らせ,有益情報
	 * 機能名： メール送信専用アドレスの取得
	 */
	public function getUketoriMailInfo($TKaiin) {
		// イベント種別の一覧
		$uketoriMailInfo = $TKaiin->find('all', array(
				'fields' => array('TKaiin.mailaddr'),
				'conditions' => array(
						'TKaiin.uketorikbn ' => 1)));
		return $uketoriMailInfo;
	}

	/**
	 * 
	 * 画面名：活動カレンダー,お知らせ,有益情報
	 * 機能名： 通知メール送信処理
	 */
	public function uketoriMailSendFunction($from,$uketoriMailInfoArray,$screenFlag) {
		// イベント種別の一覧
		$subject_mail = '【ニアショアＩＴ協会】　ホームページ更新のお知らせ';
		$msg_data[0] = '会員各位';
		$msg_data[1] = 'いつもお世話になっております。';
		$msg_data[2] = 'ニアショアＩＴ協会からのお知らせです。';
		/*
		 * $screenFlag ==> 1 「活動カレンダー」が登録・更新され場合
		 *
		 * $screenFlag ==> 2 「お知らせ」が登録・更新され場合
		 *
		 * $screenFlag ==> 3 「有益情報」が登録・更新され場合
		 *
		 * $screenFlag ==> 4 「活動報告」が流用・更新され場合
		 *
		 */
		$msg_data[3] = '';
		if($screenFlag == 1) {
			$msg_data[3] = 'ホームページの<b>「活動カレンダー」</b>が更新されましたので、ご確認ください。';
		} elseif($screenFlag == 2) {
			$msg_data[3] = 'ホームページの<b>「お知らせ」</b>が更新されましたので、ご確認ください。';
		} else if($screenFlag == 3) {
			$msg_data[3] = 'ホームページの<b>「有益情報」</b>が更新されましたので、ご確認ください。';
		} else if($screenFlag == 4) {
			$msg_data[3] = 'ホームページの<b>「活動報告」</b>が更新されましたので、ご確認ください。';
		}
		$msg_data[4] = 'https://www.nearshore-it.jp/';
		if($screenFlag == 3) {
			$msg_data[5] = '※「有益情報」の確認は、（会員ログイン）よりログイン後';
			$msg_data[6] = '　（会員メニュー）の（有益情報一覧）より確認頂けます。';
			$msg_data[7] = '※本メールは送信専用アドレスより送信しております。';
			$msg_data[8] = '　このメールに直接返信されましてもメールが届きませんのでご注意ください。';
		} else {
			$msg_data[5] = '※本メールは送信専用アドレスより送信しております。';
			$msg_data[6] = '　このメールに直接返信されましてもメールが届きませんのでご注意ください。';
		}
		$uketori_msg_mail = $this->mailUketoriTextupdate($msg_data,$screenFlag);
		$mail = new CakeEmail('smtp');
		$mail->from($from);
		$mail->to($from);
		$mail->bcc($uketoriMailInfoArray);
		$mail->subject($subject_mail);
		$mail->emailFormat('html');
		$mail->send($uketori_msg_mail);
	}
	
	/**
	 * 画面名：活動カレンダー,お知らせ,有益情報
	 * 機能名：通知メール送信処理
	 * 
	 * @param
	 *		引継ぎ情報 data
	 * @param
	 *		画面フラグ screenFlag
	 * @return string
	 * 
	 */
	private function mailUketoriTextupdate($data,$screenFlag) {
		$message="";
		$message .= "<div>".$data[0]."</div><br>";
		$message .= "<div>".$data[1]."</div>";
		$message .= "<div>".$data[2]."</div><br>";
		$message .= "<div>".$data[3]."</div>";
		$message .= "<div><a target='_blank' href='".$data[4]."'>".$data[4]."</a></div><br>";
		$message .= "<div>".$data[5]."</div>";
		$message .= "<div>".$data[6]."</div>";
		if($screenFlag == 3) {
			$message .= "<br><div>".$data[7]."</div>";
			$message .= "<div>".$data[8]."</div>";
		}
		return $message;
	}

	/**
	 * 
	 * 画面名：入会申込確認,会議・イベント申込確認
	 * 機能名： CCメール送信専用アドレスの取得
	 */
	public function getMailCCInfo($TKaiin, $sosikicd){
		$mailCC = "";
		if($sosikicd != "") {
			$mailCCInfo = $TKaiin->find('first', array(
				'fields' => array(
						'TKaiin.mailaddr'),
				'conditions' => array(
						'TKaiin.iinkaiykcd ' => $this->Constants->T_KAIIN_IINKAIYKCD,
						'TKaiin.sosikicd ' => $sosikicd)));
			if(isset($mailCCInfo['TKaiin']['mailaddr'])) {
				$mailCC = $mailCCInfo['TKaiin']['mailaddr'];
			}
		}
		return $mailCC;
	}

	/**
	 *　画面名：会員編集
	 *　機能名：協会役職名称の取得
	 */
	public function getkyoukaiyakushokuName($MKyaku) {
		// 協会役職名称の一覧
		$kyoukaiyknm_list = $MKyaku->find('list', array(
				'fields' => array(
						'kyoukaiykcd',
						'kyoukaiyknm'),
				'conditions'=>array(
						'MKyaku.fromdt <=' =>$this->Common->getSystemDate(),
						'MKyaku.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKyaku.hyojino' => 'ASC',
						'MKyaku.kyoukaiykcd' => 'ASC')));
		return $kyoukaiyknm_list;
	}
	
	/**
	 *　画面名：会員編集
	 *　機能名：委員会役職名称の取得
	 */
	public function getiinkaiyakushokuName($MIyaku) {
		// 協会役職名称の一覧
		$iinkaiyknm_list = $MIyaku->find('list', array(
				'fields' => array(
						'iinkaiykcd',
						'iinkaiyknm'),
				'conditions'=>array(
						'MIyaku.fromdt <=' =>$this->Common->getSystemDate(),
						'MIyaku.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MIyaku.hyojino' => 'ASC',
						'MIyaku.iinkaiykcd' => 'ASC')));
		return $iinkaiyknm_list;
	}	
	/**
	 *機能名：都道府県マスタから都道府県コードを取得する処理です。「getMTodofuken」 
	 *   
	 **/
	public function getMTodofuken($MTodofuken) {
		$mtodofuken_list = $MTodofuken->find('list', array(
				'fields' => array(
						'todofukencd',
						'todofukennm'),
				'conditions'=>array(
						'MTodofuken.fromdt <=' =>$this->Common->getSystemDate(),
						'MTodofuken.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MTodofuken.hyojino' => 'ASC',
						'MTodofuken.todofukencd' => 'ASC')));
		return $mtodofuken_list;		
	}
	/**
	 *機能名：趣味マスタから趣味コードを取得する処理です。「getMSyumi」
	 *
	 **/
	public function getMSyumi($MSyumi) {
		$msyumi_list = $MSyumi->find('list', array(
				'fields' => array(
						'syumicd',
						'syuminm'),
				'conditions'=>array(
						'MSyumi.fromdt <=' =>$this->Common->getSystemDate(),
						'MSyumi.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MSyumi.hyojino' => 'ASC',
						'MSyumi.syumicd' => 'ASC')));
		return $msyumi_list;
	}
	/**
	 *   
	 **/
	public function getKoninName($konin) {
		$konin_list = $konin->find('all', array(
				'fields' => array(
						'konincd',
						'koninnm'),
				'conditions'=>array(
						'MKonin.fromdt <=' =>$this->Common->getSystemDate(),
						'MKonin.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKonin.hyojino' => 'ASC',
						'MKonin.konincd' => 'ASC')));
		return $konin_list;
	}
	/**
	 *　画面名：会員追加
	 *　機能名：委員会名称の取得
	 */
	public function getShozokuiinkai($MSosiki) {
		// 委員会名称の一覧
		$sosikinm_list = $MSosiki->find('list', array(
				'fields' => array(
						'sosikicd',
						'sosikinm'),
				'conditions'=>array(
						'MSosiki.fromdt <=' =>$this->Common->getSystemDate(),
						'MSosiki.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MSosiki.hyojino' => 'ASC',
						'MSosiki.sosikicd' => 'ASC')));
		return $sosikinm_list;
	}
	
	/**
	 *　画面名：会員追加
	 *　機能名：委員会名称の取得
	 */
	public function getTodofukenName($MTodofuken) {
		// 委員会名称の一覧
		$todofukennm_list = $MTodofuken->find('list', array(
				'fields' => array(
						'todofukencd',
						'todofukennm'),
				'conditions'=>array(
						'MTodofuken.fromdt <=' =>$this->Common->getSystemDate(),
						'MTodofuken.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MTodofuken.hyojino' => 'ASC',
						'MTodofuken.todofukencd' => 'ASC')));
		return $todofukennm_list;
	}
	
	/**
	 *　画面名：会員追加
	 *　機能名：趣味名称の取得
	 */
	public function getSyumiName($MSyumi) {
		// 趣味名称の一覧
		$syuminm_list = $MSyumi->find('list', array(
				'fields' => array(
						'syumicd',
						'syuminm'),
				'conditions'=>array(
						'MSyumi.fromdt <=' =>$this->Common->getSystemDate(),
						'MSyumi.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MSyumi.hyojino' => 'ASC',
						'MSyumi.syumicd' => 'ASC')));
		return $syuminm_list;
	}
	/**
	 *公開区分を取得する。
	 **/
	public function getKokaiName($kokai) {
		$kokai_list = $kokai->find('all', array(
				'fields' => array(
						'koukaicd',
						'koukainm'),
				'conditions'=>array(
						'MKoukai.fromdt <=' =>$this->Common->getSystemDate(),
						'MKoukai.todt >=' =>$this->Common->getSystemDate()),
				'order'=>array(
						'MKoukai.hyojino' => 'ASC',
						'MKoukai.koukaicd' => 'DESC')));
		return $kokai_list;
	}
	/**
	 *分類を取得する。
	 **/
	public function getbunruiName($MBunrui) {
		$bunruiarr = $MBunrui->find('all',  array(
									'fields' => array('CONCAT(MBunrui.bunruicd, "&&", MBunrui.fromdt, "&&", MBunrui.todt) AS bunruicd','bunruinm'),
									'order'=>array('MBunrui.hyojino' => 'ASC',
												'MBunrui.bunruicd' => 'ASC')));
		$bunruiarrval =  array();
		for ($i=0; $i < count($bunruiarr) ; $i++) {
			$bunruiarrval[$bunruiarr[$i][0]['bunruicd']] = $bunruiarr[$i]['MBunrui']['bunruinm'];
		}
		return $bunruiarrval;
	}
	/**
	 *分類を取得する。
	 **/
	public function getbunruiNameList($MBunrui) {
		$bunruiarr = $MBunrui->find('list',  array(
									'fields' => array('bunruicd','bunruinm'),
									'conditions'=>array(
											'MBunrui.fromdt <=' =>$this->Common->getSystemDate(),
											'MBunrui.todt >=' =>$this->Common->getSystemDate()),
									'order'=>array('MBunrui.hyojino' => 'ASC',
												'MBunrui.bunruicd' => 'ASC')));
		return $bunruiarr;
	}
	/**
	 * 画面名：ダウンロード
	 * 機能名： カテゴリ名称の取得
	 */
	public function getCategoryName($MDlcate) {
		// カテゴリの一覧
		$mdlcate = $MDlcate->find('list', array(
										'fields' => array('arno','dlcatenm'),
										'conditions'=>array('MDlcate.koukaikbn' => 0),
										'order'=>array('MDlcate.hyojino' => 'ASC')));
		return $mdlcate;
	}
	/**
	 * 画面名：ダウンロード
	 * 機能名： カテゴリ名称の取得
	 */
	public function getCategoryNameall($MDlcate) {
		// カテゴリの一覧
		$mdlcate = $MDlcate->find('list', array(
										'fields' => array('arno','dlcatenm'),
										'order'=>array('MDlcate.hyojino' => 'ASC')));
		return $mdlcate;
	}
	public function getCategoryNameallajax($MDlcate) {
		// カテゴリの一覧
		$mdlcatearr = $MDlcate->find('all', array('fields' => array('hyojino','arno','dlcatenm'),
												'order'=>array('MDlcate.hyojino' => 'ASC')));
		$mdlcatearrval =  array();
		for ($i=0; $i < count($mdlcatearr) ; $i++) {
			$mdlcatearrval[$mdlcatearr[$i]['MDlcate']['hyojino']] = $mdlcatearr[$i]['MDlcate']['arno']."##".$mdlcatearr[$i]['MDlcate']['dlcatenm'];
		}
		return $mdlcatearrval;
	}
	/**
	 * 画面名：クラブ情報
	 * 機能名： クラブ名称の取得
	 */
	public function getClubName($MKurabu) {
		// クラブの一覧
		$mkurabu = $MKurabu->find('list', array(
										'fields' => array('kurabucd','kurabunm'),
										'conditions'=>array(
												'MKurabu.fromdt <=' => $this->Common->getSystemDate(),
												'MKurabu.todt >=' => $this->Common->getSystemDate()),
										'order'=>array('hyojino' => 'ASC')));
		return $mkurabu;
	}
	public function getcommittee($MIinkai) {
		//委員会名称一覧
		$miinkai = $MIinkai->find('list', array(
										'fields' => array('iinkaicd','iinkainm'),
										'conditions'=>array(
												'MIinkai.fromdt <=' => $this->Common->getSystemDate(),
												'MIinkai.todt >=' => $this->Common->getSystemDate()),
										'order'=>array('MIinkai.hyojino' => 'ASC')));
		return $miinkai;
	}
	/**
	 * 画面名：出欠情報
	 * 機能名： 会員名称の取得
	 */
	public function getKaiinsbList($MKaiinsb) {
		// カテゴリの一覧
		$kaiinsbnm = $MKaiinsb->find('list', array(
										'fields' => array('kaiinsbcd','kaiinsbnm'),
										'conditions'=>array(
												'MKaiinsb.fromdt <=' => $this->Common->getSystemDate(),
												'MKaiinsb.todt >=' => $this->Common->getSystemDate()),
										'order'=>array('kaiinsbcd' => 'ASC')));
		return $kaiinsbnm;
	}
	/**
	 * 
	 * 画面名：倶楽部詳細
	 * 機能名： メール送信専用アドレスの取得
	 */
	public function getClubMailInfo($MKurabu, $kurabucd) {
		// 倶楽部メイルの一覧
		$clubmailInfo = $MKurabu->find('all', array(
				'fields' => array(
						'MKurabu.mailaddr'),
				'conditions' => array(
						'MKurabu.kurabucd' => $kurabucd, 
						'MKurabu.fromdt <=' => $this->Common->getSystemDate(),
						'MKurabu.todt >=' => $this->Common->getSystemDate())));
		return $clubmailInfo;
	} 
	/**
	 * 
	 * 画面名：出欠情報（イベント）
	 * 機能名：活動分類の取得
	 */
	public function getActivity($MKbunrui) {
		$kbunruinm = $MKbunrui->find('list', array(
										'fields' => array('kbunruicd','kbunruinm'),
										'conditions'=>array('bunruicd' => 2,
															'MKbunrui.fromdt <=' => $this->Common->getSystemDate(),
															'MKbunrui.todt >=' => $this->Common->getSystemDate()),
										'order'=>array('kbunruicd' => 'ASC')));
		return $kbunruinm;
	}
	
	/**
	 * 
	 * 画面名：出欠情報（会議）
	 * 機能名：組織情報の取得
	 */
	public function getActivityKaigi($MSosiki) {
		$sosikinm = $MSosiki->find('list', array(
										'fields' => array('sosikicd','sosikinm'),
										'conditions'=>array(
													'MSosiki.fromdt <=' => $this->Common->getSystemDate(),
													'MSosiki.todt >=' => $this->Common->getSystemDate()),
										'order'=>array('hyojino' => 'ASC')));
		return $sosikinm;
	}

	/**
	 * 
	 * 画面名：倶楽部の紹介
	 * 機能名： メール送信会社名
	 */
	public function getKaishannm($request) {
		// 倶楽部メイルの一覧
		$clubmailInfo = $MKurabu->find('all', array(
				'fields' => array(
						'MKurabu.mailaddr'),
				'conditions' => array(
						'MKurabu.kurabucd' => $kurabucd, 
						'MKurabu.fromdt <=' => $this->Common->getSystemDate(),
						'MKurabu.todt >=' => $this->Common->getSystemDate())));
		return $clubmailInfo;
	} 

	/**
	 * 画面名：ＰＲ商品情報
	 * 機能名： ＰＲ商品名称の取得
	 */
	public function getTPrtantouName($TPrtantou,$kaisyacd) {
		$TPrtantou_list = $TPrtantou->find('list', array(
				'fields' => array(
						'arno',
						'tantounm'),
				'conditions' => array(
						'TPrtantou.kaisyacd' => $kaisyacd),
				'order' => array(
						'arno' => 'ASC')));
		return $TPrtantou_list;
	}
}
