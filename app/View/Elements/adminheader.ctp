<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= $this->Html->script('common/messages.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->Html->script('admin/header.js') ?>
<?= $this->html->css('admin/header.css') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<script type="text/javascript">
$(document).ready(function() {
	$(".logout").click(function () {
		$.confirm({
			title: '',
			content: 'ログアウトします。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
			    		$.ajax({
							url    : 'admin/logout',
							type   : 'POST',
							datatype : 'JSON',
							data   : '',
							async: false
						});
						window.open('', '_self').close();
					}
				},
				キャンセル: function () {
				}
			}
		});
	});
});
</script>
</head>
<body>
<nav>
	<div class="container nav-container">
		<ul class="navbar">
			<li><?php echo $this->Html->link("一般社団法人ニアショアＩＴ協会 サイト表示", array('controller' => 'top','action'=> 'index'));?></li>
			<li><a href="javascript:;" style="outline: none;" class="logout">ログアウト</a></li>
		</ul>
	</div><!-- /.nav-container -->
</nav>
<header>
	<div class="container header-container">
		<div style="width: 70%;display: inline-block;">
			<div class="header-inner">
				<p class="header-logo">
					<?php if(strtolower($this->Common->getController()) == strtolower($this->Constants->ADMIN_CTL) && strtolower($this->Common->getAction()) == strtolower($this->Constants->HOME_ACT)) {
						echo $this->Html->image('common/logo.png', array ('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));
					} else {
						echo $this->Html->image('common/logo.png', array ('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会','id'=>'logoimg','style'=>'cursor:pointer;'));
					} ?>
				</p>
				<p class="header-text">管理画面</p>
			</div>
		</div>
		<div class="tab-close-btn">
			<?php echo $this->Form->button("管理画面を閉じる", array('class' =>'button','onclick' => "window.open('', '_self').close();"));?>
		</div>
	</div><!-- /header-container -->
</header>