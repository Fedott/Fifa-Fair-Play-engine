<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Назначить трофей команде <?=$line->team->name;?>, в турнире <?=$line->table->name;?></p>
<?=form::open();?>
<p><?=form::dropdown('trophy_id', $trophies);?></p>
<p><?=form::submit('', 'Сохранить изменения');?></p>
<?=form::close();?>