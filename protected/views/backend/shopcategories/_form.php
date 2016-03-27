<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php //$form=$this->beginWidget('CActiveForm', array(
 $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'categories-form',
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

    <ul class="nav nav-tabs" id="myTab">
		<li><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Meta</a></li>
    </ul>
	<div class="tab-content">
	
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-lg-12">
					<?php echo $form->labelEx($model,'dropDownListTree'); ?>
					<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData); ?>
					<?php echo $form->error($model,'dropDownListTree'); ?>		
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($model,'name'); ?>
				</div>
				
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'name1'); ?>
					<?php echo $form->textField($model,'name1',array('size'=>60,'maxlength'=>255)); ?>
					<?php echo $form->error($model,'name1'); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'currency_id'); ?>
					<?php echo $form->dropDownList($model, 'currency_id', Currencies::model()->dropDownCurrenciesList, array('options' => $model->currency_id));?>
					<?php echo $form->error($model,'currency_id'); ?>					
				</div>
				<div class="col-lg-6">
					<?php echo $form->labelEx($model,'cargo_type'); ?>
					<?php echo $form->dropDownList($model, 'cargo_type', Delivery::model()->cargoTypesList, array('options' => $model->cargo_type, 'empty'=>'Выберите'));?>
					<?php echo $form->error($model,'cargo_type'); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<div style="padding-left: 20px;">
						<?php echo $form->checkBoxControlGroup($model, 'uni'); ?>
						<?php echo $form->error($model,'uni'); ?>
					</div>
				</div>			
			</div>

			<fieldset>
				<legend>Связанные категории</legend>
				<?php if(count($model->сategoriesRelated) != 0)	{	?>
					<table class="items table table-striped table-bordered">
						<tr>
							<th>Категория</th>
							<th>Модель</th>
							<th style="width: 80px"></th>
						</tr>
						<?php foreach ($model->сategoriesRelated as $item)	{	?>
							<tr>
								<td><?= $item->categoryRelated->name ?></td>
								<td><ul><?php foreach($item->categoriesRelationsModels as $model_item) echo '<li>'. ShopModelsAuto::model()->getModelChain($model_item->model_id) .'</li>' ?></ul></td>
								<td class="button-column">
									<a class="update" title="Редактировать" href="<?= $this->createUrl('relatedupdate', array('id'=>$item->id)) ?>">
										<img src="/img/grid-icons/update.png" alt="Редактировать">
									</a>
									<a class="delete" title="Удалить" href="<?= $this->createUrl('relateddelete', array('id'=>$item->id)) ?>">
										<img src="/img/grid-icons/delete.png" alt="Удалить">
									</a>
								</td>
							</tr>
						<?php }	?>
					</table>

				<?php }	?>

				<div class="row">
					<div class="col-lg-6">
						<a href="<?= $this->createUrl('relatedadd', array('id'=>$model->id)) ?>"  class="btn btn-primary">Добавить связанную категорию</a>
					</div>
				</div>
			</fieldset>

			


			<?php if($model->foto != '')	{	?>
				<img src="<?= Yii::app()->params->category_images_liveUrl . 'thumb_'.$model->foto ?>" alt="">
				<p><a href="<?= $this->createUrl('removefoto', array('id'=>$model->id))?>">Удалить фото</a></p>
			<?php	}	?>
			<fieldset>
				<legend>Добавить фото</legend>
				<input type="checkbox" value="1" name="no_watermark" id="no_watermark" /> <label for="no_watermark">Без водяного знака</label>
				<?php echo BsHtml::activeFileField($model, 'uploading_foto'); ?>			
			</fieldset>
			
			
<?
/*
			<div class="row">
				<?php echo $form->labelEx($model,'alias'); ?>
				<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'alias'); ?>
			</div>
*/
?>
			
			<div class="row">
				<?php echo $form->labelEx($model,'category_description'); ?>
				<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
					  'model'=>$model,
					  'attribute'=>'category_description',
					  'language'=>'ru',
					  'editorTemplate'=>'full',
					  'height'=>'200px'
				)); ?>	
				<?php echo $form->error($model,'category_description'); ?>
			</div>
			
		
		</div>

		<div class="tab-pane" id="tab2">
			<div class="row">
				<?php echo $form->labelEx($model,'metatitle'); ?>
				<?php echo $form->textField($model,'metatitle',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'metatitle'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'metakey'); ?>
				<?php echo $form->textArea($model,'metakey',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'metakey'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'metadesc'); ?>
				<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'metadesc'); ?>
			</div>
		</div>
	</div>
	
	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->