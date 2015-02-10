<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */

$this->breadcrumbs=array(
	'Shop Mediases'=>array('index'),
	$model->virtuemart_media_id=>array('view','id'=>$model->virtuemart_media_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShopMedias', 'url'=>array('index')),
	array('label'=>'Create ShopMedias', 'url'=>array('create')),
	array('label'=>'View ShopMedias', 'url'=>array('view', 'id'=>$model->virtuemart_media_id)),
	array('label'=>'Manage ShopMedias', 'url'=>array('admin')),
);
?>

<h1>Update ShopMedias <?php echo $model->virtuemart_media_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>