<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="">
<meta name="format-detection" content="address=no,email=no,telephone=no">

<!-- OGP -->
<meta property="og:title" content="パスワード再発行完了｜一般社団法人ニアショアＩＴ協会">
<meta property="og:type" content="website">
<meta property="og:url" content="/login/">
<meta property="og:image" content="">
<meta property="og:description" content="">
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">

<title>パスワード再発行完了｜一般社団法人ニアショアＩＴ協会</title>

<!-- style -->
<!-- style/common -->
<?= $this->html->css('common/common.css') ?>
<!-- style/activity -->
<?= $this->html->css('login/style.css') ?>
<!-- webfont -->
<link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">

<!--[if lt IE 9]><script src="../common/js/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="../common/js/selectivizr.min.js"></script><![endif]-->
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('login/index.js') ?>
</head>

<body id="top">
  <div id="wrap" class="members_wrap members_contents">
    <main id="main_wrap">
      <div class="contents_wrap">
        <div class="contents">
          <p class="logo"><a href="Top"><?php echo $this->Html->image('login/logo.png', array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></a></p>
          <h1 class="h1">会員ログイン</h1>
            <div class="form_contents">
            	<p class="description">パスワードの再発行手続きが完了しました。</p>
	         	<?php echo $this->Form->create('pwdchangefrm',['name'=>'pwdchangefrm','id'=>'pwdchangefrm','url' => ['controller' => 'Login', 'action' => 'index']]);?>
					<div class="submit_btn">
	                	<?php echo $this->Form->submit("< ログイン画面へ", array('class' =>'roundedmplus1c','id'=>'loginModoru','name' =>'loginModoru','controller' => 'login','action'=> 'index'));?>
	            	</div>
	        	<?php echo $this->Form->end();?>
            </div><!-- /.form_contents -->
        </div><!-- /.contents -->

        <div class="message" style="margin-top: 20px;"><?php echo $this->Flash->render('auth'); echo $this->Session->flash();?></div>
      </div><!-- /.contents_wrap -->
    </main><!-- /.main_wrap -->

    <!-- footer -->
    <footer>
      <div class="copyright">
        <div class="frame">
          <?php echo $this->element('copyrights'); ?>
        </div><!-- /.frame -->
      </div><!-- /.copyright -->
    </footer>
    <!-- /footer -->
  </div><!-- /#wrap -->
</body>
</html>