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
<?=Form::open(NULL, array('enctype' => 'multipart/form-data'));?>
<ul>
	<li class="">
		<label class="desc" for="title">
			Название
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="text" name="title" id="title" value="<?=$form['title']?>">
			<label for="title">От <b>4</b> до <b>255</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="description">
			Описание
		</label>
		<div>
			<input class="field text medium" type="text" name="description" id="description" value="<?=$form['description']?>">
			<label for="description">До <b>255</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="video">
			Видео файл
		</label>
		<div>
			<input class="field text medium" type="file" name="video" id="video">
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Загрузить">
	</li>
</ul>
<?=Form::close();?>