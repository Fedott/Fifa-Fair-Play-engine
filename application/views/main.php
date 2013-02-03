<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="offset2 span8 center">
		<h3><?=$table->name;?></h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<table class="table table-hover table-condensed">
			<tbody>
				<?php foreach($table->lines as $pos => $line):?>
					<?php if($pos >= 10) {break;}?>
					<tr class="<?=($line->id == $my_line->id)?"info":'';?>">
						<td><?=++$pos;?></td>
						<td><?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?></td>
						<td><?=$line->points;?></td>
						<td><?=$line->goals;?> - <?=$line->passed_goals;?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<table class="table table-hover table-condensed">
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
</div>