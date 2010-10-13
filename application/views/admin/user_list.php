<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Пользователи</p>
<ul>
<?foreach($users as $user):?>
	<li>
		<?=html::anchor('admin/user/edit/'.$user->id, $user->username);?>
	</li>
<?endforeach;?>
</ul>
<?=$pagination;?>