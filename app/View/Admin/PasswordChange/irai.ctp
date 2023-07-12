<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワード再発行依頼：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<?= $this->html->css('pwdsaihakko/pwdsaihakko.css') ?>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('admin/index.js') ?>
<style type="text/css">
	.back-g {
		padding: 10px 0 20px 0 !important;
	}
	.updatecls {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ2JSIgeT0iNTIlIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+6YCB5L+h5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
		background-color: rgba(255, 255, 255, .5);
	}
</style>
</head>
<body>

<!-- ========== header ========== -->
<header>
	<h1 class="login-logo"><?php echo $this->Html->image('admin/logo-login.png', array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></h1>
</header>
<!-- ========== /header ========== -->

<!-- ========== main ========== -->
<section class="login-main">
<div id="updatecls"></div>
	<div class="container">
		<main>

			<div class="login-box">
				<h2>パスワード再発行依頼</h2>
				<p class="login-txt" style="text-align: left; line-height: 1.3; margin-left: 15px;">会員登録されているメールアドレスを入力してください。<br/>再発行画面のＵＲＬが自動で登録メールアドレスに送信されます。</p>
				<?php echo $this->Form->create('loginindex', ['id' => 'loginindex', 'url' => ['controller' => 'Admin', 'action' => 'home']]); echo $this->Form->end();?>
				<?php echo $this->Form->create('pwdMailSendFrm',['name'=>'pwdMailSendFrm','id'=>'pwdMailSendFrm','url' =>['controller' => 'adminPasswordChange', 'action' => 'sendMail']]);?>
				<table class="table_size">
					<tr>
						<td class="label_content"><label for="mailaddr-field">登録メールアドレス</label></td>
						<td class="textbox_width">
						<div class="password-error">
						<?php echo $this->Form->input('mailaddr', array('type' => 'text','label' => false,'id'=>'mailaddr', 'value' => $mailadd
							,'name'=>'mailaddr','class'=>'underscoresingle','maxlength'=>'100','style'=>'width:270px;margin:0 0 15px 0;')); ?>
						</div>
						</td>
					</tr>
					<tr>
						<td class="label_content"><label for="mailaddr-field">登録メールアドレス(確認用)</label></td>
						<td class="textbox_width">
						<div class="password-error">
						<?php echo $this->Form->input('cmailaddr', array('type' => 'text','label' => false,'id'=>'cmailaddr', 'value' => $cmailadd
							,'name'=>'cmailaddr','class'=>'underscoresingle','maxlength'=>'100','style'=>'width:270px;margin:0 0 15px 0;')); ?>
						</div>
						</td>
					</tr>
				</table>
				<p class="pw-link" style="padding: 20px 0 42px;"><?php echo $this->Form->button("送信", array('class' =>'button','id'=>'submit','style'=>'padding:4px 128px 2px;','name' =>'submit','controller' => 'adminPasswordChange','action'=> 'saihakko'));?></p>
				<?php echo $this->Form->end();?>
			</div><!-- /.login-box -->
			<center><font color='red'><label class="Errtxt"></label></font></center>
			<p class="back-g" style="padding:20px !important;"><?php echo $this->Html->link("＜ ログイン画面へ戻る", array('id'=>'loginModoru','name' =>'loginModoru','controller' => 'Admin','action'=> 'index'));?></p>
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
