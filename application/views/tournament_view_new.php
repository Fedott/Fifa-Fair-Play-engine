<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3 right tournament_add_match">
		<?php if($uchastie AND $table->active AND ! $table->ended):?>
			<?=html::anchor('match/reg/'.$table->id, 'Зарегистрировать матч');?>
		<?php endif;?>
	</div>
	<div class="span6 center">
		<h3><?=HTML::anchor('tournament/view/'.$table->url, $table->name);?></h3>
	</div>
	<?php if($table->scheduled):?>
		<div class="span3 tournament_schedule">
			<?=html::anchor('tournament/schedule/'.$table->id, 'Расписание');?>
		</div>
	<?php endif;?>
</div>
<div class="row-fluid">
	<div class="span6">
		<table class="table table-hover table-condensed">
			<caption>
				<h4>Таблица</h4>
			</caption>
			<thead>
			<tr>
				<th>Пос</th>
				<th>Команда</th>
				<th class="center">И</th>
				<th class="center">З-П</th>
				<th class="center">О</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($table->lines as $pos => $line):?>
					<tr class="<?=($line->id == $my_line->id)?"info":'';?>">
						<td><?=$pos + 1;?></td>
						<td><?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?></td>
						<td class="center"><?=$line->games;?></td>
						<td class="center"><?=$line->goals;?> - <?=$line->passed_goals;?></td>
						<td class="center"><?=$line->points;?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>

		<table class="table table-hover table-condensed">
			<caption>
				<h4>Бомбардиры туринра</h4>
			</caption>
			<tbody>
			<?php $i = 1;?>
			<?php foreach($goleodors as $goleodor):?>
				<tr class="<?=($goleodor['line_id'] == $my_line->id)?'info':'';?>">
					<td><?=$i++;?></td>
					<td><?=$goleodor['player']->player_name(false);?></td>
					<td><?=HTML::anchor('tournament/club/'.$goleodor['line_id'], $goleodor['player']->club->name);?></td>
					<td><?=$goleodor['goals'];?></td>
				</tr>
			<?php endforeach;?>
			<?php if( ! count($goleodors)):?>
				<tr>
					<td colspan="10" class="center">Ни одного мяча ещё не забито</td>
				</tr>
			<?php endif;?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<?php if(count($planned_matches)):?>
			<table class="table table-condensed table-hover">
				<caption>
					<h4>Мои следующие матчи</h4>
				</caption>
				<tbody>
				<?php foreach($planned_matches as $match):?>
					<?php /** @var $match Model_Planned_Match */ ?>
					<tr>
						<td class="right span5"><?=HTML::anchor("/tournament/club/" . $match->home->id(), $club_loader->get_by_line($match->home)->name);?></td>
						<td class="center span1">vs</td>
						<td class="span5"><?=HTML::anchor("/tournament/club/" . $match->away->id(), $club_loader->get_by_line($match->away)->name);?></td>
						<td class="span2"><?=$match->round;?> тур</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php endif;?>

		<table class="table table-hover table-condensed">
			<caption>
				<h4>Матчи</h4>
			</caption>
			<tbody>
				<?php foreach($last_matches as $match):?>
					<tr class="<?=($match->home->id() == $my_line->id || $match->away->id() == $my_line->id)?"info":'';?>">
						<?php /** @var $match Model_Match */ ?>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=HTML::anchor("match/view/".$match->id, $club_loader->get_by_line($match->home)->name);?></td>
						<td class="center"><?=HTML::anchor("match/view/".$match->id, $match->home_goals." - ".$match->away_goals);?></td>
						<td><?=HTML::anchor("match/view/".$match->id, $club_loader->get_by_line($match->away)->name);?></td>
					</tr>
				<?php endforeach;?>
				<?php if( ! count($last_matches)):?>
					<tr>
						<td colspan="10" class="center">Ни одного матча ещё не сыграно</td>
					</tr>
				<?php endif;?>
			</tbody>
			<tfoot>
			<tr>
				<th/>
				<th colspan="3"><?=HTML::anchor('match/list/'.$table->url, 'Все матчи', array('class' => 'muted'));?></th>
			</tr>
			</tfoot>
		</table>

		<?php if(count($my_matches)):?>
			<table class="table table-hover table-condensed">
				<caption>
					<h4>Мои матчи</h4>
				</caption>
				<?php foreach($my_matches as $match):?>
					<tr class="
						<?=( ! $match->confirm AND $match->away->id() == $my_line->id)?"error":"";?>
						<?=( ! $match->confirm AND $match->home->id() == $my_line->id)?"warning":"";?>
					"
						<?=( ! $match->confirm AND $match->away->id() == $my_line->id)?"title='Матч требует вашего подтверждения'":"";?>
						<?=( ! $match->confirm AND $match->home->id() == $my_line->id)?"title='Матч ожидает подтверждения соперником'":"";?>
						>
						<?php /** @var $match Model_Match */ ?>
						<?php $link = ( ! $match->confirm AND $match->away->id() == $my_line->id)?url::site('match/confirm/'.$match->id):url::site('match/view/'.$match->id);?>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=html::anchor($link, $club_loader->get_by_line($match->home)->name);?></td>
						<td class="center"><?=html::anchor($link, $match->home_goals." - ".$match->away_goals);?></td>
						<td><?=html::anchor($link, $club_loader->get_by_line($match->away)->name);?></td>
					</tr>
				<?php endforeach;?>
				<tfoot>
				<tr>
					<th/>
					<th colspan="3"><?=HTML::anchor('match/my', 'Все матчи', array('class' => 'muted'));?></th>
				</tr>
				</tfoot>
			</table>
		<?php endif;?>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">

	</div>
</div>
