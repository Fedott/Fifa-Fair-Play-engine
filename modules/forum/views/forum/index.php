<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?foreach($sections as $section):?>
<div class="space">&nbsp;</div>
<div class="section">
	<ul class="section_header">
		<li>
			<dl>
				<dt class="forum_main">
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
	<ul class="section_body">
		<?foreach($section->forums as $forum):?>
		<li class="forum">
			<dl>
				<dt class="forum_main">
					<?=$forum->name;?>
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
<?endforeach;?>