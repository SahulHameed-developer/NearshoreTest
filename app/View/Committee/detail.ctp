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
     var iinkainm = $("#iinkainm").val();
     var iinkaicd = $("#iinkaicd").val();
        $.confirm({
        title: '',
        content: 'この委員会への入会申込メールを送信します。<br>よろしいですか？',
        type: 'blue',
        buttons: {
          OK: {
            action: function(){
              $(".jconfirm-box-container").css("display","none");
              $.ajax({
                url    : '../Committee/mailsend',
                type   : 'POST',
                data   : {'iinkainm': iinkainm , 'iinkaicd' : iinkaicd},
                async: false,
                success : function(data){
                  $("#frmCommittee").submit();
                },
                error : function(errorData){
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
              });
            }
          },
          キャンセル: function () {
          }
        }
      });
  });
  $(".activitycalendar").click(function(){
    $('#frmCommittee').attr('target', '_blank');
    $('#frmCommittee').attr('action', '../Activity/search');
    $('#frmCommittee').submit();
  });
  $(".activityreport").click(function(){
    $('#frmCommittee').attr('target', '_blank');
    $('#frmCommittee').attr('action', '../Activity/reportSearch');
    $('#frmCommittee').submit();
  });

});
</script>
<body id="top">
  <div id="wrap" class="about_wrap committeeDetail_contents">
    <main id="main_wrap">
      <!-- メインビジュアル終わり -->
      <div class="contents_wrap">
        <div class="contents frame">
          <article class="article">
          <?php echo $this->Form->create('frmCommittee', ['enctype' => 'multipart/form-data','id' => 'frmCommittee', 'url' => ['controller' => 'Committee', 'action' => 'index']]); 
          echo $this->Form->input('iinkainm', array('type' => 'hidden','id'=> 'iinkainm','value'=>$TIinkai[0]['MIinkai']['iinkainm'])); 
          echo $this->Form->input('iinkaicd', array('type' => 'hidden','id'=> 'iinkaicd','value'=>$this->request->data['iinkaicd']));
          ?>
            <h1 class="h1 wf-roundedmplus1c"><span><?php echo $TIinkai[0]['MIinkai']['iinkainm'];?></span></h1>
              <div class="detail_contents">
                <div class="article type_01" style="border-bottom: none;">
                  <div class="article_wrap">
                    <div class="article_block">
                      <dl class="break_line">
                        <dt>概要</dt>
                          <dd><?php echo nl2br($TIinkai[0]['TIinkai']['gaiyou']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>業務内容</dt>
                        <dd><?php echo nl2br($TIinkai[0]['TIinkai']['syokumu']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt style="vertical-align: top;">委員長</dt>
                        <dd>
                          <?php echo (isset($chairman['TKaisya']['kaisyanm'])) ? $chairman['TKaisya']['kaisyanm']."　" : ''; ?>
                          <?php echo (isset($chairman['TKaiin']['kaiinnm'])) ? $chairman['TKaiin']['kaiinnm'] : ''; ?>
                        </dd>
                      </dl>
                      <dl class="break_line">
                        <dt style="vertical-align: top;">委員</dt>
                        <dd><?php if(isset($commissioner)) { ?>
                            <table style="width: auto;">
                            <?php foreach ($commissioner as $key => $commissioner) { ?>
                            <tr>
                              <td style="padding: 0px;border:none;"><?php echo (isset($commissioner['TKaisya']['kaisyanm'])) ? $commissioner['TKaisya']['kaisyanm'] : ''; ?></td>
                              <td style="padding: 0px;border:none;"><?php echo (isset($commissioner['TKaiin']['kaiinnm'])) ? "　".$commissioner['TKaiin']['kaiinnm'] : ''; ?></td>
                            </tr>
                            <?php } ?>
                            </table>
                            <?php } ?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>入会条件</dt>
                        <dd><?php echo nl2br($TIinkai[0]['TIinkai']['njyoken']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>入会方法</dt>
                        <dd><?php echo nl2br($TIinkai[0]['TIinkai']['nhouhou']);?></dd>
                      </dl>
                      <dl class="break_line">
                        <dt>備考</dt>
                        <dd><?php echo nl2br($TIinkai[0]['TIinkai']['bikou']);?></dd>
                      </dl>
                      <?php if(!isset($this->request->data['previewflg'])) { ?>
                      <div class="committeeDetail_link_block clearfix">
                        <div class="link_item wf-roundedmplus1c activitycalendar"><a><?php echo $this->Form->button("この委員会の活動カレンダー",array('type'=>'button'));?></a></div>
                        <div class="link_item wf-roundedmplus1c activityreport"><a><?php echo $this->Form->button("この委員会の活動報告",array('type'=>'button'));?></a></div>
                      </div><!-- /.committeeDetail_link_block -->
                      <?php } ?>
                    </div><!-- /.article_block -->
                    <div id="windowsize" class="not-active figure_block clearfix">
                    <?php foreach ($syasinData as $key => $syasinData) { ?>
                      <figure class="figureSize padbt55" style="height: 280px;">
                        <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/getSyasin/".$syasinData['TSyasin']['rno']."/".$syasinData['TSyasin']['syasinkey'];?>" data-lightbox="img_1">
                        <img src="<?php echo $this->base."/Committee/getSyasin/".$syasinData['TSyasin']['rno']."/".$syasinData['TSyasin']['syasinkey'];?>" class="maxsize_osiraseSyasin"/>
                        </a>
                        <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $syasinData['TSyasin']['title']; ?></figcaption>
                      </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin1'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin1";?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin1";?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin1Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image1 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image1;?>" data-lightbox="img_1">
                      <img src="<?php echo $image1;?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin1Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin2'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin2";?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin2";?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin2Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image2 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image2;?>" data-lightbox="img_1">
                      <img src="<?php echo $image2;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin2Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin3'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin3"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin3"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin3Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image3 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image3;?>" data-lightbox="img_1">
                      <img src="<?php echo $image3;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin3Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin4'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin4"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin4"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin4Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image4 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image4;?>" data-lightbox="img_1">
                      <img src="<?php echo $image4;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin4Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin5'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin5"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin5"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin5Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image5 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image5;?>" data-lightbox="img_1">
                      <img src="<?php echo $image5;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin5Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin6'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin6"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin6"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin6Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image6 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image6;?>" data-lightbox="img_1">
                      <img src="<?php echo $image6;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin6Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin7'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin7"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin7"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin7Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image7 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image7;?>" data-lightbox="img_1">
                      <img src="<?php echo $image7;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin7Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin8'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin8"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin8"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin8Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image8 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image8;?>" data-lightbox="img_1">
                      <img src="<?php echo $image8;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin8Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                  <?php if (!empty($previewInfo['syasin9'])) {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $this->base."/Committee/viewSyasin/syasin9"; ?>" data-lightbox="img_1">
                      <img src="<?php echo $this->base."/Committee/viewSyasin/syasin9"; ?>" class="maxsize_osiraseSyasin"/>
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin9Title']; ?></figcaption>
                    </figure>
                  <?php } else if($image9 != "") {?>
                    <figure class="figureSize padbt55" style="height: 280px;">
                      <a class="imgzoom outerSyasin" href="<?php echo $image9;?>" data-lightbox="img_1">
                      <img src="<?php echo $image9;?>" class="maxsize_osiraseSyasin">
                      </a>
                      <figcaption style="display: block;width: 270px; text-align: center;" class="figcaption"><?php echo $committeeinfo['TIinkai']['syasin9Title']; ?></figcaption>
                    </figure>
                  <?php } ?>
                    </div><!-- /.dl_section -->
                  </div><!-- /.caption_block -->
                </div><!-- /.article_wrap -->
              </div><!-- /.type_01 -->
              <?php if(!isset($this->request->data['previewflg'])) { ?>
              <div class="committee_link_block clearfix">
                <div class="link_item event_detail f_left">
                  <?php echo $this->Html->link("戻る",  array('action' => '../Committee/index' )); ?>
                </div>
                <div class="link_item event_contact wf-roundedmplus1c f_right">
                  <a href="javascript:;" class="moshiKomi"><?php echo $this->Form->button("この委員会に入会を申し込む",array('type'=>'button','disabled' => $disflg)); ?></a>
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
