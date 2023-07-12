<!--header -->
<?php $this->layout="default";?>
<!-- /header -->
<?= $this->html->css('join/style.css') ?>
<div class="contents_wrap">
	<div class="contents frame">
		<article class="article">
			<h1 class="h1 wf-roundedmplus1c"><span>入会について</span></h1>
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">1．入会申込みについて</h2>
				<p class="sub_content_pad_desc description">入会できる会員種別は以下のとおりです。</p>
				<section class="sub_section">
					<h3 class="h3">（1）正会員</h3>
					<p class="sub_content_pad">当協会の目的に賛同する個人および団体</p>
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（2）準会員</h3>
					<p class="sub_content_pad">当協会の目的に賛同する個人および団体で、正会員になるまで１年間の準備期間を希望した個人および団体</p>
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（3）賛助会員</h3>
					<p class="sub_content_pad">当協会の目的に賛同し、事業に財産的援助をする法人、団体及び個人</p>
					<p class="sub_section_contents sub_content_pad">各いずれのお申し込みも『電話・FAX』『郵送』『お申込みフォーム』のいずれかでお申込みをお願いします。<br>お問い合わせ先、入会申込書につきましては下記をご参照下さい。</p>
				</section><!-- /.sub_section -->
			</section><!-- /.section -->
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">2．入会までのフローチャート</h2>
					<div class="img_block">
						<?php echo $this->Html->image('join/about/img_01.gif', array('alt' => '①入会申し込み（電話/FAX、郵送、お申込みフォーム）、事務局員訪問説明 ②申込書提出、受付け審査、理事会承認、入会手続き完了 ③会費納入'));?>
						<p tooltip="入会不承認について
　  次の各号に掲げるいずれかの事由に該当する場合、協会は入会を承認しない場合があります。
　（１）本協会、本協会会員および関係者に損害を与え、又は損害を与えるおそれがある場合
　（２）過去に法令に違反し、会員として不適当であると認められる場合又は不適格な従業者を雇用している場合
　（３）過去に本協会から除名されて５年を経過しない場合
　（４）入会申込関係書類に虚偽の事項を記載した場合
　（５）入会申込者が反社会的と認められる団体（暴力団や過激な政治活動集団等）の構成員や団体である場合
　（６）本協会の信用を傷つけ、又はその恐れのある場合
　（７）その他協会が、入会につき不適当な事由があると判断した場合" 
						class="description p_style">※受付審査　：　入会不承認について</p>
					</div>
			</section><!-- /.section -->
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">3．会費納入について</h2>
				<p class="description">入会手続きが完了しましたら、所定の期日に下記会費の納入をお願いします。</p>
				<section class="sub_section">
					<h3 class="h3">会費及び年会費</h3>
					<div class="table_area">
					<table class="table_02">
					<tr>
						<th>種別</th>
						<th>区別</th>
						<th>年会費（円）</th>
						<th>入会金（円）</th>
                    </tr>
					<tr>
						<td rowspan="3">正会員</td>
						<td>フロント</td>
						<td>24,000</td>
						<td>50,000</td>
					</tr>
					<tr>
						<td class="nb">ニアショア</td>
						<td>24,000</td>
						<td>30,000</td>
					</tr>
					<tr>
						<td class="nb">個人</td>
						<td>6,000</td>
						<td>5,000</td>
					</tr>
					<tr>
						<td rowspan="3">準会員</td>
						<td>フロント</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="nb">ニアショア</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="nb">個人</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td rowspan="3">賛助会員</td>
						<td>法人</td>
						<td>100,000</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="nb">団体</td>
						<td>100,000</td>
						<td>0</td>
					</tr>
					<tr>
						<td class="nb">個人</td>
						<td>50,000</td>
						<td>0</td>
					</tr>
					</table>
					</div><!-- /.table_area -->
				</section><!-- /.sub_section -->
			</section>
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">4．入会お問い合わせ先</h2>
				<section class="sub_section">
					<h3 class="h3">（1）郵送・電話によるお問い合わせ・申込み</h3>
					<div class="join_contact_wrap analog">
						<div class="join_contact_block">
							<div class="description_item">
								<p>〒101-0048　東京都千代田区神田司町2-13　神田第４アメレックスビル8F<br>一般社団法人　ニアショアＩＴ協会<br>TEL：03-6327-7070　FAX：03-3295-7111</p>
							</div>
							<div class="contact_link_block">
								<div class="link_item event_contact wf-roundedmplus1c">
									<?php  echo $this->Html->link('入会申込書のダウンロード', Router::url('/', true).WWW_APP_ROOT.$filepath,['class' => 'button', 'target' => '_blank', 'download'=>$filename]); ?>
								</div>
							</div><!-- /.link_block -->
						</div><!-- /.join_contact_block -->
					</div><!-- /.join_contact_wrap -->
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（2）インターネットからのお申込み</h3>
					<div class="join_contact_wrap internet">
						<div class="join_contact_block">
							<div class="description_item"><p>お申込みフォームに必要事項を記入して送信して下さい。<br>内容確認後、事務局よりご連絡させていただきます。</p>
							</div>
							<div class="contact_link_block">
								<div class="link_item event_contact wf-roundedmplus1c">
									<?php echo $this->Html->link("入会のお申し込み", array('controller' => 'join','action'=> 'entry'));?>
								</div><!-- /.contact_link_block -->
							</div><!-- /.link_block -->
						</div><!-- /.join_contact_block -->
					</div><!-- /.join_contact_wrap -->
				</section><!-- /.sub_section -->
			</section><!-- /.section -->
		</article>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->