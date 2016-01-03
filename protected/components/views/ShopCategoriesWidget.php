<div class="block menu-cat">

	<div class="head">
		<h3>Каталог</h3>
	</div>
	<div class="body">
		<? if($caregories_tree[0] != 'Не найдено') {	?>
		<? $this->widget('AadCMenu',array('items'=>$caregories_tree, 'activateParents' => true, 'htmlOptions' => array('class'=>'menu categories-menu', 'id'=>'categories-menu')));?>
		<?	}	else	{	?>
		<ul>
			<li><a href="javascript:void(0)"><?=$caregories_tree[0]?></a></li>
		</ul>
		<p class="error"></p>
		<?	}	?>
	</div>
	<? //$this->widget('zii.widgets.CMenu',array('items'=>$caregories_tree, 'activateParents' => true, 'htmlOptions' => array('class'=>'menu categories-menu', 'id'=>'categories-menu')));?>	
</div>