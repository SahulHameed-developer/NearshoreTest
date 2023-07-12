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

<!-- ========== main ========== -->
<section class="members-detail-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
				<li><?php echo $this->Html->link("HOME",'javascript:;');?></li>
				<?php if(count($prsyohinKaishaDetails) > 0) : foreach($prsyohinKaishaDetails as $prsyohinKaishaVal): ?>
					<?php $kaishaName = $prsyohinKaishaVal['TKaisya']['kaisyanm']; ?>
					<li><?php echo $this->Html->link($prsyohinKaishaVal['TKaisya']['kaisyanm'],'javascript:;');?></li>
				<?php endforeach; endif; ?>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="members-detail-main-inner container">
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
											<td><?php echo !empty($prtantou[0]['TPrtantou']['busyo']) ? $prtantou[0]['TPrtantou']['busyo'] : $busyo; ?></td>
										</tr>
										<tr>
											<th>担当者名</th>
											<td><?php echo !empty($prtantou[0]['TPrtantou']['tantounm']) ? $prtantou[0]['TPrtantou']['tantounm'] : $tantounm; ?></td>
										</tr>
									<?php endforeach; endif; ?>
								</tbody>
							</table>
						</div>
					</div><!-- /members-detail-info-overview -->
					<div class="members-detail-info-comment">
						<h3>担当者からのメッセージ</h4>
						<p><?php echo nl2br(!empty($prtantou[0]['TPrtantou']['tantoumsg']) ? $prtantou[0]['TPrtantou']['tantoumsg'] : $tantoumsg); ?></p>
					</div><!-- /members-detail-info-comment -->
				</div>
			</div><!-- /members-detail-info -->

			<div class="members-detail-pr">
				<h2><?php echo $kaishaName."の最新PR情報"; ?></h2>
					<ul>
						<li>
							<div class="members-detail-pr-img" align="center" style="height: 254px;">
								<?php if($reset != 1 ) { ?>
								<?php if (!empty($syasin1)) { ?>
									<img class="maxsize_SyasinImg" src="<?php echo $this->base."/member/viewSyasin/syasin1";?>" />
								<?php } else if($urlsyasinKey != "" && $urlsyasinKey != '0') { ?>
									<img class="maxsize_SyasinImg" src="<?php echo $this->base."/member/getSyasin/".$urlsyasinKey;?>" />
								<?php } } ?>
							</div>
							<div class="members-detail-pr-txt">
								<h3><?php echo nl2br($syohinnm); ?></h3>
								<p><?php echo nl2br($syousai); ?></p>
							</div>
						</li>
					</ul>
			</div><!-- /members-detail-pr -->
		</div><!-- /members-detail-main-inner -->

	</main>
</section>
<!-- ========== /main ========== -->
<script type="text/javascript">
	$('body').on('click.myDisable', 'a', function(e) { e.preventDefault(); });
</script>