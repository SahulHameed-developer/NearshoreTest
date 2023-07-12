<!doctype html>
<title>ログイン情報送信：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('datepicker'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/membermanage/index.js') ?>
<?= $this->html->css('admin/membermanage/style.css') ?>
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<?= $this->element('messages'); ?>
<!-- ========== /header ========== -->
<!-- ========== nav ========== -->
<style type="text/css">
	.mailsendtext {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjQ1JSIgeT0iNTYlIiBmb250LXNpemU9IjMwIiBmaWxsPSJibGFjayI+6YCB5L+h5Lit44CC44CC44CCPC90ZXh0Pjwvc3ZnPg==');
		background-color: rgba(255, 255, 255, .5);
	}
	.f_right {
		display: block;
		float: right;
	}
	input[type=checkbox] {
		display:none;
	}
	input[type=checkbox] + label {
		border:0.1px solid black;
		background: white;
		height: 13px;
		width: 13px;
	 	display:inline-block;
		padding: 0 0 0 0px;
	}
	input[type=checkbox]:checked + label {
		background: black;
		height: 13px;
		width: 13px;
		display:inline-block;
		padding: 0 0 0 0px;
	}
</style>
<!-- ========== /nav ========== -->
<!-- ========== main ========== -->
<div id="mailsendtext"></div>
<section class="main">
	<div class="container maxWidth1250">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>ログイン情報送信</li>
				<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			</ol><!-- /.breadcrumbs -->
			<div class="breadcrumbs f_right"><a style="cursor:pointer;" class="backtohome">メニューに戻る</a></div>
			<h1 class="main-title">ログイン情報送信</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('sendmail', ['id' => 'sendmail', 'name' => 'sendmail', 'url' => ['controller' => 'adminMemberManagement', 'action' => 'sendmail']]);
				echo $this->Form->input('mailidarr', array('name' => 'mailidarr','id' => 'mailidarr','type' => 'hidden','value'=>$mailarrmm));
			echo $this->Form->end(); ?>
			<?php echo $this->Form->create('membermgnt', ['id' => 'membermgnt', 'name' => 'membermgnt', 'url' => ['controller' => 'adminMemberManagement', 'action' => 'search']]);
				echo $this->Form->input('mailarrmm', array('name' => 'mailarrmm','id' => 'mailarrmm','type' => 'hidden'));
				echo $this->Form->input('kaiincd', array('name' => 'kaiincd','id' => 'kaiincd','type' => 'hidden'));
				echo $this->Form->input('kaisyacd', array('name' => 'kaisyacd','id' => 'kaisyacd','type' => 'hidden'));
				echo $this->Form->input('count', array('name' => 'count','id' => 'count','type' => 'hidden','value' => $count));?>
			<div class="search-area">
				<div class="category-search flex50">
					<h2>カテゴリーから探す</h2>
					<div class="select-wrap">
						<?php echo $this->Form->input('kaiinsbnm',array('type'=>'select',
																			'options'=>$kaiinsbnm, 
																			'label'=>false,
																			'value'=>$selectedKaiinsbnm,
																			'empty'=> '会員種別を選択してください',
																			'name'=>'kaiinsbnm'));?>
					</div></br>
					<div class="select-wrap">
						<?php echo $this->Form->input('sosiki',array('type'=>'select',
																			'options'=>$sosiki, 
																			'label'=>false,
																			'value'=>$selectedSosiki,
																			'empty'=> '組織を選択してください',
																			'name'=>'sosiki'));?>
					</div>
				</div><!-- /.category-search -->
				<div class="freeword-search flex450">
					<h2>会員の状態で探す</h2>
					<ul><h4>公開状態 &nbsp;</h4>
						<li class="fontsize"><input type="radio" name="openstate" id="openstate1" value='' <?php echo $openstateChk1; ?>><label for="openstate1">全て</label></li>
						<li class="fontsize"><input type="radio" name="openstate" id="openstate2" value='0' <?php echo $openstateChk2; ?>><label for="openstate2">公開</label><label for="openstate2" style="opacity: 0.001;">ー</label></li>
						<li class="fontsize"><input type="radio" name="openstate" id="openstate3" value='1' <?php echo $openstateChk3; ?>><label for="openstate3">非公開</label></li>
					</ul>
					<ul><h4>入会状態 &nbsp;</h4>
						<li class="fontsize"><input type="radio" name="enrollment" id="enrollment1" value="0" <?php echo $enrollment1Chk; ?>><label for="enrollment1">全て</label></li>
						<li class="fontsize"><input type="radio" name="enrollment" id="enrollment2" value="1" <?php echo $enrollment2Chk; ?>><label for="enrollment2">入会中</label></li>
						<li class="fontsize"><input type="radio" name="enrollment" id="enrollment3" value="2" <?php echo $enrollment3Chk; ?>><label for="enrollment3">休会中</label></li>
						<li class="fontsize"><input type="radio" name="enrollment" id="enrollment4" value="3" <?php echo $enrollment4Chk; ?>><label for="enrollment4">退会</label></li>
					</ul>
					<ul><h4>登録情報 &nbsp;</h4>
						<li class="fontsize"><input type="radio" name="registration" id="registration1" value="0" <?php echo $registration1Chk; ?>><label for="registration1">全て</label></li>
						<li class="fontsize"><input type="radio" name="registration" id="registration2" value="1" <?php echo $registration2Chk; ?>><label for="registration2">送信済</label></li>
						<li class="fontsize"><input type="radio" name="registration" id="registration3" value="2" <?php echo $registration3Chk; ?>><label for="registration3">未送信</label></li>
					</ul>
				</div><!-- /.freeword-search -->
				<div class="freeword-search mt10MW">
					<h2>期間で探す</h2>
					<ul>
						<li class="fontsize"><input type="radio" name="period" id="period1" value="nyukaidate" <?php echo $nyukaiChk; ?>><label for="period1">入会日</label></li>
						<li class="fontsize"><input type="radio" name="period" id="period2" value="kyukaidate" <?php echo $kyukaiChk; ?>><label for="period2">休会日</label></li>
					</ul>
					<ul>
						<li class="fontsize"><input type="radio" name="period" id="period3" value="taikaidate" <?php echo $taikaiChk; ?>><label for="period3">退会日</label></li>
						<li class="fontsize"><input type="radio" name="period" id="period4" value="tsousindt" <?php echo $tsousinChk; ?>><label for="period4">登録情報送信日</label></li>
					</ul>
					<ul>
						<div>
							<?php echo $this->Form->input('fromdate', array('class'=>'datepicker', 'name' => 'fromdate',
								'id' => 'fromdate','label' => false,'size' => '11', 'type'=>'text','value' => $fromdate,
								'maxlength' => '10')); ?>
						</div>
						<span class="mt16">&nbsp;～&nbsp;</span>
						<div>
							<?php echo $this->Form->input('todate', array('class'=>'datepicker', 'name' => 'todate', 'id' => 'todate', 
								'label' => false,'size' => '11','type'=>'text','value' => $todate,'maxlength' => '10')); ?>
						</div>
					</ul>
				</div><!-- /.freeword-search -->
			</div><!-- /.search-area -->

			<div class="search-btn">
				<?php echo $this->Form->button("検索", array('class' =>'b-search'));?>
			</div>
			<div id="dateFmtError" class="tac dateFmtError"></div>
			<?php if(!empty($searchinfo)): ?>
			<div style="width: 100%">	
				<div class="register" style="display: inline-block;width: 20%">
					<button type="button" class="b-sendregister" >ログイン情報送信</button>
				</div>
				<div style="display: inline-block;width: 78%;text-align: right;">
					<label>表示順序</label>
					<div class="select-wrap">
						<?php echo $this->Form->input('dispOrder',array('type'=>'select',
																	'options'=>$dispOrder, 
																	'label'=>false,
																	'style' =>'width:150px;',
																	'value'=>$selectedOrder,
																	'onchange' => 'this.form.submit()',
																	'id'=>'selectedOrder',
																	'name'=>'selectedOrder'));?>
					</div>
				</div>
			</div>
			<div class="newslist-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<table>
					<tbody>
						<tr>
							<th class="wd5p">選択</th>
							<th class="wd9p">会員コード</th>
							<th class="wd8p">会員名</th>
							<th class="wd8p">会員種別</th>
							<th class="wd6p">役職</th>
							<th class="wd6p">組織</th>
							<th class="wd9p">委員会役職</th>
							<th class="wd9p">メール<br>アドレス</th>
							<th class="wd9p">ログインID</th>
							<th class="wd9p">パスワード</th>
							<th class="wd6p">状態</th>
							<th class="wd6p">入会日</th>
							<th class="wd6p">休会日</th>
							<th class="wd6p">退会日</th>
							<th class="wd6p">登録情報送信日</th>
							<th></th>
						</tr>
						<?php foreach($searchinfo as $searchVal): ?>
						<tr>
							<td class="tac">
								<input type="checkbox" name="choice[]" id="<?php echo "choice".$searchVal['TKaiin']['kaiincd']; ?>" 
								value="<?php echo $searchVal['TKaiin']['kaiincd']; ?>" class="s_checkbox" 
								onclick="checkprocess('<?php echo $searchVal['TKaiin']['kaiincd']; ?>','<?php echo $searchVal['TKaiin']['lgid']; ?>','<?php echo $searchVal['TKaiin']['lgpass']; ?>','<?php echo $searchVal['TKaiin']['mailaddr']; ?>')">
								<label for="<?php echo "choice".$searchVal['TKaiin']['kaiincd']; ?>"></label>
							</td>
							<td class="wordbreak"><?php echo $searchVal['TKaiin']['kaiincd']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['TKaiin']['kaiinnm']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['tkn']['kaiinsbnm']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['mky']['kyoukaiyknm']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['mso']['sosikinm']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['miy']['iinkaiyknm']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['TKaiin']['mailaddr']; ?></td>
							<td class="wordbreak"><?php echo $searchVal['TKaiin']['lgid']; ?></td>
							<td title="<?php echo $searchVal['TKaiin']['lgpass']; ?>">
								<?php echo mb_substr($searchVal['TKaiin']['lgpass'],0,8); ?>
							</td>
							<td class="wordbreak"><?php echo $searchVal['mko']['koukainm']; ?></td>
							<td class="tac">
								<?php 
									if($searchVal['TKaiin']['nyukaidate'] != null && $searchVal['TKaiin']['nyukaidate'] != "0000-00-00") {
										echo str_replace ( '-', '/', $searchVal['TKaiin']['nyukaidate']); 
									}
								?>
							</td>
							<td class="tac">
								<?php 
									if($searchVal['TKaiin']['kyukaidate'] != null && $searchVal['TKaiin']['kyukaidate'] != "0000-00-00") {
										echo str_replace ( '-', '/', $searchVal['TKaiin']['kyukaidate']); 
									}
								?>
							</td>
							<td class="tac">
								<?php 
									if($searchVal['TKaiin']['taikaidate'] != null && $searchVal['TKaiin']['taikaidate'] != "0000-00-00") {
										echo str_replace ( '-', '/', $searchVal['TKaiin']['taikaidate']); 
									}
								?>
							</td>
							<td class="tac">
								<?php 
									if($searchVal['TKaiin']['tsousindt'] != null && $searchVal['TKaiin']['tsousindt'] != "0000-00-00 00:00:00") {
										echo mb_substr(str_replace ( '-', '/', $searchVal['TKaiin']['tsousindt']),0,10); 
									} else { ?>
										<label style="opacity: 0.001;">0000/00/00</label>
								<?php } ?>
							</td>
							<td style="padding-left: 12px !important;">
								<button name="edit" class="button edit b-edit" 
								onclick="editprocess('<?php echo $searchVal['TKaiin']['kaiincd']; ?>','<?php echo $searchVal['TKaiin']['kaisyacd']; ?>')">
								編集</button>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
			</table>
			</div><!-- /.list-table -->
			<?php elseif(isset($searched)): ?>
				<div align="center" style="margin-top:40px;color:red;">
					<?php echo $this->fetch('SEARCH_NOT_FOUND'); ?>
				</div>
			<?php endif; ?>
			<?php echo $this->Form->end();?>
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->
<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->

</body>
</html>
