<?php /* @var $this Controller */ 


$images_live_url = Yii::app()->params->images_live_url;

?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="sidebar sideLeft">
	<?php $this->widget('application.components.ShopCategoriesWidget'); ?>
	<?
	/*
	<div id="menu-tabs" class="menu-tabs">
	
		<ul class="tabs clearfix">
			<li class="catalog"><a href="javascript:void(0);" rel="tab-shop" class="defaultTab">Каталог</a></li>
			<li class="companies"><a href="javascript:void(0);" rel="tab-companies">Компании</a></li>
		</ul>
		<div class="tab-content" id="tab-shop">
			<div class="tab-content-wr">
				
			</div>
		</div>
		<div class="tab-content" id="tab-companies">
			<div class="tab-content-wr">
				<?php $this->widget('application.components.CompaniesMenuWidget'); ?>
			</div>
		</div>
			
		
	</div>
	*/
	?>
	
	
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
	<div class="vk-widget-wrap">
		<!-- VK Widget -->
		<div id="vk_groups" class="vk_groups"></div>
		<script type="text/javascript">
		VK.Widgets.Group("vk_groups", {mode: 0, width: "180", height: "350"}, 38498818);
		</script>
	</div>
	
	<?php $this->widget('application.components.LastViewedProductsWidget'); ?>

</div>				
<div class="container">
	<div class="content column2l">
		<div id="content-wr" class="content-wr">
				<?php if(isset($this->breadcrumbs)):?>
						<?php $this->widget('zii.widgets.CBreadcrumbs', array(
							'links'=>$this->breadcrumbs,
						)); ?>
				<?php endif?>
			<div id="content-cnt">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>