<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Команда, <?=$line->team->name?>, в турнире <?=$line->table->name;?></p>
<?if($line->user_id):?>
<p>Управляет командой: <?=$line->user->username;?></p>
<?else:?>
<p>Тренер не назначен</p>
<?endif;?>
<ul class="admin_actions">
	<li>
		<?=html::anchor('admin/tournament/line_coach/'.$line->id, 'Сменить управляющего командой');?>
	</li>
	<li>
		<?=html::anchor('admin/tournament/line_trophy/'.$line->id, 'Назначить трофей');?>
	</li>
</ul>