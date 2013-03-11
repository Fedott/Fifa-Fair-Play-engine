<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php for($i = 0; $i < 7; $i++):?>
	<div class="player_select_away" <?=$i?'style="display:none"':'';?>>
		<div class="input-append pull-left">
			<?=form::select("goals_a[$i][0]", array(NULL => 'Игрок') + $players, NULL, array('class' => 'input-medium away_players'));?>
		</div>
		<div class="input-prepend">
			<?=form::input("goals_a[$i][1]", NULL, array('class' => 'input-mini', 'placeholder' => 'Кол-во'));?>
		</div>
	</div>
<?php endfor;?>
<a class="add_goal_select_away">Добавить</a>