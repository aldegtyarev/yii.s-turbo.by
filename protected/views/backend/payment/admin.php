<?php
/* @var $this DeliveryController */
/* @var $model Delivery */

$this->breadcrumbs=array(
	'Способы оплаты',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#delivery-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Способы оплаты</h1>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'delivery-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		//'options',
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