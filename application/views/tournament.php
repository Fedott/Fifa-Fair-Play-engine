<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Турниры:</h2>
<?php if(count($tournaments)):?>
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th>№</th>
			<th>Название</th>
			<th>Команды участники</th>
		</tr>
	</thead>
	<?php $i = 1;?>
	<?php foreach($tournaments as $tournament):?>
		<?php $ii = 0;?>
		<tr>
			<td class="center"><?=$i++?></td>
			<td><?=html::anchor('/tournament/view/'.$tournament->url, $tournament->name, array('class' => 'tournament'))?></td>
			<td><?php foreach($tournament->lines as $line):?><?=(++$ii!=1)?', ':''?><?=$line->club->name?><?php endforeach;?></td>
		</tr>
	<?php endforeach;?>
</table>
<?php else:?>
	Ещё нет ни одного турнира.
<?php endif;?>