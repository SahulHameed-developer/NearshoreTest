<?php $curtime = "?time=".date('dmYHis'); ?>
<!-- メインビジュアル -->
<?php if (strtolower($this->Common->getController()) == strtolower($this->Constants->ACTIVITY_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Activity</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会の活動</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Activity</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会の活動</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL)) {?>
		<!-- メインビジュアル -->
		<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">About Us</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会とは</span>
			</p>
		</div><!-- /.main_visual -->

		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">About Us</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会とは</span>
			</p>
		</div><!-- /.main_visual -->
		<!-- メインビジュアル終わり -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->MEMBERS_CTL)) {?>
		<!-- メインビジュアル -->
		<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Members</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">会員企業</span>
			</p>
		</div><!-- /.main_visual -->

		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Members</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">会員企業</span>
			</p>
		</div><!-- /.main_visual -->
		<!-- メインビジュアル終わり -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->JOIN_CTL)) {?>
	<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Guide for Membership</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">入会のご案内</span>
			</p>
		</div><!-- /.main_visual -->
		
		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Guide for Membership</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">入会のご案内</span>
			</p>
		</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->PRIVACY_CTL)) {?>
		<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Privacy Policy</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">個人情報の取り扱い</span>
			</p>
		</div><!-- /.main_visual -->

		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Privacy Policy</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">個人情報の取り扱い</span>
			</p>
		</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->NEWS_CTL)) {?>
		<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Information</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">お知らせ</span>
			</p>
		</div><!-- /.main_visual -->

		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Information</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">お知らせ</span>
			</p>
		</div>
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BENEFICIAL_CTL)) {?>
		<div class="main_visual sp_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Useful Information</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">有益情報</span>
			</p>
		</div><!-- /.main_visual -->

		<div class="main_visual pc_contents">
			<p class="main_visual_title frame">
				<span class="main_title wf-Istok_web textshadow">Useful Information</span>
				<span class="sub_title wf-roundedmplus1c textshadow_jp">有益情報</span>
			</p>
		</div>
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CONTACT_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Contact Us</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">お問い合わせ</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Contact Us</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">お問い合わせ</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->DOWNLOAD_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Download</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ダウンロード</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Download</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ダウンロード</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->COMMITTEE_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Committee</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">委員会の紹介</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Committee</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">委員会の紹介</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CLUB_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Club</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">倶楽部の紹介</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Club</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">倶楽部の紹介</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BANNER_CTL)) {?>
			<div class="main_visual sp_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Banner</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会バナー</span>
				</p>
			</div><!-- /.main_visual -->

			<div class="main_visual pc_contents">
				<p class="main_visual_title frame">
					<span class="main_title wf-Istok_web textshadow">Banner</span>
					<span class="sub_title wf-roundedmplus1c textshadow_jp">ニアショアIT協会バナー</span>
				</p>
			</div><!-- /.main_visual -->
<?php } else {?>
		<!-- メインビジュアル -->
			<section class="index_main_visual sp_contents">
				<p class="main_visual_title frame">
					<span style="text-align: center;" class="top_title">ニアショア開発を通して地域経済の活性化を図る</span>
				</p>
				<h1 class="frame"><?php echo $this->Html->image('index/sp/mv_copy.png', array('alt' => 'ニアショア開発を通して地域経済の活性化を図る'));?></h1>
			</section><!-- /.main_visual-->
	
			<section class="index_main_visual pc_contents">
				<p class="main_visual_title frame">
					<span style="text-align: center;" class="top_title">ニアショア開発を通して地域経済の活性化を図る</span>
				</p>
				<h1 class="frame"><?php echo $this->Html->image('index/pc/mv_copy.png', array('alt' => 'ニアショア開発を通して地域経済の活性化を図る'));?></h1>
			</section><!-- /.main_visual-->
<?php }?>
<!-- メインビジュアル終わり -->
<?php
$bunruinm = "";
if (isset($bunruicd) && $bunruicd != "" && $bunruicd == ConstantsComponent::$KAIGI_CD) {
	$bunruinm = "会議出席連絡";
} elseif (isset($bunruicd) && $bunruicd != ""){
	$bunruinm = "イベント申込";
} else if (isset($_SESSION["activity"]["bunruicd"]) && 
				$_SESSION["activity"]["bunruicd"] == ConstantsComponent::$KAIGI_CD) {
	$bunruinm = "会議出席連絡";
} else {
	$bunruinm = "イベント申込";
}
if(strtolower(strtolower($this->Common->getController()) != strtolower(strtolower($this->Constants->TOP_CTL)))) { ?>
	<div class="page_path pc_contents">
		<ul class="frame clearfix">
			<li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
				<?php if(strtolower($this->Common->getController()) == strtolower($this->Constants->ACTIVITY_CTL)) { ?>
					<li><?php echo $this->Html->link("ニアショアIT協会の活動", array('controller' => 'activity','action'=> 'about'));?></li>
					<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->SEARCH_ACT)) {?>
						<li>活動カレンダー一覧</li>
					<?php } elseif (strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->KAIGIDETAIL_ACT) || strtolower($this->Common->getAction()) == strtolower($this->Constants->CANCEL_ACT)) {?>
						<li><?php echo $this->Html->link("活動カレンダー一覧", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
						<li><?php echo $event_shousai['TKatudo']['meisyou']; ?></li>
					<?php } elseif (strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTINDEX_ACT) ||strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTSEARCH_ACT)) {?>
						<li>活動報告一覧</li>
					<?php } elseif (strtolower($this->Common->getAction()) == strtolower($this->Constants->REPORTDETAIL_ACT)) {?>
						<li><?php echo $this->Html->link("活動報告一覧", array('controller' => 'activity','action'=> 'reportIndex'.$curtime));?></li>
						<li id="reportdetailheader"></li>
					<?php } elseif (strtolower($this->Common->getAction()) == strtolower($this->Constants->ABOUT_ACT)) {?>
						<li>活動概要</li>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
						<li><?php echo $this->Html->link("活動カレンダー一覧", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
						<li><?php echo $bunruinm;?></li>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
						<li><?php echo $this->Html->link("活動カレンダー一覧", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
						<?php if($status == strtolower($this->Constants->MAILSEARCH_ACT)) {?>
							<li><?php echo $bunruinm;?></li>
						<?php } else {?>
							<li><a href="javascript:;" class="kaigiEvent"><?php echo $bunruinm;?></a></li>
							<li>入力内容確認</li>
						<?php }?>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
						<li><?php echo $this->Html->link("活動カレンダー一覧", array('controller' => 'activity','action'=> 'index'.$curtime));?></li>
						<li><a href="javascript:;" class="kaigiEvent"><?php 
								if (isset($_SESSION["activity"]["bunruicd"]) 
									&& $_SESSION["activity"]["bunruicd"] == ConstantsComponent::$KAIGI_CD) {
									echo "会議出席連絡";
									unset($_SESSION["activity"]["bunruicd"]); // unset the bunricd
								} else {
									echo "イベント申込";
								} ?></a>
						</li>
						<li>送信完了</li>
					<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->ABOUT_CTL)) {?>
					<li><?php echo $this->Html->link("ニアショアIT協会とは", array('controller' => 'about','action'=> 'index'));?></li>	
						<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->ORGANIZATION_ACT)) {?>
							<li>組織図</li>
						<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->INDEX_ACT)) {?>
							<li>協会概要</li>	
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->MESSAGE_ACT)) {?>
							<li>ご挨拶</li>
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->EXECUTIVE_ACT)) {?>
							<li>役員紹介</li>
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->STATUTE_ACT)) {?>
							<li>定款</li>
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ACCESS_ACT)) {?>
							<li>アクセス</li>
						<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->MEMBERS_CTL)) {?>
					<li><?php echo $this->Html->link("会員企業", array('controller' => 'members','action'=> 'index'));?></li>
						<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
							<li><?php echo $this->Html->link("会員企業一覧", array('controller' => 'members','action'=> 'index'));?></li>
							<li><?php echo $detailinfo['TKaisya']['kaisyanm'];?></li>
						<?php } else { ?>
							<li>会員企業一覧</li>
						<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->JOIN_CTL)) {?>
					<li><?php echo $this->Html->link("入会のご案内", array('controller' => 'join','action'=> 'about'));?></li>
					<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
							<li><?php echo $this->Html->link("入会申込", array('controller' => 'join','action'=> 'entry'));?></li>
							<li>入力内容確認</li>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
							<li><?php echo $this->Html->link("入会申込", array('controller' => 'join','action'=> 'entry'));?></li>
							<li>送信完了</li>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->FAQ_ACT)) {?>
							 <li>よくあるご質問（FAQ）</li>
					<?php } else if (strtolower($this->Common->getAction()) == strtolower($this->Constants->ABOUT_ACT)) {?>
							<li>入会について</li>
					<?php } else {?>
							<li>入会申込</li>
					<?php } ?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->NEWS_CTL)) {?>
					<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
						<li><?php echo $this->Html->link("お知らせ一覧", array('controller' => 'news','action'=> 'index'));?></li>
						<li id="newsdetailheader">お知らせ一覧</li>
					<?php } else {?>
						<li id="newsdetailheader">お知らせ一覧</li>
					<?php } ?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BENEFICIAL_CTL)) {?>
					<?php if (strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
						<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuBenificial1','onclick'=>'return login(this.id);')); ?></li>
						<li><?php echo $this->Html->link("有益情報一覧", array('controller' => 'Beneficial','action'=> 'index'));?></li>
						<li id="beneficialdetailheader">有益情報一覧</li>
					<?php } else {?>
						<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuBenificial2','onclick'=>'return login(this.id);')); ?></li>
						<li id="beneficialdetailheader">有益情報一覧</li>
					<?php } ?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CONTACT_CTL)) {?>
						<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->ENTRY_ACT)) {?>
							<li>お問い合わせ</li>
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->CONFIRM_ACT)) {?>
							<li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'entry'));?></li>
							<li>入力内容確認</li>
						<?php } else if(strtolower($this->Common->getAction()) == strtolower($this->Constants->FINISH_ACT)) {?>
							<li><?php echo $this->Html->link("お問い合わせ", array('controller' => 'contact','action'=> 'entry'));?>
							<li>送信完了</li>
						<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->DOWNLOAD_CTL)) {?>
							<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuDownload','onclick'=>'return login(this.id);')); ?></li>
							<li>ダウンロード</li>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->COMMITTEE_CTL)) {?>
						<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuCommitee','onclick'=>'return login(this.id);')); ?></li>
						<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
							<li class="urltargetcls"><?php echo $this->Html->link("委員会の紹介", array('controller' => 'Committee','action'=> 'index'));?></li>
							<li><?php echo $this->Session->read ( 'titlename');?></li>
						<?php } else { ?>
							<li>委員会の紹介</li>
						<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->CLUB_CTL)) {?>
						<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuClub','onclick'=>'return login(this.id);')); ?></li>
						<?php if(strtolower($this->Common->getAction()) == strtolower($this->Constants->DETAIL_ACT)) {?>
							<li class="urltargetcls"><?php echo $this->Html->link("倶楽部の紹介", array('controller' => 'Club','action'=> 'index'));?></li>
							<li><?php echo $this->Session->read ( 'titlename');?></li>
						<?php } else { ?>
							<li>倶楽部の紹介</li>
						<?php }?>
				<?php } else if (strtolower($this->Common->getController()) == strtolower($this->Constants->BANNER_CTL)) {?>
							<li class="urltargetcls"><?php echo $this->Html->link("会員メニュー", array(), array('id'=>'kaiinmenuBanner','onclick'=>'return login(this.id);')); ?></li>
							<li>ニアショアIT協会バナー</li>
				<?php }else{ ?>
						<li>個人情報の取り扱いについて</li>
				<?php } ?>
		</ul>
	</div>
<?php }?>
