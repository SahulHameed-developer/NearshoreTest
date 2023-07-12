<!doctype html>
<title>PR情報一覧：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/product/index.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<script>
	$(function() {
		$(".datepicker").datepicker();
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
		.flex315 {
			flex: 0 0 315px;
		}
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
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>PR情報一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">PR情報一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('Producteditfrm', ['id' => 'Producteditfrm', 'url' => ['controller' => 'AdminProductsite', 'action' => 'edit']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('openstate', array('type' => 'hidden','value'=>$openstate));
				echo $this->Form->input('registrationstate', array('type' => 'hidden','value'=>$registrationstate));
				echo $this->Form->input('Kikanjoutai', array('type' => 'hidden','value'=>$Kikanjoutai));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
				echo $this->Form->input('arno', array('type' => 'hidden', 'id' => 'arno'));
				// echo $this->Form->input('TPrkeiyakuarno', array('type' => 'hidden', 'id' => 'TPrkeiyakuarno'));
				echo $this->Form->input('g_keiyaku_from', array('type' => 'hidden', 'id' => 'g_keiyaku_from'));
				echo $this->Form->input('g_keiyaku_to', array('type' => 'hidden', 'id' => 'g_keiyaku_to'));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('Productaddfrm', ['id' => 'Productaddfrm', 'url' => ['controller' => 'AdminProductsite', 'action' => 'add']]);
				echo $this->Form->input('gyosyunm', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('kaiinsbnm', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
				echo $this->Form->input('openstate', array('type' => 'hidden','value'=>$openstate));
				echo $this->Form->input('registrationstate', array('type' => 'hidden','value'=>$registrationstate));
				echo $this->Form->input('Kikanjoutai', array('type' => 'hidden','value'=>$Kikanjoutai));
				echo $this->Form->input('fromdate', array('type' => 'hidden','value'=>$fromdate));
				echo $this->Form->input('todate', array('type' => 'hidden','value'=>$todate));
				// echo $this->Form->input('TPrkeiyakuarno', array('type' => 'hidden', 'id' => 'TPrkeiyakuarno'));
				echo $this->Form->input('g_keiyaku_from', array('type' => 'hidden', 'id' => 'g_keiyaku_from'));
				echo $this->Form->input('g_keiyaku_to', array('type' => 'hidden', 'id' => 'g_keiyaku_to'));
				echo $this->Form->input('kaiincd', array('type' => 'hidden', 'id' => 'kaiincd'));
				echo $this->Form->input('kaisyacd', array('type' => 'hidden', 'id' => 'kaisyacd'));
				echo $this->Form->input('kaisyanm', array('type' => 'hidden', 'id' => 'kaisyanm'));
				echo $this->Form->input('selectedOrder', array('type' => 'hidden','value'=>$selectedOrder));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('ProductSearchForm', ['id' => 'ProductSearchForm','url' => ['controller' => 'AdminProductsite', 'action' => 'search']]);?>
			<div class="search-area kaiinSearch">
				<div class="category-search kaiinSearch-left width96p padR0p">
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
				<div class="freeword-search category-search width96p kaiinSearch-right padR0p flex315">
					<h2>フリーワード検索で探す</h2>
					<div style="padding-top: 10px;">
						<ul>
							<?php foreach($searchTypeList as $key => $searchType):?>
								<li class="radbtnpad"><input type="radio" name="free_radio" class="radio" value="<?php echo $key;?>" id="fr-<?php echo $key;?>" <?php if($key == $freewordTypeChk){echo "checked";}?>><label for="fr-<?php echo $key;?>"><?php echo $searchType;?></label></li>
							<?php endforeach;?>
						</ul>
						<?php echo $this->Form->input('', array('type' => 'text','name'=>'free_word','style'=>'width : 300px;padding: 0.2em 0.4em;','value'=> $keywordVal)); ?>
					</div>
				</div><!-- /.freeword-search -->
				<div class="freeword-search category-search width96p kaiinSearch-right flex280 padR0p">
					<h2>状態で探す</h2>
					<ul style="margin-top:17px;"><h4>公開状態  &nbsp; &nbsp;</h4>
						<li class="fontsize radbtnpad"><input type="radio" name="openstate" id="openstate1" value='' <?php echo $openstateChk1; ?>><label for="openstate1">全て</label></li>
						<li class="fontsize radbtnpad"><input type="radio" name="openstate" id="openstate2" value='0' <?php echo $openstateChk2; ?>><label for="openstate2">公開</label></li>&nbsp;&nbsp;
						<li class="fontsize radbtnpad"><input type="radio" name="openstate" id="openstate3" value='1' <?php echo $openstateChk3; ?>><label for="openstate3">非公開</label></li>
					</ul>
					<ul style="margin-top:15px;"><h4>PR登録 &nbsp; &nbsp; &nbsp;</h4>
						<li class="fontsize radbtnpad"><input type="radio" name="registrationstate" id="registrationstate1" value='' <?php echo $registrationstateChk1; ?>><label for="registrationstate1">全て</label></li>
						<li class="fontsize radbtnpad"><input type="radio" name="registrationstate" id="registrationstate2" value='0' <?php echo $registrationstateChk2; ?>><label for="registrationstate2">有り</label></li>&nbsp;&nbsp;
						<li class="fontsize radbtnpad"><input type="radio" name="registrationstate" id="registrationstate3" value='1' <?php echo $registrationstateChk3; ?>><label for="registrationstate3">無し</label></li>
					</ul>
					<ul style="margin-top:15px;"><h4>期間状態 &nbsp; &nbsp; </h4>
						<li class="fontsize radbtnpad"><input type="radio" name="Kikanjoutai" id="Kikanjoutai1" value='' <?php echo $KikanjoutaiChk1; ?>><label for="Kikanjoutai1">全て</label></li>
						<li class="fontsize radbtnpad"><input type="radio" name="Kikanjoutai" id="Kikanjoutai2" value='0' <?php echo $KikanjoutaiChk2; ?>><label for="Kikanjoutai2">期間内</label></li>
						<li class="fontsize radbtnpad"><input type="radio" name="Kikanjoutai" id="Kikanjoutai3" value='1' <?php echo $KikanjoutaiChk3; ?>><label for="Kikanjoutai3">期間外</label></li>
					</ul>
				</div><!-- /.freeword-search -->
				<div class="freeword-search kaiinSearch-right flex240">
					<h2 style="margin: 0;">公開期間で探す</h2>
					<ul><h4 style="padding-top: 15px">開始</h4>
						<li style="padding-top: 4px">
							<?php echo $this->Form->input('fromdate', array('class'=>'datepicker', 'name' => 'fromdate','id' => 'fromdate','label' => false,'size' => '8', 'type'=>'text','value' => $fromdate,'maxlength' => '10', 'style' => 'padding: 0.05em 0.4em;')); ?>
						</li>
					</ul>
					<ul><h4 style="padding-top: 11px">終了</h4>
						<li style="margin: 0;">
							<?php echo $this->Form->input('todate', array('class'=>'datepicker', 'name' => 'todate', 'id' => 'todate','label' => false,'size' => '8','type'=>'text','value' => $todate,'maxlength' => '10', 'style' => 'padding: 0.05em 0.4em;')); ?>
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
														'controller' => 'AdminProductsite',
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
						<th class="wd9p">会員名</th>
						<th class="wd9p">担当者名</th>
						<th class="wd15p">商品・サービス名</th>
						<th class="wd7p">公開状態</th>
						<th class="wd6p">表示順</th>
						<th style="min-width: 172px;">公開期間</th>
						<th></th>
					</tr>
					<?php
					$kaisyanm ="";
					// $kaiinnmGC ="";
					foreach($searchinfo as $searchVal): ?>
						<tr>
							<td><?php if($kaisyanm != $searchVal['TKaisya']['kaisyacd']) { echo $searchVal['TKaisya']['kaisyanm']; $kaisyanm = $searchVal['TKaisya']['kaisyacd']; } ?></td>
							<td>
								<?php echo str_replace(',', '<BR>', $searchVal['tkn']['kaiinnmGC']); ?>
							</td>
							<td><?php echo $searchVal['TPrtantou']['tantounm']; ?></td>
							<td><?php echo nl2br($searchVal['tpr']['syohinnm']); ?></td>
							<td><?php echo $searchVal['mkou']['koukainm']; ?></td>
							<td style="text-align: center;"><?php echo $searchVal['tpr']['hyojino']; ?></td>
							<td><?php if($searchVal['tpr']['kikanfrom']) { echo date('Y/m/d', strtotime($searchVal['tpr']['kikanfrom']))." ～ ".date('Y/m/d', strtotime($searchVal['tpr']['kikanto'])); } ?></td>
							<td>
							<?php 
								if( isset($searchVal['TPrkeiyaku']['foradd']) && $searchVal['TPrkeiyaku']['foradd'] == "1" ) {
									// echo $searchVal['TPrkeiyaku']['g_keiyaku_from'];echo "<BR>";
									// echo $searchVal['TPrkeiyaku']['g_keiyaku_to'];echo "<BR>";
									// if(date("Y/m/d") <= date('Y/m/d', strtotime($searchVal['TPrkeiyaku']['g_keiyaku_to'])) && date("Y/m/d") >= date('Y/m/d', strtotime($searchVal['TPrkeiyaku']['g_keiyaku_from']))) {
										echo $this->Form->button("追加", 
											array('class' =>'button edit addValue','name' =>'addValue', 
												// 'data-TPrkeiyakuarno' => $searchVal['TPrkeiyaku']['arno'],
												'data-g_keiyaku_from' => $searchVal['TPrkeiyaku']['g_keiyaku_from'],
												'data-g_keiyaku_to' => $searchVal['TPrkeiyaku']['g_keiyaku_to'],
												'data-kaiincd' => $searchVal['tkn']['kaiincd'],
												'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
												'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
												'controller' => 'AdminProductsite','action'=> 'add'));
								} else {
										echo $this->Form->button("追加", 
											array('class' =>'button edit addValue','style'=>'visibility: hidden;','name' =>'addValue', 
												// 'data-TPrkeiyakuarno' => $searchVal['TPrkeiyaku']['arno'],
												'data-kaiincd' => $searchVal['tkn']['kaiincd'],
												'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
												'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
												'controller' => 'AdminProductsite','action'=> 'add'));
									// }
								}
								if($searchVal['tpr']['syohinnm']!="") {
									// echo $searchVal['TPrkeiyaku']['g_keiyaku_from_edit'];
									// echo $searchVal['TPrkeiyaku']['g_keiyaku_to_edit'];
									echo $this->Form->button("編集", 
										array('class' =>'button edit editValue','name' =>'editValue', 
											'data-arno' => $searchVal['tpr']['arno'],
											// 'data-TPrkeiyakuarno' => $searchVal['TPrkeiyaku']['arno'],
											'data-g_keiyaku_from' => $searchVal['TPrkeiyaku']['g_keiyaku_from_edit'],
											'data-g_keiyaku_to' => $searchVal['TPrkeiyaku']['g_keiyaku_to_edit'],
											'data-kaiincd' => $searchVal['tkn']['kaiincd'],
											'data-kaisyacd' => $searchVal['TKaisya']['kaisyacd'],
											'data-kaisyanm' => $searchVal['TKaisya']['kaisyanm'],
											'controller' => 'AdminProductsite','action'=> 'edit'));
									echo $this->Form->button("削除", 
										array('class' =>'button delete','name' =>'delete',
											'data-arno' => $searchVal['tpr']['arno'],
											// 'data-TPrkeiyakuarno' => $searchVal['TPrkeiyaku']['arno'],
											'controller' => 'AdminProductsite','action'=> 'delete'));
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
