<?php
/* @var $this PagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	$model->name,
);

MetaHelper::setMeta($this, $model);
?>

<h1><?= $model->name ?></h1>

<?	if (count($dataProvider->data)) {	?>	
	<div class="category-products-list pages-list">		
		<? 
			$this->renderPartial('_loop', array(
				'app'=>$app,
				'dataProvider'=>$dataProvider,
				'url_path'=>$url_path,
			));						 
		?>
	</div>		
<?	}	?>