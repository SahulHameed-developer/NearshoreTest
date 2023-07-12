<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="">
<meta name="format-detection" content="address=no,email=no,telephone=no">

<!-- OGP -->
<meta property="og:title" content="パスワード再発行｜一般社団法人ニアショアＩＴ協会">
<meta property="og:type" content="website">
<meta property="og:url" content="/login/">
<meta property="og:image" content="">
<meta property="og:description" content="">
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">

<title>パスワード再発行｜一般社団法人ニアショアＩＴ協会</title>

<!-- style -->
<!-- style/common -->
<?= $this->html->css('common/common.css') ?>
<!-- style/activity -->
<?= $this->html->css('login/style.css') ?>
<!-- webfont -->
<link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">

<!--[if lt IE 9]><script src="../common/js/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="../common/js/selectivizr.min.js"></script><![endif]-->
<?= $this->Html->script('common/jquery.min.js') ?>
<?= $this->Html->script('common/jquery.validate.min.js') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('login/index.js') ?>
</head>
<style type="text/css">
	.back-g {
		padding: 10px 0 20px 0 !important;
	}
	.updatecls {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ2JSIgeT0iNTIlIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+6YCB5L+h5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
		background-color: rgba(255, 255, 255, .5);
	}
  .screenwdt {
    width: auto;
  }
  .errordiv_mailaddr {
    margin-left: 36%;
  }
  @media screen and (min-width: 769px) {
    .screenwdt {
      width: 560px;
    }
    .errordiv_mailaddr {
      margin-left: 41%;
    }
  }
</style>
<div id="updatecls"></div>
<body id="top">
  <div id="wrap" class="members_wrap members_contents">
    <main id="main_wrap">
      <div class="contents_wrap screenwdt">
        <div class="contents">
          <p class="logo"><a href="Top"><?php echo $this->Html->image('login/logo.png', array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></a></p>
          <h1 class="h1">パスワード再発行</h1>	

           <?php echo $this->Form->create('pwdchangefrm',['name'=>'pwdchangefrm', 'type' => 'post', 'id'=>'pwdchangefrm','url' =>['controller' => 'PasswordChange', 'action' => 'finish']]);
				echo $this->Form->input('kaiincd', array('name' => 'kaiincd','id' => 'kaiincd','type' => 'hidden', 'value'=>$kaiincd));
			?>
            <div class="form_contents">
              <p class="description">新しいパスワードを入力してください。</p>

              <div class="login_box" style="padding: 0 10px;">
                <p class="user_login">
                  <label for="kaiinnm">
                    <span class="txtbox">会員名称</span>
                    <input type="text" name="kaiinnm" id="kaiinnm" readonly="readonly" value="<?php echo $kaiinnm; ?>">
                  </label>
                </p>
                <p class="user_pass">
                  <label for="pwd">
                    <span class="txtbox">新しいパスワード</span>
                    <input type="password" name="pwd" id="pwd" placeholder="半角英字・数字・記号を含めて6文字以上">
                    <div id="errordiv_pwd" class="ml205 errordiv_mailaddr"></div>
                  </label>
                </p>
                <p class="user_pass" style="padding-top: 20px;">
                  <label for="re_pwd">
                    <span class="txtbox">新しいパスワード（確認用）</span>
                    <input type="password" name="re_pwd" id="re_pwd" placeholder="半角英字・数字・記号を含めて6文字以上">
                    <div id="errordiv_re_pwd" class="ml205 errordiv_mailaddr"></div>
                  </label>
                </p>
              </div><!-- /.login_box -->

              <div class="submit_btn">
                <?php echo $this->Form->submit("再発行", array('class' =>'roundedmplus1c','id'=>'submit','name' =>'submit','controller' => 'PasswordChange','action'=> 'finish'));?>
              </div>
            </div><!-- /.form_contents -->
           <?php echo $this->Form->end();?>
        </div><!-- /.contents -->

        <div class="message" style="margin-top: 10px;"><?php echo $this->Flash->render('auth'); echo $this->Session->flash();?></div>
      </div><!-- /.contents_wrap -->
    </main><!-- /.main_wrap -->

    <!-- footer -->
    <footer>
      <div class="copyright">
        <div class="frame">
          <?php echo $this->element('copyrights'); ?>
        </div><!-- /.frame -->
      </div><!-- /.copyright -->
    </footer>
    <!-- /footer -->
  </div><!-- /#wrap -->
</body>
</html>