<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1>Внимание!</h1>
<h3>Вы пытаетесь удалить команду, <strong class='red'><?=$line->club->name;?></strong>, из турнира, <strong class='green'><?=$line->table->name;?></strong>, вместе с результатами матчей! Эти изменения НЕ обратимы.</h3>
<?=form::open();?>
	<p>Вы уверены что хотите удалить команду из турнира?</p>
	<?=form::submit('delete_line', 'Я уверен что хочу удалить команду из турнира. Если что пиздить меня.');?>
<?=form::close();?>