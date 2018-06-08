

<h1>当選シリアル管理</h1>

<h2>「<?php echo $campaign->present_name; ?>(<?php echo $campaign->present_code; ?>)」<br>「<?php echo $present->present_data_name; ?>」の当選シリアル<?php echo $mode == 'new' ? '新規登録' : '編集'; ?></h2>
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
					<legend>当選シリアル</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>当選シリアル<span class="required">(※)</span></label>
							<?php echo Form::input('key', Input::post('key', isset($dbRow) ? $dbRow->key : '')); ?>
						</div>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'保存', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
		<?php echo Html::anchor('admin/presentkey/list/'.$present->present_data_id, '戻る', array('class' => 'action button-gray bigger right')) ?>
		<?php if ( $mode == 'edit' ) : ?>
		<?php echo Html::anchor('javascript:void(0);', '削除', array('class' => 'action button-red bigger right', 'id' => 'button-delete')) ?>
		<?php endif; ?>
	</div>
	
<?php echo Form::close(); ?>

<?php if ( $mode == 'edit' ) : ?>
<?php echo Form::open( array('action' => $delete_url, 'id' => 'form-delete') ); ?>
<?php echo Form::close(); ?>
<?php endif; ?>

