<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_User extends Controller_Admin
{
	public function action_index()
	{
		$this->action_list();
	}

	public function action_list()
	{
		$count = Jelly::query('user')->count();

		$pagination = Pagination::factory(array(
			'total_items' => $count,
		));

		$users = Jelly::query('user')
				->offset($pagination->offset)
				->limit($pagination->items_per_page)
				->execute();

		$view = new View('admin/user_list');
		$view->users = $users;
		$view->pagination = $pagination;

		$this->template->title = __("Список");
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > "
				.HTML::anchor('admin/user', __("Управление пользователями"))." > ";
	}

	public function action_edit($id)
	{
		$user = Jelly::query('user', $id)->execute();
		$errors = array();

		if($_POST)
		{
			try
			{
				$user->set(arr::extract($_POST, array('username', 'roles', 'last_name', 'first_name', 'icq', 'skype', 'origin')));
				if($_POST['password'])
				{
					$user->set(arr::extract($_POST, array('password', 'password_confirm')));
				}
				if(isset($_FILES) AND arr::path($_FILES, 'avatar.size', FALSE))
				{
					$user->avatar = $_FILES['avatar'];
				}
				$user->save();
				MISC::set_apply_message('Пользователь успешно изменён');
				Request::current()->redirect('admin/user/list');
			}
			catch (Validate_Exception $e)
			{
				$errors = $e->array->errors('register_form');
			}
		}

		$view = new View('admin/user_edit');
		$view->user = $user;
		$view->errors = $errors;

		$this->template->title = __("Редактирование пользователя, :username", array(":username" => $user->username));
		$this->template->content = $view;
		$this->template->breadcrumb = HTML::anchor('admin', 'Админка')." > "
				.HTML::anchor('admin/user', __("Управление пользователями"))." > "
				.HTML::anchor('admin/user/list', __("Список"))." > ";
	}
}