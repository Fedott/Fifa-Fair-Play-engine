<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php /** @var Model_Match $match */ ?>
<div class="row-fluid" xmlns="http://www.w3.org/1999/html">
	<div class="offset1 span10">

		<div class="row-fluid" style="margin-top: 40px;">
			<div class="span2 center">
				<?=html::image($match->home->club->logo(), array('class' => 'team_logo', 'alt' => $match->home->club->name));?>
			</div>

			<div class="span8">
				<div class="span4">
					<h4 class="team-name">
						<?=HTML::anchor('tournament/club/'.$match->home->id, $match->home->club->name);?>
					</h4>
					<div class="home_goals">
						<?php if($match->home_goals):?>
							<?php foreach ($home_goals as $goal):?>
								<div><?=$goal->player->player_name();?> <?=misc::get_goals_images($goal->count);?></div>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>

				<div class="span4 center">
					<h2>
						<?=$match->home_goals;?>
						:
						<?=$match->away_goals;?>
					</h2>
					<div>
						<div>
							<?=HTML::anchor('tournament/view/'.$match->table->id, $match->table->name);?>
						</div>
						<?php if($match->table->scheduled):?>
							<div><strong><?=$match->planned_match->round;?></strong> круг</div>
						<?php endif;?>
						<div><?=misc::get_human_date($match->date);?></div>
					</div>
				</div>

				<div class="span4 right">
					<h4 class="team-name">
						<?=HTML::anchor('tournament/club/'.$match->away->id, $match->away->club->name);?>
					</h4>
					<div class="away_goals">
						<?php if($match->away_goals):?>
							<?php foreach ($away_goals as $goal):?>
								<div><?=misc::get_goals_images($goal->count);?> <?=$goal->player->player_name();?></div>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>
			</div>

			<div class="span2 center">
				<?=html::image($match->away->club->logo(), array('class' => 'team_logo', 'alt' => $match->away->club->name));?>
			</div>
		</div>


		<div class="row-fluid">
			<div class="offset1 span4 right">
				<?php if($other_matches->count()):?>
					<h4>Другие матчи команд</h4>
					<?php foreach($other_matches as $omatch):?>
						<p>
							<?=$omatch->home->club->name;?>
							<a href="<?=URL::site('match/view/'.$omatch->id);?>">
								<?=$omatch->home_goals;?>
								-
								<?=$omatch->away_goals;?></a>
							<?=$omatch->away->club->name;?>
						</p>
					<?php endforeach;?>
				<?php endif;?>
			</div>
			<div class="offset2 span4">
				<?php if(count($match->videos)):?>
					<div class="match_videos">
						<h4>Видео матча</h4>
						<?php foreach($match->videos as $video):?>
							<p>
								<i class="icon-film"></i>
								<?=HTML::anchor(
									'http://youtu.be/'.$video->youtube_key,
									$video->title,
									array('class' => 'youtube', 'title' => HTML::chars($video->description), 'rel' => $video->youtube_key)
								);?>
							</p>
						<?php endforeach;?>
					</div>
				<?php endif;?>

				<?php if (
					$auth->logged_in()
					AND (
						$user->id == $match->home->user_id()
						OR $user->id == $match->away->user_id()
						OR $auth->logged_in('admin')
					)
				):?>
					<p><?=HTML::anchor('match/video_upload/'.$match->id, 'Добавить видео к матчу');?></p>
				<?php endif;?>
			</div>
		</div>
		<div class="row-fluid comments">
			<h3>Комментарии</h3>

		</div>
		<img id="comment_add_loadbar" src="/templates/fifa/img/ajax_load_bar.gif" style="display: none;"/>
		<div class="row-fluid">
			<div class="offset2 span8">
				<?php if($auth->logged_in()):?>
					<?=form::open('ajax/comment/add', array('id' => 'comment_add_form'));?>
					<fieldset>
						<legend>Добавить комментарий</legend>
						<?=Form::textarea('comment_text', '', array(
								'id' => 'field-comment_text',
								'class' => 'textarea field wysiwyg input-xxxlarge',
								'placeholder' => 'Введите текст комментария',
							));
						?>
					</fieldset>
					<?=form::hidden('match_id', $match->id);?>
					<?=form::submit("", "Добавить", array('class' => 'btn'));?>
					<?=form::close();?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script id="comment_tmpl" type="text/x-jquery-tmpl">
	<div class="comment row-fluid">
		<div class="span2 offset1">
			<div class="comment_author">
				<img src="${avatar_url}" alt="${username}" />
			</div>
			<div class="comment_header">
				<strong>${username}</strong>
				<p>${date}</p>
			</div>
		</div>
		<div class="comment_text span8">
			{{html text}}
		</div>
	</div>

	<hr />
</script>



<script>
	var comments_array = <?=json_encode($comments);?>;
</script>
<?=html::script('templates/ux/js/comments.js');?>
<?=html::script('templates/ux/js/youtubepopup.js');?>