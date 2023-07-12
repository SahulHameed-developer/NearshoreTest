<?php
App::uses ( 'Component', 'Controller' );
class ConstantsComponent extends Component {
	
	// 登録名
	public $SYSTEM = 'System';
	
	/**
	 * 写真情報の分類
	 */
	public $PRSYOHIN = '7'; 			// [7：PR商品情報]
	
	/**
	 * 公開区分
	 */
	public $KOKAI = '0';			// ［0：公開］
	public $HIKOKAI = '1';			// ［1:非公開］

	/**
	 * スライド表示区分
	 */
	public $SLIDE_YES= '0';			// [0：スライド表示対象]
	public $SLIDE_NO= '1';			// [1：スライド表示対象外]

	/**
	 * 通知先マスタデータ：事前に必ず登録しておくレコード
	 */
	public $SOSIKICD_KOTEI= '00';	// 組織コード
	public $BUNRUICD_KOTEI= '0';	// 分類コード
	public $KBUNRUICD_KOTEI= '000';	// 活動分類コード

	// 検索
	public $SEARCH ='search';

	// 公開区分の初期表示のセット
	public $INVAL ='1';
	
	// 悪用と悪意のあるメールアドレスとIPアドレス
	public static $RESTRICT_MAIL_ADDR = "sample@email.tst";
	public static $RESTRICT_IP_ADDR = array('45.41.181.213');

}