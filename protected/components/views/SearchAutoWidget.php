<?
		//echo'<pre>';print_r($markaDropDown);echo'</pre>';
		//echo'<pre>';print_r($modelDropDown);echo'</pre>';
		//echo'<pre>';print_r($yearDropDown);echo'</pre>';

$marka_attribs = array('empty' => 'Выберите марку');
if (count($markaDropDown))
	$marka_attribs['class'] = 'search-auto-form__border_white';

$model_attribs = array('empty' => 'Выберите модель');
if (count($modelDropDown))
	$model_attribs['class'] = 'search-auto-form__border_white';

$year_attribs = array('empty' => 'Выберите год');
if (count($yearDropDown))
	$year_attribs['class'] = 'search-auto-form__border_white';


?>
<div class="search-auto-block clearfix">
	<form id="searchautoform" method="post">
		<a href="/" class="search-auto-block-title" title="Поиск по автомобилю">
			<img src="/img/search-auto-ttl.png" alt="Поиск по автомобилю">
		</a>
		<div id="search-auto-form" class="search-auto-form">
			<?php if($select_marka != NULL || $select_model != NULL || $select_year != NULL)	{	?>
			<a href="javascript:void(0)" id="clear-search-auto" class="clear-search-auto">Сбросить фильтр по автомобилю</a>
			<?php	}	?>
			<input type="hidden" name="clear-search-auto" value="0" />
			<div class="step1 step-wr <?php if($select_marka != NULL) echo 'step-selected' ?>">
				<span class="step-num">1</span>
				<? echo CHtml::dropDownList('select-marka', $select_marka, $markaDropDown, $marka_attribs) ?>
			</div>
			<div class="step2 step-wr <?php if($select_model != NULL) echo 'step-selected' ?>">
				<span class="step-num">2</span>
				<span id="select-model-wr">
					<? echo CHtml::dropDownList('select-model', $select_model, $modelDropDown, $model_attribs) ?>
				</span>
			</div>
			<div class="step3 step-wr <?php if($select_year != NULL) echo 'step-selected' ?>">
				<span class="step-num">3</span>
				<span id="select-year-wr">
					<? echo CHtml::dropDownList('select-year', $select_year, $yearDropDown, $year_attribs) ?>
				</span>
			</div>
			<?/*<button class="search-auto-button"> </button>		*/?>
		</div>
		<? echo CHtml::hiddenField('return', $return_url) ?>		
	</form>
</div>