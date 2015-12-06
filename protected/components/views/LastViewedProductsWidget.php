<div class="last-viewed-block">
	<div class="header-wr">
		<h3>Вы недавно просматривали</h3>
	</div>
	
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view-last-viewed',
		'ajaxUpdate'=>false,
		'template'=>"{items}",
		'itemsCssClass' => 'last-viewed-list clearfix',
		'id'=>'last-viewed-list-view',
		'viewData'=>array(
			'currency_info' => $currency_info,
		),
	
	)); ?>
	
	<a href="<?=$this->controller->createUrl('shopproducts/lastviewed')?>" class="all-items" rel="nofollow">Что еще смотрели?</a>
</div>