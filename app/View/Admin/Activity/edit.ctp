<!doctype html>
<title>活動カレンダー 編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->html->css('common/common.css') ?>
<?= $this->Html->script('admin/activity/edit.js') ?>
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
	select:disabled,textarea:disabled {
	    background: #dddddd !important;
	}
</style>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /nav ========== -->

<!-- ========== header ========== -->

<!-- ========== /header ========== -->

<!-- ========== main ========== -->
<div id="updatecls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li>
				<li style="display: inline-block;">活動カレンダー 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="backpage">一覧に戻る</a></div>
			<h1 class="main-title">活動カレンダー 編集</h1>
			<?php echo $this->Form->create('update', ['id' => 'update', 'url' => ['controller' => 'adminActivity', 'action' => 'update']]);
				echo $this->Form->input('hdn_soushin', array('id' => 'hdn_soushin','name' => 'hdn_soushin','type' => 'hidden', 'value' => 0));
				echo $this->Form->input('hdn_arno', array('id' => 'hdn_arno','name' => 'hdn_arno','type' => 'hidden', 'value' => $event_shousai['hdn_arno']));
				echo $this->Form->input('hdn_bunruicd', array('id' => 'hdn_bunruicd','name' => 'hdn_bunruicd','type' => 'hidden', 'value' => $event_shousai['hdn_bunruicd'])); 
				echo $this->Form->input('hdn_sosikicd', array('name' => 'hdn_sosikicd','type' => 'hidden', 'value' => $event_shousai['hdn_sosikicd']));
				echo $this->Form->input('hdn_kbunruicd', array('name' => 'hdn_kbunruicd','type' => 'hidden', 'value' => $event_shousai['hdn_kbunruicd']));
				echo $this->Form->input('hdn_kaisaidate', array('name' => 'hdn_kaisaidate','type' => 'hidden', 'value' => $event_shousai['hdn_kaisaidate']));
				echo $this->Form->input('hdn_kaisaitmfrom', array('name' => 'hdn_kaisaitmfrom','type' => 'hidden', 'value' => $event_shousai['hdn_kaisaitmfrom']));
				echo $this->Form->input('hdn_kaisaitmto', array('name' => 'hdn_kaisaitmto','type' => 'hidden', 'value' => $event_shousai['hdn_kaisaitmto']));
				echo $this->Form->input('previewflg', array('name' => 'previewflg','id' => 'previewflg','type' => 'hidden'));
				echo $this->Form->input('kcaltourokuhdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcaltouroku')));
				echo $this->Form->input('kcalkoukaihdn', array('type' => 'hidden','value'=>$this->Session->read('Auth.User.TKengen.kcalkoukai')));
				echo $this->Form->input('koukaikbnhdn', array('id' => 'koukaikbnhdn','name' => 'koukaikbnhdn','type' => 'hidden','value'=>$event_shousai['koukaikbn']));
				echo $this->Form->input('bunruicdhdn', array('id' => 'bunruicdhdn','name' => 'bunruicdhdn','type' => 'hidden','value'=>$event_shousai['bunruicd']));
				echo $this->Form->input('taisyoukbnhdn', array('id' => 'taisyoukbnhdn','name' => 'taisyoukbnhdn','type' => 'hidden','value'=>$event_shousai['taisyoukbn']));
				echo $this->Form->input('kbunruicdhdn', array('id' => 'kbunruicdhdn','name' => 'kbunruicdhdn','type' => 'hidden','value'=>$event_shousai['kbunruicd']));
				echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn')));
			?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="required">分類</dt>
					<dd>
						<ul>
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
						<div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('sosikicd',array('type'=>'select','options'=>$sosikinm, 
									'label'=>false,
									'value'=>$event_shousai['sosikicd'],
									'class'=>'select_type','id'=>'sosikicd',
									'empty'=> '選択してください',
									'name' => 'sosikicd'
							));?>
						</div>
						</div>
						<font color='red'><label class="sosikicd"><?php if (isset($ValidateAjay['sosikicd']['0'])) { echo $ValidateAjay['sosikicd']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required">活動分類</dt>
					<dd>
						<div class="error-select">
						<div class="select-wrap">
							<?php echo $this->Form->input('kbunruicd',array('type'=>'select','options'=>$kbunruinm,'label'=>false,
								'value'=>$event_shousai['kbunruicd'],
								'empty'=> '選択してください','class'=>'select_type', 'name' => 'kbunruicd',
								'id'=>'kbunruicd'));?>
						</div>
						</div>
						<font color='red'><label class="kbunruicd"><?php if (isset($ValidateAjay['kbunruicd']['0'])) { echo $ValidateAjay['kbunruicd']['0']; }?></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field04">日付</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kaisaidate', array('class'=>'datepicker', 'label' => false, 'id' => 'kaisaidate', 'name' => 'kaisaidate','type'=>'text', 'maxlength' => '10', 'value' => str_replace("-", "/", $event_shousai['kaisaidate']))); ?>
						<font color='red'><label class="kaisaidate"><?php if (isset($ValidateAjay['kaisaidate']['0'])) { echo $ValidateAjay['kaisaidate']['0']; }?></label></font>	
					</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field05">開始時間</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('kaisaitmfrom', array('type' => 'text', 'label' => false, 'id' => 'kaisaitmfrom','name' => 'kaisaitmfrom', 'class' => 'ime-ModeDisable timebox','value' => mb_substr($event_shousai['kaisaitmfrom'],0,5),'onkeypress' => 'return checkTimeValue(event, id, "kaisaitmto");'));?>
						<font color='red'><label class="kaisaitmfrom"><?php if (isset($ValidateAjay['kaisaitmfrom']['0'])) { echo $ValidateAjay['kaisaitmfrom']['0']; }?></label></font>	
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field06">終了時間</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('kaisaitmto', array('type' => 'text', 'label' => false, 'id' => 'kaisaitmto','name' => 'kaisaitmto', 'class' => 'ime-ModeDisable timebox','value' => mb_substr($event_shousai['kaisaitmto'],0,5), 'onkeypress' => 'return checkTimeValue(event, id, "hyoudai");'));?>
					<font color='red'><label class="kaisaitmto"><?php if (isset($ValidateAjay['kaisaitmto']['0'])) { echo $ValidateAjay['kaisaitmto']['0']; }?></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field07">表題</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('hyoudai', array('type' => 'text','maxlength' => '60', 'label' => false, 'id' => 'hyoudai','name' => 'hyoudai', 'value' => $event_shousai['hyoudai']));?>
						<font color='red'><label class="hyoudai"><?php if (isset($ValidateAjay['hyoudai']['0'])) { echo $ValidateAjay['hyoudai']['0']; }?></label></font>	
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="required"><label for="field08">名称</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('meisyou', array('type' => 'text','maxlength' => '60', 'label' => false, 'id' => 'meisyou','name' => 'meisyou', 'value' => $event_shousai['meisyou']));?>
					<font color='red'><label class="meisyou"><?php if (isset($ValidateAjay['meisyou']['0'])) { echo $ValidateAjay['meisyou']['0']; }?></label></font>	
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field09">場所</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('basyo', array('maxlength' => '100', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'basyo','name' => 'basyo', 'value' => $event_shousai['basyo']));?>
						<font color='red'><label class="basyo"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="naiyoufield">
					<dt><label for="field10">内容</label></dt>
					<dd><div class="error-list"><?php  echo $this->Form->textarea('naiyou', array(
							'label' => false, 'id' => 'naiyou','maxlength' => '1024','name' => 'naiyou', 'escape' => false,'style'=>'width:668px;resize: none;','value' => $event_shousai['naiyou']));?>
						<font color='red'><label class="naiyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="gidaifield">
					<dt><label for="field11">議題</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('gidai', array('maxlength' => '255', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'gidai','name' => 'gidai', 'value' => $event_shousai['gidai']));?>
						<font color='red'><label class="gidai"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="kousifield">
					<dt><label for="field12">講師</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('kousi', array('maxlength' => '100', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'kousi','name' => 'kousi', 'value' => $event_shousai['kousi']));?>
						<font color='red'><label class="kousi"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>対象区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="taishoukbn" id="taishoukbn1" value="0" <?php if ($event_shousai['taisyoukbn'] == 0):?>checked<?php endif;?>><label for="taishoukbn1">会員のみ対象</label></li>
							<li><input type="radio" name="taishoukbn" id="taishoukbn2" value="1" <?php if ($event_shousai['taisyoukbn'] == 1):?>checked<?php endif;?>><label for="taishoukbn2">会員と非会員共に対象</label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common" id="taisyoufield">
					<dt><label for="field13">対象</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('taisyou', array( 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 
							'id' => 'taisyou','maxlength' => '100', 'name' => 'taisyou', 'value' => $event_shousai['taisyou']));?>
						<font color='red'><label class="taisyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="teiinfield">
					<dt><label for="field14">定員</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->input('teiin', array('type' => 'text', 'label' => false,'maxlength'=>'5', 'id' => 'teiin','name' => 'teiin','class' => 'ime-ModeDisable timebox', 'value' => ($event_shousai['teiin'] != 0 ? $event_shousai['teiin'] : '' ) )); ?>
						<font color='red'><label class="teiin"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="teiincommentfield">
					<dt><label for="field14">定員コメント</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('teiincom', array('label' => false,'maxlength'=>'60', 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'teiincom','name' => 'teiincom','name' =>'teiincom', 'value' => $event_shousai['teiincom']));?>
						<font color='red'><label class="teiincom"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="hiyoufield">
					<dt><label for="field15">費用</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('hiyou', array('maxlength'=>'100', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'hiyou','name' => 'hiyou', 'value' => $event_shousai['hiyou']));?>
						<font color='red'><label class="hiyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="syugoubasyofield">
					<dt><label for="field16">集合場所</label></dt>
					<dd><div class="error-list"><?php echo $this->Form->textarea('syugoubasyo', array('maxlength'=>'255', 'label' => false, 'escape' => false,'style'=>'width:668px;resize: none;', 'id' => 'syugoubasyo', 'name' => 'syugoubasyo', 'value' => $event_shousai['syugoubasyo']));?>
						<font color='red'><label class="syugoubasyo"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common" id="kigendatefield">
					<dt><label for="field17">申込期限 日付</label></dt>
					<dd><?php echo $this->Form->input('kigendate', array('class' =>'datepicker', 'type' => 'text', 'label' => false,'id' => 'kigendate', 'name' => 'kigendate', 'maxlength' => '10', 'value' =>str_replace("-", "/", $event_shousai['kigendate'])));?>
					<label><font color='red'><?php if (isset($ValidateAjay['kigendate']['0'])) { echo $ValidateAjay['kigendate']['0']; }?></font></label>	
					</dd>
				</dl>
				<dl class="form-common" id="kigentmfield">
					<dt><label for="field18">申込期限 時間</label></dt>
					<dd><?php echo $this->Form->input('kigentm', array('type' => 'text', 'label' => false, 'id' => 'kigentm','name' => 'kigentm', 'class' => 'ime-ModeDisable timebox', 'value' => mb_substr($event_shousai['kigentm'],0,5),'onkeypress' => 'return checkTimeValue(event, id, "bikou");'));?>
					<label><font color='red'><?php if (isset($ValidateAjay['kigentm']['0'])) { echo $ValidateAjay['kigentm']['0']; }?></font></label>
					</dd>
				</dl>
				<dl class="form-common" id="bikoufield">
					<dt><label for="field26">備考</label></dt>
					<dd><div class="error-list"><?php  echo $this->Form->textarea('bikou', array(
								'label' => false,'maxlength'=>'1024',  'id' => 'bikou', 'name' => 'bikou', 'escape' => false,'style'=>'width:668px;resize: none;', 'value' => $event_shousai['bikou']));?>
						<font color='red'><label class="bikou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<ul>
						<?php if (($this->Session->read('Auth.User.TKengen.kcaltouroku') == 1) && ($this->Session->read('Auth.User.TKengen.kcalkoukai') == 0) && ($this->Session->read('Auth.User.TKaiin.kanrikbn') < $this->Constants->SYS_KANRISHA)) { ?>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?><li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $inval) { ?> checked <?php }?> ><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>"> <?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						<?php } else { ?>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?><li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $event_shousai['koukaikbn']) { ?> checked <?php }?> ><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>"> <?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						<?php } ?>
						</ul>
					</dd>
				</dl>

				<dl class="form-common">
					<dt>通知メール</dt>
					<dd>
						<label for="mailcheck"><input type="checkbox" name="mailcheck" id="mailcheck">事務局へ確認・通知メール送信</label>
						<p>※ 事務局へ内容確認や通知をする場合にチェックしてください</p>
					</dd>
				</dl>
				<div class="register"　style="border: 1px solid red;"><button type="button" class="backpage" >一覧に戻る</button><button type="button" class="b-preview" id="preview">プレビュー</button><?php echo $this->Form->button("更新", array('class' =>'b-release','type' => 'button','name' => 'update'));?></div>
			</div><!-- /.form-area -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('katsudoModoruFrm', ['id' => 'katsudoModoruFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'search']]);
				echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden', 'value' => $event_shousai['hdn_bunruicd']));
				echo $this->Form->input('hdn_sosikicd', array('type' => 'hidden', 'value' => $event_shousai['hdn_sosikicd']));
				echo $this->Form->input('hdn_kbunruicd', array('type' => 'hidden', 'value' => $event_shousai['hdn_kbunruicd']));
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