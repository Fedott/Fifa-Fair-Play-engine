<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Field_Wysiwig extends Field_Text
	{
		public $strip_tags = TRUE;
		public $allowable_tags = array(
			'<a>',
			'<p>',
			'<a>',
			'<b>',
			'<sub>',
			'<div>',
			'<ul>',
			'<ol>',
			'<br>',
			'<li>',
			'<blockquote>',
		);

		public function set($value)
		{
			if($this->strip_tags)
			{

				$value = strip_tags($str, $allowable_tags);
			}

			return parent::set($value);
		}
	}