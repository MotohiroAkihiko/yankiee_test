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
		
		<div class="flakes-content">
			<div class="view-wrap">
				<p class="flakes-message error">
					<?php echo $message; ?>
				</p>
				<a href=""><?php echo Html::anchor('admin/', 'トップへ戻る') ?></a>
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
	<?php echo Asset::render('add_js');?>

</body>
</html>