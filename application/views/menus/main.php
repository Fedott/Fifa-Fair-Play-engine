<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?if($user == NULL):?>
<p>
	<?=html::anchor('login', __('Войдите'))." на сайт"."<br>Или ".html::anchor('reg', 'зарегистрируйтесь');?>
</p>
<?else:?>
	<p>
		<?=$user->username?> <?=html::anchor('logout', 'Выйти', array('class' => 'logout'));?>
	</p>
	<p>
		<?=html::anchor('main/profile', 'Профиль');?>
	</p>
<?endif;?>
	<ul class="vmenu">
		<li><?=html::anchor('news', __("Новости"));?></li>
		<li><?=html::anchor('forum', __("Форум"));?></li>
		<?if($auth->logged_in('coach')):?>
			<li>
				<?=html::anchor('match/my', 'Мои матчи');?>
				<?if($matches_not_apply_my):?>
					<?=HTML::image('templates/fifa/img/light.png', array('title' => __("Есть не подтверждённые вами матчи")));?>
				<?elseif($matches_not_apply_opponent):?>
					<?=HTML::image('templates/fifa/img/not_light.png', array('title' => __("Есть не подтверждённые соперником матчи")));?>
				<?endif;?>
			</li>
		<?endif;?>
		<li><?=html::anchor('match/list', 'Все матчи');?></li>
		<li><?=html::anchor('tournament', "Турниры");?></li>
	</ul>
<?if($auth->logged_in('admin')):?>
	<ul class="vmenu">
		<li class="vmenu_title">
			Меню администратора
		</li>
		<li><?=html::anchor('admin', 'Админка');?></li>
		<li><?=html::anchor('admin/club', 'Управление командами');?></li>
		<li><?=html::anchor('admin/player', "Управление игроками");?></li>
		<li><?=html::anchor('admin/tournament', "Управление турнирами");?></li>
		<li><?=html::anchor('admin/news/edit', "Добавить новость");?></li>
	</ul>
<?endif;?>
<?if($coach_menu):?>
	<?=$coach_menu;?>
<?endif;?>