<?php $user = $current_user['group'];?>
<h1>アイテムマスタ管理</h1>

<h2>アイテム一覧</h2>
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
		<?php echo Form::input('keyword', Input::get('keyword'), array('class' => 'search-box', 'placeholder' => 'アイテム名 または アイテム内容で検索', 'autofocus')); ?>
		<div class="filters">
			<label class="filter-checkbox">
				<?php echo Form::checkbox('pub', 'on', Input::get('pub') == 'on' , array('class' => 'checkbox')); ?> 公開中
			</label>
		</div>
	</div>
	<div class="flakes-actions-bar">
		<?php echo Html::anchor('admin/item/add', '新規追加', array('class' => 'action button-blue middle left')) ?>
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
			<td>カテゴリー</td>
			<td>アイテム名</td>
			<td>アイテム説明</td>
			<td>アイテム有効期限(秒)</td>
			<td>ポイントアップ率</td>
			<td>アイコン</td>
			<td>最終更新日時</td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list as $row ) : ?>
		<?php echo Form::open(array('action' => $delete_url.$row['id'], 'id' => 'form-delete') ); ?>
		<tr>
			<td><?php echo Form::hidden('id', $row['id'], $attributes = array()).Form::label($row['id'], 'id');?></td>
			<td><?php echo $row['publish_start_date']; ?></td>
			<td><?php echo $row['publish_end_date']; ?></td>
			<td><?php echo $row['item_category_id'] . '：' . $item_category[$row['item_category_id']]; ?> </td>
			<td><?php echo Html::anchor('admin/item/edit/'.$row['id'], mb_strimwidth($row['item_name'], 0, 30, '...')) ?></td>
			<td><?php echo mb_strimwidth($row['item_details'], 0, 30, '...'); ?></td>
			<td><?php echo $row['item_expire_seconds']; ?>秒(=<?php echo $row['item_expire_seconds']/86400;?>日)</td>
			<td><?php echo $row['item_point_up_rate']; ?>%</td>
			<td> <img src="/assets/admin/img/photo/<?php echo $row['photo_saved_as'];?>" width="85" height="85"> </td>
			<td><?php echo $row['upd_date']; ?></td>
			<?php if ( $user == 'admin' ) : ?>
    			<td><?php echo Form::button('delete', '削除', array('class' => 'action button-green smaller index-button'));?></td>
    		<?php endif; ?>
		</tr>
		<?php echo Form::close(); ?>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="flakes-pagination right">
	<?php echo Pagination::instance('pager')->render();?>
</div>

<div class="csv_DL">
<?php echo Form::open(array('action' => $download_url, 'id' => 'download') ); ?>
	<?php echo Html::anchor('javascript:void(0);', 'CSVダウンロード', array('class' => 'csv_download')) ?>
	<?php echo Form::hidden('keyword', Input::get('keyword'), array('id' => 'keyword'))?>
	<?php echo Form::hidden('keyword_id', Input::get('keyword_id'), array())?>
<?php echo Form::close(); ?>
</div>

<div class="homeIndex box">
    <div class="box-header">
        <?php echo Form::open(array("action" => $upload_url,
            "class"=>"form-horizontal",
            "enctype"=>"multipart/form-data",
        )); ?>
            <!-- .box-body -->
            <div class="box-body">
                <div class="form-group">
                    <?php echo Form::label('CSVファイルを選択してください', 'csv', array('class'=>'col-sm-4 control-label')); ?>
                    <?php echo Form::file('csv'); ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php echo Form::submit('submit', '登録', array('class' => 'btn btn-primary pull-right')); ?>
            </div>
            <!-- /.box-footer -->
        <?php echo Form::close(); ?>
    </div>
</div>