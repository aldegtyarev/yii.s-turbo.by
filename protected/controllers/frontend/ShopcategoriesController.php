<?php

class ShopCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';
	public $product_images_liveUrl ='';
	public $show_models = true;
	
	public $CQtreeGreedView  = array (
		'modelClassName' => 'page2', //название класса
		'adminAction' => 'admin' //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
	);
	
    public function actions() {
        return array (
            'create'=>'ext.QTreeGridView.actions.Create',
            'update'=>'ext.QTreeGridView.actions.Update',
            'delete'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
			'rights',
        );
    }	


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
				'actions'=>array('index','view','show'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','movecategories','updatepath','updatemeta','updatemeta1', 'updateshowinmenu'),
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
		//echo'11111111111111111111111111111111';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	
	public function actionShow($id)
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$this->processPageRequest('page');
		
		//echo'$id = <pre>';print_r($_GET);echo'</pre>';die;
		
		$selected_view = $app->request->getParam('select-view', -1);
		
		if($selected_view != -1)	{
			$app->session['Shopcategories.selected_view'] = $selected_view;
			$this->redirect(array('show','id'=>$id));
		}	else	{
			if(isset($app->session['Shopcategories.selected_view']))	{
				$selected_view = $app->session['Shopcategories.selected_view'];
			}	else	{
				$selected_view = 'row';
			}
		}
		
		$type_request = (int)$app->request->getParam('type', 0);
		$firm_request = (int)$app->request->getParam('firm', 0);
		$body_request = (int)$app->request->getParam('body', 0);
		
		//echo'$selected_view = <pre>';print_r($selected_view);echo'</pre>';
		//echo'$id = <pre>';print_r($id);echo'</pre>';
		
		$category = ShopCategories::model()->findByPk($id);
		$descendants = $category->children()->findAll(array('order'=>'ordering'));
		
		//если фильруем по какой-то модели - то получаем ИД этих моделей
		$model_ids = ShopModelsAuto::model()->getModelIds($app);
		//echo'$model_ids<pre>';print_r($model_ids,0);echo'</pre>';
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.product_id";
		$criteria->join = 'INNER JOIN {{shop_products_categories}} AS pc USING (`product_id`) ';
		
		$condition_arr = array();
		$condition_arr[] = "pc.`category_id` = ".$category->id;
		
		if(count($model_ids))	{
			$product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);
			if(count($product_ids))	{
				$condition_arr[] = "t.`product_id` IN (".implode(', ', $product_ids).")";
			}
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = "pc.`ordering`, t.`product_id`";
		
		//получаем сначала все позиции для получения их id без учета пагинации
		$rows = ShopProducts::model()->findAll($criteria);
		$finded_product_ids = ShopProducts::model()->getProductIds($rows);
		
		if($type_request != 0)	{
			$condition_arr[] = "t.type_id = ".$type_request;
		}
		
		if($firm_request != 0)	{
			$condition_arr[] = "t.firm_id = ".$firm_request;
		}
		
		if($body_request != 0)	{
			$criteria->join .= ' INNER JOIN {{shop_products_bodies}} AS pb USING (`product_id`) ';
			$condition_arr[] = "pb.body_id = ".$body_request;
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
				
		$criteria->select = "t.*";
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
               // 'pageSize'=>$app->params->pagination['products_per_page'],
                'pageSize'=>120,
				'pageVar' =>'page',
            ),
        ));
		
		if(count($descendants))	{
			ShopCategories::model()->getCategoriesMedias($descendants);
		}
		
		if(count($finded_product_ids))	{
			//загрузить группы товаров
			$producttypes = ShopProductTypes::model()->getProductTypesForProductList($connection, $finded_product_ids, $get_null = true);
			//загрузить фирмы
			$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
			
			$bodies = ShopBodies::model()->getBodiesForProductList($connection, $finded_product_ids, $model_ids);
		}	else	{
			$firms = array();
			$producttypes = array();
			$bodies = array();
		}
		
		//echo'<pre>';print_r($finded_product_ids);echo'</pre>';
		//echo'<pre>';print_r($firms);echo'</pre>';
		if(count($dataProvider->data))	{
			$product_ids = array();
			foreach($dataProvider->data as $row)	{
				$product_ids[] = $row->product_id;
				$row->product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id));
				$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
				$row->firm_name = $firms[$row->firm_id]['name'];
				//$row->product_availability_str = $firms[$row->firm_id]['name'];
			}
			
			//получаем массив доп. изображений для списка товаров
			$ProductsImages = ShopProductsImages::model()->getFotoForProductList($connection, $product_ids);
			
			if(count($ProductsImages))	{
				foreach($ProductsImages as $Image)	{
					foreach($dataProvider->data as $row)	{
						if($Image['product_id'] == $row->product_id)	{
							$row->AdditionalImages[] = array('image_file'=>$Image['image_file'], 'image_id'=>$Image['image_id']);
						}						
					}
				}
			}
		}	else	{
			$ProductsImages = array();
		}
		
		//echo'<pre>';print_r(count($finded_product_ids));echo'</pre>';
		
		$breadcrumbs = $this->createBreadcrumbs($category);
		
		if(count($model_ids))	{
			if(count($model_ids) == 2 && $model_ids[1] == 1247)	{
				$this->show_models = false;
			}	else	{
				$this->show_models = true;
			}

		}	else	{
			$firms = array();
			$bodies = array();
			$show_models = true;
		}
		//echo'<pre>';print_r($firms);echo'</pre>';
		if(count($firms))	{
			$firmsArr = array();
			foreach($firms as $f) $firmsArr[$f['id']] = $f['name'];
			$firmsDropDown = CHtml::listData($firms, 'id','name');
			//$firmsDropDown = CHtml::listData($firmsArr, 'id','name');
		}
		//echo'<pre>';print_r($firmsDropDown);echo'</pre>';
		if($selected_view == 'row')	{
			$itemView = "_view-row";
		}	else	{
			$itemView = "_view";
		}
		
        if ($app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
				//'app'=> $app,
                'dataProvider'=>$dataProvider,
                'itemView'=>$itemView,
            ));
            $app->end();
        } else {
			$data = array(
				'app'=> $app,
				'dataProvider'=> $dataProvider,
				'itemView'=>$itemView,				
				'type_request'=> $type_request,
				'firm_request'=> $firm_request,
				'body_request'=> $body_request,
				'category_id'=> $category_id,
				'selected_view'=> $selected_view,
				'category'=> $category,
				'descendants'=> $descendants,
				'ProductsImages'=> $ProductsImages,
				'breadcrumbs' => $breadcrumbs,
				'producttypes' => $producttypes,
				'bodies' => $bodies,
				'firms' => $firms,
				'productsTotal' => count($finded_product_ids),
				'firmsDropDown' => $firmsDropDown,
			);

			$this->render('show', $data);
        }		
		
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$this->processPageRequest('page');
		
		$selected_view = $app->request->getParam('select-view', -1);
		
		if($selected_view != -1)	{
			$app->session['Shopcategories.selected_view'] = $selected_view;
			$this->redirect(array('index'));
		}	else	{
			if(isset($app->session['Shopcategories.selected_view']))	{
				$selected_view = $app->session['Shopcategories.selected_view'];
			}	else	{
				$selected_view = 'row';
			}
		}
		
		$type_request = (int)$app->request->getParam('type', 0);
		$firm_request = (int)$app->request->getParam('firm', 0);
		$body_request = (int)$app->request->getParam('body', 0);
		
		//$category = ShopCategories::model()->findByPk($id);
		//$descendants = $category->children()->findAll(array('order'=>'ordering'));
		
		//если фильруем по какой-то модели - то получаем ИД этих моделей
		$model_ids = ShopModelsAuto::model()->getModelIds($app);
		//echo'$model_ids<pre>';print_r($model_ids,0);echo'</pre>';
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.product_id";
		
		$condition_arr = array();
		
		if(count($model_ids))	{
			$product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);
			if(count($product_ids))	{
				$condition_arr[] = "t.`product_id` IN (".implode(', ', $product_ids).")";
			}
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = "t.`product_id`";
				
		$criteria->condition = implode(' AND ', $condition_arr);
				
		$criteria->select = "t.*";
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
               // 'pageSize'=>$app->params->pagination['products_per_page'],
                'pageSize'=>120,
				'pageVar' =>'page',
            ),
        ));
		
		$finded_product_ids = ShopProducts::model()->getProductIds($dataProvider->data);
		
		if(count($finded_product_ids))	{
			//загрузить группы товаров
			//$producttypes = ShopProductTypes::model()->getProductTypesForProductList($connection, $finded_product_ids, $get_null = true);
			//загрузить фирмы
			$firms = ShopFirms::model()->getFirmsForProductList($connection, $finded_product_ids);
			
			//$bodies = ShopBodies::model()->getBodiesForProductList($connection, $finded_product_ids, $model_ids);
		}	else	{
			$firms = array();
			//$producttypes = array();
			//$bodies = array();
		}
		
		
		//echo'<pre>';print_r($finded_product_ids);echo'</pre>';
		//echo'<pre>';print_r($firms);echo'</pre>';
		if(count($dataProvider->data))	{
			$product_ids = array();
			foreach($dataProvider->data as $row)	{
				$product_ids[] = $row->product_id;
				$row->product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id));
				$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
				$row->firm_name = $firms[$row->firm_id]['name'];
				//$row->product_availability_str = $firms[$row->firm_id]['name'];
			}
			
			//получаем массив доп. изображений для списка товаров
			$ProductsImages = ShopProductsImages::model()->getFotoForProductList($connection, $product_ids);
			
			if(count($ProductsImages))	{
				foreach($ProductsImages as $Image)	{
					foreach($dataProvider->data as $row)	{
						if($Image['product_id'] == $row->product_id)	{
							$row->AdditionalImages[] = $Image['image_file'];
						}
					}
				}
			}
		}	else	{
			$ProductsImages = array();
		}
		
		//echo'<pre>';print_r(count($finded_product_ids));echo'</pre>';
		
		$breadcrumbs = array(
			'Список товаров'
		);
		
		if(count($model_ids))	{
			if(count($model_ids) == 2 && $model_ids[1] == 1247)	{
				$this->show_models = false;
			}	else	{
				$this->show_models = true;
			}

		}	else	{
			$firms = array();
			$bodies = array();
			$show_models = true;
		}
		
		if($selected_view == 'row')	{
			$itemView = "_view-row";
		}	else	{
			$itemView = "_view";
		}
		
        if ($app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>$itemView,
            ));
            $app->end();
        } else {
			$data = array(
				'app'=> $app,
				'dataProvider'=> $dataProvider,
				'itemView'=>$itemView,				
				'selected_view'=> $selected_view,
				'breadcrumbs' => $breadcrumbs,
			);

			$this->render('index', $data);
        }		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShopCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopCategories']))
			$model->attributes=$_GET['ShopCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ShopCategories::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//метод собирает хлебную крошку
	public function createBreadcrumbs($category)
	{
		$ancestors = $category->ancestors()->findAll();
		unset($ancestors[0]);	//удаляем из масива главную категорию "Автомобили".
		$breadcrumb = array();
		foreach($ancestors as $row)	{
			$breadcrumb[$row->name] = array('/shopcategories/show/', 'id'=>$row->id);
			
		}
		$breadcrumb[] = $category->name;
		return $breadcrumb;
	}
	
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
	
}
