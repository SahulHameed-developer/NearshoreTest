<!--header -->
<?php $this->layout="default";?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('join/index.js') ?> 
<?= $this->html->css('join/style.css') ?>
<style type="text/css">
@media screen and (min-width: 769px) {
  .form_box .captcha {
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
	var RESTRICT_MAIL_ADDR = "<?php echo ConstantsComponent::$RESTRICT_MAIL_ADDR; ?>";
	captchaCode = "<?php echo $this->Session->read('captcha_code'); ?>";
</script>
<!-- /header -->
<div class="contents_wrap">
	<div class="contents frame">
		<h1 class="h1 wf-roundedmplus1c"><span>入会申込</span></h1>
		<div class="description">
			<p>当サービスをご利用くださいまして、まことにありがとうございます。<br>当協会では、皆様のプライバシー保護を重要と考えており、お送りいただいた情報は厳重に管理いたします。</p>
		</div><!-- /.description -->
		<div class="step_block">
			<?php echo $this->Html->image('common/pc/step_01.gif', array('alt' => '入力'));?>
		</div><!-- /.step_block -->
		<?php echo $this->Form->create('nyukai',['url' => ['controller' => 'join', 'action' => 'confirm']]);?>
		<?php echo $this->Form->input('kaiinsbName', array('id' => 'kaiinsbName','type' => 'hidden','value' => $kaiinsbName)); ?>
		<?php echo $this->Form->input('gyosyuName', array('id' => 'gyosyuName','type' => 'hidden','value' => $gyosyuName)); ?>
		<?php echo $this->Form->input('buttonSel', array('type' => 'hidden','value'=>$buttonSel));?>
			<div class="form_box">
				<div class="input_box">
					<dl class="table required_form">
						<dt class="th">会員種別</dt>
						<dd class="td">
							<div class="error-list">
								<div class="select_group">
									<div class="select_wrap">
										<?php echo $this->Form->input('kaiinsbnm', array('type' => 'select',
																	'options' => $kaiinsbnm, 
																	'id' => 'members_type',
																	'label' => false,
																	'value' => $selectedKaiinsbnm,
																	'empty'=> array(''=> array(
																			'name' =>'会員種別を選択してください',
																			'value' => '',
																			'disabled' => TRUE,
																			'selected' => TRUE)),
																	'name' => 'members_type'));?>
									</div><!-- /.select_wrap -->
								</div><!-- /.select_group -->
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.kaiinsbcd.0'))) { echo $this->Session->read('errorMsg.kaiinsbcd.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table" id="reqSyokaiKaisyaNm">
						<dt class="th">紹介者会社名</dt>
						<dd class="td">
							<p class="note">※ ご紹介の場合は入力してください</p>
							<div class="error-list">
								<?php echo $this->Form->input('syokaikaisyanm', array('type' => 'text', 'class'=>'doublebyte', 'id' => 'syokaikaisyanm', 'label' => false,
									'maxlength'=>'100','name' => 'syokaikaisyanm', 'placeholder' => '全角で入力してください','value' => $syokaiKaisyaNm));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.syokaikaisyanm.0'))) { echo $this->Session->read('errorMsg.syokaikaisyanm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table" id="reqSyokaiNm">
						<dt class="th">紹介者名</dt>
						<dd class="td">
							<p class="note">※ ご紹介の場合は入力してください</p>
							<div class="error-list">
								<?php echo $this->Form->input('syokainm', array('type' => 'text', 'class'=>'doublebyte','id' => 'syokainm', 'label' => false,
									'maxlength'=>'40','name' => 'syokainm', 'placeholder' => '姓　名','value' => $syokaiNm));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.syokainm.0'))) { echo $this->Session->read('errorMsg.syokainm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">会社名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaisyanm', array('type' => 'text', 'class'=>'doublebyte','id' => 'kaisyanm', 'label' => false,
									'maxlength'=>'100','name' => 'kaisyanm', 'placeholder' => '全角で入力してください','value' => $kaisyaNm));?>
							</div>
						<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.kaisyanm.0'))) { echo $this->Session->read('errorMsg.kaisyanm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">会社名かな</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaisyanmkana', array('type' => 'text', 'class'=>'doublebyte','id' => 'kaisyanmkana', 'label' => false,
									'maxlength'=>'255','name' => 'kaisyanmkana', 'placeholder' => '全角ひらがなで入力してください。','value' => $kaisyaNmKana));?>
							</div>
						<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.kaisyanmkana.0'))) { echo $this->Session->read('errorMsg.kaisyanmkana.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">役職名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('yakunm', array('type' => 'text', 'class'=>'doublebyte','id' => 'yakunm', 'label' => false,
									'maxlength'=>'40','name' => 'yakunm', 'placeholder' => '全角で入力してください','value' => $yakuNm));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.yakunm.0'))) { echo $this->Session->read('errorMsg.yakunm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">氏名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('simei', array('type' => 'text', 'class'=>'doublebyte','id' => 'simei', 'label' => false,
									'maxlength'=>'40','name' => 'simei', 'placeholder' => '姓　名','value' => $simei));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.simei.0'))) { echo $this->Session->read('errorMsg.simei.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">氏名かな</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('simeikana', array('type' => 'text', 'class'=>'doublebyte','id' => 'simeikana', 'label' => false,
									'maxlength'=>'40','name' => 'simeikana', 'placeholder' => 'せい　めい','value' => $simeiKana));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.simeikana.0'))) { echo $this->Session->read('errorMsg.simeikana.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">電話番号</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('telno', array('type' => 'text', 'class'=>'ime-ModeDisable', 'id' => 'telno', 'label' => false,
									'maxlength'=>'15','name' => 'telno', 'placeholder' => '000-000-0000','value' => $telno));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.telno.0'))) { echo $this->Session->read('errorMsg.telno.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('mailaddr', array('type' => 'text', 'class'=>'ime-ModeDisable underscoresingle','id' => 'mailaddr', 'label' => false,
									'maxlength'=>'100','name' => 'mailaddr', 'placeholder' => '半角英数記号で入力してください','value' => $mailAddr));?>
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.mailaddr.0'))) { echo $this->Session->read('errorMsg.mailaddr.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">確認用メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('confMailaddr', array('type' => 'text', 'class'=>'ime-ModeDisable underscoresingle','id' => 'confMailaddr', 'label' => false,
									'maxlength'=>'100','name' => 'confMailaddr', 'placeholder' => 'メールアドレスをもう一度入力してください','value' => $confMailAddr));?>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">業種</dt>
						<dd class="td">
							<div class="error-select">
								<div class="select_group">
									<div class="select_wrap">
										<?php echo $this->Form->input('gyosyunm',array('type'=>'select',
																			'options'=>$gyosyunm,
																			'id'=>'industry',
																			'label'=>false,
																			'value'=>$selectedGyosyunm,
																			'empty'=> array(''=> array(
																					'name' =>'業種を選択してください',
																					'value' => '',
																					'disabled' => TRUE,
																					'selected' => TRUE)),
																			'name'=>'industry'));?>
									</div><!-- /.select_wrap -->
								</div><!-- /.select_group -->
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.gyosyucd.0'))) { echo $this->Session->read('errorMsg.gyosyucd.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">備考</dt>
						<dd class="td">
						<div class="error-list">
							<div>
								<textarea name="bikou" id="bikou" maxlength="255" style="resize: none";><?php echo $bikou;?></textarea>
							</div>
						</div>
						<label><font color='red'><?php if (!empty($this->Session->read('errorMsg.bikou.0'))) { echo $this->Session->read('errorMsg.bikou.0'); }?></font></label></dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">キャプチャ</dt>
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
										<?php if (!empty($this->Session->read('errorMsg.captchaCode.0'))) { echo $this->Session->read('errorMsg.captchaCode.0'); }?>
									</font>
								</label>
							</div>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">個人情報の取扱について</dt>
						<dd class="td">
							<div class="ifrm-container">
								<iframe src="../Privacy/privacy" class="privacy_block">インフレームを使っています。未対応のブラウザをお使いの方は<a href="../../privacy/index.html">こちら</a>でご確認ください。</iframe>
							</div><!-- /.ifrm-container -->
							<div class="check_box">
								<label><input type="checkbox" name="個人情報同意" id="check" value="個人情報の取扱に同意する" class="check">個人情報の取扱に同意する</label>
							</div><!-- /.check_box -->
						</dd>
					</dl>
				</div><!-- /.input_box -->
				<div class="button_area input_button">
					<div class="submit_button">
						<?php echo $this->Form->submit("確認画面", ['id' => 'submit']);?>
					</div><!-- /.submit_button -->
				</div><!-- /.button_area -->
			</div><!-- /.form_box -->     
		<?php echo $this->Form->end();?>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->