<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Player extends Controller_Admin
	{
		public function action_index()
		{
			$view = new View('admin/player');

			$this->template->title = __("Управление игроками");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ";
		}

		public function action_edit($id = NULL)
		{
			if($id === NULL)
				$player = Jelly::factory('player');
			else
				$player = Jelly::select ('player', $id);

			$errors = array();

			if($_POST)
			{
				try
				{
					$player->set(arr::extract($_POST, array('first_name', 'last_name', 'year_of_birth', 'club')));
					$player->save();
					Request::instance()->redirect('admin/club/view/'.$player->club->id);
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('player');
				}
			}

			$view = new View('admin/player_edit');
			$view->player = $player;
			$view->errors = $errors;

			$this->template->title = __('Редактирование игрока :name', array(':name' => $player->player_name(false)));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/player', 'Управление игроками')." > ";
		}

		public function action_adds($cid)
		{
			$errors = array();
			$allow = array();
			$club = Jelly::select('club', $cid);

			if($_POST)
			{
				foreach($_POST['last_name'] as $key => $val)
				{
					if(!empty($val))
					{
						try
						{
							$player = Jelly::factory('player');
							$player->set(array('last_name' => $_POST['last_name'][$key], 'first_name' => $_POST['first_name'][$key], 'club' => $cid));
							$player->save();
							$allow[] = $player->player_name(false);
						}
						catch (Validate_Exception $exp)
						{
							$errors[] = $player->player_name().": ".implode(",", $exp->array->errors('player'));
						}
					}
				}
			}

			$view = new View('admin/players_adds');
			$view->club = $club;
			$view->errors = $errors;
			$view->allow = $allow;

			$this->template->title = __('Добавление игроков в команду :name', array(':name' => $club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/club', 'Управление комадами')." > ";
		}
	}