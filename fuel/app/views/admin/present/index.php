
<h1>景品管理</h1>

<h2>「<?php echo $campaign->present_name; ?>(<?php echo $campaign->present_code; ?>)」の景品一覧</h2>
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
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => '景品名で検索', 'autofocus')); ?>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Html::anchor('admin/present/add/'.$campaign->present_id, '新規追加', array('class' => 'action button-blue middle left')) ?>
		<?php echo Html::anchor('admin/campaign', '戻る', array('class' => 'action button-gray middle left')) ?>
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
			<td>景品名</td>
			<td>景品説明</td>
			<td>最終更新日時</td>
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<tr>
			<td><?php echo $row['present_data_id']; ?></td>
			<td><?php echo mb_strimwidth($row['present_data_name'], 0, 30, '...'); ?></td>
			<td><?php echo mb_strimwidth($row['present_data_txt'], 0, 50, '...'); ?></td>
			<td><?php echo $row['upd_date']; ?></td>
			<td><?php echo Html::anchor('admin/present/edit/'.$row['present_data_id'], '編集', array('class' => 'action button-green smaller')) ?></td>
			<td><?php echo Html::anchor('admin/presentkey/list/'.$row['present_data_id'], '当選シリアル', array('class' => 'action button-orange smaller')) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>