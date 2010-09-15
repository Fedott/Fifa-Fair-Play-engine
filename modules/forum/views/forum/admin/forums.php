<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?foreach($forums as $forum):?>
	<?=html::anchor('forum/admin/forum_edit/'.$forum->id, $forum->name);?><br>
<?endforeach;?>
<hr>
<?=html::anchor('forum/admin/forum_edit', __("Создать"));?><br>
