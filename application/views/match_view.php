<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!--<div class="home_team_ava"><img src="/templates/template/img/bg_main.png" style="width: 100px; height: 100px;"></div>
<div class="match_result">4 : 1</div>
<div class="away_team_ava"><img src="/templates/template/img/bg_main.png" style="width: 100px; height: 100px;"></div>
-->

<table cellspacing="0" cellpadding="0" class="match">
	<tbody>
		<tr>
			<td class="home_team_ava">
				<?=html::image($match->home->team->img, array('class' => 'team_logo', 'alt' => $match->home->team->name));?>
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
						<td class="match_team_home"><?=$match->home->team->name;?></td>
						<td>-</td>
						<td class="match_away_home"><?=$match->away->team->name;?></td>
					</tr>
				</table>
				<?=$match->home_goals;?> : <?=$match->away_goals;?>
			</td>
			<td class="away_team_ava">
				<?=html::image($match->away->team->img, array('class' => 'team_logo', 'alt' => $match->away->team->name));?>
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
								<li><?=$goal->player->name();?> <?=misc::get_goals_images($goal->count);?></li>
								<?endforeach;?>
							<?endif;?>
							</ul>
						</td>
						<td class="center"> </td>
						<td class="right">
							<ul class="away_goals">
							<?if($match->away_goals):?>
								<?foreach ($away_goals as $goal):?>
								<li><?=misc::get_goals_images($goal->count);?> <?=$goal->player->name();?></li>
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
<?if(count($comments)):?>
<div class="comments">
	<h4>Комментарии к матчу:</h4>
	<?foreach($comments as $comment):?>
	<div class="comment">
		<div class="comment_author">
			<?=html::image(array('src' => $comment->author->get_avatar()/*, 'width' => 100, 'height' => 100*/), $comment->author->username);?>
		</div>
		<div class="comment_header">
			<b><?=$comment->author->username;?></b> <?=misc::get_human_date($comment->date);?>
		</div>
		<div class="comment_text">
			<?=$comment->text;?>
		</div>
	</div>
	<?endforeach;?>
</div>
<?endif;?>