<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1>Расписание турнира, <?=UTF8::strtolower($table->name);?></h1>
<table class="table">
	<?php foreach($rounds as $round => $matches):?>
		<tr>
			<th colspan="5">
				<?=$round;?> тур
			</th>
		</tr>
		<?php foreach($matches as $match):?>
			<?php /** @var $match Model_Planned_Match */ ;?>
			<tr class="<?=text::alternate('chet', 'nechet');?> <?=($match->home->id == $my_line->id OR $match->away->id == $my_line->id)?"my_team":"";?>">
				<td><?=$match->home->club->name;?></td>
				<td>vs</td>
				<td><?=$match->away->club->name;?></td>
				<td>
					<?=($match->match->id())?HTML::anchor('match/view/'.$match->match->id(), 'Сыгран'):"Не сыгран";?>
				</td>
                <?php if($auth->logged_in('admin') AND ! $match->availible):?>
                    <td>
                        <?=HTML::anchor('admin/tournament/active_match/'.$table->id.'/'.$match->id, 'Активировать');?>
                    </td>
                <?php endif;?>
			</tr>
		<?php endforeach;?>
	<?php endforeach;?>
</table>
