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
<?=form::open()?>
<ul>
	<li class="">
		<label class="desc" for="last_name">
			Фамилия или прозвище (например Кака)
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="text" name="last_name" id="last_name" value="<?=$form['last_name']?>">
			<label for="last_name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="first_name">
			Имя игрока
		</label>
		<div>
			<input class="field text medium" type="text" name="first_name" id="first_name" value="<?=$form['first_name']?>">
			<label for="first_name">Не обязательно если игрок использует прозвище(например Рональдиньо)</label>
		</div>
	</li>
	<li>
		<label class="desc" for="team_id">
			Команда игрока
		</label>
		<div>
			<?=form::dropdown(array('name' => 'team_id', 'class' => 'select medium field'), $teams, $form['team_id'])?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>