<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?foreach($sections as $section):?>
<div class="section">
	<div class="section_title">
		<?=$section->name;?>
	</div>
	<div class="section_body">
		<?foreach($section->forums as $forum):?>
		<div class=""></div>
		<?endforeach;?>
	</div>
</div>
<?endforeach;?>