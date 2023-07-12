<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('admin/normalize.css') ?>
<?= $this->html->css('admin/main.css') ?>
<?= $this->html->css('common/confirm.css') ?>
<script type="text/javascript">
$(document).ready(function() {
	var pageTop = $( '.pagetop img');
	var pagebottom = $( '.pagebottom img');
	pageTop.hide();
	pagebottom.hide();
	$(".logout").click(function () {
		$.confirm({
			title: '',
			content: 'ログアウトします。<br>よろしいですか？',
			type: 'blue',
			buttons: {
				OK: {
					action: function(){
			    		$.ajax({
							url    : '../admin/logout',
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
$(document).click(function() {
	if (location.pathname.split("/").pop() == 'home') {
		$.ajax({
			url    : '../Common/scrollsession',
			type   : 'POST',
			datatype : 'JSON',
			data   : {'scroll_val': 0 },
			async: false
		});
    }
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
<header style="padding-bottom: 0px !important;">
	<div class="container header-container">
		<div style="width: 70%;display: inline-block;">
			<div class="header-inner">
				<p class="header-logo">
					<?php if(strtolower($this->Common->getController()) == strtolower($this->Constants->ADMIN_CTL) && strtolower($this->Common->getAction()) == strtolower($this->Constants->HOME_ACT)) {
						echo $this->Html->image('common/logo.png', array ('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));
					 } else {
						echo $this->Html->image('common/logo.png', array ('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会','id'=>'logoimg','style'=>'cursor:pointer;'));
					 }?>
				</p>
				<p class="header-text">管理画面</p>
			</div>
		</div>
		<div class="tab-close-btn" style="margin-right: 30px;">
			<?php echo $this->Form->button("管理画面を閉じる", array('class' =>'button','onclick' => "window.open('', '_self').close();"));?>
		</div>
	</div><!-- /header-container -->
</header>
<script type="text/javascript">
	$(document).ready(function() {
		$('#logoimg').click(function() {
			$('#backpage_head').trigger('click');
		});
	});	
</script>