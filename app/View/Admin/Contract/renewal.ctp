<!doctype html>
<title>PR契約情報 契約更新：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'); ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/contract/renewal.js') ?>
<script>
	$(function() {
		$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm',
					OnAfterChooseMonth: function() { 
						$('#g_keiyaku_from').trigger('focusin');
						$('#g_keiyaku_from').trigger('focusout');
						$('#g_keiyaku_to').trigger('focusin');
						$('#g_keiyaku_to').trigger('focusout');
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
.updatecls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5pu05paw5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
	background-color: rgba(255, 255, 255, .5);
}
</style>
</head>
<body>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== /nav ========== -->
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="menuBack">管理画面トップ</a></li><!--
				--><li style="display: inline-block;">PR契約情報 契約更新</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="listBack">一覧に戻る</a></div>
			<h1 class="main-title">PR契約情報 契約更新</h1>
			<?php echo $this->Form->create('ContractSearchForm', ['id' => 'ContractSearchForm','url' => ['controller' => 'AdminContract', 'action' => 'search']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Contractrenewalfrm']['gyosyunm']) ? $this->request->data['Contractrenewalfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Contractrenewalfrm']['kaiinsbnm']) ? $this->request->data['Contractrenewalfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Contractrenewalfrm']['free_word']) ? $this->request->data['Contractrenewalfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Contractrenewalfrm']['free_radio']) ? $this->request->data['Contractrenewalfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'mkeiyaku','id'=>'mkeiyaku','value' => (isset($this->request->data['Contractrenewalfrm']['mkeiyaku']) ? $this->request->data['Contractrenewalfrm']['mkeiyaku'] : $this->request->data['mkeiyaku'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Contractrenewalfrm']['fromdate']) ? $this->request->data['Contractrenewalfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Contractrenewalfrm']['todate']) ? $this->request->data['Contractrenewalfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Contractrenewalfrm']['selectedOrder']) ? $this->request->data['Contractrenewalfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]);
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('Contractrenewalfrm', ['id' => 'Contractrenewalfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'add']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value' => (isset($this->request->data['Contractrenewalfrm']['kaisyacd']) ? $this->request->data['Contractrenewalfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value' => (isset($this->request->data['Contractrenewalfrm']['kaisyanm']) ? $this->request->data['Contractrenewalfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Contractrenewalfrm']['gyosyunm']) ? $this->request->data['Contractrenewalfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Contractrenewalfrm']['kaiinsbnm']) ? $this->request->data['Contractrenewalfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Contractrenewalfrm']['free_word']) ? $this->request->data['Contractrenewalfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Contractrenewalfrm']['free_radio']) ? $this->request->data['Contractrenewalfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'mkeiyaku','id'=>'mkeiyaku','value' => (isset($this->request->data['Contractrenewalfrm']['mkeiyaku']) ? $this->request->data['Contractrenewalfrm']['mkeiyaku'] : $this->request->data['mkeiyaku'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Contractrenewalfrm']['fromdate']) ? $this->request->data['Contractrenewalfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Contractrenewalfrm']['todate']) ? $this->request->data['Contractrenewalfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Contractrenewalfrm']['selectedOrder']) ? $this->request->data['Contractrenewalfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Contractrenewalfrm']['selectedOrder']) ? $this->request->data['Contractrenewalfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('ContractrenewalUpdatefrm', ['enctype' => 'multipart/form-data','id' => 'ContractrenewalUpdatefrm', 'url' => ['controller' => 'AdminContract', 'action' => 'renewalupdate']]);
				echo $this->Form->input('id', array('type' => 'hidden','name'=>'id','id'=>'id', 'value' => $gettprkeiyaku['TPrkeiyaku']['arno']));
				echo $this->Form->input('kykbn', array('type' => 'hidden','name'=>'kykbn','id'=>'kykbn', 'value' => 2));
				echo $this->Form->input('keiyakunm', array('type' => 'hidden','name'=>'keiyakunm','id'=>'keiyakunm', 'value' => '継続契約'));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value'=> (isset($this->request->data['Contractrenewalfrm']['kaisyacd']) ? $this->request->data['Contractrenewalfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value'=> (isset($this->request->data['Contractrenewalfrm']['kaisyanm']) ? $this->request->data['Contractrenewalfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
			?>
				<div class="form-area">
					<dl class="form-common">
						<dt><label for="kaishaMeisho">会社名称</label></dt>
						<dd><?php echo isset($this->request->data['Contractrenewalfrm']['kaisyanm']) ? $this->request->data['Contractrenewalfrm']['kaisyanm'] : $this->request->data['kaisyanm']; ?></dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="tantounm">広告担当者名</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'tantounm','name'=>'tantounm','value'=>$gettprkeiyaku['TPrkeiyaku']['tantounm'],'maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名')); ?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="tantounm"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="tantounmkana">広告担当者名かな</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'tantounmkana','name'=>'tantounmkana','value'=>$gettprkeiyaku['TPrkeiyaku']['tantounmkana'],'maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名'));?>
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
										<?php echo $this->Form->input('mailaddr', array('type' => 'text', 'label' => false,'id' => 'mailaddr', 'name' =>'mailaddr','value'=>$gettprkeiyaku['TPrkeiyaku']['mailaddr'],'style'=>'width:528px;','maxlength' => '100','class' =>'underscoresingle ime-ModeDisable'));?>
										<font color='red' style="font-size: 13px;"><label class="mailaddr"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 20%;display: inline-block;vertical-align: top !important;margin-top: 7px;">電話番号</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('telno', array('type' => 'text', 'label' => false,'id' => 'telno', 'name' =>'telno','value'=>$gettprkeiyaku['TPrkeiyaku']['telno'],'style'=>'width:528px;','maxlength' => '15','class' =>'ime-ModeDisable','placeholder' => '半角ハイフンを含めた電話番号'));?>
										<font color='red' style="font-size: 13px;"><label class="telno"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 20%;display: inline-block;vertical-align: top !important;margin-top: 7px;">FAX番号</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('faxno', array('type' => 'text', 'label' => false,'id' => 'faxno', 'name' =>'faxno','value'=>$gettprkeiyaku['TPrkeiyaku']['faxno'],'style'=>'width:528px;','maxlength' => '15','class' =>'ime-ModeDisable','placeholder' => '半角ハイフンを含めた電話番号'));?>
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
								<li>
									<input type="radio" name="ktukisuu" id="ktukisuu1" value="1" <?php if ($gettprkeiyaku['TPrkeiyaku']['ktukisuu'] == "1") { ?> checked <?php }?>>
									<label for="ktukisuu1">６カ月</label>
								</li>
								<li>
									<input type="radio" name="ktukisuu" id="ktukisuu2" value="2" <?php if ($gettprkeiyaku['TPrkeiyaku']['ktukisuu'] == "2") { ?> checked <?php }?>>
									<label for="ktukisuu2">１２カ月</label>
								</li>
							</ul>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="uketukedt">受付日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('uketukedt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'uketukedt', 'name' =>'uketukedt','value'=>'','maxlength' => '10')); ?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="utantounm">受付担当者名</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->text(' ', array('id'=>'utantounm','name'=>'utantounm','value'=>'','maxlength'=>'40','class' =>'doublebyte','style'=>'width:668px;resize: none;','placeholder' => '姓　名'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="utantounm"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="syounindt">承認日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('syounindt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'syounindt', 'name' =>'syounindt','value'=>'','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="tuuchidt">承認通知日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('tuuchidt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'tuuchidt', 'name' =>'tuuchidt','value'=>'','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="s_keiyaku_from">初回契約期間</label></dt>
						<dd>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('s_keiyaku_from', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 's_keiyaku_from', 'name' =>'s_keiyaku_from','value'=>date('Y/m', strtotime($gettprkeiyaku['TPrkeiyaku']['s_keiyaku_from'])),'maxlength' => '7'));?>
							</div>
							<div style="display: inline-block;">～</div>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('s_keiyaku_to', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 's_keiyaku_to', 'name' =>'s_keiyaku_to','value'=>date('Y/m', strtotime($gettprkeiyaku['TPrkeiyaku']['s_keiyaku_to'])),'maxlength' => '7'));?>
							</div>
							<font color='red' style="font-size: 0.8rem;"><label id="s_date_errorft" class="s_date_errorft"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="s_keikin">初回契約金額</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->input('s_keikin', array('class' =>'ime-ModeDisable', 'type' => 'text', 'label' => false,'id' => 's_keikin', 'name' =>'s_keikin','value'=>$gettprkeiyaku['TPrkeiyaku']['s_keikin'],'style'=>'width:200px;','maxlength' => '10'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="s_keikin"></label></font>
						</dd>
					</dl>
					<?php 
						if($gettprkeiyaku['TPrkeiyaku']['ktukisuu']=="1") {
							$addmonth = "+6 Months";
						} else {
							$addmonth = "+12 Months";
						}
						$fromdate = date('Y/m', strtotime("+1 month", strtotime(date('Y/m/28', strtotime($gettprkeiyaku['TPrkeiyaku']['g_keiyaku_to'])))));
						$todate = date('Y/m', strtotime($addmonth, strtotime(date('Y/m/28', strtotime($gettprkeiyaku['TPrkeiyaku']['g_keiyaku_to'])))));
					?>
					<dl class="form-common">
						<dt class="required"><label for="g_keiyaku_from">契約期間</label></dt>
						<dd>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('g_keiyaku_from_hidden', array('class' =>'', 'type' => 'hidden', 'label' => false,'id' => 'g_keiyaku_from_hidden', 'name' =>'g_keiyaku_from_hidden','value'=>date('Y/m', strtotime($gettprkeiyaku['TPrkeiyaku']['g_keiyaku_from'])),'maxlength' => '7'));?>
								<?php echo $this->Form->input('g_keiyaku_from', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 'g_keiyaku_from', 'name' =>'g_keiyaku_from','value'=>$fromdate,'maxlength' => '7'));?>
							</div>
							<div style="display: inline-block;">～</div>
							<div style="display: inline-block;width: 200px;">
								<?php echo $this->Form->input('g_keiyaku_to_hidden', array('class' =>'', 'type' => 'hidden', 'label' => false,'id' => 'g_keiyaku_to_hidden', 'name' =>'g_keiyaku_to_hidden','value'=>date('Y/m', strtotime($gettprkeiyaku['TPrkeiyaku']['g_keiyaku_to'])),'maxlength' => '7'));?>
								<?php echo $this->Form->input('g_keiyaku_to', array('class' =>'datepickerfmt', 'type' => 'text', 'label' => false,'id' => 'g_keiyaku_to', 'name' =>'g_keiyaku_to','value'=>$todate,'maxlength' => '7'));?>
							</div>
							<font color='red' style="font-size: 0.8rem;"><label id="g_date_errorft" class="g_date_errorft"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="g_keikin">契約金額</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->input('g_keikin', array('class' =>'ime-ModeDisable', 'type' => 'text', 'label' => false,'id' => 'g_keikin', 'name' =>'g_keikin','value'=>$gettprkeiyaku['TPrkeiyaku']['g_keikin'],'style'=>'width:200px;','maxlength' => '10'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="g_keikin"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="nyukindt">入金締切日付</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('nyukindt', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'nyukindt', 'name' =>'nyukindt','value'=>'','maxlength' => '10'));?>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class=""><label for="bikou">備考</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->textarea(' ', array('id'=>'bikou','name'=>'bikou','value'=>$gettprkeiyaku['TPrkeiyaku']['bikou'],'maxlength'=>'1024','class' => 'noTrimSpace','style'=>'width:668px;resize: none;')); ?>
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
					<div class="register"><button type="button" class ="listBack">一覧に戻る</button><?php echo $this->Form->button("契約更新", array('class' =>'b-release renewal','type' => 'button','name' => 'register'));?></div>
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