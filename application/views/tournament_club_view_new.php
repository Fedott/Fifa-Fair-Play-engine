<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="row-fluid">
	<div class="span6 offset3 center">
		<h2><?=$line->club->name;?></h2>
	</div>
</div>
<div class="row-fluid">
	<div class="offset1 span7">
		<div class="row-fluid">
			<div class="span3">
				<div class="tournament_club_logo">
					<?=HTML::image('media/logos/' . $line->club->logo, array(
						'class' => 'img-polaroid'
					));?>
				</div>
			</div>
			<div class="span8">
				<table class="table-condensed">
					<tbody>
						<tr>
							<td>Турнир</td>
							<td><?=HTML::anchor('tournament/view/' . $line->table->id, $line->table->name);?></td>
						</tr>
						<tr>
							<td>Тренер</td>
							<td>
								<?=sprintf('%s %s (%s)', $line->user->first_name, $line->user->last_name, $line->user->username);?>
							</td>
						</tr>
						<tr>
							<td>Контакты</td>
							<td><?=$line->user->get_im(", ");?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<h4>Матчи команды</h4>
			<table class="matches table table-condensed table-hover">
				<thead>
				<tr>
					<th class="right">Домашняя команда</th>
					<th class="center">Счёт</th>
					<th>Гостевая команды</th>
					<th>Дата</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($matches as $count => $match):?>
					<tr
						class="
							<?=(($line->id != $my_line->id) AND (($match->away->id == $my_line->id) OR ($match->home->id == $my_line->id)))?' info':'';?>
							<?=($count >= 10)?'hide':'';?>
							"
					>
						<td class="right"><?=html::anchor('/tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?></td>
						<td class="center"><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
						<td><?=html::anchor('/tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?></td>
						<td><?=misc::get_human_date($match->date);?></td>
					</tr>
				<?php endforeach;?>
				<?php if (isset($count) AND $count >= 10):?>
					<tr>
						<td/>
						<td colspan="10"><a href="" class="muted show-all">Показать все</a></td>
					</tr>
				<?php endif;?>
				</tbody>
			</table>
		</div>
		<div class="row-fluid">
			<?php if($schedule):?>
				<h4>Расписание игр команды</h4>
				<table class="schedule table table-condensed table-hover">
					<thead>
					<tr>
						<th class="right">Хозяева</th>
						<th class="center">Статус</th>
						<th>Гости</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach($schedule as $match):?>
						<tr
							class="
								<?=(($line->id != $my_line->id) AND (($match->away->id == $my_line->id) OR ($match->home->id == $my_line->id)))?' info':'';?>
								"
						>
							<td class="right">
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
				<div class="row-fluid">
					<div class="span3">
						<h5><?=$line->club->name;?></h5>
					</div>
					<div class="span9">
						<table class="played_matches table table-condensed table-hover">
							<thead>
							<tr>
								<th />
								<th></th>
								<?php for($i = 1; $i <= $tournament->matches; $i++):?>
									<th>Круг <?=$i;?></th>
								<?php endfor;?>
							</tr>
							</thead>
							<tbody>
							<?php foreach($tournament->lines as $ll):?>
								<?php if($ll->id != $line->id):?>
									<tr class="<?=($ll->id == $my_line->id)?'info':'';?>">
										<td>vs</td>
										<td class="">
											<?=html::anchor('tournament/club/'.$ll->id, $ll->club->name);?>
										</td>
										<?php for($i = 1; $i <= $tournament->matches; $i++):?>
											<td>
												<?php ?>
												<?php if(arr::path($played_matches, $ll->id.".count", 0) >= $i):?>
													<span class="play">Сыгран
														(<?=MISC::matches_to_score_line($played_matches[$ll->id][$i], $line->id); ?>)
													</span>
												<?php else:?>
													<span class="not_play">Не сыгран</span>
												<?php endif;?>
											</td>
										<?php endfor;?>
									</tr>
								<?php endif;?>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
	<div class="span3">
		<div class="row-fluid">
			<div>
				<div class="span10">Матчей в туринире</div>
				<div class="span2 bold"><?=$line->games;?></div>
			</div>
			<div>
				<div class="span10">Очков в туринире</div>
				<div class="span2 bold"><?=$line->points;?></div>
			</div>
			<div>
				<div class="span10">Выйграно в туринире</div>
				<div class="span2 bold"><?=$line->win;?></div>
			</div>
			<div>
				<div class="span10">Ничьих в туринире</div>
				<div class="span2 bold"><?=$line->drawn;?></div>
			</div>
			<div>
				<div class="span10">Проигранно в туринире</div>
				<div class="span2 bold"><?=$line->lose;?></div>
			</div>
			<div>
				<div class="span10">Забито в туринире</div>
				<div class="span2 bold"><?=$line->goals;?></div>
			</div>
			<div>
				<div class="span10">Пропущено в туринире</div>
				<div class="span2 bold"><?=$line->passed_goals;?></div>
			</div>

			<div>
				<div class="span8">Текущая форма</div>
				<div class="span4 bold">
					<?php /** @var Jelly_Collection $last_five_matches */ ;?>
					<?= MISC::matches_to_bullet($last_five_matches, $line->id);?>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<?php if(count($goleodors)):?>
				<h4>Бамбардиры команды</h4>
				<table class="table table-condensed">
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
		</div>
	</div>
</div>

<?=HTML::script('templates/ux/js/tournament_club.js');?>