
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('contact/index.js') ?>
<?= $this->Html->css('contact/index.css') ?>

<!-- ========== main ========== -->
<section class="contact-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
                <li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index')); ?></li>
                <li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'index'));?></li>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="contact-main-inner container">

			<h1>お問い合わせ</h1>
			<p class="contact-description">当サービスをご利用くださいまして、まことにありがとうございます。<br>当協会では、皆様のプライバシー保護を重要と考えており、お送りいただいた情報は厳重に管理いたします。</p>
			<div class="contact-step">
                <?php echo $this->Html->image('contact/step01.gif', array ('class' => 'pc_contents','alt' => '入力')); ?>
                <?php echo $this->Html->image('contact/sp_step01.gif', array ('class' => 'sp_contents','alt' => '入力')); ?>
            </div>

            <?php echo $this->Form->create('toiawasei',['id' => 'toiawasei', 'url' => ['controller' => 'contact', 'action' => 'confirm2']]);?>
                <div class="form_box">
                    <div class="input_box">
                        <dl class="table">
                            <dt class="th">問い合わせ先の企業名</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <label><?php echo $toikaisyanm; ?></label>
                                    <?php echo $this->Form->input('toikaisyanm', array('type' => 'hidden','id' => 'toikaisyanm', 'name' => 'toikaisyanm', 'value' => $toikaisyanm)); ?>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">会社名</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('kaisyanm', array('type' => 'text',
                                                        'id' => 'kaisyanm', 
                                                        'name' => 'kaisyanm',
                                                        'label' => false,
                                                        'placeholder'=>'全角で入力してください',
                                                        'maxlength'=>'100',
                                                        'value' =>$backdata['kaisyanm'],
                                                        'class' => 'doublebyte2 ime-ModeEnable')); ?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.kaisyanm.0'))) { echo $this->Session->read('ValidateToiawasei.kaisyanm.0'); }?>
                                        <?php if (isset($ValidateToiawasei['kaisyanm']['0'])) { echo $ValidateToiawasei['kaisyanm']['0']; } ?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">役職名</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('yakunm', array('type' => 'text',
                                                        'id' => 'yakunm', 
                                                        'name' => 'yakunm',
                                                        'label' => false, 
                                                        'placeholder'=>'全角で入力してください',
                                                        'maxlength'=>'40',
                                                        'value' =>$backdata['yakunm'], 
                                                        'class'=>'doublebyte2 ime-ModeEnable')); ?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.yakunm.0'))) { echo $this->Session->read('ValidateToiawasei.yakunm.0'); }?>
                                    </label>
                                    <label class="label_error">
                                        <?php if (isset($ValidateToiawasei['yakunm']['0'])) { echo $ValidateToiawasei['yakunm']['0']; }?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">担当者名</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('tantou', array('type' => 'text',
                                                        'id' => 'tantou', 
                                                        'name' => 'tantou',
                                                        'label' => false, 
                                                        'placeholder'=>'姓　名',
                                                        'maxlength'=>'40',
                                                        'value' =>$backdata['tantou'], 
                                                        'class'=>'doublebyte2 ime-ModeEnable'));?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.tantou.0'))) { echo $this->Session->read('ValidateToiawasei.tantou.0'); }?>
                                        <?php if (isset($ValidateToiawasei['tantou']['0'])) { echo $ValidateToiawasei['tantou']['0']; }?>
                                    </label>
                                </div>
                            </dd>   
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">メールアドレス</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('mailaddr', array('type' => 'text',
                                                        'id' => 'mailaddr',
                                                        'name' => 'mailaddr', 
                                                        'label' => false,
                                                        'placeholder'=>'半角英数記号で入力してください',
                                                        'maxlength'=>'100',
                                                        'value' =>$backdata['mailaddr'],
                                                        'class'=>'ime-ModeDisable underscoresingle'));?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.mailaddr.0'))) { echo $this->Session->read('ValidateToiawasei.mailaddr.0'); }?>
                                        <?php if (isset($ValidateToiawasei['mailaddr']['0'])) { echo $ValidateToiawasei['mailaddr']['0']; }?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">確認用メールアドレス</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('cmailaddr', array('type' => 'text',
                                                        'id' => 'cmailaddr', 
                                                        'name' => 'cmailaddr', 
                                                        'label' => false,
                                                        'placeholder'=>'メールアドレスをもう一度入力してください',
                                                        'maxlength'=>'100',
                                                        'value' =>$backdata['cmailaddr'],
                                                        'class'=>'ime-ModeDisable underscoresingle'));?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.cmailaddr.0'))) { echo $this->Session->read('ValidateToiawasei.cmailaddr.0'); }?>
                                        <?php if (isset($ValidateToiawasei['cmailaddr']['0'])) { echo $ValidateToiawasei['cmailaddr']['0']; }?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table">
                            <dt class="th">電話番号</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <?php echo $this->Form->input('telno', array('type' => 'text',
                                                        'id' => 'telno', 
                                                        'name'=>'telno',
                                                        'label' => false, 
                                                        'placeholder'=>'半角英数記号で入力してください', 
                                                        'maxlength'=>'120', 
                                                        'value' =>$backdata['telno'], 
                                                        'class' => 'ime-ModeDisable inputval'));?>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.telno.0'))) { echo $this->Session->read('ValidateToiawasei.telno.0'); }?>
                                        <?php if (isset($ValidateToiawasei['telno']['0'])) { echo $ValidateToiawasei['telno']['0']; }?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">業種</dt>
                            <dd class="td">
                                <div class="error-list">
                                <div class="select_group">
                                <div class="select_wrap">
                                    <?php echo $this->Form->input('gyosyucd',array('type'=>'select',
                                                                        'options'=>$gyosyunm,
                                                                        'label'=>false,
                                                                        'value'=>$backdata['gyosyucd'],
                                                                        'empty'=> array(''=> array(
                                                                            'name' =>'業種を選択してください',
                                                                            'value' => '',
                                                                            'disabled' => 'disabled',
                                                                            'selected' => TRUE)),
                                                                        'name'=>'gyosyucd',
                                                                        'id' => 'gyosyucd'));?>
                                </div><!-- /.select_wrap -->
                                </div><!-- /.select_group -->
                                </div>
                                <label class="error_gyosyucd label_error"></label>
                                <label class="label_error">
                                    <?php if (!empty($this->Session->read('ValidateToiawasei.gyosyucd.0'))) { echo $this->Session->read('ValidateToiawasei.gyosyucd.0'); }?>
                                    <?php if (isset($ValidateToiawasei['gyosyucd']['0'])) { echo $ValidateToiawasei['gyosyucd']['0']; }?>
                                </label>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">お問い合わせ内容</dt>
                            <dd class="td">
                                <div class="error-list">
                                    <div>
                                        <?php  echo $this->Form->textarea('naiyou', array('label' => false, 
                                                            'id' => 'naiyou', 
                                                            'name'=>'naiyou', 
                                                            'maxlength'=>'1024', 
                                                            'escape' => false,
                                                            'value' =>$backdata['naiyou'],
                                                            'style'=>'resize: none;'));?>
                                    </div>
                                    <label class="label_error">
                                        <?php if (!empty($this->Session->read('ValidateToiawasei.naiyou.0'))) { echo $this->Session->read('ValidateToiawasei.naiyou.0'); }?>
                                        <?php if (isset($ValidateToiawasei['naiyou']['0'])) { echo $ValidateToiawasei['naiyou']['0']; }?>
                                    </label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="table required_form">
                            <dt class="th">個人情報の取扱について</dt>
                            <dd class="td">
                                <div class="ifrm-container">
                                    <iframe src="https://www.nearshore-it.jp/Privacy/privacy" class="privacy_block">インフレームを使っています。未対応のブラウザをお使いの方は<a href="https://www.nearshore-it.jp/Privacy" target="_blank">こちら</a>でご確認ください。</iframe>
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
		</div><!-- /contact-main-inner -->

	</main>
</section>
<!-- ========== /main ========== -->