<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('join/style.css') ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
</script>
<!-- /header -->
<div class="contents_wrap">
	<div class="contents frame">
		<h1 class="h1 wf-roundedmplus1c">入力内容をご確認ください。</h1>
			<div class="step_block">
				<?php echo $this->Html->image('common/pc/step_02.gif', array('alt' => '確認'));?>
			</div><!-- /.step_block -->
			<div class="form_box">
				<div class="input_box">
					<dl class="table">
						<dt class="th">会員種別</dt>
						<dd class="td"><?php echo $kaiinsbName;?></dd>
					</dl>
					<?php if ($kaiinsb == $this->Constants->SEIKAIIN || $kaiinsb == $this->Constants->JUNKAIIN ): ?>
						<dl class="table">
							<dt class="th">紹介者会社名</dt>
							<dd class="td" style="max-width: 100px!important; ">
							<?php 
								echo $syokaiKaisyaNm;
							?>
							</dd>
						</dl>
						<dl class="table">
							<dt class="th">紹介者名</dt>
							<dd class="td"><?php echo $syokaiNm;?></dd>
						</dl>
					<?php endif; ?>
					<dl class="table">
						<dt class="th">会社名</dt>
						<dd class="td" style="max-width: 100px!important; ">
						<?php echo $kaisyaNm;?>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">会社名かな</dt>
						<dd class="td"><?php echo $kaisyaNmKana;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">役職名</dt>
						<dd class="td"><?php echo $yakuNm;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">氏名</dt>
						<dd class="td"><?php echo $simei;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">氏名かな</dt>
						<dd class="td"><?php echo $simeiKana;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">電話番号</dt>
						<dd class="td"><?php echo $telno;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">メールアドレス</dt>
						<dd class="td"><?php echo $mailAddr;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">業種</dt>
						<dd class="td"><?php echo $gyosyuName;?></dd>
					</dl>
					<dl class="table">
						<dt class="th">備考</dt>
						<dd class="td" style="max-width: 100px!important; ">
						<?php echo nl2br($bikou); ?></dd>
					</dl>
				</div><!-- /.input_box -->
			<div class="button_area input_button clearfix">
				<div class="back_button">
					<?php echo $this->Form->create('modoruFrm',['id' => 'modoruFrm','url' => ['controller' => 'join', 'action' => 'entry']]);?>
						<?php 
						echo $this->Form->input('kaiinsbName', array('type' => 'hidden','value'=>$kaiinsbName));
						echo $this->Form->input('gyosyuName', array('type' => 'hidden','value'=>$gyosyuName));
						echo $this->Form->input('selectedKaiinsbnm', array('type' => 'hidden','value'=>$kaiinsb));
						echo $this->Form->input('syokaiKaisyaNm', array('type' => 'hidden','value'=>$syokaiKaisyaNm));
						echo $this->Form->input('syokaiNm', array('type' => 'hidden','value'=>$syokaiNm));
						echo $this->Form->input('kaisyaNm', array('type' => 'hidden','value'=>$kaisyaNm));
						echo $this->Form->input('kaisyaNmKana', array('type' => 'hidden','value'=>$kaisyaNmKana));
						echo $this->Form->input('yakuNm', array('type' => 'hidden','value'=>$yakuNm));
						echo $this->Form->input('simei', array('type' => 'hidden','value'=>$simei));
						echo $this->Form->input('simeiKana', array('type' => 'hidden','value'=>$simeiKana));
						echo $this->Form->input('telno', array('type' => 'hidden','value'=>$telno));
						echo $this->Form->input('mailAddr', array('type' => 'hidden','value'=>$mailAddr));
						echo $this->Form->input('confMailAddr', array('type' => 'hidden','value'=>$confMailAddr));
						echo $this->Form->input('selectedGyosyunm', array('type' => 'hidden','value'=>$gyosyu));
						echo $this->Form->input('bikou', array('type' => 'hidden','value'=>$bikou));
						?>
						<?php echo $this->Form->submit("戻る", ['id' => 'back_button' ,'name' =>'back_button']);?>
					<?php echo $this->Form->end();?>
				</div><!-- /.back_button -->
				<div class="confirm_button">
					<?php echo $this->Form->create('nyukaiTorokuFrm',['id'=>'nyukaiTorokuFrm','url' => ['controller' => 'join', 'action' => 'sendmail']]);?>
						<?php
							echo $this->Form->input('syokaikaisyanm', array('type' => 'hidden','value'=>$syokaiKaisyaNm));
							echo $this->Form->input('syokainm', array('type' => 'hidden','value'=>$syokaiNm));
							echo $this->Form->input('kaiinsbName', array('type' => 'hidden','value'=>$kaiinsbName));
							echo $this->Form->input('gyosyuName', array('type' => 'hidden','value'=>$gyosyuName));
							echo $this->Form->input('kaiinsbcd', array('type' => 'hidden','value'=>$kaiinsb));
							echo $this->Form->input('kaisyanm', array('type' => 'hidden','value'=>$kaisyaNm));
							echo $this->Form->input('kaisyanmkana', array('type' => 'hidden','value'=>$kaisyaNmKana));
							echo $this->Form->input('yakunm', array('type' => 'hidden','value'=>$yakuNm));
							echo $this->Form->input('simei', array('type' => 'hidden','value'=>$simei));
							echo $this->Form->input('simeikana', array('type' => 'hidden','value'=>$simeiKana));
							echo $this->Form->input('telno', array('type' => 'hidden','value'=>$telno));
							echo $this->Form->input('mailaddr', array('type' => 'hidden','value'=>$mailAddr));
							echo $this->Form->input('confMailAddr', array('type' => 'hidden','value'=>$confMailAddr));
							echo $this->Form->input('gyosyucd', array('type' => 'hidden','value'=>$gyosyu));
							echo $this->Form->input('bikou', array('type' => 'hidden','value'=>$bikou));
							echo $this->Form->input('captchaCode', array('type' => 'hidden','value'=>$this->request->data['captchaCode']));
						?>
						<?php echo $this->Form->submit("送信", ['id' => 'confirm_button']);?>
					<?php echo $this->Form->end();?>
				</div><!-- /.confirm_button -->
			</div><!-- /.button_area -->
		</div><!-- /.form_box -->
	</div><!-- /.entry_contents -->
</div><!-- /.contents_wrap -->