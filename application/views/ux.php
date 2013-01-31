<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?=$title;?>
		</title>
		<?=HTML::style('templates/ux/css/bootstrap.css', array('rel' => 'stylesheet', 'media' => 'screen'));?>

		<?=HTML::script('http://code.jquery.com/jquery-latest.js');?>
		<?=HTML::script('templates/ux/js/bootstrap.js');?>
	</head>
	<body>
		<div class="container">
			<?=Request::factory(Route::get('widget')->uri(array(
					'action' => 'menu',
					'param1' => 'default',
				)))->execute();
			?>
			<?=$content;?>
		</div>
	</body>
</html>
