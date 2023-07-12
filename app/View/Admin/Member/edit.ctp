<!doctype html>
<title>会員情報 編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/member/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->css('admin/member/style.css') ?>
<script>
  $(function() {
    $(".datepicker").datepicker();
 	// 初期表示に画像選択で、リセット
	if($("#urlkaiinsyasin").val() == ""){
		$('.kaiinReset').prop('disabled', true);
		$('#ksyasintitle').attr('disabled', 'disabled');
	}
	if($("#urlkaisyalogo").val() == ""){
		$('.kaisyaLogoReset').prop('disabled', true);
	}
	if($("#urlprimage1").val() == ""){
		$('.addPrImageReset1').prop('disabled', true);
		$('#syasintitle1').attr('disabled', 'disabled');
	}
	if($("#urlprimage2").val() == ""){
		$('.addPrImageReset2').prop('disabled', true);
		$('#syasintitle2').attr('disabled', 'disabled');
	}
	if($("#urlprimage3").val() == ""){
		$('.addPrImageReset3').prop('disabled', true);
		$('#syasintitle3').attr('disabled', 'disabled');
	}
	if ($("#tbusyo1").val() != "" || $("#ttantounm1").val() != "") {
		$( "#tmailaddr1" ).rules( "add", "required" );
	} else {
		$( "#tmailaddr1" ).rules( "remove", "required" );
	}
	if ($("#tbusyo2").val() != "" || $("#ttantounm2").val() != "") {
		$( "#tmailaddr2" ).rules( "add", "required" );
	} else {
		$( "#tmailaddr2" ).rules( "remove", "required" );
	}
	if ($("#tbusyo3").val() != "" || $("#ttantounm3").val() != "") {
		$( "#tmailaddr3" ).rules( "add", "required" );
	} else {
		$( "#tmailaddr3" ).rules( "remove", "required" );
	}
	// 選択した値のセット
	var option = $('#syumicd1').find('option:selected').val();
	// 会員種別が"正会員"or"準会員"の場合
	if(option == '99'){
		$('#syumitxt1').attr('readonly', false);
		$( "#syumitxt1" ).rules( "add", "required" );
		
	}else{
		$('#syumitxt1').attr('readonly', true);
		$( "#syumitxt1" ).rules( "remove", "required" );
	}
	// 選択した値のセット
	var option = $('#syumicd2').find('option:selected').val();
	// 会員種別が"正会員"or"準会員"の場合
	if(option == '99'){
		$('#syumitxt2').attr('readonly', false);
		$( "#syumitxt2" ).rules( "add", "required" );
	}else{
		$('#syumitxt2').attr('readonly', true);
		$( "#syumitxt2" ).rules( "remove", "required" );
	}
	// 選択した値のセット
	var option = $('#syumicd3').find('option:selected').val();
	// 会員種別が"正会員"or"準会員"の場合
	if(option == '99'){
		$('#syumitxt3').attr('readonly', false);
		$( "#syumitxt3" ).rules( "add", "required" );
	}else{
		$('#syumitxt3').attr('readonly', true);
		$( "#syumitxt3" ).rules( "remove", "required" );
	}
  });
</script>
<style> 
input[type=text]:disabled {
    background: #dddddd !important;
}
.kaiinReset:disabled {
	background-color:gray !important;
}
.kaisyaLogoReset:disabled {
	background-color:gray !important;
}
.addPrImageReset1:disabled {
	background-color:gray !important;
}
.addPrImageReset2:disabled {
	background-color:gray !important;
}
.addPrImageReset3:disabled {
	background-color:gray !important;
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
.form-area {
	padding: 20px 0 0px !important;
}
</style>
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<?= $this->element('adminheader') ?>
<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]);
echo $this->Form->end();?>
<?php echo $this->Form->create('membersModoruFrm', ['id' => 'membersModoruFrm', 'url' => ['controller' => 'AdminMember', 'action' => 'search']]);
	echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
	echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
	echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
	echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
	echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
echo $this->Form->end(); ?>
<!-- ========== /main ========== -->
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;">
					<a style="cursor:pointer;" id="backpage_head" <?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
					 class="returnList" <?php } else { ?> class="returnList" <?php }?>>管理画面トップ</a>
				<?php echo $this->Html->link("", array('controller' => 'admin','action'=> 'home'));?></li><li  style="display: inline-block;">会員情報 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="breadcrumbs f_right">
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
					<a style="cursor:pointer;" class="b-back">一覧に戻る</a>
				<?php } else { ?> 
					<a style="cursor:pointer;" class="returnList">メニューに戻る</a>
				<?php }?>
			</div>
			<div class="message" style="text-align:center;display: none;" id="logid_err">登録データが重複しています。</div>
			<h1 class="main-title">会員情報 編集</h1>
				<?php echo $this->Form->create('editfrm', ['enctype' => 'multipart/form-data', 'id' => 'editfrm', 'autocomplete' => 'off' ,'name' => 'editfrm', 'url' => ['controller' => 'AdminMember', 'action' => 'memberEdit']]);
						echo $this->Form->input('kanrikbn', array('type'=>'hidden','value'=>$_SESSION['Auth']['User']['TKaiin']['kanrikbn'],'name'=>'kanrikbn','id'=>'kanrikbn'));
						echo $this->Form->input('lgid_hid', array('type' => 'hidden','value'=>$kaiininfo['TKaiin']['lgid'],'name'=>'lgid_hid','id'=>'lgid_hid'));
						echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm,'name'=>'industry','id'=>'industry'));
						echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm,'name'=>'members_type','id'=>'members_type'));
						echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal,'name'=>'free_word','id'=>'free_word'));
						echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk,'name'=>'free_radio','id'=>'free_radio'));
						echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd', 'value'=>$kaiininfo['TKaiin']['kaiincd'],'name'=>'kaiincd','id'=>'kaiincd'));		// T_KAISYA.会員コード
						echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd', 'value'=>$kaisyainfo['TKaisya']['kaisyacd'],'name'=>'kaisyacd','id'=>'kaisyacd'));
						echo $this->Form->input('password', array('type' => 'hidden', 'id' => 'password', 'value'=>$password,'name'=>'password','id'=>'password'));
						echo $this->Form->input('', array('type' => 'file','name'=>'kaiinsyasin','id'=>'kaiinsyasin','style'=> 'display:none')); 
						echo $this->Form->input('', array('type' => 'file','name'=>'kaisyalogo','id'=>'kaisyalogo','style'=> 'display:none')); 
						echo $this->Form->input('', array('type' => 'file','name'=>'primage1','id'=>'primage1','style'=> 'display:none'));
						echo $this->Form->input('', array('type' => 'file','name'=>'primage2','id'=>'primage2','style'=> 'display:none'));
						echo $this->Form->input('', array('type' => 'file','name'=>'primage3','id'=>'primage3','style'=> 'display:none'));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaiinsyasin','id'=>'urlkaiinsyasin','value'=> $images['kaiinimage'])); 
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaisyalogo','id'=>'urlkaisyalogo','value'=> $images['kaisyalogo'])); 
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlprimage1','id'=>'urlprimage1','value'=> $syasinData['primage1']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlprimage2','id'=>'urlprimage2','value'=> $syasinData['primage2']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlprimage3','id'=>'urlprimage3','value'=> $syasinData['primage3']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaiintitle','id'=>'urlkaiintitle','value'=> $kaiininfo['TKaiin']['title'])); 
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle1','id'=>'urltitle1','value'=> $syasinData['title1']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle2','id'=>'urltitle2','value'=> $syasinData['title2']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle3','id'=>'urltitle3','value'=> $syasinData['title3']));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasinKey','id'=>'urlsyasinKey','value'=> $syasinKey));
						echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' )); 
						echo $this->Form->input('', array('type' => 'hidden','name'=>'pagename','id'=>'pagename','value'=> '1' )); ?>
				<div class="form-area">
				<h2>会員情報</h2>
				<dl class="form-common">
					<dt><label for="kaiincd">会員コード</label></dt>
					<dd>
						<?php echo $kaiininfo['TKaiin']['kaiincd']; ?>
						<input type="hidden" name="kaiincd" id="kaiincd" value="<?php echo $kaiininfo['TKaiin']['kaiincd']; ?>">
						<input type="hidden" name="kanrikbn" id="kanrikbn" value="<?php echo $_SESSION['Auth']['User']['TKaiin']['kanrikbn']; ?>">
					</dd>
				</dl>
				<dl class="form-common">
					<dt <?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?> class="required" <?php }?>>会員種別</dt>
					<dd><div class="error-select">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<div class="select-wrap">
								<?php echo $this->Form->input('kaiinsbcd',array('type'=>'select',
																			'options'=>$kaiinsbnm, 
																			'label'=>false,
																			'value'=>$kaiininfo['TKaiin']['kaiinsbcd'],
																			'name'=>'kaiinsbcd',
																			'id' => 'kaiinsbcd'));?>
							</div>
						<?php } else { ?>
							<?php echo $kaiininfo['mko']['kaiinsbnm']; ?>
							<input type="hidden" name="kaiinsbcd" id="kaiinsbcd" value="<?php echo $kaiininfo['TKaiin']['kaiinsbcd']; ?>">
						<?php } ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt <?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?> class="required" <?php }?>><label for="kaiinnm">会員名称</label></dt>
					<dd>
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<input type="text" name="kaiinnm" id="kaiinnm" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>">
						<?php } else { ?>
							<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>
							<input type="hidden" name="kaiinnm" id="kaiinnm" value="<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>">
						<?php } ?>
						<font color='red'><label class="kaiinnm"><?php if (!empty($TKaiinErrors['kaiinnm'])) { echo $TKaiinErrors['kaiinnm'][0]; }?></label></font>	
						<div class="errors"></div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field04">会員名称かな</label></dt>
					<dd><div class="errors"><input type="text" name="kaiinnmkana" id="kaiinnmkana" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['kaiinnmkana']; ?>">
						<font color='red'><label class="kaiinnmkana"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisyayknm">役職名称</label></dt>
					<dd><div class="errors"><input type="text" name="kaisyayknm" id="kaisyayknm" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['kaisyayknm']; ?>">
						<font color='red'><label class="kaisyayknm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="mailaddr">メールアドレス</label></dt>
					<dd><div class="errors"><input type="email" class= "underscoresingle" name="mailaddr" id="mailaddr" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['mailaddr']; ?>">
						<font color='red'><label class="mailaddr"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="seinendate">生年月日</label></dt>
					<dd><div class="errors"><input type="text" name="seinendate" id="seinendate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['seinendate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['seinendate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['seinendate'])); endif;?>">
					<?php if(!empty($TKaiinErrors['seinendate'])): ?><span class="error"><?php echo $TKaiinErrors['seinendate'][0] ?></span><?php endif; ?></div></dd>
				</dl>
				<dl class="form-common">
					<dt>性別</dt>
					<dd>
						<ul>
							<li><input type="radio" name="seicd" id="seicd-r1" value="<?php echo $seibetu['male']['value']; ?>"  <?php echo $danseiChk; ?>><label for="seicd-r1"><?php echo $seibetu['male']['label']; ?></label></li>
							<li><input type="radio" name="seicd" id="seicd-r2" value="<?php echo $seibetu['female']['value']; ?>" <?php echo $joseiChk; ?>><label for="seicd-r2"><?php echo $seibetu['female']['label']; ?></label></li>
						</ul>
						<?php if(!empty($TKaiinErrors['seicd'])): ?><span class="error"><?php echo $TKaiinErrors['seicd'][0] ?></span><?php endif; ?>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="nyukaidate">入会日付</label></dt>
					<dd>
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
						<div class="errors" >
							<input type="text" name="nyukaidate" id="nyukaidate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>">
						</div>
						<?php } else { ?>
							<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>
							<input type="hidden" name="nyukaidate" id="nyukaidate" value="<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>">
						<?php } ?>
						<?php if(!empty($TKaiinErrors['nyukaidate'])): ?><span class="error"><?php echo $TKaiinErrors['nyukaidate'][0] ?></span><?php endif; ?>
					</dd>
				</dl>
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
				<dl class="form-common">
					<dt><label for="kyukaidate">休会日付</label></dt>
					<dd><div class="errors"><input type="text" name="kyukaidate" id="kyukaidate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['kyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['kyukaidate'])):  echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['kyukaidate'])); endif; ?>">
					<?php if(!empty($TKaiinErrors['kyukaidate'])): ?><span class="error"><?php echo $errors['kyukaidate'][0] ?></span><?php endif; ?></div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="taikaidate">退会日付</label></dt>
					<dd><div class="errors">
						<input type="text" name="taikaidate" id="taikaidate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['taikaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['taikaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['taikaidate'])); endif; ?>">
						<?php if(!empty($TKaiinErrors['taikaidate'])): ?><span class="error"><?php echo $TKaiinErrors['taikaidate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<?php } else {?>
					<input type="hidden" name="kyukaidate" id="kyukaidate" value="<?php if($kaiininfo['TKaiin']['kyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['kyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['kyukaidate'])); endif; ?>">
					<input type="hidden" name="taikaidate" id="taikaidate" value="<?php if($kaiininfo['TKaiin']['taikaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['taikaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['taikaidate'])); endif; ?>">
				<?php } ?>
				<dl class="form-common">
					<dt><label for="syokaisyanm">紹介者名</label></dt>
					<dd>
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
						<div class="errors" >
							<input type="text" name="syokaisyanm" id="syokaisyanm" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['syokaisyanm']; ?>" >
							<font color='red'><label class="syokaisyanm"></label></font>
						</div>
						<?php } else { ?>
							<?php echo $kaiininfo['TKaiin']['syokaisyanm']; ?>
							<input type="hidden" name="syokaisyanm" id="syokaisyanm" value="<?php echo $kaiininfo['TKaiin']['syokaisyanm']; ?>">
						<?php } ?>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kyoukaiykcd">協会役職</label></dt>
					<dd><div class="error-select">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<div class="select-wrap">
								<?php echo $this->Form->input('kyoukaiykcd',array('type'=>'select',
																			'options'=>$kyoukaiyknm, 
																			'label'=>false,
																			'value'=>$kaiininfo['TKaiin']['kyoukaiykcd'],
																			'name'=>'kyoukaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'kyoukaiykcd'));?>
							</div>
						<?php } else { ?>
							<?php if($kaiininfo['TKaiin']['kyoukaiykcd'] != "") {
								echo $kyoukaiyknm[$kaiininfo['TKaiin']['kyoukaiykcd']]; } ?>
							<input type="hidden" name="kyoukaiykcd" id="kyoukaiykcd" value="<?php echo $kaiininfo['TKaiin']['kyoukaiykcd']; ?>">
						<?php } ?>
						<?php if(!empty($TKaiinErrors['kyoukaiykcd'])): ?><span class="error"><?php echo $TKaiinErrors['kyoukaiykcd'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field12">所属委員会</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('sosikinm',array('type'=>'select',
																			'options'=>$sosikinm, 
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['sosikicd'],
																			'name'=>'sosikicd',
																			'empty'=> '選択してください',
																			'id' => 'sosikicd'));?>
							<?php if(!empty($errors['sosikicd'])): ?><span class="error"><?php echo $errors['sosikicd'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="iinkaiykcd">委員会役職</label></dt>
					<dd><div class="error-select">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<div class="select-wrap">
								<?php echo $this->Form->input('iinkaiyknm',array('type'=>'select',
																			'options'=>$iinkaiyknm, 
																			'label'=>false,
																			'value'=>$kaiininfo['TKaiin']['iinkaiykcd'],
																			'name'=>'iinkaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'iinkaiykcd'));?>
							</div>
						<?php } else { ?>
							<?php  if($kaiininfo['TKaiin']['iinkaiykcd'] != "") {
							echo $iinkaiyknm[$kaiininfo['TKaiin']['iinkaiykcd']]; } ?>
							<input type="hidden" name="iinkaiykcd" id="iinkaiykcd" value="<?php echo $kaiininfo['TKaiin']['iinkaiykcd']; ?>">
						<?php } ?>
						<?php if(!empty($TKaiinErrors['iinkaiykcd'])): ?><span class="error"><?php echo $TKaiinErrors['iinkaiykcd'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>倶楽部幹事区分</dt>
					<dd>
						<ul> 
							<li><input type="radio" name="kkanjikbn" id="kkanjikbn-r1" value="1" 
								<?php echo $clubsecretary; ?>><label for="kkanjikbn-r1">倶楽部の幹事</label>
							</li>
							<li><input type="radio" name="kkanjikbn" id="kkanjikbn-r2" value="0" 
								<?php echo $others; ?>>
								<label for="kkanjikbn-r2">その他</label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="field14">会員の写真</label>
							<figure class="thum">
								<?php if(empty($kaiininfo['TKaiin']['syasin'])){?>
										<?php echo $this->Html->image('admin/thum.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
										<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base.'/AdminMember/getKaiinSyasin/'.$kaiininfo['TKaiin']['kaiincd'];?>" alt="" style="max-height: 53px;max-width: 53px;width: auto!important;" id="thum01">
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> $this->base.'/AdminMember/getKaiinSyasin/'.$kaiininfo['TKaiin']['kaiincd'] )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetKaiin','id'=>'resetKaiin','value'=> '')); ?>
						<button type="button" class="kaiinReset">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="kainnsyasin" id="kainnsyasin" readonly><button type="button" class ="kaiinbtn">画像選択</button></div>
						<div id="kaiinerror" class="errors-message"></div>
						<div><p><label for="ksyasintitle">写真タイトル</label></p><input type="text" name="ksyasintitle" id="ksyasintitle" placeholder="画像にキャプションがある場合はここに入力してください。" maxlength="60" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['title']; ?>">
							<font color='red'><label class="ksyasintitle"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaiinbikou">備考</label></dt>
					<dd><textarea name="kaiinbikou" id="kaiinbikou" maxlength="255" class="doublebyte" style="resize:none;"><?php echo $kaiininfo['TKaiin']['bikou']; ?></textarea>
						<font color='red'><label class="kaiinbikou"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>更新通知メールの受取</dt>
					<dd>
						<ul>
							<li>
								<input type="radio" name="uketorikbn" id="uketorikbn-r1" value="1" <?php echo $uketorikbnChk; ?>>
								<label for="uketorikbn-r1">メールを受け取る</label>
							</li>
							<li>
								<input type="radio" name="uketorikbn" id="uketorikbn-r2" value="0" <?php echo $uketorikbnUnChk; ?>>
								<label for="uketorikbn-r2">メールを受け取らない</label>
							</li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label style="margin: 47% 0 47% 0;" for="tdest1">通知先１</label></dt>
					<dd>
						<div><p><label for="tbusyo1">部署・役職名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="tbusyo1" id="tbusyo1" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['tbusyo1'];?>">
							<font color='red'><label class="tbusyo1"></label></font>
						</div>
						<div><p><label for="ttantounm1">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm1" id="ttantounm1" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['ttantounm1'];?>">
							<font color='red'><label class="ttantounm1"></label></font>	
						</div>
						<div><p><label for="tmailaddr1" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr1" id="tmailaddr1" class= "underscoresingle" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['tmailaddr1']; ?>">
							<font color='red'><label class="tmailaddr1"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest2" style="margin: 47% 0 47% 0;">通知先２</label></dt>
					<dd>
						<div><p><label for="tbusyo2">部署・役職名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="tbusyo2" id="tbusyo2" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['tbusyo2'];?>">
							<font color='red'><label class="tbusyo2"></label></font>
						</div>
						<div><p><label for="ttantounm2">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm2" id="ttantounm2" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['ttantounm2'];?>">
							<font color='red'><label class="ttantounm2"></label></font>	
						</div>
						<div><p><label for="tmailaddr2" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr2" id="tmailaddr2" class= "underscoresingle" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['tmailaddr2']; ?>">
							<font color='red'><label class="tmailaddr2"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest3" style="margin: 47% 0 47% 0;">通知先３</label></dt>
					<dd>
						<div><p><label for="tbusyo3">部署・役職名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="tbusyo3" id="tbusyo3" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['tbusyo3'];?>">
							<font color='red'><label class="tbusyo3"></label></font>
						</div>
						<div><p><label for="ttantounm3">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm3" id="ttantounm3" maxlength="40" value="<?php echo $kaiininfo['TKaiin']['ttantounm3'];?>">
							<font color='red'><label class="ttantounm3"></label></font>	
						</div>
						<div><p><label for="tmailaddr3" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr3" id="tmailaddr3" class= "underscoresingle" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['tmailaddr3']; ?>">
							<font color='red'><label class="tmailaddr3"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgid">ログインID</label></dt>
					<dd><div class="errors"><input type="text" autocomplete="off" name="lgid" id="lgid" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['lgid']; ?>">
						<font color='red'><label class="lgid"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgpass">ログインパスワード</label></dt>
					<dd><div class="errors"><input type="password" autocomplete="off" name="lgpass" id="lgpass" maxlength="40" placeholder="半角英字、数字、記号を1文字以上含み、6ケタ以上。" value="<?php echo $kaiininfo['TKaiin']['lgpass']; ?>">
						<font color='red'><label class="lgpass"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyubinno">自宅郵便番号</label></dt>
					<dd><div class="errors"><input type="text" name="jyubinno" id="jyubinno" maxlength="7" placeholder="5330000" value="<?php echo $kaiininfo['TKaiin']['jyubinno']; ?>">
						<font color='red'><label class="jyubinno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo1">自宅住所1<br>（番地まで）</label></dt>
					<dd><div class="errors"><input type="text" name="jjyusyo1" id="jjyusyo1" maxlength="255" class="doublebyte" placeholder="例）大阪府大阪市中央区安土町１－２－３" value="<?php echo $kaiininfo['TKaiin']['jjyusyo1']; ?>">
						<font color='red'><label class="jjyusyo1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo2">自宅住所2<br>（建物や部屋番号）</label></dt>
					<dd><div class="errors"><input type="text" name="jjyusyo2" id="jjyusyo2" maxlength="255" class="doublebyte" placeholder="例）朝日生命辰野ビル８F" value="<?php echo $kaiininfo['TKaiin']['jjyusyo2']; ?>">
						<font color='red'><label class="jjyusyo2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jtelno">自宅電話番号</label></dt>
					<dd><div class="errors"><input type="tel" name="jtelno" id="jtelno" maxlength="15" placeholder="01-2345-6789" value="<?php echo $kaiininfo['TKaiin']['jtelno']; ?>">
						<font color='red'><label class="jtelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kttelno">携帯電話番号</label></dt>
					<dd><div class="errors"><input type="tel" name="kttelno" id="kttelno" maxlength="15" placeholder="080-123-45678" value="<?php echo $kaiininfo['TKaiin']['kttelno']; ?>">
						<font color='red'><label class="kttelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="ktmailaddr">携帯メールアドレス</label></dt>
					<dd><div class="errors"><input type="email" class= "underscoresingle" name="ktmailaddr" id="ktmailaddr" maxlength="100" value="<?php echo $kaiininfo['TKaiin']['ktmailaddr']; ?>">
						<font color='red'><label class="ktmailaddr"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>出身地 生まれ</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('umare',array('type'=>'select',
																			'options'=>$todofukennm, 
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['umare'],
																			'name'=>'umare',
																			'empty'=> '選択してください',
																			'id' => 'umare'));?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>出身地 育ち</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('sodati',array('type'=>'select',
																			'options'=>$todofukennm, 
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['sodati'],
																			'name'=>'sodati',
																			'empty'=> '選択してください',
																			'id' => 'sodati'));?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>婚姻区分</dt>
					<dd>
						<ul>
							<?php if(!empty($konin)): foreach($konin as $konininfo): ?>
							<li><input type="radio" name="konin" id="<?php echo $konininfo['MKonin']['konincd'];?>" 
									value="<?php echo $konininfo['MKonin']['konincd'];?>" <?php if ($konininfo['MKonin']['konincd'] == $kaiininfo['TKaiin']['konin']) { ?>
									checked <?php }?>><label for="<?php echo $konininfo['MKonin']['konincd'];?>">
										<?php echo $konininfo['MKonin']['koninnm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						</ul>
						<?php if(!empty($TKaiinErrors['konin'])): ?><span class="error"><?php echo $TKaiinErrors['konin'][0] ?></span><?php endif; ?>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>趣味1</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd1',array('type'=>'select',
																			'options'=> $syuminm, 
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['syumicd1'],
																			'empty'=> '選択してください',
																			'name'=>'syumicd1',
																			'id' => 'syumicd1'));?>
						</div>
						<?php if(!empty($TKaiinErrors['syumicd1'])): ?><span class="error"><?php echo $TKaiinErrors['syumicd1'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt1">趣味1（その他）</label></dt>
					<dd><div class="errors"><input type="text" name="syumitxt1" id="syumitxt1" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['syumitxt1']; ?>">
						<font color='red'><label class="syumitxt1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>趣味2</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd2',array('type'=>'select',
																			'options'=> $syuminm, 
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['syumicd2'],
																			'empty'=> '選択してください',
																			'name'=>'syumicd2',
																			'id' => 'syumicd2'));?>
						</div>
						<?php if(!empty($TKaiinErrors['syumicd2'])): ?><span class="error"><?php echo $TKaiinErrors['syumicd2'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt2">趣味2（その他）</label></dt>
					<dd><div class="errors"><input type="text" name="syumitxt2" id="syumitxt2" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['syumitxt2']; ?>">
						<font color='red'><label class="syumitxt2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>趣味3</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd3',array('type'=>'select',
																			'options'=>$syuminm,
																			'label'=>false,
																			'value' => $kaiininfo['TKaiin']['syumicd3'],
																			'empty'=> '選択してください',
																			'name'=>'syumicd3',
																			'id' => 'syumicd3'));?>
						</div>
						<?php if(!empty($TKaiinErrors['syumicd3'])): ?><span class="error"><?php echo $TKaiinErrors['syumicd3'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt3">趣味3（その他）</label></dt>
					<dd><div class="errors"><input type="text" name="syumitxt3" id="syumitxt3" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['syumitxt3']; ?>">
						<font color='red'><label class="syumitxt3"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikousyoku">嗜好 食べ物</label></dt>
					<dd><div class="errors"><input type="text" name="sikousyoku" id="sikousyoku" maxlength="60" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['sikousyoku']; ?>">
						<font color='red'><label class="sikousyoku"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikounomi">嗜好 飲み物</label></dt>
					<dd><div class="errors"><input type="text" name="sikounomi" id="sikounomi" maxlength="60" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['sikounomi']; ?>">
						<font color='red'><label class="sikounomi"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<div style="float:left;display: inline-block;">
							<ul>
								<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
								<li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" 
										value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $kaiininfo['TKaiin']['koukaikbn']) { ?>
										checked <?php }?>><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>">
											<?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
								<?php endforeach; else: ?>
								<?php endif; ?>
							</ul>
						</div>
						<span style="font-size: 0.9rem;float:left;margin-top:4px;margin-left:30px;">※公開を選択すると、会員企業詳細に写真と会員名称が表示されます。</span>
					</dd>
				</dl>
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
				<dl class="form-common">
					<dt>管理者区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="kanrikbn" id="kanrikbn1" value="<?php echo $this->Constants->SYS_IPPAN; ?>" <?php if($kaiininfo['TKaiin']['kanrikbn'] == $this->Constants->SYS_IPPAN) { ?>checked <?php }?>><label for="kanrikbn1">一般</label></li>
							<li><input type="radio" name="kanrikbn" id="kanrikbn2" value="<?php echo $this->Constants->SYS_KANRISHA; ?>" <?php if($kaiininfo['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>checked <?php }?>><label for="kanrikbn2">システム管理者</label></li>
						</ul>
					</dd>
				</dl>
					<?php }?>
				<h2>会社情報</h2>

				<dl class="form-common">
					<dt><label for="kaisyacd">会社コード</label></dt>
					<dd><?php echo $kaisyainfo['TKaisya']['kaisyacd']; ?>
					<input type="hidden" name="kaisyacd" id="kaisyacd" value="<?php echo $kaisyainfo['TKaisya']['kaisyacd']; ?>"></dd>
				</dl>
				<dl class="form-common">
					<dt <?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?> class="required" <?php }?>><label for="kaisyanm">会社名称</label></dt>
					<dd>
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<div class="errors">
								<input type="text" name="kaisyanm" id="kaisyanm" maxlength="100" class="doublebyte" value="<?php echo $kaisyainfo['TKaisya']['kaisyanm']; ?>">
							</div>
						<?php } else { ?>
							<?php echo $kaisyainfo['TKaisya']['kaisyanm']; ?>
							<input type="hidden" name="kaisyanm" id="kaisyanm" value="<?php echo $kaisyainfo['TKaisya']['kaisyanm']; ?>">
						<?php } ?>
						<font color='red'><label class="kaisyanm"><?php if (!empty($TKaisyaErrors['kaisyanm'])) { echo $TKaisyaErrors['kaisyanm'][0]; }?></label></font>	
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisyanmkana">会社名称かな</label></dt>
					<dd><div class="errors"><input type="text" name="kaisyanmkana" id="kaisyanmkana" maxlength="255" class="doublebyte" value="<?php echo $kaisyainfo['TKaisya']['kaisyanmkana']; ?>">
						<font color='red'><label class="kaisyanmkana"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="yubinno">郵便番号</label></dt>
					<dd><div class="errors"><input type="text" name="yubinno" id="yubinno" maxlength="7" placeholder="5330000" value="<?php echo $kaisyainfo['TKaisya']['yubinno']; ?>">
						<font color='red'><label class="yubinno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyusyo1">住所1<br>（番地まで）</label></dt>
					<dd><div class="errors"><input type="text" name="jyusyo1" id="jyusyo1" maxlength="255" class="doublebyte" placeholder="例）大阪府大阪市中央区安土町１－２－３" value="<?php echo $kaisyainfo['TKaisya']['jyusyo1']; ?>">
						<font color='red'><label class="jyusyo1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyusyo2">住所2<br>（建物や部屋番号）</label></dt>
					<dd><div class="errors"><input type="text" name="jyusyo2" id="jyusyo2" maxlength="255" class="doublebyte" placeholder="例）朝日生命辰野ビル８F" value="<?php echo $kaisyainfo['TKaisya']['jyusyo2']; ?>">
						<font color='red'><label class="jyusyo2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="telno">電話番号</label></dt>
					<dd><div class="errors"><input type="tel" name="telno" id="telno" placeholder="01-2345-6789" maxlength="15" value="<?php echo $kaisyainfo['TKaisya']['telno']; ?>">
					<font color='red'><label class="telno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="faxno">FAX番号</label></dt>
					<dd><div class="errors"><input type="tel" name="faxno" id="faxno" placeholder="01-2345-6789" maxlength="15" value="<?php echo $kaisyainfo['TKaisya']['faxno']; ?>">
						<font color='red'><label class="faxno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="gyosyucd">業種</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('gyosyunm',array('type'=>'select',
																			'options'=>$gyosyunm, 
																			'label'=>false,
																			'value'=>$kaisyainfo['TKaisya']['gyosyucd'],
																			'empty'=> '業種を選択してください',
																			'name'=>'gyosyucd',
																			'id'=>'gyosyucd'));?>
						</div>
						<?php if(!empty($TKaisyaErrors['gyosyucd'])): ?><span class="error"><?php echo $TKaisyaErrors['gyosyucd'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="daihyoyknm">代表者役職名称</label></dt>
					<dd><div class="errors"><input type="text" name="daihyoyknm" id="daihyoyknm" maxlength="80" class="doublebyte" value="<?php echo $kaisyainfo['TKaisya']['daihyoyknm']; ?>">
					<font color='red'><label class="daihyoyknm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="daihyonm">代表者名称</label></dt>
					<dd><div class="errors"><input type="text" name="daihyonm" id="daihyonm" maxlength="40" class="doublebyte" value="<?php echo $kaisyainfo['TKaisya']['daihyonm']; ?>">
					<font color='red'><label class="daihyonm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>設立年</dt>
					<dd><div class="errors"><input type="text" name="seturitu" id="seturitu" maxlength="4" class="ime-ModeDisable" value="<?php echo $kaisyainfo['TKaisya']['seturitu']; ?>">
					<font color='red'><label class="seturitu"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyugyoin">従業員数</label></dt>
					<dd><div class="errors"><input type="text" name="jyugyoin" id="jyugyoin" maxlength="5" value="<?php if($kaisyainfo['TKaisya']['jyugyoin'] != 0 ) { echo $kaisyainfo['TKaisya']['jyugyoin']; } ?>">
					<font color='red'><label class="jyugyoin"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="hpurl">ホームページURL</label></dt>
					<dd><div class="errors"><input type="text" name="hpurl" id="hpurl" maxlength="255" value="<?php echo $kaisyainfo['TKaisya']['hpurl']; ?>">
					<font color='red'><label class="hpurl"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="field53">会社ロゴ</label>
							<figure class="thum">
								<?php if(empty($kaisyainfo['TKaisya']['klogo'])) {?>
									<?php echo $this->Html->image('admin/thum.gif', array('id'=>'thum02','alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> '' )); ?>
								<?php } else {?>
									<img src="<?php echo $this->base.'/AdminMember/getKaisyaklogo/'.$kaisyainfo['TKaisya']['kaisyacd'];?>" alt="" style="max-height: 53px;max-width: 53px;width: auto!important;" id="thum02"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> $this->base.'/AdminMember/getKaisyaklogo/'.$kaisyainfo['TKaisya']['kaisyacd'] )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetLogo','id'=>'resetLogo','value'=> '')); ?>
						<button type="button" class="kaisyaLogoReset">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="klogo" id="klogo" value="" readonly><button type="button" class ="kaisyalogobtn">画像選択</button></div>
						<div id="klogo_err" class="errors-message"></div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="gyoumu">業務内容</label></dt>
					<dd><div class="errors"><textarea name="gyoumu" id="gyoumu" maxlength="2048" class="doublebyte" style="resize:none;"><?php echo $kaisyainfo['TKaisya']['gyoumu']; ?></textarea>
					<font color='red'><label class="gyoumu"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="pr">PR内容</label></dt>
					<dd><div class="errors"><textarea name="pr" id="pr" maxlength="2048" class="doublebyte" style="resize:none;"><?php echo $kaisyainfo['TKaisya']['pr']; ?></textarea>
					<font color='red'><label class="pr"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1">PRイメージ1</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['primage1'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base.'/adminMember/getSyasin/'.$syasinData['primage1'].'/'.$syasinKey;?>" style="max-height: 53px;max-width: 73px;width: auto!important;" alt="" id="thum03"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> $this->base.'/adminMember/getSyasin/'.$syasinData['primage1'].'/'.$syasinKey )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset1','id'=>'reset1','value'=> '')); ?>
						<button type="button" class="addPrImageReset1">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1" id="syasin1" value="" readonly><button type="button" class="primagebtn1">画像選択</button></div>
						<div id="syasin1dd" class="errors-message"></div>
						<?php if(!empty($TKaisyaErrors['field57'])): ?><span class="error"><?php echo $TKaisyaErrors['field57'][0] ?></span><?php endif; ?>
						<div><p><label for="syasintitle1">写真タイトル</label></p><input type="text" name="syasintitle1" id="syasintitle1" maxlength="60" class="doublebyte" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title1']?>">
						<font color='red'><label class="syasintitle1"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin2">PRイメージ2</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['primage2'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum04', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image4','id'=>'image4','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base.'/adminMember/getSyasin/'.$syasinData['primage2'].'/'.$syasinKey;?>" style="max-height: 53px;max-width: 73px;width: auto!important;" alt="" id="thum04"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image4','id'=>'image4','value'=> $this->base.'/adminMember/getSyasin/'.$syasinData['primage2'].'/'.$syasinKey )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset2','id'=>'reset2','value'=> '')); ?>
						<button type="button" class="addPrImageReset2">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2" id="syasin2" readonly><button type="button" class="primagebtn2">画像選択</button></div>
						<div id="syasin2dd" class="errors-message"></div>
						<?php if(!empty($TKaisyaErrors['field59'])): ?><span class="error"><?php echo $TKaisyaErrors['field59'][0] ?></span><?php endif; ?>
						<div><p><label for="syasintitle2">写真タイトル</label></p><input type="text" name="syasintitle2" id="syasintitle2" maxlength="60" class="doublebyte" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title2']?>">
						<font color='red'><label class="syasintitle2"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin3">PRイメージ3</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['primage3'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum05', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image5','id'=>'image5','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base.'/adminMember/getSyasin/'.$syasinData['primage3'].'/'.$syasinKey;?>" style="max-height: 53px;max-width: 73px;width: auto!important;" alt="" id="thum05"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image5','id'=>'image5','value'=> $this->base.'/adminMember/getSyasin/'.$syasinData['primage3'].'/'.$syasinKey )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset3','id'=>'reset3','value'=> '')); ?>
						<button type="button" class="addPrImageReset3">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3" id="syasin3" readonly><button type="button" class="primagebtn3">画像選択</button></div>
						<div id="syasin3dd" class="errors-message"></div>
						<?php if(!empty($TKaisyaErrors['field61'])): ?><span><?php echo $TKaisyaErrors['field61'][0] ?></span><?php endif; ?>
						<div><p><label for="syasintitle3">写真タイトル</label></p><input type="text" name="syasintitle3" id="syasintitle3" maxlength="60" class="doublebyte" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title3']?>">
						<font color='red'><label class="syasintitle3"></label></font>
						</div>
					</dd>
				</dl>
				<?php if($this->Session->read('Auth.User.TKaiin.kanrikbn') == $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kanrikbn') == $this->Constants->SYS_SUPER_KANRISHA) { ?>
					<dl class="form-common">
						<dt><label>ＰＲ商品更新担当者</label></dt>
						<dd>
							<div><p><label for="prmailaddr1">メールアドレス１</label></p></div>
							<div>
								<?php echo $this->Form->input('prmailaddr1', array('id'=>'prmailaddr1', 'name' => 'prmailaddr1','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text','value'=>$kaisyainfo['TKaisya']['prmailaddr1'])); ?>
								<font color='red'><label class="prmailaddr1"></label></font>
							</div>
							<div><p><label for="prmailaddr2">メールアドレス２</label></p></div>
							<div>
								<?php echo $this->Form->input('prmailaddr2', array('id'=>'prmailaddr2', 'name' => 'prmailaddr2','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text','value'=>$kaisyainfo['TKaisya']['prmailaddr2'])); ?>
								<font color='red'><label class="prmailaddr2"></label></font>
							</div>
							<div><p><label for="prmailaddr3">メールアドレス３</label></p></div>
							<div>
								<?php echo $this->Form->input('prmailaddr3', array('id'=>'prmailaddr3', 'name' => 'prmailaddr3','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text','value'=>$kaisyainfo['TKaisya']['prmailaddr3'])); ?>
								<font color='red'><label class="prmailaddr3"></label></font>
							</div>
						</dd>
					</dl>
				<?php } ?>
				<dl class="form-common">
					<dt><label for="kaisyabikou">備考</label></dt>
					<dd><div class="errors"><textarea name="kaisyabikou" id="kaisyabikou" maxlength="1024" class="doublebyte" style="resize:none;"><?php echo $kaisyainfo['TKaisya']['bikou']; ?></textarea>
					<font color='red'><label class="kaisyabikou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<div style="float:left;display: inline-block;">
							<ul>
								<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
								<li><input type="radio" name="kaisyakoukaikbn" id="<?php echo "kaisyakoukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" 
										value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $kaisyainfo['TKaisya']['koukaikbn']) { ?>
										checked <?php }?>><label for="<?php echo "kaisyakoukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>">
											<?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
								<?php endforeach; else: ?>
								<?php endif; ?>
							</ul>
						</div>
						<span style="font-size: 0.9rem;float:left;margin-top:4px;margin-left:30px;">※公開を選択すると、会員企業一覧に表示されます。</span>
						<?php if(!empty($TKaisyaErrors['koukaikbn'])): ?><span class="error"><?php echo $TKaisyaErrors['koukaikbn'][0] ?></span><?php endif; ?>
					</dd>
				</dl>
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
				<div class="register"><?php if(isset($period)){ ?><button type="button" class="admin-back">メニューに戻る</button><?php } else { ?><button type="button" class="b-back">一覧に戻る</button><?php } ?><button type="button" class="e-preview" id="editPreview">プレビュー</button><button type="button" class="e-release" id="edit">更新</button></div>
				<?php } else { ?>
				<div class="register"><?php if(isset($period)){ ?><button type="button" class="admin-back">メニューに戻る</button><?php } else { ?><button type="button" class="returnList">メニューに戻る</button><?php } ?><button type="button" class="e-preview" id="editPreview">プレビュー</button><button type="button" class="e-release" id="edit">更新</button></div>
				<?php } ?>
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { 
					echo $this->Form->input('mainmenu', array('type' => 'hidden','name'=>'mainmenu','id'=>'mainmenu','value'=> '1')); 
				} ?>
			<?php echo $this->Form->end();?>
			<?php
				if(isset($period)):
				echo $this->Form->create('membermgnt', ['id' => 'membermgnt', 'name' => 'membermgnt', 'url' => ['controller' => 'adminMemberManagement', 'action' => 'search']]);
				echo $this->Form->input('kaiinsbnm', array('name' => 'kaiinsbnm','id' => 'kaiinsbnm','value'=>$kaiinsbnms,'type' => 'hidden'));
				echo $this->Form->input('sosiki', array('name' => 'sosiki','id' => 'sosiki','value'=>$sosiki,'type' => 'hidden'));
				echo $this->Form->input('openstate', array('name' => 'openstate','id' => 'openstate','value'=>$openstate,'type' => 'hidden'));
				echo $this->Form->input('enrollment', array('name' => 'enrollment','id' => 'enrollment','value'=>$enrollment,'type' => 'hidden'));
				echo $this->Form->input('registration', array('name' => 'registration','id' => 'registration','value'=>$registration,'type' => 'hidden'));
				echo $this->Form->input('period', array('name' => 'period','id' => 'period','value'=>$period,'type' => 'hidden'));
				echo $this->Form->input('fromdate', array('name' => 'fromdate','id' => 'fromdate','value'=>$fromdate,'type' => 'hidden'));
				echo $this->Form->input('todate', array('name' => 'todate','id' => 'todate','value'=>$todate,'type' => 'hidden'));
				echo $this->Form->end();
				endif;
			?>
			</div><!-- /.form-area -->
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>