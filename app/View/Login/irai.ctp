<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="">
<meta name="format-detection" content="address=no,email=no,telephone=no">

<!-- OGP -->
<meta property="og:title" content="パスワード再発行依頼｜一般社団法人ニアショアＩＴ協会">
<meta property="og:type" content="website">
<meta property="og:url" content="/login/">
<meta property="og:image" content="">
<meta property="og:description" content="">
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">

<title>パスワード再発行依頼｜一般社団法人ニアショアＩＴ協会</title>

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
          <h1 class="h1">パスワード再発行依頼</h1>	

		   <?php echo $this->Form->create('loginindex', ['id' => 'loginindex', 'url' => ['controller' => 'Login', 'action' => 'home']]); echo $this->Form->end();?>
		   <?php echo $this->Form->create('pwdMailSendFrm',['name'=>'pwdMailSendFrm','id'=>'pwdMailSendFrm','url' =>['controller' => 'PasswordChange', 'action' => 'sendMail']]);?>
            <div class="form_contents">
              <p class="description" style="text-align:left;margin-left:5px;line-height: 1.3;">会員登録されているメールアドレスを入力してください。<br/>再発行画面のＵＲＬが自動で登録メールアドレスに送信されます。</p>

              <div class="login_box" style="padding: 0 10px;">
                <p class="user_login">
                  <label for="mailaddr">
                    <span class="txtbox">登録メールアドレス</span>
                    <input type="text" name="mailaddr" id="mailaddr" class="input underscoresingle fntsize_lgn_fld" value="<?php echo $mailadd; ?>" style="padding: 8px 5px;">
                    <div id="errordiv_mailaddr" class="ml205 errordiv_mailaddr" style="margin-top: -20px;padding-bottom: 20px;"></div>
                  </label>
                </p>
                <p class="user_pass">
                  <label for="cmailaddr">
                    <span class="txtbox">登録メールアドレス(確認用)</span>
                    <input type="text" name="cmailaddr" id="cmailaddr" class="underscoresingle fntsize_lgn_fld input" value="<?php echo $cmailadd; ?>" style="padding: 8px 5px;">
                    <div id="errordiv_cmailaddr" class="ml205 errordiv_mailaddr" style="padding-bottom: 20px;"></div>
                  </label>
                </p>
              </div><!-- /.login_box -->

              <div class="submit_btn">
                <?php echo $this->Form->submit("送信", array('class' =>'roundedmplus1c','id'=>'submit','name' =>'submit','controller' => 'PasswordChange','action'=> 'saihakko'));?>
              </div>
            </div><!-- /.form_contents -->
          <?php echo $this->Form->end();?>

        </div><!-- /.contents -->

        <p id="backtoblog">
          <?php echo $this->Html->link("< ログイン画面へ戻る", array('controller' => 'Login','action'=> 'index'));?>
        </p>
        <div class="message" style="margin-top: 20px;"><?php echo $this->Flash->render('auth'); echo $this->Session->flash();?></div>
		<center><font color='red'><label class="Errtxt" style="font-size: 1.3rem !important;"></label></font></center>
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
<script type = "text/javascript" >
  history.pushState(null, null, '');
  window.addEventListener('popstate', function(event) {
  history.pushState(null, null, '');
  });
</script>
</body>
</html>