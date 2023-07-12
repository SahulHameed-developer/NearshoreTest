<?php
/**
 *
 * @projectName:
 * @ModuleName:
 * @author:
 * @createDate:     
 * @version:   
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 */
App::uses('Helper', 'View');

class ConstantsHelper extends Helper {
	
	// Activity コントローラ名
	public $ACTIVITY_CTL = 'activity';
	
	// Homeページ コントローラ名
	public $TOP_CTL = 'top';
	
	// About コントローラ名
	public $ABOUT_CTL = 'about';
	
	// Members コントローラ名
	public $MEMBERS_CTL = 'members';
	
	// Join コントローラ名
	public $JOIN_CTL = 'join';
	
	// Privacy コントローラ名
	public $PRIVACY_CTL = 'privacy';
	
	// News コントローラ名
	public $NEWS_CTL = 'news';

	// Beneficial コントローラ名
	public $BENEFICIAL_CTL = 'Beneficial';

	// Admin コントローラ名
	public $ADMIN_CTL = 'admin';
	
	// contact コントローラ名
	public $CONTACT_CTL = 'contact';

	// adminActivity コントローラ名
	public $ADMINACTIVITY_CTL = 'adminActivity';
	
	// Indexは、Activityコントローラのアクション名
	public $INDEX_ACT = 'index';
	
	// Detailは、Activity, Newsコントローラのアクション名
	public $DETAIL_ACT = 'detail';
	public $CANCEL_ACT = 'cancelActivity';

	// KaigiDetailは、Activity,
	public $KAIGIDETAIL_ACT = 'Kaigidetail';
	
	// Searchは、Activityコントローラのアクション名
	public $SEARCH_ACT = 'search';
	
	// Organizationは、Aboutコントローラのアクション名
	public $ORGANIZATION_ACT = 'organization';
	
	// Messageは、Aboutコントローラのアクション名
	public $MESSAGE_ACT = 'message';
	
	// Executiveは、Aboutコントローラのアクション名
	public $EXECUTIVE_ACT = 'executive';
	
	// Statuteは、Aboutコントローラのアクション名
	public $STATUTE_ACT = 'statute';
	
	// reportIndexは、Activityコントローラのアクション名
	public $REPORTINDEX_ACT = 'reportIndex';
	
	public $REPORTSEARCH_ACT = 'reportSearch';
	
	// reportDetailは、Activityコントローラのアクション名
	public $REPORTDETAIL_ACT = 'reportDetail';
	
	// Entryは、Joinコントローラのアクション名
	public $ENTRY_ACT = 'entry';
	
	// Confirmは、Joinコントローラのアクション名
	public $CONFIRM_ACT = 'confirm';
	
	// Finishは、Joinコントローラのアクション名
	public $FINISH_ACT = 'finish';
	
	// Aboutは、Activityコントローラのアクション名
	public  $ABOUT_ACT = 'about';
	
	// accessは、Aboutコントローラのアクション名
	public $ACCESS_ACT = 'access';
	
	// faqは、 Joinコントローラのアクション名
	public $FAQ_ACT = 'faq';
	
	// homeは、 Adminコントローラのアクション名
	public $HOME_ACT = 'home';
	
	// Searchは、Activityコントローラのアクション名
	public $MAILSEARCH_ACT = 'mailSearch';
	
	// 公開区分
	public $KOUKAIKBN = '公開';
	
	// 公開区分
	public $HIKOUKAIKBN = '非公開';
	
	// 正会員
	public $SEIKAIIN = '01';
	
	// 準会員
	public $JUNKAIIN = '02';

	// 管理画面メニュー表示項目
	public $HYOJI= 'display';
	
	// 初期
	public $INITIAL ='initial';
	
	// 検索
	public $SEARCH ='search';
	
	public $ADMINMEMBER = 'adminMember';

	//管理者区分
	public $SYS_IPPAN= '00';			// [00:一般]
	public $SYS_KANRISHA= '90';			// [90：システム管理者]
	public $SYS_SUPER_KANRISHA= '95';	// [95：システム管理者]

	// download コントローラ名
	public $DOWNLOAD_CTL = 'download';

	// committee コントローラ名
	public $COMMITTEE_CTL = 'committee';

	// club コントローラ名
	public $CLUB_CTL = 'club';

	// banner コントローラ名
	public $BANNER_CTL = 'banner';

	//出欠情報
	public $SYUKKETU_SANYO_KBN = "1";


}
