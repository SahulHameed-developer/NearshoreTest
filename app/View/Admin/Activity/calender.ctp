<!doctype html>
<title>活動カレンダー一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('admin/activity/list.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<!-- ========== /header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<script type="text/javascript">
$(document).ready(function() {
	$(".edit").click(function () {
		$( "#list" ).submit();
	});
	$(".kaigisrch").click(function(){
		$("#srch").val(1);
	});
	$(".eventsrch").click(function(){
		$("#srch").val(2);
	});
});
</script>
<style>
	.f_right {
    	display: block;
    	float: right;
    }
</style>
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>活動カレンダー一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<h1 class="main-title">活動カレンダー一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'adminActivity', 'action' => 'search']]);
			echo $this->Form->input('srch', array('type' => 'hidden','id' => 'srch','class' =>'')); ?>
			<div class="calender-search-area">
				<div class="conference-search">
					<h2>会議を探す</h2>
					<p>プルダウンから会議を絞り込むことができます。</p>
					<div class="select-wrap">
						<div style="display: inline-block;">
								<?php echo $this->Form->input('sosikinm',array('type'=>'select','options'=>$sosikinm, 
									'label'=>false,
									'value'=>$selectedsosikinm,
									'empty'=> '会議の種別を選択してください','class'=>'select_type','id'=>'conference'));?>
						</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->button("検索", array('class' =>'button kaigisrch','name' =>'kaigibtn','controller' => 'adminactivity','action'=> 'search'));?>
						</div>						
					</div>
				</div><!-- /.conference-search -->
				<div class="event-search">
					<h2>イベントを探す</h2>
					<p>プルダウンからイベントを絞り込むことができます。</p>
					<div class="select-wrap">
						<div style="display: inline-block;">
							<?php echo $this->Form->input('kbunruinm',array('type'=>'select','options'=>$kbunruinm,'label'=>false,
								'value'=>$selectedKbunruinm,
								'empty'=> 'イベントの種別を選択してください','class'=>'select_type',
								'id'=>'event'));?>
						</div>
						<div style="display: inline-block;">
							<?php echo $this->Form->button("検索", array('class' =>'button eventsrch','name' =>'eventbtn','controller' => 'adminactivity','action'=> 'search'));?>						
						</div>
					</div>
				</div><!-- /.event-search -->
			</div><!-- /.calender-search-area -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('shosaiShutokuFrm', ['id' => 'shosaiShutokuFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'edit']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('srch', array('type' => 'hidden','id' => 'srch','class' => 'srch','value' => $this->Session->read('srchcondition')));
			echo $this->Form->end();?>
			<?php echo $this->Form->create('shosaiSakujoFrm', ['id' => 'shosaiSakujoFrm', 'url' => ['controller' => 'adminActivity', 'action' => 'delete']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('srch', array('type' => 'hidden','id' => 'srch','value' => $this->Session->read('srchcondition')));
			echo $this->Form->end();?>
			<div class="calender-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if(!empty($katoinfo)): ?>
				<table>
					<tbody>
					<tr>
						<th style="min-width: 76px;" class="wd10p">日付</th>
						<th class="wd18p">種別</th>
						<th>会議・イベント名称</th>
						<th style="min-width: 70px;">公開状態</th>
						<th <?php if ($this->Session->read('Auth.User.TKengen.kcaltouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA){ ?> style="<?php if($this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kkanjikbn')){ ?> min-width: 310px !important; <?php } else { ?> min-width: 230px !important;<?php } ?>" <?php } else { ?>  class="wd9p" <?php } ?> ></th>
					</tr>
					<?php if(!empty($katoinfo)): foreach($katoinfo as $katoinformation): ?>
					<tr class="wordbreak">
						<td>
							<?php echo date('Y/m/d', strtotime($katoinformation['TKatudo']['kaisaidate']));?>
						</td>
						<?php if (isset($katoinformation['mkbun']['sosikinm'])) { ?>
							<td><?php echo $katoinformation['mkbun']['sosikinm'];?></td>
						<?php } else if (isset($katoinformation['mkbun']['kbunruinm'])) { ?>
							<td><?php echo $katoinformation['mkbun']['kbunruinm'];?></td>
						<?php } else { ?>
							<td></td>
						<?php } ?>
						<td><?php echo $katoinformation['TKatudo']['meisyou']; ?></td>
						<td><?php echo $katoinformation['mkou']['koukainm'];?></td>
						<td style="text-align: center;"><?php if ($this->Session->read('Auth.User.TKengen.kcaltouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA): 
								echo $this->Form->button("編集", 
											array('class' =>'button edit shosaiShutoku',
													'name' => 'edit',
													'data-arno' => $katoinformation['TKatudo']['arno']
								));
								echo $this->Form->button("流用", 
											array('class' =>'button edit shosaiTouroku',
													'name' => 'add_2',
													'data-arno' => $katoinformation['TKatudo']['arno']
								));
								if($this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKaiin.kkanjikbn')):
								echo $this->Form->button("出欠",
											array('class' =>'attendanceReport',
												'name' => 'attendance',
												'data-arno' => $katoinformation['TKatudo']['arno'],
												'data-hdn_bunruicd' => $this->Session->read('srchcondition'),
												'data-meisyou' => $katoinformation['TKatudo']['meisyou']
											));
								endif;
								echo $this->Form->button("削除",
										array('class' =>'button delete shosaiSakujo',
												'name' => 'delete',
												'data-arno' => $katoinformation['TKatudo']['arno']
										));
							elseif($this->Session->read('Auth.User.TKengen.kcalkoukai') == 1): 
								echo $this->Form->button("編集",
										array('class' =>'button edit shosaiShutoku',
												'name' => 'edit',
												'data-arno' => $katoinformation['TKatudo']['arno']
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
			<?php 
				echo $this->Form->create('adminActivityAttendanceFrm', ['id' => 'adminActivityAttendanceFrm', 'url' => ['controller' => 
					'adminActivity', 'action' => 'attendancereport']]);
				echo $this->Form->input('arno', array('type' => 'hidden'));
				echo $this->Form->input('meisyou', array('type' => 'hidden'));
				//  活動カレンダー一覧の隠しボックス
				echo $this->Form->input('srch', array('type' => 'hidden','id' => 'srch','class' => 'srch','value' => $this->Session->read('srchcondition')));
				echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedsosikinm));
				echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
				echo $this->Form->input('calenderType', array('type' => 'hidden', 'value' => 0));
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