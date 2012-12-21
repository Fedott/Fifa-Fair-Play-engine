<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Регистрация</h2>
<?if($errors):?>
<div class="errors">
	Вы допустили следующие ошибки:
	<ul>
		<?foreach($errors as $error):?>
		<li>
			<?=$error?>
		</li>
		<?endforeach;?>
</ul>
</div>
<?endif;?>
<?=form::open(Request::$current);?>
<ul>
	<li class="">
		<label class="desc" for="username">
			Логин
		</label>
		<div>
			<input class="field text medium" type="text" name="username" id="username">
		</div>
	</li>
	<li class="">
		<label class="desc" for="password">
			Пароль
		</label>
		<div>
			<input class="field text medium" type="password" name="password" id="password">
		</div>
	</li>
	<li>
		<input type="checkbox" name="remember" value="1" /> Запомнить меня
	</li>
	<li>
		<input type="submit" class="submit" value="Войти">
	</li>
</ul>
<?=Form::close();?>