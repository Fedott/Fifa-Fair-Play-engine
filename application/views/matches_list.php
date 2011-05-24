<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<script type="text/javascript">
jQuery( function($) {
	$(document).ready( function() {
		$("a.comments_views").click(function() {
			$(this).siblings("ul").show().attr('top');
			return false;
		});
	});
});
</script>

<?if($tourn->loaded()):?>
	<h2>Матчи турнира "<?=$tourn->name;?>"</h2>
<?else:?>
	<h2>Все матчи</h2>
<?endif;?>
<?if($pagination->total_items):?>
	<table class="matches" cellpadding="3" cellspacing="1">
		<thead>
			<tr>
				<th>Домашняя команда</th>
				<th>Счёт</th>
				<th>Гостевая команды</th>
			<?if( ! $tourn->loaded()):?>
				<th>Турнир</th>
			<?endif;?>
				<th>Ком</th>
				<th>Дата</th>
				<th>Под</th>
			</tr>
		</thead>
		<tbody>
		<?foreach($matches as $match):?>
			<tr class="<?=text::alternate('nechet', 'chet');?> <?=($user AND ((int)$match->away->user_id() == $user->id OR $match->home->user_id() == $user->id))?'my_team':'';?>">
				<td><?=html::anchor('tournament/club/'.$match->home->id, $clubs_arr[$match->home->club_id()]->name);?></td>
				<td><?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?></td>
				<td><?=html::anchor('tournament/club/'.$match->away->id, $clubs_arr[$match->away->club_id()]->name);?></td>
			<?if(!$tourn->loaded()):?>
				<td><?=html::anchor('tournament/view/'.$match->table->url, $match->table->name);?></td>
			<?endif;?>
				<td>
					<?if(isset($comments_arr[$match->id])):?>
						<div class="match_comments_wrapper">
							<a href="" class="comments_views">Смотреть</a>
							<ul class="match_commnets">
								<?foreach($comments_arr[$match->id] as $comment):?>
									<li>
										<p class="comment_author">
											Автор: <b><?=$comment->author->username;?></b>
											<?if($comment->author->id == $match->home->user_id()):?>
												(<b><?=$clubs_arr[$match->home->club_id()]->name;?></b>)
											<?elseif($comment->author->id == $match->away->user_id()):?>
												(<b><?=$clubs_arr[$match->away->club_id()]->name;?></b>)
											<?endif;?>
										</p>
										<p class="comment_text">
											<?=$comment->text;?>
										</p>
									</li>
								<?endforeach;?>
							</ul>
						</div>
					<?endif;?>
				</td>
				<td><?=MISC::get_human_date($match->date);?></td>
				<td><?=($match->confirm)?'<p class="green">'.__("Да").'</p>':'<p class="red">'.__("Нет").'</p>';?></td>
			</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<?=$pagination;?>
<?else:?>
<p>
	Ещё не сыграно ни одного матча
</p>
<?endif;?>
