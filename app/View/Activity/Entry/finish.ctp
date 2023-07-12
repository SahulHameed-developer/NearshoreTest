<!--header -->
<?php $this->layout="default";?>
<?= $this->html->css('activity/style.css') ?>
<?= $this->Html->script('activity/entry/confirm.js') ?>
<script>
	if ( window.history.replaceState ) {
		<?php header('Cache-Control: private, max-age=10800, pre-check=10800'); ?>
	}
</script>
<!-- /header -->
<?php echo $this->Form->create('moshiKomiFrm',['id' => 'moshiKomiFrm','url' => ['controller' => 'activity', 'action' => 'entry']]);
	echo $this->Form->input('taisyoukbn', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.taisyoukbn')));
	echo $this->Form->input('hyoudai', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.hyoudai')));
	echo $this->Form->input('meisyou', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.meisyou')));
	echo $this->Form->input('kaisaidate', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.kaisaidate')));
	echo $this->Form->input('kaisaitmfrom', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.kaisaitmfrom')));
	echo $this->Form->input('kaisaitmto', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.kaisaitmto')));
	echo $this->Form->input('bunruicd', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.bunruicd')));
	echo $this->Form->input('sosikicd', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.sosikicd')));
	echo $this->Form->input('kbunruicd', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.kbunruicd')));
	echo $this->Form->input('arno', array('type' => 'hidden','value'=>$this->Session->read('activity.arno')));
	echo $this->Form->input('kaiincd', array('type' => 'hidden','value'=>$this->Session->read('previousPageInfo.kaiincd')));
	echo $this->Form->input('kaiinkbn', array('type' => 'hidden','value'=>$this->Session->read('activity.kaiinKbn')));
	echo $this->Form->end();
?>
<div class="contents_wrap">
	<div class="contents frame">
		<div class="step_block">
			<?php echo $this->Html->image('common/pc/step_03.gif', array('alt' => '送信'));?>
		</div><!-- /.step_block -->
		<h1 class="h1 wf-roundedmplus1c">お申し込み有難うございました。</h1>
	</div><!-- /.contents -->
</div><!-- /.contents_wrap -->