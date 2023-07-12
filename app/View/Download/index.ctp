<!DOCTYPE html>
<html lang="ja">
<?= $this->html->css('download/style.css') ?>
<?php $curtime = "?time=".date('dmYHis'); ?>
<script type="text/javascript">
  $(function(){
      function sessionTimeCheck(event) {
        var logoutStatus = window.localStorage.getItem("LogoutStatus");
        if (logoutStatus == 1) {
          return false;
        }
      }
      $('a.sessionTimeCheck').click(sessionTimeCheck);
  });
</script>
<body id="top">
  <div id="wrap" class="about_wrap download_contents">
    <main id="main_wrap">
      <!-- メインビジュアル終わり -->
      <div class="contents_wrap">
        <div class="contents frame">
          <article class="article">
            <h1 class="h1 wf-roundedmplus1c"><span>ダウンロード</span></h1>
            <div class="dl_section clearfix">
              <?php 
                if(!empty($Dlcatenm)): 
                  $cateCnt = 0;
                  foreach($Dlcatenm as $Dlcatename): 
                    $cateCnt++;
                    if($cateCnt%2 != 0):
                      echo "<table><tr><td style='border-bottom: 0px !important;'>";
                    endif;?>           
                    <section class="section" >
                      <h2 class="h2 h2_dot wf-roundedmplus1c"><?php echo $Dlcatename['MDlcate']['dlcatenm'] ?></h2>
                      <ul class="dl_list">
                        <?php if(!empty($FileData)): foreach($FileData as $FileInfo): ?>   
                          <?php if ($Dlcatename['MDlcate']['arno'] == $FileInfo['TDlfile']['cateno']) : 
                            if($fileKey != $FileInfo['TDlfile']['file']) :
                            if (file_exists(WWW_APP_ROOT.$downloadFilePath.$FileInfo['TFile']['filepath'])) : ?>
                              <li><a href="<?php echo Router::url('/', true).WWW_APP_ROOT.$downloadFilePath.$FileInfo['TFile']['filepath']; ?>" class = "sessionTimeCheck" <?php if(!isset($previewadmin)):?> target="_blank" download <?php endif;?>><?php echo $FileInfo['TFile']['title']; ?></a></li>
                            <?php else: ?>
                              <li><span tooltip="ファイルが存在しません。"><?php echo $FileInfo['TFile']['title']; ?></span></li>
                           <?php endif; endif; endif; ?>
                        <?php endforeach; else: ?>
                        <?php endif; ?>
                        <?php if(isset($previewadmin) && ($Prev_Dlcatenm == $Dlcatename['MDlcate']['arno']) ): ?>
                          <?php $filename2 = split('/',$previewInfo ['fileName']); ?>
                          <?php if(isset($filename2[1])) { ?>
                          	<li><?php echo $this->Html->link($Prev_FileData['title'],Router::url('/', true).WWW_APP_ROOT.$downloadFilePath.$previewInfo ['fileName']); ?></li>
                          <?php } else { ?>
                          	<li><?php echo $this->Html->link($Prev_FileData['title'],'viewFile/file'); ?></li>
                          <?php } ?>
                        <?php endif; ?>
                      </ul>
                    </section>
                    <?php 
                      if($cateCnt%2 == 0):
                        echo "</td></tr></table>";
                      endif;
                  endforeach;
                  if($cateCnt%2 != 0):
                    echo "</td></tr></table>";
                  endif;?>
            <?php endif; ?>
            </div><!-- /.dl_section -->
          </article>
        </div><!-- /.outline_contents -->
      </div><!-- /.contents_wrap -->
    </main><!-- /.main_wrap -->
</body>
</html>
