<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ログイン：ニアショアＩＴ協会 会員企業のPR 管理画面</title>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<?= $this->html->css('admin/login.css') ?>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('admin/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>

<SCRIPT type="text/javascript">
	$(document).ready(function() {
		$.confirm({
			title: '',
			content: 'ログインに成功しました。',
			type: 'blue',
			buttons: {
				OK: {
					btnClass: 'btn-blue',
					keys: ['enter'],
					action: function() {
						// for popup block in the chrome swap the below to line
						window.open("<?php echo $this->Html->url(array('controller'=>'AdminProductsite','action'=>'index'));?>",'_blank');
						window.location = "<?php echo $this->Html->url(array('controller'=>'Top','action'=>'index')); ?>";
					}
				}
			}
		});
	});
</SCRIPT>

</head>
<body style='font-family: "メイリオ", Meiryo, "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;'>
<!-- ========== header ========== -->
<header>
	<h1 class="login-logo"><?php echo $this->Html->image('admin/logo-login.png', array('alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR'));?></h1>
</header>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<section class="login-main">
	<div class="container">
		<main>
			<div class="login-box">
				<h2>PR商品情報ログイン</h2>
				<p class="login-txt pt17"><label class="pl10">更新担当者のメールアドレスを入力してログインしてください。</label></p>
				<?php echo $this->Form->create('loginfrm',['name'=>'loginfrm','id'=>'loginfrm','url' => ['controller' => 'admin', 'action' => 'index']]);?>
					<div>
					<table class="table_size">
						<tr>
							<td class="login_label" ><label for="mailaddress">メールアドレス</label></td>
							<td class="textbox_width">
								<div class="password-error" style="margin-top: 1px !important;">
								<?php echo $this->Form->input('mailaddress', array('type' => 'text','label' => false,'id'=>'mailaddress', 'value' => $_SESSION['Auth']['User']['Mailaddress']
									,'name'=>'mailaddress','class'=>'underscoresingle ime-ModeDisable','maxlength'=>'100','style'=>'width:290px;height:40px;')); ?>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="login_paddCss" style="padding-bottom: 40px;">
					<p><?php echo $this->Form->button("ログイン", array('class' =>'button','id'=>'loginbtn','name' =>'loginbtn','controller' => 'admin','action'=> 'index','style' => 'width:290px;padding-top: 2px !important'));?></p>
				</div>
				<?php echo $this->Form->end();?>
			</div><!-- /.login-box -->
			<p class="back-g" style="padding: 24px !important;"><?php echo $this->Html->link("＜　ニアショアＩＴ協会　会員企業のPR　に戻る", array('controller' => 'top','action'=> 'index'));?></p>
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