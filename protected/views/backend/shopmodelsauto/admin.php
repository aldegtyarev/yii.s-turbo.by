<?php
/* @var $this ShopModelsAutoController */
/* @var $model ShopModelsAuto */

$this->breadcrumbs=array(
	//'Shop Models Autos'=>array('index'),
	'Модельный ряд',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shop-models-auto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Модельный ряд</h1>
<?
/*
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
*/
?>

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'select-category',
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<?php echo BsHtml::dropDownList('selected_category', $SelectedCategory, $DropDownCategories, array('onchange'=>'form.submit()')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
/*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shop-models-auto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'parent_id',
		/*
		'name',
		'title',
		'keywords',
		'description',
		'alias',
		'path',
		'ordering',
		'category_companies',
		'cat_column',
		'anchor_css',
		'show_in_menu',
		'category_description',
		*//*
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
*/

$this->widget('ext.CQTreeBsGridView', array(
    'id' => 'shop-models-auto-grid',
    'dataProvider' => $model->search(),
	'columns'=>array(
		'id',
		'name'=>array(
			'name'=>'name',
			'type'=>'html'
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',
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
					'url' => 'Yii::app()->createUrl("shopmodelsauto/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("shopmodelsauto/movedown", array("id"=>$data->id))',
				),
			),
		),
	),
));

?>
