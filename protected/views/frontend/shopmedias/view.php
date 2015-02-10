<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */

$this->breadcrumbs=array(
	'Shop Mediases'=>array('index'),
	$model->virtuemart_media_id,
);

$this->menu=array(
	array('label'=>'List ShopMedias', 'url'=>array('index')),
	array('label'=>'Create ShopMedias', 'url'=>array('create')),
	array('label'=>'Update ShopMedias', 'url'=>array('update', 'id'=>$model->virtuemart_media_id)),
	array('label'=>'Delete ShopMedias', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->virtuemart_media_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShopMedias', 'url'=>array('admin')),
);
?>

<h1>View ShopMedias #<?php echo $model->virtuemart_media_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'virtuemart_media_id',
		'file_title',
		'file_description',
		'file_meta',
		'file_mimetype',
		'file_type',
		'file_url',
		'file_url_thumb',
		'file_is_product_image',
		'file_is_downloadable',
		'file_is_forSale',
		'file_params',
		'shared',
		'published',
		'created_on',
		'created_by',
	),
)); ?>
