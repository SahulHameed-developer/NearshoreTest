<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('activity/style.css?v=1') ?>
<?= $this->Html->script('activity/index.js?v=1') ?>
<?= $this->element('messages'); ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
</script>
<style>
.shorichuucls {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ5JSIgeT0iNDklIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+5Yem55CG5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
	background-color: rgba(255, 255, 255, .5);
}
</style>
<!-- /header -->
<div id="shorichuucls"></div>
<div class="contents_wrap">
	<div class="contents pc_frame">
		<h1 class="h1 wf-roundedmplus1c sp_frame"><span>ニアショアIT協会 活動カレンダー一覧</span></h1>
		<?php echo $this->Form->create('moshiKomitorikeshiFrm', ['id' => 'moshiKomitorikeshiFrm', 'url' => ['controller' => 'activity', 'action' => 'cancelActivity'.$curtime]]);
			echo $this->Form->input('arno', array('type' => 'hidden'));
			echo $this->Form->input('bunruicd', array('type' => 'hidden'));
			echo $this->Form->input('srchtp', array('id'=>'srchtp','name'=>'srchtp','type' => 'hidden','value'=>$srchtyp));
			echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$scroll_val));
			echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
			echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
			echo $this->Form->end();
		?>
		<?php echo $this->Form->create(null, ['url' => ['controller' => 'activity', 'action' => 'search'.$curtime]]);?>
			<div class="form_contents clearfix">
				<div class="form_wrap f_left_pc">
					<!-- 会議を探す -->
					<section class="conference_block sp_frame">
						<h2 class="h2_form wf-roundedmplus1c">会議を探す</h2>
						<p class="description">プルダウンから会議を絞り込むことができます。</p>
						<div class="select_group">
							<?php echo $this->Form->input('sosikinm',array('type'=>'select','options'=>$sosikinm, 
									'label'=>false,
									'value'=>$selectedSosikinm,
									'empty'=> array(''=> array(
											'name' =>'会議の種別を選択してください',
											'value' => '',
											'selected' => TRUE)),
									'class'=>'select_type','id'=>'conference'));?>
						</div><!-- /.select_group -->
						<?php echo $this->Form->button("検索", array('class' =>'button kaigi1','name' =>'kaigibtn','controller' => 'activity','action'=> 'search'.$curtime));?>
					</section><!-- /.conference_block -->
				</div><!-- /.form_wrap -->
				<div class="form_wrap f_right_pc">
					<!-- イベントを探す -->
					<section class="event_block sp_frame">
						<h2 class="h2_form wf-roundedmplus1c">イベントを探す</h2>
						<p class="description">プルダウンからイベントを絞り込むことができます。</p>
						<div class="select_group">
							<?php echo $this->Form->input('kbunruinm',array('type'=>'select','options'=>$kbunruinm,'label'=>false,
									'value'=>$selectedKbunruinm,
									'empty'=> array(''=> array(
											'name' =>'イベントの種別を選択してください',
											'value' => '',
											'selected' => TRUE)),
									'class'=>'select_type',
									'id'=>'event'));?>
						</div><!-- /.select_group -->
						<?php echo $this->Form->button("検索", array('class' =>'button event2','name' =>'eventbtn','controller' => 'activity','action'=> 'search'.$curtime));?>
					</section><!-- /.event_block -->
				</div><!-- /.form_wrap -->
			</div><!-- /.form_contents -->
		<?php echo $this->Form->input('srchtyp', array('id'=>'srchtyp','name'=>'srchtyp','type' => 'hidden','value'=>$srchtyp));
		echo $this->Form->end();?>
		<?php echo $this->Form->create('shosaiShutokuFrm', ['id' => 'shosaiShutokuFrm', 'url' => ['controller' => 'activity', 'action' => 'detail'.$curtime]]);
			echo $this->Form->input('srchtp', array('id'=>'srchtp','name'=>'srchtp','type' => 'hidden','value'=>$srchtyp));
			echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$scroll_val));
			echo $this->Form->input('arno', array('type' => 'hidden'));
			echo $this->Form->input('sosikinm', array('type' => 'hidden','value'=>$selectedSosikinm));
			echo $this->Form->input('kbunruinm', array('type' => 'hidden','value'=>$selectedKbunruinm));
			echo $this->Form->end();
		?>
		<?php echo $this->Form->create('moshiKomiFrm', ['id' => 'moshiKomiFrm', 'url' => ['controller' => 'activity', 'action' => 'entry']]);
			echo $this->Form->input('arno', array('type' => 'hidden'));
			echo $this->Form->end();
		?>
		<div class="detail_contents">
			<!-- 活動カレンダー一覧 -->
			<?php if(!empty($katoinfo)): foreach($katoinfo as $katoVal): ?>
				<article class="article type_01">
					<div class="article_wrap sp_frame">
						<div class="month_item">
							<span class="month"><?php echo $katoVal['TKatudo']['hyoudai']; ?></span>
						</div>
						<h2 class="h2"><?php echo $katoVal['TKatudo']['meisyou']; ?></h2>
						<div class="article_block break_line">
							<dl>
								<dt>日時</dt>
								<dd>
									<?php
										echo $this->Common->getJapDate($katoVal['TKatudo']['kaisaidate']);
										echo date("G:i", strtotime($katoVal['TKatudo']['kaisaitmfrom']));
										echo '〜';
										echo date("G:i", strtotime($katoVal['TKatudo']['kaisaitmto']));
									?>
								</dd>
							</dl>
							<dl>
								<dt>場所</dt>
								<dd><?php echo nl2br($katoVal['TKatudo']['basyo']); ?></dd>
							</dl>
					<?php if ($katoVal['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD): // 会議の場合のみ?>
							<dl>
								<dt>議題</dt>
								<dd><?php echo nl2br($katoVal['TKatudo']['gidai']); ?></dd>
							</dl>
						</div><!-- /.article_block -->
					<?php else: ?>
							<dl>
								<dt>定員</dt>
								<dd>
									<?php
									if (!empty($katoVal['TKatudo']['teiin'])) { echo $katoVal['TKatudo']['teiin']."名"; }
									if (!empty($katoVal['TKatudo']['teiincom']) && !empty($katoVal['TKatudo']['teiin']) ) {
										echo "（".nl2br($katoVal['TKatudo']['teiincom'])."）　"; 
									} else if (!empty($katoVal['TKatudo']['teiincom'])) {
										echo nl2br($katoVal['TKatudo']['teiincom']); 
									} ?>
								</dd>
							</dl>
							<dl>
								<dt>申込期限</dt>
								<dd>
									<?php
									if(($katoVal['TKatudo']['kigendate'] == "0000-00-00" && $katoVal['TKatudo']['kigentm'] == "00:00:00")
											|| ($katoVal['TKatudo']['kigendate'] == "0000-00-00" ||
														empty($katoVal['TKatudo']['kigendate'])) 
											|| (empty($katoVal['TKatudo']['kigentm']) &&
																empty($katoVal['TKatudo']['kigendate']))) {
									 echo "";	
									} else {
										echo $this->Common->getJapDate($katoVal['TKatudo']['kigendate']);
										echo date("G:i", strtotime($katoVal['TKatudo']['kigentm']));
									}
									?>
								</dd>
							</dl>
							<dl>
								<dt>備考</dt>
								<dd><?php echo nl2br($katoVal['TKatudo']['bikou']); ?></dd>
							</dl>
						</div><!-- /.article_block -->	
						<?php endif; ?>	
						<div class="event_link_block clearfix">
							<div class="link_item event_detail wf-roundedmplus1c f_left">
								<a href="javascript:;" class="shosaiShutoku"
								<?php 
								if ($katoVal['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD){
									echo "data-actionfunction='Kaigidetail' ";
								} else {
								  	echo "data-actionfunction='detail' ";
								}?>
								data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">詳細情報</a>	
							</div>
							<?php $cancelflg = 0;
							if(isset($_SESSION['Auth']['User']['TKaiin']['kaiincd'])) {
								if($katoVal['TEntry']['kaiincd']==$_SESSION['Auth']['User']['TKaiin']['kaiincd']) {
									$cancelflg = 1;
								} 
							} ?>
							<div class="link_item event_contact wf-roundedmplus1c f_right">
							<?php 
								if($cancelflg == 0) { 
									if ($katoVal['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD){?>
											<a href="javascript:;" class="shuseki" 
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">出席する</a>
									<?php } else {?>
											<a href="javascript:;" class="moshiKomi"
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">お申し込み</a>
									<?php }
								} else if(!empty($katoVal['TEntry']['mousikomidt']) 
											&& ($katoVal['TEntry']['torikesidt'] == "0000-00-00 00:00:00" 
													|| empty($katoVal['TEntry']['torikesidt']))) { ?>
									<?php if ($katoVal['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD){?>
											<a href="javascript:;" class="shusekiTorikeshi_index" 
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>" data-bunruicd="<?php echo $katoVal['TKatudo']['bunruicd'];?>">出席を取り消す</a>
									<?php } else {?>
											<a href="javascript:;" class="moshiKomitorikeshi_index"
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>" data-bunruicd="<?php echo $katoVal['TKatudo']['bunruicd'];?>">お申し込み取り消し</a>
									<?php } 
								} else { 
										if ($katoVal['TKatudo']['bunruicd'] == ConstantsComponent::$KAIGI_CD){?>
											<a href="javascript:;" class="shuseki" 
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">出席する</a>
									<?php } else {?>
											<a href="javascript:;" class="moshiKomi"
											data-arno="<?php echo $katoVal['TKatudo']['arno'];?>">お申し込み</a>
									<?php } 
								} ?>
							</div>
						</div><!-- /.link_block -->
					</div><!-- /.article_wrap -->
				</article><!-- /.type_01 -->
			<?php endforeach; else: ?>
				<div style="text-align:center;color: red;"><?php echo $this->fetch('SEARCH_NOT_FOUND'); ?></div>
			<?php endif; ?>
	</div><!-- /.detail_contents -->
</div><!-- /.contents -->
