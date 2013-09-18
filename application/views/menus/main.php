<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="navbar navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="<?=URL::base();?>">Красивый Футбол</a>
			<ul class="nav">
				<li>
					<?=HTML::anchor('news', 'Новости');?>
				</li>
				<li>
					<?=HTML::anchor('match', 'Матчи');?>
				</li>
				<li>
					<?=HTML::anchor('tournament', 'Турниры');?>
				</li>
				<li>
					<?=HTML::anchor('forum', 'Форум');?>
				</li>
				<?php if($auth->logged_in("admin")):?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Администрирование
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><?=HTML::anchor('admin/club', 'Клубы');?></li>
							<li><?=HTML::anchor('admin/player', 'Игроки');?></li>
							<li><?=HTML::anchor('admin/tournament', 'Турниры');?></li>
							<li><?=HTML::anchor('admin/page', 'Страницы');?></li>
							<li><?=HTML::anchor('admin/news', 'Новости');?></li>
							<li><?=HTML::anchor('admin/user', 'Пользователи');?></li>
						</ul>
					</li>
				<?php endif;?>
			</ul>
			<ul class="nav pull-right">
				<?php if($auth->logged_in()):?>
					<?php if($auth->logged_in('coach')):?>
						<li>
							<?=HTML::anchor('match/my', 'Мои матчи');?>
						</li>
					<?php endif;?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?=$user->username;?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><?=HTML::anchor('profile', 'Профиль');?></li>
							<li><?=HTML::anchor('logout', 'Выйти');?></li>
						</ul>
					</li>
				<?php else:?>
					<li>
						<?=HTML::anchor('login', 'Войти');?>
					</li>
					<li>
						<?=HTML::anchor('reg', 'Зарегистрироваться');?>
					</li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>