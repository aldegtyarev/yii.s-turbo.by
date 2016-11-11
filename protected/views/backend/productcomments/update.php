<?php
/* @var $this ProductcommentsController */
/* @var $model ProductComments */

$this->breadcrumbs=array(
	'Комментарии'=>array('admin'),
	'Редактирование отзыва',
);

$this->menu=array(
	array('label'=>'Комментарии', 'url'=>array('admin')),
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Отзыв для "<?php echo $model->product->product_name; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>