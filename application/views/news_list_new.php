<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<div class="page-header">
	<h2>Новости</h2>
</div>

<div class="row-fluid">
	<div class="span8">
		<?php foreach ($News as $news):?>
			<div
				class="news-element"
				<?=HTML::attributes(array(
					'news_date' => $news->date(),
					'id' => $news->url,
				));?>
			>
				<?=$news->text;?>
				<div class="news-title">
					<?=html::anchor('news/view/'.$news->url, $news->title);?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
	<div class="span4">
		<ul class="unstyled">
			<?php foreach ($News as $news):?>
				<li>
					<?=html::anchor("#". $news->url, $news->title);?>
				</li>
			<?php endforeach;?>
		</ul>
	</div>
</div>