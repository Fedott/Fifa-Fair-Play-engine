<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Назначить тренера команде <?=$line->team->name;?>, в турнире <?=$line->table->name;?></p>
<?=form::open();?>
<p><?=form::dropdown('user_id', $users, $line->user_id);?></p>
<p><?=form::submit('', 'Сохранить изменения');?></p>
<?=form::close();?>