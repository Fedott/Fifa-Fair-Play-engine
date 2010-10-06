<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div id="news_header">
	<h2><?=$news->title?></h2>
</div>
<div id="news_body">
	<?=$news->text?>
</div>
<div id="news_footer">
	<?=$news->date();?>
</div>