<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2><?=$category->name;?></h2>
<ul class="pages">
	<?foreach($category->pages as $page):?>
		<li>
			<?=html::anchor('page/view/'.$page->id, $page->title);?>
		</li>
	<?endforeach;?>
</ul>