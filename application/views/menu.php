<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?if($user == NULL):?>
<p>
	<?=html::anchor('login', 'Войдите')." на сайт"."<br>Или ".html::anchor('reg', 'зарегистрируйтесь');?>
</p>
<?else:?>
	<p>
		<?=$user->username?> <?=html::anchor('logout', 'Выйти', array('class' => 'logout'));?>
	</p>
	<p>
		<?=html::anchor('user/profile', 'Профиль');?>
	</p>
<?endif;?>
	<ul class="vmenu">
		<li><?=html::anchor('forum', 'Форум');?></li>
		<?if($auth->logged_in('coach')):?><li><?=html::anchor('match/my', 'Мои матчи');?></li><?endif;?>
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