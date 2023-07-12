<!-- ========== main ========== -->
<section class="contact-main">
	<main>

        <div class="breadcrumb-container">
            <ul class="breadcrumb-bar">
                <li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
                <li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'index'));?></li>
                <li><?php echo $this->Html->link("入力内容確認",'javascript:;'); ?></li>
            </ul>
        </div><!-- /breadcrumb-container -->

		<div class="contact-main-inner container">
			<h1>お問い合わせ</h1>
			<p class="contact-description">入力内容をご確認ください。</p>
			<div class="contact-step">
				<?php echo $this->Html->image('contact/step02.gif', array ('class' => 'pc_contents','alt' => '確認')); ?>
				<?php echo $this->Html->image('contact/sp_step02.gif', array ('class' => 'sp_contents','alt' => '確認')); ?>
			</div>

            <?php echo $this->Form->create('toiawaseiConfirm',['id' => 'toiawaseiConfirm', 'url' => ['controller' => 'contact']]);?>
            <div class="form_box">
                <div class="input_box">
                    <dl class="table">
                        <dt class="th">問い合わせ先の企業名</dt>
                        <dd class="td"><?php echo $confirmInfo['toikaisyanm']; ?></dd>
                        <?php echo $this->Form->input('toikaisyanm', array('type' => 'hidden', 'id' => 'toikaisyanm', 'value'=>$confirmInfo['toikaisyanm']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">会社名</dt>
                        <dd class="td"><?php echo $confirmInfo['kaisyanm']; ?></dd>
                        <?php echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm', 'value'=>$confirmInfo['kaisyanm']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">役職名</dt>
                        <dd class="td"><?php echo $confirmInfo['yakunm'];?></dd>
                        <?php echo $this->Form->input('yakunm', array('type' => 'hidden', 'id' => 'yakunm', 'value'=>$confirmInfo['yakunm']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">担当者名</dt>
                        <dd class="td"><?php echo $confirmInfo['tantou'];?></dd>
                        <?php echo $this->Form->input('tantou', array('type' => 'hidden', 'id' => 'tantou', 'value'=>$confirmInfo['tantou']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">メールアドレス</dt>
                        <dd class="td"><?php echo $confirmInfo['mailaddr'];?></dd>
                        <?php echo $this->Form->input('mailaddr', array('type' => 'hidden', 'id' => 'mailaddr', 'value'=>$confirmInfo['mailaddr']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">確認用メールアドレス</dt>
                        <dd class="td"><?php echo $confirmInfo['cmailaddr'];?></dd>
                        <?php echo $this->Form->input('cmailaddr', array('type' => 'hidden', 'id' => 'cmailaddr', 'value'=>$confirmInfo['cmailaddr']));?>
                    </dl>

                    <dl class="table">
                        <dt class="th">電話番号</dt>
                        <dd class="td"><?php echo $confirmInfo['telno'];?></dd>
                        <?php echo $this->Form->input('telno', array('type' => 'hidden', 'id' => 'telno', 'value'=>$confirmInfo['telno']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">業種</dt>
                        <dd class="td">
                            <?php if (isset($gyosyunm['MGyosyu']['gyosyunm'])) {  
                                echo $gyosyunm['MGyosyu']['gyosyunm']; 
                            } else { 
                                $gyosyunm['MGyosyu']['gyosyunm'] =''; 
                            } ?>
                        </dd>
                        <?php echo $this->Form->input('gyosyucd', array('type' => 'hidden', 'id' => 'gyosyucd', 'value'=>$confirmInfo['gyosyucd']));?>
                    </dl>

                    <dl class="table required_form">
                        <dt class="th">お問合せ内容</dt>
                        <dd class="td" style="max-width: 100px !important;"><?php echo nl2br($confirmInfo['naiyou']);?></dd>
                        <?php echo $this->Form->input('naiyou', array('type' => 'hidden', 'id' => 'naiyou', 'value'=>$confirmInfo['naiyou']));?>
                    </dl>
                </div><!-- /.input_box -->
                <?php echo $this->Form->end();?>

    		    <div class="confirm_button_area input_button clearfix">
                    <div class="back_button">
                        <?php echo $this->Form->submit("戻る", array('class' =>'backSend')); ?>
                    </div><!-- /.back_button -->

                    <div class="confirm_button">
                        <?php echo $this->Form->submit("送信", array('class' =>'confirmSend','name' =>'sendConfirmation','controller' => 'contact','action'=> 'sendmail')); ?>
                    </div><!-- /.confirm_button -->
                </div><!-- /.button_area -->

            </div><!-- /.form_box -->

		</div><!-- /contact-main-inner -->
	</main>
</section>
<!-- ========== /main ========== -->
<script type="text/javascript">
    $('.confirmSend').click(function() {
        $('#toiawaseiConfirm').attr('action', 'sendmail2');
        $("#toiawaseiConfirm").submit();
    });
    $('.backSend').click(function() {
        $('#toiawaseiConfirm').attr('action', 'index2');
        $("#toiawaseiConfirm").submit();
    });
</script>