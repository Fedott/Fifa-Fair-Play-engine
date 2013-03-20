<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php /** @var Model_Match $match */ ?>
<div class="row-fluid">
	<div class="offset1 span10">
		<div class="row-fluid">
			<div class="span3 center">
				<?=html::image($match->home->club->logo(), array('class' => 'team_logo', 'alt' => $match->home->club->name));?>
			</div>
			<div class="span6 center">
				<h4><?=$match->table->name;?></h4>
				<?php if($match->table->scheduled):?>
					<p><?=$match->planned_match->round;?></p>
				<?php endif;?>
				<p><?=misc::get_human_date($match->date);?></p>
			</div>
			<div class="span3 center">
				<?=html::image($match->away->club->logo(), array('class' => 'team_logo', 'alt' => $match->away->club->name));?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3 center">
				<h1><?=$match->home_goals;?></h1>
			</div>
			<div class="span6 center">
				<h1>:</h1>
				<h4>Голы</h4>
			</div>
			<div class="span3 center">
				<h1><?=$match->away_goals;?></h1>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span5 right">
				<?if($match->home_goals):?>
					<?foreach ($home_goals as $goal):?>
						<p><?=$goal->player->player_name();?> <?=misc::get_goals_images($goal->count);?></p>
					<?endforeach;?>
				<?endif;?>
			</div>
			<div class="offset2 span5">
				<?if($match->away_goals):?>
					<?foreach ($away_goals as $goal):?>
						<p><?=misc::get_goals_images($goal->count);?> <?=$goal->player->player_name();?></p>
					<?endforeach;?>
				<?endif;?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="offset2 span3 right">
				<?if($other_matches->count()):?>
					<h4>Другие матчи команд</h4>
					<?foreach($other_matches as $omatch):?>
						<p>
							<?=$omatch->home->club->name;?>
							<a href="<?=URL::site('match/view/'.$omatch->id);?>">
								<?=$omatch->home_goals;?>
								-
								<?=$omatch->away_goals;?></a>
							<?=$omatch->away->club->name;?>
						</p>
					<?endforeach;?>
				<?php endif;?>
			</div>
			<div class="offset2 span3">
				<?if(count($match->videos)):?>
					<div class="match_videos">
						<h4>Видео матча</h4>
						<?foreach($match->videos as $video):?>
							<p>
								<i class="icon-film"></i>
								<?=HTML::anchor('http://youtu.be/'.$video->youtube_key, $video->title, array('class' => 'youtube', 'title' => HTML::chars($video->description), 'rel' => $video->youtube_key));?>
							</p>
						<?endforeach;?>
					</div>
				<?endif;?>

				<?if($user->id == $match->home->user_id() OR $user->id == $match->away->user_id() OR $auth->logged_in('admin')):?>
					<p><?=HTML::anchor('match/video_upload/'.$match->id, 'Добавить видео к матчу');?></p>
				<?endif;?>
			</div>
		</div>
		<div class="row-fluid comments">
			<h3>Комментарии</h3>

		</div>
		<img id="comment_add_loadbar" src="/templates/fifa/img/ajax_load_bar.gif" style="display: none;"/>
		<div class="row-fluid">
			<div class="offset3">
				<?if($auth->logged_in()):?>
					<?=form::open('ajax/comment/add', array('id' => 'comment_add_form'));?>
					<fieldset>
						<legend>Добавить комментарий</legend>
						<?php echo Form::textarea('comment_text', '', array(
								'id' => 'field-comment_text',
								'class' => 'textarea field wysiwyg input-xxxlarge',
								'placeholder' => 'Введите текст комментария',
							));
						?>
					</fieldset>
					<?=form::hidden('match_id', $match->id);?>
					<?=form::submit("", "Добавить", array('class' => 'btn'));?>
					<?=form::close();?>
				<? endif; ?>
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