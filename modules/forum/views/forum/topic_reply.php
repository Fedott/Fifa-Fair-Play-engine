<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2><?=__("Ответить");?></h2>
<?=form::open(Request::$current);?>
<ul>
	<li>
		<?=form::label('field-title', __("Заголовок"), array('class' => 'desc'));?>
		<div>
			<?=$post->input('title');?>
		</div>
	</li>
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