<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>システムエラー（管理機能用）画面</title>
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
				<h2>システムでエラー</h2>
				<p class="login-txt">システムでエラーが発生しました。<br>
					<div class="fnt15 displayBlock" style="vertical-align: top;margin-left:7px;">※</div>
					<div class="fnt15 displayBlock txtAlign-left" style="margin-bottom: 30px;">ブラウザの戻るボタン、または、矢印（← →）を操作した場合<br>「会員ログイン」ボタンで再度ログインしてください。<br>それ以外の操作でエラーとなった場合、管理者へ連絡してください。</div>
				</p>
			</div><!-- /.login-box -->
			<?php echo $this->Form->create('syserrorfrm',['name'=>'syserrorfrm','id'=>'syserrorfrm','url' => ['controller' => '', 'action' => '']]);?>
				<div class="report-search-btn" style="border-top: 0px;">
				<?php echo $this->Form->button("画面を閉じる", array('id'=>'loginModoru','name' =>'loginModoru','onclick' => 'return CloseTab()'));?>
				</div>
			<?php echo $this->Form->end();?>
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
	function CloseTab() {
		window.open('', '_self').close();
		return false;
	}
</script>
</body>
</html>