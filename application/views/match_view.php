<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<script type="text/javascript">
jQuery( function($) {
	$(document).ready( function() {
		var comments_array = <?=json_encode($comments);?>;
		if(comments_array.length)
		{
			$("#comment_tmpl").tmpl(comments_array).appendTo("div.comments");
		}
		var options = {
			dataType: 'json',
			beforeSubmit: function () {
				$("#comment_add_form").hide();
				$("#comment_add_loadbar").show();
			},
			success: function (respone){
				if(respone.complete == true)
				{
					$("#comment_tmpl").tmpl(respone.comment).appendTo("div.comments");
					$("#comment_add_form").hide();
					$("#comment_add_loadbar").hide();
				}
				else
				{
					alert('При добавлении комментария возникли ошибки: ' + respone.errors);
					$("#comment_add_form").show();
					$("#comment_add_loadbar").hide();
				}
			}
		};
		$("#comment_add_form").ajaxForm(options);

		$("a.youtube").YouTubePopup({
			autoplay: 0,
			clickOutsideClose: true
		});
	});
})
</script>
<script id="comment_tmpl" type="text/x-jquery-tmpl">
	<div class="comment row-fluid">
		<div class="span2">
			<div class="comment_author">
				<img src="${avatar_url}" alt="${username}" />
			</div>
			<div class="comment_header">
				<b>${username}</b> ${date}
			</div>
		</div>
		<div class="comment_text span8">
			{{html text}}
		</div>
	</div>
</script>
<table cellspacing="0" cellpadding="0" class="match">
	<tbody>
		<tr>
			<td class="home_team_ava">
				<?=html::image($match->home->club->logo(), array('class' => 'team_logo', 'alt' => $match->home->club->name));?>
			</td>
			<td class="match_result">
				<div class="match_tournament">
					<?=$match->table->name;?>
				</div>
				<div class="match_date">
					<?=misc::get_human_date($match->date);?>
				</div>
				<?php if($match->planned_match):?>
					<div class='match_tournament'>
						Матч <?=$match->planned_match->round;?> тура
					</div>
				<?php endif;?>
				<table class="match_teams">
					<tr>
						<td class="match_team_home"><?=$match->home->club->name;?></td>
						<td>-</td>
						<td class="match_away_home"><?=$match->away->club->name;?></td>
					</tr>
				</table>
				<?=$match->home_goals;?> : <?=$match->away_goals;?>
			</td>
			<td class="away_team_ava">
				<?=html::image($match->away->club->logo(), array('class' => 'team_logo', 'alt' => $match->away->club->name));?>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<table class="match_goals">
					<tr>
						<td class="left">
							<ul class="home_goals">
							<?if($match->home_goals):?>
								<?foreach ($home_goals as $goal):?>
								<li><?=$goal->player->player_name();?> <?=misc::get_goals_images($goal->count);?></li>
								<?endforeach;?>
							<?endif;?>
							</ul>
						</td>
						<td class="center"> </td>
						<td class="right">
							<ul class="away_goals">
							<?if($match->away_goals):?>
								<?foreach ($away_goals as $goal):?>
								<li><?=misc::get_goals_images($goal->count);?> <?=$goal->player->player_name();?></li>
								<?endforeach;?>
							<?endif;?>
							</ul>
						</td>
					</tr>
				</table>
			</td>
			<td>

			</td>
		</tr>
	</tbody>
</table>

<?if(count($match->videos)):?>
	<div class="match_videos">
		Видео матча:<br />
		<?foreach($match->videos as $video):?>
			<?=HTML::anchor('http://youtu.be/'.$video->youtube_key, $video->title, array('class' => 'youtube', 'title' => HTML::chars($video->description), 'rel' => $video->youtube_key));?><br />
		<?endforeach;?>
	</div>
<?endif;?>

<?if($user->id == $match->home->user_id() OR $user->id == $match->away->user_id() OR $auth->logged_in('admin')):?>
	<?=HTML::anchor('match/video_upload/'.$match->id, 'Добавить видео к матчу');?>
<?endif;?>

	<?if($other_matches->count()):?>
	<div class="other_matches">
		Другие матчи команд:<br/>
		<?foreach($other_matches as $omatch):?>
		<?=$omatch->home->club->name;?>
		<a href="<?=URL::site('match/view/'.$omatch->id);?>">
		<?=$omatch->home_goals;?>
		-
		<?=$omatch->away_goals;?></a>
		<?=$omatch->away->club->name;?>
		<br/>
		<?endforeach;?>
	</div>
<?endif;?>

<div class="comments">
	<h4>Комментарии к матчу:</h4>
	
</div>
<img id="comment_add_loadbar" src="/templates/fifa/img/ajax_load_bar.gif" style="display: none;"/>
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
