<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php if($tourn->loaded()):?>
	<h2>Матчи турнира "<?=$tourn->name;?>"</h2>
<?php else:?>
	<h2>Все матчи</h2>
<?php endif;?>
<?php if($pagination->total_items):?>
	<table class="matches" cellpadding="3" cellspacing="1">
		<thead>
			<tr>
				<th>Домашняя команда</th>
				<th>Счёт</th>
				<th>Гостевая команды</th>
			<?php if( ! $tourn->loaded()):?>
				<th>Турнир</th>
			<?php endif;?>
				<th>Ком</th>
				<th>Дата</th>
				<th>Под</th>
				<th>Др</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($matches as $match):?>
			<tr class="<?=text::alternate('nechet', 'chet');?> <?=($user AND ((int)$match->away->user_id() == $user->id OR $match->home->user_id() == $user->id))?'my_team':'';?>">
				<td><?=html::anchor('tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?></td>
				<td><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
				<td><?=html::anchor('tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?></td>
			<?php if(!$tourn->loaded()):?>
				<td><?=html::anchor('tournament/view/'.$match->table->url, $match->table->name);?></td>
			<?php endif;?>
				<td>
					<?php if(isset($comments_arr[$match->id])):?>
						<div class="match_comments_wrapper">
							<a href="<?=url::site('match/view/'.$match->id);?>" class="comments_views">Смотреть</a>
							<ul class="match_commnets">
								<?php foreach($comments_arr[$match->id] as $comment):?>
									<li>
										<p class="comment_author">
											Автор: <b><?=$comment->author->username;?></b>
											<?php if($comment->author->id == $match->home->user_id()):?>
												(<b><?=$clubs_arr[$match->home->club_id()]->name;?></b>)
											<?php elseif($comment->author->id == $match->away->user_id()):?>
												(<b><?=$clubs_arr[$match->away->club_id()]->name;?></b>)
											<?php endif;?>
										</p>
										<p class="comment_text">
											<?=$comment->text;?>
										</p>
									</li>
								<?php endforeach;?>
							</ul>
						</div>
					<?php endif;?>
				</td>
				<td><?=MISC::get_human_date($match->date);?></td>
				<td><?=($match->confirm)?'<p class="green">'.__("Да").'</p>':'<p class="red">'.__("Нет").'</p>';?></td>
				<td class="center">
					<?php if(isset($videos_ids[$match->id])):?>
						<img src="/templates/fifa/img/video.png" title="Есть видео">
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<?=$pagination;?>
<?php else:?>
<p>
	Ещё не сыграно ни одного матча
</p>
<?php endif;?>
