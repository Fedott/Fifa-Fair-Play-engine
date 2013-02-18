<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Class Model_Table
 * @property $id
 * @property $name
 * @property $url
 * @property $type
 * @property $season
 * @property $active
 * @property $visible
 * @property $ended
 * @property Jelly_Collection $lines
 * @property $matches
 * @property $scheduled
 */
class Model_Table extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
			'name' => new Field_String(array(
				'rules' => array(
					'not_empty' => array(TRUE),
				),
			)),
			'url' => new Field_String(array(
				'unique' => TRUE,
			)),
			'type' => new Field_Enum(array(
				'choices' => array('friendly', 'official'),
			)),
			'season' => new Field_Integer,
			'active' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'visible' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'ended' => new Field_Boolean(array(
				'default' => FALSE,
			)),
			'lines' => new Field_HasMany,
			'matches' => new Field_Integer(array(
				'default' => 2,
			)),
			'scheduled' => new Field_Boolean(array(
				'default' => FALSE,
			)),
		));
	}

	public function make_schedule($save = FALSE)
	{
		ini_set('max_execution_time', 120);
		$matches = array();
		$rounds = count($this->lines) * $this->matches - $this->matches;
		$circle_rounds = $rounds / $this->matches;
		for($circle = 0; $circle < $this->matches; $circle++)
		{
			$matches[$circle] = array();

			$clubs = $this->lines->as_array(NULL, 'id');

			for ($ihome = 0; $ihome < count($clubs); $ihome++)
			{
				for($iaway = $ihome + 1; $iaway < count($clubs); $iaway++)
				{
					$matches[$circle][] = array('home' => $clubs[$ihome], 'away' => $clubs[$iaway]);
				}
			}
			shuffle($matches[$circle]);
			$shuffle = function($a)
			{
				shuffle($a);
				return $a;
			};
			$matches[$circle] = array_map($shuffle, $matches[$circle]);
		}

		var_dump($matches);exit;

		return $this->_create_planned_matches($matches, $save);
	}

	protected function _create_planned_matches($matches, $save = FALSE)
	{
		$objects = array();
		foreach($matches as $circle => $circle_matches)
		{
			foreach($circle_matches as $round => $round_matches)
			{
				foreach($round_matches as $match)
				{
					/** @var $match_object Model_Planned_Match */
					$match_object = Jelly::factory('planned_match', $match);
					$match_object->table = $this;
					$match_object->round = ($round + 1) + ($circle * count($circle_matches));
					$objects[] = $match_object;

					if($save)
					{
						$match_object->save();
					}
				}
			}
		}

		return $objects;
	}

	protected function _check_exists_planned_match($matches, $home, $away)
	{
		foreach($matches as $round)
		{
			foreach($round as $match)
			{
				if(($match['home'] == $home AND $match['away'] == $away) OR ($match['away'] == $home AND $match['home'] == $away))
				{
					return false;
				}
			}
		}

		return true;
	}
}