<!-- style -->
<?= $this->html->css('common/jquery.bxslider.css') ?>
<?= $this->html->css('top/index.css') ?>
<!-- style -->

<!-- ========== main ========== -->
<section class="home-main">
	<main>
		<div class="home-slide-area visbilityShowAfterLoad">
			<div class="home-slider-wrapper">
				<ul class="bxslider">
					<li><?php echo $this->Html->image('home/pr_top01.jpg', array ('title' => '最適なビジネスパートナーが見つかります！','alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR')); ?></li>
					<li><?php echo $this->Html->image('home/pr_top02.jpg', array ('title' => '自社の商品・サービスをPRできます！','alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR')); ?></li>
					<li><?php echo $this->Html->image('home/pr_top03.jpg', array ('title' => 'ビジネスネットワークが広がります！','alt' => 'ニアショアＩＴ協会 一般社団法人会員企業PR')); ?></li>
				</ul>
			</div>
		</div><!-- /.home-slide-area -->

		<?php echo $this->Form->create(null, ['id' => 'memberShosaifrm', 'url' => ['controller' => 'member', 'action' => 'index']]);
			echo $this->Form->input('', array('name'=>'arno','id'=>'arno','type' => 'hidden'));
			echo $this->Form->input('', array('name'=>'kaisyacd','id'=>'kaisyacd','type' => 'hidden'));
			echo $this->Form->input('', array('name'=>'tantou','id'=>'tantou','type' => 'hidden'));
		echo $this->Form->end();?>
		<div class="home-pick-up displayBlockAfterLoad">
			<div class="home-pick-up-wrapper">
				<ul class="bxslider2">
					<?php if(count($prsyohinDetails) > 0) : foreach($prsyohinDetails as $prsyohinVal): ?>
						<li>
							<a href="javascript:;" class="memberShosai" data-arno="<?php echo $prsyohinVal['TPrsyohin']['arno'];?>" data-kaisyacd="<?php echo $prsyohinVal['TPrsyohin']['kaisyacd'];?>" data-tantou="<?php echo $prsyohinVal['TPrsyohin']['tantou'];?>" >
								<div class="maxsize_SyasinDiv" align="center" style="height: 189px;">
									<?php if($prsyohinVal['TPrsyohin']['syasinkey'] != "0" && $prsyohinVal['TPrsyohin']['syasinkey'] != "" ) { ?>
										<img class="maxsize_SyasinImg" src="<?php echo $this->base."/top/getSyasin/".$prsyohinVal['TPrsyohin']['syasinkey'];?>" />
									<?php } ?>
								</div>
								<h3 class="titleOverflow"><?php echo $prsyohinVal['TPrsyohin']['syohinnm']; ?></h3>
								<p><?php echo $prsyohinVal['TKaisya']['kaisyanm']; ?></p>
							</a>
						</li>
					<?php endforeach; endif; ?>
				</ul>
			</div>
		</div><!-- /.home-pick-up -->

		<div class="home-pr visbilityShowAfterLoad">
			<div class="home-pr-inner container">
				<div class="home-pr-sub">
					<div class="home-pr-sub-search">
						<?php echo $this->Form->create(null, ['url' => ['controller' => 'top', 'action' => 'index']]);?>
							<p>カテゴリーで探す</p>
							<div class="select-wrapper">
								<?php echo $this->Form->input('gyosyucd',array('type'=>'select',
																	'options'=>$gyosyunm,
																	'label'=>false,
																	'value'=>$gyosyucd,
																	'empty'=> array(''=> array(
																		'name' =>'ビジネスカテゴリー',
																		'value' => '',
																		'selected' => TRUE)),
																	'name'=>'gyosyucd',
																	'id' => 'gyosyucd'));?>
							</div>
							<p>会社名で探す</p>
							<?php echo $this->Form->input('', array('maxlength' => '30','type' => 'text','name'=>'company','placeholder'=>'会社名を入力してください','value'=>$company)); ?>
							<p>所在地で探す</p>
							<?php echo $this->Form->input('', array('maxlength' => '30','type' => 'text','name'=>'location','placeholder'=>'所在地を入力してください','value'=>$location)); ?>
							<p>会員名で探す</p>
							<?php echo $this->Form->input('', array('maxlength' => '30','type' => 'text','name'=>'member','placeholder'=>'会員名を入力してください','value'=>$member)); ?>
							<p>商品名で探す</p>
							<?php echo $this->Form->input('', array('maxlength' => '30','type' => 'text','name'=>'product','placeholder'=>'商品名を入力してください','value'=>$product));
							echo $this->Form->submit("検　索");?>
						<?php echo $this->Form->end();?>
					</div>
					<div class="home-pr-sub-bnr">
						<a href="https://www.nearshore-it.jp" target="_blank"><?php echo $this->Html->image('home/bnr-nearshoreit.jpg'); ?></a>
					</div>
				</div><!-- /.home-pr-sub -->

				<div class="home-pr-main visbilityShowAfterLoad">
					<h2>商品・サービスの最新PR情報</h2>
					<ul id="pr-items">
						<?php if(count($prsyohinDetails) > 0) : foreach($prsyohinDetails as $prsyohinVal): ?>
							<li>
								<div class="home-pr-main-img" align="center" style="height: 105px;">
									<a href="javascript:;" class="memberShosai" data-arno="<?php echo $prsyohinVal['TPrsyohin']['arno'];?>" data-kaisyacd="<?php echo $prsyohinVal['TPrsyohin']['kaisyacd'];?>" data-tantou="<?php echo $prsyohinVal['TPrsyohin']['tantou'];?>" >
										<?php if($prsyohinVal['TPrsyohin']['syasinkey'] != "0" && $prsyohinVal['TPrsyohin']['syasinkey'] != "" ) { ?>
										<img class="maxsize_SyasinImg2" src="<?php echo $this->base."/top/getSyasin/".$prsyohinVal['TPrsyohin']['syasinkey'];?>" />
										<?php } ?>
									</a>
								</div>
								<div class="home-pr-main-txt">
									<h3 class="titleOverflow">
										<?php echo $this->Html->link($prsyohinVal['TPrsyohin']['syohinnm'],'javascript:;',array('data-arno'=>$prsyohinVal['TPrsyohin']['arno'],'data-kaisyacd'=>$prsyohinVal['TPrsyohin']['kaisyacd'],'data-tantou'=>$prsyohinVal['TPrsyohin']['tantou'], 'class' => 'memberShosai')); ?>
									</h3>
									<p class="home-pr-main-txt1">
										<?php echo $this->Html->link($prsyohinVal['TKaisya']['kaisyanm'],'javascript:;',array('data-arno'=>$prsyohinVal['TPrsyohin']['arno'],'data-kaisyacd'=>$prsyohinVal['TPrsyohin']['kaisyacd'],'data-tantou'=>$prsyohinVal['TPrsyohin']['tantou'], 'class' => 'memberShosai')); ?>
									</p>
									<div id="<?php echo $prsyohinVal['TPrsyohin']['arno']; ?>" class="containerdiv minHeight45 home-pr-main-txt2">
										<?php echo $this->Html->link($prsyohinVal['TPrsyohin']['syousai'],'javascript:;',array('data-arno'=>$prsyohinVal['TPrsyohin']['arno'],'data-kaisyacd'=>$prsyohinVal['TPrsyohin']['kaisyacd'],'data-tantou'=>$prsyohinVal['TPrsyohin']['tantou'], 'class' => 'memberShosai nl2br')); ?>
										<div id="<?php echo $prsyohinVal['TPrsyohin']['arno']."fadediv"; ?>" class="fade dispNone">&nbsp;...</div>
									</div>
									<p class="home-pr-main-txt3">
										<?php echo $this->Html->link('＞ 詳しく見る','javascript:;',array('data-arno'=>$prsyohinVal['TPrsyohin']['arno'],'data-kaisyacd'=>$prsyohinVal['TPrsyohin']['kaisyacd'],'data-tantou'=>$prsyohinVal['TPrsyohin']['tantou'], 'class' => 'memberShosai')); ?>
									</p>
								</div>
							</li>
						<?php endforeach; endif; ?>
						<?php if(count($prsyohinDetails) > 5) : ?>
							<p id="more"><a href="javascript:detailscontent();">もっと見る</a></p>
						<?php endif; ?>
					</ul>
				</div><!-- /.home-pr-main -->
				
			</div>
		</div><!-- /.home-pr -->
	</main>
</section>
<!-- ========== /main ========== -->

<!-- script -->
<?= $this->Html->script('common/script.js') ?>
<?= $this->Html->script('common/jquery.bxslider.js') ?>
<?= $this->Html->script('top/index.js') ?>
<!-- script -->

<script type="text/javascript">
	$( document ).ready(function() {
		$(".visbilityShowAfterLoad").css("visibility", "visible");
		$(".displayBlockAfterLoad").css("display", "block");
	});
</script>