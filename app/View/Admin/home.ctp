<!doctype html>
<title>トップ：一般社団法人ニアショアＩＴ協会 管理画面</title>
<!-- ========== nav ========== -->
<?= $this->element('adminhead') ?>
<!-- ========== /nav ========== -->

<!-- ========== main ========== -->
<?php $i = 0; ?>
<section class="top-main">
	<div class="container">
		<main>
			<ul class="category">
				<?php if ($this->Session->read('Auth.User.Menu.kaiinInfo') == $this->Constants->HYOJI):?>
					<li class="menu-width">
						<?php $i++; ?>
						<h2>会員情報</h2>
						<ul>
							<?php if ($this->Session->read('Auth.User.Menu.kaiinEdit') == $this->Constants->HYOJI):?>
								<li><?php echo $this->Html->link("会員情報編集", array('controller' => 'adminMember','action'=> 'view'));?></li>
							<?php endif; ?>
							<?php if ($this->Session->read('Auth.User.Menu.kaiinAdd') == $this->Constants->HYOJI):?>
								<li><span tooltip='会員の個人情報や企業情報を修正する事ができます 
また、会員企業に2人目以降の新規会員を追加する事ができます'>
							<?php echo $this->Html->link("会員情報一覧", array('controller' => 'adminMember','action'=> 'memberlist'));?></span></li>
								<li><span tooltip='新しい企業の会員を登録する場合に使用します
会員の個人情報や企業情報を新規登録する事ができます'>
							<?php echo $this->Html->link("会員・会社　新規追加", array('controller' => 'adminMember','action'=> 'add'));?></span></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<?php if ($this->Session->read('Auth.User.Menu.katsudoInfo') == $this->Constants->HYOJI):?>
					<li class="menu-width">
						<?php $i++; ?>
						<h2>ニアショアIT協会の活動</h2>
						<ul>
							<?php if ($this->Session->read('Auth.User.Menu.katsudoCalList') == $this->Constants->HYOJI):?>
								<li><span tooltip="委員会や倶楽部の予定されている会議やイベントを修正する事ができます
活動日付が本日から未来のものが表示されます">
							<?php echo $this->Html->link("活動カレンダー一覧", array('controller' => 'adminActivity','action'=> 'calender'));?></span></li>
							<?php endif; ?>
							<?php if ($this->Session->read('Auth.User.Menu.katsudoAdd') == $this->Constants->HYOJI):?>
								<?php if ($this->Session->read('Auth.User.TKengen.kcaltouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA): ?>
									<li><span tooltip="委員会や倶楽部のこれから予定されている会議やイベントを登録します
予定の登録を行っていない実施済みの過去の活動もここで入力する事ができます">
								<?php echo $this->Html->link("活動カレンダー　新規追加", array('controller' => 'adminActivity','action'=> 'add'));?></span></li>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ($this->Session->read('Auth.User.Menu.katsudoHokokuList') == $this->Constants->HYOJI):?>
								<li><span tooltip="委員会や倶楽部の活動報告を入力する事ができます
活動日付が本日より過去になった実施済みの会議やイベントが表示されます">
								<?php echo $this->Html->link("活動報告一覧", array('controller' => 'adminActivity','action'=> 'report'));?></span></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($this->Session->read('Auth.User.Menu.oshiraseInfo') == $this->Constants->HYOJI):?>
					<li class="menu-width">
						<?php $i++; ?>
						<h2>お知らせ</h2>
						<ul>
							<li><span tooltip="入力済みのお知らせを修正する事ができます">
							<?php echo $this->Html->link("お知らせ一覧", array('controller' => 'adminNews','action'=> 'index'));?></span></li>
							<?php if ($this->Session->read('Auth.User.Menu.oshiraseAdd') == $this->Constants->HYOJI):?>
								<?php if ($this->Session->read('Auth.User.TKengen.osirasetouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA ): ?>
									<li><span tooltip="お知らせを新規登録する事ができます
お知らせ日付・時間は未来日付も設定可能で設定日時以降に自動表示されます">
									<?php echo $this->Html->link("お知らせ　新規追加", array('controller' => 'adminNews','action'=> 'add'));?></span></li>
								<?php endif; ?>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

			<?php if (($i%3) == 0 ): ?>
			</ul><!-- /.category -->
		</main>
		<main>
			<ul class="category">
			<?php endif;?>

				<?php if ($this->Session->read('Auth.User.Menu.yuekiInfo') == $this->Constants->HYOJI):?>
					<li class="menu-width">
						<?php $i++; ?>
						<h2>有益情報</h2>
						<ul>
							<li><span tooltip="入力済の有益情報を修正することができます">
							<?php echo $this->Html->link("有益情報一覧",array('controller' => 'AdminBeneficial','action'=> 'index'));?></span></li>
							<?php if ($this->Session->read('Auth.User.Menu.yuekiAdd') == $this->Constants->HYOJI):?>
								<?php if ($this->Session->read('Auth.User.TKengen.yuekitouroku') == 1 || $this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA ): ?>
									<li><span tooltip="有益情報を新規登録することができます
有益情報の日付・時間は未来日付も設定可能で設定日時以降に自動表示されます">
									<?php echo $this->Html->link("有益情報　新規追加",array('controller' => 'AdminBeneficial','action'=> 'add'));?></span></li>
								<?php endif; ?>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

			<?php if (($i%3) == 0 ): ?>
			</ul><!-- /.category -->
		</main>
		<main>
			<ul class="category">
			<?php endif;?>

				<?php if (!empty($this->Session->read('Auth.User.TKaiin.sosikicd')) || $this->Session->read('Auth.User.TKaiin.kkanjikbn') == '1' || $this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI): ?>
				<li class="menu-width">
					<?php $i++; ?>
					<h2>委員会・倶楽部情報</h2>
					<ul>
						<?php if (!empty($this->Session->read('Auth.User.TKaiin.sosikicd')) || $this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI ): ?>
							<li><span tooltip="委員会の活動内容やメンバー等の紹介情報を更新する場合に使用します">
							<?php echo $this->Html->link("委員会紹介情報編集", array('controller' => 'AdminCommitteInfo','action'=> 'edit'));?>
							</span></li>
						<?php endif; ?>
						<?php if ($this->Session->read('Auth.User.TKaiin.kkanjikbn') == '1' || $this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI ): ?> 
							<li><span tooltip="倶楽部の活動内容やメンバー等の紹介情報を更新する場合に使用します">
								<?php echo $this->Html->link("倶楽部紹介情報編集", array('controller' => 'AdminClubInfo','action'=> 'edit'));?>
							</span></li>
						<?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>

			<?php if (($i%3) == 0 ): ?>
			</ul><!-- /.category -->
		</main>
		<main>
			<ul class="category">
			<?php endif;?>

				<?php if ($this->Session->read( 'Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI):?>
				<li class="menu-width">
					<?php $i++; ?>
					<h2>ダウンロード機能</h2>
					<ul>
						<li><span tooltip="ダウンロード画面のカテゴリー（分類）について追加や変更する場合に使用します
また、公開/非公開の切り替えも可能です">
							<?php echo $this->Html->link("ダウンロードカテゴリー編集", array('controller' => 'adminDLCategory','action'=> 'categoryedit'));?>
						</span></li>
						<li><span tooltip="ダウンロード画面用のファイルを新規にアップロードする場合に使用します">
							<?php echo $this->Html->link("ダウンロードファイル新規追加", array('controller' => 'AdminDlFile','action'=> 'add'));?>
						</span></li>
						<li><span tooltip="ダウンロード画面用のファイルの差し替えやタイトルの変更する場合に使用します
また、公開/非公開の切り替えも可能です">
							<?php echo $this->Html->link("ダウンロードファイル一覧", array('controller' => 'adminDlFile','action'=> 'index'));?>
						</span></li>
					</ul>
				</li>
				<?php endif; ?> 

			<!--<?php //if (($i%3) == 0 ): ?>
			</ul>
		</main>
		<main>
			<ul class="category">
			<?php //endif;?> -->

				<!-- <?php //if ($this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI):?>
				<li class="menu-width">
					<?php //$i++; ?>
					<h2>役職・委員情報</h2>
					<ul>
						<li><span tooltip="役職者の新任や役職変更、及び、退任の設定を行う場合に使用します">
							<?php// echo $this->Html->link("役職編集",  array(),array('onclick' => "javascript:alert('未作成');return false;"));?>
						</span></li>
						<li><span tooltip="委員会のメンバー追加や削除、及び、役職の設定を行う場合に使用します">
							<?php //echo $this->Html->link("委員編集", array(),array('onclick' => "javascript:alert('未作成');return false;"));?>
						</span></li>
						<li><span tooltip="役員紹介ページの変更を行う場合に使用します">
							<?php //echo $this->Html->link("役員紹介リスト作成", array(),array('onclick' => "javascript:alert('未作成');return false;"));?>
						</span></li>
					</ul>
				</li>
				<?php //endif; ?> -->

			<?php if (($i%3) == 0 ): ?>
			</ul><!-- /.category -->
		</main>
		<main>
			<ul class="category">
			<?php endif;?>

				<?php if ($this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI || $this->Session->read('Auth.User.TKengen.syukketusansyo') == $this->Constants->SYUKKETU_SANYO_KBN ):
				?>
					<li class="menu-width">
						<?php $i++; ?>
						<h2>管理者機能</h2>
						<ul>
						<?php if ($this->Session->read('Auth.User.Menu.kanrishaInfo') == $this->Constants->HYOJI) : ?>
							<li><span tooltip="会員に「ニアショアIT協会の活動」「お知らせ」に関するメニューを使う権限を与える事ができます">
							<?php echo $this->Html->link("権限設定", array('controller' => 'AdminPermission','action'=> 'permissionlist'));?></span></li>
							<li><span tooltip="会員に初めてパスワードをお知らせする時に使います"><?php echo $this->Html->link("ログイン情報送信", array('controller' => 'AdminMemberManagement','action'=> 'memberlist'));?></span></li>
						<?php endif; ?>
					<?php if ($this->Session->read('Auth.User.TKaiin.kanrikbn') >= $this->Constants->SYS_KANRISHA || $this->Session->read('Auth.User.TKengen.syukketusansyo') == $this->Constants->SYUKKETU_SANYO_KBN ) { ?>
						<li><span tooltip="過去に開催されたイベントの参加状況を確認できます"><?php echo $this->Html->link("出欠情報（イベント）", array('controller' => 'AdminAttendance','action'=> 'memberlist'));?></span></li>
						<li><span tooltip="過去に開催された会議の参加状況を確認できます"><?php echo $this->Html->link("出欠情報（会議）", array('controller' => 'AdminAttendanceKaigi','action'=> 'memberlist'));?></span></li>
					<?php } ?>		
							
						</ul>
					</li>
				<?php endif; ?>
				<?php if ($this->Session->read('Auth.User.Menu.prInfo') == $this->Constants->HYOJI):?>
				<li class="menu-width">
					<?php $i++; ?>
					<h2>ＰＲサイト情報</h2>
					<ul>
						<li><span tooltip="ニアショアIT協会ＰＲサイト掲載についての契約情報を更新する場合に使用します">
							<?php echo $this->Html->link("ＰＲ契約情報一覧", array('controller' => 'AdminContract','action'=> 'index'));?>
						</span></li>
						<li><span tooltip="ニアショアIT協会ＰＲサイトに掲載する商品やサービスの情報を更新する場合に使用します">
							<?php echo $this->Html->link("ＰＲ情報一覧", array('controller' => 'AdminProductsite','action'=> 'index'));?>
						</span></li>
					</ul>
				</li>
				<?php endif; ?>
				<?php if ($this->Session->read('Auth.User.Menu.superkanrishaInfo') == $this->Constants->HYOJI):?>
				<li class="menu-width">
					<?php $i++; ?>
					<h2>マスタメンテナンス</h2>
					<ul>
						<li><span tooltip="各種コードマスタの新規・変更・削除を行います
また、コード名称や表示順、適用期間も変更できます">
							<?php echo $this->Html->link("コードマスタ一覧", array('controller' => 'AdminMaster','action'=> 'codemasterlist'));?>
						</span></li>
						<!-- <li>
							<?php //echo $this->Html->link("通知先マスタ一覧", array(),array('onclick' => "javascript:alert('未作成');return false;"));?>
						</li> -->
					</ul>
				</li>
				<?php endif; ?>
			</ul><!-- /.category -->
		</main>
	</div><!-- /.container -->
</section>
<!-- ========== /main ========== -->

<!-- ========== footer ========== -->
<?= $this->element('adminfooter') ?>
<!-- ========== /footer ========== -->
</body>
</html>