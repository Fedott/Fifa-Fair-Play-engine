<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Редактирование профиля</h2>
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
<?=form::open(NULL, array('enctype' => 'multipart/form-data'));?>
<ul>
	<li class="">
		<label class="desc" for="field-first_name">
			Имя
		</label>
		<div>
			<?=$user->input('first_name');?>
			<label for="field-first_name">До <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-last_name">
			Фамилия
		</label>
		<div>
			<?=$user->input('last_name');?>
			<label for="field-last_name">До <b>30</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-icq">
			ICQ
<!--			<span class="req">*</span>-->
		</label>
		<div>
			<?=$user->input('icq');?>
			<label for="field-icq">Только цифры</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-skype">
			Skype
<!--			<span class="req">*</span>-->
		</label>
		<div>
			<?=$user->input('skype');?>
			<label for="field-skype">Только буквы литинского алфавита и цифры</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-origin">
			Логин Origin
			<span class="req">*</span>
		</label>
		<div>
			<?=$user->input('origin');?>
			<label for="field-origin">Логин origin, который так же является ником в Fifa</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="field-avatar">
			Аватар
		</label>
		<div>
			<div class="avatar">
				<?=html::image($user->get_avatar());?>
			</div>
			<?=$user->input('avatar');?>
			<label for="field-avatar" class="avatar">
				Не больше <b>500 Кб</b>
				<br/>
				При необходимости будет автоматически уменьшен до <b>100px</b> в ширину
			</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="password">
			Пароль
		</label>
		<div>
			<input class="field text medium" type="password" name="password" id="password">
			<label for="password">От <b>6</b> до <b>20</b> символов</label>
		</div>
	</li>
	<li class="">
		<label class="desc" for="password_confirm">
			Подтверждение пароля
		</label>
		<div>
			<input class="field text medium" type="password" name="password_confirm" id="password">
		</div>
	</li>
	<li>
		<input type="submit" class="submit" value="Сохранить изменения">
	</li>
</ul>
<?=form::close();?>
