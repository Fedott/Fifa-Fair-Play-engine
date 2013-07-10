<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php if($user->loaded()):?>
	<h2 class="login"><?=$user->username;?> <?=($my_profile)?(html::anchor('main/profile_edit', __("Редактировать"))):"";?></h2>
	<div class="avatar">
		<?=HTML::image($user->get_avatar());?>
	</div>
	<?php if($user->first_name):?>
		<p>Имя: <?=$user->first_name;?></p>
	<?php endif;?>
	<?php if($user->last_name):?>
		<p>Фамилия: <?=$user->last_name;?></p>
	<?php endif;?>

	<p>
		<?=$user->get_im("<br/>");?>
	</p>

	<?php if($coach):?>
		<?php if(count($coach['lines'])):?>
			<p><b>Тренер команд:</b></p>
			<ul class="user_clubs">
				<?php foreach($coach['lines'] as $line):?>
					<li>
						<?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?>
						(<?=HTML::anchor('tournament/view/'.$line->table->id, $line->table->name);?>)
					</li>
				<?php endforeach;?>
			</ul>
		<?php endif;?>
	<?php endif;?>
<?php else:?>
	Такого пользователя не существует.
<?php endif;?>