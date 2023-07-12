<!doctype html>
<title>PR商品情報 編集：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/product/edit.js') ?>
<script>
	$(function() {
		$(".datepicker").datepicker();
	});
	var BASE_PATH = "<?php echo BASE_PATH; ?>";
</script>
<style>
.registerTantou button.b-preview::after, .registerTantou button.b-release::after {
	top: 12px !important;
}
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
.rstSyasin1:disabled {
	background-color:gray !important;
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
				--><li style="display: inline-block;">PR商品情報 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="listBack">一覧に戻る</a></div>
			<h1 class="main-title">PR商品情報 編集</h1>
			<?php echo $this->Form->create('ProductSearchForm', ['id' => 'ProductSearchForm','url' => ['controller' => 'AdminProductsite', 'action' => 'search']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Producteditfrm']['gyosyunm']) ? $this->request->data['Producteditfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Producteditfrm']['kaiinsbnm']) ? $this->request->data['Producteditfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Producteditfrm']['free_word']) ? $this->request->data['Producteditfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Producteditfrm']['free_radio']) ? $this->request->data['Producteditfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'openstate','id'=>'openstate','value' => (isset($this->request->data['Producteditfrm']['openstate']) ? $this->request->data['Producteditfrm']['openstate'] : $this->request->data['openstate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'registrationstate','id'=>'registrationstate','value' => (isset($this->request->data['Producteditfrm']['registrationstate']) ? $this->request->data['Producteditfrm']['registrationstate'] : $this->request->data['registrationstate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'Kikanjoutai','id'=>'Kikanjoutai','value' => (isset($this->request->data['Producteditfrm']['Kikanjoutai']) ? $this->request->data['Producteditfrm']['Kikanjoutai'] : $this->request->data['Kikanjoutai'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Producteditfrm']['fromdate']) ? $this->request->data['Producteditfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Producteditfrm']['todate']) ? $this->request->data['Producteditfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Producteditfrm']['selectedOrder']) ? $this->request->data['Producteditfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]);
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('Producteditfrm', ['id' => 'Producteditfrm', 'url' => ['controller' => 'AdminProductsite', 'action' => 'edit']]);
				echo $this->Form->input('', array('type' => 'hidden','name'=>'arno','id'=>'arno','value' => (isset($this->request->data['Producteditfrm']['arno']) ? $this->request->data['Producteditfrm']['arno'] : $this->request->data['arno'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value' => (isset($this->request->data['Producteditfrm']['kaisyacd']) ? $this->request->data['Producteditfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value' => (isset($this->request->data['Producteditfrm']['kaisyanm']) ? $this->request->data['Producteditfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'gyosyunm','id'=>'gyosyunm','value' => (isset($this->request->data['Producteditfrm']['gyosyunm']) ? $this->request->data['Producteditfrm']['gyosyunm'] : $this->request->data['gyosyunm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaiinsbnm','id'=>'kaiinsbnm','value' => (isset($this->request->data['Producteditfrm']['kaiinsbnm']) ? $this->request->data['Producteditfrm']['kaiinsbnm'] : $this->request->data['kaiinsbnm'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_word','id'=>'free_word','value' => (isset($this->request->data['Producteditfrm']['free_word']) ? $this->request->data['Producteditfrm']['free_word'] : $this->request->data['free_word'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'free_radio','id'=>'free_radio','value' => (isset($this->request->data['Producteditfrm']['free_radio']) ? $this->request->data['Producteditfrm']['free_radio'] : $this->request->data['free_radio'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'openstate','id'=>'openstate','value' => (isset($this->request->data['Producteditfrm']['openstate']) ? $this->request->data['Producteditfrm']['openstate'] : $this->request->data['openstate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'registrationstate','id'=>'registrationstate','value' => (isset($this->request->data['Producteditfrm']['registrationstate']) ? $this->request->data['Producteditfrm']['registrationstate'] : $this->request->data['registrationstate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'Kikanjoutai','id'=>'Kikanjoutai','value' => (isset($this->request->data['Producteditfrm']['Kikanjoutai']) ? $this->request->data['Producteditfrm']['Kikanjoutai'] : $this->request->data['Kikanjoutai'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'fromdate','id'=>'fromdate','value' => (isset($this->request->data['Producteditfrm']['fromdate']) ? $this->request->data['Producteditfrm']['fromdate'] : $this->request->data['fromdate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'todate','id'=>'todate','value' => (isset($this->request->data['Producteditfrm']['todate']) ? $this->request->data['Producteditfrm']['todate'] : $this->request->data['todate'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'selectedOrder','id'=>'selectedOrder','value' => (isset($this->request->data['Producteditfrm']['selectedOrder']) ? $this->request->data['Producteditfrm']['selectedOrder'] : $this->request->data['selectedOrder'])));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('adminPRshohinupdate', ['enctype' => 'multipart/form-data','id' => 'adminPRshohinupdate', 'url' => ['controller' => 'AdminProductsite', 'action' => 'register']]);
				echo $this->Form->input('previewflg', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg'));
				echo $this->Form->input('id', array('type' => 'hidden','name'=>'id','id'=>'id', 'value' => $gettprsyohin['TPrsyohin']['arno']));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin1','id'=>'urlsyasin1','value'=> $gettprsyohin ['tsy'] ['rno']));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle1','id'=>'urltitle1','value'=> $gettprsyohin ['tsy'] ['title']));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasinKey','id'=>'urlsyasinKey','value'=> $gettprsyohin['TPrsyohin']['syasinkey']));
				echo $this->Form->input('', array('type' => 'file','name'=>'syasin1','id'=>'syasin1','style'=> 'display:none'));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyacd','id'=>'kaisyacd','value' => (isset($this->request->data['Producteditfrm']['kaisyacd']) ? $this->request->data['Producteditfrm']['kaisyacd'] : $this->request->data['kaisyacd'])));
				echo $this->Form->input('', array('type' => 'hidden','name'=>'kaisyanm','id'=>'kaisyanm','value' => (isset($this->request->data['Producteditfrm']['kaisyanm']) ? $this->request->data['Producteditfrm']['kaisyanm'] : $this->request->data['kaisyanm'])));
			?>
				<div class="form-area">
					<dl class="form-common">
						<dt><label for="kaishaMeisho">会社名称</label></dt>
						<dd><?php echo isset($this->request->data['Producteditfrm']['kaisyanm']) ? $this->request->data['Producteditfrm']['kaisyanm'] : $this->request->data['kaisyanm']; ?></dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="syohinnm">商品・サービス名</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->textarea(' ', array('id'=>'syohinnm','name'=>'syohinnm','value'=>$gettprsyohin['TPrsyohin']['syohinnm'],'maxlength'=>'100','class' => 'noTrimSpace','style'=>'width:668px;resize: none;')); ?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="syohinnm"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="syousai">商品・サービス詳細</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->textarea(' ', array('id'=>'syousai','name'=>'syousai','value'=>$gettprsyohin['TPrsyohin']['syousai'],'maxlength'=>'1024','class' => 'noTrimSpace','style'=>'width:668px;resize: none;'));?>
							</div>
							<font color='red' style="font-size: 13px;"><label class="syousai"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="thum_title">
							<div class="thum_box">
								<label for="syasin1Path">写真</label>
								<figure class="thum_02">
									<?php if(empty($gettprsyohin ['tsy'] ['rno'])){?>
										<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
										<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' )); ?>
									<?php }else{?>
										<img src="<?php echo $this->base."/AdminProductsite/getSyasin/".$gettprsyohin ['tsy'] ['rno']."/".$gettprsyohin['TPrsyohin']['syasinkey'];?>" id="thum01" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
										<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> $this->base."/AdminProductsite/getSyasinImage/".$gettprsyohin ['tsy'] ['rno']."/".$gettprsyohin['TPrsyohin']['syasinkey'] )); ?>
									<?php } ?>
								</figure>
							</div>
							<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset1','id'=>'reset1','value'=> '')); ?>
							<button type="button" class ="rstSyasin1">リセット</button>
						</dt>
						<dd class="photo">
							<div><input type="text" name="syasin1Path" id="syasin1Path" readonly><button type="button" class ="syasin1btn">画像選択</button></div>
							<div id="syasin1dd" style="font-size: 13px;color: red"  class="errors"></div>
							<div class="error-list" style="width: 100%;"><p><label>写真タイトル</label></p><input type="text" class="doublebyte" name="syasin1Title" id="syasin1Title" maxlength="60" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $gettprsyohin['tsy']['title'] ?>">
							<font color='red' style="font-size: 13px;color: red" ><label class="syasin1Title"></label></font>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="tantoubusho">担当者情報</label></dt>
						<dd>
							<div class="error-list" style="width: 680px;">
								<div style="min-height:45px;width: 100%;padding-bottom: 12px;">
									<div style="width: 40%;display: inline-block;vertical-align: top !important;">
										<div class="error-select">
											<div class="select-wrap">
												<?php echo $this->Form->input('prtantou',array(
																		'type'=>'select',
																		'options'=>$prtantou,
																		'label'=>false,
																		'empty'=> '選択してください',
																		'name' => 'prtantou',
																		'id' => 'prtantou',
																		'value' => $gettprsyohin['TPrsyohin']['tantou'])); ?>
											</div>
										</div>
									</div>
									<div class="register registerTantou" style="margin: 0;display: inline-block;">
										<?php echo $this->Form->button("この担当者情報を削除する", array('class' =>'b-release','type' => 'button','id' => 'deletetantou','style'=>'width: 250px;padding: 5px 0;'));?>
									</div>
								</div>
								<div style="width: 100%;">
									<div style="width: 14%;display: inline-block;vertical-align: top !important;margin-top: 7px;">担当部署</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('busyo', array('type' => 'text', 'label' => false,'id' => 'busyo', 'name' =>'busyo','value'=>$gettprsyohin['tpt']['busyo'],'maxlength' => '40'));?>
										<font color='red' style="font-size: 13px;"><label class="busyo"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 14%;display: inline-block;vertical-align: top !important;margin-top: 7px;">担当者名</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->input('tantounm', array('type' => 'text', 'label' => false,'id' => 'tantounm', 'name' =>'tantounm','value'=>$gettprsyohin['tpt']['tantounm'], 'class' =>'doublebyte','maxlength' => '40'));?>
										<font color='red' style="font-size: 13px;"><label class="tantounm"></label></font>
									</div>
								</div><br>
								<div style="width: 100%;">
									<div style="width: 14%;display: inline-block;vertical-align: top !important;">メッセージ</div>
									<div style="display: inline-block;">
										<?php echo $this->Form->textarea(' ', array('id'=>'tantoumsg','name'=>'tantoumsg','value'=>$gettprsyohin['tpt']['tantoumsg'],'maxlength'=>'1024','class' => 'noTrimSpace','style'=>'width:567px;resize: none;'));?>
										<font color='red' style="font-size: 13px;"><label class="tantoumsg"></label></font>
									</div>
								</div>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt><label for="Keiyakukikan">契約期間</label></dt>
						<dd>
							<?php if(!empty($this->request->data['Producteditfrm']['g_keiyaku_from'])) { ?>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('gkeiyakukikanfrom', array('type' => 'hidden','id' => 'gkeiyakukikanfrom', 'name' =>'gkeiyakukikanfrom','value' => date('Y/m', strtotime($this->request->data['Producteditfrm']['g_keiyaku_from']))));?>
								<span><?php echo date('Y/m', strtotime($this->request->data['Producteditfrm']['g_keiyaku_from'])); ?></span>
							</div>
							<div style="display: inline-block;">～</div>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('gkeiyakukikanto', array('type' => 'hidden','id' => 'gkeiyakukikanto', 'name' =>'gkeiyakukikanto','value' => date('Y/m', strtotime($this->request->data['Producteditfrm']['g_keiyaku_to']))));?>
								<span><?php echo date('Y/m', strtotime($this->request->data['Producteditfrm']['g_keiyaku_to'])); ?></span>
							</div>
							<?php } ?>
						</dd>
					</dl>
					<dl class="form-common" id="kikanfromfield">
						<dt class="required"><label for="kikanfrom">公開期間</label></dt>
						<dd>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('kikanfrom', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'kikanfrom', 'name' =>'kikanfrom','maxlength' => '10','value'=>str_replace('-', '/', $gettprsyohin['TPrsyohin']['kikanfrom'])));?>
							</div>
							<div style="display: inline-block;">～</div>
							<div style="display: inline-block;">
								<?php echo $this->Form->input('kikanto', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'kikanto', 'name' =>'kikanto','maxlength' => '10','value'=>str_replace('-', '/', $gettprsyohin['TPrsyohin']['kikanto']),'maxlength' => '10'));?>
							</div>
							<font color='red' style="font-size: 0.8rem;"><label id="date_errorft" class="date_errorft"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt class="required"><label for="hyojino">表示順</label></dt>
						<dd>
							<div class="error-list">
								<?php echo $this->Form->input('hyojino', array('class' =>'ime-ModeDisable', 'type' => 'text', 'label' => false,'id' => 'hyojino', 'name' =>'hyojino','value'=>$gettprsyohin['TPrsyohin']['hyojino'],'style'=>'width:200px;','maxlength' => '9')); ?>
								<?php echo $this->Form->input('oldhoujino', array('type' => 'hidden','id' => 'oldhoujino', 'name' =>'oldhoujino','value'=>$gettprsyohin['TPrsyohin']['hyojino'])); ?>
								
							</div>
							<font color='red' style="font-size: 13px;"><label class="hyojino"></label></font>
						</dd>
					</dl>
					<dl class="form-common">
						<dt style="padding-top: 30px;">スライド表示区分</dt>
						<dd>
							<div style="display: inline-block;width: 30%;vertical-align: middle;">
								<ul>
									<li>
										<input type="radio" name="prkbn" id="prkbn_1" value="0" <?php if ($gettprsyohin['TPrsyohin']['prkbn'] == "0") { ?> checked <?php }?>>
										<label for="prkbn_1">する</label>
									</li>
									<li>
										<input type="radio" name="prkbn" id="prkbn_2" value="1" <?php if ($gettprsyohin['TPrsyohin']['prkbn'] == "1") { ?> checked <?php }?>>
										<label for="prkbn_2">しない</label>
									</li>
								</ul>
							</div>
							<div style="display: inline-block;width: 68%;vertical-align: middle;">
								<span>※PRサイトTOPページ上部にある横方向へのイメージ表示欄に表示させるかどうかを指定します。</span>
							</div>
						</dd>
					</dl>
					<dl class="form-common">
						<dt>公開区分</dt>
						<dd>
							<ul>
								<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?>
								<li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn_r".$kokaiinfo['MKoukai']['koukaicd'];?>" 
										value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $gettprsyohin['TPrsyohin']['koukaikbn']) { ?>
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
					<div class="register"><button type="button" class ="listBack">一覧に戻る</button><button type="button" class ="b-preview">プレビュー</button><?php echo $this->Form->button("更新", array('class' =>'b-release edit','type' => 'button','name' => 'register'));?></div>
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