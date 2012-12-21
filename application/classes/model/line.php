<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @property $table
 * @property $club
 * @property $user
 * @property $games
 * @property $win
 * @property $drawn
 * @property $lose
 * @property $goals
 * @property $passed_goals
 * @property $points
 */
class Model_Line extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		// TODO: Костыль из костылей в строке сортировки добавлены тильды, для эмуляции экранирования. Очень опасно!!!
		$meta->sorting(array('points' => 'desc', 'goals` - `passed_goals' => 'desc', 'win' => 'desc', 'games' => 'asc', 'goals' => 'desc', 'passed_goals' => 'asc'))
			->load_with(array('club', 'user', 'table'))
			->fields(array(
			'id' => new Jelly_Field_Primary,
			'table' => new Jelly_Field_BelongsTo,
			'club' => new Jelly_Field_BelongsTo,
			'user' => new Jelly_Field_BelongsTo,
			'games' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'win' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'drawn' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'lose' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'goals' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'passed_goals' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
			'points' => new Jelly_Field_Integer(array(
				'default' => 0,
			)),
		));
	}

	/**
	 * Возвращает ID клуба линии, без загрузки модели по связи
	 */
	public function club_id()
	{
		return ($this->loaded())?$this->_original['club']:FALSE;
	}

	/**
	 * Возвращает ID пользователя линии, без загрузки модели по связи
	 */
	public function user_id()
	{
		return ($this->loaded())?$this->_original['user']:FALSE;
	}
}