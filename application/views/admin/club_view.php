<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1><?=$club->name?></h1>
<?if(count($club->lines)):?>
<p>Учавствует в турнирах:
	<?foreach($club->lines as $key => $line):?><?=($key==1)?', ':''?><?=$line->table->name?><?endforeach;?>
</p>
<?else:?>
<p>
	Не учавствует ни в одном турнире
</p>
<?endif?>
<?if(count($club->players)):?>
<table class="teams" cellpadding="3" cellspacing="1">
	<thead>
		<tr>
			<td class="number"></td>
			<td>Имя Фамилия или прозвище</td>
		</tr>
	</thead>
	<tbody>
		<?$i = 1;?>
		<?foreach($club->players as $player):?>
		<tr class="<?=text::alternate('nechet', 'chet');?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('admin/player/edit/'.$player->id, $player->player_name(false), array('class' => 'player'));?></td>
		</tr>
	<?endforeach;?>
	</tbody>
</table>
<?else:?>
<p>Нет игроков</p>
<?endif?>
<hr/>
<?=html::anchor('admin/club/edit/'.$club->id, 'Редактировать');?>
<br/>
<?=html::anchor('admin/club/adds/'.$club->id, 'Добавить игроков');?>
<br/>
<?=html::anchor('admin/club/parse_from_wiki/'.$club->id, 'Добавить игроков из wiki');?>