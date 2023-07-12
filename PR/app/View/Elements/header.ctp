<!-- ========== header ========== -->
<header id="header">
	<div class="sp_header_inner sp_contents clearfix frame">
		<div class="title_description">ニアショアＩＴ協会　会員企業のPRサイト</div>
		<p class="logo">
			<?php echo $this->Html->image('common/logo.png', ['url' => ['controller' => 'top','action' => 'index']], array ('alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR')); ?>
		</p>
		<div data-target="menu01" class="menu modal-open">
			<div class="menu-default">
				<?php echo $this->Html->image('common/menu_btn_sp.png', array ('alt' => 'メニュー')); ?>
			</div><!-- /.menu-default -->
		</div><!-- /.menu -->
		<nav id="menu01" class="modal-content clearfix">
			<p class="close_top">
				<a class="modal-close">
					<?php echo $this->Html->image('common/menu_btn_close_sp.png', array ('alt' => '閉じる')); ?>
				</a>
			</p>
			<ul>
				<li><?php echo $this->Html->link("会員企業PRサイトとは", array('controller' => 'about','action'=> 'index'));?></li>
				<li><?php echo $this->Html->link("掲載について", array('controller' => 'publication','action'=> 'index'));?></li>
				<li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'index'));?></li>
				<li><?php echo $this->Html->link("ログイン", array('controller' => 'admin','action'=> 'index'));?></li>
			</ul>
		</nav>
	</div><!-- /.sp_header_inner -->
	<div class="pc_header_inner pc_contents frame clearfix container">
		<div class="title_description">ニアショアＩＴ協会　会員企業のPRサイト</div>
		<p class="logo">
			<?php echo $this->Html->image('common/logo.png', ['url' => ['controller' => 'top','action' => 'index']], array ('alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR')); ?>
		</p>
		<nav>
			<!-- <div class="log_btn">
				<?php //echo $this->Html->link("ログイン", array('controller' => 'admin','action'=> 'index'));?>
			</div> -->
			<ul id="mega_menu" class="clearfix">
				<li class="log_btn"><?php echo $this->Html->link("ログイン", array('controller' => 'admin','action'=> 'index'),array('class'=>'whiteHover'));?></li>
				<li><?php echo $this->Html->link($this->Html->tag('span', 'お問い合わせ'), array('controller' => 'contact','action'=> 'index'), array('escape'=>false));?></li>
				<li><?php echo $this->Html->link($this->Html->tag('span', '掲載について'), array('controller' => 'publication','action'=> 'index'), array('escape'=>false));?></li>
				<li><?php echo $this->Html->link($this->Html->tag('span', '会員企業PRサイトとは'), array('controller' => 'about','action'=> 'index'), array('escape'=>false));?></li>
			</ul>
		</nav>
	</div><!-- /.pc_header_inner -->
</header>
<!-- ========== /header ========== -->
<style type="text/css">
	.whiteHover:hover {
		color: white !important;
	}
</style>