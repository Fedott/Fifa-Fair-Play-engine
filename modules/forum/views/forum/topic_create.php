<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2><?=__("Новая тема");?></h2>
<?=form::open(Request::$current);?>
<ul>
	<li>
		<?=form::label('field-title', __("Заголовок"), array('class' => 'desc'));?>
		<div>
			<?=$topic->input('title');?>
		</div>
	</li>
<!--	<li>
		<?=form::label('field-description', __("Краткое описание"), array('class' => 'desc'));?>
		<div>
			<?=$topic->input('description');?>
		</div>
	</li>
-->
	<li>
		<?=form::label('field-text', __("Текст"), array('class' => 'desc'));?>
		<div>
			<?=$post->input('text');?>
		</div>
	</li>
	<li>
		<?=form::submit(NULL, __("Создать"));?>
	</li>
</ul>
<?=form::close();?>