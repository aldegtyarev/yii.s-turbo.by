<?
/** @var dpsEmailController $this */
/** @var ProductCommentsForm $model */
$this->setSubject('Новый вопрос о товаре'); // указываем тему
$product_url = Yii::app()->getBaseUrl(true) . $model->product_url;
?>
<div style="width:765px;">
	<p>Товар: <b><a href="<?= $product_url ?>" target="_blank"><?= $model->product->product_name ?> <?= $model->modelName ?></a></b></p>
	<p>Имя: <?= $model->name ?></p>
	<?php if($model->email != '') { ?>
		<p>Email: <?= $model->email ?></p>
	<?php } ?>
	<p>Вопрос: <?= $model->comment ?></p>
</div>