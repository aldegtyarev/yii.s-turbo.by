<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	'Shop Models Autos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ShopModelsAuto', 'url'=>array('index')),
	array('label'=>'Create ShopModelsAuto', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shop-models-auto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Shop Models Autos</h1>

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
	'id'=>'shop-models-auto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'parent_id',
		/*
		'name',
		'title',
		'keywords',
		'description',
		'alias',
		'path',
		'ordering',
		'category_companies',
		'cat_column',
		'anchor_css',
		'show_in_menu',
		'category_description',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
