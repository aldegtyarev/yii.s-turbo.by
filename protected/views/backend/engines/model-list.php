<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	$model_title => array('shopmodelsauto/update', 'id'=>$model_id),
	'Двигатели',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('createtomodel', 'id'=>$model_id)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#engines-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список двигателей для <?= $model_title ?></h1>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name'=>array(
			'name'=>'name',
			'type'=>'html'
		),


		array(
			'class' => 'CButtonColumn',
			/*'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',*/
			'template' => '{update}&nbsp;{delete}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
					'url' => 'Yii::app()->createUrl("engines/updatetomodel", array("id"=>$data->id))',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),
			),
		),
	),
)); ?>
