<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2><?=$tournament->name?></h2>
<?=form::open();?>
<ul>
<?foreach ($teams as $team):?>
	<li>
		<?=form::checkbox('teams[]', $team->id);?>
		<?=$team->name?>
	</li>
<?endforeach;?>
</ul>
<?=form::submit('submit', 'Сохранить');?>
<?=form::close();?>