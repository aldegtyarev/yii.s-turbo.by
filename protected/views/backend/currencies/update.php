<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Список валют'=>array('admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Список валют', 'url'=>array('admin')),
	array('label'=>'Добавить', 'url'=>array('create')),
	
);
?>

<h1>Редактирование <?php echo $model->currency_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>