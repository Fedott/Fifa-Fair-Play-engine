<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="span6">
	<?=form::open();?>
	<fieldset>
		<legend>
			Регистрация матча
		</legend>
		<?php if(count($errors)):?>
			<div class="alert alert-error">
				<?php foreach($errors as $error):?>
					<?=$error;?>
				<?php endforeach;?>
			</div>
		<?php endif;?>
		<label for="away">Соперник *</label>
		<?=form::select('away', $clubs, arr::get($form, 'away'), array('id' => 'away', 'class' => ''))?>
		<div class="row-fluid">
			<div class="span6">
				<label>У вас забили</label>
				<?php for($i = 0; $i < 7; $i++):?>
					<div class="player_select_home" <?=$i?'style="display:none"':'';?>>
						<div class="input-append pull-left">
							<?=form::select("goals_h[$i][0]", array(-1 => 'Игрок') + $my_players, arr::path($form, "goals_h.$i.0"), array('class' => 'input-medium home_players'));?>
						</div>
						<div class="input-prepend">
							<?=form::input("goals_h[$i][1]", arr::path($form, "goals_h.$i.1"), array('class' => 'input-mini', 'placeholder' => 'Кол-во'));?>
						</div>
					</div>
				<?php endfor;?>
				<a class="add_goal_select_home">Добавить</a>
			</div>
			<div class="span6">
				<label>У соперника забили</label>
				<div id="away_club_players_goal">

				</div>
			</div>
		</div>
		<br />
		<?php echo Form::textarea('text', NULL, array(
			'id' => 'comment',
			'class' => 'wysiwyg input-xxlarge',
			'placeholder' => 'Коментарий',
		)); ?>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Зарегистрировать</button>
		</div>
	</fieldset>
	<?=form::close();?>
</div>

<?=html::script('templates/ux/js/reg_match.js');?>