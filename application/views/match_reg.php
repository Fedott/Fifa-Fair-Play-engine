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
		<label class="desc" for="away_id">
			Соперник
			<span class="req">*</span>
		</label>
		<div>
			<?=form::dropdown(array('name' => 'away_id', 'class' => 'select medium field'), $teams, $form['away_id'])?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="last_name">
			Счёт
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" style="width:23.5%" type="text" name="home_goals" id="home_goals" value="<?=$form['home_goals']?>">
			:
			<input class="field text medium" style="width:23.5%" type="text" name="away_goals" id="away_goals" value="<?=$form['away_goals']?>">
		</div>
	</li>
	<li>
		<div class="form_left">
			<label class="desc">
				У вас забили
			</label>
			<div class="player_select_home">
				<?=form::dropdown(array('name' => 'goals_h[0][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[0][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[1][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[1][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[2][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[2][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[3][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[3][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[4][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[4][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[5][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[5][1]', 'class' => 'text mini field'));?>
			</div>
			<div class="player_select_home" style="display:none">
				<?=form::dropdown(array('name' => 'goals_h[6][0]', 'class' => 'select mini field'), $my_team_players);?>
				<?=form::input(array('name' => 'goals_h[6][1]', 'class' => 'text mini field'));?>
			</div>
			<a class="add_goal_select_home">Добавить</a>
		</div>
		<div class="form_right">
			<label class="desc">
				У соперника забили
			</label>
			<div id="away_team_players_goal">
				
			</div>
		</div>
	</li>
	<li>
		<label class="desc" for="comment">
			Комментарий к матчу
		</label>
		<div>
			<?=form::textarea(array('id' => 'comment', 'name' => 'comment', 'class' => 'textarea medium field'), $comment_text);?>
		</div>
	</li>
	<li>
		<input type="hidden" name="home_id" value="<?=$uteam->id;?>">
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>
<script type="text/javascript">
	var tid = $("#away_id").val();
	$.get('/match/get_away_team_players/' + tid, 0, function(data){
		$('#away_team_players_goal').html(data);
	});
</script>