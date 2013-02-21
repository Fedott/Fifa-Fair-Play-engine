<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1>Расписание турнира: <?=$table->name;?></h1>
<table class="table">
	<?php foreach($table->planned_matches as $match):?>
		<?php /** @var $match Model_Planned_Match */ ;?>
		<tr class="<?=($match->home->id == $my_line->id OR $match->away->id == $my_line->id)?"my_team":"";?>">
			<td><?=$match->home->club->name;?></td>
			<td>vs</td>
			<td><?=$match->away->club->name;?></td>
			<td>
				<?=($match->match->id())?HTML::anchor('match/view/'.$match->match->id(), 'Сыгран'):"Не сыгран";?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
