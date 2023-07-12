<!doctype html>
<title>倶楽部紹介情報編集：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/ClubInfo/edit.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->css('admin/member/style.css') ?>
<?= $this->Html->css('admin/clubinfo/edit.css') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'baseurl','id'=>'baseurl','value'=> $this->base)); ?>
<div id="registercls"></div>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li style="display: inline-block;"><a style="cursor:pointer;" class="menuBack">管理画面トップ</a></li><li  style="display: inline-block;">倶楽部紹介情報 編集</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="menuBack">メニューに戻る</a></div>
			<div class="message" style="text-align:center;display: none;" id="kaiincd_err">登録データが重複しています。</div>
			<div class="message" id="session_err"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">倶楽部紹介情報 編集</h1>
			<?php echo $this->Form->create('menu', ['id' => 'menuFrm', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('ClubInfoedit', ['enctype' => 'multipart/form-data','id' => 'ClubInfoedit', 'url' => ['controller' => 'AdminClubInfo', 'action' => 'search']]); ?>
			<div class="calender-search-area" style="display: inline-block;padding-bottom: 15px !important;">
				<div class="conference-search">
					<div class="select-wrap">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('kurabucd',array('type'=>'select',
															'options'=>$clubnm,
															'label'=>false,
															'style' =>'min-width:230px;width:auto',
															'value'=>$kurabucd,
															'empty'=> '倶楽会を選択してください',
															'id'=>'kurabucd',
															'name'=>'kurabucd'));?>
						</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->button("検索", array('class' =>'buttonsearch','name' =>'kaigibtn','id' => 'buttonsearch','style'=>'padding:0.38rem 1rem;'));?>
						</div>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('ClubInfoadd', ['enctype' => 'multipart/form-data','id' => 'ClubInfoadd', 'url' => ['controller' => 'AdminClubInfo', 'action' => 'register']]); ?>
			<!-- 追加の処理 -->
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'previewflg','id'=>'previewflg','value'=> '' )); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'kurabucdinsert','id'=>'kurabucdinsert','value'=> '' )); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin','id'=>'syasin','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin1','id'=>'syasin1','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin2','id'=>'syasin2','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin3','id'=>'syasin3','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin4','id'=>'syasin4','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin5','id'=>'syasin5','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin6','id'=>'syasin6','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin7','id'=>'syasin7','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin8','id'=>'syasin8','style'=> 'display:none')); ?>
			<?php echo $this->Form->input('', array('type' => 'file','name'=>'syasin9','id'=>'syasin9','style'=> 'display:none')); ?>
			<!-- 追加の処理 -->
			<!-- 編集の処理 -->
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'isyasinkey','id'=>'isyasinkey','value'=> $isyasinkey)); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'ssyasinkey','id'=>'ssyasinkey','value'=> $ssyasinkey)); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin','id'=>'urlsyasin','value'=> (isset($syasinData['syasin'])) ? $syasinData['syasin'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin1','id'=>'urlsyasin1','value'=> (isset($syasinData['syasin1'])) ? $syasinData['syasin1'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin2','id'=>'urlsyasin2','value'=> (isset($syasinData['syasin2'])) ? $syasinData['syasin2'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin3','id'=>'urlsyasin3','value'=> (isset($syasinData['syasin3'])) ? $syasinData['syasin3'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin4','id'=>'urlsyasin4','value'=> (isset($syasinData['syasin4'])) ? $syasinData['syasin4'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin5','id'=>'urlsyasin5','value'=> (isset($syasinData['syasin5'])) ? $syasinData['syasin5'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin6','id'=>'urlsyasin6','value'=> (isset($syasinData['syasin6'])) ? $syasinData['syasin6'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin7','id'=>'urlsyasin7','value'=> (isset($syasinData['syasin7'])) ? $syasinData['syasin7'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin8','id'=>'urlsyasin8','value'=> (isset($syasinData['syasin8'])) ? $syasinData['syasin8'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urlsyasin9','id'=>'urlsyasin9','value'=> (isset($syasinData['syasin9'])) ? $syasinData['syasin9'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle','id'=>'urltitle','value'=> (isset($syasinData['title'])) ? $syasinData['title'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle1','id'=>'urltitle1','value'=> (isset($syasinData['title1'])) ? $syasinData['title1'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle2','id'=>'urltitle2','value'=> (isset($syasinData['title2'])) ? $syasinData['title2'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle3','id'=>'urltitle3','value'=> (isset($syasinData['title3'])) ? $syasinData['title3'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle4','id'=>'urltitle4','value'=> (isset($syasinData['title4'])) ? $syasinData['title4'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle5','id'=>'urltitle5','value'=> (isset($syasinData['title5'])) ? $syasinData['title5'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle6','id'=>'urltitle6','value'=> (isset($syasinData['title6'])) ? $syasinData['title6'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle7','id'=>'urltitle7','value'=> (isset($syasinData['title7'])) ? $syasinData['title7'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle8','id'=>'urltitle8','value'=> (isset($syasinData['title8'])) ? $syasinData['title8'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'urltitle9','id'=>'urltitle9','value'=> (isset($syasinData['title9'])) ? $syasinData['title9'] : '')); ?>
			<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'kurabunm','id'=>'kurabunm','value'=> '')); ?>
			<div class="form-area">
				<dl class="form-common">
					<dt class="gaiyou required"><label for="gaiyou">概要</label></dt>
					<dd><div>
						<?php  echo $this->Form->textarea('gaiyou', array( 'label' => false, 'name' => 'gaiyou', 'id' => 'gaiyou','value' => (isset($club[0]['TKurabu']['gaiyou'])) ? $club[0]['TKurabu']['gaiyou'] : '','class' => 'doublebyte','escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="gaiyou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="syokumu">設立趣旨</label></dt>
					<dd><div class="">
						<?php  echo $this->Form->textarea('syokumu', array( 'label' => false, 'name' => 'syokumu', 'id' => 'syokumu','value' => (isset($club[0]['TKurabu']['syokumu'])) ? $club[0]['TKurabu']['syokumu'] : '','class' => 'doublebyte','escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="syokumu"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kanji">代表幹事</label></dt>
					<dd><div class="">
						<?php echo $this->Form->input('kanji', array('type'=>'text','name' => 'kanji','label' => false, 'id' => 'kanji','value' => (isset($club[0]['TKurabu']['kanji'])) ? $club[0]['TKurabu']['kanji'] : '','maxlength'=> '70','disabled' => $disflg)); ?>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="kmember">メンバー</label></dt>
					<dd><div class="">
						<?php  echo $this->Form->textarea('kmember', array( 'label' => false, 'name' => 'kmember', 'id' => 'kmember','value' => (isset($club[0]['TKurabu']['kmember'])) ? $club[0]['TKurabu']['kmember'] : '','class' => 'doublebyte','maxlength'=>'1024', 'escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="kmember"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="njyoken">入部条件 </label></dt>
					<dd><div class="">
						<?php  echo $this->Form->textarea('njyoken', array( 'label' => false, 'name' => 'njyoken', 'id' => 'njyoken','value' => (isset($club[0]['TKurabu']['njyoken'])) ? $club[0]['TKurabu']['njyoken'] : '','class' => 'doublebyte','maxlength'=>'512', 'escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="njyoken"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="nhouhou">入部方法</label></dt>
					<dd><div class="">
						<?php  echo $this->Form->textarea('nhouhou', array( 'label' => false, 'name' => 'nhouhou', 'id' => 'nhouhou','value' => (isset($club[0]['TKurabu']['nhouhou'])) ? $club[0]['TKurabu']['nhouhou'] : '','class' => 'doublebyte','maxlength'=>'512', 'escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="nhouhou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt><label for="bikou">備考</label></dt>
					<dd><div class="">
						<?php  echo $this->Form->textarea('bikou', array( 'label' => false, 'name' => 'bikou', 'id' => 'bikou',
						'value' => (isset($club[0]['TKurabu']['bikou'])) ? $club[0]['TKurabu']['bikou'] : '','class' => 'doublebyte', 'escape' => false,'style'=>'resize:none;','disabled' => $disflg));?>
						<font color='red'><label class="bikou"></label></font>
					</div></dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title requireds">
						<div class="thum_box">
							<label for="syasinPath">一覧写真</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin']) || $syasinData['syasin']==""){ ?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum','alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image','id'=>'image','value'=> '' )); ?>
								<?php }else{?>
								<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin']."/".$isyasinkey;?>" id="thum" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image','id'=>'image','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin']."/".$isyasinkey )); ?>
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset','id'=>'reset','value'=> '')); ?>
						<button type="button" class="rstsyasin" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasinPath" id="syasinPath" readonly><button type="button" class ="syasinbtn">画像選択</button></div>
						<div id="syasindd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasinTitle">一覧写真タイトル</label></p>
							<?php echo $this->Form->input('syasinTitle',array('type'=>'text',
														'class'=>'doublebyte',
														'label'=>false,
														'maxlength' =>'60',
														'value' => (isset($syasinData['title'])) ? $syasinData['title'] : '',
														'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														'id'=>'syasinTitle',
														'name'=>'syasinTitle',
														'disabled' => $disflg));?>
						<font color='red'><label class="syasinTitle"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin1Path">写真１</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin1']) || $syasinData['syasin1']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum01', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> '' )); ?>
								<?php }else{ ?>
								<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin1']."/".$ssyasinkey;?>" id="thum01" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image1','id'=>'image1','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin1']."/".$ssyasinkey )); ?> 
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset1','id'=>'reset1','value'=> '')); ?>
						<button type="button" class="rstsyasin1" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin1Path" id="syasin1Path" readonly><button type="button" class ="syasin1btn">画像選択</button></div>
						<div id="syasin1dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin1Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin1Title',array('type'=>'text',
														'class'=>'doublebyte',
														'label'=>false,
														'maxlength' =>'60',
														'value' => (isset($syasinData['title1'])) ? $syasinData['title1'] : '',
														'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														'id'=>'syasin1Title',
														'name'=>'syasin1Title'));?>
						<font color='red'><label class="syasin1Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin2Path">写真2</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin2']) || $syasinData['syasin2']==""){?>
									<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum02', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin2']."/".$ssyasinkey;?>" id="thum02" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image2','id'=>'image2','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin2']."/".$ssyasinkey )); ?>
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset2','id'=>'reset2','value'=> '')); ?>
						<button type="button" class="rstsyasin2" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin2Path" id="syasin2Path" readonly><button type="button" class ="syasin2btn">画像選択</button></div>
						<div id="syasin2dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin2Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin2Title',array('type'=>'text',
															'class'=>'doublebyte',
															'label'=>false,
															'maxlength' =>'60',
															'value' => (isset($syasinData['title2'])) ? $syasinData['title2'] : '',
															'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
															'id'=>'syasin2Title',
															'name'=>'syasin2Title'));?>
						<font color='red'><label class="syasin2Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin3Path">写真3</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin3']) || $syasinData['syasin3']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum03', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> '' )); ?>
								<?php }else{?>
								<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin3']."/".$ssyasinkey;?>" id="thum03" style="max-height: 53px;max-width: 73px;width: auto!important;"/><?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image3','id'=>'image3','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin3']."/".$ssyasinkey )); ?>
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset3','id'=>'reset3','value'=> '')); ?>
						<button type="button" class="rstsyasin3" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin3Path" id="syasin3Path" readonly><button type="button" class ="syasin3btn">画像選択</button></div>
						<div id="syasin3dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin3Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin3Title',array('type'=>'text',
														  'class'=>'doublebyte',
														  'label'=>false,
														  'maxlength' =>'60',
														  'value' => (isset($syasinData['title3'])) ? $syasinData['title3'] : '',
														  'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														  'id'=>'syasin3Title',
														  'name'=>'syasin3Title'));?>
						<font color='red'><label class="syasin3Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin4Path">写真4</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin4']) || $syasinData['syasin4']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum04', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image4','id'=>'image4','value'=> '' )); ?>
								<?php }else{?>
								<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin4']."/".$ssyasinkey;?>" id="thum04" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image4','id'=>'image4',
										 'value'=> $this->base."/Club/getSyasin/".$syasinData['syasin4']."/".$ssyasinkey )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset4','id'=>'reset4','value'=> '')); ?>
						<button type="button" class="rstsyasin4" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin4Path" id="syasin4Path" readonly><button type="button" class ="syasin4btn">画像選択</button></div>
						<div id="syasin4dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin4Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin4Title',array('type'=>'text',
														  'class'=>'doublebyte',
														  'label'=>false,
														  'maxlength' =>'60',
														  'value' => (isset($syasinData['title4'])) ? $syasinData['title4'] : '',
														  'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														  'id'=>'syasin4Title',
														  'name'=>'syasin4Title'));?>
						<font color='red'><label class="syasin4Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin5Path">写真5</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin5']) || $syasinData['syasin5']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum05', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image5','id'=>'image5','value'=> '' )); ?>
								<?php }else{?>
								<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin5']."/".$ssyasinkey;?>" id="thum05" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image5','id'=>'image5','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin5']."/".$ssyasinkey )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset5','id'=>'reset5','value'=> '')); ?>
						<button type="button" class="rstsyasin5" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin5Path" id="syasin5Path" readonly><button type="button" class ="syasin5btn">画像選択</button></div>
						<div id="syasin5dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin5Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin5Title',array('type'=>'text',
															'class'=>'doublebyte',
															'label'=>false,
															'maxlength' =>'60',
															'value' => (isset($syasinData['title5'])) ? $syasinData['title5'] : '',
															'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
															'id'=>'syasin5Title',
															'name'=>'syasin5Title'));?>
						<font color='red'><label class="syasin5Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin6Path">写真6</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin6']) || $syasinData['syasin6']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum06', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image6','id'=>'image6','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin6']."/".$ssyasinkey;?>" id="thum06" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image6','id'=>'image6','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin6']."/".$ssyasinkey )); ?>
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset6','id'=>'reset6','value'=> '')); ?>
						<button type="button" class="rstsyasin6" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin6Path" id="syasin6Path" readonly><button type="button" class ="syasin6btn">画像選択</button></div>
						<div id="syasin6dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin6Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin6Title',array('type'=>'text',
															'class'=>'doublebyte',
															'label'=>false,
															'maxlength' =>'60',
															'value' => (isset($syasinData['title6'])) ? $syasinData['title6'] : '',
															'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
															'id'=>'syasin6Title',
															'name'=>'syasin6Title'));?>
						<font color='red'><label class="syasin6Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin7Path">写真7</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin7']) || $syasinData['syasin7']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum07', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image7','id'=>'image7','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/AdminClubInfo/getSyasin/".$syasinData['syasin7']."/".$ssyasinkey;?>" 
										id="thum07" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image7','id'=>'image7','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin7']."/".$ssyasinkey )); ?>
								<?php } ?>
								</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset7','id'=>'reset7','value'=> '')); ?>
						<button type="button" class="rstsyasin7" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin7Path" id="syasin7Path" readonly><button type="button" class ="syasin7btn">画像選択</button></div>
						<div id="syasin7dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin7Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin7Title',array('type'=>'text',
														  'class'=>'doublebyte',
														  'label'=>false,
														  'maxlength' =>'60',
														  'value' => (isset($syasinData['title7'])) ? $syasinData['title7'] : '',
														  'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														  'id'=>'syasin7Title',
														  'name'=>'syasin7Title'));?>
						<font color='red'><label class="syasin7Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin8Path">写真8</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin8']) || $syasinData['syasin8']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum08', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image8','id'=>'image8','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/AdminCommitteInfo/getSyasin/".$syasinData['syasin8']."/".$ssyasinkey;?>" id="thum08" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image8','id'=>'image8','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin8']."/".$ssyasinkey )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset8','id'=>'reset8','value'=> '')); ?>
						<button type="button" class="rstsyasin8" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin8Path" id="syasin8Path" readonly><button type="button" class ="syasin8btn">画像選択</button></div>
						<div id="syasin8dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin8Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin8Title',array('type'=>'text',
														  'class'=>'doublebyte',
														  'label'=>false,
														  'maxlength' =>'60',
														  'value' => (isset($syasinData['title8'])) ? $syasinData['title8'] : '',
														  'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														  'id'=>'syasin8Title',
														  'name'=>'syasin8Title'));?>
						<font color='red'><label class="syasin8Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">
						<div class="thum_box">
							<label for="syasin9Path">写真9</label>
							<figure class="thum_02">
								<?php if(!isset($syasinData['syasin9']) || $syasinData['syasin9']==""){?>
								<?php echo $this->Html->image('admin/thum_02.gif', array('id'=>'thum09', 'alt' => '','style'=>'max-height: 53px;max-width: 73px;width: auto!important;'));?>
								<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image9','id'=>'image9','value'=> '' )); ?>
								<?php }else{?>
									<img src="<?php echo $this->base."/AdminCommitteInfo/getSyasin/".$syasinData['syasin9']."/".$ssyasinkey;?>" id="thum09" style="max-height: 53px;max-width: 73px;width: auto!important;"/>
									<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'image9','id'=>'image9','value'=> $this->base."/Club/getSyasin/".$syasinData['syasin9']."/".$ssyasinkey )); ?>
								<?php } ?>
							</figure>
						</div>
						<?php echo $this->Form->input('', array('type' => 'hidden','name'=>'reset9','id'=>'reset9','value'=> '')); ?>
						<button type="button" class="rstsyasin9" >リセット</button>
					</dt>
					<dd class="photo">
						<div><input type="text" name="syasin9Path" id="syasin9Path" readonly><button type="button" class ="syasin9btn">画像選択</button></div>
						<div id="syasin9dd" class="errors-message"></div>
						<div class="error-list" style="width: 100%;"><p><label for="syasin9Title">写真タイトル</label></p>
							<?php echo $this->Form->input('syasin9Title',array('type'=>'text',
														  'class'=>'doublebyte', 
														  'label'=>false,
														  'maxlength' =>'60',
														  'value' => (isset($syasinData['title9'])) ? $syasinData['title9'] : '',
														  'placeholder'=> '画像にキャプションがある場合はここに入力してください。',
														  'id'=>'syasin9Title',
														  'name'=>'syasin9Title'));?>
						<font color='red'><label class="syasin9Title"></label></font>
						</div>
					</dd>
				</dl>
				<dl class="form-common">
					<dt class="thum_title">公開区分</dt>
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
				<div class="register"><button type="button" class="menuBack">メニューに戻る</button><?php echo $this->Form->button("プレビュー",array(
							'class' =>'b-preview',
							'name' => 'Preview',
							'type' => 'button',
							'id' => 'Preview',
							'disabled' => $disflg)); ?><?php if($upflg=="false") { echo $this->Form->button("登録",array(
							'class' =>'b-release reg',
							'name' => 'newRegister',
							'type' => 'button',
							'disabled' => $disflg,
							'id' => 'newRegister')); } else { echo $this->Form->button("更新",array(
							'class' =>'b-release upd',
							'type' => 'button',
							'name' => 'newUpdate',
							'id' => 'newUpdate')); } ?>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</main>
	</div>
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>