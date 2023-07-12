<!doctype html>
<title>出欠情報編集：ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker') ?>
<?= $this->html->css('admin/Attendance/style.css') ?>
<?= $this->Html->script('admin/activity/attendance.js') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<style type="text/css">
.attedEvent {
  height: 15px;
  width: 20px;
  background-color: #228B22;

}
.notAttedEvent {
  height: 15px;
  width: 20px;
  background-color: #ccc;
}
.searchbtn {
  margin-top: 30px !important;
  margin-left: 260px!important;
}
.attandancebtn {
  width: 19%;
  padding: 10px 10px 10px 10px;
  word-wrap: break-word;
  vertical-align: top;
}
.notAttandanceColor {
  background-color: #ccc;
}
.attandanceColor{
	font-weight: bold; 
	background-color: #228B22; 
	color: #FFF;
}
.updatebtn{
	max-width: 360px !important;
}
.updatecls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5pu05paw5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
	background-color: rgba(255, 255, 255, .5);
}
</style>
<div id="updatecls"></div>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display:inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>出欠情報編集</li>
			</ol><!-- /.breadcrumbs -->

			<?php 
				// 戻るリンク名
				$katsudouName = "活動報告一覧に戻る";
				if ($calenderType == 0) { 
					 	$katsudouName = "活動カレンダー一覧に戻る";
				} 
			?>
			<div class="breadcrumbs f_right"><a style="cursor:pointer;" class="katsudoModoruFrm"><?php echo $katsudouName ?></a></div>
			<h1 class="main-title">出欠情報編集（<?php echo $meisyou; ?>）</h1>

			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 
					'action' => 'home']]); echo $this->Form->end();?>
			<!--活動カレンダー一覧の形 -->
			<?php echo $this->Form->create('katsudoModoruFrm', ['id' => 'katsudoModoruFrm', 'url' => ['controller' => 'admin']]); 
					echo $this->Form->input('srch', array('type' => 'hidden','value'=>$srch));
					echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden' ,'value'=>$hdn_bunruicd));
					echo $this->Form->input('hdn_sosikicd', array('type' => 'hidden' ,'value'=>$hdn_sosikicd));
					echo $this->Form->input('hdn_kbunruicd', array('type' => 'hidden' ,'value'=>$hdn_kbunruicd));
				echo $this->Form->end();?>
			<!--活動報告一覧の形 -->
			<?php echo $this->Form->create('MSosiki', ['id' => 'MSosiki', 'url' => ['controller' => 'adminActivity']]);
					echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$hdn_sosikicd));
					echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$hdn_kbunruicd));
					echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$kaigiFrom));
					echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$kaigiTo));
					echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$eventFrom));
					echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$eventTo));
					echo $this->Form->input('searchcons', array('type' => 'hidden','value'=>$searchcon));
				echo $this->Form->end(); ?>

			<?php echo $this->Form->create('adminAttendanceFrm', ['id' => 'adminAttendanceFrm', 'name' => 'adminAttendanceFrm',
					'url' => ['controller' => 'AdminActivity', 'action' => 'attandancesearch']]);
				echo $this->Form->input('kkey', array('name' => 'kkey','id' => 'kkey','type' => 'hidden','value' => $kkey));
				echo $this->Form->input('meisyou', array('name' => 'meisyou','id' => 'meisyou','type' => 'hidden','value' => $meisyou)); 
				echo $this->Form->input('koushinbtn', array('type' => 'hidden')); 

				// set the common value to Activity calendar and report list
				echo $this->Form->input('calenderType', array('name' => 'calenderType','id' => 'calenderType','type' => 'hidden','value' => $calenderType));
				echo $this->Form->input('hdn_bunruicd', array('name' => 'hdn_bunruicd','id' => 'hdn_bunruicd','type' => 'hidden','value' => $hdn_bunruicd));
				echo $this->Form->input('hdn_sosikicd', array('name' => 'hdn_sosikicd','id' => 'hdn_sosikicd','type' => 'hidden','value' => $hdn_sosikicd));
				echo $this->Form->input('hdn_kbunruicd', array('name' => 'hdn_kbunruicd','id' => 'hdn_kbunruicd','type' => 'hidden','value' => $hdn_kbunruicd));

				// set the value to Activity calendar list
				echo $this->Form->input('srch', array('name' => 'srch','id' => 'srch','type' => 'hidden','value' => $srch));

				// set the value to Activity report list
				echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$kaigiFrom));
				echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$kaigiTo));
				echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$eventFrom));
				echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$eventTo));
				echo $this->Form->input('searchcon', array('name' => 'searchcon','id' => 'searchcon','type' => 'hidden','value' => $searchcon));
			?>

			<div style="width: 100%; flex-flow: row; margin-top: 25px; margin-left: 10px;">
				<div class = "inlineblk" style="width: 30%">
					<span class="fnt14 mr20 fwb">会員種別</span>
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
				<div class = "inlineblk" 
						style="width: 30%; border-left: 1px dotted #c0c0c0; padding-left: 30px; border-right: 1px dotted #c0c0c0; ">
					<span class="fnt14 mr20 fwb">組織</span>
					<span class="select-wrap">
						<?php echo $this->Form->input('sosikicd',array(
											'type'=>'select',
											'options'=>$sosiki, 
											'value'=>$sosikinm,
											'empty'=>"組織を選択してください。",
											'style' =>'width:auto;padding:6px 25px 4px 10px !important;',
											'label'=>false,
											'name'=>'sosikicd'));?>
					</span>
				</div>
				<div class = "inlineblk" style="width: 30%; padding-left: 30px;">
					<div style="flex-flow: row;">
						<ul>
							<li class="fontsize" style="float: left; padding-right: 20px;"><span class="fnt14 mr20 fwb">役職</span></li>
							<li class="fontsize" style="float: left; padding-right: 15px;"><input type="radio" name="Yakushoku" 
									id="Yakushoku1" value="0"
								<?php echo $YakushokuChk1; ?>><label for="Yakushoku1">全て</label></li>
							<li class="fontsize" style="float: left; padding-right: 15px;"><input type="radio" name="Yakushoku" 
									id="Yakushoku2" value="1"
								<?php echo $YakushokuChk2; ?>><label for="Yakushoku2">役職者のみ</label></li>
							<li class="fontsize" style="float: left;"><input type="radio" name="Yakushoku" id="Yakushoku3" value="2"
								<?php echo $YakushokuChk3; ?>><label for="Yakushoku3">役職者以外</label></li>
						</ul>
					</div>
				</div>
			</div><!-- /.search-area -->
			<div class="search-btn" style="margin-top: 5px!important;">
				<?php echo $this->Form->button("検索", array('class' =>'b-search searchbtn','type' => 'button'));?>
				<div style = "float: right; margin-right: 5px; margin-top: 11px;">
					<div class = "inlineblk" style="margin-top: 30px !important;"><div class="attedEvent"></div></div>
					<div class = "inlineblk" style="margin-top: 25px !important; margin-right: 20px;">参加/出席</div>
					<div class = "inlineblk" style="margin-top: 30px !important;"><div class="notAttedEvent"></div></div>
					<div class = "inlineblk" style="margin-top: 25px !important;">不参加/欠席</div>
				</div>
			</div>
			<div class="message"><?php echo $this->Session->flash();?></div>
				<table style="width: 100%; margin: 20px auto 60px;">
					<tbody>
						<?php if($empDetails) { ?>
							<div style="margin-left: 4px;">会員氏名をクリックすると、「参加／出席（緑色）」と「不参加／欠席（グレー）」の切り替えができます。</div>
							<?php $i=0; 
							echo '<tr style="align:left !important;"><td>';
								foreach ($empDetails as $key => $attenInfo) { 
									$i++; 
									$color = "notAttandanceColor";
									if ($attenInfo['TEntry']['arno'] && empty($attenInfo['TEntry']['torikesidt'])) {
										$color = "attandanceColor";
									}
									echo $this->Form->input('hnd_attantance', array('type' => 'hidden',
																					'id' => 'hnd_attantance'.$attenInfo['TKaiin']['kaiincd'],
																					'name' => 'hnd_attantance[]',
																					'value' => 0));
									echo $this->Form->input('hnd_kaiincd', array('type' => 'hidden',
																					'id' => 'hnd_kaiincd'.$attenInfo['TKaiin']['kaiincd'],
																					'name' => 'hnd_kaiincd[]',
																					'value' => $attenInfo['TKaiin']['kaiincd']));
									echo $this->Form->button($attenInfo['TKaiin']['kaiinnm'], 
													array(
														'type' => 'button',
														'id' =>$attenInfo['TKaiin']['kaiincd'], 
														'class' =>'b-attend attandancebtn '.$color,
														'data-kaiincd' => $attenInfo['TKaiin']['kaiincd']
													)); ?>
									<?php if($i == 5) { 
								        echo '</td></tr><tr><td>';
								        $i = 0;
								    }
								}
							echo '</td></tr>';
						} ?>
					</tbody>
				</table>
				<!-- /.list-table -->
				<?php if($count > 0) { 
					echo '<div class="register updatebtn"　style="border: 1px solid red;">
						<button type="button" class="katsudoModoruFrm">一覧に戻る</button>';
					echo $this->Form->button("更新", array('class' =>'b-release','type' => 'button','name' => 'update'));
					echo ' </div>';
				} ?>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>