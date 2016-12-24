<?php
/* @var $this ShopFirmsCategoryController */
/* @var $model ShopFirmsCategory */

$this->pageTitle = 'Группы фирм';
$this->breadcrumbs=array(
	$this->pageTitle,
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
	$('#shop-firms-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'shop-firms-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
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
