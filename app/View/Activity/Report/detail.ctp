<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('activity/index.js') ?>
<?= $this->html->css('common/lightbox.css') ?>
<?= $this->Html->script('common/lightbox.js') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<style type="text/css">
	.not-active {
	   pointer-events: none;
	   cursor: default;
	}
	.break_line {
		word-break: break-all !important; 
		display: block !important;
	}
	.outerSyasin {
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		align-items: center;
		justify-content: center;
		-ms-flex-pack: center;
		min-height: 273px; 
		height:0px;
    }
</style>
	<!-- /header -->
		<div class="contents_wrap">
			<div class="contents frame">
			<article>
			<?php if ($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$EVENT_CD) {?>
				<div class="attention_block">
					<div class="attention_item">申込の受付、終了いたしました。</div>
				</div><!-- /.attention_block -->
			<?php }?>
			<h1 class="h1 detail_title wf-roundedmplus1c">
				<span class="sub_title"><?php echo $event_shousai['TKatudo']['hyoudai'];?></span>
				<span class="main_title"><?php echo $event_shousai['TKatudo']['meisyou'];?></span>
			</h1>
				<div class="detail_contents">
					<div class="article type_01" style="border-bottom: none;">
				<div class="article_wrap">
				<div class="article_block">
					<dl class="break_line">
						<dt>日時</dt>
							<dd><?php
							echo $this->Common->getJapDate($event_shousai['TKatudo']['kaisaidate']);
							echo date("G:i", strtotime($event_shousai['TKatudo']['kaisaitmfrom']));
							echo '〜';
							echo date("G:i", strtotime($event_shousai['TKatudo']['kaisaitmto']));
						?></dd>
					</dl>
					<dl class="break_line">
						<dt>場所</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['basyo']);?></dd>
					</dl>
						<?php if($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$EVENT_CD) {?>
					<dl class="break_line">
						<dt>内容</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['naiyou']);?></dd>
						</dl>
						<?php }?>
						<?php if($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD) {?>
					<dl class="break_line">
						<dt>議題</dt>
							<dd><?php echo nl2br($event_shousai['TKatudo']['gidai']);?></dd>
					</dl>
					<?php }?>
					<?php if($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$EVENT_CD) {
					if ($event_shousai['TKatudo']['kbunruicd'] == $Kenshukai || $event_shousai['TKatudo']['kbunruicd'] == $kouenkai || $event_shousai['TKatudo']['kbunruicd'] == $jinzaiikusei) {?>
					<dl class="break_line">
						<dt>講師</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['kousi']);?></dd>
					</dl>
					<?php }?>
					<dl class="break_line">
						<dt>対象</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['taisyou']);?></dd>
					</dl>
					<dl class="break_line">
						<dt>定員</dt>
						<dd>
							<?php
							if (!empty($event_shousai['TKatudo']['teiin'])) { echo $event_shousai['TKatudo']['teiin']."名"; }
							if (!empty($event_shousai['TKatudo']['teiincom']) && !empty($event_shousai['TKatudo']['teiin']) ) {
								echo "（".nl2br($event_shousai['TKatudo']['teiincom'])."）　"; 
							} else if (!empty($event_shousai['TKatudo']['teiincom'])) {
								echo nl2br($event_shousai['TKatudo']['teiincom']); 
							} ?>
						</dd>
					</dl>
					<dl class="break_line">
						<dt>費用</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['hiyou']);?></dd>
					</dl>
					<?php if ($event_shousai['TKatudo']['kbunruicd'] == $Kenshukai || $event_shousai['TKatudo']['kbunruicd'] == $kengakukai || $event_shousai['TKatudo']['kbunruicd'] == $kouryuuibento || $event_shousai['TKatudo']['kbunruicd'] == $jinzaiikusei) { ?>
					<dl class="break_line">
						<dt>集合場所</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['syugoubasyo']);?></dd>
					</dl>
					<?php }?>
					<dl class="break_line">
						<dt>申込期限</dt>
						<dd>
							<?php 
								if(
									($event_shousai['TKatudo']['kigendate'] == "0000-00-00" && $event_shousai['TKatudo']['kigentm'] == "00:00:00")
										|| ($event_shousai['TKatudo']['kigendate'] == "0000-00-00" || empty($event_shousai['TKatudo']['kigendate'])) || 
											(empty($event_shousai['TKatudo']['kigentm']) && empty($event_shousai['TKatudo']['kigendate']))) {
									echo "";
								} else {
									echo $this->Common->getJapDate($event_shousai['TKatudo']['kigendate']);
									if (!empty($event_shousai['TKatudo']['kigentm'])) {
										echo date("G:i", strtotime($event_shousai['TKatudo']['kigentm']));
									}
									
								}
							?>
						</dd>
					</dl>
					<?php }?>
					<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
					<dl class="break_line">
						<?php if($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD) { ?>
							<dt>出席者</dt>
						<?php } else {?>
							<dt>申込者</dt>
						<?php } ?>
						<dd>
							<?php $i = 0;
							if(!empty($applicants)): 
								foreach($applicants as $applicantsVal): 
									$i++;
									if($applicantsVal['TEntry']['kaiinkbn'] == 1): echo "*"; endif;
									echo $applicantsVal['TEntry']['mousikominm']."　　";
									if($i%5 == 0): echo "<BR>"; endif; 
								endforeach; 
							endif; ?>
						</dd>
					</dl>
					<?php } ?>
					<?php if($event_shousai['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD) { ?>
					<dl class="break_line">
						<dt>備考</dt>
						<dd><?php echo nl2br($event_shousai['TKatudo']['bikou']);?></dd>
					</dl>
					<?php }?>
					<?php if (!empty($syasinInfo) || !empty($previewInfo['syasin1']) || $image1 != "" || !empty($previewInfo['syasin2']) || $image2 != "" || !empty($previewInfo['syasin3']) || $image3 != "" ) {?>
				</div><!-- /.article_block -->
					<div id="windowsize" class="not-active figure_block clearfix">
					<?php if(!empty($syasinInfo)): foreach($syasinInfo as $syasinVal): ?>
					<figure class="figure mb80">
						<a class="imgzoom outerSyasin" href="<?php echo $this->base."/activity/getSyasin/".$syasinVal['TSyasin']['syasinkey']."/".$syasinVal['TSyasin']['rno'];?>" data-lightbox="img_1">
	              		<img src="<?php echo $this->base."/activity/getSyasin/".$syasinVal['TSyasin']['syasinkey']."/".$syasinVal['TSyasin']['rno'];?>" class="maxsize_activitySyasin"/>
	           	 		</a>
						<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $syasinVal['TSyasin']['title'];?></figcaption>
					</figure>
					<?php endforeach; else:?>
					<?php if (!empty($previewInfo['syasin1'])) {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/activity/ViewSyasin/syasin1";?>" data-lightbox="img_1">
								<img src="<?php echo $this->base."/activity/ViewSyasin/syasin1";?>" class="maxsize_activitySyasin"/>
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin1Title']; ?></figcaption>
							</figure>
						<?php } else if($image1 != "") {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $image1;?>" data-lightbox="img_1">
								<img src="<?php echo $image1;?>" class="maxsize_activitySyasin">
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin1Title']; ?></figcaption>
							</figure>
						<?php } ?>
						<?php if (!empty($previewInfo['syasin2'])) {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/activity/ViewSyasin/syasin2";?>" data-lightbox="img_1">
								<img src="<?php echo $this->base."/activity/ViewSyasin/syasin2";?>" class="maxsize_activitySyasin"/>
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin2Title']; ?></figcaption>
							</figure>
						<?php } else if($image2 != "") {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $image2;?>" data-lightbox="img_1">
								<img src="<?php echo $image2;?>" class="maxsize_activitySyasin">
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin2Title']; ?></figcaption>
							</figure>
						<?php } ?>
						<?php if (!empty($previewInfo['syasin3'])) {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $this->base."/activity/ViewSyasin/syasin3";?>" data-lightbox="img_1">
								<img src="<?php echo $this->base."/activity/ViewSyasin/syasin3";?>" class="maxsize_activitySyasin"/>
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin3Title']; ?></figcaption>
							</figure>
						<?php } else if($image3 != "") {?>
							<figure class="figure mb80">
								<a class="imgzoom outerSyasin" href="<?php echo $image3;?>" data-lightbox="img_1">
								<img src="<?php echo $image3;?>" class="maxsize_activitySyasin">
								</a>
								<figcaption style="display: block;width: 273px;" class="figcaption"><?php echo $event_shousai['TKatudo']['syasin3Title']; ?></figcaption>
							</figure>
						<?php } ?>
					<?php endif; ?>
					</div><!-- /.caption_block -->

					<div class="description">
						<div class="article_block">
						<?php }?>
							<dl class="break_line">
								<dt>活動ｺﾒﾝﾄ</dt>
								<dd><?php echo nl2br($event_shousai['TKatudo']['comment']);?></dd>
							</dl>
						</div>
					<?php if (!empty($syasinInfo) || !empty($previewInfo['syasin1']) || $image1 != "" || !empty($previewInfo['syasin2']) || $image2 != "" || !empty($previewInfo['syasin3']) || $image3 != "" ) {?>
					</div><!-- /.descriptio_block -->
					<?php }?>
				</div><!-- /.article_wrap -->
				</div><!-- /.type_01 -->
		<?php echo $this->Form->create('MSosiki', ['id' => 'MSosiki', 'url' => ['controller' => 'activity', 'action' => 'reportSearch'.$curtime]]);
			  echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
			  echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
			  echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$selectedkaigiFrom));
			  echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$selectedkaigiTo));
			  echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$selectedeventFrom));
			  echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$selectedeventTo));
			  echo $this->Form->input('scroll_val', array('type' => 'hidden','value'=>$scroll_val));
			  echo $this->Form->input('srchtyp', array('type' => 'hidden','id' => 'srchtyp','name' => 'srchtyp','value'=>$srchtyp));
		?> <?php echo $this->Form->end();?>
				<?php if(!isset($previewadmin)):?>
				<div class="event_link_block">
					<div class="link_item event_detail wf-roundedmplus1c">
						<a href="javascript:;" class="backLink">戻る</a>
					</div>
				</div><!-- /.link_block -->
				<?php endif;?>
			</div><!-- /.detail_contents -->
		</article>
		</div><!-- /.contents -->
		</div><!-- /.contents_wrap -->
<script type="text/javascript">
	if($(window).width() > 769) {
		$(document).find("#windowsize").removeClass('not-active');
	}
	document.getElementById('reportdetailheader').innerHTML = "<?php echo $event_shousai['TKatudo']['meisyou'];?>";
</script>