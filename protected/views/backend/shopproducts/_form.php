<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */
/* @var $form CActiveForm */

/*

$cs->registerScriptFile('/js/bootstrap-tab.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/bootstrap-tab-init.js', CClientScript::POS_END);
*/
$cs = Yii::app()->clientScript;

$cs->registerCssFile('/css/chosen.css', 'screen');
$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);

$cs->registerScript('loading', "
	$('#ShopProducts_hide_s_desc').bootstrapSwitch();
	$('#ShopProducts_protect_copy').bootstrapSwitch();
	$('#ShopProducts_published').bootstrapSwitch();
	$('#ShopProducts_override').bootstrapSwitch();
	$('#ShopProducts_featured').bootstrapSwitch();

	$('.chosen_select').chosen();
	
	$('#suggestions li').on('click', function(){
		//alert('12ws21');
	});
	
	$('#add-new-year').on('click', function(){
		$.ajax({
			type: 'post',
			url: '/admin.php?r=shopbodies/createajax',
			data: {ShopBodies_name : $('#ShopBodies_name').val(), ShopProducts_product_id : $('#ShopProducts_product_id').val()},
			dataType: 'json',
			beforeSend: function () {
				$('#msg-wr').hide();
			},
			success: function (msg) {
				if(msg.res == 'ok')	{
					$('#bodies-wr').html(msg.data);
					$('#bodies-wr select').chosen();
					
				}
				$('#msg-wr').html(msg.msg);
				$('#msg-wr').show();
			}
		});
		return false;
	});
");

//echo'<pre>';print_r($model->SelectedModels,0);echo'</pre>';
// скрываем блок исключения из моделей если товар не из "универсальных";

$style = '';
//$style = 'style="display:none;"';
//foreach($model->SelectedModels as $key=>$mod) {
//	if($key == Yii::app()->params['universal_products']) {
//		$style = '';
//		break;
//	}
//}
?>
<style>
	#cke_ShopProducts_product_s_desc #cke_1_top,
	#cke_ShopProducts_product_s_desc #cke_1_bottom
	{display:none;}
</style>
<div class="form product-edit-form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-products-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' =>	array(
		'enctype'=>'multipart/form-data',
	),
	
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->hiddenField($model,'product_id'); ?>

    <ul class="nav nav-tabs" id="myTab">
		<li><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Описание</a></li>
		<li><a href="#tab3" data-toggle="tab">Фото</a></li>
		<li><a href="#tab4" data-toggle="tab">Meta</a></li>
		<li><a href="#tab5" data-toggle="tab">Цены</a></li>
		<li><a href="#tab6" data-toggle="tab">Сопуствующие</a></li>
    </ul>
    

	
	<div class="tab-content">
		
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<?php echo $form->labelEx($model,'product_name'); ?>
				<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>180)); ?>
				<?php echo $form->error($model,'product_name'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'cargo_type'); ?>
				<?php echo $form->dropDownList($model, 'cargo_type', Delivery::model()->cargoTypesList, array('options' => $model->cargo_type, 'empty'=>'Выберите'));?>
				<?php echo $form->error($model,'cargo_type'); ?>
			</div>
			
			
            <div class="row">
				<div class="col-lg-6">
					<div class="chosen-row">
						<?php echo $form->labelEx($model,'model_ids'); ?>
						<?php echo $form->dropDownList($model, 'model_ids', $model->DropDownListModels, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите модель', 'style'=>'width:100%;', 'options' => $model->SelectedModels));?>
						<?php echo $form->error($model,'model_ids'); ?>
					</div>
				</div>               
				
				<div class="col-lg-6">
					<div class="chosen-row" <?= $style?> >
						<?php echo $form->labelEx($model,'model_ids_dis'); ?>
						<?php echo $form->dropDownList($model, 'model_ids_dis', $model->DropDownListModelsDisabled, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите модель', 'style'=>'width:100%;', 'options' => $model->SelectedModelsDisabled));?>
						<?php echo $form->error($model,'model_ids_dis'); ?>
					</div>
				</div>               
            </div>
			
            <div class="row chosen-row">
                <?php echo $form->labelEx($model,'category_ids'); ?>
                <?php echo $form->dropDownList($model, 'category_ids', $model->DropDownListCategories, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите категорию', 'style'=>'width:400px;', 'options' => $model->SelectedCategories));?>
                <?php echo $form->error($model,'category_ids'); ?>
            </div>
						
			<div class="row">
				<?php echo $form->labelEx($model,'type_id'); ?>
				<?php echo $form->dropDownList($model, 'type_id', $model->DropDownListTypes, array('data-placeholder'=>'выберите тип', 'options' => $model->SelectedTypeId));?>
				<?php echo $form->error($model,'type_id'); ?>
			</div>
			
			<div class="row chosen-row">
				<?php echo $form->labelEx($model,'body_ids'); ?>
				<div id="bodies-wr"><?php echo $form->dropDownList($model, 'body_ids', $model->DropDownListBodies, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите год', 'style'=>'width:100%;', 'options' => $model->SelectedBodies));?></div>
				<?php echo $form->error($model,'body_ids'); ?>
			</div>
			
			<div class="row chosen-row">
				<?php echo $form->labelEx($model,'engine_ids'); ?>
				<div id="bodies-wr"><?php echo $form->dropDownList($model, 'engine_ids', $model->DropDownListEngines, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите объем двигателя', 'style'=>'width:100%;', 'options' => $model->SelectedEngines));?></div>
				<?php echo $form->error($model,'engine_ids'); ?>
			</div>
			
			<? /*
			<div class="row">
				<input type="text" id="ShopBodies_name" name="ShopBodies[name]" />
				<?php echo BsHtml::submitButton('Добавить новый', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'add-new-year', 'id'=>'add-new-year')); ?>
				<span id="msg-wr"></span>
			</div>
			*/?>
			
			
			<div class="row chosen-row">
				<?php echo $form->labelEx($model,'admin_category_ids'); ?>
				<?php echo $form->dropDownList($model, 'admin_category_ids', $model->DropDownListAdminCategories, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите категорию', 'style'=>'width:400px;', 'options' => $model->SelectedAdminCategories));?>
				<?php echo $form->error($model,'admin_category_ids'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->checkBoxControlGroup($model, 'published'); ?>
				<?php echo $form->error($model,'published'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->checkBoxControlGroup($model, 'protect_copy'); ?>
				<?php echo $form->error($model,'protect_copy'); ?>
			</div>
					
					
						
			<?/*
			<div class="row">
				<?php echo $form->labelEx($model,'manufacturer_id'); ?>
				<?php echo $form->dropDownList($model, 'manufacturer_id', $model->DropDownListManufacturers, array('data-placeholder'=>'выберите категорию', 'options' => $model->SelectedManufacturerId));?>
				<?php echo $form->error($model,'manufacturer_id'); ?>
			</div>*/?>
		</div>
		
		<div class="tab-pane" id="tab2">
			<?/*
			<div class="row">
				<?php echo $form->labelEx($model,'manuf'); ?>
				<?php echo $form->textField($model,'manuf'); ?>
				<?php echo $form->error($model,'manuf'); ?>
			</div>
			*/?>
			
			<div class="row">
				<?php echo $form->labelEx($model,'firm_id'); ?>
				<?php echo $form->dropDownList($model, 'firm_id', $model->DropDownListFirms, array('data-placeholder'=>'выберите фирму', 'options' => $model->SelectedFirmId));?>
				<?php echo $form->error($model,'firm_id'); ?>
			</div>			
			
			<div class="row">
				<?php echo $form->labelEx($model,'product_sku'); ?>
				<?php echo $form->textField($model,'product_sku',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($model,'product_sku'); ?>
			</div>	
			
			<div class="row">
				<?php echo $form->labelEx($model,'manufacturer_sku'); ?>
				<?php echo $form->textField($model,'manufacturer_sku',array('size'=>60,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'manufacturer_sku'); ?>
			</div>	
			
			<div class="row">
				<?php echo $form->labelEx($model,'material'); ?>
				<?php echo $form->textField($model,'material'); ?>
				<?php echo $form->error($model,'material'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'side'); ?>
				<?php echo $form->dropDownList($model, 'side', $model->DropDownProductSide, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedProductSideId));?>
				<?php echo $form->error($model,'side'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'lamps'); ?>
				<?php echo $form->textArea($model,'lamps'); ?>
				<?php echo $form->error($model,'lamps'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'adjustment'); ?>
				<?php echo $form->textField($model,'adjustment'); ?>
				<?php echo $form->error($model,'adjustment'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'product_s_desc'); ?>
				<?php echo $form->textArea($model,'product_s_desc'); ?>
				<?php echo $form->error($model,'product_s_desc'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->checkBoxControlGroup($model, 'hide_s_desc'); ?>
				<?php echo $form->error($model,'hide_s_desc'); ?>
			</div>			
			
			<?
			/*
			<div class="row">
				<?php echo $form->labelEx($model,'code'); ?>
				<?php echo $form->textField($model,'code'); ?>
				<?php echo $form->error($model,'code'); ?>
			</div>
			*/
			?>
			
			<?
			/*
			<div class="row">
				<?php echo $form->labelEx($model,'in_stock'); ?>
				<?php echo $form->textField($model,'in_stock'); ?>
				<?php echo $form->error($model,'in_stock'); ?>
			</div>
			*/
			?>
			
			<div class="row">
				<?php echo $form->labelEx($model,'product_availability'); ?>
				<?php echo $form->dropDownList($model, 'product_availability', $model->DropDownProductAvailability, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedProductAvailabilityId));?>
				<?php echo $form->error($model,'product_availability'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'delivery'); ?>
				<?php echo $form->textField($model,'delivery'); ?>
				<?php echo $form->error($model,'delivery'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'prepayment'); ?>
				<?php echo $form->textField($model,'prepayment'); ?>
				<?php echo $form->error($model,'prepayment'); ?>
			</div>
			
            <?/*			
			<div class="row">
				<?php echo $form->labelEx($model,'product_s_desc'); ?>
				<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
					  'model'=>$model,
					  'attribute'=>'product_s_desc',
					  'language'=>'ru',
					  'editorTemplate'=>'full',
					  'height'=>'200px'
				)); ?>
				<?php echo $form->error($model,'product_s_desc'); ?>
			</div>
*/?>			
			
			<div class="row">
				<?php echo $form->labelEx($model,'product_desc'); ?>
				<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
					  'model'=>$model,
					  'attribute'=>'product_desc',
					  'language'=>'ru',
					  'editorTemplate'=>'full',
					  'height'=>'400px',
				)); ?>	
				<?php echo $form->error($model,'product_desc'); ?>
			</div>
			
			<div class="row">
				<?php echo $form->labelEx($model,'installation'); ?>
				<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
					  'model'=>$model,
					  'attribute'=>'installation',
					  'language'=>'ru',
					  'editorTemplate'=>'full',
					  'height'=>'200px'
				)); ?>	
				<?php echo $form->error($model,'installation'); ?>
			</div>
			
		</div>
		
		<div class="tab-pane" id="tab3">
<?
			//echo'<pre>';print_r($params,0);echo'</pre>';
			//echo'<pre>';print_r($params,0);echo'</pre>';
			//print_r($model->Images)
			
?>		<div class="row product-images-list">
			<ul>
				<?php 
				foreach($model->Images as $img) {
					$checked = $img->main_foto ? true : false;

					echo BsHtml::openTag('li', array('class'=>'col-lg-3 col-md-3'));				
					echo BsHtml::imageThumbnail($params->product_images_liveUrl.'thumb_'.$img->image_file);
					echo BsHtml::radioButton('main_foto', $checked, array('value' => $img->image_id, 'id' => 'main_foto_'.$img->image_id));
					echo BsHtml::label('основное фото', 'main_foto_'.$img->image_id, array('class' => 'radio_label'));
					echo '<br />';
					echo BsHtml::submitButton('Удалить фото', array('name'=>'delete_foto['.$img->image_id.']'));

					echo BsHtml::closeTag('li');
				}
				?>
			</ul>
		</div>
		<fieldset>
			<legend>Добавить фото</legend>
			<input type="checkbox" value="1" name="no_watermark" id="no_watermark" /> <label for="no_watermark">Без водяного знака</label>
			<?php echo BsHtml::activeFileField($model, 'uploading_foto'); ?>				
		</fieldset>
			
		</div>
		
		<div class="tab-pane" id="tab4">
			<div class="row">
				<?php echo $form->labelEx($model,'metatitle'); ?>
				<?php echo $form->textField($model,'metatitle',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'metatitle'); ?>
			</div>
		
			<div class="row">
				<?php echo $form->labelEx($model,'metakey'); ?>
				<?php echo $form->textField($model,'metakey',array('size'=>60,'maxlength'=>192)); ?>
				<?php echo $form->error($model,'metakey'); ?>
			</div>

			<div class="row">
				<?php echo $form->label($model,'metadesc'); ?>
				<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'metadesc'); ?>		
			</div>
			
			
		</div>
		
		<div class="tab-pane" id="tab5">
			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'product_price'); ?>
					<?php echo $form->textField($model,'product_price',array('size'=>60,'maxlength'=>180)); ?>
					<?php echo $form->error($model,'product_price'); ?>					
				</div>
				<div class="col-lg-2">
					<?php echo $form->labelEx($model,'currency_id'); ?>
					<?php echo $form->dropDownList($model, 'currency_id', Currencies::model()->dropDownCurrenciesList, array('options' => $model->currency_id));?>
					<?php echo $form->error($model,'currency_id'); ?>					
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<?php echo $form->labelEx($model,'product_override_price'); ?>
					<?php echo $form->textField($model,'product_override_price',array('size'=>60,'maxlength'=>180)); ?>
					<?php echo $form->error($model,'product_override_price'); ?>
				</div>
			</div>
		
			<div class="row">
				<div class="col-lg-12">
					<?php echo $form->checkBoxControlGroup($model, 'override'); ?>
					<?php echo $form->error($model,'override'); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<?php echo $form->checkBoxControlGroup($model, 'featured'); ?>
					<?php echo $form->error($model,'featured'); ?>
				</div>
			</div>
						
			
		
		</div>
		
		<div class="tab-pane" id="tab6">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<? /*<input type="text" name="search_string" id="library-search-string" value="" onkeyup="lookup(this.value);" autocomplete="off" /> */ ?>
					<?php echo BsHtml::textField('search_string', '', array('id'=>"library-search-string", "onkeyup" => "lookup(this.value);", "autocomplete"=> "off")) ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<ul id="related-products-list" class="related-list">
					<?
						$ProductsRelated = $model->ProductsRelations;
						//echo'<pre>';print_r($ProductsRelated[0]->product);echo'</pre>';
						if(count($ProductsRelated))	{
							foreach($ProductsRelated as $item)	{
								$row = $item->productRelated;
								echo BsHtml::openTag('li');
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
						}
					?>
					</ul>
				</div>
			</div>

			<script type="text/javascript">
					function lookup(inputString) {
							if(inputString.length == 0) {
									// Hide the suggestion box.
									$('#suggestions').hide();
							} else {
								$('#suggestions').hide();
									$.get("/admin.php?r=shopproducts/searchajax", {str: ""+inputString+""}, function(data){
											//console.log(data.length);
											if(data.length > 0) {
													$('#suggestions').show();
													$('#autoSuggestionsList').html(data);
											}	else	{
												$('#autoSuggestionsList').html(data);
											}
									});
							}
					} // lookup

					function fill(el) {
						$('#related-products-list').append(el);
						$('#related-products-list li').each(function(){
							$(this).removeAttr('onclick');
						})
							
						setTimeout("$('#suggestions').hide();", 200);
					}
				
				function delete_position(el) {
					$(el).parent().parent().remove();
				}
			</script>
		
		</div>
	</div>





	<div class="row buttons">
		<div class="col-lg-12">
			<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
			<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
			<?php echo BsHtml::submitButton('Отмена', array('name'=>'cancel')); ?>		
		</div>
	</div>
	
	<input type="hidden" name="current-tab" id="current-tab" value="<?=$current_tab?>" />
<?php $this->endWidget(); ?>

<div class="suggestionsBox" id="suggestions" style="display: none;">
	<div class="suggestionList" id="autoSuggestionsList"></div>
</div>


</div><!-- form -->