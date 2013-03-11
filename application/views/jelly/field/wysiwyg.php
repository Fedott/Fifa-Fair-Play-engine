<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php echo Form::textarea($name, $value, $attributes + array(
	'id' => 'field-'.$name,
	'rows' => 8,
	'class' => 'textarea field wysiwyg input-xxlarge',
)); ?>