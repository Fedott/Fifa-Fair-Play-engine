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
		<label class="desc" for="field-description">
			Описание
		</label>
		<div>
			<?=$trophy->input('description');?>
			<?=form::label('field-name', "От <b>2</b> до <b>30</b> символов");?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-weight">
			Место
		</label>
		<div>
			<?=$trophy->input('weight');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-table">
			Турнир
		</label>
		<div>
			<?=$trophy->input('table');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-image">
			Изображение
		</label>
		<div>
			<?=$trophy->input('image');?>
			<?if(!empty($trophy->image)):?>
				<?=HTML::image("media/trophy/".$trophy->image);?>
			<?endif;?>
		</div>
	</li>
	<li>
		<?=form::submit('submit', 'Сохранить');?>
	</li>
</ul>
<?=form::close();?>