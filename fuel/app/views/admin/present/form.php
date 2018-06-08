

<h1>景品管理</h1>

<h2>「<?php echo $campaign->present_name; ?>(<?php echo $campaign->present_code; ?>)」の景品<?php echo $mode == 'new' ? '新規登録' : '編集'; ?></h2>
<br>

<?php if ( !empty($errors) ) : ?>
<p class="flakes-message error">
	<?php foreach ( $errors as $error ) : ?>
		<?php echo $error->get_message(); ?><br>
	<?php endforeach; ?>
</p>
<?php endif; ?>
<br>

<?php echo Form::open( array('class' => 'grid-form') ); ?>
	<div class="grid-10 gutter-20">
		<div class="span-7">
				<fieldset>
					<legend>景品内容</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>景品名<span class="required">(※)</span></label>
							<?php echo Form::input('present_data_name', Input::post('present_data_name', isset($dbRow) ? $dbRow->present_data_name : '')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>景品説明<span class="required">(※)</span></label>
							<?php echo Form::textarea('present_data_txt', Input::post('present_data_txt', isset($dbRow) ? $dbRow->present_data_txt : ''), array('rows' => 6)); ?>
						</div>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'保存', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
		<?php echo Html::anchor('admin/present/list/'.$campaign->present_id, '戻る', array('class' => 'action button-gray bigger right')) ?>
		<?php if ( $mode == 'edit' ) : ?>
		<?php echo Html::anchor('javascript:void(0);', '削除', array('class' => 'action button-red bigger right', 'id' => 'button-delete')) ?>
		<?php endif; ?>
	</div>
	
<?php echo Form::close(); ?>

<?php if ( $mode == 'edit' ) : ?>
<?php echo Form::open( array('action' => $delete_url, 'id' => 'form-delete') ); ?>
<?php echo Form::close(); ?>
<?php endif; ?>

