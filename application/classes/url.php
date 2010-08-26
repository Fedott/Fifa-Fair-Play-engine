<?php defined('SYSPATH') OR die('No direct access allowed.');

	class URL extends Kohana_URL
	{
		public static function string_to_url($string)
		{
			$string = mb_strtolower($string, "UTF-8");
			$al = array('а','б','в','г','д','е','ё','ж','з','и','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','й',' ');
			$bl = array('a','b','v','g','d','e','e','jg','z','i','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sh',"",'w',"",'ea','iu','iy','y','-');
			$string = str_replace($al, $bl, $string);

			return $string;
		}
	}