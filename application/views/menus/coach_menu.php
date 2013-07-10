<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php if($lines->count()):?>
	<ul class="vmenu teams">
		<li class="vmenu_title">
			<?=__("Ваши команды");?>
		</li>
	<?php foreach($lines as $line):?>
		<li>
			<?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?>
			(<?=HTML::anchor('tournament/view/'.$line->table->id, $line->table->name);?>)
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
<?php if(count($tables_with_lines)):?>
	<?php foreach($tables_with_lines as $table):?>
		<ul class="vmenu tables">
			<li class="vmenu_title">
				<?=HTML::anchor('tournament/view/'.$table['table']->id, $table['table']->name);?>
				<?php if($table['table']->active):?>
					<?=HTML::anchor('match/reg/'.$table['table']->id, HTML::image('templates/fifa/img/add.png', array('alt' => __("Зарегистрировать матч"))), array('title' => __("Зарегистрировать матч"), 'alt' => __("Зарегистрировать матч")));?>
				<?php endif;?>
			</li>
			<li>
				<table cellpadding="3" cellspacing="1">
					<thead>
						<tr>
							<th class="number">
								№
							</th>
							<th>
								Команда
							</th>
							<th class="goals">
								Мячи
							</th>
							<th>
								О
							</th>
						</tr>
					</thead>
					<tbody>
						<?text::alternate();?>
						<?php foreach($table['lines'] as $line):?>
							<tr class="<?=text::alternate('nechet', 'chet');?> <?=($line['line']->user->id == $user->id)?"my_team":"";?>">
								<td class="number">
									<?=$line['position'];?>
								</td>
								<td>
									<?=html::anchor('tournament/club/'.$line['line']->id, $line['line']->club->name);?>
								</td>
								<td class="goals">
									<?=$line['line']->goals."-".$line['line']->passed_goals;?>
								</td>
								<td class="points">
									<?=$line['line']->points;?>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</li>
		</ul>
	<?php endforeach;?>
<?php endif;?>