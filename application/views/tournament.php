<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Турниры:</h2>
<?if(count($tournaments)):?>
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>№</th>
			<th>Название</th>
			<th>Команды участники</th>
		</tr>
	</thead>
	<?$i = 1;?>
	<?foreach($tournaments as $tournament):?>
		<?$ii = 0;?>
		<tr>
			<td class="center"><?=$i++?></td>
			<td><?=html::anchor('/tournament/view/'.$tournament->url, $tournament->name, array('class' => 'tournament'))?></td>
			<td><?foreach($tournament->lines as $line):?><?=(++$ii!=1)?', ':''?><?=$line->club->name?><?endforeach;?></td>
		</tr>
	<?endforeach;?>
</table>
<?else:?>
	Ещё нет ни одного турнира.
<?endif;?>