<?php
/* @var $this CompaniesCategoriesController */
/* @var $model CompaniesCategories */

$this->breadcrumbs=array(
	'Companies Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CompaniesCategories', 'url'=>array('index')),
	array('label'=>'Create CompaniesCategories', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#companies-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Companies Categories</h1>

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
	'id'=>'companies-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'name',
		/*
		'title',
		'keywords',
		'description',
		'alias',
		'ordering',
		'category_companies',
		'cat_column',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
