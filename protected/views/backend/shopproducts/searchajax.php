<? if(count($rows))	{	?>
<ul class="related-list">
	<? 
		foreach($rows as $row) 	{
			echo BsHtml::openTag('li', array('class'=>'', 'onclick'=>'fill(this);'));
			echo BsHtml::openTag('div', array('class'=>'related-list-item'));
			echo BsHtml::image($params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.gif'));
			echo $row->product_name;
			echo '<br />';
			echo $row->product_sku;;
			//echo BsHtml::radioButton('main_foto', $checked, array('value' => $img->image_id, 'id' => 'main_foto_'.$img->image_id));
			//echo BsHtml::label('основное фото', 'main_foto_'.$img->image_id, array('class' => 'radio_label'));
			echo '<input type="hidden" name="related_product_ids[]" value="'.$row->product_id.'">';
			echo BsHtml::image("/img/grid-icons/delete.png", "Удалить", array('class'=>'delete-ico', 'onclick'=>'delete_position(this);'));
			
			//echo BsHtml::submitButton('Удалить фото', array('name'=>'delete_foto['.$img->image_id.']'));

			echo BsHtml::closeTag('div');
			echo BsHtml::closeTag('li');
			
		}
	?>
</ul>
<?	}	?>