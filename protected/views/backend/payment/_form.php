<?php
/* @var $this DeliveryController */
/* @var $model Delivery */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'delivery-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'ico'); ?>
			<?php echo $form->textField($model,'ico'); ?>
			<?php echo $form->error($model,'ico'); ?>
		</div>
	</div>
	<?/*
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'options'); ?>
			<?php echo $form->textArea($model,'options',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'options'); ?>
		</div>
	</div>
	*/?>
	
	<div class="row">
		<?php foreach($deliveries as $delivery)	{	?>
			<div class="col-lg-12">
				<?php echo CHtml::checkBox('Payment[relations]['.$delivery->id.']', isset($model->relations[$delivery->id]), $htmlOptions=array ('id'=>'Payment-relations-'.$delivery->id, 'value'=>$delivery->id)) ?>
				<?php echo CHtml::label($delivery->name, 'Payment-relations-'.$delivery->id, $htmlOptions=array ( )) ?>
			</div>
		<?php	}	?>		
	</div>
	
	<div class="row buttons">
		<div class="col-lg-12">
			<?php echo BsHtml::submitButton('Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
			<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->