<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->id,
);

//echo'<pre>';var_dump(Yii::app()->user->checkAccess('showListUsers'));echo'</pre>';
//echo'<pre>';var_dump(Yii::app()->user->checkAccess('updateOwnPost'));echo'</pre>';

if(Yii::app()->user->checkAccess('showPostOperations'))	{
$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	//array('label'=>'Create Post', 'url'=>array('create')),
	((Yii::app()->user->checkAccess('Post.Create')) ?	array('label'=>'Create Post', 'url'=>array('create'))  : null ),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	((Yii::app()->user->checkAccess('Post.Delete')) ? array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')): null ),
	((Yii::app()->user->checkAccess('Post.Admin')) ? array('label'=>'Manage Post', 'url'=>array('admin'))	:	null),
);
}	else	{
	$this->menu=array();
}
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(
            'label'=>'text',
            'type'=>'html',
        ),	
	
		'id',
		'authorId',
		'text',
	),
)); ?>
