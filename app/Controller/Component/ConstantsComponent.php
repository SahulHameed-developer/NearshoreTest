<?php
App::uses ( 'Component', 'Controller' );
class ConstantsComponent extends Component {
	
	/**
	 * 活動分類コード
	 */
	public $KENSHUKAI = '001';		// ［001:研修会］
	public $KENGAKUKAI = '002';		// ［002:見学会］
	public $KOUENKAI = '003';		// ［003:講演会］
	public $KOURYUUIBENTO = '008';	// ［008:交流イベント］
	public $JINZAIIKUSEI = '011';	// ［011:人材育成塾］
	
	/**
	 * 分類コード
	 */
	public static $KAIGI_CD = '1';			// ［1:会議］
	public static $EVENT_CD = '2';			// ［2:イベント］
	
	/**
	 * 会員種別コード
	 */
	public $SEIKAIIN = '01';		// ［01:正会員］
	
	
	/**
	 * 公開区分
	 */
	public $KOKAI = '0';			// ［0：公開］
	public $HIKOKAI = '1';			// ［1:非公開］
	
	
	/**
	 * ファイル情報・写真情報の分類
	 */
	public $KATUDO = '1';			// [1：活動]
	public $KAISYA = '2';			// [2：会社]
	public $OSHIRASE = '3'; 		// [3：お知らせ]
	public $DOWNLOAD = '4';         // [4：ダウンロード] （ファイル情報のみ）
	public $COMMITTEEINFO = '4';    // [4：委員会] （写真情報のみ）
	public $CLUBINFO = '5';         // [5：倶楽部] （写真情報のみ）
	public $YUEKIFILE = '5'; 		// [5：有益ファイル]
	public $YUEKI = '6'; 			// [6：有益]
	public $PRSYOHIN = '7'; 		// [7：PR商品情報]
	
	/**
	 * 会員区分
	 */
	public $KAIIN = '0';			// [0：会員]
	public $HIKAIIN = '1';			// [1：非会員]


	/**
	 * 管理者区分
	 */
	public $SYS_IPPAN= '00';			// [00:一般]
	public $SYS_KANRISHA= '90';			// [90：システム管理者]
	public $SYS_SUPER_KANRISHA= '95';	// [95：システム管理者]
	

	/**
	 * 権限情報
	 */
	public $KENGEN_NO= '0';			// [0：権限無し]
	public $KENGEN_YES= '1';			// [1：権限有り]


	/**
	 * 公開ページ：お知らせ一覧のMAX件数表示
	 */
	public $OSIRASE_MAX_REC_DISPLAY = '8';


	/**
	 * 入会申込書のパス・ファイル名
	 */
	public $FILEPATH = '/files/Join/About/excel/入会申込書.xlsx';
	public $FILENAME = '入会申込書.xlsx';


	/**
	 * お知らせのアップロードファイルパス
	 */
	public $OSIRASE_FILE_PATH = '/files/News/';
	public $OSIRASE_FULL_FILE_PATH = 'app/webroot/files/News/';


	/**
	 * DLファイルパス
	 */
	public $DL_FILE_PATH = '/files/DLFiles/';
	public $DL_FULL_FILE_PATH = 'app/webroot/files/DLFiles/';


	/**
	 * 有益情報のアップロードファイルパス
	 */
	public $YUEKI_FILE_PATH = '/files/Beneficial/';
	public $YUEKI_FULL_FILE_PATH = 'app/webroot/files/Beneficial/';


	/**
	 * 通知先マスタデータ：事前に必ず登録しておくレコード
	 */
	public $SOSIKICD_KOTEI= '00';	// 組織コード
	public $BUNRUICD_KOTEI= '0';	// 分類コード
	public $KBUNRUICD_KOTEI= '000';	// 活動分類コード
	
	// 公開区分の初期表示のセット
	public $INVAL ='1';
	
	// 婚姻区分の初期表示のセット
	public $KAITO ='0';
	/**
	 * 性別
	 */
	public $SEIBETSU = array('male' => array("value"=> 1, "label"=>"男性"), 'female' => array("value"=> 2, "label"=>"女性"));

	// 会員
	public $KAIIN_VAL = '会員';

	// 公開区分
	public $KOUKAIKBN = '公開';

	// 非会員
	public $HIKAIIN_VAL = '非会員';
	
	// 登録名
	public $SYSTEM = 'System';

	// 管理画面メニュー表示項目
	public $HYOJI= 'display';
	
	// 更新
	public $UPDATE ='update';
	
	// 登録
	public $INSERT ='insert';
	
	// 初期
	public $INITIAL ='initial';
	
	// 検索
	public $SEARCH ='search';

	//コードマスタテーブルの順序番号
	public $M_BUNRUI_VAL  	= 1;
	public $M_SOSIKI_VAL  	= 2;
	public $M_KBUNRUI_VAL 	= 3;
	public $M_KAIINSB_VAL 	= 4;
	public $M_IINKAI_VAL 	= 5;
	public $M_KURABU_VAL 	= 6;
	public $M_KYAKU_VAL   	= 7;
	public $M_IYAKU_VAL   	= 8;
	public $M_KRYAKU_VAL   	= 9;
	public $M_YKBUNRUI_VAL  = 10;
	public $M_SYUMI_VAL   	= 11;
	public $M_GYOSYU_VAL  	= 12;
	public $M_KONIN_VAL   	= 13;
	public $M_KOUKAI_VAL  	= 14;
	public $M_TODOFUKEN_VAL = 15;
	public $M_KEIYAKU_VAL = 16;

	//モデル名称配列
	public $MODEL_NM = array('MBunrui','MSosiki','MKbunrui','MKaiinsb','MIinkai','MKurabu','MKyaku','MIyaku','MKryaku','MYkbunrui','MSyumi', 'MGyosyu','MKonin','MKoukai','MTodofuken','MKeiyaku');
	//テーブル名称配列
	public $TABLE_NM = array('m_bunrui','m_sosiki','m_kbunrui','m_kaiinsb','m_iinkai','m_kurabu','m_kyaku','m_iyaku','m_kryaku','m_ykbunrui','m_syumi', 'm_gyosyu','m_konin','m_koukai','m_todofuken','m_keiyaku');
	//コード名称配列
	public $TABLE_CD_NM = array('bunruicd','sosikicd','kbunruicd','kaiinsbcd','iinkaicd','kurabucd','kyoukaiykcd','iinkaiykcd','iinkaiykcd','yakuincd','syumicd', 'gyosyucd','konincd','koukaicd','todofukencd','keiyakucd');
	//名称の名配列
	public $TABLE_NM_NAME = array('bunruinm','sosikinm','kbunruinm','kaiinsbnm','iinkainm','kurabunm','kyoukaiyknm','iinkaiyknm','iinkaiyknm','yakuinnm','syuminm', 'gyosyunm','koninnm','koukainm','todofukennm','keiyakunm');

	//テーブル名称
	public $T_KAIGIEV_TBL_NM = 't_kaigiev';
	public $T_KATUDO_TBL_NM = 't_katudo';
	public $T_KAIIN_TBL_NM = 't_kaiin';
	public $T_OSIRASE_TBL_NM = 't_osirase';
	public $T_TOIAWASE_TBL_NM = 't_toiawase';
	public $T_NYUUKAI_TBL_NM = 't_nyuukai';
	public $T_KAISYA_TBL_NM = 't_kaisya';
	public $T_IINKAI_TBL_NM = 't_iinkai';
	public $T_KURABU_TBL_NM = 't_kurabu';
	public $T_PRKYRIREKI_TBL_NM = 't_prkyrireki';
	public $T_PRKEIYAKU_TBL_NM = 't_prkeiyaku';

	//モデル名称
	public $T_KAIGIEV_MDL_NM = 'TKaigiev';
	public $T_KATUDO_MDL_NM = 'TKatudo';
	public $T_KAIIN_MDL_NM = 'TKaiin';
	public $T_OSIRASE_MDL_NM = 'TOsirase';
	public $T_TOIAWASE_MDL_NM = 'TToiawase';
	public $T_NYUUKAI_MDL_NM = 'TNyuukai';
	public $T_KAISYA_MDL_NM = 'TKaisya';
	public $T_IINKAI_MDL_NM = 'TIinkai';
	public $T_KURABU_MDL_NM = 'TKurabu';
	public $T_PRKYRIREKI_MDL_NM = 'TPrkyrireki';
	public $T_PRKEIYAKU_MDL_NM = 'TPrkeiyaku';

	//テーブルコード名称
	public $M_BUNRUI_BUNRUICD = 'bunruicd';
	public $M_SOSIKI_SOSIKICD = 'sosikicd';
	public $M_KAIINSB_KAIINSBCD = 'kaiinsbcd';
	public $M_KYAKU_KYOUKAIYKCD = 'kyoukaiykcd';
	public $M_IYAKU_IINKAIYKCD = 'iinkaiykcd';
	public $M_SYUMI_SYUMICD1 = 'syumicd1';
	public $M_SYUMI_SYUMICD2 = 'syumicd2';
	public $M_SYUMI_SYUMICD3 = 'syumicd3';
	public $M_GYOSYU_GYOSYUCD = 'gyosyucd';
	public $M_KONIN_KONIN = 'konin';
	public $M_KOUKAI_KOUKAIKBN = 'koukaikbn';
	public $T_KAIIN_UMARE = 'umare';
	public $T_KAIIN_SODATI = 'sodati';
	public $T_IINKAI_IINKAICD = 'iinkaicd';
	public $T_KURABU_KURABUCD = 'kurabucd';
	public $T_PRKYRIREKI_KYKBN = 'kykbn';
	public $T_PRKEIYAKU_KYKBN = 'kykbn';

	// 検索結果は０件の場合。
	public $SEARCH_NOT_FOUND ='検索条件に合致するデータがありません。';


	//会員情報テーブルの委員会役職コード 
	public $T_KAIIN_IINKAIYKCD = "01";

	//申込情報テーブルの会員区分
	public $T_ENTRY_KAIINKBN = "1";

	// 悪用と悪意のあるメールアドレスとIPアドレス
	public static $RESTRICT_MAIL_ADDR = "sample@email.tst";
	public static $RESTRICT_IP_ADDR = array('45.41.181.213');
}