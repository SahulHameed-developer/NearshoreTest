<!doctype html>
<title>ダウンロードファイル一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>

<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('admin/download/index.js') ?>
<?= $this->Html->css('admin/download/style.css') ?>
<?= $this->Html->css('admin/download/main.css') ?>
<?= $this->Html->css('admin/download/normalize.css') ?>
<!-- ========== nav ========== -->
<style type="text/css">
  @media screen and (min-width: 769px) {
	.flex450 {
		flex: 0 0 400px !important;
	  	border-bottom: 0px !important;
	  	margin-bottom: 0px !important;
	}
  }
  .flex450 {
  	margin-bottom: 10px;
  	border-bottom: 1px dotted #c0c0c0;
    flex: 0 0 105px;
  }
  @media screen and (min-width: 769px) {
	.flex50 {
		flex: 0 0 300px !important;
	}
  }
  /*Chrome*/
  .marginleft {
    margin-left: 42px;
  }
  /*@-moz-document url-prefix() { //Mozilla
  .marginleft {
     margin-left: 31px;
  }*/
}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
   .marginleft {
     margin-left: 33px;
  }
}
@media screen and (-webkit-min-device-pixel-ratio:0) {
  .boxwidth {
  	width: 400px !important;
  }
}
.wd50p {
  width: 60% !important;
  }
  .wd8p {
  width: 8% !important;
  }
  .wd7p {
  width: 7% !important;
  }
  .tac {
  text-align:center !important;
  }
</style>
<!-- ========== /nav ========== -->
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>ダウンロードファイル一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<h1 class="main-title">ダウンロードファイル一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('adminDownload', ['id' => 'adminDownload', 'name' => 'adminDownload', 'url' => ['controller' => 'AdminDlFile', 'action' => 'search']]);?>
			<div class="search-area">
				<div class="category-search flex50">
					<h2>カテゴリー別を探す</h2>
					<div class="select-wrap">
						<?php echo $this->Form->input('dlcatenm',array('type'=>'select',
																'options'=>$dlcatenm, 
																'label'=>false,
																'value'=>$selecteddlcatenm,
																'empty'=> 'カテゴリーの種別を選択してください',
																'class'=>'select_type',
																'style' => 'width:auto;padding:6px 25px 4px 10px !important;',
																'id'=>'catageryType'));?>
					</div>
				</div><!-- /.download-search -->
				<div class="freeword-search flex450">
					<h2>公開状態で探す</h2>
					<ul><h4>検索対象 &nbsp;</h4>
						<li class="fontsize"><input type="radio" name="catagery" id="catagery1" value=''
						<?php echo $catageryChk1; ?>><label for="catagery1">全て</label></li>
						<li class="fontsize"><input type="radio" name="catagery" id="catagery2" value='1'
						<?php echo $catageryChk2; ?>><label for="catagery2">カテゴリー</label><label for="catagery2"></label></li>
						<li class="fontsize"><input type="radio" name="catagery" id="catagery3" value='2'
						<?php echo $catageryChk3; ?>><label for="catagery3">ファイルタイトル</label></li>
					</ul>
					<ul><h4>公開状態 &nbsp;</h4>
						<li class="fontsize"><input type="radio" name="openstate" id="openstate1" value='' 
						<?php echo $openstateChk1; ?>><label for="openstate1">全て</label></li>
						<li class="fontsize"><input type="radio" name="openstate" id="openstate2" value='0'
						<?php echo $openstateChk2; ?>><label for="openstate2">公開</label></li>
						<li class="fontsize marginleft"><input type="radio" name="openstate" id="openstate3" value='1' <?php echo $openstateChk3; ?>><label for="openstate3">非公開</label></li>
					</ul>
				</div>
				<div class="freeword-search">
					<h2>フリーワード検索で探す</h2>
					<div>
					<?php echo $this->Form->input('free-word', array('class'=>'datepicker boxwidth', 'name' => 'free-word', 'id' => 'free-word', 'style'=>'width:390px !important;',
						'label' => false,'type'=>'text','value' => $freewordval,'placeholder' => 'ファイルタイトルのキーワーどを入力してください。')); ?>
					</div>
				</div>
			</div><!-- /.freeword-search -->
			<div class="search-btn" style="width: 100%;">
				<div style="text-align: center;">
					<?php echo $this->Form->button("検索", array('class' =>'b-search','type' => 'submit','id'=>'buttonsearch'));?>
				</div>
			</div>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminDownloadedit', ['id' => 'adminDownloadedit', 'url' => ['controller' => 'adminDlFile', 'action' => 'edit']]);
					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('selecteddlcatenm', array('id'=>'selecteddlcatenm','type' => 'hidden', 'value' => $selecteddlcatenm));
					echo $this->Form->input('free_word', array('id'=>'free_word','type' => 'hidden',  'value' => $freewordval));
					echo $this->Form->input('arno', array('type' => 'hidden'));
					echo $this->Form->input('filekey', array('type' => 'hidden'));
				    echo $this->Form->input('catagery', array('id'=>'catagery','type' => 'hidden',  'value' => $catagery));
				     echo $this->Form->input('openstate', array('id'=>'openstate','type' => 'hidden',  'value' => $openstate));
			?>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminDownloaddelete', ['enctype' => 'multipart/form-data', 'id' => 'adminDownloaddelete', 'url' => ['controller' => 'AdminDlFile', 'action' => 'delete']]); 
				echo $this->Form->input('arno', array('type' => 'hidden','id' => 'arno')); 
				echo $this->Form->input('filekey', array('type' => 'hidden','id' => 'filekey')); 
				echo $this->Form->input('hyojino', array('type' => 'hidden','id' => 'hyojino'));
				echo $this->Form->input('catageryType', array('type' => 'hidden',
										'value'=>$selecteddlcatenm));
				echo $this->Form->input('catagery', array('type' => 'hidden', 'value'=>$catagery)); 
				echo $this->Form->input('openstate', array('type' => 'hidden','value'=>$openstate));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$freewordval))
				;?>
			<?php echo $this->Form->end();?>
			<div class="calender-list-table download-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if(!empty($download)):?>
				<table>
				<tbody>
				<tr>
					<th class="wd12p">カテゴリー</th>
					<th class="wd8p">カテゴリー表示順</th>
					<th style="min-width: 70px;width: 70px;">カテゴリー<BR>公開区分</th>
					<th class="wd60p">ファイルタイトル</th>
					<th class="wd7p">ファイル表示順</th>
					<th style="min-width: 60px;width: 60px;">ファイル<BR>公開区分</th>
					<th></th>
				</tr>
				<?php if(!empty($download)): foreach($download as $downloadval): ?>
				<tr class="wordbreak">
					<td><?php echo $downloadval['mdlcate']['dlcatenm']; ?></td>
					<td class="tac"><?php echo $downloadval['mdlcate']['hyojino']; ?></td>
					<td>
						<?php if ($downloadval['mdlcate']['koukaikbn'] == 0) {
							echo "公開";
						} else { 
							echo "非公開";
						}?>
					</td>
					<td><?php echo $downloadval['tfile']['title']; ?></td>
					<td class="tac"><?php echo $downloadval['TDlfile']['hyojino']; ?></td>
					<td><?php echo $downloadval['mkoukai']['koukainm']; ?></td>
					<td><?php
						echo $this->Form->button("編集", 
									array('class' =>'button edit',
											'name' => 'edit',
											'data-arno'=>$downloadval['TDlfile']['arno'],
											'data-filekey'=>$downloadval['TDlfile']['file']
						));
						echo $this->Form->button("削除",
								array('class' =>'button delete',
										'name' => 'delete',
										'data-arno'=>$downloadval['TDlfile']['arno'],
										'data-filekey'=>$downloadval['TDlfile']['file'],
										'data-hyojino'=>$downloadval['TDlfile']['hyojino']
						));?>
					</td>
				</tr>
				<?php endforeach; else: ?>
				<?php endif; ?>
				</tbody>
				</table>
				<?php endif; ?>
			</div><!-- /.list-table -->
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
