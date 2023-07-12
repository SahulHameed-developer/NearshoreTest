<!doctype html>
<title>お知らせ 編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->html->css('admin/news/style.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/news/edit.js') ?>
<?= $this->html->css('common/common.css') ?>
<script>
  $(function() {
    $(".datepicker").datepicker();
  });
</script>
<style type="text/css">
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
	#naiyo:disabled {
		background: #dddddd !important;
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
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li><li style="display: inline-block;">お知らせ 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="menuBack">一覧に戻る</a></div>
			<h1 class="main-title">お知らせ 編集</h1>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'adminNews', 'action' => 'search']]);
			echo $this->Form->input('oshiraseDtFrm', array('type' => 'hidden','value'=>$oshiraseDtFrm));
			echo $this->Form->input('oshiraseDtTo', array('type' => 'hidden','value'=>$oshiraseDtTo));
			echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$free_word));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('adminNewsregister', ['enctype' => 'multipart/form-data','id' => 'adminNewsregister', 'url' => ['controller' => 'adminNews', 'action' => 'update']]);
			echo $this->Form->input('hdn_soushin', array('id' => 'hdn_soushin','name' => 'hdn_soushin','type' => 'hidden', 'value' => 0));
			echo $this->Form->input('id', array('type' => 'hidden','name'=>'id','id'=>'id', 'value' => $oshiraseishousai['0']['TOsirase']['arno']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin1','id'=>'urlsyasin1','value'=> $syasinData['syasin1']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin2','id'=>'urlsyasin2','value'=> $syasinData['syasin2']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin3','id'=>'urlsyasin3','value'=> $syasinData['syasin3']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle1','id'=>'urltitle1','value'=> $syasinData['title1']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle2','id'=>'urltitle2','value'=> $syasinData['title2']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle3','id'=>'urltitle3','value'=> $syasinData['title3']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasinKey','id'=>'urlsyasinKey','value'=> $syasinKey));
			echo $this->Form->input('', array('type' => 'file','name'=>'syasin1','id'=>'syasin1','style'=> 'display:none'));
			echo $this->Form->input('', array('type' => 'file','name'=>'syasin2','id'=>'syasin2','style'=> 'display:none')); 
			echo $this->Form->input('', array('type' => 'file','name'=>'syasin3','id'=>'syasin3','style'=> 'display:none')); 
			echo $this->Form->input('', array('type' => 'file','name'=>'file1','id'=>'file1','style'=> 'display:none')); 
			echo $this->Form->input('', array('type' => 'file','name'=>'file2','id'=>'file2','style'=> 'display:none')); 
			echo $this->Form->input('', array('type' => 'file','name'=>'file3','id'=>'file3','style'=> 'display:none'));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfile1','id'=>'urlfile1','value'=> $fileData['file1']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfile2','id'=>'urlfile2','value'=> $fileData['file2']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfile3','id'=>'urlfile3','value'=> $fileData['file3']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' ));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfiletitle1','id'=>'urlfiletitle1','value'=> $fileData['filetitle1']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfiletitle2','id'=>'urlfiletitle2','value'=> $fileData['filetitle2']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfiletitle3','id'=>'urlfiletitle3','value'=> $fileData['filetitle3']));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'urlfileKey','id'=>'urlfileKey','value'=> $filekeyval));
			echo $this->Form->input('oshiraseDtFrm', array('id'=>'oshiraseDtFrm','type' => 'hidden','value'=>$oshiraseDtFrm,'name'=>'oshiraseDtFrm','id'=>'oshiraseDtFrm'));
			echo $this->Form->input('oshiraseDtTo', array('id'=>'oshiraseDtTo','type' => 'hidden','value'=>$oshiraseDtTo,'name'=>'oshiraseDtTo','id'=>'oshiraseDtTo'));
			echo $this->Form->input('free_word', array('id'=>'free_word','type' => 'hidden','value'=>$free_word,'name'=>'free_word','id'=>'free_word'));
			echo $this->Form->input('', array('type' => 'hidden','name'=>'editval','id'=>'editval','value'=> '1'));
			echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn'))); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'osirasetouroku','id'=>'osirasetouroku','value'=>$this->Session->read('Auth.User.TKengen.osirasetouroku'))); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'osirasekoukai','id'=>'osirasekoukai','value'=>$this->Session->read('Auth.User.TKengen.osirasekoukai'))); ?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required"><label for="osirasedate">お知らせ日付</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('osirasedate', array('class'=>'datepicker','id'=>'osirasedate','label'=>false,'type'=>'text','name'=>'osirasedate','value'=> mb_substr(str_replace('-', '/', $oshiraseishousai['0']['TOsirase']['osirasedt']), 0,10 ),'maxlength' => '10')); ?>
					</div>
					<font color='red'><label class="osirasedate"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="osirasetime">お知らせ時刻</label></dt>
					<dd>
					<div class="error-list">
					<?php echo $this->Form->input('osirasetime', array('type' => 'text','id' => 'osirasetime', 'label' => false, 'class' => 'ime-ModeDisable timebox','name'=>'osirasetime','value'=> mb_substr(str_replace('-', '/', $oshiraseishousai['0']['TOsirase']['osirasedt']), 11,5 ), 'onkeypress' => 'return checkTimeValue(event, id, "title");'));?>
					</div>
					<font color='red'><label class="osirasetime"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="title">お知らせタイトル</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('title', array('type'=>'text','name' => 'title','label' => false, 'id' => 'title', 'maxlength'=> '100','placeholder'=>'ここにタイトルを入力してください。','value' => $oshiraseishousai['0']['TOsirase']['title'])); ?>
						</div>
						<font color='red'><label class="title"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="naiyo">お知らせ内容</label></dt>
					<dd><div class="error-list"><?php  echo $this->Form->textarea('notes', array('name' => 'naiyo','label' => false,'maxlength'=> '1024','id' => 'naiyo', 'escape' => false,'style'=>'width:668px;resize: none;','class' => 'noTrimSpace','value' => $oshiraseishousai['0']['TOsirase']['naiyo']));?></div>
						<font color='red'><label class="naiyo"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1Path">写真1</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['syasin1'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['syasin1']."/".$syasinKey;?>" id="thum01" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> $this->base."/news/getSyasinImage/".$syasinData['syasin1']."/".$syasinKey )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset1','id'=>'reset1','value'=> '')); ?>
						<button type="button" class ="rstSyasin1">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1Path" id="syasin1Path" value="" readonly><button type="button" class ="syasin1btn">画像選択</button></div>
						<div id="syasin1dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin1Title">写真タイトル</label></p><input type="text" name="syasin1Title" id="syasin1Title" class="doublebyte" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title1']?>">
						<font color='red'><label class="syasin1Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin2Path">写真2</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['syasin2'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum02','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['syasin2']."/".$syasinKey;?>" id="thum02" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> $this->base."/news/getSyasinImage/".$syasinData['syasin2']."/".$syasinKey )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset2','id'=>'reset2','value'=> '')); ?>
						<button type="button" class ="rstSyasin2">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2Path" id="syasin2Path" readonly><button type="button" class ="syasin2btn">画像選択</button></div>
						<div id="syasin2dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin2Title">写真タイトル</label></p><input type="text" class="doublebyte" name="syasin2Title" id="syasin2Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title2']?>">
						<font color='red'><label class="syasin2Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin3Path">写真3</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['syasin3'])){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/adminNews/getSyasin/".$syasinData['syasin3']."/".$syasinKey;?>" id="thum03" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> $this->base."/news/getSyasinImage/".$syasinData['syasin3']."/".$syasinKey )); ?>
								<?php }?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset3','id'=>'reset3','value'=> '')); ?>
						<button type="button" class ="rstSyasin3">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3Path" id=syasin3Path readonly><button type="button" class ="syasin3btn">画像選択</button></div>
						<div id="syasin3dd" class="errors"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin3Title">写真タイトル</label></p><input type="text" class="doublebyte" name="syasin3Title" id="syasin3Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title3']?>">
						<font color='red'><label class="syasin3Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file1Path">添付ファイル1</label>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetfile1','id'=>'resetfile1','value'=> '')); ?>
						<button type="button" class ="rstFile1">リセット</button>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'path1file','id'=>'path1file','value'=> $path1file )); ?>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file1Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file1Title" id="file1Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="<?php echo $fileData['filetitle1']?>">
						<font color='red'><label class="file1Title"></label></font>
						</div>
						<?php $filename1 = split('/',$path1file); 
							if($path1file != "") {
						?>
						<div id="path1" style="margin-bottom: 10px;margin-top: 10px;" class="breadcrumbs inline">
							<?php
								if (file_exists(WWW_APP_ROOT.$osiraseFilePath.$path1file)) {
									echo $this->Html->link($filename1[1],Router::url('/', true).WWW_APP_ROOT.$osiraseFilePath.$path1file,['target' => '_blank', 'download'=>$filename1[1]]); 
								} else { ?>
									<span tooltip="ファイルが存在しません"><?php echo $filename1[1]; ?></span>
							<?php } ?>
						</div>
						<?php } ?>
						<div style="margin-top:20px;"><input type="text" name="file1Path" id="file1Path" value="" readonly><button type="button" class ="file1btn">ファイル選択</button></div>
						<label id="file1dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file2Path">添付ファイル2</label>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetfile2','id'=>'resetfile2','value'=> '')); ?>
						<button type="button" class ="rstFile2">リセット</button>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'path2file','id'=>'path2file','value'=> $path2file )); ?>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file2Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file2Title" id="file2Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="<?php echo $fileData['filetitle2']?>">
						<font color='red'><label class="file2Title"></label></font>
						</div>
						<?php $filename2 = split('/',$path2file); 
							if($path2file != "") {
						?>
						<div id="path2" style="margin-bottom: 10px;margin-top: 10px;" class="breadcrumbs inline">
							<?php
								if (file_exists(WWW_APP_ROOT.$osiraseFilePath.$path2file)) {
									echo $this->Html->link($filename2[1],Router::url('/', true).WWW_APP_ROOT.$osiraseFilePath.$path2file,['target' => '_blank', 'download'=>$filename2[1]]); 
								} else { ?>
									<span tooltip="ファイルが存在しません"><?php echo $filename2[1]; ?></span>
							<?php } ?>
						</div>
						<?php } ?>
						<div style="margin-top:20px;"><input type="text" name="file2Path" id="file2Path" value="" readonly><button type="button" class ="file2btn">ファイル選択</button></div>
						<label id="file2dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<label for="file3Path">添付ファイル3</label>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'resetfile3','id'=>'resetfile3','value'=> '')); ?>
						<button type="button" class ="rstFile3">リセット</button>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'path3file','id'=>'path3file','value'=> $path3file )); ?>
					</dt>
					<dd class="photo attach">
						<div class="error-list" style="width: 100%;"><p><label for="file3Title">ファイルタイトル</label></p><input type="text" class="doublebyte" name="file3Title" id="file3Title" maxlength="60" placeholder="添付ファイルに見出しがある場合はここに入力してください。" value="<?php echo $fileData['filetitle3']?>">
						<font color='red'><label class="file3Title"></label></font>
						</div>
						<?php $filename3 = split('/',$path3file); 
							if($path3file != "") {
						?>
						<div id="path3" style="margin-bottom: 10px;margin-top: 10px;" class="breadcrumbs inline">
							<?php
								if (file_exists(WWW_APP_ROOT.$osiraseFilePath.$path3file)) {
									echo $this->Html->link($filename3[1],Router::url('/', true).WWW_APP_ROOT.$osiraseFilePath.$path3file,['target' => '_blank', 'download'=>$filename3[1]]); 
								} else { ?>
									<span tooltip="ファイルが存在しません"><?php echo $filename3[1]; ?></span>
							<?php } ?>
						</div>
						<?php } ?>
						<div style="margin-top:20px;"><input type="text" name="file3Path" id="file3Path" value="" readonly><button type="button" class ="file3btn">ファイル選択</button></div>
						<label id="file3dd" class="errors"></label>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<ul>
						<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
							<li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn_r".$kokaiinfo['MKoukai']['koukaicd'];?>" 
									value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $oshiraseishousai['0']['TOsirase']['koukaikbn']) { ?>
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
				<div class="register"><button type="button" class ="menuBack">一覧に戻る</button><button type="button" class ="b-preview">プレビュー</button><?php echo $this->Form->button("更新", array('class' =>'b-release','type' => 'button','name' => 'register'));?></div>
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
