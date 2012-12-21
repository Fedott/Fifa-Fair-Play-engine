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
<?=form::open(Request::$current);?>
<ul>
	<li class="">
		<label class="desc" for="field-name">
			Название
		</label>
		<div>
			<?=$forum->input('name');?>
			<label for="field-name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-weight">
			Вес
		</label>
		<div>
			<?=$forum->input('weight');?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-role">
			Роль для доступа
		</label>
		<div>
			<?=$forum->input('role');?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-section">
			Раздел
		</label>
		<div>
			<?=$forum->input('section');?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-description">
			Описание
		</label>
		<div>
			<?=$forum->input('description');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>