<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$tournament->name;?></h1>
<table cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<th>№</th>
			<th>Команда</th>
			<th>Матчей</th>
			<th>Побед</th>
			<th>Ничьих</th>
			<th>Поражений</th>
			<th>Забито</th>
			<th>Пропущено</th>
			<th>Разница</th>
			<th>Очков</th>
		</tr>
	</thead>
	<?$i = 1;?>
	<?foreach ($tournament->lines as $line):?>
	<tr class="<?=text::alternate('nechet', 'chet');?><?=($line->user->id == $user->id)?' my_team':'';?>">
		<td><?=$i++?></td>
		<td><?=html::anchor('tournament/club/'.$line->id, $line->club->name);?></td>
		<td><?=$line->games;?></td>
		<td><?=$line->win?></td>
		<td><?=$line->drawn?></td>
		<td><?=$line->lose?></td>
		<td><?=$line->goals?></td>
		<td><?=$line->passed_goals?></td>
		<td><?=$line->goals - $line->passed_goals?></td>
		<td><?=$line->points?></td>
	</tr>
	<?endforeach;?>
</table>
<?if(count($goleodors)):?>
<h3>Бомбардиры турнира</h3>
<table cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<th>№</th>
			<th>Имя</th>
			<th>Команда</th>
			<th>Забито</th>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?=text::alternate();?>
		<?foreach ($goleodors as $line):?>
		<tr class="<?=text::alternate('nechet', 'chet');?><?=($line['line_id'] == $my_line->id)?' my_team':'';?>">
			<td><?=$i++;?></td>
			<td><?=$line['player']->player_name(NULL);?></td>
			<td><?=html::anchor('tournament/club/'.$line['line_id'], $line['player']->club->name);?></td>
			<td><?=$line['goals'];?></td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>
<?else:?>
<p>Ещё не забито ни одного гола</p>
<?endif;?>
<?=html::anchor('match/list/'.$tournament->url, 'Матчи в рамках турнира');?>
<?if($uchastie):?>
<hr>
<?=html::anchor('match/reg/'.$tournament->id, 'Зарегистрировать матч');?>
<?endif;?>
