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
<?=form::open();?>
<ul>
	<li class="">
		<label class="desc" for="field-name">
			Название
		</label>
		<div>
			<?=$section->input('name');?>
			<label for="field-name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-weight">
			Вес
		</label>
		<div>
			<?=$section->input('weight');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>