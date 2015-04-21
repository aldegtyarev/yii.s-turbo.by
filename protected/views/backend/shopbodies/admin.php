<?php
/* @var $this ShopBodiesController */
/* @var $model ShopBodies */

$this->breadcrumbs=array(
	'Уточняющий год',
);

$this->menu=array(
	array('label'=>'Новый', 'url'=>array('create')),
);

?>

<h1>Уточняющий год</h1>

<?php $this->widget('ext.CQTreeBsGridView', array(
	'id'=>'shop-bodies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',
			//'template' => '{update}&nbsp;{delete}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),
					
				
				'moveup' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/uparrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("shopbodies/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("shopbodies/movedown", array("id"=>$data->id))',
				),
				
			),
		),
	),
)); ?>
