<!doctype html>
<title>PR企業契約履歴：ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/contract/index.js') ?>
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
<?php
function moneyFormatJapan($number) {
	$length = strlen($number);
	$val = str_split(strrev($number));
	for ($i=$length-1; $i >= 0; $i--) { 
		if($i%3 == 0 && $i !=0) {
			echo $val[$i].",";
		} else {
			echo $val[$i];
		}
	}
}
?>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>PR企業契約履歴</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="rirekiListBack">一覧に戻る</a></div>
			<h1 class="main-title">PR企業契約履歴</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]);  echo $this->Form->end();?>
			<?php echo $this->Form->create('ContractSearchForm', ['id' => 'ContractSearchForm','url' => ['controller' => 'AdminContract', 'action' => 'search']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('mkeiyaku', array('type' => 'hidden','value'=>$mkeiyaku));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
			echo $this->Form->end();?>
			<div style="margin-top: 22px;padding-left: 10px;">
				<label><?php echo $kaisyanm; ?></label>
			</div>
			<div class="list-table search-btn">
			<?php if(!empty($searchinfo)): ?>
				<table class="add_table wordbreak" style="width: 80%;">
					<tbody>
					<tr>
						<th style="width: 2%;">No</th>
						<th style="width: 6%;">日付</th>
						<th style="width: 3%;">契約月数</th>
						<th style="width: 7%;">契約期間</th>
						<th style="width: 6%;">契約金額</th>
						<th style="width: 5%;">契約区分</th>
						<th style="width: 5%;">更新者</th>
					</tr>
					<?php $i=1; foreach($searchinfo as $tprkeiyakuVal): ?>
						<tr>
							<td style="text-align: center;"><?php echo $i; ?></td>
							<td style="text-align: center;"><?php echo date('Y/m/d H:i:s', strtotime($tprkeiyakuVal['TPrkyrireki']['tourokudt'])); ?></td>
							<td style="text-align: right;">
								<?php if($tprkeiyakuVal['TPrkyrireki']['ktukisuu'] == "1") { 
									echo "6ヵ月";
								} else {
									echo "12ヵ月";
								} ?>
							</td>
							<td style="text-align: center;">
								<?php if($tprkeiyakuVal['TPrkyrireki']['keiyaku_from']) { 
									echo date('Y/m', strtotime($tprkeiyakuVal['TPrkyrireki']['keiyaku_from']))." ～ ".date('Y/m', strtotime($tprkeiyakuVal['TPrkyrireki']['keiyaku_to']));
								} ?>
							</td>
							<td style="text-align: right;"><?php echo moneyFormatJapan($tprkeiyakuVal['TPrkyrireki']['keikin'])."円"; ?></td>
							<td style="text-align: center;"><?php echo $tprkeiyakuVal['MKeiyaku']['keiyakunm']; ?></td>
							<td style="text-align: center;"><?php echo $tprkeiyakuVal['TKaiin']['kaiinnm']; ?></td>
							<?php $i++; ?>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<div style="margin:20px;">
					<?php echo $this->Form->button("一覧に戻る", array('class' =>'rirekiListBack',
														'id' => 'searchbutton',
														'name' =>'searchbtn',
														'style' =>'width:105px;padding:7px;'));?>
				</div>
			</div><!-- /.list-table -->
			<?php else: ?>
				<div align="center" style="margin-top:40px;color:red;">
					<?php echo $this->fetch('SEARCH_NOT_FOUND'); ?>
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