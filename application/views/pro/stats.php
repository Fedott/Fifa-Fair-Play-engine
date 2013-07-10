<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<table cellspacing="1" cellpading="3">
	<thead>
		<tr>
			<th>Ник</th>
			<th>Матчей</th>
			<th></th>
			<th>Голов</th>
			<th></th>
			<th>ГП</th>
			<th></th>
			<th>% УС</th>
			<th></th>
			<th>% ТП</th>
			<th></th>
			<th>% УО</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($end_values as $pro_player):?>
			<tr class="<?=text::alternate('nechet', 'chet');?>">
				<td><?=$pro_player->nick;?></td>
				<td>
					<?=$pro_player->games;?>
				</td>
				<td>
					(<?=$pro_player->games - arr::path($start_values, $pro_player->nick.".games", 0);?>)
				</td>
				<td>
					<?=$pro_player->goals;?>
				</td>
				<td>
					(<?=$pro_player->goals - arr::path($start_values, $pro_player->nick.".goals", 0);?>)
				</td>
				<td>
					<?=$pro_player->assists;?>
				</td>
				<td>
					(<?=$pro_player->assists - arr::path($start_values, $pro_player->nick.".assists", 0);?>)
				</td>
				<td>
					<?=$pro_player->shots;?>
				</td>
				<td>
					(<?=$pro_player->shots - arr::path($start_values, $pro_player->nick.".shots", 0);?>)
				</td>
				<td>
					<?=$pro_player->passes;?>
				</td>
				<td>
					(<?=$pro_player->passes - arr::path($start_values, $pro_player->nick.".passes", 0);?>)
				</td>
				<td>
					<?=$pro_player->tackles;?>
				</td>
				<td>
					(<?=$pro_player->tackles - arr::path($start_values, $pro_player->nick.".tackles", 0);?>)
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>