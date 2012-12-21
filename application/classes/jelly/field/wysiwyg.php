<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Jelly_Field_Wysiwyg extends Jelly_Field_Text
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