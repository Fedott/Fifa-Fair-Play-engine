<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="page-header">
	<h2>Мои матчи</h2>
</div>

<div class="row-fluid">
	<div class="span6">
		<?if(count($uncmatches)):?>
			<table class="table table-hover">
				<caption>
					<h3>Не подтверждённые мной</h3>
				</caption>
				<thead>
				<tr>
					<th>Дата</th>
					<th></th>
					<th class="center">Счёт</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($uncmatches as $match):?>
					<tr>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=$match->home->club->name;?></td>
						<td class="center">
							<?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?>
						</td>
						<td><?=$match->away->club->name;?></td>
						<td>
							<?=html::anchor('match/confirm/'.$match->id, 'Подтвердить');?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?endif;?>
		<?if(count($uncymatches)):?>
			<table class="table table-hover">
				<caption>
					<h3>Не подтверждённые соперником</h3>
				</caption>
				<thead>
				<tr>
					<th>Дата</th>
					<th></th>
					<th class="center">Счёт</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($uncymatches as $match):?>
					<tr>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=$match->home->club->name;?></td>
						<td class="center">
							<?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?>
						</td>
						<td><?=$match->away->club->name;?></td>
						<td/>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?endif;?>
	</div>
	<div class="span6">
		<?if(count($matches)):?>
			<table class="table table-hover table-condensed">
				<caption>
					<h3>Подтверждённые матчи</h3>
				</caption>
				<thead>
				<tr>
					<th>Дата</th>
					<th></th>
					<th class="center">Счёт</th>
					<th></th>
					<th>Статус</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($matches as $match):?>
					<tr>
						<td><?=MISC::get_human_short_date($match->date);?></td>
						<td class="right"><?=$match->home->club->name;?></td>
						<td class="center">
							<?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?>
						</td>
						<td><?=$match->away->club->name;?></td>
						<td>
							<?php if($match->confirm):?>
								<i class="icon-ok" title="Подтверждён"></i>
							<?php else:?>
								<i class="icon-remove" title="Не подтверждён"></i>
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?endif;?>
	</div>
</div>