<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php if($errors):?>
<div class="errors">
	<p class="errors">Произошла ошибка</p>
	<ul>
		<?php foreach($errors as $error):?>
		<li>
			<?=$error?>
		</li>
		<?php endforeach;?>
</ul>
</div>
<?php endif;?>
<h2>Регистрация матча</h2>
<?=form::open();?>
<fieldset>
	<label class="desc" for="away">
		Соперник
		<span class="req">*</span>
	</label>
	<div>
		<?=form::select('away', $clubs, $match->away->id, array('id' => 'away', 'class' => 'select medium field'))?>
	</div>
	<label class="desc" for="last_name">
		Счёт
		<span class="req">*</span>
	</label>
	<div>
		<input class="field text medium" style="width:23.5%" type="text" name="home_goals" id="home_goals" value="<?=$match->home_goals;?>">
		:
		<input class="field text medium" style="width:23.5%" type="text" name="away_goals" id="away_goals" value="<?=$match->away_goals;?>">
	</div>
	<div class="row-fluid">
		<div class="offset2 span4">
			<label class="desc">
				У вас забили
			</label>
			<?php for($i = 0; $i < 7; $i++):?>
				<div class="player_select_home" <?=$i?'style="display:none"':'';?>>
					<?=form::select("goals_h[$i][0]", $my_players, NULL, array('class' => 'select mini field'));?>
					<?=form::input("goals_h[$i][1]", NULL, array('class' => 'text input-micro field'));?>
				</div>
			<?php endfor;?>
			<a class="add_goal_select_home">Добавить</a>
		</div>
		<div class="span4">
			<label class="desc">
				У соперника забили
			</label>
			<div id="away_club_players_goal">

			</div>
		</div>
	</div>
	<label class="desc" for="comment">
		Комментарий к матчу
	</label>
	<div>
		<?=$comment->input('text');?>
	</div>
	<input type="submit" class="submit btn" value="Зарегистрировать" id="match_register">
</fieldset>
<?=form::close();?>
<script type="text/javascript">
	var tid = $("#away").val();
	$.get('<?=url::site('match/get_away_club_players');?>/' + tid, 0, function(data){
		$('#away_club_players_goal').html(data);
	});
</script>