<!--header -->
<?php $this->layout="default";?>
<?= $this->Html->css('members/style.css') ?>
<?= $this->Html->script('common/jquery.matchHeight.js') ?>
<?= $this->Html->script('members/index.js') ?>
<?= $this->element('messages'); ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<!-- /header -->
<style type="text/css">
.main {
	min-height:196px !important;
	min-width: 196px !important;
    display: table;
    justify-content:center;
}
.inner {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
}
.figureHei {
	min-height:196px !important;
	display: flex;
	align-items: center;
	justify-content:center;
	vertical-align: middle !important;
}
.mrgnbtmble {
	margin-bottom: 70px;
}
@media screen and (min-width: 395px) {
	.mrgnbtmble {
		margin-bottom: 50px;
	}
}
</style>
<script type="text/javascript">
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
	$(document).ready(function() {
		if (navigator.userAgent.match(/msie/i) || navigator.userAgent.match(/trident/i) ){
		   $('.figure').removeClass("figureHei");
		} else {
			$('.ieDiv').removeClass("main");
			$('.ieDiv').removeClass("inner");
		}
	});
</script>
	<div class="contents_wrap">
		<div class="contents pc_frame">
			<div class="mrgnbtmble" style="border-bottom: 3px solid #f5f6f8;">
				<h1 class="h1 wf-roundedmplus1c sp_frame" style="display: inline-block;margin-bottom:0px !important;"><span>ニアショアIT協会 会員企業一覧<span class="company_num"><span class="display_num"><?php echo $searchcount;?></span>社</span></span></h1>
				<span style="font-size: 1.4rem;float:right;margin-top:20px;">※当協会の会員で掲載希望のあった方のみ掲載しています。</span>
			</div>
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'members', 'action' => 'search'.$curtime]]);?>
				<div class="form_contents">
					<div class="search_block clearfix">
						<div class="form_wrap f_left_pc">
							<!--カテゴリーから探す -->
							<section class="category_block sp_frame">
								<h2 class="h2_form wf-roundedmplus1c">カテゴリーから探す</h2>
								<p class="description">プルダウンから登録している企業を絞り込むことができます。</p>
								<div class="select_group">
									<?php echo $this->Form->input('gyosyunm',array('type'=>'select',
																			'options'=>$gyosyunm, 
																			'label'=>false,
																			'value'=>$selectedGyosyunm,
																			'empty'=> array(''=> array(
																					'name' =>'業種を選択してください',
																					'value' => '',
																					'selected' => TRUE)),
																			'name'=>'industry'));?>
								</div><!-- /.select_group -->
								<div class="select_group">
									<?php echo $this->Form->input('kaiinsbnm',array('type'=>'select',
																			'options'=>$kaiinsbnm, 
																			'label'=>false,
																			'value'=>$selectedKaiinsbnm,
																			'empty'=> array(''=> array(
																					'name' =>'会員種別を選択してください',
																					'value' => '',
																					'disabled' => TRUE,
																					'selected' => TRUE)),
																			'name'=>'members_type'));?>
								</div><!-- /.select_group -->
							</section><!-- /.category_block -->
						</div><!-- /.form_wrap -->
						<div class="form_wrap f_right_pc">
						<!--フリーワード検索で探す -->
							<section class="free_word_block sp_frame">
								<h2 class="h2_form wf-roundedmplus1c">フリーワード検索で探す</h2>
								<p class="description">企業名や連絡窓口、所在地などから検索できます。</p>
								<div class="radio_box">
									<?php foreach($searchTypeList as $key => $searchType):?>
										<label><input type="radio" name="free_radio" class="radio" value="<?php echo $key;?>" <?php if($key == $freewordTypeChk){echo "checked";}?>><span class="radio-icon"></span><?php echo $searchType;?></label>
									<?php endforeach;?>
								</div><!-- /.radio_box -->
								<div class="text_box">
								<?php echo $this->Form->input('', array('type' => 'text','name'=>'free_word','value'=> $keywordVal)); ?>
								</div><!-- /.text_box -->
							</section><!-- /.free_word_block -->
						</div><!-- /.form_wrap -->
					</div><!-- /.search_block -->
					<div class="submit_btn sp_frame">
					<?php echo $this->Form->button("検索", array('class' =>'button','name' =>'searchbtn','controller' => 'members','action'=> 'search'.$curtime));?>
					</div>
				</div><!-- /.form_contents -->
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('kaishaShosaifrm', ['id' => 'kaishaShosaifrm', 'url' => ['controller' => 'members', 'action' => 'detail']]);
				echo $this->Form->input('kaiincd', array('type' => 'hidden'));		// T_KAIINCD.会員コード
				echo $this->Form->input('kaisyacd', array('type' => 'hidden'));		// T_KAIIN.会社コード
				echo $this->Form->input('industry', array('type' => 'hidden','value'=>$selectedGyosyunm));
				echo $this->Form->input('members_type', array('type' => 'hidden','value'=>$selectedKaiinsbnm));
				echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$keywordVal));
				echo $this->Form->input('free_radio', array('type' => 'hidden','value'=>$freewordTypeChk));
			echo $this->Form->end();?>
			<div class="members_list_box">
			<!-- ニアショアIT協会 会員企業一覧-->
			<ul class="members_list clearfix">
			<?php if(!empty($searchinfo)): foreach($searchinfo as $searchVal): ?>
				<li class="members_list_item">
				<a href="javascript:;" class="kaishaShosai"
						data-kaishakaiincd="<?php echo $searchVal['tkn']['kaiincd'];?>"
						data-kaiinKaisyacd="<?php echo $searchVal['tkn']['kaisyacd'];?>">
					<div class="main ieDiv">
					    <div class="inner ieDiv"> 
						    <figure class="figure figureHei" class="figureHei">
								<img src="<?php echo $this->base."/members/getKaisyaklogo/".$searchVal['tkn']['kaisyacd'];?>" style="vertical-align: middle !important; max-height:196px !important;max-width:196px !important;width: auto;" />
							</figure>
					     </div>
					</div>
					<p class="company_name"><?php echo  $searchVal['TKaisya']['kaisyanm']; ?></p>
					<dl class="members_name">
						<dt>連絡窓口：</dt>
						<dd>
							<?php if($searchVal['tkn']['koukaikbn'] == 0 ) {  
								echo $searchVal['tkn']['kaiinnm']; 
							} else {
								echo "非公開"; 
							} ?>
						</dd>
					</dl>
				</a>	
				</li>
			<?php endforeach; else: ?>
				<div style="text-align:center;color: red;"><?php echo $this->fetch('SEARCH_NOT_FOUND'); ?></div>
			<?php endif; ?>
			</ul>
			</div><!-- /.members_list_box -->
		</div><!-- /.contents -->
	</div><!-- /.contents_wrap -->
