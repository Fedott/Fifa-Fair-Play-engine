<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h3><?=$topic->title;?></h3>
<?foreach($posts as $post):?>
	<div class="post" id="post<?=$post->id;?>">
		<div class="block">
			<div class="block_border">
				<div class="block_content">
					<div class="profile_block">
						<div class="profile">
							<div class="profile_top">
								<p class="profile_author">
									<?=Kohana::debug($post->author);exit;?>
									<?=html::anchor('main/profile/'.$post->author['id'], $post->author['username']);?>
								</p>
							</div>
						<!--
							<p class="profile_rank">

							</p>
						-->
							<div class="profile_details">
								<p>
									<strong><?=__("Сообщений:");?></strong>
									<?=$post->author['posts'];?>
								</p>
								<p>
									<strong><?=__("Матчей:");?></strong>
									<?=$post->author['matches'];?>
								</p>
							</div>
						</div>
					</div> <!-- .profile_block -->
					<div class="post_body">
						<div class="post_content">
							<p class="post_link">
								<?=html::anchor('forum/topic/view/'.$topic->id.'/'.$post->id, "&nbsp;");?>
								<?=$post->date;?>
							</p>
							<h3>
								<?=$post->title;?>
							</h3>
							<div class="content">
								<?=$post->text;?>
							</div>
						</div>
						<ul class="profile_icons">
					<!--		<li class="top_icon">
								<a class="top">
									<span>
										<?=__("Вверх");?>
									</span>
								</a>
							</li>
					-->
						</ul>
						<div class="clear"></div>
					</div>
					<div class="block_footer"></div>
				</div>
			</div>
		</div>
	</div>
<?endforeach;?>