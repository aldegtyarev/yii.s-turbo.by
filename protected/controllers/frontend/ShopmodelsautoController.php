<?php

class ShopModelsAutoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','descendants'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopModelsAuto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopModelsAuto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopModelsAuto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-models-auto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDescendants()
	{
		$app = Yii::app();
		$model_id = $app->request->getParam('model_id', 0);
		$level = $app->request->getParam('level', 0);
		
		$model = $this->loadModel($model_id);
		
		$options = array();
		
		if($level > 1)	{
			$descendants = $model->descendants()->findAll();
			$parent_id = 0;
			foreach($descendants as $c) {
				$separator = '';
				if($c->hide_ndash == 0) {
					if($parent_id == $c->parent_id) {
						for ($x=4; $x++ < $c->level;) $separator .= '- ';
					}	else	{
						for ($x=3; $x++ < $c->level;) $separator .= '- ';
					}
					
				}	else	{
					$parent_id = $c->id;
				}
				
				
				$c->name = ' ' . $separator . $c->name;
				
				
				if($c->disabled_in_dropdown == 1)
					$options[$c->id] = array('disabled'=>true);
				//http://new.s-turbo.by/admin.php?r=shopmodelsauto/update&id=1894
				//http://new.s-turbo.by/admin.php?r=shopmodelsauto/update&id=1893
			}			
		}	else	{
			$descendants = $model->children()->findAll();		
		}
		
		
		$dropdownData = CHtml::listData($descendants, 'id','name');
		$selected = null;
		
		switch($level) {
			case 1:
				$empty = 'Выберите модель';
				$name = 'select-model';
				unset($app->session['autofilter.year']);
				unset($app->session['autofilter.model']);
				break;
			case 2:
				$empty = 'Выберите год';
				$name = 'select-year';
				unset($app->session['autofilter.year']);
				break;
			default:
				$empty = '';
				break;
		}
		
		echo CHtml::dropDownList($name, $selected, $dropdownData, array('empty' => $empty, 'class'=>'search-auto-form__border_white', 'options'=>$options));
		
		Yii::app()->end();
	}
	
}
