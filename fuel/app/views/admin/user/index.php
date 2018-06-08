
<h1>ユーザー情報</h1>

<h2>ユーザー一覧</h2>
<br>

<?php echo Form::open( array('method' => 'get') ); ?>
	<div class="flakes-search">
		<?php echo Form::input('sid', Input::get('sid'), array('class' => 'search-box', 'placeholder' => 'IDで検索', 'autofocus')); ?>
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => 'ユーザーID または ニックネームで検索', 'autofocus')); ?>
			<div class="filters">
				<label class="filter-checkbox">
					<?php echo Form::checkbox('school3', 'on', Input::get('school3') == 'on' , array('class' => 'checkbox')); ?> 白虎高校
				</label>
				<label class="filter-checkbox">
					<?php echo Form::checkbox('school2', 'on', Input::get('school2') == 'on' , array('class' => 'checkbox')); ?> 青龍高校
				</label>
				<label class="filter-checkbox">
					<?php echo Form::checkbox('school1', 'on', Input::get('school1') == 'on' , array('class' => 'checkbox')); ?> 紅鬼高校
				</label>
			</div>
	</div>
	<div class="flakes-actions-bar">
		<span style="padding-left:10px;">入会年月:</span><?php echo Form::select('ym', Input::get('ym'), $regYmArray, array('style' => 'width:200px;', 'class' => 'action middle left')); ?>
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
			<td>ニックネーム</td>
			<td>入会日時</td>
			<td>最終ログイン</td>
			<td>ガッツ</td>
			<td>ログイン数</td>
			<td>所持キャラ数</td>
			<td>所属学校</td>
			<td>使用キャラクター</td>
			<td>ユーザーID</td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<tr>
			<td><?php echo $row['site_user_id']; ?></td>
			<td><?php echo $row['nick_name']; ?></td>
			<td><?php echo $row['reg_date']; ?></td>
			<td><?php echo $row['last_login_date']; ?></td>
			<td><?php echo number_format($row['user_point']); ?></td>
			<td><?php echo $row['login_count']; ?></td>
			<td><?php echo $row['character_count']; ?></td>
			<td><?php echo $row['school_name']; ?></td>
			<td><?php echo $row['character_name']; ?></td>
			<td><?php echo $row['user_id']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	
<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>
