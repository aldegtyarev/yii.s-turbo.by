<?
/** @var dpsEmailController $this */
/** @var ProductCommentsForm $model */
$this->setSubject('Ответ на Ваш вопрос'); // указываем тему
$product_url = Yii::app()->getBaseUrl(true) . $model->product_url . '#questions-itm-' . $model->id;
?>
<div style="width:765px;">
	<p style="font-family:Arial, sans-serif;">Здравствуйте, <?= $model->name ?>. Администратор ответил на Ваш вопрос о товаре <br><br><b><?= $model->product->product_name ?> <?= $model->modelName ?></b></p>
	<p style="font-family:Arial, sans-serif;">Вы можете с ним ознакомиться, перейдя по <a href="<?= $product_url ?>" target="_blank">ссылке</a></p>

	<p style="font-family:Arial, sans-serif;">С уважением, <a href="<?= Yii::app()->getBaseUrl(true)?>"><?= Yii::app()->name ?></a></p>

	<? $this->renderPartial('_email-footer') ?>
</div>