<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h3><?=$topic->title;?></h3>
<?foreach($posts as $post):?>
	<div class="post" id="post<?=$post->id;?>">
		
	</div>
<?endforeach;?>