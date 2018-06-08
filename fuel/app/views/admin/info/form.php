

<h1>お知らせ管理</h1>

<h2>お知らせ<?php echo $mode == 'new' ? '新規登録' : '編集'; ?></h2>
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
					<legend>お知らせ内容</legend>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>お知らせタイトル<span class="required">(※)</span></label>
							<?php echo Form::input('info_title', Input::post('info_title', isset($dbRow) ? $dbRow->info_title : '')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>お知らせ内容<span class="required">(※)</span></label>
							<?php echo Form::textarea('info_details', Input::post('info_details', isset($dbRow) ? $dbRow->info_details : '<p style=" margin-right:auto; margin-left:auto; width:80%;"> ｛メッセージ文面｝</p> <div style="text-align:center; padding-top:35px; padding-bottom:15px; "> <a href="<?=$tagObj->getUrl(\'｛リンクURL｝\')?>"> <?=$tagObj->getImgClass(\'｛画像ボタンURL｝\',\'\')?></a></div>'), array('rows' => 6)); ?>
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
							<?php echo Form::input('publish_start_date', Input::post('publish_start_date', isset($dbRow) ? $dbRow->publish_start_date : ''), array('class' => 'datetimepicker-from')); ?>
						</div>
					</div>
					<div data-row-span="1">
						<div data-field-span="1">
							<label>公開期間（終了）</label>
							<?php echo Form::input('publish_end_date', Input::post('publish_end_date', isset($dbRow) ? $dbRow->publish_end_date : ''), array('class' => 'datetimepicker-to')); ?>
						</div>
					</div>
				</fieldset>
		</div>
	</div>
	
	<br>
	<div class="flakes-actions-bar">
		<?php echo Form::submit(array('value'=>'保存', 'name'=>'submit', 'class' => 'action button-green bigger left')); ?>
		<?php echo Html::anchor('admin/info', '戻る', array('class' => 'action button-gray bigger right')) ?>
		<?php if ( $mode == 'edit' ) : ?>
		<?php echo Html::anchor('javascript:void(0);', '削除', array('class' => 'action button-red bigger right', 'id' => 'button-delete')) ?>
		<?php endif; ?>
	</div>
	
<?php echo Form::close(); ?>

<p class="flakes-message tip">
[リンクURL参考]<br>
本日のデイリーミッション： /mission/y003-02.php<br>
今月のマンスリーミッション： /mission/y003-04_1.php<br>
週間ランキング： /ranking/y004-02.php<br>
競技一覧： /game/y007-01.php<br>
</p>

<p class="flakes-message tip">
[画像ボタンURL参考]<br>
挑戦する！： img/support/challenge.png<br>
確認する！： img/support/check_it.png<br>
マンスリーミッション： img/support/info_monthly.png<br>
</p>

<p class="flakes-message tip">
[メッセージテンプレート]<br>
<code>&lt;p style=&quot; margin-right:auto; margin-left:auto; width:80%;&quot;&gt;
｛メッセージ文面｝&lt;/p&gt;
&lt;div style=&quot;text-align:center; padding-top:35px; padding-bottom:15px; &quot;&gt;
&lt;a href=&quot;&lt;?=$tagObj-&gt;getUrl(&#039;｛リンクURL｝&#039;)?&gt;&quot;&gt;
&lt;?=$tagObj-&gt;getImgClass(&#039;｛画像ボタンURL｝&#039;,&#039;&#039;)?&gt;&lt;/a&gt;&lt;/div&gt;</code>
</p>

<p class="flakes-message tip">
例)<br>
<code>&lt;p style=&quot; margin-right:auto; margin-left:auto; width:80%;&quot;&gt;
デイリーミッションが始まったな。今すぐチェックしてクリアするんだ！&lt;/p&gt;
&lt;div style=&quot;text-align:center; padding-top:35px; padding-bottom:15px; &quot;&gt;
&lt;a href=&quot;&lt;?=$tagObj-&gt;getUrl(&#039;/mission/y003-02.php&#039;)?&gt;&quot;&gt;
&lt;?=$tagObj-&gt;getImgClass(&#039;img/support/challenge.png&#039;,&#039;&#039;)?&gt;&lt;/a&gt;&lt;/div&gt;</code>
</p>

<?php if ( $mode == 'edit' ) : ?>
<?php echo Form::open( array('action' => $delete_url, 'id' => 'form-delete') ); ?>
<?php echo Form::close(); ?>
<?php endif; ?>

