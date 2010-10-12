<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h2>Категории</h2>
<ul class="categories">
<?foreach($categories as $category):?>
	<li>
		<?=html::anchor('category/view/'.$category->id, $category->name);?>
	</li>
</ul>
<?endforeach;?>