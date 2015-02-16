<?php
/* @var $this ShopMediasController */
/* @var $model ShopMedias */

$this->breadcrumbs=array(
	'Shop Mediases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ShopMedias', 'url'=>array('index')),
	array('label'=>'Create ShopMedias', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shop-medias-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Shop Mediases</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shop-medias-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'virtuemart_media_id',
		'file_title',
		'file_description',
		'file_meta',
		'file_mimetype',
		'file_type',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
