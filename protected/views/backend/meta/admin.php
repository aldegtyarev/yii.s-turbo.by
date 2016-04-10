<?php
/* @var $this MetaController */
/* @var $model Meta */

$this->breadcrumbs=array(
	'Meta'
);

$this->menu=array(
	array('label'=>'Meta', 'url'=>array('admin')),
	array('label'=>'Создать', 'url'=>array('create')),
);

?>

<h1>Справочник Meta</h1>

<? $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'meta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'published',
		array(
			'class' => 'CButtonColumn',
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
