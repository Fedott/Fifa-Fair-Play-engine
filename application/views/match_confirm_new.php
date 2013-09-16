<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="span6">
	<?=form::open();?>
		<fieldset>
			<legend>
				Подтверждение матча
			</legend>
			<div class="row-fluid">
				<div class="span5 right">
					<h4><?=$match->home->club->name;?></h4>
					<h4><?=$match->home_goals;?></h4>

					<?if(count($home_goals)):?>
						<ul class="unstyled">
							<?foreach($home_goals as $goal):?>
								<?=$goal->player->player_name()." - ".$goal->count?><br>
							<?endforeach;?>
						</ul>
					<?endif;?>
				</div>
				<div class="span2 center">
					<h4>-</h4>
				</div>
				<div class="span5">
					<h4><?=$match->away->club->name;?></h4>
					<h4><?=$match->away_goals;?></h4>

					<?if(count($away_goals)):?>
						<ul class="unstyled">
							<?foreach($away_goals as $goal):?>
								<?=$goal->count." - ".$goal->player->player_name()?><br>
							<?endforeach;?>
						</ul>
					<?endif;?>
				</div>
			</div>
			<?php echo Form::textarea('text', NULL, array(
				'id' => 'comment',
				'class' => 'wysiwyg input-xxlarge',
				'placeholder' => 'Коментарий',
			)); ?>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Подтвердить</button>
			</div>
		</fieldset>
	<?=form::close();?>
</div>
