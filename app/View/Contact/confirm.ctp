<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('contact/style.css') ?>
<?= $this->Html->script('contact/confirm.js') ?>
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
			<?php echo $this->Form->create('toiawaseiConfirm',['id' => 'toiawaseiConfirm', 'url' => ['controller' => 'contact']]);?>
	<div class="form_box">
		<div class="input_box">
			<dl class="table">
			<dt class="th">会社名</dt>
			<dd class="td"  style="word-break: break-all;">
				<?php 
					echo $confirmInfo['kaisyanm'];
				?>
			</dd>
			<?php echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm', 'value'=>$confirmInfo['kaisyanm']));?>
			</dl>
			<dl class="table">
			<dt class="th">役職名</dt>
			<dd class="td"><?php echo $confirmInfo['yakunm'];?></dd>
			<?php echo $this->Form->input('yakunm', array('type' => 'hidden', 'id' => 'yakunm', 'value'=>$confirmInfo['yakunm']));?>
			</dl>
			<dl class="table">
			<dt class="th">担当者名</dt>
			<dd class="td"><?php echo $confirmInfo['tantou'];?></dd>
			<?php echo $this->Form->input('tantou', array('type' => 'hidden', 'id' => 'tantou', 'value'=>$confirmInfo['tantou']));?>
			</dl>
			<dl class="table">
			<dt class="th">メールアドレス</dt>
			<dd class="td"><?php echo $confirmInfo['mailaddr'];?></dd>
			<?php echo $this->Form->input('mailaddr', array('type' => 'hidden', 'id' => 'mailaddr', 'value'=>$confirmInfo['mailaddr']));?>
			<?php echo $this->Form->input('cmailaddr', array('type' => 'hidden', 'id' => 'cmailaddr', 'value'=>$confirmInfo['mailaddr']));?>
			</dl>
			<dl class="table">
			<dt class="th">業種</dt>
			<dd class="td"><?php if (isset($gyosyunm['MGyosyu']['gyosyunm'])) {  
				echo $gyosyunm['MGyosyu']['gyosyunm']; } else { $gyosyunm['MGyosyu']['gyosyunm'] =''; }?></dd>
			<?php echo $this->Form->input('gyosyucd', array('type' => 'hidden', 'id' => 'gyosyucd', 'value'=>$confirmInfo['gyosyucd']));?>
			</dl>
			<dl class="table">
			<dt class="th">お問い合わせタイトル</dt>
			<dd class="td" style="word-break: break-all;">
				<?php 
					echo $confirmInfo['title'];
				?>
			</dd>
			<?php echo $this->Form->input('title', array('type' => 'hidden', 'id' => 'title', 'value'=>$confirmInfo['title']));?>
			</dl>
			<dl class="table">
			<dt class="th">お問合せ内容</dt>
			<dd class="td" style="max-width: 100px!important; "><?php echo nl2br($confirmInfo['naiyou']);?></dd>
			<?php echo $this->Form->input('naiyou', array('type' => 'hidden', 'id' => 'naiyou', 'value'=>$confirmInfo['naiyou']));?>
			</dl>
		</div><!-- /.input_box -->
		<?php echo $this->Form->input('captchaCode', array('type' => 'hidden', 'id' => 'captchaCode', 'value'=>$confirmInfo['captchaCode']));?>
		<?php echo $this->Form->end();?>
		<div class="button_area input_button clearfix">
			<div class="back_button">
					<input type="submit" value="戻る" class="backSend">
			</div><!-- /.back_button -->
			<div class="confirm_button">
				<?php echo $this->Form->submit("送信", array('class' =>'submit confirmSend','name' =>'sendConfirmation','controller' => 'contact','action'=> 'sendmail'));?>
			</div><!-- /.confirm_button -->
		</div><!-- /.button_area -->
		</div><!-- /.form_box -->
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->

