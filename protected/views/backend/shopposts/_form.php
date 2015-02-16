<?php
/* @var $this ShopPostsController */
/* @var $model ShopPosts */
/* @var $form CActiveForm */
?>

<div class="form">

<style type="text/css">

#image {
    width: 200px;
    height: 200px;
    overflow: hidden;
    cursor: pointer;
    background: #000;
    color: #fff;
}
#image img {
    visibility: hidden;
}

</style>
 
<script type="text/javascript">

function openKCFinder(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img" src="' + url + '" />';
				document.getElementById('ShopPosts_image').value = url;
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
                img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
                img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.visibility = "visible";
            }
        }
    };

    window.open('/protected/extensions/ckeditor/kcfinder/browse.php?type=images&dir=images/public',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}

function myOnloadFunc() {
	//alert(document.getElementById('ShopPosts_image').value);
	var div = document.getElementById('image');
	var img = new Image();
	img.src = document.getElementById('ShopPosts_image').value;
	//alert(img.src);
	img.onload = function() {
		div.innerHTML = '<img id="img" src="' + document.getElementById('ShopPosts_image').value + '" />';
		//document.getElementById('ShopPosts_image').value = url;
		var img = document.getElementById('img');
		var o_w = img.offsetWidth;
		var o_h = img.offsetHeight;
		var f_w = div.offsetWidth;
		var f_h = div.offsetHeight;
		if ((o_w > f_w) || (o_h > f_h)) {
			if ((f_w / f_h) > (o_w / o_h))
				f_w = parseInt((o_w * f_h) / o_h);
			else if ((f_w / f_h) < (o_w / o_h))
				f_h = parseInt((o_h * f_w) / o_w);
			img.style.width = f_w + "px";
			img.style.height = f_h + "px";
		} else {
			f_w = o_w;
			f_h = o_h;
		}
		img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
		img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
		img.style.visibility = "visible";
	}
	
}
	window.onload = myOnloadFunc
</script>

<?php //$form=$this->beginWidget('CActiveForm', array(
$form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'shop-posts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<div id="image" onclick="openKCFinder(this)"><div style="margin:5px">Кликните для выбора</div></div>		
		<?php echo $form->textField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'introtext'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'introtext',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'text'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'fulltext'); ?>
		<?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
			  'model'=>$model,
			  'attribute'=>'fulltext',
			  'language'=>'ru',
			  'editorTemplate'=>'full',
			  'height'=>'200px'
		)); ?>	
		<?php echo $form->error($model,'fulltext'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hits'); ?>
		<?php echo $form->textField($model,'hits',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hits'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metadesc'); ?>
		<?php echo $form->textArea($model,'metadesc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metadesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metadata'); ?>
		<?php echo $form->textArea($model,'metadata',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metadata'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metakey'); ?>
		<?php echo $form->textArea($model,'metakey',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'metakey'); ?>
	</div>

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->