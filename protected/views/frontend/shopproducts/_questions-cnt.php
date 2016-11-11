<?php
/** @var $model ShopProducts */
/** @var $arQuestionsCount array */

?>
<div class="question-cnt">
    <span class="question-bnt" data-id="<?= $model->product_id ?>"> <span class="icon icon-angle-double-down"></span> <span class="txt">вопрос/ответ</span><?php if(isset($arQuestionsCount[$model->product_id])) { ?><sup>(<?= $arQuestionsCount[$model->product_id] ?>)</sup><?php } ?></span>

    <div class="question-response-cnt"></div>
</div>
