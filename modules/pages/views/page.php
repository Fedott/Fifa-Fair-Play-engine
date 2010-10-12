<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div id="page_header">
	<h2><?=$page->title?></h2>
</div>
<div id="page_body">
	<?=$page->text?>
</div>
<div id="page_footer">
	<?=$page->date();?>
</div>