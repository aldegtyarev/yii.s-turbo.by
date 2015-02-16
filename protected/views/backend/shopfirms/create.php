<?php
/* @var $this ShopFirmsController */
/* @var $model ShopFirms */

$this->breadcrumbs=array(
	'Фирмы'=>array('admin'),
	'Новый',
);

$this->menu=array(
	//array('label'=>'List ShopFirms', 'url'=>array('index')),
	array('label'=>'Фирмы', 'url'=>array('admin')),
);
?>

<h1>Новый</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>