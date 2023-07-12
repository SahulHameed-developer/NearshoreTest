<!doctype html>
<title>PR情報一覧：管理画面</title>
<!-- ========== nav ========== -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/product/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>

<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== /nav ========== -->

<!-- ========== header ========== -->

<!-- ========== /header ========== -->

<!-- ========== main ========== -->
<style type="text/css">
	.addValue {
		background-color: #1e4e92;
	    margin: 0 10px 0 0;
		cursor: pointer;
		width: 90px;
		padding: 5px 0;
		font-size: 1rem;
		color: #fff;
		border: none;
	}
</style>
<section class="main">
	<div class="container">
		<main>
			<h1 class="main-title">PR情報一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('Producteditfrm', ['id' => 'Producteditfrm', 'url' => ['controller' => 'AdminProductsite', 'action' => 'edit']]);
				echo $this->Form->input('arno', array('type' => 'hidden', 'id' => 'arno'));		// T_KAISYA.arno
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tka.会社コード
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));		// tka.会社コード
				echo $this->Form->input('g_keiyaku_from', array('type' => 'hidden', 'id' => 'g_keiyaku_from'));
				echo $this->Form->input('g_keiyaku_to', array('type' => 'hidden', 'id' => 'g_keiyaku_to'));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('Productaddfrm', ['id' => 'Productaddfrm', 'url' => ['controller' => 'AdminProductsite', 'action' => 'add']]);
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tka.会社コード
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));		// tka.会社コード
				echo $this->Form->input('g_keiyaku_from', array('type' => 'hidden', 'id' => 'g_keiyaku_from'));
				echo $this->Form->input('g_keiyaku_to', array('type' => 'hidden', 'id' => 'g_keiyaku_to'));
			echo $this->Form->end();?>
			<div style="margin-top: 13px;">
				<div style="padding-left: 10px; display: inline-block;margin-top: 7px;">
					<label>会社名：</label><?php echo $kaisyanm; ?>
				</div>
				<div style="float: right;">
					<?php echo $this->Form->button("新規追加", 
							array('class' =>'addValue','name' =>'addValue', 
								'data-kaiincd' => $searchinfo[0]['tkn']['kaiincd'],
								'data-kaisyacd' => $searchinfo[0]['TKaisya']['kaisyacd'],
								'data-kaisyanm' => $searchinfo[0]['TKaisya']['kaisyanm'],
								'data-g_keiyaku_from' => $searchinfo[0]['TPrkeiyaku']['g_keiyaku_from'],
								'data-g_keiyaku_to' => $searchinfo[0]['TPrkeiyaku']['g_keiyaku_to'],
								'controller' => 'AdminProductsite','action'=> 'add')); ?>
				</div>
			</div>
			<?php if(!empty($searchinfo) && !empty($searchinfo[0]['tpr']['syohinnm'])): ?>
			<div class="list-table">
				<table class="add_table wordbreak">
					<tbody>
					<tr>
						<th style="width: 15% !important;">担当者名</th>
						<th style="width: 29% !important;">商品・サービス名</th>
						<th style="width: 10% !important;">公開状態</th>
						<th style="width: 8% !important;">表示順</th>
						<th style="width: 17% !important;min-width: 172px;">公開期間</th>
						<th></th>
					</tr>
					<?php foreach($searchinfo as $searchVal): ?>
						<tr>
							<td><?php echo $searchVal['TPrtantou']['tantounm']; ?></td>
							<td><?php echo nl2br($searchVal['tpr']['syohinnm']); ?></td>
							<td><?php echo $searchVal['mkou']['koukainm']; ?></td>
							<td style="text-align: center;"><?php echo $searchVal['tpr']['hyojino']; ?></td>
							<td style="text-align: center;">
								<?php if($searchVal['tpr']['kikanfrom']) { 
									echo $searchVal['tpr']['kikanfrom']." ～ ".$searchVal['tpr']['kikanto'];
								} ?>
							</td>
							<td>
								<?php if($searchVal['tpr']['syohinnm']!="") {
									echo $this->Form->button("編集", 
										array('class' =>'button edit editValue','name' =>'editValue', 
											'data-arno' => $searchVal['tpr']['arno'],
											'data-g_keiyaku_from' => $searchVal['TPrkeiyaku']['g_keiyaku_from'],
											'data-g_keiyaku_to' => $searchVal['TPrkeiyaku']['g_keiyaku_to'],
											'data-kaiincd' => $searchVal['tkn']['kaiincd'],
											'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
											'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
											'controller' => 'AdminProductsite','action'=> 'edit'));
									echo $this->Form->button("削除", 
										array('class' =>'button delete','name' =>'delete',
											'data-arno' => $searchVal['tpr']['arno'],
											'controller' => 'AdminProductsite','action'=> 'delete'));
								} ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.list-table -->
			<?php else: ?>
				<div align="center" style="margin-top:40px;color:red;">
					<?php echo $this->fetch('DATA_NOT_FOUND'); ?>
				</div>
			<?php endif; ?>
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
