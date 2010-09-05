<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="player_select_away">
	<?=form::select('goals_a[0][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[0][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[1][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[1][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[2][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[2][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[3][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[3][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[4][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[4][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[5][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[5][1]', NULL, array('class' => 'text mini field'));?>
</div>
<div class="player_select_away" style="display:none">
	<?=form::select('goals_a[6][0]', $players, NULL, array('class' => 'select mini field'));?>
	<?=form::input('goals_a[6][1]', NULL, array('class' => 'text mini field'));?>
</div>
<a class="add_goal_select_away">Добавить</a>