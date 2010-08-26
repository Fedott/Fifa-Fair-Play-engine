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
		<label class="desc" for="name">
			Название
		</label>
		<div>
			<input class="field text medium" type="text" name="name" id="name" value="<?=$form['name']?>">
			<label for="name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>