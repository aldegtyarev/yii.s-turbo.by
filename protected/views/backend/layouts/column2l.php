<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="sidebar" id="sideLeft">
	<?php $this->widget('application.components.ShopCategoriesWidget'); ?>
</div>				
<div id="container">
	<div id="content" class="column2l">
		<div id="content">
			<?php echo $content; ?>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>