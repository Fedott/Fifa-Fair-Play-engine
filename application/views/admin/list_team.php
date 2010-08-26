<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1>Команды:</h1>
<table class="teams" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<td class="number"></td>
			<td>Название</td>
			<td>Турниры</td>
		</tr>
	</thead>
	<tbody>
	<?foreach($teams as $team):?>
		<tr class="<?=(($i%2)==0)?'chet':'nechet'?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/admin/team/view/'.$team->id, $team->name, array('class' => 'team'))?></td>
			<td><?foreach($team->lines as $key => $line):?><?=($key==1)?', ':''?><?=$line->table->name?><?endforeach;?></td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>