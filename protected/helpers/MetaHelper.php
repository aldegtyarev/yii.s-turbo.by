<?php

class MetaHelper
{
    public static function setMeta(&$cntr, $model, $name = 'name')
    {
		$app = Yii::app();
		$clientScript = $app->clientScript;
		
		if($model->metatitle != '') $cntr->pageTitle = $model->metatitle.' | '.$app->name;
			else $cntr->pageTitle = $model->$name.' | '.$app->name;

		if($model->metadesc != '') $val = $model->metadesc;
			else $val = $model->$name;
		
		$clientScript->registerMetaTag($val, 'description');
				

		if($model->metakey != '') $val = $model->metakey;
			else $val = $model->$name;
		
		$clientScript->registerMetaTag($val, 'keywords');		
    }
}

