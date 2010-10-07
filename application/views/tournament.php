<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Турниры:</h2>
<?if(count($tournaments)):?>
<table cellpadding="3" cellspacing="1">
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
		<tr class="<?=text::alternate('nechet', 'chet');?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/tournament/view/'.$tournament->url, $tournament->name, array('class' => 'tournament'))?></td>
			<td><?foreach($tournament->lines as $line):?><?=(++$ii!=1)?', ':''?><?=$line->club->name?><?endforeach;?></td>
		</tr>
	<?endforeach;?>
</table>
<?else:?>
	Ещё нет ни одного турнира.
<?endif;?>