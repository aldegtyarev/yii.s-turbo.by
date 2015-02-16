<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->pageTitle = 'Редактирование "'.$model->name.'"';

$this->breadcrumbs=array(
	'Список категорий'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Редактирование "'.$model->name.'"',
);


$this->menu=array(
	//array('label'=>'List CatalogCategories', 'url'=>array('index')),
	array('label'=>'Список категорий', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),
	//array('label'=>'View CatalogCategories', 'url'=>array('view', 'id'=>$model->id)),
	
);
?>

<h1>Редактирование "<?php echo $model->name; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>