<!doctype html>
<title>コードマスタ一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->html->css('admin/membermanage/style.css') ?>
<?= $this->Html->script('admin/codemaster/index.js') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<div id="upregtext"></div>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="returnListhome">管理画面トップ</a></li>
				<li>コードマスタ一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="breadcrumbs f_right"><a style="cursor:pointer;" class="returnListhome">メニューに戻る</a></div>
			<h1 class="main-title">コードマスタ一覧</h1>
			<?php echo $this->Form->create('listModoruFrm', ['id' => 'listModoruFrm', 'url' => ['controller' => 'Admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('index', ["id"=>"index", "name"=>"index",'url' => ['controller' => 'AdminMaster', 'action' => 'search']]);?>
			<div class="calender-search-area" style="display: inline-block;padding-bottom: 15px !important;">
				<div class="conference-search" style="padding-right: 5px !important;">
					<div class="select-wrap">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('masterCode',array('type'=>'select',
																'options'=>$masterCode, 
																'label'=>false,
																'style' =>'min-width:230px;width:auto;',
																'value'=>$selectedmstcode,
																'empty'=> 'マスタを選択してください',
																'id'=>'selectedmstcode',
																'name'=>'selectedmstcode'));?>
						</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->button("検索", array('class' =>'buttonsearch','name' =>'kaigibtn','style'=>'padding:0.38rem 1rem;','controller' => 'AdminMaster','action'=> 'search'));?>
						</div>
					</div>
				</div>
			</div>
			<?php if ($selectedmstcode != "") { ?>
			<div class="register" style="display: inline-block;">
				<button type="button" class="b-sendregister" style="width:90px !important;padding: 6px 0 !important;">新規追加</button>
			</div>
			<?php } ?>
			<?php if ($selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) { ?>
				<div class="report-search-area" style="margin-top: 0px !important;padding-bottom: 10px !important;">
					<div class="conference-search">
						<div class="select-wrap1">
							<div style="display: inline-block;">
									<?php echo $this->Form->input('classOrder',array('type'=>'select',
																'options'=>$classOrder, 
																'label'=>false,
																'style' =>'min-width:230px;width:auto;padding:6px 25px 4px 10px !important;',
																'value'=>$selectedOrder,
																'empty'=> '分類を選択してください',
																'onchange' => 'this.form.submit()',
																'id'=>'selectedOrder',
																'name'=>'selectedOrder'));?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('sousai_Frm', ['id' => 'sousai_Frm', 'url' => ['controller' => 'Adminmaster', 'action' => 'codemasterlist']]);
				echo $this->Form->input('code', array('type' => 'hidden'));
				echo $this->Form->input('bunruicd', array('type' => 'hidden'));
				echo $this->Form->input('fromdt', array('type' => 'hidden'));
				echo $this->Form->input('todt', array('type' => 'hidden'));
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
				echo $this->Form->input('selectedmstcode', array('type' => 'hidden','value'=>$selectedmstcode));
			echo $this->Form->end();?>
			<div class="dottedline" style="margin-top: 20px; margin-bottom: 50px;"></div> 
			<?php if(!empty($searchinfo)): ?>
			<div class="calender-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if ($selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) { ?>
			<table style="width:70%">
			<?php } else if ($selectedmstcode == $this->fetch('M_SOSIKI_VAL') || $selectedmstcode == $this->fetch('M_IINKAI_VAL') || $selectedmstcode == $this->fetch('M_KEIYAKU_VAL') ) { ?>
			<table style="width:75%">
			<?php } else if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL') || $selectedmstcode == $this->fetch('M_KURABU_VAL')) { ?>
			<table style="width:100%">
			<?php } else { ?>
			<table style="width:60%">
			<?php } ?>
					<tbody>
						<tr>
							<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL')) { ?>
								<th style="width:6%;">コード</th>
							<?php } else { ?>
								<th style="width:8%;">コード</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) { ?>
								<th style="width:14%;">分類</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_KURABU_VAL') ) { ?>
								<th style="width:15%;">名称</th>
							<?php } else { ?>
								<th style="width:22%;">名称</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_SOSIKI_VAL') || $selectedmstcode == $this->fetch('M_IINKAI_VAL') || $selectedmstcode == $this->fetch('M_KEIYAKU_VAL')) { ?>
								<th style="width:20%;">略称</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_KURABU_VAL') ) { ?>
								<th style="width:15%;">略称</th>
								<th style="width:19%;">代表メールアドレス</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL')) { ?>
								<th style="width:8.7%;">項目名称１</th>
								<th style="width:8.7%;">項目名称２</th>
								<th style="width:8.7%;">項目名称３</th>
								<th style="width:8.7%;">項目名称４</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL') || $selectedmstcode == $this->fetch('M_KURABU_VAL') ) { ?>
								<th style="width:6%;">表示順</th>
							<?php } else { ?>
								<th style="width:8%;">表示順</th>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL')) { ?>
								<th style="min-width: 60px;width:8.1%;">適用開始日</th>
								<th style="min-width: 60px;width:8.1%;">適用終了日</th>
							<?php } else { ?>
								<th style="min-width: 60px;width:11%;">適用開始日</th>
								<th style="min-width: 60px;width:11%;">適用終了日</th>
							<?php } ?>
							<th style="width:20%;"></th>
						</tr>
						<?php foreach($searchinfo as $searchVal): ?>
						<tr class="wordbreak">
							<td class="tac"><?php echo $searchVal['code']; ?></td>
							<?php if ($selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) { ?>
								<td><?php echo $searchVal['class_name']; ?></td>
							<?php } ?>
							<td><?php echo $searchVal['name']; ?></td>
							<?php if ($selectedmstcode == $this->fetch('M_SOSIKI_VAL') || $selectedmstcode == $this->fetch('M_IINKAI_VAL') || $selectedmstcode == $this->fetch('M_KURABU_VAL') || $selectedmstcode == $this->fetch('M_KEIYAKU_VAL') ) { ?>
								<td><?php echo $searchVal['abbr_name']; ?></td>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_KURABU_VAL') ) { ?>
								<td><?php echo $searchVal['mailaddr']; ?></td>
							<?php } ?>
							<?php if ($selectedmstcode == $this->fetch('M_YKBUNRUI_VAL')) { ?>
								<td><?php echo $searchVal['kmnm1']; ?></td>
								<td><?php echo $searchVal['kmnm2']; ?></td>
								<td><?php echo $searchVal['kmnm3']; ?></td>
								<td><?php echo $searchVal['kmnm4']; ?></td>
							<?php } ?>
							<td class="tac"><?php echo $searchVal['hyojino']; ?></td>
							<td class="tac"><?php echo str_replace('-', '/', $searchVal['fromdt']); ?></td>
							<td class="tac"><?php echo str_replace('-', '/', $searchVal['todt']); ?></td>
							<td class="tac"><?php echo $this->Form->button("編集", 
												array('class' =>'button edit shosaiShutoku',
														'name' => 'edit',
														'data-code' => $searchVal['code'],
														'data-bunruicd' => (isset($searchVal['bunruicd'])?$searchVal['bunruicd']:""),
														'data-fromdt' => $searchVal['fromdt'],
														'data-todt' => $searchVal['todt']
									));
									echo $this->Form->button("削除",
											array('class' =>'button delete shosaiSakujo',
													'name' => 'delete',
													'data-code' => $searchVal['code'],
													'data-bunruicd' => (isset($searchVal['bunruicd'])?$searchVal['bunruicd']:""),
													'data-fromdt' => $searchVal['fromdt'],
													'data-todt' => $searchVal['todt']
											));
								?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
			</table>
			</div><!-- /.list-table -->
			<?php elseif (isset($searchval)): ?>
				<div align="center" style="margin-top:25px;color:red;">
					<?php if ($selectedOrder == "" && $selectedmstcode == $this->fetch('M_KBUNRUI_VAL')) {
						echo "分類を選択してください。";
					} else {
						echo $this->fetch('SEARCH_NOT_FOUND');
					}  ?>
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