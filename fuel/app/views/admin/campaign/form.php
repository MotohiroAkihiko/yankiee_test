

<h1>キャンペーン管理</h1>

<h2>キャンペーン<?php echo $mode == 'new' ? '新規登録' : '編集'; ?></h2>
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
					<legend>キャンペーン内容</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>キャンペーン名<span class="required">(※)</span></label>
							<?php echo Form::input('present_name', Input::post('present_name', isset($dbRow) ? $dbRow->present_name : '')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>キャンペーンコード<span class="required">(※)</span></label>
							<?php echo Form::input('present_code', Input::post('present_code', isset($dbRow) ? $dbRow->present_code : '')); ?>
						</div>
					</div>
				</fieldset>
		</div>
		<div class="span-3">
				<fieldset>
					<legend>期間</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>公開期間（開始）<span class="required">(※)</span></label>
							<?php echo Form::input('present_start_date', Input::post('present_start_date', isset($dbRow) ? $dbRow->present_start_date : ''), array('class' => 'datetimepicker-from')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>公開期間（終了）<span class="required">(※)</span></label>
							<?php echo Form::input('present_end_date', Input::post('present_end_date', isset($dbRow) ? $dbRow->present_end_date : ''), array('class' => 'datetimepicker-to')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>結果発表期間（開始）<span class="required">(※)</span></label>
							<?php echo Form::input('result_start_date', Input::post('result_start_date', isset($dbRow) ? $dbRow->result_start_date : ''), array('class' => 'datetimepicker-from')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>結果発表期間（終了）<span class="required">(※)</span></label>
							<?php echo Form::input('result_end_date', Input::post('result_end_date', isset($dbRow) ? $dbRow->result_end_date : ''), array('class' => 'datetimepicker-to')); ?>
						</div>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'保存', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
		<?php echo Html::anchor('admin/campaign', '戻る', array('class' => 'action button-gray bigger right')) ?>
		<?php if ( $mode == 'edit' ) : ?>
		<?php echo Html::anchor('javascript:void(0);', '削除', array('class' => 'action button-red bigger right', 'id' => 'button-delete')) ?>
		<?php endif; ?>
	</div>
	
<?php echo Form::close(); ?>

<?php if ( $mode == 'edit' ) : ?>
<?php echo Form::open( array('action' => $delete_url, 'id' => 'form-delete') ); ?>
<?php echo Form::close(); ?>
<?php endif; ?>

