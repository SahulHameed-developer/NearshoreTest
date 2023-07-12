<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="format-detection" content="address=no,email=no,telephone=no">
		<!-- OGP -->
		<meta property="og:type" content="website">
		<meta property="og:image" content="">
		<meta property="og:description" content="">
		<meta property="og:locale" content="ja_JP">
		
		<?php if (strtolower($this->Common->getController()) == strtolower($this->Constants->TOP_CTL)) {?>
			<meta property="og:title" content="ニアショアＩＴ協会　会員企業のPRサイト">
			<meta property="og:url" content="/">
			<meta property="og:site_name" content="ニアショアＩＴ協会　会員企業のPRサイト">
			<title>ニアショアＩＴ協会　会員企業のPRサイト</title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL)) {?>
			<meta property="og:title" content="会員企業PRサイトとは｜ニアショアＩＴ協会　会員企業のPRサイト">
			<meta property="og:url" content="/about/">
			<meta property="og:site_name" content="会員企業PRサイトとは｜ニアショアＩＴ協会　会員企業のPRサイト">
			<title>会員企業PRサイトとは｜ニアショアＩＴ協会　会員企業のPRサイト</title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->PUBLICAION_CTL)) {?>
			<meta property="og:title" content="掲載について｜ニアショアＩＴ協会　会員企業のPRサイト">
			<meta property="og:url" content="/publication/">
			<meta property="og:site_name" content="掲載について｜ニアショアＩＴ協会　会員企業のPRサイト">
			<title>掲載について｜ニアショアＩＴ協会　会員企業のPRサイト</title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->MEMBER_CTL)) {?>
			<meta property="og:title" content="株式会社ケーアンドティ｜ニアショアＩＴ協会　会員企業のPRサイト">
			<meta property="og:url" content="/members/">
			<meta property="og:site_name" content="株式会社ケーアンドティ｜ニアショアＩＴ協会　会員企業のPRサイト">
			<title><?php echo $this->fetch('title'); ?></title>
		<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CONTACT_CTL)) {?>
			<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX2_ACT)) {?>	
				<meta property="og:title" content="お問い合わせ｜ニアショアＩＴ協会　会員企業のPRサイト">
				<meta property="og:url" content="/contact/">
				<meta property="og:site_name" content="お問い合わせ｜ニアショアＩＴ協会　会員企業のPRサイト">
				<title>お問い合わせ｜ニアショアＩＴ協会　会員企業のPRサイト</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM2_ACT)) { ?>
				<meta property="og:title" content="お問い合わせ入力内容確認｜ニアショアＩＴ協会　会員企業のPRサイト">
				<meta property="og:url" content="/contact/confirm.html">
				<meta property="og:site_name" content="お問い合わせ入力内容確認｜ニアショアＩＴ協会　会員企業のPRサイト">
				<title>お問い合わせ入力内容確認｜ニアショアＩＴ協会　会員企業のPRサイト</title>
			<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH2_ACT)) { ?>
				<meta property="og:title" content="お問い合わせ完了｜ニアショアＩＴ協会　会員企業のPRサイト">
				<meta property="og:url" content="/contact/finish.html">
				<meta property="og:site_name" content="お問い合わせ完了｜ニアショアＩＴ協会　会員企業のPRサイト">
				<title>お問い合わせ完了｜ニアショアＩＴ協会　会員企業のPRサイト</title>
			<?php } ?>	
		<?php } ?>

		<!-- script -->
		<?= $this->Html->script('common/script.js') ?>
		<!-- script -->
		
		<!-- style -->
		<?= $this->html->css('common/normalize.css') ?>
		<?= $this->html->css('common/main.css') ?>
		<!-- style -->

	</head>
	<body id="top">
		<span id="megamenu-overlay"></span>
		<?php echo $this->element('header');?>
		<main>
			<?= $this->fetch('content') ?>
		</main>
		<?php echo $this->element('footer');?>
	</body>
</html>