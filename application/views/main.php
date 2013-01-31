<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div class="span6">
	<table class="table table-hover">
		<tbody>
			<?php foreach($table->lines as $pos => $line):?>
				<?php if($pos > 10) {break;}?>
				<tr>
					<td><?=++$pos;?></td>
					<td><?=$line->club->name;?></td>
					<td><?=$line->points;?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
<div class="span6">
	<table class="table table-hover">
		<tbody>
			<?php foreach($goleodors as $pos => $goleodor):?>
				<tr>
					<td><?=++$pos;?></td>
					<td><?=$goleodor['player']->player_name();?></td>
					<td><?=$goleodor['goals'];?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>