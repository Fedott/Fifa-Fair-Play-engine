<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?=Form::open(NULL, array('enctype' => 'multipart/form-data'));?>
	<?=$video->input('title');?>
	<?=$video->input('description');?>
	<?=Form::file('video');?>
	<?=Form::submit('', 'Загрузить');?>
<?=Form::close();?>