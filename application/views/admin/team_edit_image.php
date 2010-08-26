<?php defined('SYSPATH') OR die('No direct access allowed.');?>
Эмблема клуба, <?=$team->name;?><br>
<?=html::image($team->img);?>
<hr>
<?=form::open_multipart();?>
	<?=form::upload('picture');?>
	<?=form::submit('submit', 'Изменить');?>
<?=form::close();?>