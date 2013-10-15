<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h3>Расписание турнира, <?=UTF8::strtolower($table->name);?></h3>
<div class="span6">
	<table class="table table-hover table-condensed">
		<?php foreach($rounds as $round => $matches):?>
			<tr>
				<th colspan="5" class="center progress-striped">
					<?=$round;?> тур
				</th>
			</tr>
			<?php foreach($matches as $match):?>
				<?php /** @var $match Model_Planned_Match */ ;?>
				<tr class="<?=($match->home->id == $my_line->id OR $match->away->id == $my_line->id)?"info":"";?>">
					<td class="right">
						<?=$match->home->club->name;?>
					</td>
					<td class="center">vs</td>
					<td><?=$match->away->club->name;?></td>
					<td>
						<?=($match->match->id())?HTML::anchor('match/view/'.$match->match->id(), 'Сыгран'):"Не сыгран";?>
					</td>
	                <td>
	                    <?php if($auth->logged_in('admin') AND ! $match->available):?>
	                        <?=HTML::anchor('admin/tournament/active_match/'.$match->id, 'Активировать');?>
	                    <?php endif;?>
	                    <?php if($auth->logged_in('admin') AND $match->available AND ! $match->played):?>
		                    <?=HTML::anchor('admin/tournament/deactivate_match/'.$match->id, 'Деативировать');?>
	                    <?php endif;?>
	                </td>
				</tr>
			<?php endforeach;?>
		<?php endforeach;?>
	</table>
</div>
