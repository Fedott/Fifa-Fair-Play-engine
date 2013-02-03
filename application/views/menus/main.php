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
			</ul>
			<ul class="nav pull-right">
				<?php if($auth->logged_in()):?>
					<li>
						<?=HTML::anchor('profile', $user->username);?>
					</li>
				<?php else:?>
					<li>
						<?=HTML::anchor('login', 'Войти');?>
					</li>
					<li>
						<?=HTML::anchor('logout', 'Зарегистрироваться');?>
					</li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>