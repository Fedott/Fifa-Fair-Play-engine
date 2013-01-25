<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Вы уверены что хотитет удалить видео, <?=$video->title;?></h2>
<br />
<?=HTML::anchor('admin/video/delete/'.$video->id."?delete=true", 'Да');?>
|
<?=HTML::anchor('admin/video', 'Нет');?>
