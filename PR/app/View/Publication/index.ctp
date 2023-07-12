<!-- ========== main ========== -->
<section class="publication-main">
	<main>

		<div class="breadcrumb-container">
			<ul class="breadcrumb-bar">
				<li><?php echo $this->Html->link("HOME", array('controller' => 'top','action'=> 'index'));?></li>
				<li><?php echo $this->Html->link("掲載について", array('controller' => 'publication','action'=> 'index'));?></li>
			</ul>
		</div><!-- /breadcrumb-container -->

		<div class="publication-main-inner container">

			<h1>掲載について</h1>

			<ul>
				<li>
					<h2>掲載のお申込みについて</h2>
					<p>当サイトに掲載をご希望される場合は、以下2通りの方法のいずれかにてご対応ください。</p>
					<dl>
						<dt>【方法1】</dt>
						<dd>事務局まで、電話またはメールでご連絡ください。<br>事務局より掲載申込書類をお送りいたします。<br>必要事項をご記入の上、事務局までお送りください。</dd>
					</dl>
					<dl>
						<dt>【方法2】</dt>
						<dd>当協会ホームページの会員専用ページよりログインして頂き、掲載申込書類をダウンロードしてください。<br>必要事項をご記入の上、事務局までお送りください。</dd>
					</dl>
				</li>
				<li>
					<h2>留意事項について</h2>
					<ol>
						<li>当サイトへの掲載により商談の成約をお約束するものではございませんので、予めご了承ください。</li>
						<li>商談内容については、事務局を通じて連絡された場合においても、一切関知いたしません。会員企業様当事者の責任において、商談を行っていただくものとします。</li>
						<li>当サイトへの商品およびサービスの掲載、更新作業等については、会員企業様の責任において行っていただきます。</li>
					</ol>
				</li>
				<li>
					<h2>事務局の連絡先について</h2>
					<p>掲載についてのお問い合わせ、ご連絡は下記までお願い致します。</p>
					<div class="publication-info-box">
						<p class="publication-info1">ニアショアＩＴ協会</p>
						<p class="publication-info2">TEL：03-6327-7070 / FAX：03-3295-7111</p>
						<p class="publication-info2">MAIL：<a href="mailto:info@nearshore-it.jp">info@nearshore-it.jp</a></p>
						<p class="publication-info2">〒101-0048 東京都千代田区神田司町2丁目13番 神田第4アメレックスビル8F</p>
					</div>
				</li>
			</ul>

		</div><!-- /publication-main-inner -->

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