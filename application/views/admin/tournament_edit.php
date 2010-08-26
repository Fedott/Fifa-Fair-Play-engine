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
		<label class="desc" for="field-name">
			Название
		</label>
		<div>
			<?=$tournament->input('name');?>
			<label for="field-name">От <b>2</b> до <b>30</b> символов</label>
		</div>
	</li>
	<li>
		<label class="desc" for="field-type">
			<?=__('Тип турнира');?>
		</label>
		<div>
			<?=$tournament->input('type');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-active">
			<?=__('Активировать');?>
		</label>
		<div>
			<?=$tournament->input('active');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-visible">
			<?=__('Видимый');?>
		</label>
		<div>
			<?=$tournament->input('visible');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-ended">
			<?=__('Закончен');?>
		</label>
		<div>
			<?=$tournament->input('ended');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>