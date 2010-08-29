<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Назначить тренера команде <?=$line->club->name;?>, в турнире <?=$line->table->name;?></p>
<?=form::open();?>
<p><?=form::select('user_id', $users, $line->user_id, array('class' => 'select medium field'));?></p>
<p><?=form::submit('', 'Сохранить изменения');?></p>
<?=form::close();?>