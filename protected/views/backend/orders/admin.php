<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Create Orders', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список заказов</h1>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'orders-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width' => '80'),
        ),
        array(
            'name'=>'created',
            'value'=>'date("d.m.Y", $data->created)',
            'htmlOptions'=>array('width' => '40'),
        ),
		'summ_usd',
		'summ_byr',
		array(
			'class' => 'CButtonColumn',
			'template' => '{view}&nbsp;{delete}',
			'buttons' => array(
				'view' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),
			),
		),
	),
)); ?>
