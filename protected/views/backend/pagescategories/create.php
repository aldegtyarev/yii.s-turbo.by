<?php
/* @var $this PagescategoriesController */
/* @var $model PagesCategories */

$this->breadcrumbs=array(
	'Категории страниц'=>array('admin'),
	'Новая',
);

$this->menu=array(
	array('label'=>'Категории страниц', 'url'=>array('admin')),
);
?>

<h1>Новая категория</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>