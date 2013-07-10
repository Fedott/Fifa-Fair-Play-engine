<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2>Добавление игроков в команду: <span style="color:red;"><?=$club->name?></span></h2>
<?php if($errors):?>
<div class="errors">
	<p class="errors">Произошла ошибка</p>
	<ul>
		<?php foreach($errors as $error):?>
		<li>
			<?=$error?>
		</li>
		<?php endforeach;?>
</ul>
</div>
<?php endif;?>
<?php if($allow):?>
<div class="allow">
	<p class="allow">Успешно добавлены</p>
	<ul>
		<?php foreach($allow as $ok):?>
		<li>
			<?=$ok?>
		</li>
		<?php endforeach;?>
</ul>
</div>
<?php endif;?>
<?=form::open();?>
	<ul class="">
		<li>
			<?=form::textarea('tables', NULL, array('class' => 'textarea field max'));?>
		</li>
		<li>
			<?=Form::submit("sub", "Спарсить игроков");?>
		</li>
	</ul>
<?=form::close();?>