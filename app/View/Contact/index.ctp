<!--header -->
<?php $this->layout="default";?>
<?= $this->Html->script('common/jquery.validate.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->html->css('contact/style.css') ?>
<?= $this->Html->script('contact/index.js') ?>
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
<div class="contents_wrap" style="text-align:left !important;">
	<div class="contents frame">
		<h1 class="h1 wf-roundedmplus1c"><span>お問い合わせ</span></h1>
			<div class="description">
				<p>当サービスをご利用くださいまして、まことにありがとうございます。<br>当協会では、皆様のプライバシー保護を重要と考えており、お送りいただいた情報は厳重に管理いたします。</p>
			</div><!-- /.description -->
			<div class="step_block">
				<?php echo $this->Html->image('common/pc/step_01.gif', array('alt' => '入力'));?>
			</div><!-- /.step_block -->
		<?php echo $this->Form->create('toiawasei',['id' => 'toiawasei', 'url' => ['controller' => 'contact', 'action' => 'confirm']]);?>
			<div class="form_box">
				<div class="input_box">
					<dl class="table required_form">
						<dt class="th">会社名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaisyanm', array('type' => 'text','id' => 'kaisyanm', 'label' => false,
															'name' => 'kaisyanm', 'placeholder'=>'全角で入力してください', 'maxlength'=>'100',
															'value' =>$backdata['kaisyanm'],
															'class' => 'doublebyte kaisyanm ime-ModeEnable'));?>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.kaisyanm.0'))) { echo $this->Session->read('ValidateToiawasei.kaisyanm.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['kaisyanm']['0'])) { echo $ValidateToiawasei['kaisyanm']['0']; }?></font></label>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">役職名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('yakunm', array('type' => 'text','id' => 'yakunm', 'name' => 'yakunm',
															'label' => false, 'value' =>$backdata['yakunm'], 'maxlength'=>'40',
															'placeholder'=>'全角で入力してください', 'class'=>'doublebyte ime-ModeEnable'));?>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.yakunm.0'))) { echo $this->Session->read('ValidateToiawasei.yakunm.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['yakunm']['0'])) { echo $ValidateToiawasei['yakunm']['0']; }?></font></label>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">担当者名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('tantou', array('type' => 'text','id' => 'tantou', 'name' => 'tantou',
															'label' => false, 'value' =>$backdata['tantou'], 'maxlength'=>'40',
															'placeholder'=>'姓　名', 'class'=>'doublebyte ime-ModeEnable'));?>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.tantou.0'))) { echo $this->Session->read('ValidateToiawasei.tantou.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['tantou']['0'])) { echo $ValidateToiawasei['tantou']['0']; }?></font></label>
							</div>
						</dd>	
					</dl>
					<dl class="table required_form">
						<dt class="th">メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('mailaddr', array('type' => 'text','id' => 'mailaddr', 'name' => 'mailaddr', 'maxlength'=>'100',
															'label' => false, 'value' =>$backdata['mailaddr'],
															'placeholder'=>'半角英数記号で入力してください', 'class'=>'ime-ModeDisable underscoresingle'));?>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.mailaddr.0'))) { echo $this->Session->read('ValidateToiawasei.mailaddr.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['mailaddr']['0'])) { echo $ValidateToiawasei['mailaddr']['0']; }?></font></label>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">確認用メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('cmailaddr', array('type' => 'text','id' => 'cmailaddr', 'name' => 'cmailaddr', 'maxlength'=>'100',
															'label' => false, 'value' =>$backdata['cmailaddr'],
															'placeholder'=>'メールアドレスをもう一度入力してください', 'class'=>'ime-ModeDisable underscoresingle'));?>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.cmailaddr.0'))) { echo $this->Session->read('ValidateToiawasei.cmailaddr.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['cmailaddr']['0'])) { echo $ValidateToiawasei['cmailaddr']['0']; }?></font></label>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">業種</dt>
						<dd class="td">
							<div class="error-select">
							<div class="select_group">
							<div class="select_wrap">
							<?php echo $this->Form->input('gyosyucd',array('type'=>'select',
																		'options'=>$gyosyunm, 
																		'label'=>false,
																		'value'=>$backdata['gyosyucd'],
																		'empty'=> array(''=> array(
																				'name' =>'業種を選択してください',
																				'value' => '',
																				'disabled' => TRUE,
																				'selected' => TRUE)),
																		'name'=>'gyosyucd'));?>
							</div><!-- /.select_wrap -->
							</div><!-- /.select_group -->
							</div>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.gyosyucd.0'))) { echo $this->Session->read('ValidateToiawasei.gyosyucd.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['gyosyucd']['0'])) { echo $ValidateToiawasei['gyosyucd']['0']; }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">お問い合わせタイトル</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('title', array('type' => 'text','id' => 'title', 'name'=>'title','label' => false, 'value' =>$backdata['title'], 'maxlength'=>'120', 'placeholder'=>'お問い合わせタイトルを入力してください', 'class' => 'inputval'));?>
								<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.title.0'))) { echo $this->Session->read('ValidateToiawasei.title.0'); }?></font></label>
								<label><font color='red'><?php if (isset($ValidateToiawasei['title']['0'])) { echo $ValidateToiawasei['title']['0']; }?></font></label>
							</div>
						</dd>
					</dl>
					<dl class="table required_form">
						<dt class="th">お問い合わせ内容</dt>
						<dd class="td">
							<div class="error-list">
								<div><?php  echo $this->Form->textarea('naiyou', array('label' => false, 'name'=>'naiyou', 'value' =>$backdata['naiyou'],'id' => 'naiyou', 'maxlength'=>'1024', 'escape' => false,'style'=>'resize: none;'));?></div>
							<label><font color='red'><?php if (!empty($this->Session->read('ValidateToiawasei.naiyou.0'))) { echo $this->Session->read('ValidateToiawasei.naiyou.0'); }?></font></label>
							<label><font color='red'><?php if (isset($ValidateToiawasei['naiyou']['0'])) { echo $ValidateToiawasei['naiyou']['0']; }?></font></label>
							</div>
						</dd>
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
										<?php if (!empty($this->Session->read('ValidateToiawasei.captchaCode.0'))) { echo $this->Session->read('ValidateToiawasei.captchaCode.0'); }?>
									</font>
								</label>
							</div>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">個人情報の取扱について</dt>
						<dd class="td">
							<div class="ifrm-container">
								<iframe src="../Privacy/privacy" class="privacy_block">インフレームを使っています。未対応のブラウザをお使いの方は<a href="../privacy/index.html">こちら</a>でご確認ください。</iframe>
							</div><!-- /.ifrm-container -->
								
							<div class="check_box">
								<label><input type="checkbox" name="個人情報同意" id="check" value="個人情報の取扱に同意する" class="check">個人情報の取扱に同意する</label>
							</div><!-- /.check_box -->
						</dd>
					</dl>
				</div><!-- /.input_box -->
					<div class="button_area input_button">
						<div class="submit_button">
							<?php echo $this->Form->submit("確認画面", ['id' => 'submit', 'name' => 'submit']);?>
						</div><!-- /.submit_button -->
					</div><!-- /.button_area -->
			</div><!-- /.form_box -->
		<?php echo $this->Form->end();?>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->