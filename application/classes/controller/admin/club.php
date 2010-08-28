<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Club extends Controller_Admin
	{
		public function action_index()
		{
			$view = new View('admin/club');

			$this->template->title = __("Управление клубами");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ";
		}

		public function action_list()
		{
			$clubs = Jelly::select('club')->execute();

			$view = new View('admin/clubs_list');
			$view->clubs = $clubs;

			$this->template->title = __("Клубы");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ";
		}

		public function action_edit($cid = NULL)
		{
			if($cid === NULL)
				$club = Jelly::factory ('club');
			else
				$club = Jelly::select('club', $cid);
			$errors = array();

			if($_POST)
			{
				try
				{
					$club->set(Arr::extract($_POST, array('name')));
					$club->url = url::string_to_url($club->name);
					if(isset($_FILES))
						$club->logo = $_FILES['logo'];
					$club->save();
					Request::instance()->redirect('admin/club/view/'.$club->id);
				}
				catch (Validate_Exception $exp)
				{
					$errors = $exp->array->errors('club');
				}
			}

			$view = new View('admin/club_edit');
			$view->club = $club;
			$view->errors = $errors;

			$this->template->title = __("Редактирование");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}

		public function action_view($id)
		{
			$club = Jelly::select('club', $id);

			$view = new View('admin/club_view');
			$view->club = $club;

			$this->template->title = __("Клуб :name", array(':name' => $club->name));
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ";
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

			$this->template->title = __('Добавление игроков');
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}
	}