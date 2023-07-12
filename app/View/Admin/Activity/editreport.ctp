<!doctype html>
<title>活動報告 <?php echo ( $this->request->data['adminActivityeditFrm']['divert'] == "1" ? "流用" : "編集");?>：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/activity/report.js') ?>
<?= $this->html->css('common/common.css') ?>
<style> 
input[type=text]:disabled {
    background: #dddddd !important;
}
input[id="kigendate"]:disabled {
    background: white !important;
}
.errors {
	font-size: 0.9rem;
	color: #e20000;
}
.updatecls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url( <?php echo ( $this->request->data['adminActivityeditFrm']['divert'] == "1" ? "'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+55m76Yyy5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg=='" : "'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5pu05paw5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg=='");?> );
	background-color: rgba(255, 255, 255, .5);
}
input[type=text]:disabled {
    background: #dddddd !important;
}
select:disabled,textarea:disabled {
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
</style>
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
				<li style="display: inline-block;"><a style="cursor:pointer;" id="backpage_head" class="backpage_head">管理画面トップ</a></li>
				<li style="display: inline-block;">活動報告 <?php echo ( $this->request->data['adminActivityeditFrm']['divert'] == "1" ? "流用" : "編集");?></li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" class="menuBack">一覧に戻る</a></div>
			<h1 class="main-title">活動報告 <?php echo ( $this->request->data['adminActivityeditFrm']['divert'] == "1" ? "流用" : "編集");?></h1>
			<?php echo $this->Form->create('reportedit', ['enctype' => 'multipart/form-data','id' => 'reportedit', 'url' => ['controller' => 'adminActivity', 'action' => 'reportupdate']]);
			echo $this->Form->input('hdn_soushin', array('id' => 'hdn_soushin','name' => 'hdn_soushin','type' => 'hidden', 'value' => 0));
			echo $this->Form->input('id', array('id' => 'id','name' => 'id','type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['divert'] == "1" ? "" : $katoinfo['TKatudo']['arno'] ));
			echo $this->Form->input('hdn_bunruicd', array('id' => 'hdn_bunruicd','name' => 'hdn_bunruicd','type' => 'hidden', 'value' => $katoinfo['TKatudo']['bunruicd']));
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
 			echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden','name' => 'hdn_bunruicd','value' => $katoinfo['TKatudo']['bunruicd']));
 			echo $this->Form->input('', array('type' => 'hidden','name'=>'editval','id'=>'editval','value'=> '1'));
 			echo $this->Form->input('kbunruicdhdn', array('id' => 'kbunruicdhdn','name' => 'kbunruicdhdn','type' => 'hidden','value'=>$katoinfo['TKatudo']['kbunruicd']));
 			echo $this->Form->input('khoutourokuhdn', array('type' => 'hidden','id' => 'khoutourokuhdn','value'=>$this->Session->read('Auth.User.TKengen.khoutouroku')));
 			echo $this->Form->input('khoukoukaihdn', array('type' => 'hidden','id' => 'khoukoukaihdn','value'=>$this->Session->read('Auth.User.TKengen.khoukoukai')));
 			echo $this->Form->input('sosikinm', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['sosikinm']));
 			echo $this->Form->input('kbunruinm', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kbunruinm']));
 			echo $this->Form->input('kaigiFrom', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kaigiFrom']));
 			echo $this->Form->input('kaigiTo', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kaigiTo']));
 			echo $this->Form->input('eventFrom', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['eventFrom']));
 			echo $this->Form->input('eventTo', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['eventTo']));
 			echo $this->Form->input('searchcon', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['searchcon']));
 			echo $this->Form->input('', array('type' => 'hidden','name'=>'reset1','id'=>'reset1','value'=> ''));
 			echo $this->Form->input('', array('type' => 'hidden','name'=>'reset2','id'=>'reset2','value'=> ''));
 			echo $this->Form->input('', array('type' => 'hidden','name'=>'reset3','id'=>'reset3','value'=> ''));
 			echo $this->Form->input('previewflg', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> ''));
			echo $this->Form->input('kanrikbnhdn', array('type' => 'hidden','id' => 'kanrikbnhdn','value'=>$this->Session->read('Auth.User.TKaiin.kanrikbn')));
			echo $this->Form->input('divert', array('type' => 'hidden','id' => 'divert','name' => 'divert','value'=>$this->request->data['adminActivityeditFrm']['divert'])); ?>	
			<div class="form-area">
				<dl class="form-common">
					<dt>分類</dt>
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
					<dt>組織</dt>
					<dd>
						<div class="error-select">
							<div class="select-wrap">
								<?php echo $this->Form->input('sosikinm',array('type'=>'select','options'=>$sosikinm,'label'=>false,'value'=>$katoinfo['TKatudo']['sosikicd'], 'empty'=> '選択してください','class'=>'select_type','id'=>'conference','name'=>'sosikicd'));?>
							</div>
						</div>
						<font color='red'><label class="sosikicd"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>活動分類</dt>
					<dd>
						<div class="error-select">
							<div class="select-wrap">
								<?php echo $this->Form->input('kbunruinm',array('type'=>'select','label'=>false,'empty'=> '選択してください','options'=>$kbunruinm,'value'=>$katoinfo['TKatudo']['kbunruicd'],'class'=>'select_type','name'=>'kbunruicd','id'=>'kbunruicd'));?>
							</div>
						</div>
						<font color='red'><label class="sosikicd"></label></font>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisaidatefield">日付</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('kaisaidate', array('class'=>'datepicker','type'=>'text','maxlength' => '10',
									'value'=> str_replace("-", "/", $katoinfo['TKatudo']['kaisaidate']),'name' => 'kaisaidate','label' => false, 'id' => 'kaisaidate')); ?>
							<font color='red'><label class="kaisaidate"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="field05">開始時間</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kaisaitmfrom', array('type' => 'text','id' => 'kaisaitmfrom', 'label' => false, 'value'=> mb_substr($katoinfo['TKatudo']['kaisaitmfrom'],0,5),'class' => 'timebox ime-ModeDisable','name'=>'kaisaitmfrom', 'onkeypress' => 'return checkTimeValue(event, id, "kaisaitmto");'));?>
						<font color='red'><label class="kaisaitmfrom"></label></font>
					</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kaisaitmto">終了時間</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('kaisaitmto', array('type'=>'text','name' => 'kaisaitmto','label' => false, 'id' => 'kaisaitmto', 'class' => 'timebox ime-ModeDisable', 'value'=> mb_substr($katoinfo['TKatudo']['kaisaitmto'],0,5),'onkeypress' => 'return checkTimeValue(event, id, "hyoudai");')); ?>
							<font color='red'><label class="kaisaitmto"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="hyoudai">表題</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('hyoudai', array('type'=>'text','name' => 'hyoudai','label' => false, 'id' => 'hyoudai','maxlength' => '60',
									'value'=> $katoinfo['TKatudo']['hyoudai'])); ?>
							<font color='red'><label class="hyoudai"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="meisyou">名称</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('name', array('type'=>'text','name' => 'meisyou','label' => false,'maxlength' => '60', 'id' => 'meisyou','placeholder'=>'例）○○○本社ビル文化施設の見学会',
									'value'=> $katoinfo['TKatudo']['meisyou'])); ?>
							<font color='red'><label class="meisyou"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt><label for="basyo">場所</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('basyo', array('name' => 'basyo','label' => false, 'id' => 'basyo','maxlength' => '100', 'escape' => false,'style'=>'width:668px;resize: none;', 'value'=> $katoinfo['TKatudo']['basyo'])); ?>
							<font color='red'><label class="basyo"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="naiyoufield">
					<dt><label for="naiyou">内容</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('naiyou', array('name' => 'naiyou','label' => false, 'id' => 'naiyou','style'=>'width:668px;resize: none;','maxlength' => '1024','value'=> $katoinfo['TKatudo']['naiyou'])); ?>
							<font color='red'><label class="naiyou"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="gidaifield">
					<dt><label for="gidai">議題</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('agenda', array('name' => 'gidai','label' => false, 'id' => 'gidai','maxlength' => '255', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['gidai'])); ?>
							<font color='red'><label class="gidai"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="kousifield">
					<dt><label for="kousi">講師</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('kousi', array('name' => 'kousi','label' => false, 'id' => 'kousi','maxlength' => '100', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['kousi'])); ?>
							<font color='red'><label class="kousi"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>対象区分</dt>
					<dd>
						<ul>
							<li><input type="radio" name="scategory_radio" id="members" value="0" <?php if ($katoinfo['TKatudo']['taisyoukbn'] == 0) { ?>
									checked <?php }?>><label for="members">会員のみ対象</label></li>
							<li><input type="radio" name="scategory_radio" id="non_members" value="1" <?php if ($katoinfo['TKatudo']['taisyoukbn'] == 1) { ?>
									checked <?php }?>><label for="non_members">会員と非会員共に対象</label></li>
						</ul>
					</dd>
				</dl>
				<dl class="form-common" id="taisyoufield">
					<dt><label for="taisyou">対象</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('taisyou', array('name' => 'taisyou','label' => false, 'id' => 'taisyou','placeholder'=>'例）正会員、全会員、全会員と家族、一般','maxlength' => '100', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['taisyou'])); ?>
							<font color='red'><label class="taisyou"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="teiinfield">
					<dt><label for="teiin">定員</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->input('teiin', array('type'=>'text','name' => 'teiin','maxlength'=>'5','label' => false, 'id' => 'teiin',
									'value'=> ($katoinfo['TKatudo']['teiin'] != 0 ? $katoinfo['TKatudo']['teiin'] : '' ) )); ?>
							<font color='red'><label class="teiin"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="teiincomfield">
					<dt><label for="teiincom">定員コメント</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('teiincom', array('name' => 'teiincom','label' => false, 'id' => 'teiincom','maxlength' => '60', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['teiincom'])); ?>
							<font color='red'><label class="teiincom"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="hiyoufield">
					<dt><label for="hiyou">費用</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('hiyou', array('name' => 'hiyou','label' => false, 'id' => 'hiyou','maxlength' => '100', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['hiyou'])); ?>
							<font color='red'><label class="hiyou"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="syugoubasyofield">
					<dt><label for="syugoubasyo">集合場所</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('syugoubasyo', array('name' => 'syugoubasyo','label' => false, 'id' => 'syugoubasyo','maxlength' => '255', 'escape' => false,'style'=>'width:668px;resize: none;','value'=> $katoinfo['TKatudo']['syugoubasyo'])); ?>
							<font color='red'><label class="syugoubasyo"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="kigendatefield">
					<dt><label for="field17">申込期限 日付</label></dt>
					<dd>
					<div class="error-list">
						<?php echo $this->Form->input('kigendate', array('class' =>'datepicker', 'type' => 'text', 'label' => false, 'id' => 'kigendate', 'name' =>'kigendate','value'=>str_replace("-", "/", $katoinfo['TKatudo']['kigendate']),
							'maxlength' => '10'));?>
					</div>
					</dd>
				</dl>
				<dl class="form-common" id="kigentmfield">
					<dt><label for="field18">申込期限 時間</label></dt>
					<dd><?php echo $this->Form->input('kigentmfield', array('type' => 'text', 'label' => false, 
							'id' => 'kigentm', 'name' =>'kigentm', 'class' => 'timebox ime-ModeDisable','value'=> mb_substr($katoinfo['TKatudo']['kigentm'],0,5), 'onkeypress' => 'return checkTimeValue(event, id, "bikou");'));?>
					</dd>
				</dl>
				<dl class="form-common" id="bikoufield">
					<dt><label for="bikou">備考</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('bikou', array('name' => 'bikou','label' => false, 'id' => 'bikou','style'=>'width:668px;resize:none;','maxlength' => '1024','value'=> $katoinfo['TKatudo']['bikou'])); ?>
							<font color='red'><label class="bikou"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common" id="commentfield">
					<dt><label for="comment">活動コメント</label></dt>
					<dd>
						<div class="error-list">
							<?php echo $this->Form->textarea('comment', array('name' => 'comment','label' => false, 'id' => 'comment','maxlength' => '1024','style'=>'width:668px;resize:none;','value'=> $katoinfo['TKatudo']['comment'])); ?>
							<font color='red'><label class="comment"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1Path">写真1</label>
							<figure class="thum_02">
								<?php if(empty($syasinData['syasin1'])){ ?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum01','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' )); 
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin1','id'=>'divrstsyashin1','value'=> ''));
									?>
								<?php }else{?>
									<img src="<?php echo $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin1'];?>" id="thum01" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin1'] ));
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin1','id'=>'divrstsyashin1','value'=> '1'));
									 ?>
								<?php }?>
							</figure>
						</div>
						<button type="button" class ="rstSyasin1">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1Path" id="syasin1Path" value="" readonly><button type="button" class ="syasin1btn">画像選択</button></div>
						<div id="syasin1dd" class="errors"></div>
						<div class="error-list" style="width: 100%;">
							<p><label for="field05">写真タイトル</label></p><input type="text" class="doublebyte" maxlength="60" name="syasin1Title" id="syasin1Title" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title1']?>">
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
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> '' )); 
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin2','id'=>'divrstsyashin2','value'=> ''));
									?>
								<?php }else{?>
									<img src="<?php echo $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin2'];?>" id="thum02" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin2'] )); 
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin2','id'=>'divrstsyashin2','value'=> '1'));
									?>
								<?php }?>
							</figure>
						</div>
						<button type="button" class ="rstSyasin2">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2Path" id="syasin2Path" readonly><button type="button" class ="syasin2btn">画像選択</button></div>
						<div id="syasin2dd" class="errors"></div>
						<div class="error-list" style="width: 100%;">
							<p><label for="field07">写真タイトル</label></p><input type="text" class="doublebyte" maxlength="60" name="syasin2Title" id="syasin2Title" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title2']?>">
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
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> '' )); 
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin3','id'=>'divrstsyashin3','value'=> ''));
									?>
								<?php }else{?>
									<img src="<?php echo $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin3'];?>" id="thum03" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> $this->base."/activity/getSyasin/".$syasinKey."/".$syasinData['syasin3'] )); 
									echo $this->Form->input('', array('type' => 'hidden','name'=>'divrstsyashin3','id'=>'divrstsyashin3','value'=> '1'));
									?>
								<?php } ?>
							</figure>
						</div>
						<button type="button" class ="rstSyasin3">リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3Path" id="syasin3Path" readonly><button type="button" class ="syasin3btn">画像選択</button></div>
						<div id="syasin3dd" class="errors"></div>
						<div class="error-list" style="width: 100%;">
							<p><label for="field09">写真タイトル</label></p><input type="text" class="doublebyte" maxlength="60" name="syasin3Title" id="syasin3Title" placeholder="画像にキャプションがある場合はここに入力してください。" value="<?php echo $syasinData['title3']?>">
							<font color='red'><label class="syasin3Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt>公開区分</dt>
					<dd>
						<ul>
						<?php if (($this->Session->read('Auth.User.TKengen.khoutouroku') == 1) && ($this->Session->read('Auth.User.TKengen.khoukoukai') == 0) && ($this->Session->read('Auth.User.TKaiin.kanrikbn') < $this->Constants->SYS_KANRISHA)) {?>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?><li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $inval) { ?> checked <?php }?> ><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>"> <?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						<?php } else {?>
							<?php if(!empty($kokai)): foreach($kokai as $kokaiinfo): ?><li><input type="radio" name="koukaikbn" id="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>" value="<?php echo $kokaiinfo['MKoukai']['koukaicd'];?>" <?php if ($kokaiinfo['MKoukai']['koukaicd'] == $katoinfo['TKatudo']['koukaikbn']) { ?> checked <?php }?> ><label for="<?php echo "koukaikbn-".$kokaiinfo['MKoukai']['koukaicd'];?>"> <?php echo $kokaiinfo['MKoukai']['koukainm'];?></label></li>
							<?php endforeach; else: ?>
							<?php endif; ?>
						<?php }?>
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
				<div class="register"><button type="button" class ="menuBack">一覧に戻る</button><?php echo $this->Form->button("プレビュー", 
							array('type' =>'button','class' =>'editpreview',
									'name' => 'preview','id' => 'preview'
				));
				if($this->request->data['adminActivityeditFrm']['divert'] == 1){
					echo $this->Form->button("登録",array('type' =>'button','class' =>'b-release','name' => 'register'));
				} else {
					echo $this->Form->button("更新",array('type' =>'button','class' =>'b-release','name' => 'register')); 
				}
				?></div>
			</div><!-- /.form-area -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create(null, ['id' => 'adminActivityeditFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'activityReportSearch']]);
 				echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden', 'value' => $katoinfo['TKatudo']['bunruicd']));
 				echo $this->Form->input('sosikinm', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['sosikinm']));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kbunruinm']));
				echo $this->Form->input('kaigiFrom', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kaigiFrom']));
				echo $this->Form->input('kaigiTo', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['kaigiTo']));
				echo $this->Form->input('eventFrom', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['eventFrom']));
				echo $this->Form->input('eventTo', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['eventTo']));
				echo $this->Form->input('searchcons', array('type' => 'hidden', 'value' => $this->request->data['adminActivityeditFrm']['searchcon']));
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