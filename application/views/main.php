<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3 right tournament_add_match">
		<?php if($uchastie AND $table->active):?>
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
			<tbody>
				<?php foreach($lines as $pos => $line):?>
					<tr class="<?=($line->id == $my_line->id)?"info":'';?>">
						<td><?=$pos;?></td>
						<td><?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?></td>
						<td><?=$line->points;?></td>
						<td><?=$line->goals;?> - <?=$line->passed_goals;?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th/>
					<th colspan="3"><?=HTML::anchor('tournament/view/'.$table->url, 'Полная таблица', array('class' => 'muted'));?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="span6">
		<table class="table table-hover table-condensed">
			<caption>
				<h4>Матчи</h4>
			</caption>
			<tbody>
				<?php foreach($last_matches as $match):?>
					<tr>
						<?php /** @var $match Model_Match */ ?>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=HTML::anchor("match/view/".$match->id, $match->home->club->name);?></td>
						<td class="center"><?=HTML::anchor("match/view/".$match->id, $match->home_goals." - ".$match->away_goals);?></td>
						<td><?=HTML::anchor("match/view/".$match->id, $match->away->club->name);?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
			<tr>
				<th/>
				<th colspan="3"><?=HTML::anchor('match/list/'.$table->url, 'Все матчи', array('class' => 'muted'));?></th>
			</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
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
						<td><?=HTML::anchor('tournament/club/'.$goleodor['player']->club->id, $goleodor['player']->club->name);?></td>
						<td><?=$goleodor['goals'];?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<div class="span6">

		<?php if(count($my_matches)):?>
			<table class="table table-hover table-condensed">
				<caption>
					<h4>Ваши матчи</h4>
				</caption>
				<?php foreach($my_matches as $match):?>
					<tr class="
						<?=( ! $match->confirm AND $match->away->id() == $my_line->id)?"error":"";?>
						<?=( ! $match->confirm AND $match->home->id() == $my_line->id)?"warning":"";?>
					">
						<?php /** @var $match Model_Match */ ?>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=$match->home->club->name;?></td>
						<td class="center"><?=$match->home_goals." - ".$match->away_goals;?></td>
						<td><?=$match->away->club->name;?></td>
					</tr>
				<?php endforeach;?>
			</table>
		<?php endif;?>
	</div>
</div>