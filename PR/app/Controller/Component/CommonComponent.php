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
}
