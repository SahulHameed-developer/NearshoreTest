<!DOCTYPE html>
<html lang="ja">
<?= $this->html->css('activity/style.css') ?>
<?= $this->html->css('committee/style.css') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/lightbox.css') ?>
<?= $this->Html->script('common/lightbox.js') ?>
<script type="text/javascript">
$(document).ready(function() {
  $(".moshiKomi").click(function(){
     var kurabunm = $("#kurabunm").val();
     var kurabucd = $("#kurabucd").val();
        $.confirm({
        title: '',
        content: 'この倶楽部への入部申込メールを送信します。<br>よろしいですか？',
        type: 'blue',
        buttons: {
          OK: {
            action: function(){
              $(".jconfirm-box-container").css("display","none");
              $.ajax({
                url    : '../Club/mailsend',
                type   : 'POST',
                data   : {'kurabunm': kurabunm , 'kurabucd' : kurabucd},
                async: false,
                success : function(data){
                  if(data == 1){
                    mailError();
                  }else{
                   $("#frmClub").submit();
                  }
                },
                error : function(errorData){
                 mailError();
                }
              });
            }
          },
          キャンセル: function () {
          }
        }
      });
  });
  $(".activitycalendar").click(function(){
    $('#frmClub').attr('target', '_blank');
    $('#frmClub').attr('action', '../Activity/search');
    $('#frmClub').submit();
  });
  $(".activityreport").click(function(){
    $('#frmClub').attr('target', '_blank');
    $('#frmClub').attr('action', '../Activity/reportSearch');
    $('#frmClub').submit();
  });
  
});
function mailError(){
     $.confirm({
        title: '',
        content: '申し込みが出来ませんでした。<br>事務局へ直接お問い合わせください。',
        type: 'blue',
        buttons: {
          OK: {
                btnClass: 'btn-blue',
                keys: ['enter']                                 
              }
        }
    });
  }
</script>
<body id="top">
  <div id="wrap" class="about_wrap committeeDetail_contents">
    <main id="main_wrap">
      <!-- メインビジュアル終わり -->
      <div class="contents_wrap">
        <div class="contents frame">
          <article class="article">
          <?php echo $this->Form->create('frmClub', ['enctype' => 'multipart/form-data','id' => 'frmClub', 'url' => ['controller' => 'Club', 'action' => 'index']]); 
          echo $this->Form->input('kurabunm', array('type' => 'hidden','id'=> 'kurabunm','value'=>$TKurabu[0]['MKurabu']['kurabunm'])); 
          echo $this->Form->input('kurabucd', array('type' => 'hidden','id'=> 'kurabucd','value'=>$TKurabu[0]['TKurabu']['kurabucd']));
         ?>
            <h1 class="h1 wf-roundedmplus1c"><span><?php echo $TKurabu[0]['MKurabu']['kurabunm'];?></span></h1>
              <div class="detail_contents">
                <div class="article type_01" style="border-bottom: none;">
                  <div class="article_wrap">
                    <div class="article_block">
                      <dl class="break_line">
                        <dt>概要</dt>
                          <dd><?php echo nl2br($TKurabu[0]['TKurabu']['gaiyou']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>設立趣旨</dt>
                        <dd><?php echo nl2br($TKurabu[0]['TKurabu']['syokumu']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>代表幹事</dt>
                        <dd><?php echo nl2br($TKurabu[0]['TKurabu']['kanji']);?></dd>
                        </dl>
                      <dl class="break_line">
                        <dt>メンバー</dt>
                          <dd><?php echo nl2br($TKurabu[0]['TKurabu']['kmember']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>入部条件</dt>
                        <dd><?php echo nl2br($TKurabu[0]['TKurabu']['njyoken']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>入部方法</dt>
                        <dd><?php echo nl2br($TKurabu[0]['TKurabu']['nhouhou']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>備考</dt>
                        <dd><?php echo nl2br($TKurabu[0]['TKurabu']['bikou']);?></dd>
                      </dl>
                      <?php if(!isset($this->request->data['previewflg'])) { ?>
                      <div class="committeeDetail_link_block clearfix">
                        <div class="link_item wf-roundedmplus1c activitycalendar"><a><?php echo $this->Form->button("この倶楽部の活動カレンダー",array('type'=>'button'));?></a></div>
                        <div class="link_item wf-roundedmplus1c activityreport"><a><?php echo $this->Form->button("この倶楽部の活動報告",array('type'=>'button'));?></a></div>
                      </div><!-- /.committeeDetail_link_block -->
                      <?php } ?>
                    </div><!-- /.article_block -->
                    <div id="windowsize" class="not-active figure_block clearfix">
                    <?php foreach ($syasinData as $key => $syasinData) { ?>
                      <figure class="figureSize padbt55" style="height: 280px;">
                        <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/getSyasin/".$syasinData['TSyasin']['rno']."/".$syasinData['TSyasin']['syasinkey'];?>" data-lightbox="img_1">
                        <img src="<?php echo $this->base."/Club/getSyasin/".$syasinData['TSyasin']['rno']."/".$syasinData['TSyasin']['syasinkey'];?>" class="maxsize_osiraseSyasin"/>
                        </a>
                        <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $syasinData['TSyasin']['title']; ?></figcaption>
                      </figure>
                    <?php } ?>
                  <?php if (!empty($previewInfo['syasin1'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin1";?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin1";?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin1Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image1 != "") { ?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image1;?>" data-lightbox="img_1">
                      <img src="<?php echo $image1;?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin1Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin2'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin2";?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin2";?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin2Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image2 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image2;?>" data-lightbox="img_1">
                      <img src="<?php echo $image2;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin2Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin3'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin3"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin3"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin3Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image3 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image3;?>" data-lightbox="img_1">
                      <img src="<?php echo $image3;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin3Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin4'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin4"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin4"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin4Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image4 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image4;?>" data-lightbox="img_1">
                      <img src="<?php echo $image4;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin4Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin5'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin5"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin5"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin5Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image5 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image5;?>" data-lightbox="img_1">
                      <img src="<?php echo $image5;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin5Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin6'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin6"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin6"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin6Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image6 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image6;?>" data-lightbox="img_1">
                      <img src="<?php echo $image6;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin6Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin7'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin7"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin7"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin7Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image7 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image7;?>" data-lightbox="img_1">
                      <img src="<?php echo $image7;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin7Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin8'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin8"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin8"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin8Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image8 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image8;?>" data-lightbox="img_1">
                      <img src="<?php echo $image8;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin8Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin9'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Club/viewSyasin/syasin9"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Club/viewSyasin/syasin9"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin9Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image9 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image9;?>" data-lightbox="img_1">
                      <img src="<?php echo $image9;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $clubinfo['TKurabu']['syasin9Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                    </div><!-- /.dl_section -->
                  </div><!-- /.caption_block -->
                </div><!-- /.article_wrap -->
              </div><!-- /.type_01 -->
              <?php if(!isset($this->request->data['previewflg'])) { ?>
              <div class="committee_link_block clearfix">
                <div class="link_item event_detail f_left">
                  <?php echo $this->Html->link("戻る",  array('action' => '../Club/index' )); ?>
                </div>
                <div class="link_item event_contact wf-roundedmplus1c f_right">
                  <a href="javascript:;" class="moshiKomi"><?php echo $this->Form->button("この倶楽部に入部を申し込む",array('type'=>'button','disabled' => $disflg)); ?></a>
                </div>
              </div>
              <?php } ?>
            </div><!-- /.detail_contents -->                
            <?php echo $this->Form->end();?>
          </article>
        </div><!-- /.outline_contents -->
      </div><!-- /.contents_wrap -->
    </main><!-- /.main_wrap -->
</body>
</html>
<script type="text/javascript">
  if($(window).width() > 769) {
    $(document).find("#windowsize").removeClass('not-active');
  }
</script>
