<?php
/**
 * Created by PhpStorm.
 * User: Alexius
 * Date: 18.03.2016
 * Time: 23:32
 */
$cs = Yii::app()->clientScript;

$cs->registerCssFile('/css/chosen.css', 'screen');
$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);
$cs->registerScript('loading', "
	$('.chosen_select').chosen();
");

$this->pageTitle = 'Связаная категория';

$this->breadcrumbs = $breadcrumbs;

$this->menu = $menu;

?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
         'id'=>'categories-form',
         'enableAjaxValidation'=>false,
         'htmlOptions' =>	array(),
     )); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="col-lg-12">
                <?php echo $form->labelEx($model,'category_related_id'); ?>
                <?php echo $form->dropDownList($model, 'category_related_id', $DropDownCategories); ?>
                <?php echo $form->error($model,'category_related_id'); ?>
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
                <div class="chosen-row">
                    <?php echo $form->labelEx($model,'model_ids'); ?>
                    <?php echo $form->dropDownList($model, 'model_ids', $DropDownModels, array('multiple' => true, 'class'=>'chosen_select', 'data-placeholder'=>'выберите модель', 'style'=>'width:100%;', 'options' => $model->model_ids));?>
                    <?php echo $form->error($model,'model_ids'); ?>
                </div>
            </div>

        </div>

        <div class="row buttons">
            <div class="col-lg-12">
                <?php echo BsHtml::submitButton('Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'task', 'value'=>'save')); ?>
            </div>
        </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->