<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$line->club->name;?></h1>
<p>Турнир: <?=html::anchor('/tournament/view/'.$tournament->url, $tournament->name);?></p>
<p>Тренер: <?=$line->user->first_name." ".$line->user->last_name." (".$line->user->username.")";?> <?=$line->user->get_im(", ");?></p>
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

<?php if(count($goleodors)):?>
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
		<?php $i = 1;?>
		<?php foreach ($goleodors as $lin):?>
		<tr class="<?=text::alternate('nechet', 'chet')?>">
			<td><?=$i++;?></td>
			<td><?=$lin['player']->player_name(NULL);?></td>
			<td><?=$lin['goals'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php else:?>
<p>Ещё не забито ни одного гола</p>
<?php endif;?>

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
	<?php foreach($matches as $match):?>
		<tr class="<?=text::alternate('nechet', 'chet')?> <?=(($line->id != $my_line->id) AND (($match->away->id == $my_line->id) OR ($match->home->id == $my_line->id)))?' my_team':'';?>">
			<td><?=html::anchor('/tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?></td>
			<td><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
			<td><?=html::anchor('/tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?></td>
			<td><?=misc::get_human_date($match->date);?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<?php if($schedule):?>
	<h4>Расписание игр команды</h4>
	<table class="matches table">
		<thead>
			<tr>
				<th>Хозяева</th>
				<th>Статус</th>
				<th>Гости</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($schedule as $match):?>
				<tr class="<?=text::alternate('nechet', 'chet')?> <?=(($line->id != $my_line->id) AND (($match->away->id == $my_line->id) OR ($match->home->id == $my_line->id)))?' my_team':'';?>">
					<td>
						<?=html::anchor('/tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?>
					</td>
					<td class="center">
						<?php if($match->played):?>
							<span class="green">Сыгран </span>(<?=html::anchor('match/view/'.$match->match->id, $match->match->home_goals." - ".$match->match->away_goals);?>)
						<?php elseif($match->available):?>
							Скоро будет сыгран
						<?php else:?>
							<span class="gray">Не сыгран</span>
						<?php endif;?>
					</td>
					<td>
						<?=html::anchor('/tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else:?>
	<h4>Сыгранные/не сыгранные матчи</h4>
	<table class="matches" cellpadding="3" cellspacing="1">
		<thead>
			<tr>
				<th>Команда</th>
				<?php for($i = 1; $i <= $tournament->matches; $i++):?>
				<th>Круг <?=$i;?></th>
				<?php endfor;?>
			</tr>
		</thead>
		<tbody>
			<?text::alternate();?>
			<?php foreach($tournament->lines as $ll):?>
				<?php if($ll->id != $line->id):?>
				<tr class="<?=text::alternate('nechet', 'chet')?> <?=($ll->id == $my_line->id)?'my_team':'';?>">
					<td class="">
						<div class="club_info_in_profile">
							<?=html::anchor('tournament/club/'.$ll->id, $ll->club->name);?>
							<?=html::image('templates/fifa/img/profile_info.png', array('class' => 'popup_profile_trigger'));?>
							<div class="popup_profile">
								<strong><?=$ll->club->name;?></strong>
								<br>
								<?php if($ll->user->loaded()):?>
									<?=__("Тренер: ").$ll->user->username;?>
									<br>
									<?=$ll->user->get_im("<br/>");?>
								<?php else:?>
									У команды нет тренера
								<?php endif;?>
							</div>
						</div>
					</td>
					<?php for($i = 1; $i <= $tournament->matches; $i++):?>
					<td>
						<?php if(arr::path($played_matches, $ll->id.".count", 0) >= $i):?>
							<p class="play">Сыгран (<?php
								if (($played_matches[$ll->id][$i]->home->id == $line->id AND $played_matches[$ll->id][$i]->home_goals > $played_matches[$ll->id][$i]->away_goals) OR ($played_matches[$ll->id][$i]->home->id != $line->id AND $played_matches[$ll->id][$i]->home_goals < $played_matches[$ll->id][$i]->away_goals))
								{
									echo "<font class='green'>".$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals."</font>";
								}
								else
								{
									echo "<font class='red'>".$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals."</font>";
								}
							?>)</p>
						<?php else:?>
							<p class="not_play">Не сыгран</p>
						<?php endif;?>
					</td>
					<?php endfor;?>
				</tr>
				<?php endif;?>
			<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>