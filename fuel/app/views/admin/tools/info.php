

<h1>4Q運用ツール</h1>

<h2>お知らせ一括登録用SQL生成</h2>
<br>

<?php if ( !empty($errors) ) : ?>
<p class="flakes-message error">
	<?php foreach ( $errors as $error ) : ?>
		<?php echo $error; ?><br>
	<?php endforeach; ?>
</p>
<?php endif; ?>
<br>

<?php echo Form::open( array('class' => 'grid-form') ); ?>
	<div class="grid-10 gutter-20">
		<div class="span-7">
				<fieldset>
					<legend>お知らせ内容</legend>
						<div data-field-span="1">
							<label><span class="required">下のテキストエリアにExcelから貼り付けて生成ボタン！<br>(※)エラーになったらExcelデータ不備かプログラム考慮漏れ！</span></label>
							<?php echo Form::textarea('info_tsv', Input::post('info_tsv', ''), array('rows' => 6, 'placeholder' => '”ココにExcelからコピーしたタブ区切りのデータを貼り付けてください。”')); ?>
						</div>
						<?php if ( !is_null(Input::post('info_tsv')) ) :?>
						<div data-field-span="1">
							<label><span class="required">↓↓↓↓↓生成結果↓↓↓↓↓</span></label>
							<?php echo Form::textarea('insert_query', $insert_query, array('rows' => 6)); ?>
						</div>
						<?php endif;?>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'生成', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
	</div>
	
<?php echo Form::close(); ?>

