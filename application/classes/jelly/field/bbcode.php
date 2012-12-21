<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Jelly_Field_Bbcode extends Jelly_Field_Text
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

		public function get($model, $value)
		{
			return $this->bbcode($value);
		}

		public function bbcode($text)
		{
			$str_search = array(
				"#\[br\]#is",
				"#\[p\](.+?)\[/p\]#",
				"#\[b\](.+?)\[/b\]#is",
				"#\[i\](.+?)\[/i\]#is",
				"#\[s\](.+?)\[/s\]#is",
				"#\[u\](.+?)\[/u\]#is",
				"#\[url=(.+?)\](.+?)\[\/url\]#is",
				"#\[url\](.+?)\[\/url\]#is",
				"#\[img\](.+?)\[\/img\]#is",
				"#\[size=(.+?)\](.+?)\[\/size\]#is",
				"#\[color=(.+?)\](.+?)\[\/color\]#is",
				"#\[list\](.+?)\[\/list\]#is",
				"#\[list=(1|a|I)\](.+?)\[\/list\]#is",
				"#\[\*\](.*)#",
				"#\[h(1|2|3|4|5|6)\](.+?)\[/h\\1\]#is",
				"#\[quote=(.+)\](.+)\[\/quote\]#is",
				"#\[quote\](.+)\[\/quote\]#is",
			);
			$str_replace = array(
				"<br />",
				"<p>\\1</p>",
				"<strong>\\1</strong>",
				"<span style='font-style:italic'>\\1</span>",
				"<span style='text-decoration:line-through'>\\1</span>",
				"<span style='text-decoration:underline'>\\1</span>",
				"<a target='_blank' href='\\1'>\\2</a>",
				"<a target='_blank' href='\\1'>\\1</a>",
				"<img src='\\1' />",
				"<span style='font-size:\\1pt'>\\2</span>",
				"<span style='color:\\1'>\\2</span>",
				"<ul>\\1</ul>",
				"<ol type='\\1'>\\2</ol>",
				"<li>\\1</li>",
				"<h\\1>\\2</h\\1>",
				"<blockquote><cite>\\1</cite>\\2</blockquote>",
				"<blockquote>\\1</blockquote>",
			);
			return preg_replace($str_search, $str_replace, $text);
		}
	}