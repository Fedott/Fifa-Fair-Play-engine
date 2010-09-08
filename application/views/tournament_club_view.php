<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$line->club->name;?></h1>
<p>Турнир: <?=html::anchor('/tournament/view/'.$tournament->url, $tournament->name);?></p>
<p>Тренер: <?=$line->user->first_name." ".$line->user->last_name." (".$line->user->username.")";?> ICQ: <?=$line->user->icq;?></p>
<table class="season_info">
	<tbody>
		<tr>
			<td>Матчей:</td>
			<td><?=$line->games;?></td>
		</tr>
		<tr>
			<td>Очков:</td>
			<td><?=$line->points;?></td>
		</tr>
		<tr>
			<td>Выйграно</td>
			<td><?=$line->win;?></td>
		</tr>
		<tr>
			<td>Ничьих:</td>
			<td><?=$line->drawn;?></td>
		</tr>
		<tr>
			<td>Проиграно:</td>
			<td><?=$line->lose;?></td>
		</tr>
		<tr>
			<td>Забито:</td>
			<td><?=$line->goals;?></td>
		</tr>
		<tr>
			<td>Пропущено</td>
			<td><?=$line->passed_goals;?></td>
		</tr>
	</tbody>
</table>

<?if(count($goleodors)):?>
<h4>Бамбардиры команды</h4>
<table cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<th class="number">№</th>
			<th>Имя</th>
			<th class="count">Забито</th>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?foreach ($goleodors as $lin):?>
		<tr class="<?=text::alternate('nechet', 'chet')?>">
			<td><?=$i++;?></td>
			<td><?=$lin['player']->player_name(NULL);?></td>
			<td><?=$lin['goals'];?></td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>
<?else:?>
<p>Ещё не забито ни одного гола</p>
<?endif;?>

<h4>Матчи команды</h4>
<table class="matches" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<th>Домашняя команда</th>
			<th>Счёт</th>
			<th>Гостевая команды</th>
			<th>Дата</th>
		</tr>
	</thead>
	<tbody>
	<?foreach($matches as $match):?>
		<tr class="<?=text::alternate('nechet', 'chet')?><?=(($match->away->id == $my_line->id) OR ($match->home->id == $my_line->id))?' my_team':'';?>">
			<td><?=html::anchor('/tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?></td>
			<td><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
			<td><?=html::anchor('/tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?></td>
			<td><?=misc::get_human_date($match->date);?></td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>

<h4>Сыгранные/не сыгранные матчи</h4>
<table class="matches" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<th>Команда</th>
			<?for($i = 1; $i <= $tournament->matches; $i++):?>
			<th>Круг <?=$i;?></th>
			<?endfor;?>
		</tr>
	</thead>
	<tbody>
		<?text::alternate();?>
		<?foreach($tournament->lines as $ll):?>
			<?if($ll->id != $line->id):?>
			<tr class="<?=text::alternate('nechet', 'chet')?>">
				<td><?=html::anchor('tournament/team/'.$ll->id, $ll->club->name);?></td>
				<?for($i = 1; $i <= $tournament->matches; $i++):?>
				<td>
					<?if(arr::path($played_matches, $ll->id.".count", 0) >= $i):?>
						<p class="play">Сыгран (<?=$played_matches[$ll->id][$i]->home_goals;?> - <?=$played_matches[$ll->id][$i]->away_goals;?>)</p>
					<?else:?>
						<p class="not_play">Не сыгран</p>
					<?endif;?>
				</td>
				<?endfor;?>
			</tr>
			<?endif;?>
		<?endforeach;?>
	</tbody>
</table>