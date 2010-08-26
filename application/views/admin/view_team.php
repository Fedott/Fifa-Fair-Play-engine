<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$team->name?></h1>
<?if(count($team->lines)):?>
<p>Учавствует в турнирах:
	<?foreach($team->lines as $key => $line):?><?=($key==1)?', ':''?><?=$line->table->name?><?endforeach;?>
</p>
<?else:?>
<p>
	Не учавствует ни в одном турнире
</p>
<?endif?>
<?if(count($team->players)):?>
<table class="teams" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<td class="number"></td>
			<td>Имя Фамилия или прозвище</td>
		</tr>
	</thead>
	<tbody>
		<?foreach($team->players as $player):?>
		<tr class="<?=(($i%2)==0)?'chet':'nechet'?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('admin/player/edit/'.$player->id, $player->name(false), array('class' => 'player'));?></td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>
<?else:?>
<p>Нет игроков</p>
<?endif?>
<hr>
<?=html::anchor('admin/team/edit/'.$team->id, 'Редактировать')?>
<br>
<?=html::anchor('admin/player/adds/'.$team->id, 'Добавить игроков')?>
<br>
<?=html::anchor('admin/team/edit_image/'.$team->id, 'Изменить логотип');?>