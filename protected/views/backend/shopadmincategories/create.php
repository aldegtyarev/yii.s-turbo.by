<?php
/* @var $this ShopadmincategoriesController */
/* @var $model ShopAdminCategories */

$this->breadcrumbs=array(
	'Адм. категории'=>array('admin'),
	'Новый',
);

$this->menu=array(
	array('label'=>'Адм. категории', 'url'=>array('admin')),
);
?>

<h1>Новая адм. категория</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>