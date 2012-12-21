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
			<?=$category->input('name');?>
			<label for="field-name">От <b>2</b> до <b>255</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-description">
			Описание
		</label>
		<div>
			<?=$category->input('description');?>
		</div>
	</li>
	<li>
		<?if($category->loaded()):?>
			<input type="submit" class="submit" value="Сохранить изменения">
		<?else:?>
			<input type="submit" class="submit" value="Создать">
		<?endif;?>
	</li>
</ul>
<?=form::close();?>