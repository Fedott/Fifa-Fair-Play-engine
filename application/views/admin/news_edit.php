<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?=form::open();?>
<ul>
	<li>
		<?=form::label('field-title', 'Заголовок', array('class' => 'desc'));?>
		<div>
			<?=$news->input('title');?>
		</div>
	</li>
	<li>
		<label class="desc" for="field-text">
			<?=__("Текст новости");?>
		</label>
		<div>
			<?=$news->input('text');?>
		</div>
	</li>
	<li>
		<?=form::submit('', __('Сохранить'));?>
	</li>
</ul>
<?=form::close();?>