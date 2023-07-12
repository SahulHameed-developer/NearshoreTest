<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワード再発行：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<?= $this->html->css('pwdsaihakko/pwdsaihakko.css') ?>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('admin/index.js') ?>
<style type="text/css">
.error {
	width: 290px;
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
	<div class="container">
		<main>
		<div class="login-box">
			<h2>パスワード再発行</h2>
			<p class="login-txt">新しいパスワードを入力してください。</p>
			<?php echo $this->Form->create('pwdchangefrm',['name'=>'pwdchangefrm', 'type' => 'post', 'id'=>'pwdchangefrm','url' =>['controller' => 'adminPasswordChange', 'action' => 'finish']]);
				echo $this->Form->input('kaiincd', array('name' => 'kaiincd','id' => 'kaiincd','type' => 'hidden', 'value'=>$kaiincd));
			?>
			<table class="table_size" style="width:95% !important;">
					<tr>
						<td class="label_content"><label for="mem_code-field">会員名称</label></td>
						<td class="textbox_width"><?php echo $this->Form->input('kaiinnm', array('type' => 'text', 'value'=>$kaiinnm, 'readonly'=>'readonly', 'label' => false,'id'=>'kaiinnm','name'=>'kaiinnm','style'=>'width:282px;')); ?>
						</td>
					</tr>
					<tr>
						<td class="label_content"><label for="pwd-field">新しいパスワード</label></td>
						<td class="textbox_width">
						<div class="password-error">
						<?php echo $this->Form->input('pwd', array('type' => 'password','label' => false,'id'=>'pwd','placeholder'=>'半角英字・数字・記号を含めて6文字以上','name'=>'pwd','style'=>'width:282px;height: 38px;')); ?>
						</div>
						</td>
					</tr>
					<tr>
						<td class="label_content"><label for="re_pwd-field">新しいパスワード（確認用）</label></td>
						<td class="textbox_width">
						<div class="password-error">
						<?php echo $this->Form->input('re_pwd', array('type' => 'password','label' => false,'id'=>'re_pwd','placeholder'=>'半角英字・数字・記号を含めて6文字以上','name'=>'re_pwd','style'=>'width:282px;height: 38px;')); ?> 
						</div>
						</td>
					</tr>
				</table>
				<div class="message"><?php echo $this->Session->flash();?></div>
				<p class="pw-link"><?php echo $this->Form->button("再発行", array('class' =>'button','id'=>'submit','name' =>'submit','controller' => 'adminPasswordChange','action'=> 'finish'));?></p>
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