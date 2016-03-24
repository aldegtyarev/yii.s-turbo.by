<?
$app = Yii::app();

$type = $app->request->getParam('type', -1);
$url_params = UrlHelper::getUrlParams($app);	// это забирается из GET параметров
$selected_auto = UrlHelper::getSelectedAuto($app);	//это то что храниться в сессии

if($type != -1) $selected_auto['type'] = $type;

if($selected_auto['engine'] == -1) unset($selected_auto['engine']);
$url_params = UrlHelper::buildUrlParams($selected_auto, $url_params['id']);
$url = $url_params[0];
unset($url_params[0]);



//echo'<pre>';print_r($selected_auto);echo'</pre>';
//echo'<pre>';print_r($modelDropDown);echo'</pre>';
//echo'<pre>';print_r($yearDropDown);echo'</pre>';

$marka_attribs = array('empty' => 'Выберите марку');
if (count($markaDropDown))
	$marka_attribs['class'] = 'search-auto-form__border_white';

$model_attribs = array('empty' => 'Выберите модель');
if (count($modelDropDown))
	$model_attribs['class'] = 'search-auto-form__border_white';

$year_attribs = array('empty' => 'Выберите год');
if (count($yearDropDown)) {
	$year_attribs['class'] = 'search-auto-form__border_white';
	$year_attribs['options'] = $yearOptions;
	
}

$current_action = $app->getController()->getAction()->getId();
$current_controller =  $app->getController()->getId();

if($current_controller == 'shopcategories' && $current_action == 'show') {
	unset($url_params['engine']);
	$form_action = $app->getController()->createUrl($url, $url_params);
} else {
	$form_action = $app->getController()->createUrl('shopcategories/index');
}



?>
<div id="search-auto-block" class="search-auto-block clearfix">
	<?/*<form id="searchautoform" method="post" action="<?= Yii::app()->getController()->createUrl('shopcategories/show', $url_params) ?>">*/?>
	<form id="searchautoform" method="post" action="<?= $form_action ?>">
		<a href="/" class="search-auto-block-title" title="Поиск по автомобилю">
			<img src="/img/search-auto-ttl.png" alt="Поиск по автомобилю">
		</a>
		<div id="search-auto-form" class="search-auto-form">
			<?php if($select_marka != NULL || $select_model != NULL || $select_year != NULL)	{
				$style = '';
			} else	{
				$style = 'style="display:none;"';
			}	?>
			<a href="javascript:void(0)" id="clear-search-auto" class="clear-search-auto" <?= $style ?> >Сбросить фильтр по автомобилю</a>
			<input type="hidden" name="clear-search-auto" value="0" />
			<div class="step1 step-wr <?php if($select_marka != NULL) echo 'step-selected' ?>">
				<span class="step-num">1</span>
				<? echo CHtml::dropDownList('select-marka', $select_marka, $markaDropDown, $marka_attribs) ?>
			</div>
			<div class="step2 step-wr <?php if($select_model != NULL) echo 'step-selected' ?>">
				<span class="step-num">2</span>
				<span id="select-model-loading" class="search-auto-loading">идет загрузка...</span>
				<div id="select-model-wr">
					<? echo CHtml::dropDownList('select-model', $select_model, $modelDropDown, $model_attribs) ?>
				</div>
			</div>
			<div class="step3 step-wr <?php if($select_year != NULL) echo 'step-selected' ?>">
				<span class="step-num">3</span>
				<span id="select-year-loading" class="search-auto-loading">идет загрузка...</span>
				<div id="select-year-wr">
					<? echo CHtml::dropDownList('select-year', $select_year, $yearDropDown, $year_attribs) ?>
				</div>
			</div>
		</div>
		<? echo CHtml::hiddenField('return', $return_url) ?>		
	</form>
</div>