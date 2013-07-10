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
	<?php $i = 1;?>
	<?php foreach($clubs as $club):?>
		<tr class="<?=text::alternate('nechet', 'chet');?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/admin/club/view/'.$club->id, $club->name, array('class' => 'club'))?></td>
			<td><?php foreach($club->lines as $key => $line):?><?=($key==1)?', ':''?><?=$line->table->name?><?php endforeach;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<hr/>
<div class="control-panel">
	<ul>
		<li>
			<?=html::anchor('admin/club/edit', 'Создать команду');?>
		</li>
	</ul>
</div>