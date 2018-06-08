
<h1>キャンペーン管理</h1>

<h2>キャンペーン一覧</h2>
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
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => 'キャンペーン名で検索', 'autofocus')); ?>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Html::anchor('admin/campaign/add', '新規追加', array('class' => 'action button-blue middle left')) ?>
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
			<td>キャンペーン名</td>
			<td>キャンペーンコード</td>
			<td>応募期間（開始）</td>
			<td>応募期間（終了）</td>
			<td>結果発表期間（開始）</td>
			<td>結果発表期間（終了）</td>
			<td>最終更新日時</td>
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<tr>
			<td><?php echo $row['present_id']; ?></td>
			<td><?php echo mb_strimwidth($row['present_name'], 0, 30, '...'); ?></td>
			<td><?php echo $row['present_code']; ?></td>
			<td><?php echo $row['present_start_date']; ?></td>
			<td><?php echo $row['present_end_date']; ?></td>
			<td><?php echo $row['result_start_date']; ?></td>
			<td><?php echo $row['result_end_date']; ?></td>
			<td><?php echo $row['upd_date']; ?></td>
			<td><?php echo Html::anchor('admin/campaign/edit/'.$row['present_id'], '編集', array('class' => 'action button-green smaller')) ?></td>
			<td><?php echo Html::anchor('admin/present/list/'.$row['present_id'], '景品', array('class' => 'action button-orange smaller')) ?></td>
			<td><?php echo Html::anchor('admin/drawing/list/'.$row['present_id'], '抽選', array('class' => 'action button-red smaller')) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>