<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Builder_Post extends Jelly_Builder
{
	public function by_topic($id)
	{
		return $this->where("topic_id", "=", $id);
	}
}