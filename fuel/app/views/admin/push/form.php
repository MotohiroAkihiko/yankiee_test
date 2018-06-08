

<h1>Push通知管理</h1>

<h2>Push通知<?php echo $mode == 'new' ? '新規登録' : '編集'; ?></h2>
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
					<legend>Push通知内容</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>通知名称<span class="required">(※)</span></label>
							<?php echo Form::input('push_name', Input::post('push_name', isset($dbRow) ? $dbRow->push_name : ''), array('maxlength' => 16)); ?>
						</div>
					</div>
					<div data-row-span="2">
						<div data-field-span="1">
							<label>通知ティッカー<span class="required">(※)</span></label>
							<?php echo Form::input('push_ticker', Input::post('push_ticker', isset($dbRow) ? $dbRow->push_ticker : ''), array('maxlength' => 16)); ?>
						</div>
						<div data-field-span="1">
							<label>通知タイトル<span class="required">(※)</span></label>
							<?php echo Form::input('push_title', Input::post('push_title', isset($dbRow) ? $dbRow->push_title : ''), array('maxlength' => 16)); ?>
						</div>	
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>通知メッセージ<span class="required">(※)</span></label>
							<?php echo Form::input('push_message', Input::post('push_message', isset($dbRow) ? $dbRow->push_message : ''), array('maxlength' => 25)); ?>	
						</div>
					</div>
				</fieldset>
		</div>
		<div class="span-3">
				<fieldset>
					<legend>期間</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>通知配信（開始）<span class="required">(※)</span></label>
							<?php echo Form::input('push_start_date', Input::post('push_start_date', isset($dbRow) ? $dbRow->push_start_date : ''), array('class' => 'datetimepicker-from')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>通知配信（終了）</label>
							<?php echo Form::input('push_end_date', Input::post('push_end_date', isset($dbRow) ? $dbRow->push_end_date : ''), array('class' => 'datetimepicker-to')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>配信フラグ</label>
							<?php echo Form::checkbox('push_flg', '1', Input::get('push_flg', isset($dbRow) ? $dbRow->push_flg : 1) == '1' , array('class' => 'checkbox')); ?> 配信する
						</div>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'保存', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
		<?php echo Html::anchor('admin/push', '戻る', array('class' => 'action button-gray bigger right')) ?>
		<?php if ( $mode == 'edit' ) : ?>
		<?php echo Html::anchor('javascript:void(0);', '削除', array('class' => 'action button-red bigger right', 'id' => 'button-delete')) ?>
		<?php endif; ?>
	</div>
	
<?php echo Form::close(); ?>

<?php if ( $mode == 'edit' ) : ?>
<?php echo Form::open( array('action' => $delete_url, 'id' => 'form-delete') ); ?>
<?php echo Form::close(); ?>
<?php endif; ?>

