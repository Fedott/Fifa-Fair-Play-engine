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
	<?foreach($clubs as $club):?>
		<tr class="<?=text::alternate('nechet', 'chet');?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/admin/club/view/'.$club->id, $club->name, array('class' => 'club'))?></td>
			<td><?foreach($club->lines as $key => $line):?><?=($key==1)?', ':''?><?=$line->table->name?><?endforeach;?></td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>