<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$tournament->name?></h1>
<?if(count($tournament->lines)):?>
<p>Команды учавствующие в турнире:</p>
<ul>
	<?php /** @var $line Model_Line */?>
	<?foreach($tournament->lines as $key => $line):?>
		<li>
			<?=html::anchor('admin/tournament/line_view/'.$line->id, $line->club->name)?>
			<?if($line->win + $line->drawn + $line->lose == 0):?>
				| <?=html::anchor('admin/tournament/line_delete/'.$line->id, 'X');?>
			<?endif;?>
		</li>
	<?endforeach;?>
</ul>
<?else:?>
<p>
	Турнир пока пуст
</p>
<?endif?>
<hr>
<?=html::anchor('admin/tournament/edit/'.$tournament->id, 'Редактировать')?>
<br>
<?=html::anchor('admin/tournament/edit_lines/'.$tournament->id, 'Добавить команды')?>