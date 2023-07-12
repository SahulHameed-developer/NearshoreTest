<!-- ========== footer ========== -->
<footer>
	<?php echo $this->Form->create('footer_form', ['id' => 'footer_form','name' => 'footer_form']);
		echo $this->Form->input('scroll_val', array('id'=>'scroll_val','name'=>'scroll_val','type' => 'hidden','value'=>$this->Session->read('Footer.scroll_val')));
	echo $this->Form->end(); ?>
	<div class="pagetop">
		<?php echo $this->Html->image('common/pagetop.png', array('alt' => 'ページトップへ戻る','class' => 'gototop','style' => 'cursor:pointer;display:none;'));?>
	</div><!-- /.pagetop -->
	<div class="pagebottom breadcrumbs">
		<?php echo $this->Html->image('common/pagebottom.png', array('alt' => 'ページボットムへ戻る','class' => 'gotobottom','style' => 'cursor:pointer;display:none;'));?>
	</div><!-- /Page_Bottom -->
	<?php echo $this->element('copyrights'); ?>
</footer>
<script type = "text/javascript">
	$(document).ready(function() {
		$('input, textarea').on('drop', function(event) {
			event.preventDefault();
		});
		$('input, textarea').blur(function () {
			var arrTrimSpace = ($(this).attr('class')).split(' ');
			if ($.inArray('noTrimSpace', arrTrimSpace) != -1) { } else {
				$(this).val($.trim( $(this).val()));
			}
			// エモジスを置き換える
			var Emoji = isEmoji($(this).val());
			$(this).val(Emoji);
		});
		$("img, a").mousedown(function(){
			return false;
		});
	});
	// エモジスを置き換える
	function isEmoji(str) {
		var ranges = ['\ud83c[\udf00-\udfff]','\ud83d[\udc00-\ude4f]','\ud83d[\ude80-\udeff]'];
		return str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
	}
	var e = location.pathname.split("/").pop();
	history.pushState(null, null, e);
	window.addEventListener('popstate', function(event) {
		history.pushState(null, null, e);
		window.location = "<?php echo $this->Html->url(array('controller' => 'Error', 'action' => 'systemError')); ?>";
	});
	$(document).bind('keydown keyup', function(e) {
		if(e.which === 116) {
			if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) { } else {
				window.location = "<?php echo $this->Html->url(array('controller' => 'Error', 'action' => 'systemError')); ?>";
			}	
		}
	});
</script>

<!-- Session Timeout Process -->
<?= $this->Html->script('common/timeout.js'); ?>
<script type="text/javascript">
	var idleTime = 1;
	var adminTrig = 0;
	$(document).ready(function () {
		var idleInterval = setInterval(timerIncrement, 60000);
		$(this).mousemove(function (e) { idleTime = 1; });
		$(this).keypress(function (e) { idleTime = 1; });
		$(this).click(function (e) { idleTime = 1; });
		$(this).scroll(function (e) { idleTime = 1; });
	});
	function timerIncrement() {
		window.localStorage.setItem("adminIdletime",idleTime);
		idleTime = idleTime + 1;
		if (idleTime > timeoutMin && adminTrig ==　0 ) {
			adminTrig = 1;
			localStorage.removeItem("adminIdletime");
			$.confirm({
				title: '',
				content: '一定時間操作されなかったため、自動ログアウトされました。<BR/>会員機能を利用するには、再度ログインしてください。',
				type: 'blue',
				columnClass: 'col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
				buttons: {
					OK: {
						btnClass: 'btn-blue',
						keys: ['enter'],
						action: function(){
							window.location = "<?php echo $this->Html->url(array('controller' => 'Admin', 'action' => 'logout')); ?>";
							adminTrig = 0;
							window.open('', '_self').close();
						}
					}
				}
			});
		}
	}

</script>   
<!-- Session Timeout Process -->

<!-- ========== /footer ========== -->