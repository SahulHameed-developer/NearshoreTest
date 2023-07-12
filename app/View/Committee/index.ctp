<!DOCTYPE html>
<html lang="ja">
<?= $this->html->css('committee/style.css') ?>
<script type="text/javascript">
$(document).ready(function() {
  $(".detailpage").click(function(){
    // alert('未作成');
    var id = $(this).attr('id');
    var spl = id.split('$$');

    $("#iinkaicd").val(spl[0]);
    $("#ssyasinkey").val(spl[1]);
    $('#frmCommittee').submit();
  });
});
</script>
<body id="top">
  <div id="wrap" class="about_wrap download_contents">
    <main id="main_wrap">
      <!-- メインビジュアル終わり -->
      <div class="contents_wrap">
        <div class="contents frame">
          <article class="article">
          <?php echo $this->Form->create('frmCommittee', ['enctype' => 'multipart/form-data','id' => 'frmCommittee', 'url' => ['controller' => 'Committee', 'action' => 'detail']]);?>
            <?php echo $this->Form->input('', array('type' => 'hidden','name'=>'iinkaicd','id'=>'iinkaicd','value'=> '')); ?>
            <?php echo $this->Form->input('', array('type' => 'hidden','name'=>'ssyasinkey','id'=>'ssyasinkey','value'=> '')); ?>
            <h1 class="h1 wf-roundedmplus1c"><span>委員会の紹介</span></h1>
            <div class="committee_list_box">
                <ul class="committee_list clearfix">
                  <?php foreach ($syasinData as $key => $syasinData) { ?>
                  <li class="committee_list_item">
                    <span class="detailpage" id="<?php echo $syasinData['TIinkai']['iinkaicd']."$$".$syasinData['TIinkai']['ssyasinkey']; ?>" style="cursor: pointer;">
                        <figure class="figureBox figureIE">
                          <img src="<?php echo $this->base."/Committee/getSyasin/".$syasinData['TSyasin']['rno']."/".$syasinData['TSyasin']['syasinkey'];?>"  class="imgStyle">
                        </figure>
                        <p class="marginTL" style="text-align: center"><?php echo $syasinData['TSyasin']['title']; ?></p>
                    </span>
                  </li>
                  <?php } ?>
                </ul>
            </div><!-- /.dl_section -->
          <?php echo $this->Form->end();?>
          </article>
        </div><!-- /.outline_contents -->
      </div><!-- /.contents_wrap -->
    </main><!-- /.main_wrap -->
</body>
</html>
