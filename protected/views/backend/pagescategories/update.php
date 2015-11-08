<?php
/* @var $this PagescategoriesController */
/* @var $model PagesCategories */

$this->breadcrumbs=array(
	'Категории страниц'=>array('admin'),
	'Изменить '.$model->name,
);


$this->menu=array(
	array('label'=>'Категории страниц', 'url'=>array('admin')),
	array('label'=>'Новая', 'url'=>array('create')),
);

?>

<h1>Изменить <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>