<!doctype html>
<title>ダウンロードカテゴリー編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/download/categoryedit.js') ?>
<?= $this->html->css('common/common.css') ?>
<style type="text/css">
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
	.deletecls {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5YmK6Zmk5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
		background-color: rgba(255, 255, 255, .5);
	}
	@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
		.heightchange {
			min-height:35.6px !important;
		}
	}
	@media screen and (-webkit-min-device-pixel-ratio:0) { 
	    .heightchange {
		    min-height:35px !important;
		}
	}
	@supports (-ms-ime-align: auto) {
	  .heightchange {
	    	min-height:37px !important;
	  }
	}
	
</style>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<div id="pageloadcls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li>
				<li style="display: inline-block;">ダウンロードカテゴリー 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="backpage_head">メニューに戻る</a></div>
			<h1 class="main-title">ダウンロードカテゴリー 編集</h1>
			<?php echo $this->Form->create('categoryedit', ['id' => 'categoryedit', 'url' => ['controller' => 'admindlcategory', 'action' => 'categoryedit']]);
				echo $this->Form->input('hiddenradio_previous', array('id' => 'hiddenradio_previous','name' => 'hiddenradio_previous','type' => 'hidden'));
			?>
			<div class="form-area">
				<dl class="form-common" id="categoryfield">
					<dt class="required">編集区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="category" id="cat_1" class="radio" value="<?php echo $CATEGORY_ADD;?>" checked><label for="cat_1">カテゴリー追加</label></li>
							<li><input type="radio" name="category" id="cat_2" class="radio" value="<?php echo $CATEGORY_UPD;?>"><label for="cat_2">カテゴリー変更</label></li>
							<li><input type="radio" name="category" id="cat_3" class="radio" value="<?php echo $CATEGORY_DEL;?>"><label for="cat_3">カテゴリー削除</label></li>
						</ul>
					</dd>
				</dl>
				<?php
					echo $this->Form->input('hdnCATEGORY_ADD', array('id' => 'hdnCATEGORY_ADD','name' => 'hdnCATEGORY_ADD','type' => 'hidden', 'value'=> $CATEGORY_ADD));
					echo $this->Form->input('hdnCATEGORY_UPD', array('id' => 'hdnCATEGORY_UPD','name' => 'hdnCATEGORY_UPD','type' => 'hidden', 'value'=> $CATEGORY_UPD));
					echo $this->Form->input('hdnCATEGORY_DEL', array('id' => 'hdnCATEGORY_DEL','name' => 'hdnCATEGORY_DEL','type' => 'hidden', 'value'=> $CATEGORY_DEL));
				?>
				<dl class="form-common"  >
					<dt class="required"><label for="dlcatename" id="categorycombo">カテゴリー</label></dt>
					<dd>
						<div class="error-list" style="height: 40px">
							<div class="select-wrap" id="dlcatenmselectbox">
									<?php echo $this->Form->input('dlcatename',array('type'=>'select','options'=>$dlcatenm, 
										'label'=>false,
										'value'=>'',
										'empty'=> '選択してください','class'=>'select_type','id'=>'dlcatename','name'=>'dlcatename'));?>
							</div>
							<div class="error-list heightchange" id="categorynametextbox" >
								<?php echo $this->Form->input('', array('type' => 'text','id' => 'categoryname','name'=>'categoryname', 'label' => false, 'maxlength' => 30));?>
							</div>
						</div>
						<font color='red'><label class="dlcatename"></label></font>
					</dd>
				</dl>
				<dl class="form-common"  id="category_editdl">
					<dt class="required"><label for="dlcatename_edit">カテゴリー</label></dt>
					<dd>
						<div class="error-list" style="height: 40px">
							<div class="error-list heightchange" id="categorynametextbox_edit" >
								<?php echo $this->Form->input('', array('type' => 'text','id' => 'categoryname_edit','name'=>'categoryname_edit', 'label' => false, 'maxlength' => 30));?>
							</div>
						</div>
						<font color='red'><label class="dlcatename_edit"></label></font>
					</dd>
				</dl>
				<!-- <dl class="form-common" id="categorynamefield">
					
					<font color='red'><label class="categoryname"></label></font>
					</dd>
				</dl> -->
				<dl class="form-common" id="koukaifield">
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
				<dl class="form-common" id="hyojinofield">
					<dt class="required"><label for="hyojino">表示順</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('hyojino', array('type' => 'text','id' => 'hyojino','name'=>'hyojino', 'class' => 'ime-ModeDisable','style'=>'width:200px;', 'label' => false,'maxlength'=>'3'));?>
						</div>
						<font color='red'><label class="hyojino"></label></font>
					</dd>
				</dl>
				<div class="register" style="max-width: 360px;"><button type="button" class="b-back backpage_head" >メニューに戻る</button><?php echo $this->Form->button("登録	",array('class' =>'b-release reg','type' => 'button','name' => 'register','id' => 'register')); ?><?php echo $this->Form->button("更新	",array('class' =>'b-release upd','type' => 'button','name' => 'register')); ?><?php echo $this->Form->button("削除	",array('class' =>'b-release delete','type' => 'button','name' => 'register')); ?>
				</div>
			</div>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('homepageForm', ['id' => 'homepageForm', 'url' => ['controller' => 'admin', 'action' => 'home']]);
			echo $this->Form->end();?>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>