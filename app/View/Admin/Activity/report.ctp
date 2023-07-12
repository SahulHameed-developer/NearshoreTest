<!doctype html>
<title>活動報告一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->element('monthpicker'); ?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('admin/activity/report.js') ?>
<script type="text/javascript">
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.appendTo('#selectError');
		}
	});
	$(document).ready(function() {
		$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm' });
	});
</script>
<style>
	.f_right {
    	display: block;
    	float: right;
    }
</style>
<!-- ========== nav ========== -->
<!-- ========== /nav ========== -->

<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->

<!-- ========== main ========== -->
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>活動報告一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">活動報告一覧</h1>
			<?php if(!isset($selectedKbunruinm)): $selectedKbunruinm = ""; endif;?>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create(null, ['id' => 'report','url' => ['controller' => 'adminActivity', 'action' => 'activityReportSearch']]);
				echo $this->Form->input('searchcon',array('type'=>'hidden','id'=>'searchcon','id'=>'searchcon'));?>
			<div class="report-search-area">
				<div class="conference-search">
					<h2>会議を探す</h2>
					<p>会議の種別や開催年月から絞り込むことができます。</p>
					<div class="select-wrap1">
						<div style="display: inline-block;">
								<?php echo $this->Form->input('sosikinm',array('type'=>'select','options'=>$sosikinm, 
									'label'=>false,
									'value'=>$selectedsosikinm,
									'empty'=> '会議の種別を選択してください','class'=>'select_type','id'=>'conference'));?>
						</div>
					</div>
					<table style="margin-top: 20px;">
						<tr>
							<td>
								<?php echo $this->Form->input('kaigiFrom',array('class'=>'datepickerfmt','type'=>'text','label'=>false,'value'=>$koushindt1,'name'=>'kaigiFrom','id'=>'kaigiFrom','style'=>'width:140px;',
									'maxlength' => '7'));?>
							</td>
							<td>
								<span>～</span>
							</td>
							<td>
								<?php echo $this->Form->input('kaigiTo',array('class'=>'datepickerfmt','type'=>'text','label'=>false,'value'=>$koushindt2,'name'=>'kaigiTo','id'=>'kaigiTo','style'=>'width:140px;','maxlength' => '7'));?>
							</td>
						</tr>
					</table>
					<div class="report-search-btn">
						<?php echo $this->Form->button("検索", array('class' =>'submit kaigibtn button','name' =>'kaigibtn','controller' => 'adminactivity','action'=> 'activityReportSearch'));?>
					</div>
				</div><!-- /.conference-search -->
				<div class="event-search">
					<h2>イベントを探す</h2>
					<p>イベントの種別や開催年月から絞り込むことができます。</p>
					<div class="select-wrap1">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('kbunruinm',array('type'=>'select','options'=>$kbunruinm,'label'=>false,'value'=>$selectedKbunruinm,
								'empty'=> 'イベントの種別を選択してください','class'=>'select_type',
								'id'=>'event'));?>
						</div>
					</div>
					<table style="margin-top: 20px;">
						<tr>
							<td>
								<?php echo $this->Form->input('eventFrom',array('class'=>'datepickerfmt','type'=>'text','label'=>false,'value'=>$eventdt1,'id'=>'eventFrom','name'=>'eventFrom','style'=>'width:140px;','maxlength' => '7'));?>
							</td>
							<td>
								<span>～</span>
							</td>
							<td>
								<?php echo $this->Form->input('eventTo',array('class'=>'datepickerfmt','type'=>'text','label'=>false,'value'=>$eventdt2,'id'=>'eventTo','name'=>'eventTo','style'=>'width:140px;','maxlength' => '7'));?>
							</td>
						</tr>
					</table>
					<div class="report-search-btn">
						<?php echo $this->Form->button("検索", array('class' =>'submit eventbtn button','name' =>'eventbtn','controller' => 'adminactivity','action'=> 'activityReportSearch'));?>
					</div>
				</div><!-- /.event-search -->
			</div><!-- /.calender-search-area -->
			<div id="selectError" style="text-align:center;" class="selectError"></div>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminActivitydeleteFrm', ['id' => 'adminActivitydeleteFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'deletereport']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('syasinkey', array('type' => 'hidden'));
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$koushindt1));
				echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$koushindt2));
				echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$eventdt1));
				echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$eventdt2));
				echo $this->Form->input('searchcon',array('type'=>'hidden','value'=>$searchcon));
			echo $this->Form->end(); ?>
			<div class="calender-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if(!empty($katoinfo)):?>
			<table>
				<tbody>
				<tr>
					<th style="min-width: 76px;" class="wd10p">日付</th>
					<th class="wd18p">種別</th>
					<th>会議・イベント名称</th>
					<th style="min-width: 70px;">公開状態</th>
					<th <?php if ($this->Session->read('Auth.User.TKengen.khoutouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA){ ?> style="<?php if($this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kkanjikbn')){ ?> min-width: 310px !important; <?php } else { ?> min-width: 230px !important;<?php } ?>" <?php } else { ?>  class="wd9p" <?php } ?> ></th>
				</tr>
				<?php 
				if(!empty($katoinfo)): foreach($katoinfo as $katoinformation):?>
				<tr class="wordbreak">
					<td><?php echo str_replace('-', '/', substr($katoinformation['TKatudo']['kaisaidate'], 0, 10)); ?></td>
					<?php if (isset($katoinformation['mkbun']['sosikinm'])) { ?>
						<td><?php echo $katoinformation['mkbun']['sosikinm'];?></td>
					<?php } else if (isset($katoinformation['mkbun']['kbunruinm'])) { ?>
						<td><?php echo $katoinformation['mkbun']['kbunruinm'];?></td>
					<?php } else {?>
						<td></td>
					<?php } ?>
					<td><?php echo $katoinformation['TKatudo']['meisyou']; ?></td>
					<td><?php echo $katoinformation['mkou']['koukainm'];?></td>
					<td style="text-align: center;"><?php if ($this->Session->read('Auth.User.TKengen.khoutouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA): 
							echo $this->Form->button("編集", 
										array('class' =>'edit',
										'data-arno' => $katoinformation['TKatudo']['arno'],
										'data-syasinkey' => $katoinformation['TKatudo']['syasinkey']
							));
							echo $this->Form->button("流用", 
										array('class' =>'edit add_2',
										'data-arno' => $katoinformation['TKatudo']['arno'],
										'data-syasinkey' => $katoinformation['TKatudo']['syasinkey'],
										'data-divert' => 1
							));
							if($this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kkanjikbn')):
							echo $this->Form->button("出欠",
									array('class' =>'attendanceReport',
										'name' => 'attendance',
										'data-arno' => $katoinformation['TKatudo']['arno'],
										'data-hdn_bunruicd' => $this->request->data['MSosiki']['searchcon'],
										'data-meisyou' => $katoinformation['TKatudo']['meisyou']
									));
							endif;
							echo $this->Form->button("削除",
									array('class' =>'button delete reportSakujo',
										'name' => 'delete',
										'data-arno' => $katoinformation['TKatudo']['arno'],
										'data-syasinkey' => $katoinformation['TKatudo']['syasinkey']
									));
						elseif ($this->Session->read('Auth.User.TKengen.khoukoukai') == 1):
							echo $this->Form->button("編集",
									array('class' =>'edit',
									'data-arno' => $katoinformation['TKatudo']['arno'],
									'data-syasinkey' => $katoinformation['TKatudo']['syasinkey']
							));
						endif; ?>
					</td>
				</tr>
				<?php endforeach; else: ?>
				<?php endif; ?>
				</tbody>
			</table>
			<?php endif; ?>
			</div><!-- /.list-table -->
			<?php echo $this->Form->create('adminActivityeditFrm', ['id' => 'adminActivityeditFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'editreport']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('syasinkey', array('type' => 'hidden'));
				echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$koushindt1));
				echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$koushindt2));
				echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$eventdt1));
				echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$eventdt2));
				echo $this->Form->input('searchcon', array('type' => 'hidden','value'=>$searchcon));
				echo $this->Form->input('divert', array('type' => 'hidden'));
			echo $this->Form->end(); ?>
			<?php 
				echo $this->Form->create('adminActivityAttendanceFrm', ['id' => 'adminActivityAttendanceFrm', 'url' => ['controller' => 
					'adminActivity', 'action' => 'attendancereport']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('meisyou', array('type' => 'hidden'));
				//活動報告一覧の隠しボックス
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$koushindt1));
				echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$koushindt2));
				echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$eventdt1));
				echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$eventdt2));
				echo $this->Form->input('searchcon', array('type' => 'hidden','value'=>$searchcon));
				echo $this->Form->input('calenderType', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('hdn_bunruicd', array('type' => 'hidden'));
				echo $this->Form->end(); ?>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>