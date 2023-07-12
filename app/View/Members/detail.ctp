<?php $this->layout="default";?>
<!-- header -->
<?= $this->html->css('members/style.css') ?>
<?= $this->Html->script('common/jquery.matchHeight.js') ?>
<?= $this->Html->script('members/index.js') ?>
<!-- /header -->
<?= $this->html->css('common/lightbox.css') ?>
<?= $this->Html->script('common/lightbox.js') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<?php echo $this->Form->create('membersModoruFrm', ['id' => 'membersModoruFrm', 'url' => ['controller' => 'members', 'action' => 'search'.$curtime]]);
echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$radiovalue));
echo $this->Form->end();
?>
	<div class="contents_wrap">
		<div class="contents pc_frame">
			<article>
				<h1 class="h1 detail_title wf-roundedmplus1c sp_frame">
					<span class="logo_title" class="minsize_logo" style="vertical-align: middle;">
						<div class="outerlogo">
							<?php if (!empty($previewMemberInfo['syasin2'])) {?>
							<img src="<?php echo $this->base."/members/viewMemberSyasin/syasin2"?>" class="maxsize_logo"/>
							<?php } elseif (!empty($detailinfo['TKaisya']['kaisyacd'])) {?>
							<img src="<?php echo $this->base."/members/getKaisyaklogo/".$detailinfo['TKaisya']['kaisyacd'];?>" class="maxsize_logo"/>
							<?php } elseif (!empty($detailinfo['TKaisya']['memberAddFrm']['kaisyacd'])) {?>
							<img src="<?php echo $this->base."/members/getKaisyaklogo/".$detailinfo['TKaisya']['memberAddFrm']['kaisyacd'];?>" class="maxsize_logo"/>
							<?php } elseif (!empty($detailinfo['TKaisya']['urlkaisyalogo'])) {?>
							<img src="<?php echo $this->base."/members/getKaisyaklogo/".$detailinfo['TKaisya']['urlkaisyalogo'];?>" class="maxsize_logo"/>
							<?php }?>
						</div>
					</span>
					<span class="main_title"><?php echo $detailinfo['TKaisya']['kaisyanm'];?></span>
				</h1>
				<div class="detail_contents clearfix">
					<div class="f_right_pc">
					<?php if(!empty($kaiininfo)): foreach($kaiininfo as $kaiinVal): ?>
						<?php if($kaiinVal['TKaiin']['koukaikbn'] == 0) { ?>
							<div class="caption_box img_photo">
								<figure class="figure">
									<div class="outer">
										<img src="<?php echo $this->base."/members/getKaiinSyasin/".$kaiinVal['TKaiin']['kaiincd'];?>" style="max-height: 220px;max-width: 220px;width: auto;" />
									</div>
									<figcaption class="figcaption"><span><?php echo $kaiinVal['TKaiin']['kaisyayknm']; ?></span><span><?php echo $kaiinVal['TKaiin']['kaiinnm']; ?></span></figcaption>
								</figure>
							</div>
						<?php } ?>
					<?php endforeach; else: ?>
					<?php if (!empty($previewMemberInfo['syasin1'])) {?>
						<?php if((isset($detailinfo['TKaisya']['koukaikbn']) && $detailinfo['TKaisya']['koukaikbn'] == 0) || (isset($detailinfo['TKaisya']['kaiinkoukaikbn']) && $detailinfo['TKaisya']['kaiinkoukaikbn'] == 0) ) { ?>
							<div class="caption_box img_photo">
								<figure class="figure">
									<div class="outer">
										<img src="<?php echo $this->base."/members/viewMemberSyasin/syasin1";?>" style="max-height: 220px;max-width: 220px;width: auto;"/>
									</div>
									<figcaption class="figcaption"><span><?php echo $detailinfo['TKaisya']['kaisyayknm']; ?></span><span><?php echo $detailinfo['TKaisya']['kaiinnm']; ?></span></figcaption>
								</figure>
							</div>
						<?php } ?>
					<?php } elseif (!empty($detailinfo['TKaisya']['kaiincd'])) { ?>
						<div class="caption_box img_photo">
							<figure class="figure">
								<div class="outer">
									<img src="<?php echo $this->base."/members/getKaiinSyasin/".$detailinfo['TKaisya']['kaiincd'];?>" style="max-height: 220px;max-width: 220px;width: auto;"/>
								</div>
								<figcaption class="figcaption"><span><?php echo $detailinfo['TKaisya']['kaisyayknm']; ?></span><span><?php echo $detailinfo['TKaisya']['kaiinnm']; ?></span></figcaption>
							</figure>
						</div>
					<?php } elseif (!empty($detailinfo['TKaisya']['memberAddFrm']['kaiincd'])) { ?>
						<div class="caption_box img_photo">
							<figure class="figure">
								<div class="outer">
									<img src="<?php echo $this->base."/members/getKaiinSyasin/".$detailinfo['TKaisya']['memberAddFrm']['kaiincd'];?>" style="max-height: 220px;max-width: 220px;width: auto;"/>
								</div>
								<figcaption class="figcaption"><span><?php echo $detailinfo['TKaisya']['memberAddFrm']['kaisyayknm']; ?></span><span><?php echo $detailinfo['TKaisya']['memberAddFrm']['kaiinnm']; ?></span></figcaption>
							</figure>
						</div>
					<?php } elseif (!empty($detailinfo['TKaisya']['urlkaiinsyasin'])) { ?>
						<?php if(isset($detailinfo['TKaisya']['koukaikbn']) && $detailinfo['TKaisya']['koukaikbn'] == 0) { ?>
							<div class="caption_box img_photo">
								<figure class="figure">
									<div class="outer">
										<img src="<?php echo $this->base."/members/getKaiinSyasin/".$detailinfo['TKaisya']['urlkaiinsyasin'];?>" style="max-height: 220px;max-width: 220px;width: auto;"/>
									</div>
									<figcaption class="figcaption"><span><?php echo $detailinfo['TKaisya']['kaisyayknm']; ?></span><span><?php echo $detailinfo['TKaisya']['kaiinnm']; ?></span></figcaption>
								</figure>
							</div>
						<?php } ?>
					<?php } endif; ?>
					</div><!-- /.caption_box -->
					<div class="detail_box f_left_pc sp_frame">
						<!-- ニアショアIT協会 会員企業詳細-->
						<div class="section outline_section">
							<dl>
								<dt class="h2">代表者</dt>
								<dd>
							<dl>
								<dt><?php echo $detailinfo['TKaisya']['daihyoyknm'];?>　</dt>
								<dd><?php echo $detailinfo['TKaisya']['daihyonm'];?></dd>
							</dl>
								</dd>
							</dl>
							<dl>
								<dt class="h2">本社所在地</dt>
								<dd>
									<?php echo $yubinno;
									if($detailinfo['TKaisya']['jyusyo1'] != "") { 
										echo "</br>".$detailinfo['TKaisya']['jyusyo1'];  
									}
									if($detailinfo['TKaisya']['jyusyo2'] != "") {  
										echo "</br>".$detailinfo['TKaisya']['jyusyo2'];  
									}?>
								</dd>
							</dl>
							<dl class="break_line">
							<dt class="h2">連絡先</dt>
								<dd>
							<dl>
								<?php if (!empty($detailinfo['TKaisya']['telno'])) {?>
									<dt>TEL : </dt>
									<dd><?php echo $detailinfo['TKaisya']['telno'];?></dd>
								<?php }?>
								<?php if (!empty($detailinfo['TKaisya']['faxno'])) {?>
									<dt>FAX : </dt>
									<dd><?php echo $detailinfo['TKaisya']['faxno'];?></dd>
								<?php }?>
							</dl>
							<dl>
								<?php if (!empty($detailinfo['TKaisya']['hpurl'])) {?>
									<dt>URL : </dt>
									<?php if (!isset($previewadmin)) {?>
									<dd><a style="display: inline-block;text-decoration: underline;color: blue;" href="<?php echo $detailinfo['TKaisya']['hpurl'];?>" target="_blank"><?php echo $detailinfo['TKaisya']['hpurl'];?></a></dd>
								<?php } else { ?>
									<dd><?php echo $detailinfo['TKaisya']['hpurl'];?></dd>
								<?php } }?>
							</dl>
								</dd>
								</dl>
						</div><!-- /.section -->
						<section class="section">
							<h2 class="h2">業務内容</h2>
								<p class="description"><?php echo nl2br($detailinfo['TKaisya']['gyoumu']);?></p>
						</section>
						<section class="section">
							<h2 class="h2">PR</h2>
									<p class="description"><?php echo nl2br($detailinfo['TKaisya']['pr']);?></p>
						</section>
						<ul id="windowsize" class="not-active bnr_blocked clearfix">
						<?php if(!empty($syasinInfo)): foreach($syasinInfo as $syasinVal): ?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/getSyasin/".$syasinVal['TSyasin']['syasinkey']."/".$syasinVal['TSyasin']['rno'];?>" data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/getSyasin/".$syasinVal['TSyasin']['syasinkey']."/".$syasinVal['TSyasin']['rno'];?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption"><?php echo $syasinVal['TSyasin']['title'];?></figcaption>
							</figure>
						<?php endforeach; else: ?>
							<?php if (!empty($previewMemberInfo['syasin3'])) { ?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/viewMemberSyasin/syasin3";?>" data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/viewMemberSyasin/syasin3";?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption"><?php echo $detailinfo['TKaisya']['syasintitle1'];?></figcaption>
							</figure>
							<?php } elseif (!empty($detailinfo['TKaisya']['urlsyasinKey']) && !empty($detailinfo['TKaisya']['urlprimage1'])) {?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage1'];?>" 
									data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage1'];?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption">
									<?php if(isset($detailinfo['TKaisya']['syasintitle1'])) { 
										echo $detailinfo['TKaisya']['syasintitle1']; 
									} else if(isset($detailinfo['TKaisya']['primaget1'])) { 
										echo $detailinfo['TKaisya']['primaget1']; 
									} ?>
								</figcaption>
							</figure>
							<?php }?>
							<?php if (!empty($previewMemberInfo['syasin4'])) {?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/viewMemberSyasin/syasin4";?>" data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/viewMemberSyasin/syasin4";?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption"><?php echo $detailinfo['TKaisya']['syasintitle2']; ?></figcaption>
							</figure>
							<?php } elseif (!empty($detailinfo['TKaisya']['urlsyasinKey']) && !empty($detailinfo['TKaisya']['urlprimage2'])) {?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage2'];?>" 
									data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage2'];?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption">
									<?php if(isset($detailinfo['TKaisya']['syasintitle2'])) { 
										echo $detailinfo['TKaisya']['syasintitle2']; 
									} else if(isset($detailinfo['TKaisya']['primaget2'])) { 
										echo $detailinfo['TKaisya']['primaget2']; 
									} ?>
								</figcaption>
							</figure>
							<?php }?>
							<?php if (!empty($previewMemberInfo['syasin5'])) {?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/viewMemberSyasin/syasin5";?>" data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/viewMemberSyasin/syasin5"; ?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption"><?php echo $detailinfo['TKaisya']['syasintitle3']; ?></figcaption>
							</figure>
							<?php } elseif (!empty($detailinfo['TKaisya']['urlsyasinKey']) && !empty($detailinfo['TKaisya']['urlprimage3'])) {?>
							<figure class="figureImg mb40">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage3'];?>" 
									data-lightbox="img_1">
								<img class="maxsize_syasin" src="<?php echo $this->base."/members/getSyasin/".$detailinfo['TKaisya']['urlsyasinKey']."/".$detailinfo['TKaisya']['urlprimage3'];?>"/>
								</a>
								<figcaption style="display: block;width: 200px;" class="figcaption">
									<?php if(isset($detailinfo['TKaisya']['syasintitle3'])) { 
										echo $detailinfo['TKaisya']['syasintitle3']; 
									} else if(isset($detailinfo['TKaisya']['primaget3'])) { 
										echo $detailinfo['TKaisya']['primaget3']; 
									} ?>
								</figcaption>
							</figure>
							<?php }?>
						<?php endif; ?>
						</ul><!-- /.bnr_block -->
					</div><!-- /.detail_box -->
				</div><!-- /.detail_contents -->
				<div class="link_block sp_frame">
					<?php if (!isset($previewadmin)) {?>
					<div class="link_item event_detail wf-roundedmplus1c"><a href="javascript:;" class="membersModoru">戻る</a></div>
					<?php }?>
				</div><!-- /.link_block -->
			</article>
		 </div><!-- /.contents -->
	</div><!-- /.contents_wrap -->
<script type="text/javascript">
	if($(window).width() > 769) {
		$(document).find("#windowsize").removeClass('not-active');
	}
</script>
