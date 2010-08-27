<?php defined('SYSPATH') OR die('No direct access allowed.');?>
Эмблема клуба, <?=$club->name;?><br>
<?=HTML::image($club->logo);?>
<hr>
<?=Form::open('', array('enctype' => 'multipart/form-data'));?>
	<?=Form::file('logo');?>
<br>
	<?=Form::submit('submit', 'Изменить');?>
<?=Form::close();?>