<!-- ========== main ========== -->
<section class="about-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
				<li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
				<li><?php echo $this->Html->link("会員企業PRサイトとは", array('controller' => 'about','action'=> 'index'));?></li>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="about-main-inner container">

			<h1>会員企業PRサイトとは</h1>

			<ul>
				<li>
					<h2>会員企業PRサイトとは</h2>
					<p>ニアショアＩＴ協会では経営者の方々の「学び」「仲間作り」「相互扶助」をキーワードに様々な事業活動を展開しております。当サイトもその活動の一環として会員企業様が自社商品・サービスをみんなにアピールして、ビジネスマッチングを促進するサイトです。<br>ウェブ上で商品・サービスの情報を検索することができ、気に入った商品・サービスがあれば会員企業様間で商談していただけます。<br>仲良くなった会員様、又は関心を持たれた会員様の企業が取り扱う商品やサービスをご覧いただき、ビジネスネットワークの拡大・開拓に是非お役立てください。</p>
				</li>
				<li>
					<h2>商談の方法について</h2>
					<p>当サイトで掲載企業の商品・サービスをご覧になる中で、商談等をご希望される場合は、以下2通りの方法のいずれかにてご対応ください。</p>
					<dl>
						<dt>【方法1】</dt>
						<dd>各会員企業ページの「ニアショアＩＴ協会を通じてこの企業に問い合わせする」ボタンをクリックしてお問い合わせください。<br>事務局から先方企業に問い合わせをし、回答をお返事致します。</dd>
					</dl>
					<dl>
						<dt>【方法2】</dt>
						<dd>掲載企業の会社概要にある担当者へ直接ご連絡ください。<br>その際には、当サイトをご覧になったことをお伝えください。</dd>
					</dl>
				</li>
				<li>
					<h2>掲載を希望される会員様へ</h2>
					<p>掲載をご希望の会員企業様は、「<?php echo $this->Html->link("掲載について", array('controller' => 'publication','action'=> 'index'));?>」をご覧いただき、事務局までお申し込みください。</p>
				</li>
			</ul>

		</div><!-- /about-main-inner -->

	</main>
</section>
<!-- ========== /main ========== -->
<script>
	$(function() {
		$('#submit').attr('disabled', 'disabled');
		$('#check').click(function() {
			if ($(this).prop('checked') == false) {
				$('#submit').attr('disabled', 'disabled');
			} else {
				$('#submit').removeAttr('disabled');
			}
		});
	});
</script>