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

<h1>Manage Engines</h1>

<div class="row">
	<div class="col-lg-6 col-md-6">
		<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
			'id'=>'select-model',
			'enableAjaxValidation'=>false,
		)); ?>
			<p>Модельный ряд</p>
			<?php echo BsHtml::dropDownList('selected_model', $SelectedModel, $model->DropDownListModels, array('onchange'=>'form.submit()')); ?>

		<?php $this->endWidget(); ?>			
	</div>

</div>


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
			//'template' => '{update}&nbsp;{delete}&nbsp;{copy}',
			'template' => '{update}&nbsp;{delete}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),
				/*
				'copy' => array(
					'label'=>'Доблировать',
					'imageUrl'=>'/img/grid-icons/copy.png',
					'url' => 'Yii::app()->createUrl("engines/copy", array("id"=>$data->id))',
				),
				*/
				
			),
		),
	),
)); ?>

