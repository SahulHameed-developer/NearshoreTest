<!--header -->
<?php $this->layout="default";?>
<!-- /header -->
<!-- style/index -->
<?= $this->html->css('beneficial/style.css') ?>
<?= $this->html->css('common/lightbox.css') ?>
<?= $this->Html->script('common/lightbox.js') ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".ichiran_page").click(function () {
			if($("#recCountBack").val() == "top") {
				window.location = "<?php echo $this->Html->url(array('controller' => 'Top', 'action' => 'index')); ?>";
			} else {
				$( "#beneficialIndexfrm" ).submit();
			}
		});
		function sessionTimeCheck(event) {
			var logoutStatus = window.localStorage.getItem("LogoutStatus");
			if (logoutStatus == 1) {
				return false;
			}
		}
		$('a.sessionTimeCheck').click(sessionTimeCheck);
	});
</script>
<style type="text/css">
	.not-active {
	   pointer-events: none;
	   cursor: default;
	}
	.outerSyasin {
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		align-items: center;
		justify-content: center;
		-ms-flex-pack: center;
		min-height: 300px; 
		height:0px;
    }
</style>
<div class="contents_wrap">
	<div class="contents frame">
		<article>
			<h1 class="h1 wf-roundedmplus1c">
				<span>
					<span class="headline beneficial_title"><?php echo $yuekiInfo['TYueki']['title']; ?></span>
					<span class="date">
						<?php 
							$yuekidt = $this->Common->getDateFormat($yuekiInfo['TYueki']['jyohodt']);
							echo $yuekidt."　情報提供：".$yuekiInfo['TYueki']['kaiinnm'];
						?>
					</span>
				</span>
			</h1>
			<div class="detail_contents">
				<div class="description">
					<p><?php echo nl2br($yuekiInfo['TYueki']['naiyo']); ?></p>
				</div><!-- /.descriptio -->
				<div id="windowsize" class="figure_block not-active clearfix">
					<?php if (!empty($previewInfo['syasin1'])) {?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $this->base."/Beneficial/viewSyasin/syasin1";?>" data-lightbox="img_1">
							<img src="<?php echo $this->base."/Beneficial/viewSyasin/syasin1";?>" class="maxsize_yuekiSyasin"/>
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin1Title']; ?></figcaption>
						</figure>
					<?php } else if($image1 != "") { ?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $image1;?>" data-lightbox="img_1">
							<img src="<?php echo $image1;?>" class="maxsize_yuekiSyasin"/>
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin1Title']; ?></figcaption>
						</figure>
					<?php } ?>
					<?php if (!empty($previewInfo['syasin2'])) { ?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $this->base."/Beneficial/viewSyasin/syasin2";?>" data-lightbox="img_1">
							<img src="<?php echo $this->base."/Beneficial/viewSyasin/syasin2";?>" class="maxsize_yuekiSyasin"/>
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin2Title']; ?></figcaption>
						</figure>
					<?php } else if($image2 != "") { ?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $image2;?>" data-lightbox="img_1">
							<img src="<?php echo $image2;?>" class="maxsize_yuekiSyasin">
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin2Title']; ?></figcaption>
						</figure>
					<?php } ?>
					<?php if (!empty($previewInfo['syasin3'])) {?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $this->base."/Beneficial/viewSyasin/syasin3"; ?>" data-lightbox="img_1">
							<img src="<?php echo $this->base."/Beneficial/viewSyasin/syasin3"; ?>" class="maxsize_yuekiSyasin"/>
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin3Title']; ?></figcaption>
						</figure>
					<?php } else if($image3 != "") {?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $image3;?>" data-lightbox="img_1">
							<img src="<?php echo $image3;?>" class="maxsize_yuekiSyasin">
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $yuekiInfo['TYueki']['syasin3Title']; ?></figcaption>
						</figure>
					<?php } ?>
					<?php if(!empty($syasin_info)): foreach ($syasin_info as $getpic): ?>
						<figure class="figureSize mb80">
							<a class="imgzoom outerSyasin" href="<?php echo $this->base."/Beneficial/getSyasin/".$yuekiInfo['TYueki']['syasin']."/".$getpic['TSyasin']['rno'];?>" data-lightbox="img_1">
							<img src="<?php echo $this->base."/Beneficial/getSyasin/".$yuekiInfo['TYueki']['syasin']."/".$getpic['TSyasin']['rno'];?>" class="maxsize_yuekiSyasin"/>
							</a>
							<figcaption style="display: block;width: 300px;" class="figcaption"><?php echo $getpic['TSyasin']['title']; ?></figcaption>
						</figure>
					<?php endforeach; else: ?>
					<?php endif; ?>
				</div><!-- /.caption_block -->
				<div class="attachment_block">
					<?php if(!empty($previewInfo['file1'])) {?>
						<dl>
							<?php $filena1 =$previewInfo['file1Name'];  ?>
							<?php if($yuekiInfo['TYueki']['file1Title'] == "") { ?>			
								<dd class="inline"><?php echo $this->Html->link('添付ファイル１','viewFile/file1',
									['target' => '_blank', 'download'=>$filena1, 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } else { ?>
								<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file1Title'],'viewFile/file1',['target' => '_blank', 'download'=>$filena1, 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } ?>
						</dl>
					<?php } else if($path1file != "") { ?>
						<dl>
							<?php $filename1 = split('/',$path1file);
							if (file_exists(WWW_APP_ROOT.$yuekiFilePath.$path1file)) { ?>
								<?php if($yuekiInfo['TYueki']['file1Title'] == "") { ?>			
									<dd class="inline"><?php echo $this->Html->link('添付ファイル１',Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path1file,
										['target' => '_blank', 'download'=>$filename1[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } else { ?>
									<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file1Title'],Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path1file,['target' => '_blank', 'download'=>$filename1[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } ?>
							<?php } else { ?>
								<dd>
									<span tooltip="ファイルが存在しません。"><?php echo $filename1[1]; ?></span>
								</dd>
							<?php } ?>
						</dl>
					<?php } ?>
					<?php if(!empty($previewInfo['file2'])) {?>
						<dl>
							<?php if($yuekiInfo['TYueki']['file2Title'] == "") { ?>		
								<dd class="inline"><?php echo $this->Html->link('添付ファイル２','viewFile/file2',
									['target' => '_blank', 'download'=>$previewInfo['file2Name'], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } else { ?>
								<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file2Title'],'viewFile/file2',['target' => '_blank', 'download'=>$previewInfo['file2Name'], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php }?>
						</dl>
					<?php } else if($path2file != "") { ?>
						<dl>
							<?php $filename2 = split('/',$path2file);
							if (file_exists(WWW_APP_ROOT.$yuekiFilePath.$path2file)) { ?>
								<?php if($yuekiInfo['TYueki']['file2Title'] == "") { ?>			
									<dd class="inline"><?php echo $this->Html->link('添付ファイル２',Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path2file,
											['target' => '_blank', 'download'=>$filename2[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } else { ?>
									<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file2Title'],Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path2file,
											['target' => '_blank', 'download'=>$filename2[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } ?>
							<?php } else { ?>
								<dd>
									<span tooltip="ファイルが存在しません。"><?php echo $filename2[1]; ?></span>
								</dd>
							<?php } ?>
						</dl>
					<?php } ?>
					<?php if(!empty($previewInfo['file3'])) {?>
						<dl>
							<?php if($yuekiInfo['TYueki']['file3Title'] == "") { ?>
								<dd class="inline"><?php echo $this->Html->link('添付ファイル３','viewFile/file3',
										['target' => '_blank', 'download'=>$previewInfo['file3Name'], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } else { ?>
								<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file3Title'],'viewFile/file3',['target' => '_blank', 'download'=>$previewInfo['file3Name'], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } ?>
						</dl>
					<?php } else if($path3file != "") { ?>
						<dl>
							<?php $filename3 = split('/',$path3file);
							if (file_exists(WWW_APP_ROOT.$yuekiFilePath.$path3file)) { ?>
								<?php if($yuekiInfo['TYueki']['file3Title'] == "") { ?>
									<dd class="inline"><?php echo $this->Html->link('添付ファイル３',Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path3file,
										['target' => '_blank', 'download'=>$filename3[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } else { ?>
									<dd class="inline"><?php echo $this->Html->link($yuekiInfo['TYueki']['file3Title'],Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$path3file,
										['target' => '_blank', 'download'=>$filename3[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
								<?php } ?>
							<?php } else { ?>
								<dd>
									<span tooltip="ファイルが存在しません。"><?php echo $filename3[1]; ?></span>
								</dd>
							<?php } ?>
						</dl>
					<?php } 
					$i = 1; 
					if(!empty($file_info)): foreach ($file_info as $getfile): 
						$filename = explode("/",$getfile['TFile']['filepath']);
						if (file_exists(WWW_APP_ROOT.$yuekiFilePath.$getfile['TFile']['filepath'])) { ?>
						<dl>
							<?php if($getfile['TFile']['title'] == "") { ?>
								<dd class="inline"><?php echo $this->Html->link('添付ファイル'.mb_convert_kana($i,'A'), Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$getfile['TFile']['filepath'],
									['target' => '_blank', 'download'=>$filename[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } else { ?>
								<dd class="inline"><?php echo $this->Html->link($getfile['TFile']['title'], Router::url('/', true).WWW_APP_ROOT.$yuekiFilePath.$getfile['TFile']['filepath'],['target' => '_blank', 'download'=>$filename[1], 'class' => 'anchorFileDownload sessionTimeCheck']); ?></dd>
							<?php } ?>
						</dl>
						<?php } else { ?>
						<dl>
							<dd>
								<span tooltip="ファイルが存在しません。"><?php echo $filename[1]; ?></span>
							</dd>
						</dl>
						<?php } ?>
					<?php $i++; endforeach; else: ?>
					<?php endif; ?>
				</div><!-- /.attachment_block -->
				<div class="description" style="margin-top: 20px;word-break: break-all;">
					<?php if (!isset($previewadmin)) {?>
					<p><a style="display: inline-block;text-decoration: underline;color: blue;" href="<?php echo $yuekiInfo['TYueki']['sankourl'];?>" target="_blank"><?php echo $yuekiInfo['TYueki']['sankourl'];?></a></p>
					<?php } else { ?>
					<p><?php echo $yuekiInfo['TYueki']['sankourl'];?></p>
					<?php } ?>
				</div>
			</div><!-- /.detail_contents -->
			<?php if (!isset($previewadmin)) { ?>
				<div class="link_block">
					<div class="link_item"><a href="javascript:;" class="ichiran_page">戻る</a></div>
				</div><!-- /.link_block -->
			<?php } ?>
			<?php
				echo $this->Form->create('beneficialIndexfrm', ['id' => 'beneficialIndexfrm', 'url' => ['controller' => 'Beneficial', 'action' => 'index']]);
				echo $this->Form->input('recCountBack', array('id'=>'recCountBack','type' => 'hidden','value' => $pageCount));
				echo $this->Form->input('scroll_val', array('type' => 'hidden','value'=>$scroll_val));
				echo $this->Form->end();
			?>
		</article>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->
<script type="text/javascript">
	if($(window).width() > 769) {
		$(document).find("#windowsize").removeClass('not-active');
	}
	document.getElementById('beneficialdetailheader').innerHTML = "<?php echo $yuekiInfo['TYueki']['title']; ?>";
</script>