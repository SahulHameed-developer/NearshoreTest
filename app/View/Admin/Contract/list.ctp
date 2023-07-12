<!doctype html>
<title>PR契約情報一覧：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/contract/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<script>
	$(function() {
		$(".datepicker").MonthPicker({  Button: false, MonthFormat: 'yy/mm' });
	});
</script>
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
	.width96p {
		width: 96%;
	}
	.padR0p {
		padding-right: 0px;
	}
	.radbtnpad {
		padding-left: 18px !important;
		padding-right: 12px !important;
	}
	.wd15p {
		width: 15% !important;
	}
	.wd7p {
		width: 7% !important;
	}
	.flex240 {
		flex: 1 1 auto;
	}
	.flex270 {
		flex: 1 1 auto;
	}
	.flex280 {
		flex: 1 1 auto;
	}
	.flex315 {
		flex: 1 1 auto;
	}
	@media screen and (min-width: 900px) {
		.flex240 {
		    flex: 0 0 240px;
		}
		.flex270 {
		    flex: 0 0 270px;
		}
		.flex280 {
		    flex: 0 0 280px;
		}
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
				<li>PR契約情報一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<h1 class="main-title">PR契約情報一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('Contractrenewalfrm', ['id' => 'Contractrenewalfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'renewal']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('mkeiyaku', array('type' => 'hidden','value'=>$mkeiyaku));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
				echo $this->Form->input('arno', array('type' => 'hidden', 'id' => 'arno'));		// T_KAISYA.arno
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tka.会社コード
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));		// tka.会社コード
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
				echo $this->Form->input('g_keiyaku_from', array('type' => 'hidden', 'id' => 'g_keiyaku_from'));		// tka.会社コード
				echo $this->Form->input('g_keiyaku_to', array('type' => 'hidden', 'id' => 'g_keiyaku_to'));		// tka.会社コード
			echo $this->Form->end();?>
			<?php echo $this->Form->create('Contracteditfrm', ['id' => 'Contracteditfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'edit']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('mkeiyaku', array('type' => 'hidden','value'=>$mkeiyaku));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
				echo $this->Form->input('arno', array('type' => 'hidden', 'id' => 'arno'));		// T_KAISYA.arno
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));		// T_KAISYA.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));		// tka.会社コード
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));		// tka.会社コード
				echo $this->Form->input('prevaluesto', array('type' => 'hidden', 'id' => 'prevaluesto'));	
				echo $this->Form->input('nextvaluesfrom', array('type' => 'hidden', 'id' => 'nextvaluesfrom'));	
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('Contractaddfrm', ['id' => 'Contractaddfrm', 'url' => ['controller' => 'AdminContract', 'action' => 'add']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('mkeiyaku', array('type' => 'hidden','value'=>$mkeiyaku));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
				echo $this->Form->input('arno', array('type' => 'hidden', 'id' => 'arno'));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('ContractSearchForm', ['id' => 'ContractSearchForm','url' => ['controller' => 'AdminContract', 'action' => 'search']]);?>
			<div class="search-area kaiinSearch">
				<div class="category-search kaiinSearch-left width96p">
					<h2>カテゴリーから探す</h2>
					<div class="select-wrap">
						<?php echo $this->Form->input('kaiinsbnm',array('type'=>'select',
																		'options'=>$kaiinsbnm, 
																		'label'=>false,
																		'value'=>$selectedKaiinsbnm,
																		'empty'=> '会員種別を選択してください',
																		'name'=>'kaiinsbnm'));?>
					</div><br>
					<div class="select-wrap">
						<?php echo $this->Form->input('gyosyunm',array('type'=>'select',
																		'options'=>$gyosyunm, 
																		'label'=>false,
																		'value'=>$selectedGyosyunm,
																		'empty'=> '業種を選択してください',
																		'name'=>'gyosyunm'));?>
					</div>
				</div><!-- /.category-search -->
				<div class="freeword-search category-search width96p kaiinSearch-right flex315">
					<h2>フリーワード検索で探す</h2>
					<div style="padding-top: 10px;">
						<ul>
							<?php foreach($searchTypeList as $key => $searchType):?>
								<li class="radbtnpad"><input type="radio" name="free_radio" class="radio" value="<?php echo $key;?>" id="fr-<?php echo $key;?>" <?php if($key == $freewordTypeChk){echo "checked";}?>><label for="fr-<?php echo $key;?>"><?php echo $searchType;?></label></li>
							<?php endforeach;?>
						</ul>
						<?php echo $this->Form->input('', array('type' => 'text','name'=>'free_word','style'=>'width : 250px;padding: 0.2em 0.4em;','value'=> $keywordVal)); ?>
					</div>
				</div><!-- /.freeword-search -->
				<div class="category-search width96p kaiinSearch-right flex280" style="border-left: 1px dotted #c0c0c0;padding-left: 30px;">
					<h2>状態で探す</h2>
					<div style="width: 30%;display: inline-block;vertical-align: top;">
						<h4>契約区分</h4>
					</div>
					<div style="width: 65%;display: inline-block;">
						<ul class="fnt14 mt10" style="display: inline-block;">
							<div id="wrapper" style="width: 88px;">
								<label>
									<input type="radio" name="mkeiyaku" id="mkeiyaku1" value="" class="check" <?php echo $mkeiyakuChk1; ?>>
									<span class="pad_11_7">全て</span>
								</label>
							</div>
						</ul>
						<?php foreach ($mkeiyakuList as $key => $mkeiyakuListvalue) { ?>
						<ul class="fnt14 mt10" style="display: inline-block;">
							<div id="wrapper" style="width: 88px;height: 30px;">
								<label>
									<input type="radio" name="mkeiyaku" id="kei-<?php echo $key;?>" value="<?= $key ?>" class="check" <?php if($key == $mkeiyaku) {?> checked <?php } ?>>
									<span class="pad_11_7"><?php echo $mkeiyakuListvalue;?></span>
								</label>
							</div>
						</ul>
						<?php } ?>
					</div>
				</div><!-- /.MkeiyakuChk-search -->
				<div class="freeword-search kaiinSearch-right flex240">
					<h2 style="margin: 0;">契約期間で探す</h2>
					<ul><h4 style="padding-top: 15px">開始</h4>
						<li style="padding-top: 4px">
							<?php echo $this->Form->input('fromdate', array('class'=>'datepicker', 'name' => 'fromdate','id' => 'fromdate','label' => false,'size' => '8', 'type'=>'text','value' => $fromdate,'maxlength' => '7', 'style' => 'padding: 0.05em 0.4em;')); ?>
						</li>
					</ul>
					<ul><h4 style="padding-top: 11px">終了</h4>
						<li style="margin: 0;">
							<?php echo $this->Form->input('todate', array('class'=>'datepicker', 'name' => 'todate', 'id' => 'todate','label' => false,'size' => '8','type'=>'text','value' => $todate,'maxlength' => '7', 'style' => 'padding: 0.05em 0.4em;')); ?>
						</li>
					</ul>
				</div><!-- /.freeword-search -->
			</div><!-- /.search-area -->
			<div class="search-btn" style="width: 100%;">
				<div style="display:inline-block;width: 52%;text-align: right;">
					<?php echo $this->Form->button("検索", array(
														'class' =>'search-btn',
														'id' => 'searchbutton',
														'name' =>'searchbtn',
														'controller' => 'AdminContract',
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
				<div id="dateFmtError" style="font-size: 0.9rem;margin-top: 15px;" class="tac dateFmtError"></div>
			</div>
			<?php echo $this->Form->end();?>
			<?php if($display == $this->Constants->SEARCH): if(!empty($searchinfo)): ?>
			<div class="list-table">
				<table class="add_table wordbreak">
					<tbody>
					<tr>
						<th class="wd15p">企業名</th>
						<th class="wd15p">会員名</th>
						<th class="wd20p">契約期間</th>
						<th class="wd8p">契約金額</th>
						<th class="wd7p">契約状態</th>
						<th style="min-width: 330px;"></th>
					</tr>
					<?php
					$kaisyanm ="";
					// $kaiinnmGC ="";
					foreach($searchinfo as $keys => $searchVal): ?>
						<tr>
							<td><?php if($kaisyanm != $searchVal['TKaisya']['kaisyacd']) { echo $searchVal['TKaisya']['kaisyanm']; $kaisyanm = $searchVal['TKaisya']['kaisyacd']; } ?></td>
							<td>
								<?php echo str_replace(',', '<BR>', $searchVal['tkn']['kaiinnmGC']); ?>
							</td>
							<td style="text-align: center;"><?php if($searchVal['tpr']['g_keiyaku_from']) { echo date('Y/m', strtotime($searchVal['tpr']['g_keiyaku_from']))." ～ ".date('Y/m', strtotime($searchVal['tpr']['g_keiyaku_to'])); } ?></td>
							<td style="text-align: right;"><?php if(!empty($searchVal['tpr']['g_keikin'])) { echo moneyFormatJapan($searchVal['tpr']['g_keikin'])."円"; } ?></td>
							<td><?php if(date('Y/m/d', strtotime($searchVal['tpr']['g_keiyaku_to'])) < date('Y/m/d') && !empty($searchVal['tpr']['g_keiyaku_to'])) {
								echo "終了";
							} else {
								echo $searchVal['mkei']['keiyakurs'];
							} ?></td>
							<td><?php 
							if($searchVal['tpr']['arno']!="") {
								// print_r($searchVal);
								// $prevaluesto = "1970/01";
								// $nextvaluesfrom = "9999/12";
								// $this_value = $searchinfo[$keys];
								// if(isset($searchinfo[$keys-1])) {
								// 	$preval = $searchinfo[$keys-1];
								// 	if(($this_value['tkn']['kaiincd'] == $preval['tkn']['kaiincd']) && ($this_value['TKaisya']['kaisyacd'] == $preval['TKaisya']['kaisyacd'])) {
								// 		$prevaluesto = date('Y/m', strtotime($preval['tpr']['g_keiyaku_to']));
								// 	}
								// }
								// if(isset($searchinfo[$keys+1])) {
								// 	$nextval = $searchinfo[$keys+1];
								// 	if(($this_value['tkn']['kaiincd'] == $nextval['tkn']['kaiincd']) && ($this_value['TKaisya']['kaisyacd'] == $nextval['TKaisya']['kaisyacd'])) {
								// 		$nextvaluesfrom = date('Y/m', strtotime($nextval['tpr']['g_keiyaku_from']));
								// 	}
								// }
								if($searchVal['TPrkeiyaku']['prevaluesto'] == "1970-01-01") {
									$prevaluesto = "1970/01";
								} else {
									$prevaluesto = date('Y/m', strtotime($searchVal['TPrkeiyaku']['prevaluesto']));
								}
								if($searchVal['TPrkeiyaku']['nextvaluesfrom'] == "9999-12-01") {
									$nextvaluesfrom = "9999/12";
								} else {
									$nextvaluesfrom = date('Y/m', strtotime($searchVal['TPrkeiyaku']['nextvaluesfrom']));
								}
								echo $this->Form->button("履歴", 
									array('class' =>'button edit rirekiList','name' =>'rirekiList', 
										'data-arno' => $searchVal['tpr']['arno'],
										'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
										'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
										'controller' => 'AdminContract','action'=> 'search'));
								echo $this->Form->button("編集", 
									array('class' =>'button edit editValue','name' =>'editValue', 
										'data-arno' => $searchVal['tpr']['arno'],
										'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
										'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
										'data-prevaluesto' => $prevaluesto,
										'data-nextvaluesfrom' => $nextvaluesfrom,
										'controller' => 'AdminContract','action'=> 'search'));
								if($searchVal['TPrkeiyaku']['nextvaluesfrom'] == "9999-12-01") {
									echo $this->Form->button("契約更新", 
									array('class' =>'button edit renewalValue','name' =>'renewalValue', 
										'data-arno' => $searchVal['tpr']['arno'],
										'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
										'data-g_keiyaku_from' => substr($searchVal['tpr']['g_keiyaku_from'],0,10),
										'data-g_keiyaku_to' => substr($searchVal['tpr']['g_keiyaku_to'],0,10),
										'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
										'controller' => 'AdminContract','action'=> 'search'));
									echo $this->Form->button("削除", 
										array('class' =>'button delete','name' =>'delete',
											'data-arno' => $searchVal['tpr']['arno'],
											'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
											'data-g_keiyaku_from' => substr($searchVal['tpr']['g_keiyaku_from'],0,10),
											'data-g_keiyaku_to' => substr($searchVal['tpr']['g_keiyaku_to'],0,10),
											'data-ktukisuu' => $searchVal['tpr']['ktukisuu'],
											'data-g_keikin' => $searchVal['tpr']['g_keikin'],
											'data-kykbn' => $searchVal['tpr']['kykbn'],
											'controller' => 'AdminContract','action'=> 'delete'));
								}
							} else {
							echo $this->Form->button("新規", 
								array('class' =>'button edit addValue','name' =>'addValue', 
									'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
									'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
									'controller' => 'AdminContract','action'=> 'add'));
							}
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
