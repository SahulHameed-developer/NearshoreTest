<!doctype html>
<title>ダウンロードファイル新規追加：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('admin/download/add.js') ?>
<?= $this->Html->css('admin/download/style.css') ?>
<?= $this->Html->css('admin/download/normalize.css') ?>
<?= $this->Html->css('admin/download/main.css') ?>
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
</style>
</head>
<body>
<!-- ========== nav ========== -->
<!-- ========== /nav ========== -->
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="menuBack">管理画面トップ</a></li>
				<li style="display: inline-block;">ダウンロードファイル 新規追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" 
				class="menuBack">メニューに戻る</a></div>
			<h1 class="main-title">ダウンロードファイル 新規追加</h1>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]); 
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('downloadregister', ['enctype' => 'multipart/form-data','id' => 'downloadregister', 'url' => ['controller' => 'AdminDlFile', 'action' => 'register']]); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' ));?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'file1','id'=>'file1','style'=> 'display:none')); ?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required"><label for="rno">カテゴリー</label></dt>
					<dd>
						<div class="error-list">
							<div class="select-wrap">
								<?php echo $this->Form->input('shinkicatagery',array('type'=>'select',
										'options'=>$shinkicatagery, 
										'label'=>false,
										'empty'=> '選択してください','class'=>'select_type',
										'name'=>'rno',
										'id'=>'rno'));?>
								<font color='red'><label class="rno"></label></font>
							</div>
						</div>
						</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title required">
						<label for="filepath">ダウンロードファイル</label>
						<button type="button" class ="rstFile1 mt64">リセット</button>
					</dt>
					<dd class="photo attach">	
						<div class="error-list boxwidth100"><p>
						<label for="title">ファイルタイトル</label></p>
						<input type="text" class="doublebyte" name="title" id="title" class="doublebyte" maxlength="60" placeholder="ファイルタイトルを入力してください。"　value="">
						<font color='red'><label class="title"></label></font>
						</div>
						<div class="mt20"><input type="text" name="filepath" id="filepath" value="" readonly>
						<button type="button" class="downloadbtn">ファイル選択</button>
						<font color='red'><label class="filepath"></label></font>
						</div>
						<font color='red'><label id="file1dd" class="error-list"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required">公開区分</dt>
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
					<dt class="required"><label for="hyojino">表示順</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('hyojino', array('type' => 'text','id' => 'hyojino','name'=>'hyojino', 'class' => 'ime-ModeDisable','style'=>'width:200px;', 'label' => false,'maxlength'=>'3'));?>
						</div>
						<font color='red'><label class="hyojino"></label></font>
					</dd>
				</dl>
				<div class="register"><button type="button" class="menuBack">メニューに戻る</button><button type="button" class ="b-preview">プレビュー</button><?php echo $this->Form->button("登録", array('class' =>'b-release','type' => 'submit','name' => 'register'));?></div>
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
