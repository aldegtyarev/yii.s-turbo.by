<?php
/* @var $this ShopFirmsCategoryController */
/* @var $model ShopFirmsCategory */


$this->pageTitle = 'Новая группа фирм';

$this->breadcrumbs=array(
	'Группы фирм'=>array('admin'),
	'Новая',
);

$this->menu=array(
	array('label'=>'Группы фирм', 'url'=>array('admin')),
);
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>