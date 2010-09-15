<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?foreach($sections as $section):?>
	<?=html::anchor('forum/admin/section_edit/'.$section->id, $section->name);?><br>
<?endforeach;?>
<hr>
<?=html::anchor('forum/admin/section_edit', __("Создать"));?><br>
