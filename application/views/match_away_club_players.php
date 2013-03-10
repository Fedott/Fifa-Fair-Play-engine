<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php for($i = 0; $i < 7; $i++):?>
	<div class="player_select_away" <?=$i?'style="display:none"':'';?>>
		<?=form::select("goals_a[$i][0]", $players, NULL, array('class' => 'select mini field'));?>
		<?=form::input("goals_a[$i][1]", NULL, array('class' => 'text input-micro field'));?>
	</div>
<?php endfor;?>
<a class="add_goal_select_away">Добавить</a>