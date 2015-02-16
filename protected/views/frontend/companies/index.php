<?php
/* @var $this CompaniesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies',
);

$this->menu=array(
	array('label'=>'Create Companies', 'url'=>array('create')),
	array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h1>Companies</h1>

<?php 
	/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
*/


?>
<div class="companies-list">
	<ul>
		<? foreach($company_info['rows'] as $row) {	?>
			<li class="clearfix">
				<? echo $row->title ?>
			</li>
		<?	}	?>
	</ul>
<?php 

$this->widget('CLinkPager', array(	
	'header' => '', 
	'pages' => $company_info['pages'], 
	'id' => 'pages', 
	'nextPageLabel'=> '>',
	'prevPageLabel'=> '<',
	//'cssFile'=>'/css/pager.css',
));

?>
	
</div>