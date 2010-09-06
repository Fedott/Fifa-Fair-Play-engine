<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?=$title?> | Чемпионат "Красивый футбол!"</title>
	<link rel="shortcut icon" href="/templates/fifa/img/favicon.ico" type="image/x-icon" />
	<?=HTML::style('templates/fifa/css/reset.css');?>
	<?=HTML::style('templates/fifa/css/main.css');?>
	<?=HTML::style('templates/fifa/css/form.css');?>
	<?=HTML::style('templates/fifa/js/jwysiwyg/jquery.wysiwyg.css');?>
	<?=HTML::script('templates/fifa/js/jquery.js');?>
	<?=HTML::script('templates/fifa/js/jquery.listen.js');?>
	<?=HTML::script('templates/fifa/js/main.js');?>
</head>
<body>
	<div id="center">
		<div id="head" onClick="window.location='/'" style="cursor:pointer">
			
		</div>
<!--		<div id="menu">
			<div id="menu_left"></div>
			<div id="menu_center">
				<a href="/" class="menu_button">Главная</a>
				<a href="/match/" class="menu_button">Матчи</a>
				<a href="/team/" class="menu_button">Команды</a>
				<a href="/tournaments/" class="menu_button">Турниры</a>
			</div>
			<div id="menu_right"></div> 
		</div>-->
		
		<div id="middle">
			<div id="container">
				<div id="breadcrumb">
					<?=(isset($breadcrumb)?$breadcrumb:"").$title;?>
				</div>
			<?if(MISC::isset_error_message()):?>
				<div id="error_message">
					<?=MISC::get_error_message();?>
				</div>
			<?endif;?>
			<?if(MISC::isset_apply_message()):?>
				<div id="apply_message">
					<?=MISC::get_apply_message();?>
				</div>
			<?endif;?>
				<div id="content">
					<?=$content?>
				</div>
			</div>
			<div id="sidebar" class="sl">
				<?=Request::factory(Route::get('widget')->uri(array(
						'action' => 'menu',
						'param1' => 'default',
					)))->execute();
				?>
			</div>
		</div>
		<div id="footer">
		
		</div>
	</div>
	
</body>
</html>