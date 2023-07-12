<!doctype html>
<title>会員情報 メンバー追加：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/member/index.js') ?>
<?= $this->html->css('common/common.css') ?>
<script>
$(function() {
	$(".datepicker").datepicker();
	$("#seturitu").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
});
</script>
<style> 
input[type=text]:disabled {
    background: #dddddd !important;
}
.add2KaiinSyasinReset:disabled {
	background-color:gray !important;
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
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /nav ========== -->
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== header ========== -->

<!-- ========== /header ========== -->
<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]);
echo $this->Form->end();?>
<?php echo $this->Form->create('membersModoruFrm', ['id' => 'membersModoruFrm', 'url' => ['controller' => 'AdminMember', 'action' => 'search']]);
	echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
	echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
	echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
	echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
	echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
	echo $this->Form->end(); ?>
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="returnList">管理画面トップ</a></li>
				<li style="display: inline-block;">会員情報 メンバー追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="add_2returnList">一覧に戻る</a></div>
			<div class="message" style="text-align:center;display: none;" id="kaiincd_err">登録データが重複しています。</div>
			<div class="message" id="session_err"><?php echo $this->Session->flash(); ?></div>
			<!-- <?php //echo $this->Session->flash(); ?> -->
			<h1 class="main-title">会員情報 メンバー追加</h1>
			<?php echo $this->Form->create('memberAddFrm', ['enctype' => 'multipart/form-data', 'id' => 'memberAddFrm','autocomplete' => 'off', 'name' => 'memberAddFrm', 'url' => ['controller' => 'adminMember', 'action' => 'memberAdd']]);
				echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm,'name'=>'industry','id'=>'industry'));
				echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm,'name'=>'members_type','id'=>'members_type'));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal,'name'=>'free_word','id'=>'free_word'));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk,'name'=>'free_radio','id'=>'free_radio'));
				echo $this->Form->input('kaisyacd', array('type' => 'hidden','value'=>$kaisyainfo['TKaisya']['kaisyacd'],'name'=>'kaisyacd','id'=>'kaisyacd'));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlkaisyalogo','id'=>'urlkaisyalogo','value'=> $kaisyainfo['TKaisya']['kaisyacd']));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'resetKaiin','id'=>'resetKaiin','value'=> ''));
				echo $this->Form->input('', array('type' => 'file','name'=>'kaiinsyasin','id'=>'kaiinsyasin','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' )); ?>
			<div class="form-area">
				<h2>会員情報</h2>
				<div></div>
				<dl class="form-common">
					<dt class="required"><label for="kaiincd">会員コード</label></dt>
					<dd><div class="errors">
						<input type="text" name="kaiincd" id="kaiincd" class ="numberonly ime-ModeDisable" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kaiincd']; endif; ?>" maxlength = "6" placeholder="会員コードを入力してください。">
						<font color='red'><label class="kaiincd"><?php if (!empty($errors['kaiincd'])) { echo $errors['kaiincd'][0]; }?></label></font>	
					</div></dd>			 
				</dl>
				<dl class="form-common">
					<dt class="required">会員種別</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('kaiinsbnm',array('type'=>'select',
																			'options'=>$kaiinsbnm,
																			'value' => $kaiinsbcd,
																			'label'=>false,
																			'name'=>'kaiinsbcd',
																			'id' => 'kaiinsbcd'));?>
							<?php if(!empty($errors['kaiinsbcd'])): ?><span class="error"><?php echo $errors['kaiinsbcd'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kaiinnm">会員名称</label></dt>
					<dd><div class="errors">
						<input type="text" class="doublebyte" name="kaiinnm" id="kaiinnm" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kaiinnm']; endif; ?>">
						<font color='red'><label class="kaiinnm"><?php if (!empty($errors['kaiinnm'])) { echo $errors['kaiinnm'][0]; }?></label></font>	
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaiinnmkana">会員名称かな</label></dt>
					<dd><div class="errors">
						<input type="text" class="doublebyte" name="kaiinnmkana" id="kaiinnmkana" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kaiinnmkana']; endif; ?>">
						<font color='red'><label class="kaiinnmkana"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisyayknm">役職名称</label></dt>
					<dd><div class="errors">
						<input type="text" class="doublebyte" name="kaisyayknm" id="kaisyayknm" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kaisyayknm']; endif; ?>">
						<font color='red'><label class="kaisyayknm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="mailaddr">メールアドレス</label></dt>
					<dd><div class="errors">
						<input type="email" name="mailaddr" id="mailaddr" class= "underscoresingle" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['mailaddr']; endif; ?>">
						<font color='red'><label class="mailaddr"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="seinendate">生年月日</label></dt>
					<dd><div class="errors">
						<input type="text" name="seinendate" id="seinendate" class="datepicker" maxlength="10" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['seinendate']; endif; ?>">
						<?php if(!empty($errors['seinendate'])): ?><span class="error"><?php echo $errors['seinendate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>性別</dt>
					<dd>
						<ul>
							<li><input type="radio" name="seicd" id="seicd-r1" value="<?php echo $seibetu['male']['value']; ?>"  <?php echo $danseiChk; ?>><label for="seicd-r1"><?php echo $seibetu['male']['label']; ?></label></li>
							<li><input type="radio" name="seicd" id="seicd-r2" value="<?php echo $seibetu['female']['value']; ?>" <?php echo $joseiChk; ?>><label for="seicd-r2"><?php echo $seibetu['female']['label']; ?></label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="nyukaidate">入会日付</label></dt>
					<dd><div class="errors">
						<input type="text" name="nyukaidate" id="nyukaidate" class="datepicker" maxlength="10" value="<?php if(!empty($kaiininfo['TKaiin']['nyukaidate'])):  echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['kyukaidate'])); endif; ?>">
						<?php if(!empty($errors['nyukaidate'])): ?><span class="error"><?php echo $errors['nyukaidate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kyukaidate">休会日付</label></dt>
					<dd><div class="errors">
						<input type="text" name="kyukaidate" id="kyukaidate" class="datepicker" maxlength="10" value="<?php if(!empty($kaiininfo['TKaiin']['kyukaidate'])):  echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['nyukaidate'])); endif; ?>">
						<?php if(!empty($errors['kyukaidate'])): ?><span class="error"><?php echo $errors['kyukaidate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="taikaidate">退会日付</label></dt>
					<dd><div class="errors">
						<input type="text" name="taikaidate" id="taikaidate" class="datepicker" maxlength="10" value="<?php if(!empty($kaiininfo['TKaiin']['taikaidate'])): echo date('Y/m/d',strtotime($kaiininfo['TKaiin']['taikaidate'])); endif; ?>">
						<?php if(!empty($errors['taikaidate'])): ?><span class="error"><?php echo $errors['taikaidate'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syokaisyanm">紹介者名</label></dt>
					<dd><div class="errors">
						<input type="text" name="syokaisyanm" id="syokaisyanm" class="doublebyte" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kyoukaiykcd']; endif; ?>">
						<font color='red'><label class="syokaisyanm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field12">協会役職</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('kyoukaiykcd',array('type'=>'select',
																			'options'=>$kyoukaiyknm, 
																			'label'=>false,
																			'value' => $kyoukaiykcd,
																			'name'=>'kyoukaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'kyoukaiykcd'));?>
							<?php if(!empty($errors['kyoukaiykcd'])): ?><span class="error"><?php echo $errors['kyoukaiykcd'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field12">所属委員会</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('sosikinm',array('type'=>'select',
																			'options'=>$sosikinm, 
																			'label'=>false,
																			'value' => $sosikicd,
																			'name'=>'sosikicd',
																			'empty'=> '選択してください',
																			'id' => 'sosikicd'));?>
							<?php if(!empty($errors['sosikicd'])): ?><span class="error"><?php echo $errors['sosikicd'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field13">委員会役職</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('iinkaiyknm',array('type'=>'select',
																			'options'=>$iinkaiyknm, 
																			'label'=>false,
																			'value' => $iinkaiykcd,
																			'name'=>'iinkaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'iinkaiykcd'));?>
							<?php if(!empty($errors['iinkaiykcd'])): ?><span class="error"><?php echo $errors['iinkaiykcd'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>倶楽部幹事区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="kkanjikbn" id="kkanjikbn-r1" value="1"><label for="kkanjikbn-r1">倶楽部の幹事</label>
							</li>
							<li><input type="radio" name="kkanjikbn" id="kkanjikbn-r2" value="0" checked><label for="kkanjikbn-r2">その他</label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="kainnsyasin">会員の写真</label>
							<figure class="thum"><?php echo $this->Html->image('admin/thum.gif', array('id' => 'thum01', 'alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class="add2KaiinSyasinReset" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo"><div class="errors">
						<div><input type="text" name="kainnsyasin" id="kainnsyasin" readonly><button type="button" class="addKaiinsyasinbtn">画像選択</button></div>
						<div id="kaiinerror" class="errors-message"></div>
						<div><p><label for="ksyasintitle">写真タイトル</label></p><input type="text" name="ksyasintitle" id="ksyasintitle" class="doublebyte" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" disabled="disabled"></div>
						<font color='red'><label class="ksyasintitle"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="bikou">備考</label></dt>
					<dd><div class="errors">
						<textarea name="bikou" id="bikou" class="doublebyte" maxlength="255" style="resize:none;"><?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['bikou']; endif; ?></textarea>
						<font color='red'><label class="bikou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>更新通知メールの受取</dt>
					<dd>
						<ul>
							<li>
								<input type="radio" name="uketorikbn" id="uketorikbn-r1" value="1" checked>
								<label for="uketorikbn-r1">メールを受け取る</label>
							</li>
							<li>
								<input type="radio" name="uketorikbn" id="uketorikbn-r2" value="0">
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
							<input type="text" class="doublebyte" name="tbusyo1" id="tbusyo1" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tbusyo1']; endif; ?>">
							<font color='red'><label class="tbusyo1"></label></font>
						</div>
						<div><p><label for="ttantounm1">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm1" id="ttantounm1" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['ttantounm1']; endif; ?>">
							<font color='red'><label class="ttantounm1"><?php if (!empty($errors['ttantounm1'])) { echo $errors['ttantounm1'][0]; }?></label></font>	
						</div>
						<div><p><label for="tmailaddr1" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr1" id="tmailaddr1" class= "underscoresingle" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tmailaddr1']; endif; ?>">
							<font color='red'><label class="tmailaddr1"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest2" style="margin: 47% 0 47% 0;">通知先２</label></dt>
					<dd>
						<div><p><label for="tbusyo2">部署・役職名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="tbusyo2" id="tbusyo2" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tbusyo2']; endif; ?>">
							<font color='red'><label class="tbusyo2"></label></font>
						</div>
						<div><p><label for="ttantounm2">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm2" id="ttantounm2" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['ttantounm2']; endif; ?>">
							<font color='red'><label class="ttantounm2"><?php if (!empty($errors['ttantounm2'])) { echo $errors['ttantounm2'][0]; }?></label></font>	
						</div>
						<div><p><label for="tmailaddr2" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr2" id="tmailaddr2" class= "underscoresingle" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tmailaddr2']; endif; ?>">
							<font color='red'><label class="tmailaddr2"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest3" style="margin: 47% 0 47% 0;">通知先３</label></dt>
					<dd>
						<div><p><label for="tbusyo3">部署・役職名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="tbusyo3" id="tbusyo3" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tbusyo3']; endif; ?>">
							<font color='red'><label class="tbusyo3"></label></font>
						</div>
						<div><p><label for="ttantounm3">担当者名称</label></p></div>
						<div class="errors">
							<input type="text" class="doublebyte" name="ttantounm3" id="ttantounm3" maxlength="40" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['ttantounm3']; endif; ?>">
							<font color='red'><label class="ttantounm3"><?php if (!empty($errors['ttantounm3'])) { echo $errors['ttantounm3'][0]; }?></label></font>	
						</div>
						<div><p><label for="tmailaddr3" >メールアドレス</label></p></div>
						<div class="errors">
							<input type="email" name="tmailaddr3" id="tmailaddr3" class= "underscoresingle" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['tmailaddr3']; endif; ?>">
							<font color='red'><label class="tmailaddr3"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgid">ログインID</label></dt>
					<dd><div class="errors">
						<input type="text" autocomplete="off" name="lgid" id="lgid" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['lgid']; endif; ?>">
						<font color='red'><label class="lgid"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgpass">ログインパスワード</label></dt>
					<dd><div class="errors">
						<input type="password" autocomplete="off" name="lgpass" id="lgpass" maxlength="100" placeholder="半角英字、数字、記号を1文字以上含み、6ケタ以上。" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['lgpass']; endif; ?>">
						<font color='red'><label class="lgpass"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyubinno">自宅郵便番号</label></dt>
					<dd><div class="errors">
						<input type="text" name="jyubinno" id="jyubinno" maxlength="7" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['jyubinno']; endif; ?>">
						<font color='red'><label class="jyubinno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo1">自宅住所1<br>（番地まで）</label></dt>
					<dd><div class="errors">
						<input type="text" name="jjyusyo1" id="jjyusyo1" class="doublebyte" maxlength="255" placeholder="例）大阪府大阪市中央区安土町１－２－３" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['jjyusyo1']; endif; ?>">
						<font color='red'><label class="jjyusyo1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo2">自宅住所2<br>（建物や部屋番号）</label></dt>
					<dd><div class="errors">
						<input type="text" name="jjyusyo2" id="jjyusyo2" class="doublebyte" maxlength="255" placeholder="例）朝日生命辰野ビル８F" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['jjyusyo2']; endif; ?>">
						<font color='red'><label class="jjyusyo2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jtelno">自宅電話番号</label></dt>
					<dd><div class="errors">
						<input type="tel" name="jtelno" id="jtelno" maxlength="15" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['jtelno']; endif; ?>">
						<font color='red'><label class="jtelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kttelno">携帯電話番号</label></dt>
					<dd><div class="errors">
						<input type="tel" name="kttelno" id="kttelno"  maxlength="15" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['kttelno']; endif; ?>">
						<font color='red'><label class="kttelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="ktmailaddr">携帯メールアドレス</label></dt>
					<dd><div class="errors">
						<input type="email" class= "underscoresingle" name="ktmailaddr" id="ktmailaddr" maxlength="100" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['ktmailaddr']; endif; ?>">
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
																			'value' => $umare,
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
																			'value' => $sodati,
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
									value="<?php echo $konininfo['MKonin']['konincd'];?>" <?php if ($konininfo['MKonin']['konincd'] == $kaito) { ?>
									checked <?php }?>><label for="<?php echo $konininfo['MKonin']['konincd'];?>">
										<?php echo $konininfo['MKonin']['koninnm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>趣味1</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd1',array('type'=>'select',
																			'options'=> $syuminm, 
																			'label'=>false,
																			'value' => $syumicd1,
																			'empty'=> '選択してください',
																			'name'=>'syumicd1',
																			'id' => 'syumicd1'));?>
							<?php if(!empty($errors['syumicd1'])): ?><span class="error"><?php echo $errors['syumicd1'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt1">趣味1（その他）</label></dt>
					<dd><div class="errors">
						<input type="text" name="syumitxt1" id="syumitxt1" readonly="readonly" maxlength="40" class="doublebyte" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['syumitxt1']; endif; ?>">
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
																			'value' => $syumicd2,
																			'empty'=> '選択してください',
																			'name'=>'syumicd2',
																			'id' => 'syumicd2'));?>
							<?php if(!empty($errors['syumicd2'])): ?><span class="error"><?php echo $errors['syumicd2'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt2">趣味2（その他）</label></dt>
					<dd><div class="errors">
						<input type="text" name="syumitxt2" id="syumitxt2" readonly="readonly" maxlength="40" class="doublebyte" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['syumitxt2']; endif; ?>">
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
																			'value' => $syumicd3,
																			'empty'=> '選択してください',
																			'name'=>'syumicd3',
																			'id' => 'syumicd3'));?>
						<?php if(!empty($errors['syumicd3'])): ?><span class="error"><?php echo $errors['syumicd3'][0] ?></span><?php endif; ?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt3">趣味3（その他）</label></dt>
					<dd><div class="errors">
						<input type="text" name="syumitxt3" id="syumitxt3" readonly="readonly" maxlength="40" class="doublebyte" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['syumitxt3']; endif; ?>">
						<font color='red'><label class="syumitxt3"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikousyoku">嗜好 食べ物</label></dt>
					<dd><div class="errors">
						<input type="text" name="sikousyoku" id="sikousyoku" maxlength="60" class="doublebyte" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['sikousyoku']; endif; ?>">
						<font color='red'><label class="sikousyoku"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikounomi">嗜好 飲み物</label></dt>
					<dd><div class="errors">
						<input type="text" name="sikounomi" id="sikounomi" maxlength="60" class="doublebyte" value="<?php if(!empty($kaiininfo)): echo $kaiininfo['TKaiin']['sikounomi']; endif; ?>">
						<font color='red'><label class="sikounomi"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd><div class="errors" style="display: inline-block;float:left;">
						<ul>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
							<li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" 
									value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $inval) { ?>
									checked <?php }?>><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>">
										<?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						</ul>
					</div>
					<span style="font-size: 0.9rem;float:left;margin-top:4px;margin-left:30px;">※公開を選択すると、会員企業詳細に写真と会員名称が表示されます。</span>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>管理者区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="kanrikbn" id="kanrikbn1" value="<?php echo $this->Constants->SYS_IPPAN; ?>" checked><label for="kanrikbn1">一般</label></li>
							<li><input type="radio" name="kanrikbn" id="kanrikbn2" value="<?php echo $this->Constants->SYS_KANRISHA; ?>"><label for="kanrikbn2">システム管理者</label></li>
						</ul>
					</dd>
				</dl>
				<div class="register"><button type="button" class="add_2returnList">一覧に戻る</button><button type="button" class="preview">プレビュー</button><?php echo $this->Form->button("登録",array(
							'class' =>'release',
							'name' => 'newRegister',
							'type' => 'button',
							'id' => 'newRegister'));?></div>
				
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
					<dd><?php if($kaisyainfo['TKaisya']['jyugyoin'] != 0 ) { echo $kaisyainfo['TKaisya']['jyugyoin']; } ?></dd>
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
					<dd>
						<?php echo nl2br($kaisyainfo['TKaisya']['pr']);?>
						<?php echo $this->Form->input('pr', array('id'=>'pr', 'name'=>'pr', 'label' => false,'type'=>'hidden', 'value' => $kaisyainfo['TKaisya']['pr'])); ?>
					</dd>
				</dl>
				<dl class="form-common">
					<?php echo $this->Form->input('urlsyasinKey', array('id'=>'urlsyasinKey', 'name'=>'urlsyasinKey', 'label' => false,'type'=>'hidden', 'value' => $syasinKey)); ?>
					<dt class="thum_title">PRイメージ1</dt>
					<dd class="photo">
						<figure class="thum_02">
							<?php if(empty($syasinData['primage1'])){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => ''));?>
							<?php }else{?>
								<?php echo $this->Form->input('primaget1', array('type'=>'hidden','value'=>$syasinData['title1'],'name'=>'primaget1','id'=>'primaget1')); ?>
								<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['primage1']."/".$syasinKey;?>" style="max-height: 53px;max-width: 53px;width: auto!important;" />
								<?php echo $this->Form->input('urlprimage1', array('id'=>'urlprimage1', 'name'=>'urlprimage1', 'label' => false,
																		'type'=>'hidden', 'value' => $syasinData['primage1'])); ?>
							<?php }?>
						</figure>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">PRイメージ2</dt>
					<dd class="photo">
						<figure class="thum_02">
							<?php if(empty($syasinData['primage2'])){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => ''));?>
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
								<?php echo $this->Html->image('admin/thum_02.gif', array('alt' => ''));?>
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