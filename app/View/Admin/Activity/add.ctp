<!doctype html>
<title>活動カレンダー <?php echo (isset($event_shousai['hdn_arno']) ? "流用" : "新規追加");?>：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/activity/index.js') ?>
<?= $this->html->css('common/common.css') ?>
<script>
	$(function() {
		$(".datepicker").datepicker();
		$(".b-back").click(function () {
			$( "#add" ).submit();
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
<!-- ========== main ========== -->
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li  style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li>
				<li  style="display: inline-block;">活動カレンダー <?php echo (isset($event_shousai['hdn_arno']) ? "流用" : "新規追加");?></li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="backpage">一覧に戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">活動カレンダー <?php echo (isset($event_shousai['hdn_arno']) ? "流用" : "新規追加");?></h1>
			<?php echo $this->Form->create('register', ['id' => 'register', 'url' => ['controller' => 'adminActivity', 'action' => 'register']]);
				echo $this->Form->input('hdn_soushin', array('id' => 'hdn_soushin','name' => 'hdn_soushin','type' => 'hidden', 'value' => 0));
				echo $this->Form->input('kcaltourokuhdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcaltouroku')));
				echo $this->Form->input('kcalkoukaihdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcalkoukai')));
				echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn')));
				echo $this->Form->input('previewflg', array('name' => 'previewflg','id' => 'previewflg','type' => 'hidden')); 
				echo $this->Form->input('hdn_arno', array('id' => 'hdn_arno','name' => 'hdn_arno','type' => 'hidden', 'value' => (isset($event_shousai['hdn_arno']) ? $event_shousai['hdn_arno'] : "")));
				echo $this->Form->input('hiddenradio_previous', array('id' => 'hiddenradio_previous','name' => 'hiddenradio_previous','type' => 'hidden'));
				echo $this->Form->input('hdn_bunruicd', array('id' => 'hdn_bunruicd','name' => 'hdn_bunruicd','type' => 'hidden', 'value' => (isset($event_shousai['hdn_arno']) ? $event_shousai['hdn_arno'] : ""))); 
				echo $this->Form->input('hdn_sosikicd', array('name' => 'hdn_sosikicd','type' => 'hidden', 'value' => (isset($event_shousai['hdn_sosikicd']) ? $event_shousai['hdn_sosikicd'] : "")));
				echo $this->Form->input('hdn_kbunruicd', array('name' => 'hdn_kbunruicd','type' => 'hidden', 'value' => (isset($event_shousai['hdn_kbunruicd']) ? $event_shousai['hdn_kbunruicd'] : "")));
				echo $this->Form->input('hdn_kaisaidate', array('name' => 'hdn_kaisaidate','type' => 'hidden', 'value' => (isset($event_shousai['hdn_kaisaidate']) ? $event_shousai['hdn_kaisaidate'] : "")));
				echo $this->Form->input('hdn_kaisaitmfrom', array('name' => 'hdn_kaisaitmfrom','type' => 'hidden', 'value' => (isset($event_shousai['hdn_kaisaitmfrom']) ? $event_shousai['hdn_kaisaitmfrom'] : "")));
				echo $this->Form->input('hdn_kaisaitmto', array('name' => 'hdn_kaisaitmto','type' => 'hidden', 'value' => (isset($event_shousai['hdn_kaisaitmto']) ? $event_shousai['hdn_kaisaitmto'] : "")));
				echo $this->Form->input('kcaltourokuhdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcaltouroku')));
				echo $this->Form->input('kcalkoukaihdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcalkoukai')));
				echo $this->Form->input('koukaikbnhdn', array('id' => 'koukaikbnhdn','name' => 'koukaikbnhdn','type' => 'hidden','value'=>(isset($event_shousai['koukaikbn']) ? $event_shousai['koukaikbn'] : "")));
				echo $this->Form->input('bunruicdhdn', array('id' => 'bunruicdhdn','name' => 'bunruicdhdn','type' => 'hidden','value'=>(isset($event_shousai['bunruicd']) ? $event_shousai['bunruicd'] : "")));
				echo $this->Form->input('taisyoukbnhdn', array('id' => 'taisyoukbnhdn','name' => 'taisyoukbnhdn','type' => 'hidden','value'=>(isset($event_shousai['taisyoukbn']) ? $event_shousai['taisyoukbn'] : "")));
				echo $this->Form->input('kbunruicdhdn', array('id' => 'kbunruicdhdn','name' => 'kbunruicdhdn','type' => 'hidden','value'=>(isset($event_shousai['kbunruicd']) ? $event_shousai['kbunruicd'] : "")));
				echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn')));
				?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required">分類</dt>
					<dd>
						<ul id="ulradio">
							<li>
								<?php echo $this->Form->radio('radio', $bunruilist, array(
									'name' => 'bunruicd',
									'id' => 'bunruicd',
									'legend' => false,
									'separator'=>'</li><li>',
									'value' => $bunruicd
								)); ?>
							</li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required">組織</dt>
					<dd>
					<div class="error-list">
						<div class="select-wrap">
								<?php echo $this->Form->input('sosikicd',array('type'=>'select','options'=>$sosikinm, 
									'label'=>false,
									'value'=>(isset($event_shousai['sosikicd']) ? $event_shousai['sosikicd'] : ""),
									'empty'=> '選択してください','class'=>'select_type','id'=>'sosikicd','name'=>'sosikicd'));?>
						</div>
					</div>
					<font color='red'><label class="sosikicd"><?php if (isset($ValidateAjay['sosikicd']['0'])) { echo $ValidateAjay['sosikicd']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required">活動分類</dt>
					<dd>
					<div class="error-list">
						<div class="select-wrap">
							<?php echo $this->Form->input('kbunruicd',array('type'=>'select','options'=>$kbunruinm,'label'=>false,
								'value'=>(isset($event_shousai['kbunruicd']) ? $event_shousai['kbunruicd'] : ""),
								'empty'=> '選択してください','class'=>'select_type',
								'id'=>'kbunruicd','name'=>'kbunruicd'));?>
						</div>
					</div>
					<font color='red'><label class="kbunruicd"><?php if (isset($ValidateAjay['kbunruicd']['0'])) { echo $ValidateAjay['kbunruicd']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field04">日付</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kaisaidate', array('class'=>'datepicker','id'=>'kaisaidate','label'=>false,'type'=>'text','name'=>'kaisaidate','maxlength' => '10','value' => (isset($event_shousai['kaisaidate']) ? str_replace("-", "/",$event_shousai['kaisaidate']) : ""))); ?>
					</div>
					<font color='red'><label class="kaisaidate"><?php if (isset($ValidateAjay['kaisaidate']['0'])) { echo $ValidateAjay['kaisaidate']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field05">開始時間</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('kaisaitmfrom', array('type' => 'text','id' => 'kaisaitmfrom', 'label' => false, 'class' => 'ime-ModeDisable timebox','name'=>'kaisaitmfrom', 'value' => (isset($event_shousai['kaisaitmfrom']) ? mb_substr($event_shousai['kaisaitmfrom'],0,5) : ""), 'onkeypress' => 'return checkTimeValue(event, id, "kaisaitmto");'));?>
						</div>
						<font color='red'><label class="kaisaitmfrom"><?php if (isset($ValidateAjay['kaisaitmfrom']['0'])) { echo $ValidateAjay['kaisaitmfrom']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field06">終了時間</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kaisaitmto', array('type' => 'text','id' => 'kaisaitmto', 'label' => false, 
								'class' => 'timebox ime-ModeDisable','name'=>'kaisaitmto', 'value' => (isset($event_shousai['kaisaitmto']) ? mb_substr($event_shousai['kaisaitmto'],0,5) : ""), 'onkeypress' => 'return checkTimeValue(event, id, "hyoudai");'));?>
					</div>
					<font color='red'><label class="kaisaitmto"><?php if (isset($ValidateAjay['kaisaitmto']['0'])) { echo $ValidateAjay['kaisaitmto']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field07">表題</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('hyoudai', array('type' => 'text','maxlength' => '60','id' => 'hyoudai','name'=>'hyoudai', 'label' => false, 'value'=>(isset($event_shousai['hyoudai']) ? $event_shousai['hyoudai'] : "")));?>
					</div>
					<font color='red'><label class="hyoudai"><?php if (isset($ValidateAjay['hyoudai']['0'])) { echo $ValidateAjay['hyoudai']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field08">名称</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('meisyou', array('type' => 'text','maxlength' => '60','id' => 'meisyou','name'=>'meisyou', 'label' => false, 'value'=>(isset($event_shousai['meisyou']) ? $event_shousai['meisyou'] : "")));?>
					</div>
					<font color='red'><label class="meisyou"><?php if (isset($ValidateAjay['meisyou']['0'])) { echo $ValidateAjay['meisyou']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field09">場所</label></dt>
					<dd><div class="error-list">
					<?php echo $this->Form->textarea('basyo', array('id' => 'basyo','maxlength' => '100', 'name'=>'basyo', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['basyo']) ? $event_shousai['basyo'] : "")));?>
					<font color='red'><label class="basyo"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="naiyoufield">
					<dt><label for="field10">内容</label></dt>
					<dd><div class="error-list"><?php  echo $this->Form->textarea('naiyou', array(
								'label' => false, 
							'id' => 'naiyou','maxlength' => '1024','name' => 'naiyou', 'escape' => false,'style'=>'width:668px;resize: none;',
							'value'=>(isset($event_shousai['naiyou']) ? $event_shousai['naiyou'] : "")));?>
						<font color='red'><label class="naiyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="gidaifield">
					<dt><label for="field11">議題</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('gidai', array('maxlength' => '255','id' => 'gidai','name' =>'gidai', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['gidai']) ? $event_shousai['gidai'] : "")));?>
						<font color='red'><label class="gidai"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="kousifield">
					<dt><label for="field12">講師</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('kousi', array('maxlength' => '100','id' => 'kousi','name' =>'kousi', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['kousi']) ? $event_shousai['kousi'] : "")));?>
						<font color='red'><label class="kousi"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>対象区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="taishoukbn" id="taishoukbn1" value="0"><label for="taishoukbn1">会員のみ対象</label></li>
							<li><input type="radio" name="taishoukbn" id="taishoukbn2" value="1"><label for="taishoukbn2">会員と非会員共に対象</label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common" id="taisyoufield">
					<dt><label for="field13">対象</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('taisyou', array('maxlength' => '100','id' => 'taisyou','name' =>'taisyou', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['taisyou']) ? $event_shousai['taisyou'] : "")));?>
						<font color='red'><label class="taisyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="teiinfield">
					<dt><label for="field14">定員</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('teiin', array('type' => 'text','id' => 'teiin','name' =>'teiin','class' => 'timebox ime-ModeDisable', 'label' => false,'maxlength'=>'5','value'=>(isset($event_shousai['teiin']) ? $event_shousai['teiin'] : "")));?>
						<font color='red'><label class="teiin"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="teiincommentfield">
					<dt><label for="field14">定員コメント</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('teiincom', array('id' => 'teiincom','name' =>'teiincom', 'label' => false,'maxlength'=>'60', 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['teiincom']) ? $event_shousai['teiincom'] : "")));?>
						<font color='red'><label class="teiincom"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="hiyoufield">
					<dt><label for="field15">費用</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('hiyou', array('maxlength'=>'100','name' =>'hiyou', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','id' => 'hiyou','value'=>(isset($event_shousai['hiyou']) ? $event_shousai['hiyou'] : "")));?>
						<font color='red'><label class="hiyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="syugoubasyofield">
					<dt><label for="field16">集合場所</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('syugoubasyo', array('maxlength'=>'255','name' =>'syugoubasyo', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;','id' => 'syugoubasyo','value'=>(isset($event_shousai['syugoubasyo']) ? $event_shousai['syugoubasyo'] : "")));?>
						<font color='red'><label class="syugoubasyo"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="kigendatefield">
					<dt><label for="field17">申込期限 日付</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kigendate', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'kigendate', 'name' =>'kigendate','maxlength' => '10','value'=>(isset($event_shousai['kigendate']) ? str_replace("-", "/", $event_shousai['kigendate']) : "")));?>
					</div>
					<label><font color='red'><?php if (isset($ValidateAjay['kigendate']['0'])) { echo $ValidateAjay['kigendate']['0']; }?></font></label>
					</dd>
				</dl>
				<dl class="form-common" id="kigentmfield">
					<dt><label for="field18">申込期限 時間</label></dt>
					<dd><?php echo $this->Form->input('kigentm', array('type' => 'text', 'label' => false, 'id' => 'kigentm', 'name' =>'kigentm', 'class' => 'timebox ime-ModeDisable', 'onkeypress' => 'return checkTimeValue(event, id, "bikou");','value'=>(isset($event_shousai['kigentm']) ? mb_substr($event_shousai['kigentm'],0,5) : "")));?>
					<label><font color='red'><?php if (isset($ValidateAjay['kigentm']['0'])) { echo $ValidateAjay['kigentm']['0']; }?></font></label>
					</dd>
				</dl>
				<dl class="form-common" id="bikoufield">
					<dt><label for="field26">備考</label></dt>
					<dd><div class="error-list"><?php  echo $this->Form->textarea('bikou', array( 
								'label' => false,'maxlength'=>'1024', 'id' => 'bikou','name' => 'bikou', 'escape' => false,'style'=>'width:668px;resize: none;','value'=>(isset($event_shousai['bikou']) ? $event_shousai['bikou'] : "")));?>
						<font color='red'><label class="bikou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<div style="display: inline-block;float:left;">
							<ul>
								<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?><li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $inval) { ?> checked <?php }?> ><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>"> <?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
								<?php endforeach; else: ?>
								<?php endif; ?>
							</ul>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>通知メール</dt>
					<dd>
						<label for="mailcheck"><input type="checkbox" name="mailcheck" id="mailcheck">事務局へ確認・通知メール送信</label>
						<p>※ 事務局へ内容確認や通知をする場合にチェックしてください</p>
					</dd>
				</dl>
				<div class="register"><button type="button" class="b-back backpage" >一覧に戻る</button><button type="button" class="b-preview" id="preview">プレビュー</button><?php echo $this->Form->button("登録",array('class' =>'b-release registersubmit','type' => 'button','name' => 'register'));?>
				</div>
			</div><!-- /.form-area -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('katsudoModoruFrm', ['id' => 'katsudoModoruFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]);
				echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden', 'value' => (isset($event_shousai['hdn_bunruicd']) ? $event_shousai['hdn_bunruicd'] : "")));
				echo $this->Form->input('hdn_sosikicd', array('type' => 'hidden', 'value' => (isset($event_shousai['hdn_sosikicd']) ? $event_shousai['hdn_sosikicd'] : "")));
				echo $this->Form->input('hdn_kbunruicd', array('type' => 'hidden', 'value' => (isset($event_shousai['hdn_kbunruicd']) ? $event_shousai['hdn_kbunruicd'] : "")));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('stayaddFrm', ['id' => 'stayaddFrm', 'url' => ['controller' => 'AdminActivity', 'action' => 'add']]);
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