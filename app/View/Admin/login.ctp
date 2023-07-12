<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ログイン：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<?= $this->html->css('pwdsaihakko/pwdsaihakko.css') ?>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('admin/index.js') ?>

<?php include APP.'View'.DS.'Elements'.DS.'analyticstracking.php'; ?>
</head>
<body style='font-family: "メイリオ", Meiryo, "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;'>
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
			<h2>管理画面ログイン</h2>
			<p class="login-txt pt17"><label class="pl10">ユーザー名・パスワードを入力してログインしてください。</label></p>
			<?php echo $this->Form->create('loginfrm',['name'=>'loginfrm','id'=>'loginfrm','url' => ['controller' => 'admin', 'action' => 'index']]);?>
			<div>
			<table class="table_size">
				<tr>
					<td class="login_label" ><label for="username-field">ユーザー名</label></td>
					<td class="textbox_width">
						<div class="password-error" style="margin-top: 1px !important;">
						<?php echo $this->Form->input('lgid', array('type' => 'text','label' => false,'id'=>'lgid', 'value' => $username
							,'name'=>'lgid','class'=>'ime-ModeDisable','maxlength'=>'100','style'=>'width:290px;height:40px;')); ?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="login_label" ><label for="pw-field">パスワード</label></td>
					<td class="textbox_width">
						<div class="password-error" style="margin-top: 1px !important;">
						<?php echo $this->Form->input('lgpass', array('type' => 'password','label' => false,'id'=>'lgpass', 'name'=>'lgpass','maxlength'=>'40','style'=>'width:290px;height:40px;')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="login_paddCss">
				<p><?php echo $this->Form->button("ログイン", array('class' =>'button','id'=>'loginbtn','name' =>'loginbtn','controller' => 'admin','action'=> 'index','style' => 'width:290px;padding-top: 2px !important'));?></p>
		</div>
				<p class="pw-link" style="padding: 19px 0 19px !important;"><?php echo $this->Html->link("＞ パスワードを忘れた方はこちら", array('controller' => 'adminPasswordChange','action'=> 'irai'));?></p>

			<?php echo $this->Form->end();?>
			</div><!-- /.login-box -->
			<p class="back-g" style="padding: 24px !important;"><?php echo $this->Html->link("＜ 一般社団法人ニアショアＩＴ協会 に戻る", array('controller' => 'top','action'=> 'index'));?></p>
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
<script type = "text/javascript" >
	history.pushState(null, null, '');
	window.addEventListener('popstate', function(event) {
	history.pushState(null, null, '');
	});
</script>
</body>
</html>