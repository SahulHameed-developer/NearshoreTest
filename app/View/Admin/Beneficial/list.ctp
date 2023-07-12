<!doctype html>
<title>有益情報一覧：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- jQuery ui Datepicker -->
<?= $this->element('monthpicker'); ?>
<?= $this->Html->script('common/jquery.confirm.js') ?>
<?= $this->html->css('common/confirm.css') ?>
<?= $this->Html->script('common/jquery-validate.js') ?>
<?= $this->Html->script('admin/beneficial/index.js') ?>
<?= $this->Html->css('admin/beneficial/style.css') ?>
<!-- ========== nav ========== -->
<!-- ========== /nav ========== -->
<!-- ========== header ========== -->
<?= $this->element('adminheader') ?>
<!-- ========== /header ========== -->
<!-- ========== main ========== -->
<section class="main">
	<div class="container">
		<main>
			<ol class="breadcrumbs" style="display: inline-block;">
				<li><a style="cursor:pointer;" id="backpage_head" class="backtohome">管理画面トップ</a></li>
				<li>有益情報一覧</li>
			</ol><!-- /.breadcrumbs -->
			<div class="f_right breadcrumbs"><a style="cursor:pointer;" id="backpage_head" class="backtohome">メニューに戻る</a></div>
			<div class="message"><?php if (!empty($this->Session->read('errorMsg.msg'))) { echo $this->Session->read('errorMsg.msg'); }?></div>
			<h1 class="main-title">有益情報一覧</h1>
			<?php echo $this->Form->create('backtohome', ['id' => 'backtohome', 'url' => ['controller' => 'Admin', 'action' => 'home']]); echo $this->Form->end();?>
			<?php echo $this->Form->create('yueki', ['url' => ['controller' => 'AdminBeneficial', 'action' => 'search']]);?>
				<div class="newslist-search-area">
					<div class="newslist-date-search">
						<h2>日付から探す</h2>
						<p>日付から絞り込むことができます。</p>
						<div class="date">
							<?php echo $this->Form->input('yuekiDtFrm', array('class'=>'datepickerfmt', 'name' => 'yuekiDtFrm',
									'label' => false, 'id' => 'yuekiDtFrm', 'type'=>'text', 'value'=>$yuekiDtFrm,
									'maxlength' => '7')); ?>
						</div>
						<span>～</span>
						<div class="date">
							<?php echo $this->Form->input('yuekiDtTo', array('class'=>'datepickerfmt', 'name' => 'yuekiDtTo', 
									'label' => false, 'id' => 'yuekiDtTo','type'=>'text','value'=>$yuekiDtTo,'maxlength' => '7'));
							?>
						</div>
						<div id="dateFmtError" class="dateFmtError"></div>
					</div><!-- /.date-search -->
					<div class="newslist-freeword-search">
						<h2>フリーワード検索で探す</h2>
						<p>文中内のキーワードなどから検索できます。</p>
						<input type="text" name="free-word" value="<?php echo $free_word;?>">
					</div><!-- /.freeword-search -->
				</div><!-- /.newslist-search-area -->
				<div class="newslist-search-btn"><?php 
							echo $this->Form->button("検索", 
										array('class' =>'button','name' =>''));?>
				</div>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminBeneficialedit', ['id' => 'adminBeneficialedit', 'url' => ['controller' => 'AdminBeneficial', 'action' => 'edit']]);
					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('yuekiDtFrm', array('id'=>'yuekiDtFrm','type' => 'hidden', 'value' => $yuekiDtFrm));
					echo $this->Form->input('yuekiDtTo', array('id'=>'yuekiDtTo','type' => 'hidden',  'value' => $yuekiDtTo));
					echo $this->Form->input('free_word', array('id'=>'free_word','type' => 'hidden',  'value' => $free_word));
					echo $this->Form->input('syasinKey', array('type' => 'hidden'));?>
			<?php echo $this->Form->end();?>
			<?php echo $this->Form->create('adminBeneficialdelete', ['id' => 'adminBeneficialdelete', 'url' => ['controller' => 'AdminBeneficial', 'action' => 'delete']]);
					echo $this->Form->input('arno', array('type' => 'hidden'));
					echo $this->Form->input('syasinKey', array('type' => 'hidden'));
					echo $this->Form->input('filekey', array('type' => 'hidden'));
					echo $this->Form->input('yuekiDtFrm', array('type' => 'hidden','value'=>$yuekiDtFrm));
					echo $this->Form->input('yuekiDtTo', array('type' => 'hidden','value'=>$yuekiDtTo));
					echo $this->Form->input('free_word', array('type' => 'hidden','value'=>$free_word));?>
			<?php echo $this->Form->end();?>
			<div class="newslist-list-table">
			<div class="message"><?php echo $this->Session->flash();?></div>
			<?php if(!empty($yueki)):?>
				<table>
					<tbody>
						<tr>
							<th style="min-width: 75px;" class="wd12p">日付</th>
							<th class="wd50p">タイトル</th>
							<th style="min-width: 70px;">公開状態</th>
							<th <?php if ($this->Session->read('Auth.User.TKengen.yuekitouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA){  } else { ?>  class="wd9p" <?php } ?> ></th>
						</tr>
						<?php if(!empty($yueki)): foreach($yueki as $yuekival): ?>
							<tr class="wordbreak">
								<td><?php echo date('Y/m/d', strtotime($yuekival['0']['yueki_date']));?></td>
								<td><?php echo $yuekival['TYueki']['title']; ?></td>
								<td><?php echo $yuekival['mkou']['koukainm']; ?></td>
								<td><?php if ($this->Session->read('Auth.User.TKengen.yuekitouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA): 
										echo $this->Form->button("編集", 
													array('class' =>'button edit',
															'name' => 'edit',
															'data-id'=>$yuekival['TYueki']['arno'],
															'data-syasinkey'=>$yuekival['TYueki']['syasin'],
										));
										echo $this->Form->button("削除",
												array('class' =>'button delete',
														'name' => 'delete',
														'data-id'=>$yuekival['TYueki']['arno'],
														'data-syasinkey'=>$yuekival['TYueki']['syasin'],
														'data-filekey'=>$yuekival['TYueki']['file'],
										));
										elseif ($this->Session->read('Auth.User.TKengen.yuekikoukai') == 1):?><?php 
										echo $this->Form->button("編集",
												array('class' =>'button edit',
														'name' => 'edit',
														'data-id'=>$yuekival['TYueki']['arno'],
														'data-syasinkey'=>$yuekival['TYueki']['syasin'],
										));
										?><?php endif; ?></td>
							</tr>
						<?php endforeach; else: ?>
						<?php endif; ?>
					</tbody>
				</table>
				<?php endif; ?>
			</div><!-- /.list-table -->
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