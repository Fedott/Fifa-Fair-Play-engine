<?php defined('SYSPATH') OR die('No direct access allowed.');?>
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
<?=form::open()?>
<ul id="players">
	<li class="">
		<div class="input_left">
			<label class="desc" for="last_name[1]">
				Фамилия
			</label>
			<div>
				<input class="field text lite" type="text" name="last_name[1]" id="last_name[1]">
			</div>
		</div>
		<div class="input_right">
			<label class="desc" for="first_name[1]">
				Имя
			</label>
			<div>
				<input class="field text lite" type="text" name="first_name[1]" id="first_name[1]">
			</div>
		</div>
	</li>
</ul>
<ul>
	<li>
		<input type="button" class="add" value="Добавить ещё игрока" id="add_player_button">
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>