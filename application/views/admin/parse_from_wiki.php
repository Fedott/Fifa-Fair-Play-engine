<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2>Добавление игроков в команду: <span style="color:red;"><?=$club->name?></span></h2>
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
<?if($allow):?>
<div class="allow">
	<p class="allow">Успешно добавлены</p>
	<ul>
		<?foreach($allow as $ok):?>
		<li>
			<?=$ok?>
		</li>
		<?endforeach;?>
</ul>
</div>
<?endif;?>
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