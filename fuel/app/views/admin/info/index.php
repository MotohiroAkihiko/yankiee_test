<?php $user = $current_user['group'];?>
<h1>お知らせ管理</h1>

<h2>お知らせ一覧</h2>
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
		<?php echo Form::input('keyword_id', Input::get('keyword_id'), array('class' => 'search-box', 'placeholder' => 'IDで検索', 'autofocus')); ?>
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => 'お知らせタイトル または お知らせ内容で検索', 'autofocus')); ?>
		<div class="filters">
			<label class="filter-checkbox">
				<?php echo Form::checkbox('pub', 'on', Input::get('pub') == 'on' , array('class' => 'checkbox')); ?> 公開中
			</label>
		</div>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Html::anchor('admin/info/add', '新規追加', array('class' => 'action button-blue middle left')) ?>
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
			<td>公開期間（開始）</td>
			<td>公開期間（終了）</td>
			<td>お知らせタイトル</td>
			<td>お知らせ内容</td>
			<td>最終更新日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<?php echo Form::open(array('action' => $delete_url.$row['id'], 'id' => 'form-delete') ); ?>
		<tr>
			<td><?php echo Form::hidden('id', $row['id'], $attributes = array()).Form::label($row['id'], 'id');?></td>
			<td><?php echo $row['publish_start_date']; ?></td>
			<td><?php echo $row['publish_end_date']; ?></td>
			<td><?php echo Html::anchor('admin/info/edit/'.$row['id'], mb_strimwidth($row['info_title'], 0, 30, '...')) ?></td>
			<td><?php echo mb_strimwidth($row['info_details'], 0, 60, '...'); ?></td>
			<td><?php echo $row['upd_date']; ?></td>
			<td><?php echo $row['info_category']; ?></td>
			<?php if ( $user == 'admin' ) : ?>
    			<td><?php echo Form::button('delete', '削除', array('class' => 'action button-green smaller'));?></td>
    		<?php endif; ?>
		</tr>
		<?php echo Form::close(); ?>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>