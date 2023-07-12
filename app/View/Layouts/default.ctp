<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="">
		<meta name="format-detection" content="address=no,email=no,telephone=no">
		<!-- OGP -->
		<meta property="og:type" content="website">
		<meta property="og:image" content="">
		<meta property="og:description" content="">
		<meta property="og:locale" content="ja_JP">
		
		<!-- script -->
		<!-- script/jquery -->
		<?= $this->Html->script('common/jquery.min.js') ?>
		<!-- script/common -->
		<?= $this->Html->script('common/common.js') ?>
		<?php $curtime = "?time=".date('dmYHis'); ?>
		
		<?php if (strtolower($this->Common->getController()) == strtolower($this->Constants->TOP_CTL)) {?>
			<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
			<meta property="og:title" content="一般社団法人ニアショアＩＴ協会">
			<meta property="og:url" content="/">
			<title>一般社団法人ニアショアＩＴ協会</title>
		<?php } elseif (strtolower($this->Common->getController()) == strtolower($this->Constants->ACTIVITY_CTL)) {?>
			<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->SEARCH_ACT)) {?>
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:title" content="活動カレンダー一覧｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/event/">
				<title>活動カレンダー一覧｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>	
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:title" content="活動カレンダー詳細｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/event/">
				<title>活動カレンダー詳細｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>	
				<meta property="og:title" content="イベント申込｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/entry/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title><?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
												echo "会議出席連絡｜ニアショアＩＴ協会";
											} else {
												echo "イベントお申し込み｜ニアショアＩＴ協会";
											} ?></title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>	
				<meta property="og:title" content="イベント申込入力内容確認｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/entry/confirm.html">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title><?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
												echo "会議出席連絡入力内容確認｜ニアショアＩＴ協会";
											} else {
												echo "イベント申込入力内容確認｜ニアショアＩＴ協会";
											} ?></title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
				<meta property="og:title" content="イベント申込完了｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/entry/finish.html">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title><?php if ($_SESSION["activity"]["bunruicd"] == ConstantsComponent::$KAIGI_CD) {
												echo "会議出席連絡完了｜ニアショアＩＴ協会";
											} else {
												echo "イベント申込完了｜ニアショアＩＴ協会";
											} ?></title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTINDEX_ACT) ||
					strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTSEARCH_ACT)) {?>
				<meta property="og:title" content="活動報告一覧｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/report/">
				<title>活動報告一覧｜一般社団法人ニアショアＩＴ協会</title>			
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTDETAIL_ACT)) {?>
				<meta property="og:title" content="活動カ報告詳細｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/report/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>活動カ報告詳細｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:title" content="活動概要｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/activity/about/">
				<title>活動概要｜一般社団法人ニアショアＩＴ協会</title>
			<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL) && strtolower($this->Common->getAction()) == strtolower($this->Constants->ORGANIZATION_ACT)) {?>
			<meta property="og:title" content="組織図｜一般社団法人ニアショアＩＴ協会">
			<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
			<meta property="og:url" content="/about/organization/">
			<title>組織図｜一般社団法人ニアショアＩＴ協会</title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL)) {?>
			<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->MESSAGE_ACT)) {?>
				<meta property="og:site_name" content="｜">
				<meta property="og:title" content="ご挨拶｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="">
				<title>ご挨拶｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->EXECUTIVE_ACT)) {?>
				<meta property="og:title" content="役員紹介｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/about/executive/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>役員紹介｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->STATUTE_ACT)) {?>
				<meta property="og:title" content="定款｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/about/statute/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>定款｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ACCESS_ACT)) {?>
				<meta property="og:title" content="アクセス｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/about/access/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>アクセス｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:title" content="協会概要｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/about/outline/">
				<title>協会概要｜一般社団法人ニアショアＩＴ協会</title>	
			<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->MEMBERS_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
				<meta property="og:title" content="会員企業詳細｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/members/">
				<title>会員企業詳細｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:title" content="会員企業一覧｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/members/">
				<title>会員企業一覧｜一般社団法人ニアショアＩＴ協会</title>
			<?php }?>
			<?= $this->html->css('members/style.css') ?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->JOIN_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
				<meta property="og:title" content="入会申込｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/join/entry">
				<title>入会申込｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
				<meta property="og:title" content="入会申込入力内容確認｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/join/entry/confirm">
				<title>入会申込入力内容確認｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
				<meta property="og:title" content="入会申込完了｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/join/entry/finish">
				<title>入会申込完了｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ABOUT_ACT)) {?>
				<meta property="og:title" content="入会について｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/join/about/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>入会について｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:title" content="FAQ（よくある質問）｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/join/faq/">
				<title>よくあるご質問（FAQ）｜一般社団法人ニアショアＩＴ協会</title>
			<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->PRIVACY_CTL)) {?>
			<meta property="og:title" content="個人情報の取り扱いについて｜一般社団法人ニアショアＩＴ協会">
			<meta property="og:url" content="/privacy/">
			<title>個人情報の取り扱いについて｜一般社団法人ニアショアＩＴ協会</title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->NEWS_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
				<meta property="og:title" content="お知らせ詳細のタイトル｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/news/details/170000/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>お知らせ詳細のタイトル｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:title" content="お知らせ一覧｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/news/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>お知らせ一覧｜一般社団法人ニアショアＩＴ協会</title>
			<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BENEFICIAL_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
				<meta property="og:title" content="有益情報詳細のタイトル｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/Beneficial/details/170000/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>有益情報詳細のタイトル｜一般社団法人ニアショアＩＴ協会</title>
			<?php } else {?>
				<meta property="og:title" content="有益情報一覧｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:url" content="/Beneficial/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>有益情報一覧｜一般社団法人ニアショアＩＴ協会</title>
			<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CONTACT_CTL)) {?>
				<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
					<meta property="og:title" content="お問い合わせ｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/contact/">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<title>お問い合わせ｜一般社団法人ニアショアＩＴ協会</title>				
				<?php } elseif(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
					<meta property="og:title" content="お問い合わせ入力内容確認｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/contact/confirm.html">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<title>お問い合わせ入力内容確認｜一般社団法人ニアショアＩＴ協会</title>				
				<?php } elseif(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
						<meta property="og:title" content="お問い合わせ完了｜一般社団法人ニアショアＩＴ協会">
						<meta property="og:type" content="website">
						<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
						<title>お問い合わせ完了｜一般社団法人ニアショアＩＴ協会</title>	
				<?php	} ?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->DOWNLOAD_CTL)) {?>
				<meta property="og:title" content="ダウンロード｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:type" content="website">
				<meta property="og:url" content="/about/outline/">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>ダウンロード｜一般社団法人ニアショアＩＴ協会</title>		
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->COMMITTEE_CTL)) {?>
				<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
					<meta property="og:title" content="委員会詳細｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/about/outline/">
					<title><?php echo $this->Session->read ( 'titlename'); ?>｜一般社団法人ニアショアＩＴ協会</title>
				<?php } else {?>
					<meta property="og:title" content="委員会の紹介｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/about/outline/">
					<title>委員会の紹介｜一般社団法人ニアショアＩＴ協会</title>
				<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CLUB_CTL)) {?>
				<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
					<meta property="og:title" content="CIMA研究会｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/about/outline/">
					<title><?php echo $this->Session->read ( 'titlename'); ?>｜一般社団法人ニアショアＩＴ協会</title>
				<?php } else { ?>
					<meta property="og:title" content="倶楽部の紹介｜一般社団法人ニアショアＩＴ協会">
					<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
					<meta property="og:url" content="/about/outline/">
					<title>倶楽部の紹介｜一般社団法人ニアショアＩＴ協会</title>
				<?php }?>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BANNER_CTL)) {?>
				<meta property="og:title" content="ニアショアIT協会バナー｜一般社団法人ニアショアＩＴ協会">
				<meta property="og:type" content="website">
				<meta property="og:url" content="/membermenu/banner">
				<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
				<title>ニアショアIT協会バナー｜一般社団法人ニアショアＩＴ協会</title>		
		<?php } ?> 
		
		<!-- style -->
		<!-- style/common -->
		 <?= $this->Html->css('common/common.css') ?>

		<!-- webfont -->
		<link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css"
			rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Istok+Web"
			rel="stylesheet">

		<!--[if lt IE 9]><script src="./common/js/html5shiv.js"></script><![endif]-->
		<!--[if lt IE 9]><script src="./common/js/selectivizr.min.js"></script><![endif]-->
	<?php include APP.'View'.DS.'Elements'.DS.'analyticstracking.php'; ?>
</head>
<body id="top">
	<?php if (strtolower($this->Common->getController()) == strtolower($this->Constants->ACTIVITY_CTL)) {?>
		<!-- 活動コントローラの条件 -->
		
		<!-- 活動コントローラのアクションの条件 -->
		<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTINDEX_ACT) ||
				strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTSEARCH_ACT)) {?>
			<div id="wrap" class="activity_wrap report_contents">
		<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTDETAIL_ACT)) {?>
			<div id="wrap" class="activity_wrap reprot_detail_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ABOUT_ACT)) {?>
			<div id="wrap" class="activity_wrap about_contents">
		<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
			<div id="wrap" class="activity_wrap entry_contents">
		<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
			<div id="wrap" class="activity_wrap confirm_contents">
		<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
			<div id="wrap" class="activity_wrap finish_contents">
		<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)
					|| strtolower($this->Common->getAction()) == strtolower($this->Constants->KAIGIDETAIL_ACT)) {?>
			<div id="wrap" class="activity_wrap event_detail_contents">
		<?php } else if (strtolower($this->Common->getAction()) == $this->Constants->INDEX_ACT) {?>
			<div id="wrap" class="activity_wrap event_contents">
		<?php } else {?>
			<div id="wrap" class="activity_wrap event_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->MEMBERS_CTL)) {?>
			<!-- メンバーコントローラの条件 -->
			
			<!-- メンバーコントローラのアクションの条件 -->
		<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX_ACT) || 
				strtolower($this->Common->getAction()) == strtolower($this->Constants->SEARCH_ACT)) {?>
				<div id="wrap" class="members_wrap members_contents">
		<?php } else {?>
				<div id="wrap" class="members_wrap members_detail_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL)) {?>
		<!--Aboutコントローラの条件  -->
		
		<!-- Aboutコントローラのアクションの条件-->
		<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->MESSAGE_ACT)) {?>
			<div id="wrap" class="about_wrap message_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->EXECUTIVE_ACT)) {?>
			<div id="wrap" class="about_wrap executive_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->STATUTE_ACT)) {?>
			<div id="wrap" class="about_wrap statute_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ACCESS_ACT)) {?>
			<div id="wrap" class="about_wrap access_contents">
		<?php } else {?>
			<div id="wrap" class="about_wrap outline_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->JOIN_CTL)) {?>
		<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
			<div id="wrap" class="join_wrap entry_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
			<div id="wrap" class="join_wrap confirm_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
			<div id="wrap" class="join_wrap finish_contents">
		<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ABOUT_ACT)) {?>
			 <div id="wrap" class="join_wrap about_contents">
		<?php } else {?>
			<div id="wrap" class="join_wrap faq_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->PRIVACY_CTL)) {?>
			<div id="wrap" class="praivacy_wrap privacy_contents">
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->NEWS_CTL)) {?>
		<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
			<div id="wrap" class="news_wrap news_detail_contents">
		<?php } else {?>
			<div id="wrap" class="news_wrap news_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BENEFICIAL_CTL)) {?>
		<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
			<div id="wrap" class="beneficial_wrap beneficial_detail_contents">
		<?php } else {?>
			<div id="wrap" class="beneficial_wrap beneficial_contents">
		<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CONTACT_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
				<div id="wrap" class="contact_wrap entry_contents">
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
				<div id="wrap" class="contact_wrap confirm_contents">
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
				  <div id="wrap" class="contact_wrap finish_contents">
			<?php }?>
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->DOWNLOAD_CTL)) {?>
			<div id="wrap" class="membermenu_wrap download_contents">
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->COMMITTEE_CTL)) {?>
			<div id="wrap" class="membermenu_wrap download_contents">
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CLUB_CTL)) {?>
			<div id="wrap" class="membermenu_wrap download_contents">
	<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BANNER_CTL)) {?>
			<div id="wrap" class="membermenu_wrap download_contents">
	<?php } else{?>
			<div id="wrap">
	<?php }?>
	<header id="header">
		<div class="title_description pc_contents">
			<strong class="frame user_dtl">ニアショアＩＴ協会はＩＣＴへの需要を取りまとめ、国内の地方でＩＣＴ関連の事業を営む中小企業への受注活動を支援します。
			<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
				<span id="userNamedisplay" style="float: right;"><?php echo $_SESSION['Auth']['User']['TKaiin']['kaiinnm']."　".'様'; ?></span>
			<?php } ?>
			</strong>
		</div><!-- /.title_description -->
		<div class="sp_header_inner sp_contents clearfix frame">
			<p class="logo">
						<?php echo $this->Html->image('common/logo.png', ['url' => ['controller' => 'top','action' => 'index']], array (
								'alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会' 
						));?>
			</p><!-- /.logo -->

		<div data-target="menu01" class="menu modal-open">
			<div class="menu-default"><?php echo $this->Html->image('common/sp/menu_btn.png', array('alt' => 'メニュー'));?></div><!-- /.menu-default -->
		</div><!-- /.menu -->

		<nav id="menu01" class="modal-content clearfix">
			<p class="close_top"><a class="modal-close"><?php echo $this->Html->image('common/sp/menu_btn_close.png', array('alt' => '閉じる'));?></a></p>
			<ul>
				<li>
					<a href="<?php echo $this->base;?>/lp01/index.html" target="_blank">発注をお考えの企業様</a>
				</li>
				<li>
					<a href="<?php echo $this->base;?>/lp02/index.html" target="_blank">受注をご希望の企業様</a>
				</li>
				<?php if(!isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
					<li><?php echo $this->Html->link("会員ログイン", array('controller' => 'login','action'=> 'index'));?></li>
				<?php } else { ?>
					<li><?php echo $this->Html->link("ログアウト", array('controller' => 'login','action'=> 'logout'), array('id' => 'logoutLinkMbl'));?></li>
				<?php } ?>
				<li><?php echo $this->Html->link("お知らせ", array('controller' => 'news','action'=> 'index'));?></li>
				<li><a class="nlt">ニアショアIT協会とは</a>
					<ul>
						<li><?php echo $this->Html->link("協会概要", array('controller' => 'about','action'=> 'index'));?></li>
						<li><?php echo $this->Html->link("ご挨拶", array('controller' => 'about','action'=> 'message'));?></li>
						<li><?php echo $this->Html->link("役員紹介", array('controller' => 'about','action'=> 'executive'));?></li>
						<li><?php echo $this->Html->link("組織図", array('controller' => 'about','action'=> 'organization'));?></li>
						<li><?php echo $this->Html->link("アクセス", array('controller' => 'about','action'=> 'access'));?></li>
						<li><?php echo $this->Html->link("定款", array('controller' => 'about','action'=> 'statute'));?></li>
					</ul>
				</li>
				<li><a class="nlt">会員企業</a>
								<ul>
									<li><?php echo $this->Html->link("会員企業一覧", array('controller' => 'members','action'=> 'index'.$curtime));?></li>
									<li><a href="<?php echo $this->base;?>/PR" target="_blank">会員企業ＰＲ</a></li>
								</ul>
				</li>
				<li><a class="nlt">ニアショアIT協会の活動</a>
								<ul>
									<li><?php echo $this->Html->link("活動概要", array('controller' => 'activity','action'=> 'about'));?></li>
									<li><?php echo $this->Html->link("活動カレンダー", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
									<li><?php echo $this->Html->link("活動報告", array('controller' => 'activity','action'=> 'reportIndex'.$curtime));?></li>
								</ul>
				</li>
				<li><a class="nlt">入会のご案内</a>
								<ul>
									<li><?php echo $this->Html->link("入会について", array('controller' => 'join','action'=> 'about'));?></li>
									<li><?php echo $this->Html->link("入会のお申し込みー", array('controller' => 'join','action'=> 'entry'));?></li>
									<li><?php echo $this->Html->link("よくあるご質問", array('controller' => 'join','action'=> 'faq'));?></li>
								</ul>
				</li>
				<li><a class="nlt">お問い合わせ</a>
								<ul>
									<li><?php echo $this->Html->link("事務局へお問い合わせ", array('controller' =>'contact','action'=> 'entry'));?></li>
								</ul>
				</li>
				<li><?php echo $this->Html->link("個人情報の取り扱いについて", array('controller' => 'privacy','action'=> 'index'));?></li>
				<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
				<li id="kaiinmenuMbl"><a class="nlt">会員メニュー</a>
								<ul class="urltargetcls">
									<li><?php echo $this->Html->link("情報更新", array(), array('id'=>'kaiinmenuMobile','onclick'=>'return login(this.id);')); ?></li>
									<li><?php echo $this->Html->link("ダウンロード", array('controller' => 'download','action'=> 'index'));?></li>
									<li><?php echo $this->Html->link("委員会の紹介", array('controller' => 'Committee','action'=> 'index'));?></li>
									<li><?php echo $this->Html->link("倶楽部の紹介", array('controller' => 'Club','action'=> 'index'));?></li>
									<li><?php echo $this->Html->link("有益情報一覧", array('controller' => 'Beneficial','action'=> 'index'));?></li>
									<li><?php echo $this->Html->link("案件管理システム", 'http://anken.nearshore-it.jp/', array('target' => '_blank'));?></li>
									<li><?php echo $this->Html->link("ニアショアIT協会バナー", array('controller' => 'banner','action'=> 'index'));?></li>
								</ul>
				</li>
				<?php } ?>
			</ul>
		</nav>
		</div><!-- /.sp_header_inner -->

		<div class="pc_header_inner pc_contents frame clearfix user_dtl">
			<p class="logo">
					<?php echo $this->Html->image('common/logo.png', ['url' => ['controller' => 'top','action' => 'index']], array (
								'alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会' 
						));?>
			</p><!-- /.logo -->

		<nav>
			<ul id="mega_menu" class="clearfix mt-24">
				<li class="parent_about">
				<?php echo $this->Html->link($this->Html->tag('span', 'ニアショアIT協会とは'), array('controller' => 'about','action'=> 'index'), array('escape'=>false));?>
					<ul>
						<li><?php echo $this->Html->link("協会概要", array('controller' => 'about','action'=> 'index'));?></li>
						<li><?php echo $this->Html->link("ご挨拶", array('controller' => 'about','action'=> 'message'));?></li>
						<li><?php echo $this->Html->link("役員紹介", array('controller' => 'about','action'=> 'executive'));?></li>
						<li><?php echo $this->Html->link("組織図", array('controller' => 'about','action'=> 'organization'));?></li>
						<li><?php echo $this->Html->link("アクセス", array('controller' => 'about','action'=> 'access'));?></li>
						<li><?php echo $this->Html->link("定款", array('controller' => 'about','action'=> 'statute'));?></li>
					</ul>
				</li>

				<li class="parent_members">
					<?php echo $this->Html->link($this->Html->tag('span', '会員企業'), array('controller' => 'members','action'=> 'index'.$curtime), array('escape'=>false));?>
						<ul>
							<li><?php echo $this->Html->link("会員企業一覧", array('controller' => 'members','action'=> 'index'.$curtime));?></li>
							<li><a href="<?php echo $this->base;?>/PR" target="_blank">会員企業ＰＲ</a></li>
						</ul>
				</li>
				<li class="parent_activity">
					<?php echo $this->Html->link($this->Html->tag('span', 'ニアショアIT協会の活動'), array('controller' => 'activity','action'=> 'about'), array('escape'=>false));?>
						<ul>
							<li><?php echo $this->Html->link("活動概要", array('controller' => 'activity','action'=> 'about'));?></li>
							<li><?php echo $this->Html->link("活動カレンダー", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
							<li><?php echo $this->Html->link("活動報告", array('controller' => 'activity','action'=> 'reportIndex'.$curtime));?></li>
						</ul>
				</li>

				<li class="parent_join">
					<?php echo $this->Html->link($this->Html->tag('span', '入会のご案内'), array('controller' => 'join','action'=> 'about'), array('escape'=>false));?>
						<ul>
							<li><?php echo $this->Html->link("入会について", array('controller' => 'join','action'=> 'about'));?></li>
							<li><?php echo $this->Html->link("入会のお申し込み", array('controller' => 'join','action'=> 'entry'));?></li>
							<li><?php echo $this->Html->link("よくあるご質問", array('controller' => 'join','action'=> 'faq'));?></li>
						</ul>
				</li>

				<li class="parent_contact">
					<?php echo $this->Html->link($this->Html->tag('span', 'お問い合わせ'), array('controller' => 'contact','action'=> 'entry'), array('escape'=>false));?>
						<ul>
							<li><?php echo $this->Html->link("事務局へお問い合わせ", array('controller' => 'contact','action'=> 'entry'));?></li>
						</ul>
				</li>

				<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
				<li class="urltargetcls parent_membermenu" id="kaiinmenuDsk">
					<?php echo $this->Html->link($this->Html->tag('span', '会員メニュー'), array(), array('id'=>'kaiinmenuTitle','onclick'=>'return login(this.id);','escape'=>false)); ?>
						<ul>
							<li><?php echo $this->Html->link("情報更新", array(), array('id'=>'kaiinmenu','onclick'=>'return login(this.id);')); ?></li>
							<li><?php echo $this->Html->link("ダウンロード", array('controller' => 'download','action'=> 'index'));?></li>
							<li><?php echo $this->Html->link("委員会の紹介", array('controller' => 'committee','action'=> 'index'));?></li>
							<li><?php echo $this->Html->link("倶楽部の紹介", array('controller' => 'club','action'=> 'index'));?></li>
							<li><?php echo $this->Html->link("有益情報一覧", array('controller' => 'Beneficial','action'=> 'index'));?></li>
							<li><?php echo $this->Html->link("案件管理システム", 'http://anken.nearshore-it.jp/', array('target' => '_blank'));?></li>
							<li><?php echo $this->Html->link("ニアショアIT協会バナー", array('controller' => 'banner','action'=> 'index'));?></li>
						</ul>
				</li>
				<?php } ?>
				<a href="<?php echo $this->base;?>/lp01/index.html" class="landingpages_green_clr" target="_blank">発注をお考えの企業様</a>
				<a href="<?php echo $this->base;?>/lp02/index.html" class="landingpages_brown_clr" target="_blank">受注をご希望の企業様</a>
			</ul>
		</nav>
		
		<div class="log_btn">
			<?php if(!isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { 
				echo $this->Html->link("会員ログイン", array('controller' => 'login', 'action' => 'index'));
			} else {
				echo $this->Html->link("ログアウト", array('controller' => 'login', 'action' => 'logout'), array('id' => 'logoutLinkDsk'));
			} ?>
		</div>

		</div><!-- /.pc_header_inner -->
	</header>
	<!-- /header -->
		<main id="main_wrap">
			<?php echo $this->element('banner');?>
			<div class="row">
			<?= $this->fetch('content') ?>
			</div>
		</main><!-- /.main_wrap -->
	<?php echo $this->element('footer');?>
	<!-- /footer -->
	</div><!-- /#wrap -->
	<?php if (isset($previewadmin)) { ?>
		<script type="text/javascript">
			$("a").not(".anchorFileDownload, .anchorpagetop, .imgzoom").attr("href", "javascript:;");
			$("a#kaiinmenuTitle").prop("onclick", null);
			$("a#kaiinmenu").prop("onclick", null);
			$(".urltargetcls a").removeAttr("target");
		</script>
	<?php }?>

	<!-- Session Timeout Process -->
	<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
		<?= $this->Html->script('common/timeout.js'); ?>
		<?= $this->Html->script('common/jquery.confirm.js') ?>
		<?= $this->html->css('common/confirm.css') ?>
		<script type="text/javascript">
			window.localStorage.setItem("LogoutStatus", 0);
			var idleTime = 1;
			var userTrig = 0;
			$(document).ready(function () {
				var idleInterval = setInterval(timerIncrement, 60000);
				$(this).mousemove(function (e) { idleTime = 1; });
				$(this).keypress(function (e) { idleTime = 1; });
				$(this).click(function (e) { idleTime = 1; });
				$(this).scroll(function (e) { idleTime = 1; });
			});
			function logout() {
				$.ajax({
					url    : 'Login/sessionTimeout',
					type   : 'POST',
					datatype : 'JSON',
					async: false,
					success : function(data) {
						// alert(data);
					},
					error : function(errorData) {
					}
				});
			}
			function timerIncrement() {
				window.localStorage.setItem("userIdletime",idleTime);
				var adminIdletime = window.localStorage.getItem("adminIdletime");
				localStorage.removeItem("adminIdletime");
				if(adminIdletime == 1) {
					idleTime = 1;
				}
				idleTime = idleTime + 1;
				if (idleTime > timeoutMin && userTrig == 0 ) {
					userTrig = 1;
					localStorage.removeItem("userIdletime");
					$.confirm({
						title: '',
						content: '一定時間操作されなかったため、自動ログアウトされました。<BR/>会員機能を利用するには、再度ログインしてください。',
						type: 'blue',
						columnClass: 'col-md-6 col-md-offset-4 col-sm-5 col-sm-offset-3 col-xs-10 col-xs-offset-1',
						buttons: {
							OK: {
								btnClass: 'btn-blue',
								keys: ['enter'],
								action: function(){
									logout();
									window.localStorage.setItem("LogoutStatus", 1);
									$('#userNamedisplay').hide();
									$('#kaiinmenuDsk').hide();
									$('#kaiinmenuMbl').hide();
									$('#logoutLinkDsk').text('会員ログイン');
									$('#logoutLinkMbl').text('会員ログイン');
								}
							}
						}
					});
					history.pushState(null, null, '');
					window.addEventListener('popstate', function(event) {
						history.pushState(null, null, '');
					});
				}
			}
		</script>  
	<?php } ?>
	<!-- Session Timeout Process -->
<script type="text/javascript">
	function login(id) {
		var return_first = function () {
		var tmp = null;
			$.ajax({
				url    : 'Login/checkSession',
				type   : 'POST',
				datatype : 'JSON',
				data   : '',
				async: false,
				success : function(data){
					tmp = data;
				}
			});
			return tmp;
		}();
		var return_second = function () {
		var tmp = null;
			$.ajax({
				url    : '../Login/checkSession',
				type   : 'POST',
				datatype : 'JSON',
				data   : '',
				async: false,
				success : function(data){
					tmp = data;
				}
			});
			return tmp;
		}();
		if(return_first == 1 || return_second == 1) {
			var baseUrl = "<?php echo $this->base; ?>";
			var browserIE = msieversion();
			if(browserIE == true ) {
				$("#"+id).attr("href", "<?php echo $this->Html->url(array('controller' => 'admin', 'action' => 'home')); ?>");
				$("#"+id).attr("target", "_blank");
			} else {
				window.open (baseUrl+"/admin/home");
				return false;
			}
		} else {
			$("#"+id).attr("href", "<?php echo $this->Html->url(array('controller' => 'login', 'action' => 'index')); ?>");
			$("#"+id).attr("target", "");
		}
		//return false;
	}
	function msieversion(){
		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");
		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) { 
			// alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
			// If Internet Explorer, return true
			return true;
		} else {
			// If another browser, return false
			return false;
		}
	}
</script>
</body>
</html>