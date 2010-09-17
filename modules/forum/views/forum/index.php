<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?foreach($sections as $section):?>
<div class="block">
	<div class="block_border">
		<div class="block_content">
			<ul class="block_header">
				<li>
					<dl>
						<dt class="list_main">
							<?=$section->name;?>
						</dt>
						<dd class="count_topics">
							<?=__("Темы");?>
						</dd>
						<dd class="count_posts">
							<?=__("Сообщения");?>
						</dd>
						<dd class="last_post">
							<?=__("Последнее сообщение");?>
						</dd>
					</dl>
				</li>
			</ul>
			<ul class="block_body">
				<?foreach($section->forums as $forum):?>
				<li class="list">
					<dl>
						<dt class="list_main">
							<?=html::anchor('forum/view/'.$forum->id, $forum->name);?>
							<br/>
							<?=$forum->description;?>
						</dt>
						<dd class="count_topics">
							<?=$forum->count_topics;?>
						</dd>
						<dd class="count_posts">
							<?=$forum->count_posts;?>
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
<?endforeach;?>