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
		<label class="desc" for="field-title">
			Название
		</label>
		<div>
			<?=$page->input('title');?>
			<label for="field-title">От <b>2</b> до <b>255</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-text">
			Текст
		</label>
		<div>
			<?=$page->input('text');?>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-category">
			Категория
		</label>
		<div>
			<?=$page->input('category');?>
		</div>
	</li>
	<li>
		<?if($page->loaded()):?>
			<input type="submit" class="submit" value="Сохранить изменения">
		<?else:?>
			<input type="submit" class="submit" value="Создать">
		<?endif;?>
	</li>
</ul>
<?=form::close();?>