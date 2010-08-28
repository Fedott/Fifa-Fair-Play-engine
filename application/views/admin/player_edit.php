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
		<label class="desc" for="field-last_name">
			Фамилия или прозвище (например Кака)
			<span class="req">*</span>
		</label>
		<div>
			<?=$player->input('last_name');?>
			<label for="field-last_name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-first_name">
			Имя игрока
		</label>
		<div>
			<?=$player->input('first_name');?>
			<label for="field-first_name">Не обязательно если игрок использует прозвище(например Рональдиньо)</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-year_of_birth">
			Год рожденья
		</label>
		<div>
			<?=$player->input('year_of_birth');?>
			<label for="field-year_of_birth">Пример: 1988</label>
		</div>
	</li>
	<li>
		<label class="desc" for="field-club">
			Команда игрока
		</label>
		<div>
			<?=$player->input('club');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>