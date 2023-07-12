<?php if(isset($_SESSION['Auth']['User']['TKaiin']['kaiinnm']) && $_SESSION['Auth']['User']['TKaiin']['kaiinnm'] != "") {?>
  <script type="text/javascript">
    window.location = "<?php echo $this->Html->url(array('controller' => 'Top', 'action' => 'index')); ?>";
  </script>
<?php }?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="">
<meta name="format-detection" content="address=no,email=no,telephone=no">
<!-- OGP -->
<meta property="og:title" content="ログイン｜一般社団法人ニアショアＩＴ協会">
<meta property="og:type" content="website">
<meta property="og:url" content="/login/">
<meta property="og:image" content="">
<meta property="og:description" content="">
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="一般社団法人ニアショアＩＴ協会">
<title>ログイン｜一般社団法人ニアショアＩＴ協会</title>
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
<?= $this->Html->script('login/index.js') ?>

</head>
<body id="top">
  <div id="wrap" class="members_wrap members_contents">
    <main id="main_wrap">
      <div class="contents_wrap">
        <div class="contents">
          <p class="logo"><a href="Top"><?php echo $this->Html->image('login/logo.png', array('alt' => 'ニアショアIT協会 一般社団法人ニアショアＩＴ協会'));?></a></p>
          <h1 class="h1">会員ログイン</h1>
          <?php echo $this->Form->create('loginfrm',['name'=>'loginfrm','id'=>'loginfrm','url' => ['controller' => 'login', 'action' => 'index']]);?>
            <div class="form_contents">
              <p class="description">ユーザー名・パスワードを入力してログインしてください。</p>
              <div class="login_box">
                <p class="user_login">
                  <label for="lgid">
                    <span>ユーザー名</span>
                    <input type="text" name="lgid" id="lgid" style="padding: 8px 5px;" class="input fntsize_lgn_usr" value="<?php echo $username; ?>">
                    <div id="errordiv_lgid" class="ml85" style="margin-top:-10px;margin-left: 22%;padding-bottom: 20px;"></div>
                  </label>
                </p>
                <p class="user_pass">
                  <label for="lgpass">
                    <span>パスワード</span>
                    <input type="password" name="lgpass" id="lgpass" style="padding: 4px 0 8px 5px;" class="input fntsize_lgn_pass" value="">
                    <div id="errordiv_lgpass" class="ml85" style="margin-top:5px;margin-left: 22%;"></div>
                  </label>
                </p>
              </div><!-- /.login_box -->
              <div class="submit_btn">
                <?php echo $this->Form->submit("ログイン", array('class' =>'roundedmplus1c','id'=>'loginbtn','name' =>'loginbtn','controller' => 'login','action'=> 'index'));?>
              </div>
            </div><!-- /.form_contents -->
          <?php echo $this->Form->end();?>
          <p id="nav">
            <?php echo $this->Html->link("> パスワードを忘れた方はこちら", array('controller' => 'PasswordChange','action'=> 'irai'));?></p>
          </p>
        </div><!-- /.contents -->
        <p id="backtoblog">
          <?php echo $this->Html->link("< 一般社団法人ニアショアＩＴ協会 に戻る", array('controller' => 'top','action'=> 'index'));?>
        </p>
        <div class="message" style="margin-top: 20px;"><?php echo $this->Flash->render('auth'); echo $this->Session->flash();?></div>
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