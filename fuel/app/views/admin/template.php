<!doctype html>
<html lang="ja">
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="ja" class="no-js"><!--<![endif]-->

<head>

	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta charset="UTF-8" />

	<?php echo Asset::css('admin/css/all.css'); ?>
	<?php echo Asset::css('admin/css/common.css'); ?>
	<?php echo Asset::render('add_css');?>

	<title>ヤンキー::<?php echo $title; ?></title>

</head>

<body>
	<!--[if lt IE 7]>
		<p class="chromeframe" style="background:#eee; padding:10px; width:100%">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
	<![endif]-->

	<div class="flakes-frame">

		<?php if ( !is_null($current_user) ) : ?>
		<div class="flakes-navigation menu">

			<a href="index.html" class="logo">
				<?php echo Asset::img('admin/img/logo.png', array('style' => 'width:200px;')); ?>
			</a>

			<ul>
				<li class="title">
					<?php echo $current_user['name'] ?>さんがログイン中<br>
					<div class="<?php echo Fuel::$env == Fuel::PRODUCTION  ? 'site_prod' : 'site_dev'; ?>">[<?php echo Fuel::$env == Fuel::PRODUCTION  ? '本番サイト' : '開発サイト'; ?>]</div>
				</li>
			</ul>

			<ul>
				<li class="title">メインメニュー</li>
				<li><?php echo Html::anchor('admin/dashboard', 'ダッシュボード') ?></li>
				<li><?php echo Html::anchor('admin/user', 'ユーザー情報') ?></li>
				<li><?php echo Html::anchor('admin/info', 'お知らせ管理') ?></li>
				<li><?php echo Html::anchor('admin/item', 'アイテムマスタ管理') ?></li>
				<li><?php echo Html::anchor('admin/push', 'Push通知管理') ?></li>
				<li><?php echo Html::anchor('admin/dailymission', 'デイリーミッション管理') ?></li>
			</ul>

			<?php if ( $current_user['group'] == 'admin' || $current_user['group'] == '4q' ) : ?>
			<ul>
				<li class="title">4Q運用メニュー</li>
				<li><?php echo Html::anchor('admin/dashboard4q', '運用ダッシュボード') ?></li>
				<li><?php echo Html::anchor('admin/campaign', 'キャンペーン管理') ?></li>
				<li><?php echo Html::anchor('admin/master', '各種マスタ') ?></li>
				<li><?php echo Html::anchor('admin/manual', '運用マニュアル') ?></li>
			</ul>
			<ul>
				<li class="title">4Q運用ツール</li>
				<li><?php echo Html::anchor('admin/tools/info', 'お知らせ一括登録用SQL生成') ?></li>
			</ul>
			<?php endif; ?>

			<p class="foot">
				<?php echo Html::anchor('admin/logout', 'ログアウト', array('class' => 'action button-gray bigger')) ?>
			</p>
		</div>
		<?php endif; ?>

		<div class="flakes-content">

			<div class="flakes-mobile-top-bar">
				<a href="index.html" class="logo-wrap">
					<?php echo Asset::img('admin/img/logo.png', array('style' => 'height:30px;')); ?>
				</a>

				<a href="" class="navigation-expand-target">
					<?php echo Asset::img('admin/img/site-wide/navigation-expand-target.png', array('style' => 'height:30px;')); ?>
				</a>
			</div>

			<div class="view-wrap">
				<?php echo $content; ?>
			</div>
		</div>

	</div>
</div>

	<?php echo Asset::css('admin/bower_components/gridforms/gridforms.css'); ?>

	<?php echo Asset::js('admin/bower_components/jquery/jquery-1.11.2.min.js'); ?>
	<?php echo Asset::js('admin/bower_components/snapjs/snap.js'); ?>
	<?php echo Asset::js('admin/bower_components/responsive-elements/responsive-elements.js'); ?>
	<?php echo Asset::js('admin/bower_components/gridforms/gridforms.js'); ?>

	<?php echo Asset::js('admin/js/base.js'); ?>
	<?php echo Asset::js('admin/js/common.js'); ?>
	<?php echo Asset::render('add_js');?>

</body>
</html>