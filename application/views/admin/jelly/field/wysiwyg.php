<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<?php echo Form::textarea($name, $value, $attributes + array(
	'id' => 'field-'.$name,
	'rows' => 8,
	'class' => 'textarea field wysiwyg-cl input-xxlarge',
)); ?>
<?=html::style("templates/admin/wysiwyg//jquery.cleditor.css");?>
<?=html::script("templates/admin/wysiwyg/jquery.cleditor.min.js");?>
<script type="text/javascript">
	$(document).ready(function () { $(".wysiwyg-cl").cleditor(); });
</script>