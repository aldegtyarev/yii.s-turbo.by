<?php
/** @var $model ProductCommentsForm */

?>



<?php $form=$this->beginWidget('CActiveForm', array(
    'action' => $this->createUrl('product/comments', array('id'=>$model->product_id)),
    'id'=>'product-comment-form-' . time(),
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('class'=>'product-comment-form'),
)); ?>


    <div class="row">
        <div class="col-50">
            <?php echo $form->textField($model,'name',array('size'=>11,'maxlength'=>64, 'placeholder'=>$model->getAttributeLabel('name'))); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-50">
            <?php echo $form->textField($model,'email',array('size'=>11,'maxlength'=>64, 'placeholder'=>$model->getAttributeLabel('email'))); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-100">
            <?php echo $form->textArea($model,'comment',array('rows'=>4, 'cols'=>50,'maxlength'=>2048, 'placeholder'=>$model->getAttributeLabel('comment'))); ?>
            <?php echo $form->error($model,'comment'); ?>
        </div>
    </div>

    <div class="buttons">
        <?php echo CHtml::submitButton('Отправить', array('name'=>'apply', 'class'=>'button-red')); ?>
    </div>

<?php $this->endWidget(); ?>

<?php if(!is_null($model->id)) { ?>
    <?/*<div style="color: #009a00; font-weight: bold; font-size: 16px; margin-bottom: 20px;">Ваш вопрос отправлен.</div>*/?>
    <div id="question-sended" class="order-done-popup" style="width: 550px; display: none;">
        <div class="order-done-hdr">
            <img src="/img/logo-top.png" alt="магазин автомобильных запчастей">
        </div>
        <div class="order-done-info">
            <p class="r1">Ваш вопрос отправлен.</p>
            <p class="r1">В ближайшее время на Ваш e-mail придет ответ.</p>
            <p class="r3"></p>
            <p class="r4">Спасибо!</p>
        </div>
    </div>
    <a href="#question-sended" class="fb-question-sended" style="color:#fff;font-size:2px;visibility: hidden;">Подробнее</a>
<? } ?>