<?php defined('SYSPATH') OR die('No direct access allowed.');

	class Controller_Admin_Club extends Controller_Admin
	{
		public function action_index()
		{
			$this->action_list();
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
		
		public function action_parse_from_wiki($club_id)
		{
			$club = Jelly::select("club", $club_id);
			$errors = array();
			$allow = array();
			
			if($_POST)
			{
				include Kohana::find_file('vendor', 'phpQuery');
				
				$tables = phpQuery::newDocumentHTML($_POST['tables']);

				$count = 0;
				$players_arr = array();
				foreach ($tables->find("tr") as $player_tr)
				{
					if($count++ < 1)
					{
						continue;
					}
					$player_full_name = array('first_name' => NULL, 'last_name' => NULL, 'year_of_birth' => NULL);
					$player_tr = pq($player_tr)->find("td");
					$i_td = 1;
					foreach($player_tr as $player_td)
					{
						if($i_td == 4)
						{
							$tmp = pq($player_td)->find("a:first")->attr("title");
							$tmp = explode(",", $tmp);
							if(count($tmp) == 2)
							{
								$player_full_name = array('first_name' => trim($tmp[1]), 'last_name' => $tmp[0]);
							}
							else
							{
								$player_full_name['last_name'] = $tmp[0];
							}
						}
						if($i_td == 5)
						{
							$tmp = pq($player_td)->text();
							$player_full_name['year_of_birth'] = $tmp;
						}

						$i_td++;
					}
					
					$players_arr[] = $player_full_name;
				}

				foreach($players_arr as $player_arr)
				{
					try
					{
						$player = Jelly::factory('player');
						$player->set(array(
						                  'last_name' => $player_arr['last_name'],
						                  'first_name' => $player_arr['first_name'],
						                  'year_of_birth' => $player_arr['year_of_birth'],
						                  'club' => $club->id));
						$player->save();
						$allow[] = $player->player_name(false);
					}
					catch (Validate_Exception $exp)
					{
						$errors[] = $player->player_name().": ".implode(",", $exp->array->errors('player'));
					}
				}
			}
			
			$view = new View('admin/parse_from_wiki');
			$view->club = $club;
			$view->errors = $errors;
			$view->allow = $allow;
			
			$this->template->title = __("Добавление игроков из wiki");
			$this->template->content = $view;
			$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > ".
					HTML::anchor('admin/club', 'Управление клубами')." > ".
					HTML::anchor('admin/club/view/'.$club->id, 'Клуб '.$club->name)." > ";
		}
	}