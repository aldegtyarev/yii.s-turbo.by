<?php

class SiteController extends Controller
{
	public $layout='//layouts/column2l';
	
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
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	
	public function actionCompanies()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('empty-page');
	}	

	public function actionOplataidostavka()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('empty-page');
	}	

	public function actionFeedback()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('empty-page');
	}	

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	
	public function actionMoveusers()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		$sql = "select * FROM {{users}} WHERE 1";
		$command = $connection->createCommand($sql);
		$yii_users = $command->queryAll();	
		
		$sql = "select * FROM s9r5d_users WHERE 1";
		$command = $connection->createCommand($sql);
		$joomla_users = $command->queryAll();	
		echo'<pre>';print_r($joomla_users[0]);echo'</pre>';
		foreach($yii_users as $yii)	{
			foreach($joomla_users as $joomla)	{
				if($yii['email'] == $joomla['email'])	{
					
					$sql = "UPDATE {{users_profiles}} SET 
							`override` = '".$joomla['override']."', 
							`partner_free` = '".$joomla['partner_free']."', 
							`partner` = '".$joomla['partner']."', 
							`news` = '".$joomla['news']."', 
							`comment` = '".$joomla['comment']."', 
							`question` = '".$joomla['question']."', 
							`edit` = '".$joomla['edit']."', 
							`dizain` = '".$joomla['dizain']."', 
							`company_id` = '".$joomla['company_id']."', 
							`template_file` = '".$joomla['template_file']."', 
							`style_file` = '".$joomla['style_file']."',
							`company_autor` = '".$joomla['company_autor']."', 
							`company_forum` = '".$joomla['company_forum']."', 
							`company_forum_url` = '".$joomla['company_forum_url']."' 
							
							WHERE `user_id` = ".$yii['id'];
					$command = $connection->createCommand($sql);
					$res = $command->execute();
					
					break;
				}
				
			}
		}
	}
	
	public function actionSubscribers()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select s.*, u.email, yiiusers.id as yii_user_id FROM s9r5d_subscribers as s INNER JOIN s9r5d_users as u ON u.id = s.user_id INNER JOIN {{users}} AS yiiusers ON u.email =  yiiusers.email WHERE 1";
		$command = $connection->createCommand($sql);
		$subscribers = $command->queryAll();
		echo'<pre>';print_r($subscribers);echo'</pre>';
		
		foreach($subscribers as $row)	{
			$sql = "INSERT INTO {{subscribers}}(`company_id`, `user_id`, `email`) VALUES (".$row['company_id'].", ".$row['yii_user_id'].", '".$row['email']."')";
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
		
	}
	
	
	public function actionSetparentid()
	{
		$res = ShopCategories::model()->setparentid();
	}
	
	public function actionUpdatesku()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select virtuemart_product_id, product_sku FROM s9r5d_virtuemart_products";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		//echo'<pre>';print_r($subscribers);echo'</pre>';
		
		foreach($rows as $row)	{
			$sql = "UPDATE  {{shop_products}} SET  `product_sku` =  '".$row['product_sku']."' WHERE  `product_id` = ".$row['virtuemart_product_id'];
			//$sql = "INSERT INTO {{subscribers}}(`company_id`, `user_id`, `email`) VALUES (".$row['company_id'].", ".$row['yii_user_id'].", '".$row['email']."')";
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
		
	}		
	
	public function actionUpdatecustoms()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select virtuemart_product_id FROM s9r5d_virtuemart_products";
		$command = $connection->createCommand($sql);
		$products_ids = $command->queryColumn();
		//echo'<pre>';print_r($products_ids);echo'</pre>';
		
		foreach($products_ids as $id)	{
		
			$sql = "select * FROM s9r5d_virtuemart_product_customfields WHERE virtuemart_product_id = $id";
			$command = $connection->createCommand($sql);
			$customfields = $command->queryAll();
			
			if(count($customfields))	{
				$update_arr = array();
				foreach($customfields as $f)	{
					$field = '';
					switch($f['virtuemart_custom_id'])	{
						case 3:
							$field = 'manuf';
							break;
						case 4:
							$field = 'material';
							break;
						case 5:
							$field = 'code';
							break;
						case 6:
							$field = 'in_stock';
							break;
						case 7:
							$field = 'delivery';
							break;
						case 8:
							$field = 'prepayment';
							break;
					}
					if($field != '')
						$update_arr[] = "`$field` = '".$f['custom_value']."'";
					
				}
				$update_str = implode(',', $update_arr);
				//echo'<pre>';print_r($update_str);echo'</pre>';
				$sql = "UPDATE  {{shop_products}} SET  $update_str  WHERE  `product_id` = $id";
				//echo'<pre>';print_r($sql);echo'</pre>';
				$command = $connection->createCommand($sql);
				$res = $command->execute();
				//break;
			}
		}
	}
	
	public function actionUpdateproductavailability()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select virtuemart_product_id, product_availability FROM s9r5d_virtuemart_products";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		//echo'<pre>';print_r($rows);echo'</pre>';
		
		
		foreach($rows as $r)	{
			$sql = "UPDATE  {{shop_products}} SET  `product_availability` =  '".$r['product_availability']."' WHERE  `product_id` = ".$r['virtuemart_product_id'];
			//$sql = "INSERT INTO {{subscribers}}(`company_id`, `user_id`, `email`) VALUES (".$row['company_id'].", ".$row['yii_user_id'].", '".$row['email']."')";
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
		echo'<pre>ok</pre>';
		
		
	}	
	
	public function actionCheckcategoriesmedias()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{shop_categories_medias}}";
		$command = $connection->createCommand($sql);
		$shop_categories_medias = $command->queryAll();
		//echo'<pre>';print_r($shop_categories_medias);echo'</pre>';		
		
		$sql = "select * FROM {{shop_categories}}";
		$command = $connection->createCommand($sql);
		$shop_categories = $command->queryAll();
		//echo'<pre>';print_r($shop_categories);echo'</pre>';
		
		$no = 0;
		foreach($shop_categories_medias as $scm)	{
			$present = false;
			foreach($shop_categories as $sc)	{
				if($scm['category_id'] == $sc['id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_categories_medias}} WHERE  `id` = ".$scm['id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
	}
		
	public function actionCheckprices()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{shop_product_prices}}";
		$command = $connection->createCommand($sql);
		$shop_product_prices = $command->queryAll();
		//echo'<pre>';print_r($shop_categories_medias);echo'</pre>';		
		
		$sql = "select * FROM {{shop_products}}";
		$command = $connection->createCommand($sql);
		$shop_products = $command->queryAll();
		//echo'<pre>';print_r($shop_categories);echo'</pre>';
		
		$no = 0;
		foreach($shop_product_prices as $scm)	{
			$present = false;
			foreach($shop_products as $sc)	{
				if($scm['product_id'] == $sc['product_id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_product_prices}} WHERE  `product_id` = ".$scm['product_id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
	}
	
	public function actionCheckprodmedias()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{shop_products_medias}}";
		$command = $connection->createCommand($sql);
		$shop_product_prices = $command->queryAll();
		//echo'<pre>';print_r($shop_categories_medias);echo'</pre>';		
		
		$sql = "select * FROM {{shop_products}}";
		$command = $connection->createCommand($sql);
		$shop_products = $command->queryAll();
		//echo'<pre>';print_r($shop_categories);echo'</pre>';
		
		$no = 0;
		foreach($shop_product_prices as $scm)	{
			$present = false;
			foreach($shop_products as $sc)	{
				if($scm['product_id'] == $sc['product_id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_products_medias}} WHERE  `product_id` = ".$scm['product_id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
		
		
	}
	
	public function actionCheckproductscategoriesproducts()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{shop_products_categories}}";
		$command = $connection->createCommand($sql);
		$shop_product_prices = $command->queryAll();
		//echo'<pre>';print_r($shop_categories_medias);echo'</pre>';		
		
		$sql = "select * FROM {{shop_products}}";
		$command = $connection->createCommand($sql);
		$shop_products = $command->queryAll();
		//echo'<pre>';print_r($shop_categories);echo'</pre>';
		
		$no = 0;
		foreach($shop_product_prices as $scm)	{
			$present = false;
			foreach($shop_products as $sc)	{
				if($scm['product_id'] == $sc['product_id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_products_categories}} WHERE  `product_id` = ".$scm['product_id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
		
		
	}
	
	public function actionCheckproductscategoriescategories()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{shop_products_categories}}";
		$command = $connection->createCommand($sql);
		$shop_products_categories = $command->queryAll();
		//echo'<pre>';print_r($shop_categories_medias);echo'</pre>';		
		
		$sql = "select * FROM {{shop_categories}}";
		$command = $connection->createCommand($sql);
		$shop_categories = $command->queryAll();
		//echo'<pre>';print_r($shop_categories);echo'</pre>';
		
		$no = 0;
		foreach($shop_products_categories as $scm)	{
			$present = false;
			foreach($shop_categories as $sc)	{
				if($scm['category_id'] == $sc['id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_products_categories}} WHERE  `id` = ".$scm['id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
	}
	
	//обновляет поле "user_id"
	public function actionCheckcompanies()
	{
		//echo'<pre>';print_r('moveusers');echo'</pre>';
		$connection = Yii::app()->db;
		
		$sql = "select * FROM {{companies}}";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		
		foreach($rows as $row)	{
			$sql = "select * FROM s9r5d_k2_items WHERE `title` = '".$row['title']."'";			
			$command = $connection->createCommand($sql);
			$company = $command->queryRow();
			echo'<pre>';print_r($company);echo'</pre>';
			
			$sql = "select `username` FROM s9r5d_users WHERE `id` = '".$company['created_by']."'";			
			$command = $connection->createCommand($sql);
			$username = $command->queryRow();
			echo'<pre>';print_r($username);echo'</pre>';
			
			$sql = "select `id` FROM {{users}} WHERE `username` = '".$username['username']."'";			
			$command = $connection->createCommand($sql);
			$user_id = $command->queryRow();
			echo'<pre>';print_r($user_id);echo'</pre>';
			
			$sql = "UPDATE {{companies}} SET `user_id` = ".$user_id['id']." WHERE  `id` = ".$row['id'];
			$command = $connection->createCommand($sql);
			$res = $command->execute();
			
			
			
			/*
			foreach($shop_categories as $sc)	{
				if($scm['category_id'] == $sc['id'])	{
					$present = true;
					break;
				}
			}
			//echo'<pre>';var_dump($present);echo'</pre>';
			if($present === false)	{
				$no++;
				//echo'<pre>';print_r($scm['id']);echo'</pre>'; 3hnspc_shop_product_prices
				$sql = "DELETE FROM {{shop_products_categories}} WHERE  `id` = ".$scm['id'];
				$command = $connection->createCommand($sql);
				$res = $command->execute();
			}
			*/
		}
		echo'<pre>ok</pre>';
		echo'<pre>';print_r($no);echo'</pre>';
	}
	
}