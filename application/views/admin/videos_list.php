<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1>Видео:</h1>
<table class="teams" cellpadding="3" cellspacing="1">
	<thead>
	<tr>
		<td class="number"></td>
		<td>Название</td>
		<td>Описание</td>
		<td>Действия</td>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1;?>
	<?php foreach($videos as $video):?>
		<tr class="<?=text::alternate('nechet', 'chet');?>">
			<td><?=$i++?>.</td>
			<td><?=html::anchor('/admin/video/edit/'.$video->id, $video->title, array('class' => 'video'))?></td>
			<td><?=$video->description;?></td>
			<td>
				<?=HTML::anchor('admin/video/delete/'.$video->id, 'Удалить');?>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>