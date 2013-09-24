<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?=$title;?>
		</title>
		<link rel="shortcut icon" href="/templates/fifa/img/favicon.ico" type="image/x-icon" />

		<meta http-equiv="Content-Type" Content="text/html; Charset=UTF-8">
		<meta http-equiv="content-language" content="ru">
		<meta name="description" Content="Чемпионат Красивый футбол сайт где проводится чемпионат по игре FIFA Soccer. Здесь в этом чемпионате играют только в красивый футбол, без багов, без задротства. Чемпионат создан для получения удовольствия от игры в футбол на виртуальных полях.">
		<meta name="keywords" content="Fifa 14, fifa 15, fifa 13, fifa 12, fifa, fifa soccer, чемпионат fifa 14, чемпионат fifa 13, турнир fifa 14, турнир fifa 13, футбол, красивый футбол, чемпионат">

		<?=HTML::style('templates/ux/css/bootstrap.css', array('rel' => 'stylesheet', 'media' => 'screen'));?>
		<?=HTML::style('templates/ux/css/bootstrap-responsive.css', array('rel' => 'stylesheet'));?>
		<?=HTML::style('templates/ux/css/bootstrap-wysihtml5.css');?>
		<?=HTML::style('http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css');?>

		<?=HTML::style('templates/ux/css/style.css', array('rel' => 'stylesheet'));?>

		<?=HTML::script('http://code.jquery.com/jquery-latest.js');?>
		<?=HTML::script('http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js');?>

		<?=HTML::script('templates/ux/js/jquery.tmpl.js');?>
		<?=HTML::script('templates/ux/js/jquery.youtubepopup.js');?>
		<?=HTML::script('templates/ux/js/jquery.form.js');?>
		<?=HTML::script('templates/ux/js/bootstrap.js');?>
		<?=HTML::script('templates/ux/js/wysihtml5.js');?>
		<?=HTML::script('templates/ux/js/bootstrap-wysihtml5.js');?>
		<?=HTML::script('templates/ux/js/main.js');?>
	</head>
	<body>
		<?=Request::factory(Route::get('widget')->uri(array(
			'action' => 'menu',
			'param1' => 'default',
		)))->execute();
		?>
		<div class="container">
			<?php if(MISC::isset_apply_message()):?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?=MISC::get_apply_message();?>
				</div>
			<?php endif;?>
			<?php if(MISC::isset_error_message()):?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?=MISC::get_error_message();?>
				</div>
			<?php endif;?>
			<?=$content;?>
		</div>
		<div id="kohana-profiler">
			<?//=View::factory('profiler/stats'); ?>
		</div>
	</body>
</html>
