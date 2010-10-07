<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?if($user->loaded()):?>
	<h2 class="login"><?=$user->username;?> <?=($my_profile)?(html::anchor('main/profile_edit', __("Редактированить"))):"";?></h2>
	<div class="avatar">
		<?=HTML::image($user->get_avatar());?>
	</div>
	<?if($user->first_name):?>
		<p>Имя: <?=$user->first_name;?></p>
	<?endif;?>
	<?if($user->last_name):?>
		<p>Фамилия: <?=$user->last_name;?></p>
	<?endif;?>

	<?if($coach):?>
		<?if(count($coach['lines'])):?>
			<p><b>Тренер команд:</b></p>
			<ul class="user_clubs">
				<?foreach($coach['lines'] as $line):?>
					<li>
						<?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?>
						(<?=HTML::anchor('tournament/view/'.$line->table->id, $line->table->name);?>)
					</li>
				<?endforeach;?>
			</ul>
		<?endif;?>
	<?endif;?>
<?else:?>
	Такого пользователя не существует.
<?endif;?>