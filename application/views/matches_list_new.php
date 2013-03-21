<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php
/**
 * @var array $clubs_arr
 * @var array $comments_arr
 * @var $matches
 * @var Model_Match $match
 * @var Model_User $user
 * @var array $videos_ids
 * @var Model_Table $tourn
 */
?>
<div class="page-header">
	<?if($tourn->loaded()):?>
		<h2>Матчи турнира "<?=$tourn->name;?>"</h2>
	<?else:?>
		<h2>Все матчи</h2>
	<?endif;?>
</div>
<div class="row-fluid">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Дата</th>
				<th></th>
				<th class="center">Счёт</th>
				<th></th>
				<th>Дополнительно</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($matches as $match):?>
				<tr>
					<td><?=MISC::get_human_short_date($match->date);?></td>
					<td class="right"><?=$clubs_arr[$match->home->club_id()]->name;?></td>
					<td class="center">
						<?=html::anchor('match/view/'.$match->id, $match->home_goals." - ".$match->away_goals);?>
					</td>
					<td><?=$clubs_arr[$match->away->club_id()]->name;?></td>
					<td>
						<?php if($match->confirm):?>
							<i class="icon-ok" title="Подтверждён"></i>
						<?php else:?>
							<i class="icon-remove" title="Не подтверждён"></i>
						<?php endif;?>
						<?if(isset($comments_arr[$match->id])):?>
							<i class="icon-comment" title="Есть комментарии" show-match-comments="<?=$match->id;?>"></i>
							<div class="popover bottom in fade" comments-match-id="<?=$match->id;?>" style="display: none;">
								<div class="arrow"></div>
								<div class="popover-content">
									<?foreach($comments_arr[$match->id] as $comment):?>
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
									<?endforeach;?>
								</div>
							</div>
						<?php endif;?>
						<?php if(isset($videos_ids[$match->id])):?>
							<i class="icon-film" title="Есть видео"></i>
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>

<?=html::script('templates/ux/js/popover.js');?>