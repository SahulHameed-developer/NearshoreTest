<!--header -->
<?php $this->layout="default";?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('activity/entry/index.js') ?>
<?= $this->html->css('activity/style.css') ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
	var RESTRICT_MAIL_ADDR = "<?php echo ConstantsComponent::$RESTRICT_MAIL_ADDR; ?>";
	captchaCode = "<?php echo $this->Session->read('captcha_code'); ?>";
</script>
<style type="text/css">
	.searchButton {
		width:55px !important;
		padding: 0px 0px 0px 0px !important;
	}
	@media screen and (min-width: 769px) {
		.searchButton {
			width:120px !important;
			padding: 0px 0px 0px 0px !important;
		}
	}
	@media screen and (min-width: 769px) {
		.form_box .captcha {
			width: 340px !important;
		}
		.display_inline_block {
			display: inline-block;
		}
	}
</style>
<!-- /header -->
<div class="contents_wrap">
	<div class="contents frame">
		<h1 class="h1 wf-roundedmplus1c"><span><?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
												echo "会議出席連絡";
											} else {
												echo "イベント申込";
											} ?></span></h1>
		<div class="description">
			<p>当サービスをご利用くださいまして、まことにありがとうございます。<br>当協会では、皆様のプライバシー保護を重要と考えており、お送りいただいた情報は厳重に管理いたします。</p>
		</div><!-- /.description -->
		<div class="step_block">
			<?php echo $this->Html->image('common/pc/step_01.gif', array('alt' => '入力'));?>
		</div><!-- /.step_block -->
		<?php echo $this->Form->create('kaigiEvent',['url' => ['controller' => 'activity', 'action' => 'confirm']]);
				echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>$hyoudai));
				echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>$meisyou));
				echo $this->Form->input('kaisaidate', array('type' => 'hidden','value'=>$kaisaidate));
				echo $this->Form->input('kaisaitmfrom', array('type' => 'hidden','value'=>$kaisaitmfrom));
				echo $this->Form->input('kaisaitmto', array('type' => 'hidden','value'=>$kaisaitmto));
				echo $this->Form->input('taisyoukbn', array('type' => 'hidden','value'=>$taisyoukbn));
				echo $this->Form->input('kaisyanmHid', array('type' => 'hidden','value'=>$kaisyanm));
				echo $this->Form->input('kaiinnmHid', array('type' => 'hidden','value'=>$kaiinnm));
				echo $this->Form->input('confirmBut', array('type' => 'hidden','value'=>$confirmVal));
				echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>$bunruicd));
				echo $this->Form->input('sosikicd', array('type' => 'hidden','value'=>$sosikicd));
				echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$kbunruicd));
				echo $this->Form->input('kaiinKbn', array('type' => 'hidden','value'=>$kaiinKbn));
				echo $this->Form->input('buttonSel', array('type' => 'hidden','value'=>$buttonSel));
				echo $this->Form->input('arno', array('type' => 'hidden','id' => 'arno','value'=>$arno));
				echo $this->Form->input('kaiincd', array('type' => 'hidden','id' => 'kaiincd','value'=>$kaiincd));
				echo $this->Form->input('kaiinkbnmem', array('type' => 'hidden','id' => 'kaiinkbnmem','value'=>$kaiinkbnmem));
			?>
		<div class="form_box break_line">
			<?php if ($taisyoukbn == 1): ?>
				<div class="input_box">
					<dl class="table">
						<dt class="th"><?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
												echo "会議名";
											} else {
												echo "イベント名";
											} ?></dt>
						<dd class="td">
							<p class="sub_title"><span class="month"><?php echo $hyoudai?></span></p>
							<p class="title"><?php echo $meisyou?></p>
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
					<dl class="table required_form">
						<dt class="th">会員区分</dt>
						<dd class="td">
							<div class="radio_box">
								<label><input type="radio" name="free_radio" id="kaiin" class="radio" value="<?php echo $kaiin_val; ?>"><span class="radio-icon"></span><?php echo $kaiin_val; ?></label>
								<label><input type="radio" name="free_radio" id="hikaiin" class="radio" value="<?php echo $hikaiin_val; ?>"><span class="radio-icon"></span><?php echo $hikaiin_val; ?></label>
							</div><!-- /.radio_box -->
						</dd>
					</dl>
					<dl class="table required_form" id ="kainMail">
						<dt class="th">会員メールアドレス</dt>
						<dd class="td">
							<div class="inbTop">
								<div class="error-list">
									<?php echo $this->Form->input('mailaddr', array('type' => 'text', 'class'=>'ime-ModeDisable underscoresingle', 'id' => 'mailaddr', 'label' => false,
										'maxlength'=>'100','name' => 'mailaddr', 'placeholder'=>'会員の登録済みメールアドレスを入力してください','value' => $mailaddr));?>
									<?php echo $this->Session->flash();?>
								</div>
							</div>
							<div class="inbTop">
								<?php echo $this->Form->button("検索", array('class' =>'searchButton', 'name' =>'kaiinMailbtn','id' =>'kaiinMailbtn', 'type' => 'button'));?>
							</div>
							</br>
							<label class="error_mail" style="color: #e20000;font-size: 1.3rem;"></label>
							<label id="error_label" class="error_label kaiinMailbtnerr" style="color: #e20000;font-size: 1.3rem;"></label>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.mailaddr.0'))) { echo $this->Session->read('errorMsgs.mailaddr.0'); } ?></font></label>
						</dd>
					</dl>
					<dl class="table" id="kaisyaName">
						<dt class="th">会社名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaisyanm', array('type' => 'text', 'class'=>'ime-ModeEnable doublebyte kaisyanm', 'id' => 'kaisyanm', 'label' => false,'maxlength'=>'100','name' => 'kaisyanm', 'placeholder'=>'全角で入力してください', 'style'=> 'display:none','value' => $kaisyanm));?>
								<label id="kaisyanmlb"><?php echo $kaisyanm;?></label>
							</div>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.kaisyanm.0'))) { echo $this->Session->read('errorMsgs.kaisyanm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table" id="kaiinName">
						<dt class="th">氏名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaiinnm', array('type' => 'text', 'class'=>'ime-ModeEnable doublebyte', 'id' => 'kaiinnm', 'label' => false,
								'maxlength'=>'40','name' => 'kaiinnm', 'style'=> 'display:none', 'placeholder'=>'姓　名','value' => $kaiinnm));?>
								<label id="kaiinnmlb"><?php echo $kaiinnm;?></label>
							</div>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.simei.0'))) { echo $this->Session->read('errorMsgs.simei.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form" id ="mailAddr">
						<dt class="th">メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('emailAddr', array('type' => 'text', 'class'=>'ime-ModeDisable underscoresingle', 'id' => 'emailAddr', 'label' => false,
								'maxlength'=>'100','name' => 'emailAddr', 'placeholder'=>'半角英数記号で入力してください','value' => $mailaddr));?>
							</div>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.mailaddr.0'))) { echo $this->Session->read('errorMsgs.mailaddr.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table required_form" id ="confirmMail">
						<dt class="th">確認用メールアドレス</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('confirmEmail', array('type' => 'text', 'class'=>'ime-ModeDisable underscoresingle', 'id' => 'confirmEmail', 'label' => false,
								'maxlength'=>'100','name' => 'confirmEmail', 'placeholder'=>'メールアドレスをもう一度入力してください','value' => $mailaddr));?>
							</div>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">備考</dt>
						<dd class="td">
						<textarea name="bikou" maxlength="1024" id="bikou" style="resize: none";><?php echo $bikou; ?></textarea>
						<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.bikou.0'))) { echo $this->Session->read('errorMsgs.bikou.0'); }?></font></label>
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
										<?php if (!empty($this->Session->read('errorMsgs.captchaCode.0'))) { echo $this->Session->read('errorMsgs.captchaCode.0'); }?>
									</font>
								</label>
							</div>
						</dd>
					</dl>
					<dl class="table" id ="kojinInfo">
						<dt class="th">個人情報の取扱について</dt>
						<dd class="td">
							<div class="ifrm-container">
								<iframe src="../privacy/privacy" class="privacy_block">インフレームを使っています。未対応のブラウザをお使いの方は<a href="../../privacy/index.html">こちら</a>でご確認ください。</iframe>
							</div><!-- /.ifrm-container -->
							<div class="check_box">
								<label><input type="checkbox" name="kojinInfo" id="check" value="個人情報の取扱に同意する" class="check">個人情報の取扱に同意する</label>
							</div><!-- /.check_box -->
						</dd>
					</dl>
				</div><!-- /.input_box -->
			<?php else: ?>
				<div class="input_box">
					<dl class="table">
						<dt class="th"><?php if ($bunruicd == ConstantsComponent::$KAIGI_CD) {
												echo "会議名";
											} else {
												echo "イベント名";
											} ?></dt>
						<dd class="td">
							<p class="sub_title"><span class="month"><?php echo $hyoudai?></span></p>
							<p class="title"><?php echo $meisyou?></p>
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
					<dl class="table required_form" id ="kainMail">
						<dt class="th">会員メールアドレス</dt>
						<dd class="td">
							<div class="inbTop">
								<div class="error-list">
									<?php echo $this->Form->input('mailaddr', array('type' => 'text', 'class'=>'ime-ModeDisable', 'id' => 'mailaddr', 'label' => false,
										'maxlength'=>'100','name' => 'mailaddr', 'placeholder'=>'会員の登録済みメールアドレスを入力してください','value' => $mailaddr));?>
									<?php echo $this->Session->flash();?>
								</div>
							</div>
							<div class="inbTop">
								<?php echo $this->Form->button("検索", array('class' =>'searchButton', 'name' =>'kaiinMailbtn','id' =>'kaiinMailbtn', 'type' => 'button'));?>
							</div>
							</br>
							<label class="error_mail" style="color: #e20000;font-size: 1.3rem;"></label>
							<label id="error_label" class="error_label" style="color: #e20000;font-size: 1.3rem;"></label>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.mailaddr.0'))) { echo $this->Session->read('errorMsgs.mailaddr.0'); } ?></font></label>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">会社名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaisyanm', array('type' => 'text', 'class'=>'ime-ModeEnable doublebyte kaisyanm', 'id' => 'kaisyanm', 'label' => false,'maxlength'=>'100','name' => 'kaisyanm', 'placeholder'=>'全角で入力してください', 'style'=> 'display:none','value' => $kaisyanm));?>
								<label id="kaisyanmlb"><?php echo $kaisyanm;?></label>
							</div>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.kaisyanm.0'))) { echo $this->Session->read('errorMsgs.kaisyanm.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">氏名</dt>
						<dd class="td">
							<div class="error-list">
								<?php echo $this->Form->input('kaiinnm', array('type' => 'text', 'class'=>'ime-ModeEnable doublebyte', 'id' => 'kaiinnm', 'label' => false,
								'maxlength'=>'40','name' => 'kaiinnm', 'style'=> 'display:none', 'placeholder'=>'姓　名','value' => $kaiinnm));?>
								<label id="kaiinnmlb"><?php echo $kaiinnm;?></label>
							</div>
							<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.simei.0'))) { echo $this->Session->read('errorMsgs.simei.0'); }?></font></label>
						</dd>
					</dl>
					<dl class="table">
						<dt class="th">備考</dt>
						<dd class="td">
						<textarea name="bikou" maxlength="1024" id="bikou" ><?php echo $bikou; ?></textarea>
						<label class="db_error"><font color='red'><?php if (!empty($this->Session->read('errorMsgs.bikou.0'))) { echo $this->Session->read('errorMsgs.bikou.0'); }?></font></label>
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
										<?php if (!empty($this->Session->read('errorMsgs.captchaCode.0'))) { echo $this->Session->read('errorMsgs.captchaCode.0'); }?>
									</font>
								</label>
							</div>
						</dd>
					</dl>
				</div><!-- /.input_box -->
			<?php endif; ?>
			<div class="button_area input_button">
				<div class="submit_button">
					<?php echo $this->Form->submit("確認画面", ['id' => 'submit', 'name' => 'submit']);?>
				</div><!-- /.submit_button -->
			</div><!-- /.button_area -->
		</div><!-- /.form_box -->
		<?php echo $this->Form->end();?>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->