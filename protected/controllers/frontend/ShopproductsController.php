<?php

class ShopProductsController extends Controller
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','detail'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('superman'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	
	//метод загружает товар. $product = product_id
	public function actionDetail($product)
	{
		$app = Yii::app();
		$connection = $app->db;
		//echo'<pre>';print_r($product);echo'</pre>';
		/*
		$path_arr = explode('/', $path);
		$slug = str_replace('-detail', '', $path_arr[count($path_arr)-1]);
		$category_path = substr(str_replace($path_arr[count($path_arr)-1], '', $path), 0, -1);
		*/
		//$model = $this->loadModelbySlug($slug);
		$model = $this->loadModel($product);
		
		//получаем сопутствующие товары
		$related_rows = ShopProductsRelations::model()->getRelatedProducts($product);
		/*
		$sql = "SELECT p.`product_id`, p.`product_name`, p.`product_sku`, p.`product_image`, p.`manuf`, p.`product_price`, p.`product_availability`
				FROM `{{shop_products}}` AS p
				INNER JOIN `{{shop_products_relations}}` AS pr ON p.`product_id` = pr.`product_related_id`
				WHERE pr.`product_id` = :product_id";
		
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$rows = $command->queryAll();
		*/
		$criteria = new CDbCriteria();
		
		$criteria->select = "t.*";
		$criteria->join = 'INNER JOIN `{{shop_products_relations}}` AS pr ON t.`product_id` = pr.`product_related_id`';
		$criteria->condition = 'pr.`product_id` = '.$product;

        $RelatedDataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
				'pageVar' =>'page',
            ),
        ));
		
		$finded_product_ids = ShopProducts::model()->getProductIds($RelatedDataProvider->data);
		//echo'$related_rows<pre>';print_r($finded_product_ids);echo'</pre>';die;
		
		$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
		
		foreach($RelatedDataProvider->data as $row)	{
			$row->product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id));
			$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
			$row->firm_name = $firms[$row->firm_id]['name'];
		}

		//echo'$related_rows<pre>';print_r($RelatedDataProvider->data);echo'</pre>';die;
		
		//$breadcrumbs = $this->createBreadcrumbs($category_path, $model);
		$breadcrumbs = array(
			$model->product_name,
		);
		//echo'<pre>';print_r($model->shopProductsMediases);echo'</pre>';
		//echo'<pre>';print_r($model->shopProductPrices);echo'</pre>';
		
		// сохраняем в сессию, что мы смотрели данный товар
		$shopProductsIds = isset($app->session['shopProducts.ids']) ? $app->session['shopProducts.ids'] : array() ;
		if (!in_array($model->product_id, $shopProductsIds)) {
			$shopProductsIds[] = $model->product_id;
		}
		
		$app->session['shopProducts.ids'] = $shopProductsIds;
		
		$this->render('view',array(
			'model'=>$model,
			'rows'=>$related_rows,
			'RelatedDataProvider'=>$RelatedDataProvider,
			'breadcrumbs' => $breadcrumbs,
		));
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShopProducts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopProducts']))
		{
			$model->attributes=$_POST['ShopProducts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->product_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopProducts']))
		{
			$model->attributes=$_POST['ShopProducts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->product_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopProducts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopProducts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopProducts']))
			$model->attributes=$_GET['ShopProducts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopProducts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopProducts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
	}
	
	public function loadModelbySlug($slug)
	{
		$model = ShopProducts::model()->findBySlug($slug);
		if($model===null)
			throw new CHttpException(404,'Запрашиваемая страница не найдена.');
		return $model;
		
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopProducts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//метод собирает хлебную крошку
	public function createBreadcrumbs($path, $model)
	{
		$category = ShopCategories::model()->findByPath($path);
		$ancestors = $category->ancestors()->findAll();
		unset($ancestors[0]);	//удаляем из масива главную категорию "Автомобили".
		$breadcrumb = array();
		foreach($ancestors as $row)	{
			$breadcrumb[$row->name] = array('/shopcategories/show/', 'id'=>$row->id);
			
		}
		$breadcrumb[$category->name] = array('/shopcategories/show/', 'id'=>$category->id);;
		$breadcrumb[] = $model->product_name;
		return $breadcrumb;
	}	
	
}
