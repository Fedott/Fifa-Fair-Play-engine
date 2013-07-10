<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<p>Пользователи</p>
<ul>
<?php foreach($users as $user):?>
	<li>
		<?=html::anchor('admin/user/edit/'.$user->id, $user->username);?> | <?=html::anchor('admin/user/login/'.$user->id, 'Как видит он');?>
	</li>
<?php endforeach;?>
</ul>
<?=$pagination;?>