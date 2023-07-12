<!--header -->
<?php $this->layout="default";?>
<?= $this->Html->script('common/jquery.validate.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->html->css('activity/style.css?v=1') ?>
<?= $this->Html->script('activity/index.js?v=1') ?>
<?= $this->Html->script('activity/cancel.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<style type="text/css">
	.break_line {
		word-break: break-all !important; 
		display: block !important;
	}
@media screen and (min-width: 769px) {
  .article_box .captcha {
    width: 340px !important;
  }
  .display_inline_block {
  	display: inline-block;
  }
}
</style>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
	captchaCode = "<?php echo $this->Session->read('captcha_code'); ?>";
	var btop = "<?php echo $b_top; ?>";
</script>
<!-- /header -->
<?php 

echo $this->Form->create('shosaiModoruFrm', ['id' => 'shosaiModoruFrm', 'url' => ['controller' => 'activity', 'action' => 'search'.$curtime]]);
	echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$event_shousai['TKatudo']['kbunruicd']));
	echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
	echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
	echo $this->Form->input('scroll_val', array('type' => 'hidden','value'=>$scroll_val));
	echo $this->Form->input('srchtyp', array('type' => 'hidden','id' => 'srchtyp','name' => 'srchtyp','value'=>$srchtyp));
echo $this->Form->end();

echo $this->Form->create('moshiKomiFrm', ['id' => 'moshiKomiFrm', 'url' => ['controller' => 'activity', 'action' => 'entry']]);
	echo $this->Form->input('arno', array('type' => 'hidden'));
	echo $this->Form->end();
?>
<div class="contents_wrap">
	<div class="contents frame">
		<?php 
			echo $this->Form->create('moshiKomitorikeshiFrm', ['id' => 'moshiKomitorikeshiFrm', 'url' => ['controller' => 'activity', 'action' => 'cancel'.$curtime]]);
			echo $this->Form->input('arno', array('type' => 'hidden','value'=>(isset($event_shousai['TKatudo']['arno'])) ? $event_shousai['TKatudo']['arno'] : ''));
			echo $this->Form->input('kaiinKbn', array('type' => 'hidden','value'=>(isset($event_shousai['TKatudo']['taisyoukbn'])) ? $event_shousai['TKatudo']['taisyoukbn'] : ''));
			echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>(isset($event_shousai['TKatudo']['hyoudai'])) ? $event_shousai['TKatudo']['hyoudai'] : ''));
			echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>(isset($event_shousai['TKatudo']['meisyou'])) ? $event_shousai['TKatudo']['meisyou'] : ''));
			echo $this->Form->input('kaisyanm', array('type' => 'hidden','value'=>(isset($event_shousai['kaigiev']['kaisyanm'])) ? $event_shousai['kaigiev']['kaisyanm'] : ''));
			echo $this->Form->input('simei', array('type' => 'hidden','value'=>(isset($event_shousai['kaigiev']['simei'])) ? $event_shousai['kaigiev']['simei'] : ''));
			echo $this->Form->input('mailaddr', array('type' => 'hidden','value'=>(isset($event_shousai['kaigiev']['mailaddr'])) ? $event_shousai['kaigiev']['mailaddr'] : ''));
			echo $this->Form->input('bikou', array('type' => 'hidden','value'=>(isset($event_shousai['kaigiev']['bikou'])) ? $event_shousai['kaigiev']['bikou'] : ''));
			echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>(isset($event_shousai['TKatudo']['bunruicd'])) ? $event_shousai['TKatudo']['bunruicd'] : ''));
			echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
			echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
			echo $this->Form->input('screenName', array('type' => 'hidden','value'=>'kaigi'));
		?>
		<article>
			<h1 class="h1 detail_title wf-roundedmplus1c">
				<span class="sub_title"><?php echo $event_shousai['TKatudo']['hyoudai'];?></span>
				<span class="main_title"><?php echo $event_shousai['TKatudo']['meisyou'];?></span>
			</h1>
			<div class="detail_contents">
			<!-- 活動カレンダー詳細 -->
				<div class="article type_01">
					<div class="article_wrap">
						<div class="article_block">
							<dl>
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
							<dl class="break_line">
								<dt>議題</dt>
								<dd><?php echo nl2br($event_shousai['TKatudo']['gidai']);?></dd>
							</dl>
							<?php $cancelflg = 0; if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm'])) { ?>
							<dl class="break_line">
								<dt>出席者</dt>
								<dd>
									<?php $i = 0;
									if(!empty($applicants)): 
										foreach($applicants as $applicantsVal): 
											$i++;
											if($applicantsVal['TEntry']['kaiinkbn'] == 1): echo "*"; endif;
											echo $applicantsVal['TEntry']['mousikominm']."　　";
											if($applicantsVal['TEntry']['kaiincd']==$_SESSION['Auth']['User']['TKaiin']['kaiincd']) {
												$cancelflg = 1;
											}
											if($i%5 == 0): echo "<BR>"; endif; 
										endforeach; 
									endif; ?>
								</dd>
							</dl>
							<?php } ?>
							<?php if($cancelflg == 1 && !isset($previewadmin)) { ?>
								<div class="article_box">
									<div class="input_box">
										<dl class="table required_form" style="border-top: 0px; padding-top: 10px;">
											<dt class="th" style="padding-top: 15px;">キャプチャ</dt>
											<dd class="td">
												<div class="error-list" style="width: 100%;">
													<img src="data:image/jpeg;base64,<?php echo $this->request->data['captchaImageData']; ?>" alt="CAPTCHA" class="captcha-image" style="width:auto;height: 50px;">
													<img src= "<?php echo $this->base; ?>/app/webroot/img/common/refresh.png" class="refresh-captcha" title="キャプチャを更新するには、ここをクリックしてください。" style="width: 25px; cursor: pointer;padding-top: 12px;"/>
													<div class="display_inline_block">
														<?php echo $this->Form->input('captchaCode', 
																			array(
																					'type' => 'text',
																					'id' => 'captchaCode',
																					'name'=>'captchaCode',
																					'label' => false,
																					'autocomplete' => 'off',
																					'maxlength'=>'6',
																					'placeholder'=>'左に表示されている文字列を入力してください',
																					'style' => 'margin-top:12px;',
																					'class' => 'inputval captcha ime-ModeDisable'));?>
													</div>
													<label style="display: block;">
														<font color='red'>
															<?php if (!empty($this->Session->read('errorMsgs.captchaCode.0'))) { echo $this->Session->read('errorMsgs.captchaCode.0'); }?>
														</font>
													</label>
												</div>
											</dd>
										</dl>
									</div><!-- /.input_box -->
								</div><!-- /.article_box -->
							<?php } ?>
						</div><!-- /.article_block -->
					</div><!-- /.article_wrap -->
				</div><!-- /.type_01 -->
				<?php if(!isset($previewadmin)) { ?>
				<div class="event_link_block clearfix">
					<div class="link_item event_detail f_left">
						<a href="javascript:;" class="shosaiModoru">戻る</a>
					</div>
					<?php if($cancelflg == 0) { ?>
					<div class="link_item event_contact wf-roundedmplus1c f_right">
						<a href="javascript:;" class="shuseki"
							data-arno="<?php echo $event_shousai['TKatudo']['arno'];?>">出席する</a>
					</div>
					<?php } else { ?>
					<div class="link_item event_contact wf-roundedmplus1c f_right">
						<a href="javascript:;" class="shusekiTorikeshi" data-arno="<?php echo $event_shousai['TKatudo']['arno'];?>">出席を取り消す</a>
					</div>
					<?php } ?>
				</div>
				<?php } ?><!-- /.link_block -->
			</div><!-- /.detail_contents -->
		</article>
		<?php echo $this->Form->end();?>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->