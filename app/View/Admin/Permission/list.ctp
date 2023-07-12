<!doctype html>
<title>権限設定：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->html->css('admin/membermanage/style.css') ?>
<?= $this->Html->script('admin/permission/index.js') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== /header ========== -->
<!-- ========== nav ========== -->
<style>
	@media screen and (min-width: 768px) {
		.newslist-list-table th:last-child, .newslist-list-table td:last-child {
			width: 6% !important;
		}
	}
	.upregtext {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ1JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+55m76Yyy44O75pu05paw5Lit44CC44CC44CCIDwvdGV4dD48L3N2Zz4=');
		background-color: rgba(255, 255, 255, .5);
	}
	input[type=checkbox] {
		display:none;
	}
	input[type=checkbox] + label {
		border:0.1px solid black;
		background: white;
		height: 13px;
		width: 13px;
	 	display:inline-block;
		padding: 0 0 0 0px;
	}
	input[type=checkbox]:checked + label {
		background: black;
		height: 13px;
		width: 13px;
		display:inline-block;
		padding: 0 0 0 0px;
	}
</style>
<!-- ========== /nav ========== -->
<!-- ========== main ========== -->
<div id="upregtext"></div>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="returnList">管理画面トップ</a></li>
				<li>権限設定</li>
			</ol><!-- /.breadcrumbs -->
			<div class="breadcrumbs f_right"><a style="cursor:pointer;" class="returnList">メニューに戻る</a></div>
			<h1 class="main-title">権限設定</h1>
			<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('index', ["id"=>"index", "name"=>"index",'url' => ['controller' => 'adminPermission', 'action' => 'search']]);
				echo $this->Form->input('kcaltouroku_val', array('name' => 'kcaltouroku_val','id' => 'kcaltouroku_val','type' => 'hidden')); 
				echo $this->Form->input('kcaltouroku_ncval', array('name' => 'kcaltouroku_ncval','id' => 'kcaltouroku_ncval','type' => 'hidden')); 
				echo $this->Form->input('kcalkoukai_val', array('name' => 'kcalkoukai_val','id' => 'kcalkoukai_val','type' => 'hidden')); 
				echo $this->Form->input('kcalkoukai_ncval', array('name' => 'kcalkoukai_ncval','id' => 'kcalkoukai_ncval','type' => 'hidden')); 
				echo $this->Form->input('khoutouroku_val', array('name' => 'khoutouroku_val','id' => 'khoutouroku_val','type' => 'hidden')); 
				echo $this->Form->input('khoutouroku_ncval', array('name' => 'khoutouroku_ncval','id' => 'khoutouroku_ncval','type' => 'hidden')); 
				echo $this->Form->input('khoukoukai_val', array('name' => 'khoukoukai_val','id' => 'khoukoukai_val','type' => 'hidden')); 
				echo $this->Form->input('khoukoukai_ncval', array('name' => 'khoukoukai_ncval','id' => 'khoukoukai_ncval','type' => 'hidden')); 
				echo $this->Form->input('osirasetouroku_val', array('name' => 'osirasetouroku_val','id' => 'osirasetouroku_val','type' => 'hidden')); 
				echo $this->Form->input('osirasetouroku_ncval', array('name' => 'osirasetouroku_ncval','id' => 'osirasetouroku_ncval','type' => 'hidden')); 
				echo $this->Form->input('osirasekoukai_val', array('name' => 'osirasekoukai_val','id' => 'osirasekoukai_val','type' => 'hidden')); 
				echo $this->Form->input('osirasekoukai_ncval', array('name' => 'osirasekoukai_ncval','id' => 'osirasekoukai_ncval','type' => 'hidden')); 
				echo $this->Form->input('yuekitouroku_val', array('name' => 'yuekitouroku_val','id' => 'yuekitouroku_val','type' => 'hidden')); 
				echo $this->Form->input('yuekitouroku_ncval', array('name' => 'yuekitouroku_ncval','id' => 'yuekitouroku_ncval','type' => 'hidden')); 
				echo $this->Form->input('yuekikoukai_val', array('name' => 'yuekikoukai_val','id' => 'yuekikoukai_val','type' => 'hidden')); 
				echo $this->Form->input('yuekikoukai_ncval', array('name' => 'yuekikoukai_ncval','id' => 'yuekikoukai_ncval','type' => 'hidden')); 
				echo $this->Form->input('syukketusansyo_val', array('name' => 'syukketusansyo_val','id' => 'syukketusansyo_val','type' => 'hidden'));
				echo $this->Form->input('syukketusansyo_ncval', array('name' => 'syukketusansyo_ncval','id' => 'syukketusansyo_ncval','type' => 'hidden'));
				echo $this->Form->input('count', array('name' => 'count','id' => 'count','type' => 'hidden','value' => $count)); ?>
			<div class="calender-search-area" style="display: inline-block;">
				<div class="conference-search" style="padding-right: 5px !important;">
					<h2>カテゴリーから探す</h2>
					<p>プルダウンから登録している企業を絞り込むことができます。</p>
					<div class="select-wrap">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('sosiki',array('type'=>'select',
																			'options'=>$sosiki, 
																			'label'=>false,
																			'value'=>$selectedSosiki,
																			'empty'=> '組織を選択してください',
																			'name'=>'sosiki'));?>
						</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->button("検索", array('class' =>'buttonsearch','name' =>'kaigibtn','controller' => 'adminPermission','action'=> 'search'));?>
						</div>
					</div>
				</div>
			</div>
			<?php if(!empty($searchinfo)): ?>
				<div class="register" style="display: inline-block;">
					<button type="button" class="b-sendregister" >登録・更新</button>
				</div>
			<?php endif; ?>
			<div class="dottedline"></div> 
			<?php if(!empty($searchinfo)): ?>
			<div style="text-align: right;">
				<label>表示順序</label>
				<div class="select-wrap">
					<?php echo $this->Form->input('dispOrder',array('type'=>'select',
																'options'=>$dispOrder, 
																'label'=>false,
																'style' =>'width:150px;',
																'value'=>$selectedOrder,
																'onchange' => 'this.form.submit()',
																'id'=>'selectedOrder',
																'name'=>'selectedOrder'));?>
				</div>
			</div>
			<div class="newslist-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<table>
					<tbody>
						<tr>
							<th class="wd5p">会員<br>コード</th>
							<th class="wd14p">会員名</th>
							<th class="wd6p">会員種別</th>
							<th class="wd8p">役職</th>
							<th class="wd8p">組織</th>
							<th class="wd8p">委員会役職</th>
							<th class="wd6p5">活動<br>カレンダー<br>登録権限</th>
							<th class="wd6p5">活動<br>カレンダー<br>公開権限</th>
							<th class="wd6p">活動報告<br>登録権限</th>
							<th class="wd6p">活動報告<br>公開権限</th>
							<th class="wd6p">お知らせ<br>登録権限</th>
							<th class="wd6p">お知らせ<br>公開権限</th>
							<th class="wd6p">有益情報<br>登録権限</th>
							<th class="wd6p">有益情報<br>公開権限</th>
							<th class="wd6p">出欠<br>参照権限</th>
						</tr>
						<?php foreach($searchinfo as $searchVal): ?>
						<tr class="wordbreak">
							<td><?php echo $searchVal['TKaiin']['kaiincd']; ?></td>
							<td><?php echo $searchVal['TKaiin']['kaiinnm']; ?></td>
							<td><?php echo $searchVal['tkn']['kaiinsbnm']; ?></td>
							<td><?php echo $searchVal['mky']['kyoukaiyknm']; ?></td>
							<td><?php echo $searchVal['mso']['sosikinm']; ?></td>
							<td><?php echo $searchVal['miy']['iinkaiyknm']; ?></td>
							<td class="tac">
								<input type="checkbox" class="kcaltouroku_checkbox" name="kcaltouroku[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "kcaltouroku".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['kcaltouroku'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "kcaltouroku".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="kcalkoukai_checkbox" name="kcalkoukai[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "kcalkoukai".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['kcalkoukai'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "kcalkoukai".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="khoutouroku_checkbox" name="khoutouroku[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "khoutouroku".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['khoutouroku'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "khoutouroku".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="khoukoukai_checkbox" name="khoukoukai[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "khoukoukai".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['khoukoukai'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "khoukoukai".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="osirasetouroku_checkbox" name="osirasetouroku[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "osirasetouroku".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['osirasetouroku'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "osirasetouroku".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="osirasekoukai_checkbox" name="osirasekoukai[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "osirasekoukai".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['osirasekoukai'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "osirasekoukai".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="yuekitouroku_checkbox" name="yuekitouroku[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "yuekitouroku".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['yuekitouroku'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "yuekitouroku".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="yuekikoukai_checkbox" name="yuekikoukai[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "yuekikoukai".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['yuekikoukai'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "yuekikoukai".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="tac">
								<input type="checkbox" class="syukketusansyo_checkbox" name="syukketusansyo[]" value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" id="<?php echo "syukketusansyo".$searchVal['TKaiin']['kaiincd']; ?>" <?php if($searchVal['tgen']['syukketusansyo'] == "1"): ?> Checked <?php endif; ?> >
								<label for="<?php echo "syukketusansyo".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
			</table>
			</div><!-- /.list-table -->
			<?php elseif (isset($searchval)): ?>
				<div align="center" style="margin-top:25px;color:red;">
					<?php echo $this->fetch('SEARCH_NOT_FOUND'); ?>
				</div>
			<?php endif; ?>
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