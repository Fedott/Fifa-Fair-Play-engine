<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?if($tourn->loaded()):?>
<h2>Матчи турнира "<?=$tourn->name;?>"</h2>
<?else:?>
<h2>Все матчи</h2>
<?endif;?>
<?if($pagination->total_items):?>
	<table class="matches" cellpadding="3" cellspacing="1">
		<thead>
			<tr>
				<th>Домашняя команда</th>
				<th>Счёт</th>
				<th>Гостевая команды</th>
			<?if(!$tourn->loaded()):?>
				<th>Турнир</th>
			<?endif;?>
				<th>Дата</th>
			</tr>
		</thead>
		<tbody>
		<?foreach($matches as $match):?>
			<tr class="<?=text::alternate('nechet', 'chet');?> <?=($user AND ($match->away->user->id == $user->id OR $match->home->user->id == $user->id))?'my_team':'';?>">
				<td><?=html::anchor('tournament/club/'.$match->home->id, $match->home->club->name);?></td>
				<td><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
				<td><?=html::anchor('tournament/club/'.$match->away->id, $match->away->club->name);?></td>
			<?if(!$tourn->loaded()):?>
				<td><?=html::anchor('tournament/view/'.$match->table->url, $match->table->name);?></td>
			<?endif;?>
				<td><?=MISC::get_human_date($match->date);?></td>
			</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<?=$pagination;?>
<?else:?>
<p>
	Ещё не сыграно ни одного матча
</p>
<?endif;?>
