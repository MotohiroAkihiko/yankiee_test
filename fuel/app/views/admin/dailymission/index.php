
<h1>デイリーミッション管理</h1>

<h2>デイリーミッション一覧</h2>
<br>

<?php if (Session::get_flash('success')): ?>
	<p class="flakes-message success">
		<?php echo Session::get_flash('success'); ?><br>
	</p>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
	<p class="flakes-message error">
		<?php echo Session::get_flash('error'); ?><br>
	</p>
<?php endif; ?>

<?php echo Form::open( array('method' => 'get') ); ?>
	<div class="flakes-search">
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => 'ミッション条件で検索', 'autofocus')); ?>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'検索', 'name'=>'submit', 'class' => 'action button-gray middle right')); ?>
	</div>
<?php echo Form::close(); ?>

[検索結果：<?php echo Pagination::instance('pager')->total_items;?>件]
<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>公開開始日時</td>
			<td>ミッション条件</td>
			<td>ミッションタイプ</td>
			<td>クリア条件JSONデータ</td>
			<td>報酬JSONデータ</td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['publish_start_date']; ?></td>
			<td><?php echo $row['mission_name']; ?></td>
			<td><?php echo $row['mission_type']; ?></td>
			<td><?php echo $row['mission_clear_data']; ?></td>
			<td><?php echo $row['mission_present_data']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>



<div class="flakes-actions-bar">
	<div class="tips">
		
		<h2>JSONデータ参考情報</h2>
		<br>
	
		[クリア条件JSONデータ]<br>
		
		<p class="flakes-message information">
		■ミッションタイプ：TypeA（{競技名}で今日1日で合計{ガッツ}G以上獲得しろ！）<br>
		<br>
		クリア条件データは「game_id」に競技のID、「user_point」に条件となるガッツが登録されています。<br>
		※競技IDは下記の[競技マスタ登録一覧]を参照してください。
		</p>
		<br>
		
		<p class="flakes-message information">
		■ミッションタイプ：TypeB（次の2つの競技をプレイしろ！＜{競技名}、{競技名}＞）<br>
		<br>
		クリア条件データは「game_id」に競技のIDがカンマ区切りで登録されています。<br>
		※競技IDは下記の[競技マスタ登録一覧]を参照してください。
		</p>
		<br>
		
		[報酬JSONデータ]<br>
		
		<p class="flakes-message information">
		クリア条件データはアイテムの場合、「item_id」にアイテムのIDが登録されています。<br>
		ガッツの場合、「user_point」にガッツが登録されています。<br>
		※アイテムIDは下記の[アイテムマスタ登録一覧]を参照してください。
		</p>
		<br>

		[競技マスタ登録一覧]<br>
		<table class="flakes-table">
			<colgroup>
				<col span="1" style="width:20px" />
		<col span="1" style="width:40%" />
			</colgroup>
			<thead>
				<tr>
					<td>ID</td>
					<td>ゲーム名</td>
					<td></td>
				</tr>
			</thead>
			<tbody class="list">
				<?php foreach ( $list_mst_game as $row ) : ?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['game_name']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br>
		
		[アイテムマスタ登録一覧]<br>
		<table class="flakes-table">
			<colgroup>
				<col span="1" style="width:20px" />
		<col span="1" style="width:40%" />
			</colgroup>
			<thead>
				<tr>
					<td>ID</td>
					<td>アイテム名</td>
					<td></td>
				</tr>
			</thead>
			<tbody class="list">
				<?php foreach ( $list_mst_item as $row ) : ?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['item_name']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		
	</div>
</div>
