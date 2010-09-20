<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="block">
	<div class="block_border">
		<div class="block_content">
			<ul class="block_header">
				<li>
					<dl>
						<dt class="list_main">
							<?=$forum->name;?>
						</dt>
						<dd class="count_replies">
							<?=__("Ответы");?>
						</dd>
						<dd class="count_views">
							<?=__("Просмотры");?>
						</dd>
						<dd class="last_post">
							<?=__("Последнее сообщение");?>
						</dd>
					</dl>
				</li>
			</ul>
			<ul class="block_body">
				<?foreach($forum->topics as $topic):?>
				<li class="list">
					<dl>
						<dt class="list_main">
							<?=html::anchor('forum/topic/view/'.$topic->id, $topic->title);?>
							<br/>
							<?=__("От :username » :date", array(':username' => $topic->author['username'], ':date' => $topic->date));?>
						</dt>
						<dd class="count_replies">
							<?=$topic->count_posts - 1;?>
						</dd>
						<dd class="count_views">
							<?=$topic->count_views;?>
						</dd>
						<dd class="last_post">
							&nbsp;
						</dd>
					</dl>
				</li>
				<?endforeach;?>
			</ul>
		</div>
	</div>
</div>
<div class="forum_nav">
	<?if($auth->logged_in($forum->role->name) OR $auth->logged_in('admin')):?>
		<?=html::anchor('forum/topic/create/'.$forum->id, __("Новая тема"));?>
	<?endif;?>
</div>