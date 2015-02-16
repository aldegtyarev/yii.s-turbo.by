<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs=array(
	//'Shop Products'=>array('index'),
	'Список товаров',
);

$this->menu=array(
	//array('label'=>'List ShopProducts', 'url'=>array('index')),
	array('label'=>'Новый', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shop-products-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
//echo'<pre>';print_r($SelectedCategory);echo'</pre>';
?>

<h1>Список товаров</h1>

<?
/*
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/
?>
	<div class="row">
		<div class="col-lg-6 col-md-6">
			<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
				'id'=>'select-category',
				'enableAjaxValidation'=>false,
			)); ?>
				<p>Категории</p>
				<?php echo BsHtml::dropDownList('selected_category', $SelectedCategory, $DropDownCategories, array('onchange'=>'form.submit()')); ?>
			
			<?php $this->endWidget(); ?>			
		</div>
		
		<div class="col-lg-6 col-md-6">
			<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
				'id'=>'select-model',
				'enableAjaxValidation'=>false,
			)); ?>
				<p>Модельный ряд</p>
				<?php echo BsHtml::dropDownList('selected_model', $SelectedModel, $DropDownModels, array('onchange'=>'form.submit()')); ?>
			
			<?php $this->endWidget(); ?>			
		</div>
		
	</div>



<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'shop-products-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate' => false,
	'columns'=>array(
		'product_id',
		'product_name',
		'product_sku',
		array(
			'class' => 'CButtonColumn',
			//'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',
			'template' => '{update}&nbsp;{delete}&nbsp;{copy}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),
					
				'copy' => array(
					'imageUrl'=>'/img/grid-icons/copy.png',
					'url' => 'Yii::app()->createUrl("shopproducts/copy", array("id"=>$data->product_id))',
				),
			),
		),
	),
)); ?>
