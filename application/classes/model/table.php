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
		$circle_matches = array();
		for($circle = 0; $circle < $this->matches; $circle++)
		{
			$matches[$circle] = array();

			$clubs = $this->lines->as_array(NULL, 'id');
			$extra_command = false;
			if(count($clubs) % 2)
			{
				$clubs[] = -1;
				$extra_command = true;
			}
			$circle_rounds = count($clubs) - 1;

			shuffle($clubs);

			$half = count($clubs) / 2;

			$clubs_first_half = $clubs;
			$clubs_second_half = array_reverse(array_splice($clubs_first_half, $half));
			$first_club = array_shift($clubs_first_half);

			for($round = 0; $round < $circle_rounds; $round++)
			{
				if($round)
				{
					$tmp = array_shift($clubs_first_half);
					array_push($clubs_first_half, array_shift($clubs_second_half));
					array_unshift($clubs_second_half, $tmp);
				}
				array_unshift($clubs_first_half, $first_club);
				for($i = 0; $i < count($clubs_first_half); $i++)
				{
					$matches[$circle][$round][] = array('home' => $clubs_first_half[$i], 'away' => $clubs_second_half[$i]);
					$circle_matches[$clubs_first_half[$i]][$clubs_second_half[$i]] = 1;
					$circle_matches[$clubs_second_half[$i]][$clubs_first_half[$i]] = 1;
				}
				array_shift($clubs_first_half);
			}

			if($extra_command)
			{
				$matches[$circle] = $this->_clear_extra_command($matches[$circle]);
			}
		}

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

	protected function _clear_extra_command($matches)
	{
		foreach($matches as $key => $round)
		{
			foreach($round as $key_match => $match)
			{
				if($match['home'] == -1 OR $match['away'] == -1)
				{
					unset($matches[$key][$key_match]);
				}
			}
		}

		return $matches;
	}
}