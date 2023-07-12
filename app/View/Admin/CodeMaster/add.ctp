<!doctype html>
<title>コードマスタ 新規追加：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/codemaster/index.js') ?>
<?= $this->html->css('common/common.css') ?>
<script>
	$(function() {
		$(".datepicker").datepicker();
		var r = 1;
		$('#ulradio input[type=radio]').each(function(){
			if(r == 1) {
				var radio_id = $(this).attr('id');
				$("#"+radio_id).prop('checked', true);
				r = 2;
			}
		});
	});
</script>
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
</style>
<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li  style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="returnList">管理画面トップ</a></li>
				<li  style="display: inline-block;">コードマスタ 新規追加</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="backpage">一覧に戻る</a></div>
			<div class="message" style="text-align:center;display: none;" id="checkcode_err">登録データが重複しています。</div>
			<h1 class="main-title">コードマスタ 新規追加</h1>
			<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('register', ['id' => 'register', 'url' => ['controller' => 'AdminMaster', 'action' => 'register']]); 
				echo $this->Form->input('mstcode', array('id' => 'mstcode','name' => 'mstcode','type' => 'hidden','value'=>$selectedmstcode));
				echo $this->Form->input('classOrder', array('id' => 'classOrder','name' => 'classOrder','type' => 'hidden','value'=>$selectedOrder)); ?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required"><label for="codefield">コード</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('code', array('id'=>'code','label'=>false,'type'=>'text','name'=>'code','style'=>'width:200px;','class' => 'ime-ModeDisable')); ?>
						</div>
						<font color='red'><label class="code"></label></font>
					</dd>
				</dl>
				<?php if ($selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) { ?>
				<dl class="form-common">
					<dt class="required"><label for="kaigi">分類</label></dt>
					<dd>
						<ul id="ulradio">
							<li>
								<?php echo $this->Form->radio('radio', $bunruilist, array(
									'name' => 'bunruicd',
									'id' => 'bunruicd',
									'legend' => false,
									'separator'=>'</li><li>'
								)); ?>
							</li>
						</ul>
					</dd>
				</dl>
				<?php } ?>
				<dl class="form-common">
					<dt class="required"><label for="meisho">名称</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('meisho', array('type' => 'text','id' => 'meisho', 'label' => false,'name'=>'meisho', 'class' => 'doublebyte'));?>
						</div>
						<font color='red'><label class="meisho"></label></font>
					</dd>
				</dl>
				<?php if ($selectedmstcode == $this->fetch('M_SOSIKI_VAL') || $selectedmstcode == $this->fetch('M_IINKAI_VAL') || $selectedmstcode == $this->fetch('M_KURABU_VAL') || $selectedmstcode == $this->fetch('M_KEIYAKU_VAL')) { ?>
				<dl class="form-common">
					<dt class="required"><label for="ryakusho">略称</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('ryakusho', array('type' => 'text','id' => 'ryakusho', 'label' => false, 'class' => 'doublebyte','name'=>'ryakusho','maxlength'=>'20'));?>
						</div>
						<font color='red'><label class="ryakusho"></label></font>
					</dd>
				</dl>
				<?php } ?>
				<?php if ($selectedmstcode == $this->fetch('M_KURABU_VAL') ) { ?>
				<dl class="form-common">
					<dt class="required"><label for="ryakusho">代表メールアドレス</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('mailaddr', array('type' => 'text','id' => 'mailaddr','class'=>'underscoresingle', 'name' => 'mailaddr', 'maxlength'=>'100', 'label' => false));?>
						</div>
						<font color='red'><label class="mail"></label></font>
					</dd>
				</dl>
				<?php } ?>
				<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL')) { ?>
				<dl class="form-common">
					<dt class="required"><label for="kmnm1">項目名称１</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('kmnm1', array('type' => 'text','id' => 'kmnm1', 'label' => false, 'class' => 'doublebyte','name'=>'kmnm1','maxlength'=>'20'));?>
						</div>
						<font color='red'><label class="kmnm1"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kmnm2">項目名称２</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('kmnm2', array('type' => 'text','id' => 'kmnm2', 'label' => false, 'class' => 'doublebyte','name'=>'kmnm2','maxlength'=>'20'));?>
						</div>
						<font color='red'><label class="kmnm2"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kmnm3">項目名称３</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('kmnm3', array('type' => 'text','id' => 'kmnm3', 'label' => false, 'class' => 'doublebyte','name'=>'kmnm3','maxlength'=>'20'));?>
						</div>
						<font color='red'><label class="kmnm3"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="kmnm4">項目名称４</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('kmnm4', array('type' => 'text','id' => 'kmnm4', 'label' => false, 'class' => 'doublebyte','name'=>'kmnm4','maxlength'=>'20'));?>
						</div>
						<font color='red'><label class="kmnm4"></label></font>
					</dd>
				</dl>
				<?php } ?>
				<dl class="form-common">
					<dt class="required"><label for="fromdt">適用期間</label></dt>
					<dd>
					<div class="errors">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('fromdt', array('type' => 'text','id' => 'fromdt','class'=>'datepicker','name'=>'fromdt', 'label' => false,'maxlength' => '10'));?>
						</div>
						<div style="display: inline-block;">～</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->input('todt', array('type' => 'text','id' => 'todt','class'=>'datepicker','name'=>'todt', 'label' => false,'maxlength' => '10'));?>
						</div>
						<font color='red' style="font-size: 0.9rem;"><label id="date_errorft" class="date_errorft"></label></font>
						<font color='red' style="font-size: 0.9rem;"><label class="errorft"></label></font>
					</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="hyojino">表示順</label></dt>
					<dd>
						<div class="errors">
							<?php echo $this->Form->input('hyojino', array('type' => 'text','id' => 'hyojino','name'=>'hyojino', 'class' => 'ime-ModeDisable','style'=>'width:200px;', 'label' => false,'maxlength'=>'3'));?>
						</div>
						<font color='red'><label class="hyojino"></label></font>
					</dd>
				</dl>
				<div class="register" style="max-width: 360px;"><button type="button" class="b-back backpage" >一覧に戻る</button><?php echo $this->Form->button("登録",array('class' =>'b-release','type' => 'button','name' => 'register')); ?>
				</div>
			</div><!-- /.form-area -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('ModoruFrm', ['id' => 'ModoruFrm', 'url' => ['controller' => 'AdminMaster', 'action' => 'search']]);
				echo $this->Form->input('selectedmstcode', array('type' => 'hidden','value'=>$selectedmstcode));
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
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