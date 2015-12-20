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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ico'); ?>
		<?php echo $form->textField($model,'ico'); ?>
		<?php echo $form->error($model,'ico'); ?>
	</div>
	
	<?/*
	<div class="row">
		<?php echo $form->labelEx($model,'options'); ?>
		<?php echo $form->textArea($model,'options',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'options'); ?>
	</div>
	*/?>
	
	<div class="row">
		<div class="col-lg-12">
			<fielset>
				<legend>Обычная доставка</legend>

				<?php echo $form->labelEx($model,'units_qty12'); ?>
				<?php foreach(Delivery::model()->cargoTypesList as $cargo_id=>$cargo_type)	{	?>
					<div class="row">
						<div class="col-lg-3"><?= $cargo_type ?></div>
						<div class="col-lg-4"><input type="text" name="DeliveryForm[units_qty12][<?= $cargo_id ?>]" value="<?= $model->units_qty12[$cargo_id] ?>" class="form-control"></div>
					</div>
				<?php	}	?>

				<?php echo $form->labelEx($model,'units_qty3'); ?>
				<?php foreach(Delivery::model()->cargoTypesList as $cargo_id=>$cargo_type)	{	?>
					<div class="row">
						<div class="col-lg-3"><?= $cargo_type ?></div>
						<div class="col-lg-4"><input type="text" name="DeliveryForm[units_qty3][<?= $cargo_id ?>]" value="<?= $model->units_qty3[$cargo_id] ?>" class="form-control"></div>
					</div>
				<?php	}	?>
			</fielset>
		</div>
	</div>
	
	
	
	<div class="row">
		<div class="col-lg-12">
			<fielset>
				<legend>Ускоренная доставка</legend>

				<?php echo $form->labelEx($model,'units_qty12_q'); ?>
				<?php foreach(Delivery::model()->cargoTypesList as $cargo_id=>$cargo_type)	{	?>
					<div class="row">
						<div class="col-lg-3"><?= $cargo_type ?></div>
						<div class="col-lg-4"><input type="text" name="DeliveryForm[units_qty12_q][<?= $cargo_id ?>]" value="<?= $model->units_qty12_q[$cargo_id] ?>" class="form-control"></div>
					</div>
				<?php	}	?>

				<?php echo $form->labelEx($model,'units_qty3_q'); ?>
				<?php foreach(Delivery::model()->cargoTypesList as $cargo_id=>$cargo_type)	{	?>
					<div class="row">
						<div class="col-lg-3"><?= $cargo_type ?></div>
						<div class="col-lg-4"><input type="text" name="DeliveryForm[units_qty3_q][<?= $cargo_id ?>]" value="<?= $model->units_qty3_q[$cargo_id] ?>" class="form-control"></div>
					</div>
				<?php	}	?>

			</fielset>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'free'); ?>
			<?php echo $form->textField($model,'free'); ?>
			<?php echo $form->error($model,'free'); ?>
		</div>
	</div>
	
	
	<div class="row buttons">
		<div class="col-lg-12">
			<?php echo BsHtml::submitButton('Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
			<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->