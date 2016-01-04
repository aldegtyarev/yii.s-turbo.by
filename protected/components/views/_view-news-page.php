<?php

//print_r($data);

//echo'<pre>';print_r($data->foto);echo'</pre>';//die;
$url = $this->controller->createUrl('pages/'.$url_path, array('alias'=>$data->alias));

?>

<li class="products-on-auto-item last-news-item floatLeft">
	<a href="<?= $url ?>" title="<?= $data->name ?>" class="db page-item-more">
		<span class="db products-on-auto-item-img-cnt">
		<span class="db products-on-auto-item-img">
			<img src="<?= $data->foto?>" alt="" class="medium-image">
		</span>
		</span>
		<span class="db products-on-auto-item-ttl"><?= $data->name ?></span>
	</a>
	<?/*<a href="<?= $url ?>" title="<?= $data->name ?>" class="db products-on-auto-item-ttl"><?= $data->name ?></a>*/?>
	<p class="products-on-auto-item-intro">
		<?= strip_tags($data->intro) ?>
		<br>
		<a class="products-on-auto-item-more page-item-more" href="<?= $url ?>" title="<?= $data->name ?>">Подробнее</a>
	</p>

</li>
