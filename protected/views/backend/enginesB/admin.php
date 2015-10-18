<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Engines'=>array('index'),
	'Manage',
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
	$('#engines-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Объемы двигателей</h1>

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


<?php $this->widget('ext.CQTreeBsGridView', array(
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
					'url' => 'Yii::app()->createUrl("engines/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("engines/movedown", array("id"=>$data->id))',
				),
				
			),
		),
	),
)); ?>
