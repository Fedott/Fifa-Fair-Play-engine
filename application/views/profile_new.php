<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="row-fluid">
	<h2 class="page-header">
		Пользователь
	</h2>
	<div class="span2 center">
		<?=HTML::image($user->get_avatar());?>
	</div>
	<div class="span6">
		<h4>
			<?=$user->username;?>
			<?=
				($my_profile)
					?('<small>'.html::anchor('main/profile_edit', __("Редактированить")).'</small>')
					:""
			;?>
		</h4>
		<table class="profile">
			<tbody>
			<?php if($user->first_name):?>
				<tr>
					<th>Имя</th>
					<td><?=$user->first_name;?></td>
				</tr>
			<?php endif;?>
			<?php if($user->last_name):?>
				<tr>
					<th>Фамилия</th>
					<td><?=$user->last_name;?></td>
				</tr>
			<?php endif;?>
			</tbody>
			<tbody>
			<?php foreach($user->get_im_as_array() as $im => $im_login):?>
				<tr>
					<th><?=$im;?></th>
					<td><?=$im_login;?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
			<?php if($coach):?>
				<?php if (count($coach['lines'])):?>
					<tbody>
					<tr>
						<th>Команды</th>
						<td>
							<ul class="unstyled">
								<?php foreach ($coach['lines'] as $line):?>
									<li>
										<?=HTML::anchor('tournament/club/'.$line->id, $line->club->name);?>
										(<?=HTML::anchor('tournament/view/'.$line->table->id, $line->table->name);?>)
									</li>
								<?php endforeach;?>
							</ul>
						</td>
					</tr>
					</tbody>
				<?php endif;?>
			<?php endif;?>
		</table>
	</div>
</div>
