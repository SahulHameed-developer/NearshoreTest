<!--header -->
<?php $this->layout="default";?>
<!-- /header -->
<!-- style/index -->
<?= $this->html->css('news/style.css') ?>
<?= $this->Html->script('news/index.js') ?>
<style type="text/css">
	.titleOverflow {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
</style>
<div class="contents_wrap">
	<div class="contents frame">
		<section class="section">
			<h1 class="h1 wf-roundedmplus1c"><span>お知らせ一覧</span></h1>
			<div class="news_list">
				<?php echo $this->Form->create('newsDetailfrm', ['id' => 'newsDetailfrm', 'url' => ['controller' => 'news', 'action' => 'detail']]);
					echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$scroll_val));
					echo $this->Form->input('arno', array('id'=>'arno','type' => 'hidden'));
					echo $this->Form->input('recCount', array('id'=>'recCount','type' => 'hidden','value'=> $count));
					echo $this->Form->input('count', array('id'=>'count','name'=>'count','type' => 'hidden','value'=> $totalcount)); ?>
					<div id="record"></div>
				<?php echo $this->Form->end(); ?>
			</div><!-- /.news_list -->
			<div class="link_block btndiv">
				<div class="link_item displayBtn"><a href="javascript:;">もっと見る</a></div>
			</div><!-- /.link_block -->
		</section>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->