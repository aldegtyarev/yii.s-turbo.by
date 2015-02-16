<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Страницы'=>array('admin'),
	'Новая',
);

$this->menu=array(
	//array('label'=>'List Pages', 'url'=>array('index')),
	array('label'=>'Страницы', 'url'=>array('admin')),
);
?>

<h1>Новая</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>