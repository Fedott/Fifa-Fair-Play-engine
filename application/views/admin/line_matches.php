<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<table class="matches" cellpadding="3" cellspacing="1">
	<thead>
	<tr>
		<th>Команда</th>
		<?php for($i = 1; $i <= $line->table->matches; $i++):?>
		<th>Круг <?=$i;?></th>
		<?php endfor;?>
	</tr>
	</thead>
	<tbody>
	<?text::alternate();?>
	<?php foreach($line->table->lines as $ll):?>
		<?php if($ll->id != $line->id):?>
		<tr class="<?=text::alternate('nechet', 'chet')?>">
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
			<?php for($i = 1; $i <= $line->table->matches; $i++):?>
			<td>
				<?php if(arr::path($played_matches, $ll->id.".count", 0) >= $i):?>
					<?php if($played_matches[$ll->id][$i]->tech):?>
						<p class="tech_match">
							Технический (<?=$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals;?>)
						</p>
					<?php else:?>
						<p class="play">
							Сыгран (<?=$played_matches[$ll->id][$i]->home_goals." - ".$played_matches[$ll->id][$i]->away_goals;?>)
						</p>
					<?php endif;?>
				<?php else:?>
					<p class="not_play"><?=html::anchor('admin/tournament/line_new_tech_lose/'.$line->id.'/'.$ll->id, 'Тех поражение');?></p>
				<?php endif;?>
			</td>
			<?php endfor;?>
		</tr>
			<?php endif;?>
		<?php endforeach;?>
	</tbody>
</table>