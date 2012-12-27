<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
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
<h2>Назначение технического поражения</h2>
<p>
	Засчиать техническое поражение со счётом 0-3 команде, <strong><?=$home->club->name;?></strong>, в пользу команды <strong><?=$away->club->name;?></strong>
</p>
<?=form::open();?>
<ul>
	<li>
		<label class="desc" for="comment">
			Причина технического поражения
		</label>
		<div>
			<?=$comment->input('text');?>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Засчитать техническое поражение">
	</li>
</ul>
<?=form::close();?>