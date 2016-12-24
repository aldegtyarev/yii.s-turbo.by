<?php
/* @var $this ShopFirmsCategoryController */
/* @var $model ShopFirmsCategory */


$this->pageTitle = 'Редактирование: ' . $model->name;

$this->breadcrumbs=array(
    'Группы фирм'=>array('admin'),
    $this->pageTitle,
);

$this->menu=array(
    array('label'=>'Группы фирм', 'url'=>array('admin')),
    array('label'=>'Добавить', 'url'=>array('create')),

);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>