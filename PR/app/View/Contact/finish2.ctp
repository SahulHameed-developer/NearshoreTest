<!-- ========== main ========== -->
<section class="contact-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
				<li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
                <li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'index'));?></li>
                <li><?php echo $this->Html->link("お問い合わせありがとうございます。",'javascript:;'); ?></li>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="contact-finish-inner container">

			<div class="contact-step">
				<?php echo $this->Html->image('contact/step03.gif', array ('class' => 'pc_contents','alt' => '送信')); ?>
				<?php echo $this->Html->image('contact/sp_step03.gif', array ('class' => 'sp_contents','alt' => '送信')); ?>
			</div>

			<h1 class="contact-finish">お問い合わせありがとうございます。</h1>

			<div class="description">
				<p>この度は、お問い合わせいただきまして、まことにありがとうございます。<br>担当者より折り返しご連絡いたします。</p>
				<p>※確認メールを自動送信しております。<br>確認メールが届いていない場合は、迷惑メールフォルダをご確認いただくか、<br>お手数ですが、TEL.03-6327-7070 までお電話にてご連絡ください。</p>
			</div><!-- /.description -->

			</div><!-- /contact-finish-inner -->

	</main>
</section>
<!-- ========== /main ========== -->