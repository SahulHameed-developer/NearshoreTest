<!doctype html>
<title>出欠情報（イベント）：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('admin/Attendance/style.css') ?>
<?= $this->Html->script('admin/attendance/list.js') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<style type="text/css">
#wrapper { padding: 0%;
 }
#wrap{ 
    float: left;
    position: relative;
    margin: 10%;
    width: 40%; 
}
#fixed{ 
    position:fixed;
    width:inherit;
    padding:0px; 
    height:10px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm' });
});
</script>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display:inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>出欠情報（イベント）</li>
			</ol><!-- /.breadcrumbs -->
			<div class="breadcrumbs f_right"><a style="cursor:pointer;" class="backtohome">メニューに戻る</a></div>
			<h1 class="main-title">出欠情報（イベント）</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('adminAttendance', ['id' => 'AdminAttendance', 'name' => 'AdminAttendance', 'url' => ['controller' => 'AdminAttendance', 'action' => 'search']]);
				echo $this->Form->input('count', array('name' => 'count','id' => 'count','type' => 'hidden','value' => $count));?>
			<div class="search-area">
				<div class="freeword-search flex420">
					<div class="w100p">
						<div class="inlineblk w20p">
							<span class="fnt14 mr20 fwb">年月</span>
						</div>
						<div class="inlineblk" style="width: 77%;">
							<span class="inlineblk">
								<?php echo $this->Form->input('attenDtFrm',array('type'=>'text',
																'class'=>'datepickerfmt',
																'style' =>'width:130px !important;',
																'label'=>false,
																'id'=>'attenDtFrm',
																'name'=>'attenDtFrm',
																'value'=>$attenDtFrm));?>
							</span>
							<span style="margin-right:10px;">～</span>
							<span class="inlineblk">
								<?php echo $this->Form->input('attenDtTo',array('type'=>'text',
													          'class'=>'datepickerfmt',
															  'style' =>'width:130px !important;',
															  'label'=>false,
															  'id'=>'attenDtTo',
															  'name'=>'attenDtTo',
															  'value'=>$attenDtTo));?>
							</span>
						</div>
						<div id="dateFmtError" class="dateFmtError"></div>
					</div>
					<div class="w100p mt10">
						<div class="inlineblk w20p">
							<span class="fnt14 mr20 fwb">会員種別</span>
						</div>
						<div class="inlineblk" style="width: 77%;">
							<span class="select-wrap">
								<?php echo $this->Form->input('kaiinsbnm',array(
															  'type'=>'select',
															  'options'=>$kaiinsbnm, 
															  'value'=>$kaiinsbname,
															  'empty'=>"会員種別を選択してください。",
															  'style' =>'width:auto;padding:6px 25px 4px 10px !important;',
															  'label'=>false,
															  'name'=>'kaiinsbnm'));?>
							</span>
						</div>
					</div>

					<div class="w100p mt20">
						<div class="inlineblk w20p vat">
							<span class="fnt14 mr20 fwb">役職</span>
						</div>
						<div class="inlineblk" style="width: 77%;">
							<ul>
								<li class="fontsize"><input type="radio" name="Yakushoku" id="Yakushoku1" value="0" 
									<?php echo $YakushokuChk1; ?>><label for="Yakushoku1">全て</label></li>
								<li class="fontsize"><input type="radio" name="Yakushoku" id="Yakushoku2" value="1"
									<?php echo $YakushokuChk2; ?>><label for="Yakushoku2">役職者のみ</label></li>
								<li class="fontsize"><input type="radio" name="Yakushoku" id="Yakushoku3" value="2"
									<?php echo $YakushokuChk3; ?>><label for="Yakushoku3">役職者以外</label></li>
							</ul>
						</div>
					</div>

					<div class="w100p">
						<div class="inlineblk w20p">
							<span class="fnt14 mr20 fwb">会員名</span>
						</div>
						<div class="inlineblk" style="width: 78%;">
							<?php echo $this->Form->input('kaiinmei', array('name'=>'kaiinmei','id' => 'kaiinmei','label' => false,'style' =>'width:310px;','type'=>'text','placeholder'=>"会員名(漢字)を入力してください。",
								'value' => $kaiinmei)); ?>
						</div>
					</div>

				</div><!-- /.category-search -->
				<div class="freeword-search flex740">
					<div class="w100p searchcontrol">
						<div class="inlineblk vat" style="width: 11%;">
							<span class="fnt14 mr20 fwb">活動分類</span>
						</div>
						<div class="inlineblk" style="width: 88%;">
							<ul>
								<li class="fontsize"><input type="radio" name="katsudo" id="katsudo1" value="0" 
									<?php echo $katsudoRadio1; ?>><label for="katsudo1">全て</label></li>
								<li class="fontsize"><input type="radio" name="katsudo" id="katsudo2" value="1"
									<?php echo $katsudoRadio2; ?>><label for="katsudo2">個別</label></li>
							</ul>
						</div>
						<div class="inlineblk searchcontrolcheckbox" style="width: 88%;padding-left: 87px;">
							<ul class="fnt14 mt10" style="display: inline-block;">
							<?php foreach ($kbunruinm as $key => $kbunruinmvalue) { ?>
								<li class="fontsize" style="display: inline-block;">
									<input 
										type="checkbox" 
										<?php if (isset($katsudoRadio1) && $katsudoRadio1!="") { ?> disabled="disabled"<?php } ?>
										name="Katsudoucheck[]" id="Katsudoucheck_<?php echo $key ?>" 
										value="<?= $key ?>"
										class="check"
										<?php if (isset($Katsudoucheck) && $Katsudoucheck!="") { 
											if(in_array($key, $Katsudoucheck)) {?> checked <?php } } 
										?> >
									<label for="Katsudoucheck_<?php echo $key ?>" class="checkdisable<?php if (isset($katsudoRadio2) && $katsudoRadio2!="") {?> active cursorpointer<?php } ?>">
										<?php echo $kbunruinmvalue;?>
									</label>
								</li>
								<div id="fixed"></div>
							<?php } ?>
							</ul>
						</div>
					</div>
					<div class="w100p" style="margin-top: 5px;">
						<div class="inlineblk" style="width: 11%;">
							<span class="fnt14 mr20 fwb">出席率</span>
						</div>
						<div class="inlineblk" style="width: 88%;">
							<div class="inlineblk">
								<?php echo $this->Form->input('textbox', array('name' => 'Shussekikaisu', 
								'id' => 'Shussekikaisu', 'label' => false,'type'=>'text', 'maxlength' => 5, 'style'=>'width:100px;','value' =>
								$Shussekikaisu)); ?>
							</div>
							<span class="inlineblk fnt14 mr20">％</span>
							<div class="inlineblk vam">
								<ul>
									<li class="fontsize"><input type="radio" name="Shussekiritsu" id="Shussekiritsu1" value="0" <?php echo $Shussekiritsu1; ?>><label for="Shussekiritsu1">以上</label></li>
									<li class="fontsize"><input type="radio" name="Shussekiritsu" id="Shussekiritsu2" value="1"  <?php echo $Shussekiritsu2; ?>><label for="Shussekiritsu2">以下</label></li>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- /.freeword-search -->
			</div><!-- /.search-area -->
			<div class="search-btn">
				<?php echo $this->Form->button("検索", array('class' =>'b-search'));?>
			</div>
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if(!empty($attenInfo)):?>
			<div class="w100p">	
				<div class="inlineblk w100p" style="text-align: right;">
					<label>表示順序</label>
					<div class="select-wrap">
						<?php echo $this->Form->input('narabijun',array('type'=>'select',
																	'label'=>false,
																	'options'=>$narabijun,
																	'value'=>$selectednarabi,
																	'style' =>'width:150px;',
																	'id'=>'narabijun',
																	'name'=>'narabijun'));?>
					</div>
				</div>
			</div>
			<div class="newslist-list-table">
				<?php
					$tdwidth = 100/(count($activityList)+5);
				?>
			<table style="width: 100%;">
					<tbody>
						<tr> 
							<th style="width : <?php echo $tdwidth; ?>% !important;" rowspan="2">氏<BR>名</th>
							<th style="width : <?php echo $tdwidth; ?>% !important;" rowspan="2">会<BR>員<BR>種<BR>別</th>
							<th style="width : <?php echo $tdwidth; ?>% !important;" rowspan="2">協<BR>会<BR>役<BR>職</th>
							<th style="width : <?php echo $tdwidth; ?>% !important;" rowspan="2">所<BR>属<BR>組<BR>織</th>
							<th style="width : <?php echo $tdwidth; ?>% !important;">総<BR>回<BR>数</th>
							<?php foreach ($activityList as $key => $kbunruinmvalue) { ?>
							<?php if($Katsudoucheck=="") { ?>
							<th style="width : <?php echo $tdwidth; ?>% !important;"><?php 
									$japanese2 = mb_convert_encoding($kbunruinmvalue, "UTF-16", "UTF-8");
									$length = mb_strlen($japanese2, "UTF-16");
									for($i=0; $i<$length; $i++) {
									    $char = mb_substr($japanese2, $i, 1, "UTF-16");
									    $utf8 = mb_convert_encoding($char, "UTF-8", "UTF-16");
									    echo $utf8 . "<BR>";
									}
								?>
							</th>
							<?php } else { ?>
							<?php if (in_array($key, $Katsudoucheck)) { ?>
							<th style="width : <?php echo $tdwidth; ?>% !important;"><?php
									$japanese2 = mb_convert_encoding($kbunruinmvalue, "UTF-16", "UTF-8");
									$length = mb_strlen($japanese2, "UTF-16");
									for($i=0; $i<$length; $i++) {
									    $char = mb_substr($japanese2, $i, 1, "UTF-16");
									    $utf8 = mb_convert_encoding($char, "UTF-8", "UTF-16");
									    echo $utf8 . "<BR>";
									} ?></th>
							<?php } } } ?>
						</tr>
						<tr style="border-top : 1px solid white; ">
							<th ><?php echo $katudoCnt; ?></th>
							<?php foreach ($kbunruicnttop as $key => $kbunruicnttop) {?>
							<th>
								<?php 
								if (isset($kbunruicnttop[0][0]['cnt'])) {
									echo $kbunruicnttop[0][0]['cnt'];
								}
								?>
							</th>
							<?php } ?>
						</tr>
						<?php $i=0; foreach ($attendanceData as $key => $attenInfo) { ?>
						<tr>
							<td>
							<?php
								if (isset($attenInfo['kaiinnm'])) {
								 	echo $attenInfo['kaiinnm']; 
								 } 
							?>
							</td>
							<td>
								<?php
									if(isset($attenInfo['kaiinsbnm'])) {
										echo $attenInfo['kaiinsbnm'];
									}
								?>
							</td>
							<td>
								<?php
									if(isset($attenInfo['kyoukaiyknm'])) {
										echo $attenInfo['kyoukaiyknm'];
									}
								?>
							</td>
							<td>
								<?php
									if(isset($attenInfo['sosikirs'])) {
										echo $attenInfo['sosikirs'];
									}
								?>
							</td>
							<td class="tac">
								<?php	
									if(isset($attenInfo['event']['total']) && $attenInfo['event']['total'] != 0) {
										echo $attenInfo['event']['total'];
									}
								?>
							</td>
							<?php foreach ($activityList as $evtKey => $kbunruinmvalue) { ?>
							<?php if ($Katsudoucheck=="") { ?>
							<td class="tac"><?php if(isset($attenInfo['event'][$evtKey]) && $attenInfo['event'][$evtKey] != 0) {
								echo $attenInfo['event'][$evtKey]; } ?></td>
							<?php } else if (in_array($evtKey, $Katsudoucheck)) { ?>
							<td class="tac"><?php if(isset($attenInfo['event'][$evtKey]) && $attenInfo['event'][$evtKey] != 0) {
								echo $attenInfo['event'][$evtKey]; } ?></td>
							<?php } ?>
							<?php } ?>
						</tr>
						<?php $i++; } ?>
					</tbody>
			</table>
			<?php endif; ?>
			<?php echo $this->Form->end();?>
			</div><!-- /.list-table -->
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->

</body>
</html>