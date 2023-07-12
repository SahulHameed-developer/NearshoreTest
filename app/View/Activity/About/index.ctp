<!--header -->
	<?php $this->layout="default";?>
	<?= $this->html->css('activity/style.css') ?>
	<?= $this->Html->script('activity/index.js') ?>
<!-- /header -->
<div class="contents_wrap">
	<div class="contents frame">
		<article class="article">
			<span style="float: right;margin-top: 3%;">平成30年1月31日</span>
			<h1 class="h1 wf-roundedmplus1c"><span>理事会他活動概要について</span></h1>
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">1. 理事会について</h2>
				<p class="description">　協会では、総会が最高意思決定機関ですが、実際に協会の事業方針を考え、具体的に問題を処理し解決していくのは理事会になります。<br>総会の場合、定期総会（通常総会）は年1回しか開催されませんし、提案された議案についてしか決議することができません。その総会議案を作成するのも理事会です。<br>　理事会は、定期的に開催されます。<br>特に議題や問題がなくても、協会の状況を把握し、事業の会計報告を受けることなどは大切です。また、会員からクレームや要望が発生した場合や緊急に解決しなければならない問題等が生じたときは、臨時理事会を開き柔軟に対応しています。</p>
			</section><!-- /.section -->
			<section class="section">
				<h2 class="h2 h2_dot wf-roundedmplus1c">2. 各委員会について</h2>
				<p class="description">　協会は大都市圏の情報通信技術（以下「ICT」と称する）への需要をとりまとめ、国内の地方でICT関連の事業を営む中小の企業への受注活動を支援するなど、大都市圏と地方の取引を積極的かつ円滑に進める活動を行うことを目的としています。<br>　各委員会では大都市圏のICT顧客への広告宣伝、地方のICT企業への受注支援、開発標準、セキュリティ、コンプライアンス基準の制定と教育などの事業を企画し、「地方の活性化」「相互扶助」「仲間作り」の３つをキーワードに、それによって、豊かな創造力・感性を持った会員同士が共感し、自己を成長させると共に、生涯共に高め合える貴重な仲間との出逢いを支援します。</p>
				<section class="sub_section">
					<h3 class="h3">（1）広報委員会</h3>
					<p>当委員会では、永続的な会員増強を推進できる仕組み作りを検討すると共に、会員増強を目的とした展示会への出展や協会ＰＲを行っています。また、各種事業と連携しながら、新しい入会者を増強すべく活動しています。</p>
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（2）情報管理委員会</h3>
					<p>当委員会では、案件情報管理ツールを使って、発注企業の案件情報を管理し、ニアショア企業への受注支援を行っております。また、空き要員の情報を管理し、フロント企業へ情報提供を行っています。<br>今後は、会員同士が情報を共有できるグループウェアの導入に向け活動していきます。</p>
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（3）品質管理委員会</h3>
					<p>当委員会では、全会員を対象にした品質向上の為の活動を行っています。<br>協会開発標準の作成。協会品質マニュアルの作成、プロジェクト管理ツールの導入及び運用、情報セキュリティ、コンプライアンス啓蒙及び教育など、幅広いテーマでの研修を開催しています。</p>
				</section><!-- /.sub_section -->
				<section class="sub_section">
					<h3 class="h3">（4）営業推進委員会</h3>
					<p>当委員会では、ホームページからのお問合せ企業様や広報委員会で実施した広報活動で反響のあった企業様への入会説明や、発注企業様への定期訪問などの営業活動を行うと共に、発注企業様からの案件情報の取りまとめと会員企業様への展開を行っています。<br>また、スポーツ、文化活動などを通じ、企業活動の原動力となる経営者の健康促進を図り、文化教養を高めると共に、楽しい仲間作りなどで明日の企業活力を要請するための福利厚生事業を展開しています。</p>
				</section><!-- /.sub_section -->
			</section><!-- /.section -->
			<div class="activity_link_block clearfix">
				<div class="link_item wf-roundedmplus1c"><?php echo $this->Html->link("活動カレンダーの一覧", array('controller' => 'activity','action'=> 'index'));?></div>
				<div class="link_item wf-roundedmplus1c"><?php echo $this->Html->link("活動報告の一覧", array('controller' => 'activity','action'=> 'reportIndex'));?></div>
			</div><!-- /.activity_link_block -->
		</article>
	</div><!-- /.outline_contents -->
</div><!-- /.contents_wrap -->