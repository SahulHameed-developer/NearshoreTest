<!doctype html>
<title>PR契約情報 新規追加：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/contract/add.js') ?>
<script>
	$(function() {
		$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm',
					OnAfterChooseMonth: function() { 
				        $('#s_keiyaku_from').trigger('focusin');
						$('#s_keiyaku_from').trigger('focusout');
						$('#s_keiyaku_to').trigger('focusin');
						$('#s_keiyaku_to').trigger('focusout');
				    }  
		});
		$(".datepicker").datepicker();
	});
</script>
<style>
.f_right {
	display: block;
	float: right;
}
.registercls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+55m76Yyy5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
	background-color: rgba(255, 255, 255, .5);
}
</style>
</head>
<body>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== /nav ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="menuBack">管理画面トップ</a></li><!--
				--><li style="display: inline-block;">PR契約情報 新規追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="listBack">一覧に戻る</a></div>
			<h1 class="main-title">PR契約情報 新規追加</h1>
			<?php echo $this->Form->create('ContractSearchForm', ['id' => 'ContractSearchForm','url' => ['controller' => 'AdminContract', 'action' => 'search']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Contractaddfrm']['gyosyunm']) ? $this->request->data['Contractaddfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Contractaddfrm']['kaiinsbnm']) ? $this->request->data['Contractaddfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Contractaddfrm']['free_word']) ? $this->request->data['Contractaddfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Contractaddfrm']['free_radio']) ? $this->request->data['Contractaddfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'mkeiyaku','id'=>'mkeiyaku','value' => (isset($this->request->data['Contractaddfrm']['mkeiyaku']) ? $this->request->data['Contractaddfrm']['mkeiyaku'] : $this->request->data['mkeiyaku'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Contractaddfrm']['fromdate']) ? $this->request->data['Contractaddfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Contractaddfrm']['todate']) ? $this->request->data['Contractaddfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Contractaddfrm']['selectedOrder']) ? $this->request->data['Contractaddfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]);
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('Contractaddfrm', ['id' => 'Contractaddfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'add']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value' => (isset($this->request->data['Contractaddfrm']['kaisyacd']) ? $this->request->data['Contractaddfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value' => (isset($this->request->data['Contractaddfrm']['kaisyanm']) ? $this->request->data['Contractaddfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Contractaddfrm']['gyosyunm']) ? $this->request->data['Contractaddfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Contractaddfrm']['kaiinsbnm']) ? $this->request->data['Contractaddfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Contractaddfrm']['free_word']) ? $this->request->data['Contractaddfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Contractaddfrm']['free_radio']) ? $this->request->data['Contractaddfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'mkeiyaku','id'=>'mkeiyaku','value' => (isset($this->request->data['Contractaddfrm']['mkeiyaku']) ? $this->request->data['Contractaddfrm']['mkeiyaku'] : $this->request->data['mkeiyaku'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Contractaddfrm']['fromdate']) ? $this->request->data['Contractaddfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Contractaddfrm']['todate']) ? $this->request->data['Contractaddfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Contractaddfrm']['selectedOrder']) ? $this->request->data['Contractaddfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('ContractRegisterfrm', ['enctype' => 'multipart/form-data','id' => 'ContractRegisterfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'register']]);
				echo $this->Form->input('id', array('type' => 'hidden','name'=>'kykbn','id'=>'kykbn', 'value' => '1'));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value'=> (isset($this->request->data['Contractaddfrm']['kaisyacd']) ? $this->request->data['Contractaddfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value'=> (isset($this->request->data['Contractaddfrm']['kaisyanm']) ? $this->request->data['Contractaddfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
			?>
				<div class="form-area">
					<dl class="form-common">
						<dt><label for="kaishaMeisho">会社名称</label></dt>
						<dd><?php echo isset($this->request->data['Contractaddfrm']['kaisyanm']) ? $this->request->data['Contractaddfrm']['kaisyanm'] : $this->request->data['kaisyanm']; ?></dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="tantounm">広告担当者名</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'tantounm','name'=>'tantounm','maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名')); ?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="tantounm"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="tantounmkana">広告担当者名かな</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'tantounmkana','name'=>'tantounmkana','maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="tantounmkana"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label>連絡先</label></dt>
						<dd>
							<div class="error-list" style="width: 680px;">
								<div style="width: 100%;">
									<div style="width: 20%;display: inline-block;vertical-align: top !important;margin-top: 7px;">メールアドレス</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('mailaddr', array('type' => 'text', 'label' => false,'id' => 'mailaddr', 'name' =>'mailaddr','style'=>'width:528px;','maxlength' => '100','class' =>'underscoresingle ime-ModeDisable'));?>
										<font color='red' style="font-size: 13px;"><label class="mailaddr"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 20%;display: inline-block;vertical-align: top !important;margin-top: 7px;">電話番号</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('telno', array('type' => 'text', 'label' => false,'id' => 'telno', 'name' =>'telno','style'=>'width:528px;','maxlength' => '15','class' =>'ime-ModeDisable','placeholder' => '半角ハイフンを含めた電話番号'));?>
										<font color='red' style="font-size: 13px;"><label class="telno"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 20%;display: inline-block;vertical-align: top !important;margin-top: 7px;">FAX番号</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('faxno', array('type' => 'text', 'label' => false,'id' => 'faxno', 'name' =>'faxno','style'=>'width:528px;','maxlength' => '15','class' =>'ime-ModeDisable','placeholder' => '半角ハイフンを含めた電話番号'));?>
										<font color='red' style="font-size: 13px;"><label class="faxno"></label></font>
									</div>
								</div>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="ktukisuu">契約月数</label></dt>
						<dd>
							<ul>
								<li><input type="radio" name="ktukisuu" id="ktukisuu1" value="1" checked>
									<label for="ktukisuu1">６カ月</label></li>
								<li><input type="radio" name="ktukisuu" id="ktukisuu2" value="2" >
									<label for="ktukisuu2">１２カ月</label></li>
							</ul>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="uketukedt">受付日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('uketukedt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'uketukedt', 'name' =>'uketukedt','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="utantounm">受付担当者名</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'utantounm','name'=>'utantounm','maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="utantounm"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="syounindt">承認日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('syounindt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'syounindt', 'name' =>'syounindt','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="tuuchidt">承認通知日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('tuuchidt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'tuuchidt', 'name' =>'tuuchidt','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="s_keiyaku_from">初回契約期間</label></dt>
						<dd>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('s_keiyaku_from', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 's_keiyaku_from', 'name' =>'s_keiyaku_from','maxlength' => '7'));?>
							</div>
							<div style="display: inline-block;">～</div>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('s_keiyaku_to', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 's_keiyaku_to', 'name' =>'s_keiyaku_to','maxlength' => '7'));?>
							</div>
							<font color='red' style="font-size: 0.8rem;"><label id="date_errorft" class="date_errorft"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="s_keikin">初回契約金額</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->input('s_keikin', array('class' =>'ime-ModeDisable', 'type' => 'text', 'label' => false,'id' => 's_keikin', 'name' =>'s_keikin','style'=>'width:200px;','maxlength' => '10'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="s_keikin"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="nyukindt">入金締切日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('nyukindt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'nyukindt', 'name' =>'nyukindt','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="bikou">備考</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->textarea(' ', array('id'=>'bikou','name'=>'bikou','maxlength'=>'1024','class' => 'noTrimSpace','style'=>'width:668px;resize: none;')); ?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="bikou"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt>通知メール</dt>
						<dd>
							<label for="mailchk"><input type="checkbox" name="mailchk" id="mailchk">事務局へ確認・通知メール送信</label>
							<p>※ 事務局へ内容確認や通知をする場合にチェックしてください</p>
						</dd>
					</dl>
					<div class="register"><button type="button" class ="listBack">一覧に戻る</button><?php echo $this->Form->button("登録", array('class' =>'b-release add','type' => 'button','name' => 'register'));?></div>
				</div><!-- /.form-area -->
			<?php echo $this->Form->end();?>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>