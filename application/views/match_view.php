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
	});
})
</script>
<script id="comment_tmpl" type="text/x-jquery-tmpl">
	<div class="comment">
		<div class="comment_author">
			<img src="${avatar_url}" alt="${username}" />
		</div>
		<div class="comment_header">
			<b>${username}</b> ${date}
		</div>
		<div class="comment_text">
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

<div class="comments">
	<h4>Комментарии к матчу:</h4>
	
</div>
<img id="comment_add_loadbar" src="/templates/fifa/img/ajax_load_bar.gif" style="display: none;"/>
<?if(Auth::instance()->logged_in()):?>
	<?=form::open('ajax/comment/add', array('id' => 'comment_add_form'));?>
		<h4>Добавить комментарий</h4>
		<?php echo Form::textarea('comment_text', '', array(
				'id' => 'field-comment_text',
				'rows' => 8,
				'cols' => 40,
				'class' => 'textarea field wysiwyg max',
			));
		?>
		<?=form::hidden('match_id', $match->id);?>
		<?=form::submit("", "Добавить");?>
	<?=form::close();?>
<? endif; ?>
