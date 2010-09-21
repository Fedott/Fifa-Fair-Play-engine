<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h3><?=$topic->title;?></h3>
<?foreach($posts as $post):?>
	<div class="post" id="post<?=$post->id;?>">
		<div class="block">
			<div class="block_border">
				<div class="block_content">
					<div class="profile_block">
						<div class="postprofile">
							<div class="profile_top">
								<p class="profile_author">
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
								<?=html::anchor('forum/topic/view/'.$topic->id.'?postid='.$post->id.'#post'.$post->id, "&nbsp;");?>
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
<div class="topic_action">
	<div class="pagination">
		<?=$pagination;?>
	</div>
</div>
<div class="reply_form">
	<?=form::open('forum/topic/reply/'.$topic->id);?>
	<ul>
		<li>
			<?=form::label('field-title', __("Заголовок"), array('class' => 'desc'));?>
			<div>
				<?=$postform->input('title');?>
			</div>
		</li>
		<li>
			<?=form::label('field-text', __("Текст"), array('class' => 'desc'));?>
			<div>
				<?=$postform->input('text');?>
			</div>
		</li>
		<li>
			<?=form::submit(NULL, __("Отправить"));?>
		</li>
	</ul>
	<?=form::close();?>
</div>