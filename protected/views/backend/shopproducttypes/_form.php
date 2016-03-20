<?php
/* @var $this ShopProductTypesController */
/* @var $model ShopProductTypes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-product-types-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'dropDownListTree'); ?>
			<?php echo $form->dropDownList($model, 'parentId', $model->DropDownlistData); ?>
			<?php echo $form->error($model,'dropDownListTree'); ?>		
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'cargo_type'); ?>
			<?php echo $form->dropDownList($model, 'cargo_type', Delivery::model()->cargoTypesList, array('options' => $model->cargo_type, 'empty'=>'Выберите'));?>
			<?php echo $form->error($model,'cargo_type'); ?>
		</div>
	</div>

	<fieldset>
		<legend>Связанные группы товаров</legend>
		<?php if(count($model->typesRelated) != 0)	{	?>
			<table class="items table table-striped table-bordered">
				<tr>
					<th>Группа</th>
					<th>Текст ссылки</th>
					<th>Целевая категория</th>
					<th>Модели</th>
					<th style="width: 80px"></th>
				</tr>
				<?php foreach ($model->typesRelated as $item)	{	?>
					<tr>
						<td><?= $item->typeRelated->name ?></td>
						<td><?= $item->name ?></td>
						<td><?= $item->category->name ?></td>
						<td><ul><?php foreach($item->typesRelationsModels as $model_item) echo '<li>'. ShopModelsAuto::model()->getModelChain($model_item->model_id) .'</li>' ?></ul></td>
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
				<a href="<?= $this->createUrl('relatedadd', array('id'=>$model->type_id)) ?>"  class="btn btn-primary">Добавить связанную группу</a>
			</div>
		</div>
	</fieldset>

	

	<div class="row buttons">
		<div class="col-lg-2">
			<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'task', 'value'=>'apply')); ?>
		</div>
	</div>
	<br>
	<br>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'update_price_value'); ?>
			<div style="width: 150px;">
				<?php echo $form->dropDownList($model, 'update_price_value', Yii::app()->params['price_change']); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-3">
			<?php echo BsHtml::submitButton('Обновить цены', array('color' => BsHtml::BUTTON_COLOR_WARNING, 'name'=>'task', 'value'=>'update_price')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'fake_discount'); ?>
			<div style="width: 150px;">
				<?php echo $form->dropDownList($model, 'fake_discount', Yii::app()->params['price_change_fake']); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-3">
			<?php echo BsHtml::submitButton('Обновить fake цены', array('color' => BsHtml::BUTTON_COLOR_WARNING, 'name'=>'task', 'value'=>'update_price_fake')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->