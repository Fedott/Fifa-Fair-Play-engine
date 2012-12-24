<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Ajax_Comment extends Controller_Template
{
	public $auto_render = FALSE;
	
	public function action_add()
	{
		if( ! $this->auth->logged_in())
		{
			misc::set_error_message("Авторизируйтесь что бы добавлять комментарии");
			Request::current()->redirect('match/view/'.arr::get($_POST, 'match_id'));
		}
		if($_POST)
		{
			try
			{
				$comment = Jelly::factory('comment');
				$comment->author = $this->user->id;
				$comment->match = $_POST['match_id'];
				$comment->date = time();
				$comment->text = $_POST['comment_text'];
				
				$comment->save();
				
				$return = array(
					'complete' => true,
					'comment' => array(
						'username' => $this->user->username,
						'avatar_url' => url::site($this->user->get_avatar()),
						'text' => $comment->text,
						'date' => misc::get_human_date($comment->date),
					),
				);
			}
			catch (Validation_Exception $exp)
			{
				$errors = $exp->array->errors('comment_errors');
				
				$return = array(
					'complete' => false,
					'errors' => $errors,
				);
			}
			
			echo json_encode($return);
		}
	}
}