<?php

//print_r($data);

//echo'<pre>';print_r($data->foto);echo'</pre>';//die;
$url = $this->controller->createUrl('pages/'.$url_path, array('alias'=>$data->alias));

?>

<li class="products-on-auto-item floatLeft">
	<a class="products-on-auto-item-img" href="<?= $url ?>" title="<?= $data->name ?>">
		<img src="<?= $data->foto?>" alt="" class="medium-image">
	</a>
	<p class="products-on-auto-item-ttl"><?= $data->name ?></p>			
	<p class="products-on-auto-item-intro">
		<?= strip_tags($data->intro) ?>
		<br>
		<a class="products-on-auto-item-more" href="<?= $url ?>" title="<?= $data->name ?>">Читать дальше</a>
	</p>

</li>
