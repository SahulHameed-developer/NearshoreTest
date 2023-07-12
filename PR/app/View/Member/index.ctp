<?= $this->Html->script('common/jquery.min.js') ?>

<style type="text/css">
	.maxsize_SyasinImg {
		max-height: 254px;
		max-width: 356px;
		width: auto;
		position: relative;
		top: 50%;
		transform: translateY(-50%);
	}
</style>
<?php
$company_name = '';
if (count($prsyohinKaishaDetails) > 0) {
	$company_name = $prsyohinKaishaDetails[0]['TKaisya']['kaisyanm'];
}
$this->assign('title', $company_name.'　｜　ニアショアＩＴ協会　会員企業のPRサイト'); ?>

<!-- ========== main ========== -->
<section class="members-detail-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
				<li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
				<?php if(count($prsyohinKaishaDetails) > 0) : foreach($prsyohinKaishaDetails as $prsyohinKaishaVal): ?>
					<?php $kaishaName = $prsyohinKaishaVal['TKaisya']['kaisyanm']; ?>
					<li><?php echo $this->Html->link($prsyohinKaishaVal['TKaisya']['kaisyanm'], 'javascript:;');?></li>
				<?php endforeach; endif; ?>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="members-detail-main-inner container">
			<?php echo $this->Form->create(null, ['id' => 'memberfrm', 'url' => ['controller' => 'contact', 'action' => 'index2']]);
				echo $this->Form->input('', array('name'=>'toikaisyanm','id'=>'toikaisyanm','type' => 'hidden'));
			echo $this->Form->end();?>
			<div class="members-detail-info">
				<h1><?php echo $kaishaName."の企業情報"; ?></h1>
				<div class="members-detail-info-inner">
					<div class="members-detail-info-overview">
						<h3>会社概要</h4>
						<div>
							<table>
								<tbody>
									<?php if(count($prsyohinKaishaDetails) > 0) : foreach($prsyohinKaishaDetails as $prsyohinKaishaVal): ?>
										<tr>
											<th>企業名</th>
											<td><?php echo $prsyohinKaishaVal['TKaisya']['kaisyanm']; ?></td>
										</tr>
										<tr>
											<th>URL</th>
											<td>
												<a href=<?php echo $prsyohinKaishaVal['TKaisya']['hpurl']; ?> target="_blank"><?php echo $prsyohinKaishaVal['TKaisya']['hpurl']; ?></a>
											</td>
										</tr>
										<tr>
											<th>業種</th>
											<td><?php echo $prsyohinKaishaVal['MGyosyu']['gyosyunm']; ?></td>
										</tr>
										<?php if(!empty($prsyohinKaishaVal['TKaisya']['jyusyo1']) && !empty($prsyohinKaishaVal['TKaisya']['jyusyo2'])) { ?>
										<tr>
											<th>所在地1</th>
											<td><?php echo $prsyohinKaishaVal['TKaisya']['jyusyo1']; ?></td>
										</tr>
										<tr>
											<th>所在地2</th>
											<td><?php echo $prsyohinKaishaVal['TKaisya']['jyusyo2']; ?></td>
										</tr>
										<?php } else { ?>
										<tr>
											<th>所在地</th>
											<td><?php echo $prsyohinKaishaVal['TKaisya']['jyusyo1']; ?></td>
										</tr>
										<?php } ?>
										<tr>
											<th>電話番号</th>
											<td><?php echo $prsyohinKaishaVal['TKaisya']['telno']; ?></td>
										</tr>
										<tr>
											<th>担当部署</th>
											<td><?php echo $prsyohinKaishaVal['TPrtantou']['busyo']; ?></td>
										</tr>
										<tr>
											<th>担当者名</th>
											<td><?php echo $prsyohinKaishaVal['TPrtantou']['tantounm']; ?></td>
										</tr>
									<?php endforeach; endif; ?>
								</tbody>
							</table>
						</div>
					</div><!-- /members-detail-info-overview -->
					<div class="members-detail-info-comment">
						<h3>担当者からのメッセージ</h4>
						<p><?php echo nl2br($prsyohinKaishaVal['TPrtantou']['tantoumsg']); ?></p>
					</div><!-- /members-detail-info-comment -->
					<p class="members-detail-info-btn">
						<?php echo $this->Html->link("ニアショアＩＴ協会を通じてこの企業に問い合わせする",'javascript:;',array('data-toikaisyanm'=>$prsyohinKaishaVal['TKaisya']['kaisyanm'], 'class' => 'gotoContact')); ?>
					</p>
				</div>
			</div><!-- /members-detail-info -->

			<div class="members-detail-pr">
				<h2><?php echo $kaishaName."の最新PR情報"; ?></h2>
					<ul>
						<?php if(count($prsyohinDetails) > 0) : foreach($prsyohinDetails as $prsyohinVal): ?>
							<li>
								<div class="members-detail-pr-img" align="center" style="height: 254px;">
									<?php if($prsyohinVal['TPrsyohin']['syasinkey'] != "0" && $prsyohinVal['TPrsyohin']['syasinkey'] != "" ) { ?>
										<img class="maxsize_SyasinImg" src="<?php echo $this->base."/member/getSyasin/".$prsyohinVal['TPrsyohin']['syasinkey'];?>" />
									<?php } ?>
								</div>
								<div class="members-detail-pr-txt">
									<h3><?php echo $prsyohinVal['TPrsyohin']['syohinnm']; ?></h3>
									<p><?php echo nl2br($prsyohinVal['TPrsyohin']['syousai']); ?></p>
								</div>
							</li>
						<?php endforeach; endif; ?>
					</ul>
			</div><!-- /members-detail-pr -->

		</div><!-- /members-detail-main-inner -->

	</main>
</section>
<!-- ========== /main ========== -->

<script type="text/javascript">
	$(".gotoContact").click(function () {
		$("#toikaisyanm").val($(this).attr("data-toikaisyanm"));
		$( "#memberfrm" ).submit();
	});
</script>