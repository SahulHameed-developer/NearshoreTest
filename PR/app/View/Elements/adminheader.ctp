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
	$("#logoimg").click(function () {
		window.location = "<?php echo $this->Html->url(array('controller'=>'Top','action'=>'index'));?>";
	});
});
</script>
</head>
<body>
<nav>
	<div class="container nav-container">
		<ul class="navbar">
			<li><?php echo $this->Html->link("ニアショアＩＴ協会　会員企業PRサイト表示", array('controller' => 'top','action'=> 'index'));?></li>
			<li><a href="javascript:;" style="outline: none;" class="logout">ログアウト</a></li>
		</ul>
	</div><!-- /.nav-container -->
</nav>
<header>
	<div class="container header-container" style="background-color: white;padding:0px;">
		<div style="width: 70%;display: inline-block;">
			<div class="header-inner">
				<p class="header-logo" style="margin-top:10px;">
					<?php echo $this->Html->image('common/logo.png', array ('alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR','id'=>'logoimg','style'=>'cursor:pointer;')); ?>
				</p>
				<p class="header-text">PR情報管理画面</p>
			</div>
		</div>
		<div class="tab-close-btn">
			<?php echo $this->Form->button("管理画面を閉じる", array('class' =>'button','onclick' => "window.open('', '_self').close();"));?>
		</div>
	</div><!-- /header-container -->
</header>