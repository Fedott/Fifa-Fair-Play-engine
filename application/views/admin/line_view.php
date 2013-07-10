<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Команда, <?=$line->club->name?>, в турнире <?=$line->table->name;?></p>
<?php if($line->user->id):?>
<p>Управляет командой: <?=$line->user->username;?></p>
<?php else:?>
<p>Тренер не назначен</p>
<?php endif;?>
<ul class="admin_actions">
	<li>
		<?=html::anchor('admin/tournament/line_coach/'.$line->id, 'Сменить управляющего командой');?>
	</li>
	<li>
		<?=html::anchor('admin/tournament/line_matches/'.$line->id, 'Матчи');?>
	</li>
	<li>
		<?=html::anchor('admin/tournament/line_trophy/'.$line->id, 'Назначить трофей');?>
	</li>
	<li>
		<?=html::anchor('admin/tournament/line_delete_force/'.$line->id, 'Удалать команду вместе с результатами', array('class' => 'red'));?>
	</li>
</ul>