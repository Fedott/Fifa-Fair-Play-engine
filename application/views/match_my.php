<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Ваши матчи</h2>
<?if(count($uncmatches)):?>
	<h3>Не подтверждённые вами матчи</h3>
	<ul>
	<?foreach($uncmatches as $match):?>
		<li><?=html::anchor('match/confirm/'.$match->id, $match->home->club->name." ".$match->home_goals." - ".$match->away_goals." ".$match->away->club->name);?> (<?=$match->table->name;?>)</li>
	<?endforeach;?>
	</ul>
<?endif;?>
<?if(count($uncymatches)):?>
	<h3>Не подтверждённые соперником матчи</h3>
	<ul>
	<?foreach($uncymatches as $match):?>
		<li>
			<?=$match->home->club->name." ".$match->home_goals." - ".$match->away_goals." ".$match->away->club->name;?> (<?=$match->table->name;?>)
			|
			<?=MISC::confirm_link('match/delete/'.$match->id, __("Удалить"), __("Вы уверены что хотите удалить результаты этого матча?"));?>
		</li>
	<?endforeach;?>
	</ul>
<?endif;?>
<?if(count($matches)):?>
	<h3>Подтверждённые матчи</h3>
	<ul>
	<?foreach($matches as $match):?>
		<li><?=html::anchor('match/view/'.$match->id, $match->home->club->name." ".$match->home_goals." - ".$match->away_goals." ".$match->away->club->name);?> (<?=$match->table->name;?>)</li>
	<?endforeach;?>
	</ul>
<?endif;?>
<?if(!count($matches) AND !count($uncmatches) AND !count($uncymatches)):?>
	Вы ещё не сыграли ни одного матча.
<?endif;?>