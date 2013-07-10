<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1>Турниры:</h1>
<table class="teams" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<td class="number"></td>
			<td>Название</td>
			<td>Участники</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($tournaments as $tournament):?>
		<?php $ii = 0;?>
		<tr class="<?=(($i%2)==0)?'chet':'nechet'?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/admin/tournament/view/'.$tournament->id, $tournament->name, array('class' => 'tournament'))?></td>
			<td><?php foreach($tournament->lines as $key => $line):?><?=(++$ii!=1)?', ':''?><?=$line->club->name?><?php endforeach;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<hr/>
<div class="control-panel">
	<ul>
		<li>
			<?=html::anchor('admin/tournament/edit', 'Создать турнир');?>
		</li>
		<li>
			<?=html::anchor('admin/tournament/trophy_edit', 'Создать трофей');?>
		</li>
	</ul>
</div>