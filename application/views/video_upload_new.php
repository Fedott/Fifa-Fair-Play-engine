<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="span6">
	<?=form::open();?>
	<fieldset>
		<legend>Добавление видео к матчу</legend>
		<?php if(count($errors)):?>
			<div class="alert alert-error">
				<?php foreach($errors as $error):?>
					<?=$error;?>
				<?php endforeach;?>
			</div>
		<?php endif;?>

		<label for="field-title">Название <span class="red">*</span></label>
		<?=$video->input('title');?>
		<span class="help-inline">
			Указать счёт после этого гола.
		</span>
		<span class="help-block">
			<span class="muted">Например после первого гола счёт становится 1-0, а после ответного 1-1 и т.д.</span>
		</span>

		<label for="field-description">Описание</label>
		<?=$video->input('description');?>
		<span class="help-inline">
			Краткий коментарий
		</span>

		<label for="field-video">Видео файл</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
		<input class="field text medium" type="file" name="video" id="field-video">
		<span class="help-inline">
			До <b>100</b> мегабайт
		</span>

		<label for="field-video_url">Ссылка на видео</label>
		<input class="field text medium" type="text" name="video_url" id="video_url">
		<span class="help-block">
			Ссылка на видео с сайта
			<?=html::anchor('http://www.easports.com/fifa/football-club/profile/media/PC/'. $user->origin, 'EA Sports', array('target' => '_blank'));?>
		</span>
		<p class="text-info">
			Добавить видео вы можете загрузив файл с вашего компьютера <strong>или</strong> указав ссылку на видео с сайта EA Sports.
		</p>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Добавить видео</button>
		</div>
	</fieldset>
	<?=form::close();?>
</div>
 