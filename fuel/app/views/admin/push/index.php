
<h1>Push通知管理</h1>

<h2>Push通知一覧</h2>
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
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => '通知名称、通知ティッカー、通知タイトル、通知メッセージで検索', 'autofocus')); ?>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Html::anchor('admin/push/add', '新規追加', array('class' => 'action button-blue middle left')) ?>
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
			<td>配信（開始）</td>
			<td>配信（終了）</td>
			<td>通知名称</td>
			<td>通知ティッカー</td>
			<td>通知タイトル</td>
			<td>通知メッセージ</td>
			<td>配信フラグ</td>
			<td>最終更新日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<tr>
			<td><?php echo $row['push_id']; ?></td>
			<td><?php echo $row['push_start_date']; ?></td>
			<td><?php echo $row['push_end_date']; ?></td>
			<td><?php echo $row['push_name'];?></td>
			<td><?php echo $row['push_ticker'];?></td>
			<td><?php echo $row['push_title'];?></td>
			<td><?php echo $row['push_message'];?></td>
			<td><?php echo $row['push_flg'];?></td>
			<td><?php echo $row['upd_date']; ?></td>
			<td><?php echo Html::anchor('admin/push/edit/'.$row['push_id'], '編集', array('class' => 'action button-green smaller')) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>