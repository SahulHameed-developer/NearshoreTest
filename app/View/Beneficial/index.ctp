<!--header -->
<?php $this->layout="default";?>
<!-- /header -->
<!-- style/index -->
<?= $this->html->css('beneficial/style.css') ?>
<?= $this->Html->script('beneficial/index.js') ?>
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
			<h1 class="h1 wf-roundedmplus1c"><span>有益情報一覧</span></h1>
			<div class="section_mb">
				<section class="article">
					<h3 class="h3 descriptionTitle_fnsize" style="font-weight: bold;">◆免責事項について</h3>
					<dd class="description_ml">
						<ol class="description_fnsize">
							<li>当サイトでの情報・資料の掲載には十分に注意を払っておりますが、掲載された情報の内容の正確性については一切保証を致しません。</li>
							<li>また、当サイトに掲載された情報・資料を利用、使用、ダウンロードするなどの行為に関連して生じたあらゆる損害等についても、理由
	    の如何に関わらず、協会は一切責任を負いません。</li>
							<li>また、当サイトに掲載している情報には、会員企業のほか第三者が提供している情報が含まれていますが、これらは皆さまの便宜のために提供しているものであり、協会はその内容の正確性については一切責任を負いかねますのでご了承ください。</li>
						</ol>
					</dd>
				</section>
			</div>
			<div class="beneficial_list">
				<?php echo $this->Form->create('beneficialDetailfrm', ['id' => 'beneficialDetailfrm', 'url' => ['controller' => 'Beneficial', 'action' => 'detail']]);
					echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$scroll_val));
					echo $this->Form->input('arno', array('id'=>'arno','type' => 'hidden'));
					echo $this->Form->input('recCount', array('id'=>'recCount','type' => 'hidden','value'=> $count));
					echo $this->Form->input('count', array('id'=>'count','name'=>'count','type' => 'hidden','value'=> $totalcount)); ?>
					<div id="record"></div>
				<?php echo $this->Form->end(); ?>
			</div><!-- /.beneficial_list -->
			<div class="link_block btndiv">
				<div class="link_item displayBtn"><a href="javascript:;">もっと見る</a></div>
			</div><!-- /.link_block -->
		</section>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->