<!doctype html>
<title>有益情報 新規追加：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->html->css('admin/beneficial/style.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/beneficial/add.js') ?>
<script>
  $(function() {
    $(".datepicker").datepicker();
  });
</script>
<style>
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
	input[type=text]:disabled {
	    background: #dddddd !important;
	}
	.rstSyasin1:disabled {
		background-color:gray !important;
	}
	.rstSyasin2:disabled {
		background-color:gray !important;
	}
	.rstSyasin3:disabled {
		background-color:gray !important;
	}
	.rstFile1:disabled {
		background-color:gray !important;
	}
	.rstFile2:disabled {
		background-color:gray !important;
	}
	.rstFile3:disabled {
		background-color:gray !important;
	}
</style>
</head>
<body>
<!-- ========== nav ========== -->
<!-- ========== /nav ========== -->
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="menuBack">管理画面トップ</a></li><!--
				--><li style="display: inline-block;">有益情報 新規追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="menuBack">メニューに戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">有益情報 新規追加</h1>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]);?>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminBeneficialregister', ['enctype' => 'multipart/form-data','id' => 'adminBeneficialregister', 'url' => ['controller' => 'AdminBeneficial', 'action' => 'register']]);?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin1','id'=>'syasin1','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin2','id'=>'syasin2','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin3','id'=>'syasin3','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'file1','id'=>'file1','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'file2','id'=>'file2','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'file3','id'=>'file3','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'editval','id'=>'editval','value'=> '0')); 
				  echo $this->Form->input('hdn_soushin', array('id' => 'hdn_soushin','name' => 'hdn_soushin','type' => 'hidden', 'value' => 0));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'path1file','id'=>'path1file','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'path2file','id'=>'path2file','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'path3file','id'=>'path3file','value'=> '' ));
				  echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' ));
				  echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn')));?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'yuekitouroku','id'=>'yuekitouroku','value'=>$this->Session->read('Auth.User.TKengen.yuekitouroku'))); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'yuekikoukai','id'=>'yuekikoukai','value'=>$this->Session->read('Auth.User.TKengen.yuekikoukai'))); ?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required"><label for="yuekidate">日付</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('yuekidate', array('class'=>'datepicker','id'=>'yuekidate','label'=>false,'type'=>'text','name'=>'yuekidate','value' => date('Y/m/d'),'maxlength' => '10')); ?>
						</div>
						<font color='red'><label class="yuekidate"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="yuekitime">時刻</label></dt>
					<dd>
						<div class="error-list">
						<?php echo $this->Form->input('yuekitime', array('type' => 'text','id' => 'yuekitime', 'label' => false, 'class' => 'ime-ModeDisable timebox','name'=>'yuekitime','value' => date('H:i'), 'onkeypress' => 'return checkTimeValue(event, id, "title");'));?>
						</div>
						<font color='red'><label class="yuekitime"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kaiinnm">情報提供会員</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('kaiinnm', array('type'=>'text','name' => 'kaiinnm','label' => false, 'id' => 'kaiinnm', 'class'=> 'doublebyte', 'maxlength'=> '40','placeholder'=>'ここに会員名称を入力してください。')); ?>
						</div>
						<font color='red'><label class="kaiinnm"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="title">タイトル</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('title', array('type'=>'text','name' => 'title','label' => false, 'id' => 'title', 'maxlength'=> '100','placeholder'=>'ここにタイトルを入力してください。')); ?>
						</div>
						<font color='red'><label class="title"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="naiyo">内容</label></dt>
					<dd>
						<div class="error-list"><?php echo $this->Form->textarea(' ', array('id'=>'naiyo','name'=>'naiyo','maxlength'=>'1024','class' => 'noTrimSpace','style'=>'width:668px;resize: none;'));?></div>
						<font color='red'><label class="naiyo"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1Path">写真1</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class ="rstSyasin1">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1Path" id="syasin1Path" readonly><button type="button" class ="syasin1btn">画像選択</button></div>
						<div id="syasin1dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin1Title">写真タイトル</label></p><input type="text" class="doublebyte" name="syasin1Title" id="syasin1Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。">
						<font color='red'><label class="syasin1Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin2Path">写真2</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum02','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class ="rstSyasin2">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2Path" id="syasin2Path" readonly><button type="button" class ="syasin2btn">画像選択</button></div>
						<div id="syasin2dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin2Title">写真タイトル</label></p><input type="text" class="doublebyte" name="syasin2Title" id="syasin2Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。">
						<font color='red'><label class="syasin2Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin3Path">写真3</label>
							<figure class="thum_02"><?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?></figure>
						</div>
						<button type="button" class ="rstSyasin3">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3Path" id="syasin3Path" readonly><button type="button" class ="syasin3btn">画像選択</button></div>
						<div id="syasin3dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin3Title">写真タイトル</label></p><input type="text" class="doublebyte" name="syasin3Title" id="syasin3Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。">
						<font color='red'><label class="syasin3Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file1Path">添付ファイル1</label>
						<button type="button" class ="rstFile1">リセット</button>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file1Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file1Title" id="file1Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="">
						<font color='red'><label class="file1Title"></label></font>
						</div>
						<div style="margin-top:10px;"><input type="text" name="file1Path" id="file1Path" value="" readonly><button type="button" class ="file1btn">ファイル選択</button></div>
						<label id="file1dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file2Path">添付ファイル2</label>
						<button type="button" class ="rstFile2">リセット</button>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file2Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file2Title" id="file2Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="">
						<font color='red'><label class="file2Title"></label></font>
						</div>
						<div style="margin-top:10px;"><input type="text" name="file2Path" id="file2Path" value="" readonly><button type="button" class ="file2btn">ファイル選択</button></div>
						<label id="file2dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file3Path">添付ファイル3</label>
						<button type="button" class ="rstFile3">リセット</button>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file3Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file3Title" id="file3Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="">
						<font color='red'><label class="file3Title"></label></font>
						</div>
						<div style="margin-top:10px;"><input type="text" name="file3Path" id="file3Path" value="" readonly><button type="button" class ="file3btn">ファイル選択</button></div>
						<label id="file3dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="sankourl">参考URL</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('sankourl', array('type'=>'text','name' => 'sankourl','label' => false, 'id' => 'sankourl', 'maxlength'=> '512','placeholder'=>'')); ?>
						</div>
						<font color='red'><label class="sankourl"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<ul>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
								<li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn_r".$kokaiinfo['MKoukai']['koukaicd'];?>" 
									value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $kokaiVal) { ?>
									checked <?php }?>><label for="<?php echo "koukaikbn_r".$kokaiinfo['MKoukai']['koukaicd'];?>">
										<?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>通知メール</dt>
					<dd>
						<label for="mailchk"><input type="checkbox" name="mailchk" id="mailchk">事務局へ確認・通知メール送信</label>
						<p>※ 事務局へ内容確認や通知をする場合にチェックしてください</p>
					</dd>
				</dl>
				<div class="register"><button type="button" class ="menuBack">メニューに戻る</button><button type="button" class ="b-preview">プレビュー</button><?php echo $this->Form->button("登録", array('class' =>'b-release','type' => 'button','name' => 'register'));?></div>
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
