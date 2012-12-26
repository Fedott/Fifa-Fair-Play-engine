<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<table class="matches" cellpadding="3" cellspacing="1">
	<thead>
	<tr>
		<th>Команда</th>
		<?for($i = 1; $i <= $line->table->matches; $i++):?>
		<th>Круг <?=$i;?></th>
		<?endfor;?>
	</tr>
	</thead>
	<tbody>
	<?text::alternate();?>
	<?foreach($line->table->lines as $ll):?>
		<?if($ll->id != $line->id):?>
		<tr class="<?=text::alternate('nechet', 'chet')?>">
			<td class="">
				<div class="club_info_in_profile">
					<?=html::anchor('tournament/club/'.$ll->id, $ll->club->name);?>
					<?=html::image('templates/fifa/img/profile_info.png', array('class' => 'popup_profile_trigger'));?>
					<div class="popup_profile">
						<strong><?=$ll->club->name;?></strong>
						<br>
						<?if($ll->user->loaded()):?>
						<?=__("Тренер: ").$ll->user->username;?>
						<br>
						<?=$ll->user->get_im("<br/>");?>
						<?else:?>
						У команды нет тренера
						<?endif;?>
					</div>
				</div>
			</td>
			<?for($i = 1; $i <= $line->table->matches; $i++):?>
			<td>
				<?if(arr::path($played_matches, $ll->id.".count", 0) >= $i):?>
					<p class="play">Сыгран (<?php
						if (($played_matches[$ll->id][$i]->home->id == $line->id AND $played_matches[$ll->id][$i]->home_goals > $played_matches[$ll->id][$i]->away_goals) OR ($played_matches[$ll->id][$i]->home->id != $line->id AND $played_matches[$ll->id][$i]->home_goals < $played_matches[$ll->id][$i]->away_goals))
						{
							echo "<font class='green'>".$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals."</font>";
						}
						else
						{
							echo "<font class='red'>".$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals."</font>";
						}
						?>)
					</p>
				<?else:?>
					<p class="not_play"><?=html::anchor('admin/tournament/line_new_tech_lose/'.$line->id.'/'.$ll->id, 'Тех поражение');?></p>
				<?endif;?>
			</td>
			<?endfor;?>
		</tr>
			<?endif;?>
		<?endforeach;?>
	</tbody>
</table>