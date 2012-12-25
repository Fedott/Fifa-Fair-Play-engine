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
				$player = Jelly::query ('player', $id)->execute();

			$errors = array();

			if($_POST)
			{
				try
				{
					$player->set(arr::extract($_POST, array('first_name', 'last_name', 'year_of_birth', 'club')));
					$player->save();
					Request::current()->redirect('admin/club/view/'.$player->club->id);
				}
				catch (Jelly_Validation_Exception $exp)
				{
					$errors = $exp->errors();
				}
			}

			$view = new View('admin/player_edit');
			$view->player = $player;
			$view->errors = $errors;

			$this->template->title = __('Редактирование игрока :name', array(':name' => $player->player_name(false)));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".HTML::anchor('admin/player', 'Управление игроками')." > ";
		}
	}