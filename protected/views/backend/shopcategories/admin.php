<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Категории магазина'
);

$this->menu=array(
	//array('label'=>'List Categories', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Категории магазина</h1>

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

<?
/*
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/
?>

<?php 
/*
	//$this->widget('zii.widgets.grid.CGridView', array(
	//$this->widget('ext.QTreeGridView.CQTreeGridView', array(
	$this->widget('ext.CQTreeGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile' => '/css/CGridView/styles.css',
	//'ajaxUpdate' => false,
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
					'url' => 'Yii::app()->createUrl("shopcategories/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("shopcategories/movedown", array("id"=>$data->id))',
				),
			),
		),
	),
)); 
*/
?>




            
<?php
//$this->widget('bootstrap.widgets.BsGridView', array(
$this->widget('ext.CQTreeBsGridView', array(
    'id' => 'categories-grid',
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
					'url' => 'Yii::app()->createUrl("shopcategories/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("shopcategories/movedown", array("id"=>$data->id))',
				),
			),
		),
	),
));

    ?>
        
    


