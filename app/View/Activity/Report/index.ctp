<!--header -->
<?php $this->layout="default";?>
<?= $this->element('monthpicker'); ?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('activity/index.js') ?>
<?= $this->Html->script('common/commonMessages.js') ?>
<?= $this->element('messages'); ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
</script>
<!-- header -->
<script type="text/javascript">
$(document).ready(function() {
	$(".datepickerfmt").MonthPicker({  Button: false, MonthFormat: 'yy/mm' });
});
</script>
<?php  /*  echo $this->element('sql_dump'); */?>
<div class="contents_wrap">
	<div class="contents pc_frame">
		<h1 class="h1 wf-roundedmplus1c sp_frame"><span>ニアショアIT協会 活動報告一覧</span></h1>
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'activity', 'action' => 'reportSearch'.$curtime]]);
				echo $this->Form->input('srchtyp', array('id'=>'srchtyp','name'=>'srchtyp','type' => 'hidden','value'=>$srchtyp)); ?>
				<div class="form_contents clearfix">
					<div class="form_wrap f_left_pc">
						<section class="conference_block sp_frame">
							<h2 class="h2_form wf-roundedmplus1c">会議を探す</h2>
							<p class="description">会議の種別や開催年月から絞り込むことができます。</p>
							<div class="select_group">
								<?php echo $this->Form->input('sosikinm',array('type'=>'select','options'=>$sosikinm, 
												'label'=>false,
												'value' => $selectedSosikinm,
												'empty'=> array(''=> array(
														'name' =>'会議の種別を選択してください',
														'value' => '',
														'selected' => TRUE)),
												'class'=>'select_type','id'=>'conference'));?>
							</div><!-- /.select_group -->
							<div class="select_month_group">
								<div class="date">
									<?php echo $this->Form->input('kaigiFrom',array('class'=>'datepickerfmt','type'=>'text',
												'label'=>false,'value'=>$selectedkaigiFrom,
												'id'=>'kaigiFrom','style'=>'width:130px;','maxlength' => '7'));?>
								</div><!-- /.date -->
								<span>〜</span>
								<div class="date">
									<?php echo $this->Form->input('kaigiTo',array('class'=>'datepickerfmt','type'=>'text',
												'label'=>false,'value'=>$selectedkaigiTo,
												'id'=>'kaigiTo','style'=>'width:130px;','maxlength' => '7'));?>
								</div><!-- /.date -->
								<div id="selectError1" class="selectError"></div>
							</div><!-- /.select_month_group -->
							<div class="submit_btn">
								<?php echo $this->Form->submit("検索", array('class' =>'submit kaigibtn','name' =>'kaigibtn','controller' => 'activity','action'=> 'search'.$curtime));?>
							</div>
								</section><!-- /.conference_block -->
							</div><!-- /.form_wrap -->
							<div class="form_wrap f_right_pc">
								<section class="event_block sp_frame">
									<h2 class="h2_form wf-roundedmplus1c">イベントを探す</h2>
										<p class="description">イベントの種別や開催年月から絞り込むことができます。</p>
									<div class="select_group">
										<?php echo $this->Form->input('kbunruinm',array('type'=>'select','options'=>$kbunruinm,'label'=>false,
												'value' => $selectedKbunruinm,
												'empty'=> array(''=> array(
														'name' =>'イベントの種別を選択してください',
														'value' => '',
														'selected' => TRUE)),
												'class'=>'select_type',
												'id'=>'event'));?>
									</div><!-- /.select_group -->
								<div class="select_month_group">
									<div class="date">
										<?php echo $this->Form->input('eventFrom',array('class'=>'datepickerfmt','type'=>'text',
													'label'=>false,'value'=>$selectedeventFrom,
													'id'=>'eventFrom','style'=>'width:130px;','maxlength' => '7'));?>
									</div><!-- /.date -->
									<span>〜</span>
									<div class="date">
										<?php echo $this->Form->input('eventTo',array('class'=>'datepickerfmt','type'=>'text',
													'label'=>false,'value'=>$selectedeventTo,
													'id'=>'eventTo','style'=>'width:130px;','maxlength' => '7'));?>
									</div><!-- /.date -->
								<div id="selectError2" class="selectError"></div>
							</div><!-- /.select_month_group -->
						<div class="submit_btn">
							<?php echo $this->Form->submit("検索", array('class' =>'submit eventbtn','name' =>'eventbtn','controller' => 'activity','action'=> 'search'.$curtime));?>
						</div>
					</section><!-- /.event_block -->
				</div><!-- /.form_wrap -->
			</div><!-- /.form_contents -->
		<?php echo $this->Form->end();?>
		<?php echo $this->Form->create('shosaiJouhouFrm', ['id' => 'shosaiJouhouFrm', 'url' => ['controller' => 'activity', 'action' => 'reportDetail']]);
			echo $this->Form->input('srchtp', array('id'=>'srchtp','name'=>'srchtp','type' => 'hidden','value'=>$srchtyp));
			echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$scroll_val));
			echo $this->Form->input('arno', array('type' => 'hidden')); 
			echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
			echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
			
			echo $this->Form->input('kaigiFrom', array('type' => 'hidden','value'=>$selectedkaigiFrom));
			echo $this->Form->input('kaigiTo', array('type' => 'hidden','value'=>$selectedkaigiTo));
			echo $this->Form->input('eventFrom', array('type' => 'hidden','value'=>$selectedeventFrom));
			echo $this->Form->input('eventTo', array('type' => 'hidden','value'=>$selectedeventTo));
			echo $this->Form->end();
		?>
		<div class="detail_contents">
			<?php if(!empty($katoinfo)): foreach($katoinfo as $katoVal): ?>
				<article class="article type_01">
					<div class="article_wrap sp_frame">
					<?php if ($katoVal['TKatudo']['bunruicd'] == 2) {?>
						<div class="attention_block">
							<div class="attention_item">申込の受付、終了いたしました。</div>
						</div><!-- /.attention_block -->
					<?php }?>
						<div class="month_item">
							<span class="month"><?php echo $katoVal['TKatudo']['hyoudai']; ?></span>
						</div>
						<h2 class="h2"><?php echo $katoVal['TKatudo']['meisyou']; ?></h2>
					<div class="article_block break_line">
						<dl>
							<dt>日時</dt>
							<dd><?php 
								echo $this->Common->getJapDate($katoVal['TKatudo']['kaisaidate']);
								echo date("G:i", strtotime($katoVal['TKatudo']['kaisaitmfrom']));
								echo '〜';
								echo date("G:i", strtotime($katoVal['TKatudo']['kaisaitmto']));?>
							</dd>
						</dl>
						<dl>
							<dt>場所</dt>
							<dd><?php echo nl2br($katoVal['TKatudo']['basyo']); ?></dd>
						</dl>
						<?php if ($katoVal['TKatudo']['bunruicd'] == 1): ?>
						<dl>
							<dt>議題</dt>
							<dd><?php echo nl2br($katoVal['TKatudo']['gidai']); ?></dd>
						</dl>
						<?php endif; ?>
					</div><!-- /.article_block -->
					<div class="event_link_block clearfix">
						<div class="link_item event_detail wf-roundedmplus1c">
							<a href="javascript:;" class="shousaijouhou"
								data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">詳細情報</a>						
						</div>
						</div><!-- /.link_block -->
					</div><!-- /.article_wrap -->
				</article><!-- /.type_01 -->
			<?php endforeach; else: ?>
				<div style="text-align:center;color: red;"><?php echo $this->fetch('SEARCH_NOT_FOUND');?></div>
			<?php endif; ?>
		</div><!-- /.detail_contents -->
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->