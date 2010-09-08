<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Widget extends Controller
	{
		public function action_menu($type = NULL)
		{
			$auth = Auth::instance();
			$user= $auth->get_user();

			$coach_menu = FALSE;
			if($auth->logged_in('coach'))
			{
				$lines = Jelly::select('line')
						->where("user_id", "=", $user->id)
						->where("_table:table.visible", "=", 1)
						->execute();

				$tables = array();
				foreach($lines as $line)
				{
					$tables[] = $line->table;
					if(count($tables) == 3)
						break;
				}

				$tables_with_lines = array();
				foreach($tables as $table)
				{
					$tables_with_lines[]['table'] = $table;
					$number = count($tables_with_lines)-1;
					$tables_with_lines[$number]['lines'] = array();
					foreach($table->lines as $key => $line)
					{
						if($line->user->id == $user->id)
						{
							$position = $key + 1;
							if($key == 0)
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 1], 'position' => $position + 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 2], 'position' => $position + 2);
							}
							elseif($key == count($table->lines) - 1)
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 2], 'position' => $position - 2);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 1], 'position' => $position - 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
							}
							else
							{
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key - 1], 'position' => $position - 1);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key], 'position' => $position);
								$tables_with_lines[$number]['lines'][] = array('line' => $table->lines[$key + 1], 'position' => $position + 1);
							}
						}
					}
				}

				$coach_menu = new View('menus/coach_menu');
				$coach_menu->lines = $lines;
				$coach_menu->tables_with_lines = $tables_with_lines;
				$coach_menu->user = $user;
			}

			$view = View::factory('menus/main');
			$view->auth = $auth;
			$view->user = $auth->get_user();
			$view->coach_menu = $coach_menu;
			echo $view->render();
		}
	}