<!doctype html>
<title>会員情報 編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/member/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->css('common/common.css') ?>
<script>
  $(function() {
    $(".datepicker").datepicker();
    if($("#image1").val() == ""){
		$('.kaiinReset').prop('disabled', true);
		$('#ksyasintitle').attr('disabled', 'disabled');
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
.register button.e2-release {
	background-color: #f4c000;
}
input[type=text]:disabled {
    background: #dddddd !important;
}
.kaiinReset:disabled {
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
</style>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /nav ========== -->
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== header ========== -->

<!-- ========== /header ========== -->
<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]);
echo $this->Form->end();?>
<?php echo $this->Form->create('membersModoruFrm', ['id' => 'membersModoruFrm', 'url' => ['controller' => 'AdminMemberManagement', 'action' => 'search']]);
	echo $this->Form->input('mailarrmm',array('type'=>'hidden','value'=>$backinfo['mailarrmm']));
	echo $this->Form->input('kaiinsbnm',array('type'=>'hidden','value'=>$backinfo['kaiinsbnm']));
	echo $this->Form->input('sosiki',array('type'=>'hidden','value'=>$backinfo['sosiki']));
	echo $this->Form->input('openstate',array('type'=>'hidden','value'=>$backinfo['openstate']));
	echo $this->Form->input('enrollment',array('type'=>'hidden','value'=>$backinfo['enrollment']));
	echo $this->Form->input('registration',array('type'=>'hidden','value'=>$backinfo['registration']));
	echo $this->Form->input('period',array('type'=>'hidden','value'=>$backinfo['period']));
	echo $this->Form->input('fromdate',array('type'=>'hidden','value'=>$backinfo['fromdate']));
	echo $this->Form->input('todate',array('type'=>'hidden','value'=>$backinfo['todate']));
	echo $this->Form->input('selectedOrder',array('type'=>'hidden','value'=>$backinfo['selectedOrder']));
echo $this->Form->end(); ?>
<!-- ========== main ========== -->
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="returnList">管理画面トップ</a></li>
				<li style="display: inline-block;">会員情報 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="edit_2returnList">一覧に戻る</a></div>
			<div class="message" style="text-align:center;display: none;" id="logid_err">登録データが重複しています。</div>
			<?php echo $this->Session->flash(); ?>
			<h1 class="main-title">会員情報 編集</h1>
			<?php echo $this->Form->create('editfrm', ['enctype' => 'multipart/form-data', 'id' => 'editfrm', 'autocomplete' => 'off' ,'name' => 'editfrm', 'url' => ['controller' => 'AdminMember', 'action' => 'memberEdit2']]);
				echo $this->Form->input('kanrikbn', array('type'=>'hidden','value'=>$this->Constants->SYS_KANRISHA,'name'=>'kanrikbn','id'=>'kanrikbn'));
				echo $this->Form->input('lgid_hid', array('type' => 'hidden','value'=>$kaiininfo['TKaiin']['lgid'],'name'=>'lgid_hid','id'=>'lgid_hid'));
				echo $this->Form->input('kaiinsbnm',array('type'=>'hidden','value'=>$backinfo['kaiinsbnm']));
				echo $this->Form->input('sosiki',array('type'=>'hidden','value'=>$backinfo['sosiki']));
				echo $this->Form->input('openstate',array('type'=>'hidden','value'=>$backinfo['openstate']));
				echo $this->Form->input('enrollment',array('type'=>'hidden','value'=>$backinfo['enrollment']));
				echo $this->Form->input('registration',array('type'=>'hidden','value'=>$backinfo['registration']));
				echo $this->Form->input('period',array('type'=>'hidden','value'=>$backinfo['period']));
				echo $this->Form->input('fromdate',array('type'=>'hidden','value'=>$backinfo['fromdate']));
				echo $this->Form->input('todate',array('type'=>'hidden','value'=>$backinfo['todate']));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd', 'value'=>$kaiininfo['TKaiin']['kaiincd']));
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd', 'value'=>$kaisyainfo['TKaisya']['kaisyacd']));
				echo $this->Form->input('password', array('type' => 'hidden', 'id' => 'password', 'value'=>$password)); 
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaiintitle','id'=>'urlkaiintitle','value'=> $kaiininfo['TKaiin']['title'])); 
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaiinsyasin','id'=>'urlkaiinsyasin','value'=> $images['kaiinimage']));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaisyalogo','id'=>'urlkaisyalogo','value'=> $images['kaisyalogo'])); 
				echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' ));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'pagename','id'=>'pagename','value'=> '2' )); ?>
				<?php echo $this->Form->input('', array('type' => 'file','name'=>'kaiinsyasin','id'=>'kaiinsyasin','style'=> 'display:none')); ?>
			<div class="form-area">
				<h2>会員情報</h2>
				<div>
				</div>
				<dl class="form-common">
					<dt><label for="kaiincd">会員コード</label></dt>
					<dd> 
						<?php echo $kaiininfo['TKaiin']['kaiincd'];
						echo $this->Form->input('kaiincd',array('name'=>'kaiincd','id'=>'kaiincd','type'=>'hidden','value'=>$kaiininfo['TKaiin']['kaiincd']));
						echo $this->Form->input('kaisyacd',array('name'=>'kaisyacd','id'=>'kaisyacd','type'=>'hidden','value'=>$kaiininfo['TKaiin']['kaisyacd']));
						echo $this->Form->input('kanrikbn',array('name'=>'kanrikbn','id'=>'kanrikbn','type'=>'hidden','value'=>$kaiininfo['TKaiin']['kanrikbn'])); ?>
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
					<dd><div class="errors">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<input type="text" name="kaiinnm" id="kaiinnm" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>">
						<?php } else { ?>
							<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>
							<input type="hidden" name="kaiinnm" id="kaiinnm" value="<?php echo $kaiininfo['TKaiin']['kaiinnm']; ?>">
						<?php } ?>
							<font color='red'><label class="kaiinnm"></label></font>
					</div></dd>
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
					<dd><div class="errors">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<input type="text" name="nyukaidate" id="nyukaidate" class="datepicker" maxlength="10"  value="<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>">
						<?php } else { ?>
							<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>
							<input type="hidden" name="nyukaidate" id="nyukaidate" value="<?php if($kaiininfo['TKaiin']['nyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['nyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>">
						<?php } ?>
						<?php if(!empty($TKaiinErrors['nyukaidate'])): ?><span class="error"><?php echo $TKaiinErrors['nyukaidate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
				<dl class="form-common">
					<dt><label for="kyukaidate">休会日付</label></dt>
					<dd><div class="errors"><input type="text" name="kyukaidate" id="kyukaidate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['kyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['kyukaidate'])):  echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['kyukaidate'])); endif; ?>">
					<?php if(!empty($TKaiinErrors['kyukaidate'])): ?><span class="error"><?php echo $errors['kyukaidate'][0] ?></span><?php endif; ?></div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="taikaidate">退会日付</label></dt>
					<dd><div class="errors"><input type="text" name="taikaidate" id="taikaidate" class="datepicker" maxlength="10" value="<?php if($kaiininfo['TKaiin']['taikaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['taikaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['taikaidate'])); endif; ?>">
					<?php if(!empty($TKaiinErrors['taikaidate'])): ?><span class="error"><?php echo $TKaiinErrors['taikaidate'][0] ?></span><?php endif; ?></div></dd>
				</dl>
				<?php } else {?>
					<input type="hidden" name="kyukaidate" id="kyukaidate" value="<?php if($kaiininfo['TKaiin']['kyukaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['kyukaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['kyukaidate'])); endif; ?>">
					<input type="hidden" name="taikaidate" id="taikaidate" value="<?php if($kaiininfo['TKaiin']['taikaidate'] != '0000-00-00' && !empty($kaiininfo['TKaiin']['taikaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['taikaidate'])); endif; ?>">
				<?php } ?>
				<dl class="form-common">
					<dt><label for="syokaisyanm">紹介者名</label></dt>
					<dd><div class="errors">
						<?php if($_SESSION['Auth']['User']['TKaiin']['kanrikbn'] >= $this->Constants->SYS_KANRISHA) { ?>
							<input type="text" name="syokaisyanm" id="syokaisyanm" maxlength="40" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['syokaisyanm']; ?>" >
							<font color='red'><label class="syokaisyanm"></label></font>
						<?php } else { ?>
							<input type="hidden" name="syokaisyanm" id="syokaisyanm" value="<?php echo $kaiininfo['TKaiin']['syokaisyanm']; ?>">
						<?php } ?>
					</div></dd>
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
							<?php echo $kaiininfo['TKaiin']['kyoukaiykcd']; ?>
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
							<?php echo $kaiininfo['TKaiin']['iinkaiykcd']; ?>
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
									<img src="<?php echo $this->base.'/AdminMember/getKaiinSyasin/'.$kaiininfo['TKaiin']['kaiincd'];?>" style="max-height: 53px;max-width: 53px;width: auto!important;" alt="" id="thum01">
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
						<div><p><label for="ksyasintitle">写真タイトル</label></p><input type="text" name="ksyasintitle" id="ksyasintitle" placeholder="画像にキャプションがある場合はここに入力してください。" maxlength="60" class="doublebyte" value="<?php echo $kaiininfo['TKaiin']['title']; ?>"></div>
							<font color='red'><label class="ksyasintitle"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="bikou">備考</label></dt>
					<dd><textarea name="bikou" id="bikou" maxlength="255" class="doublebyte" style="resize: none;"><?php echo $kaiininfo['TKaiin']['bikou']; ?></textarea>
						<font color='red'><label class="bikou"></label></font>
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
					<dt><label for="tdest1" style="margin: 47% 0 47% 0;">通知先１</label></dt>
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

				<div class="register"><button type="button" class="edit_2returnList">一覧に戻る</button><button type="button" class="e-preview" id="editPreview">プレビュー</button><button type="button" class="e2-release" id="edit">更新</button></div>
				
				<h2>会社情報</h2>

				<dl class="form-common">
					<dt>会社コード</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['kaisyacd']; ?></dd>
				</dl>
				<dl class="form-common">
					<dt>会社名称</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['kaisyanm']; ?>
					<?php echo $this->Form->input('kaisyanm', array('id'=>'kaisyanm', 'name'=>'kaisyanm', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['kaisyanm'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>会社名称かな</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['kaisyanmkana']; ?>
					<?php echo $this->Form->input('kaisyanmkana', array('id'=>'kaisyanmkana', 'name'=>'kaisyanmkana', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['kaisyanmkana'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>郵便番号</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['yubinno']; ?>
					<?php echo $this->Form->input('yubinno', array('id'=>'yubinno', 'name'=>'yubinno', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['yubinno'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>住所1<br>（番地まで）</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['jyusyo1']; ?>
					<?php echo $this->Form->input('jyusyo1', array('id'=>'jyusyo1', 'name'=>'jyusyo1', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['jyusyo1'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>住所2<br>（建物や部屋番号）</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['jyusyo2']; ?>
					<?php echo $this->Form->input('jyusyo2', array('id'=>'jyusyo2', 'name'=>'jyusyo2', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['jyusyo2'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>電話番号</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['telno']; ?>
					<?php echo $this->Form->input('telno', array('id'=>'telno', 'name'=>'telno', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['telno'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>FAX番号</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['faxno']; ?>
					<?php echo $this->Form->input('faxno', array('id'=>'faxno', 'name'=>'faxno', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['faxno'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>業種</dt>
					<dd><?php echo $gyosyunm; ?></dd>
				</dl>
				<dl class="form-common">
					<dt>代表者役職名称</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['daihyoyknm']; ?>
					<?php echo $this->Form->input('daihyoyknm', array('id'=>'daihyoyknm', 'name'=>'daihyoyknm', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['daihyoyknm'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>代表者名称</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['daihyonm']; ?>
					<?php echo $this->Form->input('daihyonm', array('id'=>'daihyonm', 'name'=>'daihyonm', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['daihyonm'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>設立年</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['seturitu']; ?></dd>
				</dl>
				<dl class="form-common">
					<dt>従業員数</dt>
					<dd><?php echo $kaisyainfo['TKaisya']['jyugyoin']; ?></dd>
				</dl>
				<dl class="form-common">
					<dt>ホームページURL</dt>
					<dd class="break_line"><?php echo $kaisyainfo['TKaisya']['hpurl']; ?>
					<?php echo $this->Form->input('hpurl', array('id'=>'hpurl', 'name'=>'hpurl', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['hpurl'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">会社ロゴ</dt>
					<dd class="photo">
						<figure class="thum">
							<?php if(empty($kaisyainfo['TKaisya']['klogo'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03','alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
							<?php }else{?>
								<img src="<?php echo $this->base."/AdminMember/getKaisyaklogo/".$kaisyainfo['TKaisya']['kaisyacd'];?>" style="max-height: 53px;max-width: 53px;width: auto!important;" alt="" id="thum03"/>
							<?php }?>
						</figure>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>業務内容</dt>
					<dd><?php echo nl2br($kaisyainfo['TKaisya']['gyoumu']); ?>
					<?php echo $this->Form->input('gyoumu', array('id'=>'gyoumu', 'name'=>'gyoumu', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['gyoumu'])); ?></dd>
				</dl>
				<dl class="form-common">
					<dt>PR内容</dt>
					<dd><?php echo nl2br($kaisyainfo['TKaisya']['pr']);?>
					<?php echo $this->Form->input('pr', array('id'=>'pr', 'name'=>'pr', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['pr'])); ?></dd>
				</dl>
				<dl class="form-common">
					<?php echo $this->Form->input('urlsyasinKey', array('id'=>'urlsyasinKey', 'name'=>'urlsyasinKey', 'label' => false,'type'=>'hidden', 'value' => $syasinKey)); ?>
					<dt class="thum_title">PRイメージ1</dt>
					<dd class="photo">
						<figure class="thum_02">
							<?php if(empty($syasinData['primage1'])){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
							<?php }else{?>
								<?php echo $this->Form->input('primaget1', array('type'=>'hidden','value'=>$syasinData['title1'],'name'=>'primaget1','id'=>'primaget1')); ?>
								<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['primage1']."/".$syasinKey;?>" style="max-height: 53px;max-width: 53px;width: auto!important;" />
								<?php echo $this->Form->input('urlprimage1', array('id'=>'urlprimage1', 'name'=>'urlprimage1', 'label' => false,'type'=>'hidden', 'value' => $syasinData['primage1'])); ?>
							<?php }?>
						</figure>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">PRイメージ2</dt>
					<dd class="photo">
						<figure class="thum_02">
							<?php if(empty($syasinData['primage2'])){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
							<?php }else{?>
								<?php echo $this->Form->input('primaget2', array('type'=>'hidden','value'=>$syasinData['title2'],'name'=>'primaget2','id'=>'primaget2')); ?>
								<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['primage2']."/".$syasinKey;?>" style="max-height: 53px;max-width: 53px;width: auto!important;"/>
								<?php echo $this->Form->input('urlprimage2', array('id'=>'urlprimage2', 'name'=>'urlprimage2', 'label' => false,'type'=>'hidden', 'value' => $syasinData['primage2'])); ?>
							<?php } ?>
						</figure>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">PRイメージ3</dt>
					<dd class="photo">
						<figure class="thum_02">
							<?php if(empty($syasinData['primage3'])){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
							<?php }else{?>
								<?php echo $this->Form->input('primaget3', array('type'=>'hidden','value'=>$syasinData['title3'],'name'=>'primaget3','id'=>'primaget3')); ?>
								<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['primage3']."/".$syasinKey;?>" style="max-height: 53px;max-width: 53px;width: auto!important;"/>
								<?php echo $this->Form->input('urlprimage3', array('id'=>'urlprimage3', 'name'=>'urlprimage3', 'label' => false,'type'=>'hidden', 'value' => $syasinData['primage3'])); ?>
							<?php } ?>
						</figure>
					</dd>
				</dl>
				<?php if($this->Session->read('Auth.User.TKaiin.kanrikbn') == $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kanrikbn') == $this->Constants->SYS_SUPER_KANRISHA) { ?>
					<dl class="form-common">
						<dt><label>ＰＲ商品更新担当者</label></dt>
						<dd>
							<?php if(!empty($kaisyainfo['TKaisya']['prmailaddr1'])) { ?>
							<div><p><label for="prmailaddr1" >メールアドレス１</label></p></div>
							<div>
								<?php echo $kaisyainfo['TKaisya']['prmailaddr1']; ?>
							</div>
							<?php } ?>
							<?php if(!empty($kaisyainfo['TKaisya']['prmailaddr2'])) { ?>
							<div><p><label for="prmailaddr1" >メールアドレス２</label></p></div>
							<div>
								<?php echo $kaisyainfo['TKaisya']['prmailaddr2']; ?>
							</div>
							<?php } ?>
							<?php if(!empty($kaisyainfo['TKaisya']['prmailaddr3'])) { ?>
							<div><p><label for="prmailaddr1" >メールアドレス３</label></p></div>
							<div>
								<?php echo $kaisyainfo['TKaisya']['prmailaddr3']; ?>
							</div>
							<?php } ?>
						</dd>
					</dl>
				<?php } ?>
				<dl class="form-common">
					<dt>備考</dt>
					<dd><?php echo nl2br($kaisyainfo['TKaisya']['bikou']); ?></dd>
				</dl>
				<?php echo $this->Form->end();?>
			</div><!-- /.form-area -->
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>