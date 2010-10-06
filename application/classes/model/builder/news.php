<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Builder_News extends Jelly_Builder
{
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'url';
		}
		return parent::unique_key($id);
	}
}