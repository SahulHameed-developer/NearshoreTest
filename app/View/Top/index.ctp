<!--header -->
<?php $this->layout="default";?>
<!-- /header -->
<!-- style/index -->
<?= $this->Html->css('index/style.css') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#beneficial_record').on('click', '.beneficial_list_item', function() {
		$("#arno").val($(this).attr("data-arno"));
		$('#Detailfrm').attr('action', 'Beneficial/detail');
		$("#Detailfrm").submit();
	});
	$('#news_record').on('click', '.news_list_item', function() {
		$("#arno").val($(this).attr("data-arno"));
		$("#Detailfrm").submit();
	});
	$('#calender_record').on('click', '.news_list_item', function() {
		if($(this).attr("data-bunruicd") == 2) {
			$("#shosaiShutokuFrmArno").val($(this).attr("data-arno"));
			$("#shosaiShutokuFrm").submit();
		} else {
			$("#shosaiKaigiFrmArno").val($(this).attr("data-arno"));
			$("#shosaiKaigiFrm").submit();
		}
	});
});
</script>
<div class="index_contents frame">
	<article class="catch_copy_box">
		<h2 class="catch_copy wf-roundedmplus1c">ニアショア企業すべての受注を目指して</h2>
		<p class="description"><span class="pc_break"><span>都市部には大きな市場がありますが、地方にはそれがありません。地方にいながら、都市部の巨大市場にアクセスして、事業を活性化しよう！これがニアショアＩＴ協会の狙いです。<BR/>都市部に拠点を置く「フロント企業」と地方に拠点を置く「ニアショア企業」との連携で、地方の受注機会を増やし、平準化する仕組みを提供するのがニアショアＩＴ協会です。<BR/>このような活動を通して、地方における雇用を促進し、地域の活性化に貢献したいと願っています。</span></p>
	</article><!-- /.catch_copy_box -->
	<?php echo $this->Form->create('Detailfrm', ['id' => 'Detailfrm', 'url' => ['controller' => 'news', 'action' => 'detail']]);
		echo $this->Form->input('arno', array('id'=>'arno','type' => 'hidden'));
	echo $this->Form->end(); ?>
	<?php echo $this->Form->create('shosaiShutokuFrm', ['id' => 'shosaiShutokuFrm', 'url' => ['controller' => 'activity', 'action' => 'detail'.$curtime]]);
		echo $this->Form->input('arno', array('type' => 'hidden'));
		echo $this->Form->input('sosikinm', array('type' => 'hidden'));
		echo $this->Form->input('kbunruinm', array('type' => 'hidden'));
		echo $this->Form->input('b_top', array('id' => 'b_top','value' => 'top','type' => 'hidden'));
	echo $this->Form->end(); ?>
	<?php echo $this->Form->create('shosaiKaigiFrm', ['id' => 'shosaiKaigiFrm', 'url' => ['controller' => 'activity', 'action' => 'Kaigidetail'.$curtime]]);
		echo $this->Form->input('arno', array('type' => 'hidden'));
		echo $this->Form->input('b_top', array('id' => 'b_top','value' => 'top','type' => 'hidden'));
	echo $this->Form->end(); ?>

	<section class="index_box">
		<ul class="index_list clearfix">
			<li class="index_item_01">
				<?php echo $this->Html->link($this->Html->tag('h2').
							$this->Html->tag('span', 'Members',array('class' => 'index_bg wf-Istok_web')).
							$this->Html->tag('span', '会員企業',array('class' => 'index_title')),
							array('controller' => 'members','action'=> 'index'),
							array('escape'=>false)); ?>
			</li>
			<li class="index_item_02">
				<?php echo $this->Html->link($this->Html->tag('h2').
							$this->Html->tag('span', 'Activity',array('class' => 'index_bg wf-Istok_web')).
							$this->Html->tag('span', 'ニアショアIT協会の活動',array('class' => 'index_title')),
							array('controller' => 'activity','action'=> 'about'),
							array('escape'=>false)); ?>
			</li>
			<li class="index_item_03">
				<?php echo $this->Html->link($this->Html->tag('h2').
							$this->Html->tag('span', 'Report',array('class' => 'index_bg wf-Istok_web')).
							$this->Html->tag('span', '活動報告',array('class' => 'index_title')),
							array('controller' => 'activity','action'=> 'reportIndex'),
							array('escape'=>false)); ?>
			</li>
		</ul><!-- /.index_list -->
	</section><!-- /.index_box -->
</div><!-- /.contents -->
<div class="news_contents">
	<div class="news_box frame clearfix">
		<section class="news_block">
			<h2 class="h2 wf-roundedmplus1c">お知らせ</h2>
			<div id="news_record" class="news_list">
				<?php if(!empty($oshiraseDetails)): foreach($oshiraseDetails as $osirase): ?>
				<a href="javascript:;" data-arno="<?php echo $osirase['TOsirase']['arno']; ?>" class="news_list_item">
					<dl>
						<dt class="news_time">
							<span><?php echo date("Y.m.d", strtotime($osirase['TOsirase']['osirasedt'])); ?></span>
						</dt>
						<dd class="news_description maxchar_break">
							<?php echo $osirase['TOsirase']['title']; ?>
						</dd>
					</dl>
				</a>
				<!-- /.news_list_item -->
				<?php endforeach; endif; ?>
			</div><!-- /.news_list -->
			<div class="news_link wf-roundedmplus1c">
				<?php echo $this->Html->link($this->Html->tag('i', '', 
					array('class' => 'icon-key')).$this->Html->tag('span', 'お知らせの一覧はこちら'),
					array('controller' => 'news','action'=> 'index'),
					array('escape'=>false)); ?>
			</div>
		</section>
		<!-- /.news_block -->
		<section class="calendar_block">
			<h2 class="h2 wf-roundedmplus1c">活動カレンダー</h2>
			<div id="calender_record" class="news_list">
				<?php if(!empty($katudoDetails)): 
					foreach($katudoDetails as $katudo):
						if($katudo['TKatudo']['bunruicd'] == 1): 
							$class_item = "seminer_item";
						else:
							$class_item = "event_item";
						endif; ?>
						<a href="javascript:;" <?php if($katudo['TKatudo']['bunruicd'] == 1) { ?> data-bunruicd="1" <?php } else { ?> data-bunruicd="2" <?php } ?> data-arno="<?php echo $katudo['TKatudo']['arno']; ?>" class="news_list_item <?php echo $class_item;?>">
							<dl>
								<dt class="news_time"><span><?php echo date("Y.m.d", strtotime($katudo['TKatudo']['kaisaidate']));?></span></dt>
								<dd class="news_description maxchar_break"><?php echo $katudo['TKatudo']['hyoudai']."&nbsp;".$katudo['TKatudo']['meisyou'];?></dd>
							</dl>
						</a><!-- /.news_list_item -->
					<?php endforeach; 
				endif; ?>
			</div><!-- /.news_list -->
			<div class="news_link wf-roundedmplus1c">
				<?php echo $this->Html->link($this->Html->tag('i', '', 
						array('class' => 'icon-key')).$this->Html->tag('span', '活動カレンダーの一覧はこちら'),
						array('controller' => 'activity','action'=> 'index'.$curtime),
						array('escape'=>false)); ?>
			</div>
		</section><!-- /.calender_block -->
	</div><!-- /.news_box -->	
</div><!-- /.news_contents -->