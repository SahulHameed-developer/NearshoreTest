<?php $curtime = "?time=".date('dmYHis'); ?>
<section class="join_contents">
	<div class="frame">
		<h2 class="h2 wf-roundedmplus1c">入会のご案内</h2>
		<p class="description">一般社団法人ニアショアＩＴ協会では活動趣旨にご賛同いただける方のご入会をお待ちしております</p>
		<div class="link_block clearfix">
			<div class="link_item join_about wf-roundedmplus1c">
				<?php echo $this->Html->link("入会について", array('controller' => 'join','action'=> 'about'));?>
			</div>
			<div class="link_item join_contact wf-roundedmplus1c">
				<?php echo $this->Html->link("入会のお申し込み", array('controller' => 'join','action'=> 'entry'));?>
			</div>
		</div>
		<div class="link_block clearfix mt_top">
			<div class="link_item join_about wf-roundedmplus1c">
				<a href="<?php echo $this->base;?>/lp01/index.html" target="_blank">発注をお考えの企業様</a>
			</div>
			<div class="link_item join_contact wf-roundedmplus1c">
				<a href="<?php echo $this->base;?>/lp02/index.html" target="_blank">受注をご希望の企業様</a>
			</div>
		</div>
		<!-- /.link_block -->
	</div>
	<!-- /.frame -->
</section>
<!-- /.join_contents -->
<!-- footer -->
<footer>
	<div class="footer_inner">
		<div class="frame">
			<div class="link_block sp_contents">
				<ul class="clearfix">
					<li><?php echo $this->Html->link("ニアショアIT協会とは", array('controller' => 'about','action'=> 'index'));?></li>
					<li><?php echo $this->Html->link("個人情報の取り扱いについて", array('controller' => 'Privacy','action'=> 'index'));?></li>
					<li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'entry'));?></li>
				</ul>
			</div>
			<!-- /.link_block -->

			<div class="sitemap pc_contents">
				<ul class="clearfix">
				<li><?php echo $this->Html->link("お知らせ", array('controller' => 'news','action'=> 'index'), array('class' => 'alone_link'));?></li>
					<li><?php echo $this->Html->link("ニアショアIT協会とは", array('controller' => 'about','action'=> 'index'));?>
						<ul>
							<li><?php echo $this->Html->link("協会概要", array('controller' => 'about','action'=> 'index'));?></li>
							<li><?php echo $this->Html->link("ご挨拶", array('controller' => 'about','action'=> 'message'));?></li>
							<li><?php echo $this->Html->link("役員紹介", array('controller' => 'about','action'=> 'executive'));?></li>
							<li><?php echo $this->Html->link("組織図", array('controller' => 'about','action'=> 'organization'));?></li>
							<li><?php echo $this->Html->link("アクセス", array('controller' => 'about','action'=> 'access'));?></li>
							<li><?php echo $this->Html->link("定款", array('controller' => 'about','action'=> 'statute'));?></li>
						</ul></li>
					<li><?php echo $this->Html->link("会員企業", array('controller' => 'members','action'=> 'index'));?>	
						<ul>
							<li><?php echo $this->Html->link("会員企業一覧", array('controller' => 'members','action'=> 'index'.$curtime));?></li>
							<li><a href="<?php echo $this->base;?>/PR" target="_blank">会員企業ＰＲ</a></li>
						</ul></li>
					<li><?php echo $this->Html->link("ニアショアIT協会の活動", array('controller' => 'activity','action'=> 'about'));?>
						<ul>
							<li><?php echo $this->Html->link("活動概要", array('controller' => 'activity','action'=> 'about'));?></li>
							<li><?php echo $this->Html->link("活動カレンダー", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
							<li><?php echo $this->Html->link("活動報告", array('controller' => 'activity','action'=> 'reportIndex'.$curtime));?></li>
						</ul></li>
					<li><?php echo $this->Html->link("入会のご案内", array('controller' => 'join','action'=> 'about'));?>
						<ul>
							<li><?php echo $this->Html->link("入会について", array('controller' => 'join','action'=> 'about'));?></li>
							<li><?php echo $this->Html->link("入会のお申し込み", array('controller' => 'join','action'=> 'entry'));?></li>
							<li><?php echo $this->Html->link("よくあるご質問", array('controller' => 'join','action'=> 'faq'));?></li>
						</ul><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'entry'));?>
							<?php echo $this->Html->link("個人情報の取り扱いについて", array('controller' => 'Privacy','action'=> 'index'), array('class' => 'alone_link'));?>
				</ul>
			</div>
			<!-- /.sitemap -->

			<p class="logo">
				<a href="javascript:;">
			<?php echo $this->Html->image('common/logo_footer.png', ['url' => ['controller' => 'top','action' => 'index']], array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></a>
			</p>
			<div class="contact_block">
				<p><span class="address">〒101-0048 東京都千代田区神田司町2丁目13番 神田第4アメレックスビル8F</span><span class="tel">TEL: <a href="tel:0662623266"><span>03-6327-7070</span></a>　FAX: 03-3295-7111</span></p>
			</div>
			<!-- /.contact_block -->
		</div>
		<!-- /.frame -->
	</div>
	<!-- /.footer_inner -->
	
	<div class="pagetop">
		<a href="#top" class="sp_contents anchorpagetop"><?php echo $this->Html->image('common/sp/pagetop.png', array('alt' => 'ページトップへ戻る'));?></a>
		<a href="#top" class="pc_contents anchorpagetop"><?php echo $this->Html->image('common/pc/pagetop.png', array('alt' => 'ページトップへ戻る'));?></a>
	</div>
	<!-- /.pagetop -->

	<div class="copyright">
		<div class="frame urltargetcls">
			<a href="https://www.hts-act.com/" target="_blank" class="footer_link">
				<p>Copyright &copy; 2017 Hts Act Co.,Ltd. All rights reserved.</p>
			</a>
		</div>
		<!-- /.frame -->
	</div>
	<!-- /.copyright -->
</footer>
<!-- /footer -->
<script type="text/javascript">
	$(document).ready(function() {
		$('input, textarea').blur(function () {
			$(this).val($.trim( $(this).val()));
			// エモジスを置き換える
			var Emoji = isEmoji($(this).val());
			$(this).val(Emoji);
		});
		$("img, a").mousedown(function(){
			return false;
		});
	});
	// エモジスを置き換える
	function isEmoji(str) {
		var ranges = ['\ud83c[\udf00-\udfff]','\ud83d[\udc00-\ude4f]','\ud83d[\ude80-\udeff]'];
		return str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
	}
</script>