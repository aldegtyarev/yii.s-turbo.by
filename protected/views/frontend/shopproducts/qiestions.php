<?php
/** @var $model ShopProducts */
/** @var $modelComment ProductCommentsForm */
/** @var $commentsDataProvider CActiveDataProvider */

?>
<div class="quection-form-cnt">
    <h3>Задать вопрос</h3>
    <div>
        <?php
            $this->renderPartial('_questions-form', array(
                'app'=>$app,
                'model'=>$modelComment,
            ));
        ?>
    </div>
</div>

<?php if(count($commentsDataProvider->data) > 0) { ?>
    <div class="questions-lst-cnt">
        <?php $this->widget('zii.widgets.CListView', array(
            'id' => 'questions-lst',
            'dataProvider'=>$commentsDataProvider,
            'itemView'=>'_question-item',
            'ajaxUpdate'=>false,
            'template'=>"{items}",

            'itemsCssClass' => 'questions-lst clearfix',
//            'viewData'=>array(
//                'currency_info' => $currency_info,
//                'deliveries_list' => $deliveries_list,
//                'modelinfoTxt' => $model_info_name,
//                'app'=>$app,
//            ),
        )); ?>
    </div>
<?php } ?>


