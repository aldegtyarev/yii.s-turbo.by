<?php

class PagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';

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
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				//'height'=>40,
				//'width'=>120,				
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
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
	*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		//подключаем класс для замены 
		//больших изображений на миниютюры со ссылками
		$aadThumbnails = new AadThumbnails();	
		
		$model = $this->loadModel($id);
		//var_dump($model);

		//$mvThumbnails = new aadThumbnails();
		$aadThumbnails->onPrepareContent($model);
		//mvThumbnails::onPrepareContent($model);
		$regex = '#<img\s.*?>#';
		//$model->text = preg_replace_callback($regex, array($this, "imageReplacer"), $model->text);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}


	/**
	 *  Новости
	 */
	public function actionNews()
	{
		$app = Yii::app();
		$category_id = 2;
		
		$alias = $app->request->getParam('alias', '');
		
		if($alias != '') {
			$model = $this->loadModelByAlias($alias);
			$this->renderPage1($model, $category_id);
		}	else	{
			//$url_path = 'news';
			$this->renderPagesList($category_id, $app);
		}
	}
	
	/**
	 *  Наши работы
	 */
	public function actionOur()
	{
		$app = Yii::app();
		$category_id = 3;
		
		$alias = $app->request->getParam('alias', '');
		
		if($alias != '') {
			$model = $this->loadModelByAlias($alias);
			$this->renderPage1($model, $category_id);
		}	else	{
			$this->renderPagesList($category_id, $app);
		}
	}
	
	/**
	 * Доставка
	 */
	public function actionDelivery()
	{
		$id = 3;
		$this->renderPage($id);
	}

	/**
	 * Оплата
	 */
	public function actionPayment()
	{
		$id = 4;
		$this->renderPage($id);
	}

	/**
	 * гарантия
	 */
	public function actionGuarantee()
	{
		$id = 5;
		$this->renderPage($id);
	}

	/**
	 * Города доставки по Беларуси:
	 */
	public function actionTownslist()
	{
		$id = 7;
		$this->renderPage($id);
	}
	
	/**
	 * Города доставки по Беларуси:
	 */
	public function actionContacts()
	{
		$id = 6;
		$app = Yii::app();
		
		$model = $this->loadModel($id);
		$form = new ContactForm;
		
		if(isset($_POST['ContactForm']))
		{
			$form->attributes=$_POST['ContactForm'];
			if($form->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($form->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode('Сообщение с сайта').'?=';
				$headers="From: $name <{$form->email}>\r\n".
					"Reply-To: {$form->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$form->body,$headers);
				Yii::app()->user->setFlash('contact','Спасибо за Ваше сообщение.');
				$this->refresh();
			}
		}
		
		
		$current_action = $app->getController()->getAction()->getId();
		$current_controller =  $app->getController()->getId();
		
		$breadcrumbs = array($model->name);
		
		$this->render('view-contacts',array(
			'model'=>$model,
			'current_action'=>$current_action,
			'current_controller'=>$current_controller,
			'breadcrumbs'=>$breadcrumbs,
			'form'=>$form,
		));			
		
		
		//$this->renderPage($id);
	}
	
	
	/**
	 * гарантия
	 */
	public function actionAbout()
	{
		$id = 2;
		$id = 1;
		$this->renderPage($id);
	}
	
	public function renderPage($id)
	{
		$model = $this->loadModel($id);
		
		$this->renderPage1($model);
	}

	public function renderPage1(&$model, $category_id = 1)
	{		
		$app = Yii::app();		
		$modal = (int) $app->request->getParam('modal', '0');
		$current_action = $app->getController()->getAction()->getId();
		$current_controller =  $app->getController()->getId();
		
		$breadcrumbs = array();
				
		if($category_id > 1) {
			$category = $this->loadCategoryModel($category_id);
			$breadcrumbs[$category->name] = array('pages/'.$category->alias);
		}
		
		$breadcrumbs[] = $model->name;
		
		//$aadThumbnails = new AadThumbnails();
		//$aadThumbnails->onPrepareContent($model);
		
		if($modal == 0) {
			$this->render('view',array(
				'model'=>$model,
				'current_action'=>$current_action,
				'current_controller'=>$current_controller,
				'breadcrumbs'=>$breadcrumbs,
			));			
		}	else	{
			$this->renderPartial('view-modal',array(
				'model'=>$model,
				'current_action'=>$current_action,
				'current_controller'=>$current_controller,
			));
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelByAlias($alias)
	{
		$model=Pages::model()->findByAlias($alias);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadCategoryModel($id)
	{
		$model=PagesCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/*
	* возвращает список страниц заданной рубрики
	*/
	private function loadPages($category_id = 1)
	{
		$criteria = new CDbCriteria();
		//$criteria->select = "t.product_id";

		$condition_arr = array(
			'type = '.$category_id,
		);

		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = 'created DESC';
		
        $dataProvider = new CActiveDataProvider('Pages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
				'pageSize'=>Yii::app()->params->pagination['products_per_page'],
				//'pageSize'=>1,
				'pageVar' =>'page',
            ),
        ));
		return $dataProvider;
	}
	
	public function renderPagesList($category_id, &$app)
	{
		$this->processPageRequest('page');

		$model = $this->loadCategoryModel($category_id);

		$dataProvider = $this->loadPages($category_id);

		foreach($dataProvider->data as $row)	{
			$row->foto = $app->params->pages_images_liveUrl.($row->foto ? 'thumb_'.$row->foto : 'noimage.jpg');
		}

		$url_path = $model->alias;

		if ($app->request->isAjaxRequest){

			$this->renderPartial('_loopAjax', array(
				'dataProvider'=>$dataProvider,
				'url_path'=>$url_path,				
				
			));
			
			$app->end();
		}	else	{
			
			$this->render('index', array(
				'app'=> $app,
				'model'=>$model,
				'dataProvider'=>$dataProvider,
				'url_path'=>$url_path,
				'breadcrumb'=>$breadcrumb,
			));			
		}
	}
	
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
	

	
}
