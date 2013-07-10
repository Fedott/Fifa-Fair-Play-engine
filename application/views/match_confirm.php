<?php defined('SYSPATH') OR die('No direct access allowed.');?>
Вы подтверждаете результат матча:<br>
<?=$match->home->club->name." ".$match->home_goals." - ".$match->away_goals." ".$match->away->club->name;?><br>
<?php if(count($home_goals)):?>
	Голы хозяев:<br>
	<?php foreach($home_goals as $goal):?>
		<?=$goal->player->player_name()." - ".$goal->count?><br>
	<?php endforeach;?>
<?php endif;?>
<?php if(count($away_goals)):?>
	Голы гостей:<br>
	<?php foreach($away_goals as $goal):?>
		<?=$goal->player->player_name()." - ".$goal->count?><br>
	<?php endforeach;?>
<?php endif;?>
<br>
<?=form::open(NULL, array('id' => 'confirm_form'));?>
<ul>
	<li>
		<label class="desc" for="comment">
			Комментарий к матчу
		</label>
		<div>
			<?=$comment->input('text');?>
		</div>
	</li>
	<li>
		<?=form::hidden('confirm', 1);?>
		<input type="submit" class="submit match_confirm" value="Подтвердить результат">
		| <?=html::anchor('match/my', 'Нет');?>
	</li>
</ul>
<?=form::close();?>