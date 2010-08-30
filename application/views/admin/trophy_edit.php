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
		<?=form::label(array('for' => 'field-discription', 'class' => 'desc'), 'Описание');?>
		<div>
			<?=$trophy->input('description');?>
			<?=form::label('name', "От <b>2</b> до <b>30</b> символов");?>
		</div>
	</li>
	<li>
		<?=form::label(array('for' => 'weight', 'class' => 'desc'), 'Место');?>
		<div>
			<?=$trophy->input('weight');?>
		</div>
	</li>
	<li>
		<?=form::label(array('for' => 'table_id', 'class' => 'desc'), 'Турнир');?>
		<div>
			<?=form::dropdown(array('name' => 'table_id', 'class' => 'select medium field'), $tables, $form['table_id'])?>
		</div>
	</li>
	<li>
		<?=form::label(array('for' => 'picture', 'class' => 'desc'), 'Изображение трофея');?>
		<div>
			<?=html::image($trophy->image);?>
		</div>
		<div>
			<?=form::upload('picture');?>
		</div>
	</li>
	<li>
		<?=form::submit('submit', 'Сохранить');?>
	</li>
</ul>
<?=form::close();?>