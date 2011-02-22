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
<?=form::open();?>
<ul>
	<li class="">
		<label class="desc" for="username">
			Логин
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="text" name="username" id="username" value="<?=$form['username']?>">
			<label for="username">От <b>4</b> до <b>20</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="password">
			Пароль
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="password" name="password" id="password">
			<label for="password">От <b>6</b> до <b>20</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="password_confirm">
			Подтверждение пароля
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="password" name="password_confirm" id="password_confirm">
			<label for="password_confirm">От <b>6</b> до <b>20</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="email">
			E-mail
			<span class="req">*</span>
		</label>
		<div>
			<input class="field text medium" type="text" name="email" id="email" value="<?=$form['email']?>">
		</div>
	</li>
	<li class="">
		<label class="desc" for="icq">
			ICQ
<!--			<span class="req">*</span>-->
		</label>
		<div>
			<input class="field text medium" type="text" name="icq" id="icq" maxlength="12" value="<?=$form['icq']?>">
			<label for="icq">Только цифры</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="skype">
			Skype
<!--			<span class="req">*</span>-->
		</label>
		<div>
			<input class="field text medium" type="text" name="skype" id="icq" maxlength="12" value="<?=$form['skype']?>">
			<label for="skype">Только буквы литинского алфавита и цифры</label>
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Зарегистрироваться">
	</li>
</ul>
<?=form::close();?>
