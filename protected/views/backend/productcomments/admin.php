<?php
/* @var $this ProductcommentsController */
/* @var $model ProductComments */

$this->breadcrumbs=array(
	'Комметарии к товарам',
);

$this->menu=array(
	array('label'=>'List ProductComments', 'url'=>array('index')),
	array('label'=>'Create ProductComments', 'url'=>array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#product-comments-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Комметарии к товарам</h1>

<?/*
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/?>

<?php $this->widget('bootstrap.widgets.BsGridView', array(
	'id'=>'product-comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	    
        array(
            'name' =>'id',
            'headerHtmlOptions' => array(
                'class' => 'id_column',
            ),
        ),

		array(
			'name' =>'product_id',
			'type'=>'raw',

			'value'=>function($data,$row){ // declare signature so that we can use $data, and $row within this function
				return '<a href="http://s-turbo.by'.$data->product_url.'" target="_blank">'.$data->product->product_name.'</a>';
			}
		),

		'name',
		'email',

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
