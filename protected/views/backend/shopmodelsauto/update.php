<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->pageTitle = 'Редактирование "'.$model->name.'"';

$this->breadcrumbs=array(
	'Модельный ряд'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Редактирование "'.$model->name.'"',
);


$this->menu=array(
	//array('label'=>'List CatalogCategories', 'url'=>array('index')),
	array('label'=>'Модельный ряд', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),
	//array('label'=>'View CatalogCategories', 'url'=>array('view', 'id'=>$model->id)),
	
);
?>

<h1>Редактирование "<?php echo $model->name; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>