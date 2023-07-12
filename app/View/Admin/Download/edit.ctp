<!doctype html>
<title>ダウンロードファイル 編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/download/edit.js') ?>
<?= $this->Html->css('admin/download/style.css') ?>
<?= $this->Html->css('admin/download/normalize.css') ?>
<?= $this->Html->css('admin/download/main.css') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<style>
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
.rstFile:disabled {
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
<!-- ========== main ========== -->
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li>
				<li style="display: inline-block;">ダウンロードファイル 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="menuBack">一覧に戻る</a></div>
			<h1 class="main-title">ダウンロードファイル 編集</h1>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'AdminDlFile', 'action' => 'search']]);
			echo $this->Form->input('selecteddlcatenm', array('name'=>'selecteddlcatenm','type' => 'hidden','value'=>$selecteddlcatenm));
			echo $this->Form->input('free-word', array('name'=>'free-word','type' => 'hidden','value'=>$freewordval));
			echo $this->Form->input('catagery', array('id'=>'catagery','type' => 'hidden',  'value' => $catagery));
			echo $this->Form->input('openstate', array('id'=>'openstate','type' => 'hidden',  'value' => $openstate));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('adminDownloadedit', ['enctype' => 'multipart/form-data','id' => 'adminDownloadedit', 'url' => ['controller' => 'adminDownload', 'action' => 'update']]); 
			echo $this->Form->input('', array('type' => 'file','name'=>'file','id'=>'file','style'=> 'display:none'));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'tdlarno','id'=>'tdlarno','value'=> $tdlarno));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfile','id'=>'urlfile','value'=> $file));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfiletitle','id'=>'urlfiletitle','value'=> $filetitle));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfileKey','id'=>'urlfileKey','value'=> $filekeyval));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' ));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'oldhoujino','id'=>'oldhoujino','value'=> $hyojino )); 
			echo $this->Form->input('', array('type' => 'hidden','name'=>'catageryType',
				'id'=>'catageryType','value'=> $catageryType ));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word',
				'id'=>'free_word','value'=> $free_word ));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'catagery',
				'id'=>'catagery','value'=> $catagery ));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'openstate',
			    'id'=>'openstate','value'=> $openstate ));?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="thum_title required"><label for="catageryType">カテゴリー</label></dt>
					<dd>
						<div class="error-list">
							<div class="select-wrap">
								<?php echo $this->Form->input('shinkicatagery',array('type'=>'select',
										'options'=>$shinkicatagery, 
										'label'=>false,
										'value'=>$selectedcatagery,
										'empty'=> '選択してください','class'=>'select_type',
										'name'=>'catageryType',
										'id'=>'catageryType'));?>
							</div>
						</div>
						<font color='red'><label class="catageryType"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title required">
						<label for="field02">ダウンロードファイル</label>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetfile','id'=>'resetfile','value'=> '')); ?>
						<button type="button" class ="rstFile">リセット</button>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'pathfile','id'=>'pathfile','value'=> $filepath )); ?>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="filetitle">ファイルタイトル</label></p><input type="text" class="doublebyte" name="filetitle" id="filetitle" maxlength="60" placeholder="ファイルタイトルを入力してください。" value="<?php echo $filetitle?>">
						<font color='red'><label class="filetitle"></label></font>
						</div>
						<?php $filename = split('/',$filepath); 
							if($filepath != "") {
						?>
						<div id="path" style="margin-bottom: 10px;margin-top: 10px;" class="breadcrumbs inline">
							<?php
								if (file_exists(WWW_APP_ROOT.$downloadFilePath.$filepath)) {
									echo $this->Html->link($filename[1],Router::url('/', true).WWW_APP_ROOT.$downloadFilePath.$filepath.$curtime,['target' => '_blank', 'download'=>$filename[1]]); 
								} else { ?>
									<span tooltip="ファイルが存在しません"><?php echo $filename[1]; ?></span>
							<?php } ?>
						</div>
						<?php } ?>
						<div style="margin-top:20px;"><input type="text" name="filePath" id="filePath" value="" readonly><button type="button" class ="filebtn">ファイル選択</button></div>
						<font color='red'><label id="filedd" class="error-list"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title required">公開区分</dt>
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
					<dt class="thum_title required"><label for="hyojino">表示順</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('hyojino', array('type' => 'text','id' => 'hyojino','name'=>'hyojino', 'class' => 'ime-ModeDisable','style'=>'width:200px;', 'label' => false,'maxlength'=>'3', 'value' => $hyojino));?>
						</div>
						<font color='red'><label class="hyojino"></label></font>
					</dd>
				</dl>
				<div class="register"><button type="button" class ="menuBack">一覧に戻る</button><button type="button" class ="b-preview">プレビュー</button><?php echo $this->Form->button("更新", array('class' =>'b-release','type' => 'submit','name' => 'register'));?></div>
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
