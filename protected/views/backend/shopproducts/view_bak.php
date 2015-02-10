<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs=array(
	'Shop Products'=>array('index'),
	$model->product_id,
);

$this->menu=array(
	array('label'=>'List ShopProducts', 'url'=>array('index')),
	array('label'=>'Create ShopProducts', 'url'=>array('create')),
	array('label'=>'Update ShopProducts', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Delete ShopProducts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopProducts', 'url'=>array('admin')),
);
?>

<h1>View ShopProducts #<?php echo $model->product_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'product_s_desc',
		'product_desc',
		'product_name',
		'product_name_manual',
		'product_sku',
		'metadesc',
		'metakey',
		'customtitle',
		'slug',
		'product_video',
		'product_charact',
		'product_brand_id',
		'product_type_id',
		'for_dogs',
		'protect_copy',
		'product_in_stock',
		'product_ordered',
	),
)); ?>
