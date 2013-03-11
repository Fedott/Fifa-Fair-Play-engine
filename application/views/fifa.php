<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?=$title;?> <?=(isset($breadcrumb)?misc::title_from_breadcrumb($breadcrumb):"");?> &bull; Чемпионат "Красивый футбол!"</title>
	<link rel="shortcut icon" href="/templates/fifa/img/favicon.ico" type="image/x-icon" />

	<meta http-equiv="Content-Type" Content="text/html; Charset=UTF-8">
	<meta http-equiv="content-language" content="ru">
	<meta name="description" Content="Чемпионат Красивый футбол сайт где проводится чемпионат по игре FIFA Soccer. Сдесь в этом чемпионате играют только в красивый футбол, без багов, без задротства. Чемпионат создан для получения удовольствия от игры в футбол на виртуальных полях.">

	<?=HTML::style('templates/fifa/css/reset.css');?>
	<?=HTML::style('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/redmond/jquery-ui.css');?>
	<?=HTML::style('templates/fifa/css/main.css');?>
	<?=HTML::style('templates/fifa/css/form.css');?>
	<?=HTML::style('templates/fifa/css/forum.css');?>
	<?=HTML::style('templates/fifa/js/jwysiwyg/jquery.wysiwyg.css');?>

	<?=HTML::script('templates/fifa/js/jquery.js');?>
	<?=HTML::script('templates/fifa/js/jquery-ui.js');?>
	<?=HTML::script('templates/fifa/js/jquery.listen.js');?>
	<?=HTML::script('templates/fifa/js/jquery.corner.js');?>
	<?=HTML::script('templates/fifa/js/jquery.popup.js');?>
	<?=HTML::script('templates/fifa/js/jquery.form.js');?>
	<?=HTML::script('templates/fifa/js/jquery.tmpl.js');?>
	<?=HTML::script('templates/fifa/js/jwysiwyg/jquery.wysiwyg.js');?>
	<?=HTML::script('templates/fifa/js/jquery.youtubepopup.js');?>
	<?=HTML::script('templates/fifa/js/main.js');?>
</head>
<body>
	<div id="center">
		<a id="head" href="<?=URL::base();?>"></a>
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
			<div class="socil_buttons">
				<a href="http://twitter.com/fifafairplay_ru">
					<?=html::image('templates/fifa/img/twitter.png', array('alt' => __("Мы в твиттере")));?>
				</a>
				<a href="http://vk.com/fifafairplay">
					<?=html::image('templates/fifa/img/vk.png', array('alt' => __("Мы вконтакте")));?>
				</a>
			</div>
			<div class="c">
				Чемпионат "Красивый футбол!" &copy;
			</div>
		</div>
	</div>

	<!-- Yandex.Metrika counter -->
	<div style="display:none;"><script type="text/javascript">
	(function(w, c) {
	    (w[c] = w[c] || []).push(function() {
	        try {
	            w.yaCounter336263 = new Ya.Metrika(336263);
	             yaCounter336263.clickmap(true);

	        } catch(e) { }
	    });
	})(window, 'yandex_metrika_callbacks');
	</script></div>
	<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
	<noscript><div><img src="//mc.yandex.ru/watch/336263" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

	<!--Google Analytics -->
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-5481004-1");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	<!--/Google Analytics -->
</body>
</html>