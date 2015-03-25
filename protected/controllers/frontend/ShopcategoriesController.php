<?php

class ShopCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2l';
	
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
		
		//echo'$selected_view = <pre>';print_r($selected_view);echo'</pre>';
		//echo'$id = <pre>';print_r($id);echo'</pre>';
		
		
		
		$connection = $app->db;
		
		$category = ShopCategories::model()->findByPk($id);
		$descendants = $category->children()->findAll(array('order'=>'ordering'));
		//echo'descendants = <pre>';print_r($descendants);echo'</pre>';
		$products_and_pages = ShopProducts::model()->findProductsInCat($category->id, $type_request, $firm_request);
		//echo'products_and_pages = <pre>';print_r($products_and_pages['rows']);echo'</pre>';
		if(count($descendants))	{
			ShopCategories::model()->getCategoriesMedias($descendants);
		}
		
		if(count($products_and_pages['product_ids']))	{
			//загрузить фирмы
			$firms = ShopFirms::model()->getFirmsForProductList($connection, $products_and_pages['product_ids']);
			$producttypes = ShopProductTypes::model()->getProductTypesForProductList($connection, $products_and_pages['product_ids']);
			$bodies = ShopBodies::model()->getBodiesForProductList($connection, $products_and_pages['product_ids']);
		
			//загрузить группы товаров
		}	else	{
			$firms = array();
			$producttypes = array();
		}
		
		//получаем массив доп. изображений для списка товаров
		if(count($products_and_pages['rows']))	{
			$product_ids = array();
			foreach($products_and_pages['rows'] as $row)	{
				$product_ids[] = $row->product_id;
			}
			
			$ProductsImages = ShopProductsImages::model()->getFotoForProductList($connection, $product_ids);
			if(count($ProductsImages))	{
				foreach($ProductsImages as $row)	{
					$products_and_pages['rows'][$row['product_id']]->AdditionalImages[] = $row['image_file'];
				}
			}
		}	else	{
			$ProductsImages = array();
		}
		
		//echo'<pre>';print_r($products_and_pages['rows']);echo'</pre>';
		//echo'<pre>';print_r($product_ids);echo'</pre>';
		
		$breadcrumbs = $this->createBreadcrumbs($category);
		
		$data = array(
			'type_request'=> $type_request,
			'firm_request'=> $firm_request,
			'category_id'=> $category_id,
			'selected_view'=> $selected_view,
			'category'=> $category,
			'descendants'=> $descendants,
			'products_and_pages'=> $products_and_pages,
			'ProductsImages'=> $ProductsImages,
			'breadcrumbs' => $breadcrumbs,
			'producttypes' => $producttypes,
			'bodies' => $bodies,
			'firms' => $firms,
			'productsTotal' => count($products_and_pages['product_ids']),
		);
						
		$this->render('show', $data);
		
		/*
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
		*/
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShopCategories;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->getDropDownlistData();

		if(isset($_POST['ShopCategories']))
		{
			$model->attributes=$_POST['ShopCategories'];
			$model->parentId = $_POST['ShopCategories']['parentId'];
			//$model->name = $_POST['ShopCategories']['name'];
			
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('admin','id'=>$model->id));
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
		$model->getDropDownlistData();
		
		$model->parentId = $model->parent()->find();	//получаем предка

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopCategories']))
		{
			$model->attributes=$_POST['ShopCategories'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
		//$this->loadModel($id)->delete();
		$this->loadModel($id)->deleteNode();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShopCategories');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
	
	
	public function actionUpdatemeta1()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM `{{shop_categories}}`";
		$command = $connection->createCommand($sql);
		$cat_rows = $command->queryAll();
		//echo'<pre>';print_r($cat_rows);echo'</pre>';
		foreach($cat_rows as $cat_row)	{
			$sql = "SELECT * FROM `s9r5d_virtuemart_categories_ru_ru` WHERE `virtuemart_category_id` = ".$cat_row['id'];
			$command = $connection->createCommand($sql);
			$old_info = $command->queryRow();
			$update_arr = array();
			$update_arr[] = "`title` = '".$old_info['customtitle']."'";
			$update_arr[] = "`keywords` = '".$old_info['metakey']."'";
			$update_arr[] = "`description` = '".$old_info['metadesc']."'";
			$update_str = implode(', ', $update_arr);
			$cat_id = $cat_row['id'];
			echo'<pre>';print_r($update_str);echo'</pre>';
			$sql = "UPDATE {{shop_categories}} SET $update_str WHERE `id` = $cat_id";
			$command = $connection->createCommand($sql);
			$rowCount=$command->execute();
			
		}
	}
	
	public function actionUpdateshowinmenu()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM `{{shop_categories}}` WHERE `anchor_css` = 'end'";
		$command = $connection->createCommand($sql);
		$cat_rows = $command->queryAll();
		//echo'<pre>';print_r($cat_rows);echo'</pre>';
		foreach($cat_rows as $cat_row)	{
			$category=ShopCategories::model()->findByPk($cat_row['id']);
			$descendants=$category->children()->findAll();
			foreach($descendants as $descendant)	{
				$descendant->show_in_menu = 0;
				$descendant->save(false);
			}
		}
	}
	
	//обновление мета информации из старой таблицы меню
	public function actionUpdatemeta()
	{
		//unset($menu_items);
		
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM `s9r5d_menu` WHERE `published` = 1 AND `link` like '%com_virtuemart%'";
		$command = $connection->createCommand($sql);
		$menu_items = $command->queryAll();
		
		//echo'<pre>';print_r(json_decode($menu_items[66]['params']));echo'</pre>';
		//echo'<pre>';print_r($menu_items[16]['link']);echo'</pre>';
		//$link_arr = explode('&', $menu_items[16]['link']);
		//echo'<pre>';print_r($link_arr);echo'</pre>';
		//echo'<pre>';print_r($menu_items);echo'</pre>';
		
		foreach($menu_items as $menu_item)	{
			$update_arr = array();
			$cat_name = '';
			$cat_id = 0;
			$params = json_decode($menu_item['params']);
			//echo'<pre>';print_r($params);echo'</pre>';
			
			
			
			$anchor_css = 'menu-anchor_css';
			if($params->$anchor_css != '')	{
				$update_arr[] = "`anchor_css` = '".$params->$anchor_css."'";
			}	else	{
				
			}
			$update_arr[] = "`show_in_menu` = 1";
			$update_arr[] = "`alias` = '".$menu_item['alias']."'";
			
			
			$link_arr = explode('&', $menu_item['link']);
			foreach($link_arr as $link_i)	{
				$link_i_arr = explode('=', $link_i);
				//echo'<pre>';print_r($link_i_arr);echo'</pre>';
				if($link_i_arr[0] == 'virtuemart_category_id')	{
					$cat_id = $link_i_arr[1];
				}
			}
			

			if($params->page_title != '')	{
				$update_arr[] = "`title` = '".$params->page_title."'";
			}
			
			$description = 'menu-meta_description';
			if($params->$description != '')	{
				$update_arr[] = "`description` = '".$params->$description."'";
			}
			
			$keywords = 'menu-meta_keywords';
			if($params->$keywords != '')	{
				$update_arr[] = "`keywords` = '".$params->$keywords."'";
			}
			
			$update_str = implode(', ', $update_arr);
			//echo'<pre>';print_r($params->$description);echo'</pre>';
			//echo'<pre>';print_r($params->menu-meta_keywords);echo'</pre>';
			
			//if($cat_name != '')	{
			if($cat_id)	{
				//echo'<pre>cat_name = ';print_r($cat_name);echo'</pre>';
				//echo"<pre> $cat_id | ";print_r($update_str);echo'</pre>';
				//$sql = "UPDATE {{shop_categories}} SET $update_str WHERE `name` = \"$cat_name\"";
				$sql = "UPDATE {{shop_categories}} SET $update_str WHERE `id` = $cat_id";
				echo'<pre>';print_r($sql);echo'</pre>';
				$command = $connection->createCommand($sql);
				$rowCount=$command->execute();
			}
		}
		unset($menu_items);
		//echo'<pre>';print_r($menu_items);echo'</pre>';
	}
	
	public function actionMovecategories()
	{
		$connection = Yii::app()->db;
		
		$sql = 'TRUNCATE TABLE {{shop_categories}}';
		$command = $connection->createCommand($sql);
		//$res = $command->execute();
		
		$sql = "select cr.*, cc.category_parent_id, ca.ordering
				FROM s9r5d_virtuemart_categories_ru_ru as cr
				INNER JOIN s9r5d_virtuemart_category_categories AS cc ON cc.category_child_id = cr.virtuemart_category_id
				INNER JOIN s9r5d_virtuemart_categories AS ca ON ca.virtuemart_category_id = cr.virtuemart_category_id
				WHERE cr.virtuemart_category_id >= 4500 AND cr.virtuemart_category_id <=4999 ORDER BY cr.virtuemart_category_id";
		$command = $connection->createCommand($sql);
		$virtuemart_categories = $command->queryAll();
		$virtuemart_categories1 = $virtuemart_categories;
		$deleted_cats = array();
		//echo'<pre>';print_r($virtuemart_categories);echo'</pre>';
		foreach($virtuemart_categories as $key=>$cat) {
			//echo'<pre>';print_r($cat);echo'</pre>';
			/*
			$data_['Categories'][parentId] = ;
			$data_['Categories'][name] = $cat['category_name'];
			$data_['Categories'][title] = '';
			$data_['Categories'][keywords] = '';
			$data_['Categories'][description] = '';
			$data_['Categories'][alias] = '';
			*/
			$add_record = false;
			$add_record = true;
			/*
			if($cat['category_parent_id'] == 0)	{
				$add_record = true;
			}	else	{
				foreach($virtuemart_categories1 as $cat1) {
					if($cat['category_parent_id'] == $cat1['virtuemart_category_id'])	{
						$add_record = true;
						break;
					}
				}
			}
			*/
			if($add_record)	{
				$model = new ShopCategories;
				$model->id = $cat['virtuemart_category_id'];
				$model->parentId = $cat['category_parent_id'];
				$model->name = $cat['category_name'];
				$model->title = $cat['custom_title'];
				$model->keywords = $cat['metakey'];
				$model->description = $cat['metadesc'];
				$model->alias = $cat['slug'];
				$model->ordering = $cat['ordering'];
				$model->category_companies = $cat['category_companies'];
				$model->cat_column = $cat['cat_column'];
				$model->save();
			}	else	{
				$virtuemart_categories[$key]['deleted'] = 1;
			}
			echo'<pre>';print_r($cat);echo'</pre>';
		}
		
	}
	
	public function actionUpdatepath()
	{
		echo'<pre>';print_r('actionUpdatepath');echo'</pre>';
		$ShopCategories = ShopCategories::model()->findAll('id > 4000 and id <= 5000');
		echo'<pre>';print_r(count($ShopCategories));echo'</pre>';
		$i = 0;
		foreach($ShopCategories as $category)	{
			//if($category->alias != 'avtomobili')	{
				$ancestors = $category->ancestors()->findAll();
				$path = '';
				foreach($ancestors as $a)	{
					if($a->alias != 'avtomobili')	{
						$path .= $a->alias.'/';
						//echo'<pre>';print_r($a->name);echo'</pre>';
					}
				}
				$path .= $category->alias;
				if($category->name == 'vt146|146 (94-01)')	{

					
				}
					//echo'<pre>ancestors=';print_r($ancestors);echo'</pre>';
				//echo'<pre>path = ';print_r($path);echo'</pre>';				
				$category->path = $path;
				$category->save(false);
			//}
			/*
			foreach($ancestors as $$ancestor)	{
				$ancestor->__destruct();
			}
			*/
			//if (count($ancestors))	$ancestors->__destruct();
			$i++;


		}
		echo'<pre>';print_r($i);echo'</pre>';
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
}
