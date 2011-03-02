<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?if($errors):?>
<div class="errors">
	<p class="errors">Произошла ошибка</p>
	<ul>
		<?foreach($errors as $error):?>
		<li>
			<?=$error?>
		</li>
		<?endforeach;?>
</ul>
</div>
<?endif;?>
<h2>Регистрация матча</h2>
<?=form::open();?>
<ul>
	<li>
		<label class="desc" for="away">
			Соперник
			<span class="req">*</span>
		</label>
		<div>
			<?=form::select('away', $clubs, $match->away->id, array('id' => 'away', 'class' => 'select medium field'))?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="last_name">
			Счёт
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" style="width:23.5%" type="text" name="home_goals" id="home_goals" value="<?=$match->home_goals;?>">
			:
			<input class="field text medium" style="width:23.5%" type="text" name="away_goals" id="away_goals" value="<?=$match->away_goals;?>">
		</div>
	</li>
	<li>
		<div class="form_left">
			<label class="desc">
				У вас забили
			</label>
			<div class="player_select_home">
				<?=form::select('goals_h[0][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[0][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[1][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[1][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[2][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[2][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[3][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[3][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[4][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[4][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[5][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[5][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::select('goals_h[6][0]', $my_players, NULL, array('class' => 'select mini field'));?>
				<?=form::input('goals_h[6][1]', NULL, array('class' => 'text mini field'));?>
			</div>
			<a class="add_goal_select_home">Добавить</a>
		</div>
		<div class="form_right">
			<label class="desc">
				У соперника забили
			</label>
			<div id="away_club_players_goal">
				
			</div>
		</div>
	</li>
	<li>
		<label class="desc" for="comment">
			Комментарий к матчу
		</label>
		<div>
			<?=$comment->input('text');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения" id="match_register">
	</li>
</ul>
<?=form::close();?>
<script type="text/javascript">
	var tid = $("#away").val();
	$.get('<?=url::site('match/get_away_club_players');?>/' + tid, 0, function(data){
		$('#away_club_players_goal').html(data);
	});
</script>