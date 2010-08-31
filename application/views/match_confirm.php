<?php defined('SYSPATH') OR die('No direct access allowed.');?>
Вы подтверждаете результат матча:<br>
<?=$match->home->team->name." ".$match->home_goals." - ".$match->away_goals." ".$match->away->team->name;?><br>
<?if(count($home_goals)):?>
Голы хозяев:<br>
<?foreach($home_goals as $goal):?>
<?=$goal->player->name()." - ".$goal->count?><br>
<?endforeach;?>
<?endif;?>
<?if(count($away_goals)):?>
Голы гостей:<br>
<?foreach($away_goals as $goal):?>
<?=$goal->player->name()." - ".$goal->count?><br>
<?endforeach;?>
<?endif;?>
<br>
<?=form::open();?>
<ul>
	<li>
		<label class="desc" for="comment">
			Комментарий к матчу
		</label>
		<div>
			<?=form::textarea(array('id' => 'comment', 'name' => 'comment', 'class' => 'textarea medium field'));?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Подтвердить результат">
		| <?=html::anchor('match', 'Нет');?>
	</li>
</ul>
