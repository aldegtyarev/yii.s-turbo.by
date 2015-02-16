<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Companies', 'url'=>array('index')),
	array('label'=>'Create Companies', 'url'=>array('create')),
	array('label'=>'Update Companies', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Companies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h1>View Companies #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'alias',
		'published',
		'introtext',
		'fulltext',
		'created',
		'user_id',
		'trash',
		'ordering',
		'featured',
		'featured_ordering',
		'hits',
		'params',
		'metadesc',
		'metadata',
		'metakey',
		'section',
		'region',
		'city',
		'address',
		'email',
		'site',
		'phone_mts',
		'phone_vel',
		'phone',
		'subscribers',
		'company_comments',
		'company_rating',
	),
)); ?>
