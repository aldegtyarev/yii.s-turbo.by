<?php
/* @var $this PagescategoriesController */
/* @var $model PagesCategories */

$this->breadcrumbs=array(
	'Категории страниц',
);

$this->menu=array(
	array('label'=>'Новая', 'url'=>array('create')),
);

?>

<h1>Категории страниц</h1>


<? $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'pages-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		//'alias',
		//'descr',
		//'metatitle',
		//'metakey',
		/*
		'metadesc',
		*/
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
