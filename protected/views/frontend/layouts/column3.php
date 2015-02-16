<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="sidebar sideLeft">
	<?php $this->widget('application.components.ShopCategoriesWidget'); ?>
</div>				
<div class="container">
	<div class="content column3">
		<?php echo $content; ?>
	</div>
</div>
<div class="sidebar sideRight">
	Right side bar
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
</div>


<?php $this->endContent(); ?>