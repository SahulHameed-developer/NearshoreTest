<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="description" content="">
		<meta name="format-detection" content="address=no,email=no,telephone=no">
		<!-- OGP -->
		<meta property="og:type" content="website">
		<meta property="og:image" content="">
		<meta property="og:description" content="">
		<meta property="og:locale" content="ja_JP">
		<meta property="og:title" content="お知らせ詳細のタイトル｜一般社団法人ニアショアＩＴ協会">
		<meta property="og:url" content="/news/details/170000/">
		<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
		<title>お知らせ詳細のタイトル｜一般社団法人ニアショアＩＴ協会</title>
		<!-- style/common -->
		 <?= $this->html->css('common/common.css') ?>
		 <?= $this->html->css('news/style.css') ?>
		 <?= $this->Html->script('news/index.js') ?>
		<!-- webfont -->
		<link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">
		<!--[if lt IE 9]><script src="./common/js/html5shiv.js"></script><![endif]-->
		<!--[if lt IE 9]><script src="./common/js/selectivizr.min.js"></script><![endif]-->
	</head>
	<body id="top">
		<div id="wrap" class="news_wrap news_detail_contents">
			<!-- /header -->
			<main id="main_wrap">
				<div class="row">
					<div class="contents_wrap">
						<div class="contents frame">
							<article>
								<h1 class="h1 wf-roundedmplus1c">
									<span>
										<span class="headline"><?php echo $previewInfo['title'];?></span>
										<span class="date"><?php echo $this->Common->getDateFormat($previewInfo['torokuDate']);?></span>
									</span>
								</h1>
								<div class="detail_contents">
									<div class="description">
										<p><?php echo $previewInfo['naiyo'];?></p>
									</div><!-- /.descriptio -->
									<div class="figure_block clearfix">
									<?php if(!empty($previewInfo['syasin1'])):?>
										<figure class="figureSize">
											<img src="<?php echo $this->base."/adminNews/getViewSyasin/syasin1";?>" style="width:100%!important"/>
											<figcaption class="figcaption"><?php echo $previewInfo['syasin1Title']; ?></figcaption>
										</figure>
									<?php endif; ?>
									<?php if(!empty($previewInfo['syasin2'])):?>
										<figure class="figureSize">
											<img src="<?php echo $this->base."/adminNews/getViewSyasin/syasin2";?>" style="width:100%!important"/>
											<figcaption class="figcaption"><?php echo $previewInfo['syasin2Title']; ?></figcaption>
										</figure>
									<?php endif; ?>
									<?php if(!empty($previewInfo['syasin3'])):?>
										<figure class="figureSize">
											<img src="<?php echo $this->base."/adminNews/getViewSyasin/syasin3";?>" style="width:100%!important"/>
											<figcaption class="figcaption"><?php echo $previewInfo['syasin3Title']; ?></figcaption>
										</figure>
									<?php endif; ?>
									</div><!-- /.caption_block -->
									<div class="attachment_block">
									<?php if(!empty($previewInfo['file1'])):?>
										<dl>
											<dt><?php echo $previewInfo['file1Title']; ?></dt>
											<dd><?php echo $this->Html->link(Router::url('/', true).WWW_APP_ROOT.'/'.$previewInfo['file1Name'],'getViewfile/file1',['target' => '_blank', 'download'=>$previewInfo['file1Name']]); ?></dd>
										</dl>
									<?php endif; ?>
									<?php if(!empty($previewInfo['file2'])):?>
										<dl>
											<dt><?php echo $previewInfo['file2Title']; ?></dt>
											<dd><?php echo $this->Html->link(Router::url('/', true).WWW_APP_ROOT.'/'.$previewInfo['file2Name'],'getViewfile/file2',['target' => '_blank', 'download'=>$previewInfo['file2Name']]); ?></dd>
										</dl>
									<?php endif; ?>
									<?php if(!empty($previewInfo['file3'])):?>
										<dl>
											<dt><?php echo $previewInfo['file3Title']; ?></dt>
											<dd><?php echo $this->Html->link(Router::url('/', true).WWW_APP_ROOT.'/'.$previewInfo['file3Name'],'getViewfile/file3',['target' => '_blank', 'download'=>$previewInfo['file3Name']]); ?></dd>
										</dl>
									<?php endif; ?>
									</div><!-- /.attachment_block -->
								</div><!-- /.detail_contents -->
								<div class="link_block">
									<div class="link_item">
									<?php echo $this->Html->link("戻る", array('controller' => 'adminNews','action'=> 'add'));?>
									</div>
								</div><!-- /.link_block -->
							</article>
						</div><!-- /.contents -->
					</div><!-- /.contents_wrap -->			
				</div>
			</main>
		</div><!-- /#wrap -->
	</body>
</html>