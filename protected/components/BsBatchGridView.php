<?php
//http://loco.ru/materials/401-yii-gruppovye-operacii-v-cgridview
//Yii::import('zii.widgets.grid.CGridView');  
//Yii::import('application.extensions.alphapager.ApGridView'); // так как я использую ещё фильтрацию по первой букве имени, то расширять буду не CGridView, а ApGridView (стороннее расширение alphapager)
Yii::import('bootstrap.widgets.BsGridView'); // так как я использую ещё yiibootstrap
//class GridView extends ApGridView {
class BsBatchGridView extends BsGridView {
   public $groupActions = array();
   public function init()
    {
       array_unshift($this->columns, array(
          'id'=>'batchId',
 		  'class'=>'CCheckBoxColumn',
          'selectableRows'=>2,
          'checkBoxHtmlOptions'=>array(
          'name'=>'batchId[]',
          ),
          'htmlOptions'=>array(
             'class'=>'group-checkbox-column',
          ),
       ));
      return parent::init();
 }
   public function renderPager()
    {
       //echo "<div class='pre-header' style='float:left'>";
       echo '<div class="row">';
       if(count($this->groupActions)) {
          //echo CHtml::dropDownList('group-actions', null, array(null=>'Выберите действие:')+$this->groupActions, array());
          echo '<div class="col-lg-4 col-md-4">'.BsHtml::dropDownList('group-actions', null, array(null=>'Выберите действие:')+$this->groupActions, array()).'</div>';
       }
       /*
	   echo CHtml::button('submit', array(
          'id'=>'group-operation-submit',
          'onclick'=>'groupOperation()',
       ));
	   */
	   echo '<div class="col-lg-4 col-md-4">';
	   echo BsHtml::submitButton('Применить', array(
		   'color' => BsHtml::BUTTON_COLOR_SUCCESS,
		   'id'=>'group-operation-submit',
		   'onclick'=>'groupOperation()',
		   'name'=>'apply'
	   ));
	   
       echo "</div>";
       echo "</div>";
      $actionLinks = array();
       foreach($this->groupActions as $k=>$v) {
          $actionLinks[$k] = Yii::app()->controller->createUrl($k);
       }
       $actionLinks = json_encode($actionLinks);
      Yii::app()->clientScript->registerScript('go', "
         var actionLinks = $actionLinks;
         function groupOperation(){
            var select = $('#group-actions');
            var action = select.val();
            var submit = $('#group-operation-submit');
            submit.attr('disabled', 'disabled');
            $.ajax({
               url: actionLinks[action],
               type: 'POST',
               data: $('.group-checkbox-column input').serializeArray(),
               complete: function(){
                  submit.removeAttr('disabled');
               },
               success: function(){
                  jQuery('#{$this->id}').yiiGridView('update');
               }
           });
      }
      ", CClientScript::POS_HEAD);
       parent::renderPager();
    }
}