<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<h1 class="news"><?=__("Новости");?></h1>
<?php foreach($News as $news):?>
<div class="news_short">
		<div class="news_short_header">
			<?=html::anchor('news/view/'.$news->url, $news->title);?>
		</div>
		<div class="news_short_info">
			Создана: <?=$news->date();?>
		</div>
	<div class="news_short_body">
		<?php text::limit_words($news->text, 50, '...');?>
		<?=$news->text?>
	</div>
	<div class="news_short_footer">
		<?=html::anchor('news/view/'.$news->url, 'Подробнее')?>
	</div>
</div>
<?php endforeach;?>
<div class="pagination">
	<?=$pagination;?>
</div>