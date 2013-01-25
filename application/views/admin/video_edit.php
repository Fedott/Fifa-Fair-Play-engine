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
<?=form::open(NULL, array('enctype' => 'multipart/form-data'));?>
	<ul>
		<li class="">
			<label class="desc" for="field-name">
				Название
			</label>
			<div>
				<?=$video->input('title');?>
				<label for="field-name">От <b>4</b> до <b>255</b> символов</label>
			</div>
		</li>
		<li class="">
			<label class="desc" for="field-logo">
				Описание
			</label>
			<div>
				<?=$video->input('description');?>
				<label for="field-name">До <b>255</b> символов</label>
			</div>
		</li>
		<li class="">
			<label class="desc" for="field-logo">
				Матч
			</label>
			<div>
				<?//=$video->input('match');?>
			</div>
		</li>
		<li>
			<input type="submit" class="submit" value="Сохранить изменения">
		</li>
	</ul>
<?=form::close();?>