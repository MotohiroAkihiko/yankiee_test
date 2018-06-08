
<div class="login">
<?php echo Asset::img('admin/img/logo.png', array('style' => 'text-align:center;')); ?>
	<?php if ( !empty($errors) || isset($login_error) ) : ?>
	<p class="flakes-message error">
		<?php foreach ( $errors as $error ) : ?>
			<?php echo $error->get_message(); ?><br>
		<?php endforeach; ?>
		<?php if ( isset($login_error) ) echo $login_error; ?>
	</p>
	<?php endif; ?>
	
	<?php echo Form::open(array()); ?>
		<fieldset>
			<legend>ログイン</legend>
				<ul>
					<li>
						<?php echo Form::input('login_user_id', Input::post('login_user_id'), array('placeholder' => 'ログインID', 'autofocus')); ?>
					</li>
					<li>
						<?php echo Form::password('password', null, array('placeholder' => 'パスワード')); ?>
					</li>
				</ul>
				
				<br>
				<?php echo Form::submit(array('value'=>'ログイン', 'name'=>'submit', 'class' => 'button-green bigger')); ?>
				
		</fieldset>
	<?php echo Form::close(); ?>
</div>


