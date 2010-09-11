<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Field_Wysiwyg extends Field_Text
	{
		public $xss_clean = TRUE;

		public function set($value)
		{
			if($this->xss_clean)
			{
				$value = Security::xss_clean($value);
			}

			return parent::set($value);
		}
	}