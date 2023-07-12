<!doctype html>
<title>会員情報 新規追加：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/member/index.js') ?>
<?= $this->Html->css('admin/member/style.css') ?>
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
.rstKaiinSyasin:disabled {
	background-color:gray !important;
}
.rstkaisyalogo:disabled {
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
</style>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /nav ========== -->
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== header ========== -->
<!-- ========== /header ========== -->
<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]);
echo $this->Form->end();?>
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="returnList">管理画面トップ</a></li><li  style="display: inline-block;">会員情報 新規追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="returnList">メニューに戻る</a></div>
			<div class="message" style="text-align:center;display: none;" id="kaiincd_err">登録データが重複しています。</div>
			<div class="message" id="session_err"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">会員情報 新規追加</h1>
			<?php echo $this->Form->create('newListAddFrm', ['enctype' => 'multipart/form-data', 'id' => 'newListAddFrm','autocomplete' => 'off', 'name' => 'newListAddFrm', 'url' => ['controller' => 'AdminMember', 'action' => 'add']]);
				echo $this->Form->input('', array('type' => 'file','name'=>'kaiinsyasin','id'=>'kaiinsyasin','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'file','name'=>'kaisyalogo','id'=>'kaisyalogo','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'file','name'=>'primage1','id'=>'primage1','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'file','name'=>'primage2','id'=>'primage2','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'file','name'=>'primage3','id'=>'primage3','style'=> 'display:none')); 
				echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' )); ?>
			<div class="form-area">
				<h2>会員情報</h2>
				<dl class="form-common">
					<dt class="required"><label for="kaiincd">会員コード</label></dt>
					<dd><div class="errors">
					<?php echo $this->Form->input('kaiincd', array('type' => 'text', 'placeholder' => '会員コードを入力してください。' ,
							'name' => 'kaiincd', 'class' => 'ime-ModeDisable numberonly', 'id' => 'kaiincd', 'maxlength'=>'6', 'label' => false));?>
							<font color='red'><label class="kaiincd"><?php if (!empty($ValidateAjay['kaiincd'])) { echo $ValidateAjay['kaiincd'][0]; }?></label></font>
					</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required">会員種別</dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('kaiinsbcd',array('type'=>'select',
																			'options'=>$kaiinsbnm, 
																			'label'=>false,
																			'value' => $kaiinsbcd,
																			'name' => 'kaiinsbcd',
																			'id' => 'kaiinsbcd'));?>
						</div>
						<?php if(!empty($ValidateAjay['kaiinsbcd']['0'])): ?><span class="error"><?php echo $ValidateAjay['kaiinsbcd'][0] ?></span><?php endif; ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kaiinnm">会員名称</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kaiinnm', array('type' => 'text','id' => 'kaiinnm', 'maxlength'=>'40',
							'class' => 'doublebyte', 'placeholder' => '姓　名' , 'name' => 'kaiinnm', 'label' => false));?>
						<font color='red'><label class="kaiinnm"><?php if (!empty($ValidateAjay['kaiinnm'])) { echo $ValidateAjay['kaiinnm'][0]; }?></label></font>	
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaiinnmkana">会員名称かな</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kaiinnmkana', array('type' => 'text','id' => 'kaiinnmkana', 'maxlength'=>'40',
							'class' => 'doublebyte', 'placeholder' => '姓　名' ,'name' => 'kaiinnmkana', 'label' => false));?>
						<font color='red'><label class="kaiinnmkana"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisyayknm">役職名称</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kaisyayknm', array('type' => 'text','id' => 'kaisyayknm', 'name' => 'kaisyayknm', 'maxlength'=>'40','class' => 'doublebyte', 'label' => false));?>
						<font color='red'><label class="kaisyayknm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="mailaddr">メールアドレス</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('mailaddr', array('type' => 'text','id' => 'mailaddr','class'=>'underscoresingle', 'name' => 'mailaddr', 'maxlength'=>'100', 'label' => false));?>
						<font color='red'><label class="mailaddr"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="seinendate">生年月日</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('seinendate', array('class'=>'datepicker','id'=>'seinendate', 'name' => 'seinendate', 'label' => false,'type'=>'text','maxlength' => '10')); ?>
						<font color='red'><label class="seinendate"></label></font>
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
						<?php echo $this->Form->input('nyukaidate', array('class'=>'datepicker','id'=>'nyukaidate', 'name' => 'nyukaidate', 'label' => false, 'value' => '','type'=>'text','maxlength' => '10')); ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kyukaidate">休会日付</label></dt>
					<dd><div class="errors">
							<?php echo $this->Form->input('kyukaidate', array('class'=>'datepicker','id'=>'kyukaidate', 'name' => 'kyukaidate', 'label' => false, 'value' => '','type'=>'text','maxlength' => '10')); ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="taikaidate">退会日付</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('taikaidate', array('class'=>'datepicker','id'=>'taikaidate', 'name' => 'taikaidate', 'label' => false, 'value' => '','type'=>'text','maxlength' => '10')); ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syokaisyanm">紹介者名</label></dt>
					<dd><div class="errors">
						<?php echo $this->form->input('syokaisyanm', array('type' => 'text', 'id' => 'syokaisyanm' , 'name' => 'syokaisyanm', 'maxlength'=>'40','class' => 'doublebyte', 'label' => false)); ?>
						<font color='red'><label class="syokaisyanm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kyoukaiyknm">協会役職</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('kyoukaiykcd',array('type'=>'select',
																			'options'=>$kyoukaiyknm, 
																			'label'=>false,
																			'value' => $kyoukaiykcd,
																			'name' => 'kyoukaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'kyoukaiykcd'));?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sosikicd">所属委員会</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('sosikicd',array('type'=>'select',
																			'options'=>$sosikinm, 
																			'label'=>false,
																			'value' => $sosikicd,
																			'name' => 'sosikicd',
																			'empty'=> '選択してください',
																			'id' => 'sosikicd'));?>
						</div>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="iinkaiykcd">委員会役職</label></dt>
					<dd><div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('iinkaiykcd',array('type'=>'select',
																			'options'=>$iinkaiyknm, 
																			'label'=>false,
																			'value' => $iinkaiykcd,
																			'name' => 'iinkaiykcd',
																			'empty'=> '選択してください',
																			'id' => 'iinkaiykcd')); ?>
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
							<figure class="thum">
								<?php if(empty($kaiininfo['TKaiin']['syasin'])){?>
										<?php echo $this->Html->image('admin/thum.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
								<?php }else{?>
									<?php echo $this->Html->image($kaiininfo['TKaiin']['syasin'], array('width'=>'300px', 'height'=>'20px','id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?>
								<?php }?>
							</figure>
						</div>
						<button type="button" class ="rstKaiinSyasin" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo">
							<div><input type="text" name="kainnsyasin" id="kainnsyasin" readonly><button type="button" class ="kaiinbtn">画像選択</button></div>
							<div id="kaiinerror" class="errors-message"></div>
							<div><p><label for="ksyasintitle">写真タイトル</label></p><input type="text" name="ksyasintitle" id="ksyasintitle" class="doublebyte"  maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" disabled="disabled">
							<font color='red'><label class="ksyasintitle"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaiinbikou">備考</label></dt>
					<dd><div class="errors">
						<?php  echo $this->Form->textarea('kaiinbikou', array( 'label' => false, 'name' => 'kaiinbikou', 'id' => 'kaiinbikou','class' => 'doublebyte','maxlength'=>'255', 'escape' => false,'style'=>'resize:none;'));?>
						<font color='red'><label class="kaiinbikou"></label></font>
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
						<div>
							<?php echo $this->Form->input('tbusyo1', array('type' => 'text','id' => 'tbusyo1', 'name' => 'tbusyo1', 'maxlength'=>'40','class' => 'doublebyte', 'label' => false));?>
							<font color='red'><label class="tbusyo1"></label></font>
						</div>
						<div><p><label for="ttantounm1">担当者名称</label></p></div>
						<div>
							<?php echo $this->Form->input('ttantounm1', array('type' => 'text','id' => 'ttantounm1', 'maxlength'=>'40',
								'class' => 'doublebyte', 'placeholder' => '姓　名' , 'name' => 'ttantounm1', 'label' => false));?>
							<font color='red'><label class="ttantounm1"></font>	
						</div>
						<div><p><label for="tmailaddr1" >メールアドレス</label></p></div>
						<div>
							<?php echo $this->Form->input('tmailaddr1', array('id'=>'tmailaddr1', 'name' => 'tmailaddr1','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
							<font color='red'><label class="tmailaddr1"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest2" style="margin: 47% 0 47% 0;">通知先２</label></dt>
					<dd>
						<div><p><label for="tbusyo2">部署・役職名称</label></p></div>
						<div>
							<?php echo $this->Form->input('tbusyo2', array('type' => 'text','id' => 'tbusyo2', 'name' => 'tbusyo2', 'maxlength'=>'40','class' => 'doublebyte', 'label' => false));?>
							<font color='red'><label class="tbusyo2"></label></font>
						</div>
						<div><p><label for="ttantounm2">担当者名称</label></p></div>
						<div>
							<?php echo $this->Form->input('ttantounm2', array('type' => 'text','id' => 'ttantounm2', 'maxlength'=>'40',
								'class' => 'doublebyte', 'placeholder' => '姓　名' , 'name' => 'ttantounm2', 'label' => false));?>
							<font color='red'><label class="ttantounm2"></font>	
						</div>
						<div><p><label for="tmailaddr2" >メールアドレス</label></p></div>
						<div>
							<?php echo $this->Form->input('tmailaddr2', array('id'=>'tmailaddr2', 'name' => 'tmailaddr2','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
							<font color='red'><label class="tmailaddr2"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="tdest3" style="margin: 47% 0 47% 0;">通知先３</label></dt>
					<dd>
						<div><p><label for="tbusyo3">部署・役職名称</label></p></div>
						<div>
							<?php echo $this->Form->input('tbusyo3', array('type' => 'text','id' => 'tbusyo3', 'name' => 'tbusyo3', 'maxlength'=>'40','class' => 'doublebyte', 'label' => false));?>
							<font color='red'><label class="tbusyo3"></label></font>
						</div>
						<div><p><label for="ttantounm3">担当者名称</label></p></div>
						<div>
							<?php echo $this->Form->input('ttantounm3', array('type' => 'text','id' => 'ttantounm3', 'maxlength'=>'40',
								'class' => 'doublebyte', 'placeholder' => '姓　名' , 'name' => 'ttantounm3', 'label' => false));?>
							<font color='red'><label class="ttantounm3"></font>	
						</div>
						<div><p><label for="tmailaddr3">メールアドレス</label></p></div>
						<div>
							<?php echo $this->Form->input('tmailaddr3', array('id'=>'tmailaddr3', 'name' => 'tmailaddr3','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
							<font color='red'><label class="tmailaddr3"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgid">ログインID</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('lgid', array('id'=>'lgid', 'label' => false, 'name' => 'lgid','autocomplete'=>'off', 'maxlength'=>'100', 'class' => 'logintext ime-ModeDisable','type'=>'text')); ?>
						<font color='red'><label class="lgid"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="lgpass">ログインパスワード</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('lgpass', array('id'=>'lgpass', 'label' => false, 'name' => 'lgpass','autocomplete'=>'off', 'maxlength'=>'40', 'class' => 'logintext','type'=>'password','placeholder'=>'半角英字、数字、記号を1文字以上含み、6ケタ以上。')); ?>
						<font color='red'><label class="lgpass"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyubinno">自宅郵便番号</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jyubinno', array('id'=>'jyubinno', 'label' => false, 'class' => 'bango', 'name' => 'jyubinno', 'placeholder'=>'ハイフンを含まない','type'=>'text', 'maxlength'=>'7')); ?>
						<font color='red'><label class="jyubinno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo1">自宅住所1<br>（番地まで）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jjyusyo1', array('id'=>'jjyusyo1', 'label' => false, 'placeholder'=>'例）大阪府大阪市中央区安土町１－２－３','type'=>'text', 'class' => 'doublebyte', 'name' => 'jjyusyo1', 'maxlength'=>'255')); ?>
						<font color='red'><label class="jjyusyo1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jjyusyo2">自宅住所2<br>（建物や部屋番号）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jjyusyo2', array('id'=>'jjyusyo2', 'label' => false, 'placeholder'=>'例）朝日生命辰野ビル８F','type'=>'text', 'class' => 'doublebyte', 'name' => 'jjyusyo2', 'maxlength'=>'255')); ?>
						<font color='red'><label class="jjyusyo2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jtelno">自宅電話番号</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jtelno', array('id'=>'jtelno', 'label' => false, 'class' => 'bango', 'name' => 'jtelno', 'placeholder'=>'半角ハイフンを含めた電話番号','type'=>'text', 'name' => 'jtelno','maxlength'=>'15')); ?>
						<font color='red'><label class="jtelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kttelno">携帯電話番号</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kttelno', array('id'=>'kttelno', 'label' => false, 'class' => 'bango', 'name' => 'kttelno', 'placeholder'=>'半角ハイフンを含めた電話番号','type'=>'text', 'name' => 'kttelno','maxlength'=>'15')); ?>
						<font color='red'><label class="kttelno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="ktmailaddr">携帯メールアドレス</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('ktmailaddr', array('id'=>'ktmailaddr','maxlength'=>'100','class'=>'underscoresingle', 'label' => false, 'placeholder'=>'','type'=>'text', 'name' => 'ktmailaddr')); ?>
						<font color='red'><label class="ktmailaddr"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>出身地 生まれ</dt>
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('umare',array('type'=>'select',
														'options'=>$todofuken, 
														'label'=>false,
														'value' => '',
														'empty'=> '選択してください',
														'id' => 'umare', 'name' => 'umare')); ?>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>出身地 育ち</dt>
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('sodati',array('type'=>'select',
														'options'=>$todofuken, 
														'label'=>false,
														'value' => '',
														'empty'=> '選択してください',
														'id' => 'sodati', 
														'name' => 'sodati')); ?>
						</div>
					</dd>
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
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd1',array('type'=>'select',
																			'options'=>$msyumi, 
																			'label'=>false,
																			'value' => $syumicd1,
																			'empty'=> '選択してください',
																			'name'=>'syumicd1',
																			'id' => 'syumicd1'));?>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt1">趣味1（その他）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('syumitxt1', array('id'=>'syumitxt1', 'name' => 'syumitxt1', 'readonly' => 'readonly', 'label' => false, 'placeholder'=>'','maxlength'=>'40','class' => 'doublebyte','type'=>'text')); ?>
						<font color='red'><label class="syumitxt1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>趣味2</dt>
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd2',array('type'=>'select',
																			'options'=>$msyumi, 
																			'label'=>false,
																			'value' => $syumicd2,
																			'empty'=> '選択してください',
																			'name'=>'syumicd2',
																			'id' => 'syumicd2'));?>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt2">趣味2（その他）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('syumitxt2', array('id'=>'syumitxt2', 'name' => 'syumitxt2', 'readonly' => 'readonly', 'label' => false, 'placeholder'=>'','maxlength'=>'40','class' => 'doublebyte','type'=>'text')); ?>
						<font color='red'><label class="syumitxt2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>趣味3</dt>
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('syumicd3',array('type'=>'select',
																			'options'=>$msyumi, 
																			'label'=>false,
																			'value' => $syumicd3,
																			'empty'=> '選択してください',
																			'name'=>'syumicd3',
																			'id' => 'syumicd3'));?>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syumitxt3">趣味3（その他）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('syumitxt3', array('id'=>'syumitxt3', 'label' => false, 'placeholder'=>'','maxlength'=>'40','class' => 'doublebyte','type'=>'text', 'readonly' => 'readonly', 'name' => 'syumitxt3',)); ?>
						<font color='red'><label class="syumitxt3"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikousyoku">嗜好 食べ物</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('sikousyoku', array('id'=>'sikousyoku', 'name' => 'sikousyoku', 'label' => false, 'placeholder'=>'','maxlength'=>'60','type'=>'text', 'class' => 'doublebyte','maxlength'=>'60')); ?>
						<font color='red'><label class="sikousyoku"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sikounomi">嗜好 飲み物</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('sikounomi', array('id'=>'sikounomi', 'label' => false, 'placeholder'=>'','type'=>'text', 'name' => 'sikounomi', 'class' => 'doublebyte','maxlength'=>'60')); ?>
						<font color='red'><label class="sikounomi"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<div style="display: inline-block;float:left;">
							<ul>
								<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
								<li><input type="radio" name="kaiinkoukaikbn" id="<?php echo "kaiinkoukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" 
										value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $inval) { ?>
										checked <?php }?>><label for="<?php echo "kaiinkoukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>">
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

				<h2>会社情報</h2>

				<dl class="form-common">
					<dt class="required"><label for="kaisyacd">会社コード</label></dt>
					<dd><div class="errors">
					<?php echo $this->Form->input('kaisyacd', array('id'=>'kaisyacd', 'maxlength'=>'5', 'name' => 'kaisyacd', 'label' => false, 'placeholder'=>'','type'=>'text', 'class' => 'ime-ModeDisable numberonly')); ?>
						<font color='red'><label class="kaisyacd"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kaisyanm">会社名称</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kaisyanm', array('id'=>'kaisyanm', 'name' => 'kaisyanm', 'label' => false, 'placeholder'=>'', 'maxlength'=>'100','type'=>'text', 'class' => 'doublebyte')); ?>
						<font color='red'><label class="kaisyanm"><?php if (!empty($ValidateAjay['kaisyanm'])) { echo $ValidateAjay['kaisyanm'][0]; }?></label></font>													
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisyanmkana">会社名称かな</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('kaisyanmkana', array('id'=>'kaisyanmkana', 'name' => 'kaisyanmkana', 'label' => false, 'placeholder'=>'','type'=>'text', 'class' => 'doublebyte', 'maxlength'=>'255')); ?>
						<font color='red'><label class="kaisyanmkana"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="yubinno">郵便番号</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('yubinno', array('id'=>'yubinno', 'label' => false, 'name' => 'yubinno', 'placeholder'=>'ハイフンを含まない','type'=>'text', 'class' => 'bango', 'maxlength'=>'7')); ?>
						<font color='red'><label class="yubinno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyusyo1">住所1<br>（番地まで）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jyusyo1', array('id'=>'jyusyo1', 'label' => false, 'placeholder'=>'例）大阪府大阪市中央区安土町１－２－３','type'=>'text', 'name' => 'jyusyo1', 'class' => 'doublebyte', 'maxlength'=>'255')); ?>
						<font color='red'><label class="jyusyo1"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyusyo2">住所2<br>（建物や部屋番号）</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jyusyo2', array('id'=>'jyusyo2', 'label' => false, 'placeholder'=>'例）朝日生命辰野ビル８F','type'=>'text', 'name' => 'jyusyo2', 'class' => 'doublebyte', 'maxlength'=>'255')); ?>
						<font color='red'><label class="jyusyo2"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="telno">電話番号</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('telno', array('id'=>'telno', 'label' => false, 'placeholder'=>'半角ハイフンを含めた電話番号','type'=>'text', 'name' => 'telno', 'class' => 'bango', 'maxlength'=>'15')); ?>
						<font color='red'><label class="telno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="faxno">FAX番号</label></dt>
					<dd><div class="errors"><?php echo $this->Form->input('faxno', array('id'=>'faxno', 'label' => false, 'placeholder'=>'半角ハイフンを含めた電話番号','type'=>'text', 'name' => 'faxno', 'class' => 'bango', 'maxlength'=>'15')); ?>
						<font color='red'><label class="faxno"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class=""><label for="field47">業種</label></dt>
					<dd>
						<div class="select-wrap">
							<?php echo $this->Form->input('gyosyucd',array('type'=>'select',
																			'options'=>$gyosyunm,
																			'label'=>false,
																			'value' => $gyosyucd,
																			'empty'=> '選択してください',
																			'name'=>'gyosyucd',
																			'id' => 'gyosyucd'));?>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="daihyoyknm">代表者役職名称</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('daihyoyknm', array('id'=>'daihyoyknm', 'label' => false, 'placeholder'=>'','type'=>'text', 'name'=>'daihyoyknm', 'class' => 'doublebyte', 'maxlength'=>'80')); ?>
						<font color='red'><label class="daihyoyknm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="daihyonm">代表者名称</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('daihyonm', array('id'=>'daihyonm', 'label' => false, 'placeholder'=>'','type'=>'text', 'name'=>'daihyonm', 'class' => 'doublebyte', 'maxlength'=>'40')); ?>
						<font color='red'><label class="daihyonm"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>設立年</dt>
					<dd><div class="errors">
							<?php echo $this->Form->input('seturitu',array('type' => 'text', 'name'=>'seturitu', 'id'=>'seturitu','class' => 'ime-ModeDisable','maxlength'=>'4', 'label'=>false)); ?>
						<font color='red'><label class="seturitu"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="jyugyoin">従業員数</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('jyugyoin', array('id'=>'jyugyoin', 'name'=>'jyugyoin', 'label' => false, 'placeholder'=>'','type'=>'text','maxlength'=>'5')); ?>
						<font color='red'><label class="jyugyoin"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="hpurl">ホームページURL</label></dt>
					<dd><div class="errors">
						<?php echo $this->Form->input('hpurl', array('id'=>'hpurl', 'name'=>'hpurl', 'label' => false, 'placeholder'=>'','type'=>'text','maxlength'=>'255')); ?>
						<font color='red'><label class="hpurl"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="klogo">会社ロゴ</label>
							<figure class="thum"><?php echo $this->Html->image('admin/thum.gif', array('id'=>'thum02', 'alt' => '','style'=>'max-height: 53px;max-width: 53px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class="rstkaisyalogo" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="klogo" id="klogo" readonly><button type="button" class ="kaisyalogobtn">画像選択</button></div>
						<div id="klogo_err" class="errors-message"></div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="gyoumu">業務内容</label></dt>
					<dd><?php  echo $this->Form->textarea('gyoumu', array('label' => false, 'class' => 'doublebyte', 'name'=>'gyoumu','id' => 'gyoumu', 'maxlength'=>'2048','escape' => false,'style'=>'resize:none;'));?>
						<font color='red'><label class="gyoumu"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="pr">PR内容</label></dt>
					<dd><?php  echo $this->Form->textarea('pr', array('label' => false, 'class' => 'doublebyte', 'name'=>'pr','id' => 'pr', 'maxlength'=>'2048', 'escape' => false,'style'=>'resize:none;'));?>
						<font color='red'><label class="pr"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1">PRイメージ1</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class="addPrImageReset1" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1" id="syasin1" readonly><button type="button" class="primagebtn1">画像選択</button></div>
						<div id="syasin1dd" class="errors-message"></div>
						<div><p><label for="syasintitle1">イメージタイトル</label></p><input type="text" name="syasintitle1" id="syasintitle1" placeholder="画像にキャプションがある場合はここに入力してください。" maxlength="60" class="doublebyte" disabled="disabled">
						<font color='red'><label class="syasintitle1"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin2">PRイメージ2</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum04', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class="addPrImageReset2" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2" id="syasin2" readonly><button type="button" class="primagebtn2">画像選択</button></div>
						<div id="syasin2dd" class="errors-message"></div>
						<div><p><label for="syasintitle2">イメージタイトル</label></p><input type="text" name="syasintitle2" id="syasintitle2" placeholder="画像にキャプションがある場合はここに入力してください。" maxlength="60" class="doublebyte" disabled="disabled">
						<font color='red'><label class="syasintitle2"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin3">PRイメージ3</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum05', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class="addPrImageReset3" disabled="disabled">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3" id="syasin3" readonly><button type="button" class="primagebtn3">画像選択</button></div>
						<div id="syasin3dd" class="errors-message"></div>
						<div><p><label for="syasintitle3">イメージタイトル</label></p><input type="text" name="syasintitle3" id="syasintitle3" placeholder="画像にキャプションがある場合はここに入力してください。" maxlength="60" class="doublebyte" disabled="disabled">
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
								<?php echo $this->Form->input('prmailaddr1', array('id'=>'prmailaddr1', 'name' => 'prmailaddr1','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
								<font color='red'><label class="prmailaddr1"></label></font>
							</div>
							<div><p><label for="prmailaddr2">メールアドレス２</label></p></div>
							<div>
								<?php echo $this->Form->input('prmailaddr2', array('id'=>'prmailaddr2', 'name' => 'prmailaddr2','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
								<font color='red'><label class="prmailaddr2"></label></font>
							</div>
							<div><p><label for="prmailaddr3">メールアドレス３</label></p></div>
							<div>
								<?php echo $this->Form->input('prmailaddr3', array('id'=>'prmailaddr3', 'name' => 'prmailaddr3','class'=>'underscoresingle', 'maxlength'=>'100', 'label' => false,'type'=>'text')); ?>
								<font color='red'><label class="prmailaddr3"></label></font>
							</div>
						</dd>
					</dl>
				<?php } ?>
				<dl class="form-common">
					<dt><label for="kaisyabikou">備考</label></dt>
					<dd><?php  echo $this->Form->textarea('kaisyabikou', array('label' => false, 'class' => 'doublebyte', 'name' => 'kaisyabikou','id' => 'kaisyabikou', 'maxlength'=>'1024', 'escape' => false,'style'=>'resize:none;'));?>
						<font color='red'><label class="kaisyabikou"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<div style="display: inline-block;float:left;">
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
						<span style="font-size: 0.9rem;float:left;margin-top:4px;margin-left:30px;">※公開を選択すると、会員企業一覧に表示されます。</span>
					</dd>
				</dl>
				<div class="register"><button type="button" class="returnList">メニューに戻る</button><button type="button" class="b-preview" id="addPreview">プレビュー</button><?php echo $this->Form->button("登録",array(
							'class' =>'b-release',
							'name' => 'newRegister',
							'type' => 'button',
							'id' => 'newRegister'));?>
				</div>
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
