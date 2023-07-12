<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワード再発行完了：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
</head>
<body>
<!-- ========== header ========== -->
<header>
	<h1 class="login-logo"><?php echo $this->Html->image('admin/logo-login.png', array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></h1>
</header>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<section class="login-main">
	<div class="container">
		<main>
		<div class="login-box">
			<h2>パスワード再発行完了</h2>
			<p class="login-txt">パスワードの再発行手続きが完了しました。</p>
			<?php echo $this->Form->create('pwdchangefrm',['name'=>'pwdchangefrm','id'=>'pwdchangefrm','url' => ['controller' => 'admin', 'action' => 'index']]);?>
				<p class="pw-link"><?php echo $this->Form->button("＜ ログイン画面へ", array('class' =>'button','id'=>'loginModoru','name' =>'loginModoru','controller' => 'admin','action'=> 'index'));?></p>
			<?php echo $this->Form->end();?>
			</div><!-- /.login-box -->
			<div class="message"><?php echo $this->Flash->render('auth'); echo $this->Session->flash();?></div>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->

<!-- ========== footer ========== -->
<footer>
	<?php echo $this->element('copyrights'); ?>
</footer>
<!-- ========== /footer ========== -->
</body>
</html>