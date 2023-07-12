<!-- ========== footer ========== -->
<footer>
	<div class="footer-container" style="padding: 50px 0 0 0;">
		<div class="container">
			<ul class="footer-nav">
				<li><?php echo $this->Html->link("会員企業PRサイトとは", array('controller' => 'about','action'=> 'index'));?></li><!--
				--><li><?php echo $this->Html->link("掲載について", array('controller' => 'publication','action'=> 'index'));?></li><!--
				--><li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'index'));?></li><!--
				--><li><a href="https://www.nearshore-it.jp" target="_blank">ニアショアＩＴ協会のホームページへ</a></li>
			</ul><!-- /.footer-nav -->
			<p class="footer-info1">ニアショアＩＴ協会</p>
			<p class="footer-info2">〒101-0048 東京都千代田区神田司町2丁目13番 神田第4アメレックスビル8F　</p>
			<p class="footer-info2">TEL: 03-6327-7070　FAX: 03-3295-7111</p><BR>
		</div>
	</div><!-- /.footer-container -->
	<div class="pagetop displayAfterLoad">
		<a href="#top" class="sp_contents">
			<?php echo $this->Html->image('common/pagetop_sp.png', array ('alt' => 'ページトップへ戻る')); ?>
		</a>
		<a href="#top" class="pc_contents">
			<?php echo $this->Html->image('common/pagetop_pc.png', array ('alt' => 'ページトップへ戻る')); ?>
		</a>
	</div><!-- /.pagetop -->
	<div class="footer-container" style="padding: 0 0 50px 0;">
		<div class="container">
			<a class="footerlink" href="https://www.hts-act.com/" target="_blank">
				<p class="footer-copyright">Copyright &copy; 2020 Hts Act Co.,Ltd. All rights reserved.</p>
			</a>
		</div>
	</div>
</footer>
<!-- ========== /footer ========== -->
<style type="text/css">
	@media screen and (min-width: 769px) {
	  .footerlink {
		  display: inline-block;
	  }
	}
</style>
<script type="text/javascript">
	$(".displayAfterLoad").hide();
	jQuery(window).load(function () {
		$(".displayAfterLoad").show();
	});
</script>