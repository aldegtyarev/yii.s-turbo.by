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
		//$app = Yii::app();
		//UrlHelper::checkChangeAuto($app);
		$meta_info = Meta::getMetaInfo();
		$this->render('index',array('meta_info'=>$meta_info));
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
	
	/**
	 * Displays the contact page
	 */
	public function actionBackcall()
	{
		$model = new BackCallForm;
		if(isset($_POST['BackCallForm']))
		{
			$model->attributes=$_POST['BackCallForm'];
			if($model->validate())	{
				$data = array('model' => $model);
				
				$to = array(Yii::app()->params['adminEmail']);
				
				Yii::app()->dpsMailer->sendByView(
					$to, // определяем кому отправляется письмо
					'emailBackCall', // view шаблона письма
					$data
				);
				
				if(Yii::app()->request->isAjaxRequest)	return $this->renderPartial('back-call-result',array('model'=>$model));
					else return $this->render('back-call-result',array('model'=>$model));
				
				
				//$this->refresh();
			}
		}
		
		if(Yii::app()->request->isAjaxRequest)	$this->renderPartial('back-call',array('model'=>$model));
			else $this->render('back-call',array('model'=>$model));
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
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionBuildsitemap()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$categories_urls = ShopCategories::model()->getAllCategoriesUrls($this, $connection);
		$product_urls = ShopProducts::model()->getAllProductsUrls($this, $connection);
		$pages_urls = Pages::model()->getAllUrlsForSitemap($this, $connection);
		//die;
		
		//$urls = $product_urls + $pages_urls;
		$urls = array_merge($categories_urls, $product_urls , $pages_urls);
		
		$sitemap_file = Yii::getPathOfAlias('webroot') . '/sitemap.xml';
		
		$date_now = date('Y-m-d');
		
		$dom = new domDocument("1.0", "utf-8");
		$urlset = $dom->createElement("urlset");
		$urlset->setAttribute("xmlns", 'http://www.sitemaps.org/schemas/sitemap/0.9');
		
		$dom->appendChild($urlset);
		
		foreach($urls as $item) {
			$url = $dom->createElement('url');
			$urlset->appendChild($url);

			$loc = $dom->createElement('loc', $item);
			$lastmod = $dom->createElement('lastmod', $date_now);
			$changefreq = $dom->createElement('changefreq', 'weekly');
			$priority = $dom->createElement('priority', '1.0');

			$url->appendChild($loc);
			$url->appendChild($lastmod);
			$url->appendChild($changefreq);
			$url->appendChild($priority);
		}
		
		$dom->save($sitemap_file);

		//$data = implode("", file("bigfile.txt"));
		$gzdata = gzencode($sitemap_file, 9);
		$fp = fopen(Yii::getPathOfAlias('webroot') . '/sitemap.xml.gz', "w");
		fwrite($fp, $gzdata);
		fclose($fp);

		$this->redirect('/admin.php?r=site/buildsitemapfinished&rows='.count($urls));
	}	
	
	public function actionRenderlastviewed()
	{
		$this->renderPartial('last-viewed');
	}	
	
	
}