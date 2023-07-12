<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('activity/entry/confirm.js') ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
</script>
<style type="text/css">
.shorichuucls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5Yem55CG5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
	background-color: rgba(255, 255, 255, .5);
}
</style>
<div id="shorichuucls"></div>
<!-- /header -->
<?php echo $this->Form->create('moshiKomiFrm',['id' => 'moshiKomiFrm','url' => ['controller' => 'activity', 'action' => 'entry']]);
	echo $this->Form->input('taisyoukbn', array('type' => 'hidden','value'=>$taisyoukbn));
	echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>$hyoudai));
	echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>$meisyou));
	echo $this->Form->input('kaisaidate', array('type' => 'hidden','value'=>$kaisaidate));
	echo $this->Form->input('kaisaitmfrom', array('type' => 'hidden','value'=>$kaisaitmfrom));
	echo $this->Form->input('kaisaitmto', array('type' => 'hidden','value'=>$kaisaitmto));
	echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>$bunruicd));
	echo $this->Form->input('sosikicd', array('type' => 'hidden','value'=>$sosikicd));
	echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$kbunruicd));
	echo $this->Form->input('arno', array('type' => 'hidden','value'=>$arno));
	echo $this->Form->end();
?>
<div class="contents_wrap">
	<div class="contents frame">
		<h1 class="h1 wf-roundedmplus1c">入力内容をご確認ください。</h1>
		<div class="step_block">
			<?php echo $this->Html->image('common/pc/step_02.gif', array('alt' => '確認'));?>
		</div><!-- /.step_block -->
		<div class="form_box break_line">
			<div class="input_box">
				<dl class="table">
					<dt class="th">
						<?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
								echo "会議名";
							} else {
								echo "イベント名";
							} ?></dt>
					<dd class="td">
						<p class="sub_title"><span class="month"><?php echo $hyoudai?></span></p>
						<p class="title"><?php echo $meisyou;?></p>
						<div class="date">
							<dl>
								<dt>日時：</dt>
								<dd>
									<?php
										echo $this->Common->getJapDate($kaisaidate);
										echo date("G:i", strtotime($kaisaitmfrom));
										echo '〜';
										echo date("G:i", strtotime($kaisaitmto));
									?>
								</dd>
							</dl>
						</div>
					</dd>
				</dl>
				<dl class="table">
					<dt class="th">会社名</dt>
					<dd class="td"  style="word-break: break-all;">
						<?php 
							echo $kaisyanm;
						?>
					</dd>
				</dl>
				<dl class="table">
					<dt class="th">氏名</dt>
					<dd class="td"><?php echo $kaiinnm;?></dd>
				</dl>
				<dl class="table">
					<dt class="th">メールアドレス</dt>
						<dd class="td">
							<?php echo $emailAdd; ?>
						</dd>
				</dl>
				<dl class="table">
					<dt class="th">備考</dt>
					<dd class="td"  style="word-break: break-all;">
					<?php echo nl2br($bikou); ?></dd>
				</dl>
			</div><!-- /.input_box -->
			<div class="button_area input_button clearfix">
				<div class="back_button">
					<?php echo $this->Form->create('modoruFrm',['id' => 'modoruFrm','url' => ['controller' => 'activity', 'action' => 'entry']]);?>
						<?php 
							echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>$hyoudai));
							echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>$meisyou));
							echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>$bunruicd));
							echo $this->Form->input('sosikicd', array('type' => 'hidden','value'=>$sosikicd));
							echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$kbunruicd));
							echo $this->Form->input('kaisaidate', array('type' => 'hidden','value'=>$kaisaidate));
							echo $this->Form->input('kaisaitmfrom', array('type' => 'hidden','value'=>$kaisaitmfrom));
							echo $this->Form->input('kaisaitmto', array('type' => 'hidden','value'=>$kaisaitmto));
							echo $this->Form->input('kaiinKbn', array('type' => 'hidden','value'=>$kaiinKbn));
							echo $this->Form->input('kaisyanm', array('type' => 'hidden','value'=>$kaisyanm));
							echo $this->Form->input('simei', array('type' => 'hidden','value'=>$kaiinnm));
							echo $this->Form->input('mailaddr', array('type' => 'hidden','value'=>$emailAdd));
							echo $this->Form->input('bikou', array('type' => 'hidden','value'=>$bikou));
							echo $this->Form->input('taisyoukbn', array('type' => 'hidden','value'=>$taisyoukbn));
							echo $this->Form->input('arno', array('type' => 'hidden','value'=>$arno));
							echo $this->Form->input('kaiinkbnmem', array('type' => 'hidden','value'=>$kaiinkbnmem));
							echo $this->Form->input('kaiincd', array('type' => 'hidden','value'=>$kaiincd));
						?>
						<?php echo $this->Form->submit("戻る", ['id' => 'back_button','name' =>'back_button']);?>
					<?php echo $this->Form->end();?>
				</div><!-- /.back_button -->
				<div class="confirm_button">
					<?php echo $this->Form->create('soshin',['url' => ['controller' => 'activity', 'action' => 'sendmail']]);?>
					<?php 
						echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>$hyoudai));
						echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>$meisyou));
						echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>$bunruicd));
						echo $this->Form->input('sosikicd', array('type' => 'hidden','value'=>$sosikicd));
						echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$kbunruicd));
						echo $this->Form->input('kaisaidate', array('type' => 'hidden','value'=>$kaisaidate));
						echo $this->Form->input('kaisaitmfrom', array('type' => 'hidden','value'=>$kaisaitmfrom));
						echo $this->Form->input('kaisaitmto', array('type' => 'hidden','value'=>$kaisaitmto));
						echo $this->Form->input('kaiinKbn', array('type' => 'hidden','value'=>$kaiinKbn));
						echo $this->Form->input('kaisyanm', array('type' => 'hidden','value'=>$kaisyanm));
						echo $this->Form->input('simei', array('type' => 'hidden','value'=>$kaiinnm));
						echo $this->Form->input('mailaddr', array('type' => 'hidden','value'=>$emailAdd));
						echo $this->Form->input('bikou', array('type' => 'hidden','value'=>$bikou));
						echo $this->Form->input('taisyoukbn', array('type' => 'hidden','value'=>$taisyoukbn));
						echo $this->Form->input('arnoVal', array('type' => 'hidden','value'=>$arno));
						echo $this->Form->input('kaiinkbnmem', array('type' => 'hidden','value'=>$kaiinkbnmem));
						echo $this->Form->input('kaiincd', array('type' => 'hidden','value'=>$kaiincd));
						echo $this->Form->input('captchaCode', array('type' => 'hidden','value'=>$this->request->data['captchaCode']));
					?>
					<?php echo $this->Form->submit("送信", ['id' => 'confirm_button']);?>
					<?php echo $this->Form->end();?>
				</div><!-- /.confirm_button -->
			</div><!-- /.button_area -->
		</div><!-- /.form_box -->
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->