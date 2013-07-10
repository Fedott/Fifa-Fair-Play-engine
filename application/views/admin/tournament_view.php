<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$tournament->name?></h1>
<?php if(count($tournament->lines)):?>
<p>Команды учавствующие в турнире:</p>
<ul>
	<?php /** @var $line Model_Line */?>
	<?php foreach($tournament->lines as $key => $line):?>
		<li>
			<?=html::anchor('admin/tournament/line_view/'.$line->id, $line->club->name)?>
			<?php if($line->win + $line->drawn + $line->lose == 0):?>
				| <?=html::anchor('admin/tournament/line_delete/'.$line->id, 'X');?>
			<?php endif;?>
		</li>
	<?php endforeach;?>
</ul>
<?php else:?>
<p>
	Турнир пока пуст
</p>
<?php endif?>
<hr>
<?=html::anchor('admin/tournament/edit/'.$tournament->id, 'Редактировать')?>
<?php if($tournament->scheduled):?>
	<br/>
	<?=html::anchor('admin/tournament/make_schedule/'.$tournament->id, 'Сгенерировать расписание');?>
<?php endif;?>
<br>
<?=html::anchor('admin/tournament/edit_lines/'.$tournament->id, 'Добавить команды')?>