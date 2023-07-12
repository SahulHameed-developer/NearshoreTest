<!doctype html>
<title>会員情報一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/member/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<!-- ========== nav ========== -->
<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== /nav ========== -->

<!-- ========== header ========== -->

<!-- ========== /header ========== -->

<!-- ========== main ========== -->
<style>
	.f_right {
    	display: block;
    	float: right;
    }
</style>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>会員情報一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">会員情報一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('kaiineditfrm', ['id' => 'kaiineditfrm', 'url' => ['controller' => 'AdminMember', 'action' => 'edit']]);
				echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tkn.会社コード
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('kaiindeletefrm', ['id' => 'kaiindeletefrm', 'url' => ['controller' => 'AdminMember', 'action' => 'delete']]);
				echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tkn.会社コード
				echo $this->Form->input('syasinkey', array('type' => 'hidden', 'id' => 'syasinkey'));		// tkn.会社コード
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('kaiinaddfrm', ['id' => 'kaiinaddfrm', 'url' => ['controller' => 'AdminMember', 'action' => 'add_2']]);
				echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tkn.会社コード
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'adminMember', 'action' => 'search']]);?>
			<div class="search-area kaiinSearch">
				<div class="category-search kaiinSearch-left">
					<h2>カテゴリーから探す</h2>
					<p>プルダウンから登録している企業を絞り込むことができます。</p>
					<div class="select-wrap">
						<?php echo $this->Form->input('gyosyunm',array('type'=>'select',
																		'options'=>$gyosyunm, 
																		'label'=>false,
																		'value'=>$selectedGyosyunm,
																		'empty'=> '業種を選択してください',
																		'name'=>'industry'));?>
					</div>
					<div class="select-wrap">
						<?php echo $this->Form->input('kaiinsbnm',array('type'=>'select',
																		'options'=>$kaiinsbnm, 
																		'label'=>false,
																		'value'=>$selectedKaiinsbnm,
																		'empty'=> '会員種別を選択してください',
																		'name'=>'members_type'));?>
					</div>
				</div><!-- /.category-search -->
				<div class="freeword-search  kaiinSearch-right">
					<h2>フリーワード検索で探す</h2>
					<p>企業名や会員名、所在地などから検索できます。</p>
					<ul>
						<?php foreach($searchTypeList as $key => $searchType):?>
							<li><input type="radio" name="free_radio" class="radio" value="<?php echo $key;?>" id="fr-<?php echo $key;?>" <?php if($key == $freewordTypeChk){echo "checked";}?>><label for="fr-<?php echo $key;?>"><?php echo $searchType;?></label></li>
						<?php endforeach;?>
					</ul>
					<?php echo $this->Form->input('', array('type' => 'text','name'=>'free_word','value'=> $keywordVal)); ?>
				</div><!-- /.freeword-search -->
			</div><!-- /.search-area -->
			<div class="search-btn" style="width: 100%;">
				<div style="display:inline-block;width: 52%;text-align: right;">
					<?php echo $this->Form->button("検索", array(
														'class' =>'search-btn',
														'id' => 'searchbutton',
														'name' =>'searchbtn',
														'controller' => 'AdminMember',
														'action'=> 'search'));?>
				</div>
				<div style="display: inline-block;width: 45%;text-align: right;">
				<?php if(!empty($searchinfo)) { ?>
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
				<?php } ?>
				</div>
			</div>
			<?php echo $this->Form->end();?>
			<?php if($display == $this->Constants->SEARCH): if(!empty($searchinfo)): ?>
			<div class="list-table">
				<table class="add_table wordbreak">
					<tbody>
					<tr>
						<th class="wd9p" >会員コード</th>
						<th>企業名</th>
						<th class="wd10p">代表者名</th>
						<th class="wd10p">会員名</th>
						<th class="wd15p">業種</th>
						<th class="wd10p">会員種別</th>
						<th style="min-width: 65px;">公開状態</th>
						<th></th>
					</tr>
					<?php foreach($searchinfo as $searchVal): ?>
						<tr>
							<td><?php echo $searchVal['tkn']['kaiincd']; ?></td>
							<td><?php echo $searchVal['TKaisya']['kaisyanm']; ?></td>
							<td><?php echo $searchVal['TKaisya']['daihyonm']; ?></td>
							<td><?php echo $searchVal['tkn']['kaiinnm']; ?></td>
							<td><?php echo $searchVal['mgs']['gyosyunm']; ?></td>
							<td><?php echo $searchVal['mkn']['kaiinsbnm']; ?></td>
							<td><?php echo $searchVal['mkou']['koukainm']; ?></td>
							<td><?php 
							echo $this->Form->button("追加", 
								array('class' =>'button edit addValue','name' =>'addValue', 
									'data-kaiincd' => $searchVal['tkn']['kaiincd'],
									'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
									'controller' => 'AdminMember','action'=> 'add_2'));
							echo $this->Form->button("編集", 
								array('class' =>'button edit editValue','name' =>'editValue', 
									'data-kaiincd' => $searchVal['tkn']['kaiincd'],
									'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
									'controller' => 'AdminMember','action'=> 'edit'));
							echo $this->Form->button("削除", 
								array('class' =>'button delete','name' =>'delete',
									'data-kaiincd' => $searchVal['tkn']['kaiincd'],
									'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
									'data-syasinkey' => $searchVal['TKaisya']['syasin'],
									'controller' => 'AdminMember','action'=> 'delete'));
							?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.list-table -->
			<?php else: ?>
				<div align="center" style="margin-top:40px;color:red;">
					<?php echo $this->fetch('SEARCH_NOT_FOUND'); ?>
				</div>
			<?php endif; endif; ?>
			</form>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->

<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>
