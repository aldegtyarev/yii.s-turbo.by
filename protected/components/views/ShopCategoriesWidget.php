<div class="block menu-cat">
	<div class="head">
		<h3>Каталог</h3>
	</div>
	<div class="body">
		<? $this->widget('AadCMenu',array('items'=>$caregories_tree, 'activateParents' => true, 'htmlOptions' => array('class'=>'menu categories-menu', 'id'=>'categories-menu')));?>
	</div>
	<? //$this->widget('zii.widgets.CMenu',array('items'=>$caregories_tree, 'activateParents' => true, 'htmlOptions' => array('class'=>'menu categories-menu', 'id'=>'categories-menu')));?>	
</div>