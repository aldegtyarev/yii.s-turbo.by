<?php
$app = Yii::app();
$tab_id = $app->request->getParam('tab', 1);

?>


<div class="page-cnt page-modal <?=$current_controller . '-' . $current_action?>">
	<script>
		$(document).ready(function () {
			function switch_tabs(obj)
			{
				$('.tab-pane').hide();
				$('.nav-tabs li').removeClass("selected");
				var id = obj.attr("href");
				$(id).show();
				obj.parent().addClass("selected");
			}			
			
			$('.nav-tabs a').on('click', function(){
				switch_tabs(jQuery(this));
				return false
			});

			switch_tabs($('.nav-tabs #tab-<?= $tab_id ?>'));

		});
	</script>
	
	<h2><?php echo $model->name; ?></h2>

	<? echo $model->text; ?>
</div>
