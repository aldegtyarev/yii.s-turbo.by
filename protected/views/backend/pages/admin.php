<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	//'Pages'=>array('index'),
	'Страницы',
);

$this->menu=array(
	//array('label'=>'List Pages', 'url'=>array('index')),
	array('label'=>'Новая', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pages-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Страницы</h1>

<?
/*
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
*/
?>
<?php //$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'pages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class' => 'CButtonColumn',
			//'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',
			'template' => '{update}&nbsp;{delete}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),					
			),
		),
	),
)); ?>
