<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2><?=$tournament->name?></h2>
<?=Form::open(Request::$current);?>
<ul>
<?foreach ($clubs as $club):?>
	<li>
		<?=Form::checkbox('clubs[]', $club->id, FALSE, array('id' => 'club_'.$club->id));?>
		<?=Form::label('club_'.$club->id, $club->name);?>
	</li>
<?endforeach;?>
</ul>
<?=Form::submit('submit', 'Сохранить');?>
<?=Form::close();?>