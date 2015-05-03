<?php

/**
 * This is the model class for table "{{shop_products}}".
 *
 * The followings are the available columns in table '{{shop_products}}':
 * @property string $product_id
 * @property string $product_s_desc
 * @property string $product_desc
 * @property string $product_name
 * @property string $product_sku
 * @property integer $published
 * @property string $metadesc
 * @property string $metakey
 * @property string $customtitle
 * @property string $slug
 * @property string $product_video
 * @property string $product_charact
 * @property integer $firm_id
 * @property integer $type_id
 * @property integer $protect_copy
 * @property integer $product_ordered
 * @property string $product_availability
 * @property string $manuf
 * @property string $material
 * @property string $code
 * @property string $in_stock
 * @property string $delivery
 * @property string $prepayment
 *
 * The followings are the available model relations:
 * @property ShopProductPrices[] $shopProductPrices
 * @property ShopProductsCategories[] $shopProductsCategories
 * @property ShopProductsMedias[] $shopProductsMediases
 */
class ShopProducts extends CActiveRecord implements IECartPosition
{
    const SCENARIO_UPLOADING_FOTO = 'uploading_foto';
	
	public $file_url_thumb;
    public $product_price;
    public $product_override_price;
    public $product_currency;
    public $product_url;
    public $uploading_foto;
    
	public $operate_method;
	
    public $DropDownListAdminCategories;
    public $SelectedAdminCategories;
    public $admin_category_ids;
	
    public $DropDownListCategories;
    public $SelectedCategories;
    public $category_ids;
	
    public $DropDownListModels;
    public $SelectedModels;
    public $model_ids;
    public $AllModelslist;
	
    public $DropDownListBodies;
    public $SelectedBodies;
    public $body_ids;
	
	public $DropDownListManufacturers;
	public $SelectedManufacturerId;
	
	public $DropDownListFirms;
	public $SelectedFirmId;
	
	public $DropDownListTypes;
	public $SelectedTypeId;
	
	public $DropDownProductAvailability;
	public $SelectedProductAvailabilityId;
	public $ProductAvailabilityArray = array(
		0 => array('id' => 0, 'name' => 'не указано'),
		1 => array('id' => 1, 'name' => 'под заказ'),
	);
	public $product_availability_str;
	
	public $DropDownProductSide;
	public $SelectedProductSideId;
	public $ProductSideArray = array(
        0 => array('id' => 0, 'name' => 'не указано'),
		1 => array('id' => 1, 'name' => 'левая (водительская)'),
		2 => array('id' => 2, 'name' => 'правая (пассажирская)'),

		3 => array('id' => 3, 'name' => 'левая = правая'),
		4 => array('id' => 4, 'name' => 'левая + правая (комплект)'),		
	);
	
	public $product_ids;
	public $SelectedCategory;
	public $SelectedModel;
	
	public $AdditionalImages = array();
	public $firm_name = array();
    
    public $_modelsList = '';
    
    
	
	
	/**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_products}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_name, product_sku', 'required'),
            array('published, hide_s_desc, firm_id, type_id, protect_copy, product_availability, product_ordered, manufacturer_id, override, side', 'numerical', 'integerOnly'=>true),
            array('metatitle, manuf, material, code, in_stock, delivery, prepayment, lamps, adjustment, product_s_desc', 'length', 'max'=>255),
            array('product_desc, installation, metadesc', 'length', 'max'=>17000),
            array('product_name', 'length', 'max'=>180),
            array('product_sku', 'length', 'max'=>64),
            array('metakey, slug', 'length', 'max'=>192),
			array('product_price, product_override_price', 'length', 'max'=>15),
			array('uploading_foto', 'file', 'types'=>'JPG,JPEG,PNG', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб', 'tooSmall' => 'Не формат', 'on'=>self::SCENARIO_UPLOADING_FOTO),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_id, product_s_desc, product_desc, product_name, product_sku, published, metadesc, metakey, metatitle, slug, firm_id, type_id, protect_copy, product_availability, manuf, material, code, in_stock, delivery, prepayment, category_ids, manufacturer_id, product_price, override, product_override_price, product_ids, SelectedCategory, side, lamps, adjustment', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'shopProductPrices' => array(self::HAS_MANY, 'ShopProductPrices', 'product_id'),
            'manufacturer' => array(self::BELONGS_TO, 'ShopManufacturers', 'manufacturer_id'),
            'firm' => array(self::BELONGS_TO, 'ShopFirms', 'firm_id'),
            'type' => array(self::BELONGS_TO, 'ShopProductTypes', 'type_id'),
            'ProductsBodies' => array(self::HAS_MANY, 'ShopProductsBodies', 'product_id'),
            'ProductsCategories' => array(self::HAS_MANY, 'ShopProductsCategories', 'product_id'),
            'Images' => array(self::HAS_MANY, 'ShopProductsImages', 'product_id'),
            'shopProductsMediases' => array(self::HAS_MANY, 'ShopProductsMedias', 'product_id', 'with'=>'media'),
			'ProductsModelsAutos' => array(self::HAS_MANY, 'ShopProductsModelsAuto', 'product_id', 'with'=>'model'),
			'ProductsRelations' => array(self::HAS_MANY, 'ShopProductsRelations', 'product_id'),
			'ProductsRelations1' => array(self::HAS_MANY, 'ShopProductsRelations', 'product_related_id'),
			'ProductsAdminCategories' => array(self::HAS_MANY, 'ShopProductsAdminCategories', 'product_id'),			
		);
		
		
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'product_id' => 'id',
            'product_s_desc' => 'Описание',
            'product_desc' => 'Полное описание',
            'installation' => 'Установка',
            'product_name' => 'Название',
            'product_sku' => 'Артикул',
            'published' => 'Публикация',
            'metadesc' => 'meta description',
            'metakey' => 'meta keywords',
            'metatitle' => 'meta title',
            'slug' => 'Псевдоним',
            'manufacturer_id' => 'Производитель (для меня)',
            'firm_id' => 'Производитель',
            'type_id' => 'Внутренние категории',
            'protect_copy' => 'Защита от копирования',
            'product_availability' => 'Наличие',
            'manuf' => 'Производитель',
            'material' => 'Материал',
            //'code' => 'Код товара',
            //'in_stock' => 'Наличие',
            'delivery' => 'Доставка',
            'prepayment' => 'Предоплата',
            'DropDownListCategories' => 'DropDownListCategories',
            'category_ids' => 'Категории',
            'model_ids' => 'Модельный ряд',
            'body_ids' => 'Уточняющий год',
            'product_price' => 'Цена',
            'override' => 'Выводить акционную цену',
            'product_override_price' => 'Акционная цена',
            'side' => 'Сторона',
            'lamps' => 'Лампочки',
            'adjustment' => 'Регулировка',
            'admin_category_ids' => 'Админ. категории',
            'modelsList' => 'Модельный ряд',
            'hide_s_desc' => 'Не вводить краткое описание в карточке  товара',
        );
    }
    
    public function getModelsList()
    {
        $this->_modelsList = '';
		$list = array();
		// 11
		
		/*
		$model_ids = ShopProductsModelsAuto::model()->getModelIdsFromProduct($this->product_id);
        if(is_array($model_ids))	{
			foreach($model_ids as $model_id)   {
				$list[] = ShopModelsAuto::model()->getFullNameModel($model_id);
			}

			$this->_modelsList = implode(',<br>', $list);			
		}
		//	30 -> 191
        */
		
		$model_list = ShopProductsModelsAuto::model()->getModelsFullNames($this->product_id);
        if(is_array($model_list))	{
			foreach($model_list as $model)   {
				$list[] = $model['fullname'];
			}
			$this->_modelsList = implode('<br>', $list);
			//echo'<pre>';print_r(implode(',<br>', $list),0);echo'</pre>';
		}
		// 30 -> 71
        
        return $this->_modelsList;
    }

    public function setModelsList($value)
    {
        $this->_modelsList = $value;
    }    

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
		
		$sort = new CSort();
		
		
		$app = Yii::app();

		$this->SelectedCategory = 0;
		if(isset($app->session['ShopProducts.selected_category']))	{
			$this->SelectedCategory = (int)$app->session['ShopProducts.selected_category'];
		}
		
		$this->SelectedModel = 0;
		if(isset($app->session['ShopModelsAuto.selected_model']))	{
			$this->SelectedModel = (int)$app->session['ShopModelsAuto.selected_model'];
		}

		//если выбрана атегория, то получаем id товаров из выбранной и вложенной категорий
		if($this->SelectedCategory)	{
			$cat_ids = ShopCategories::model()->getChildrensIds($this->SelectedCategory);
			$this->product_ids = ShopProductsCategories::model()->getProductIdsInCategories($cat_ids);
			if($this->product_ids)	{
				$criteria->condition = "t.`product_id` IN ($this->product_ids)";
			}
		}
		
		//если выбрана модель авто, то получаем id товаров из выбранной и вложенной категорий
		if($this->SelectedModel)	{
			$cat_ids = ShopModelsAuto::model()->getChildrensIds($this->SelectedModel);
			$this->product_ids = ShopProductsModelsAuto::model()->getProductIdsInCategories($cat_ids);
			if($this->product_ids)	{
				$criteria->condition = "t.`product_id` IN ($this->product_ids)";
			}
		}

        $criteria->compare('product_id',$this->product_id,true);
        $criteria->compare('product_s_desc',$this->product_s_desc,true);
        $criteria->compare('product_desc',$this->product_desc,true);
        $criteria->compare('product_name',$this->product_name,true);
        $criteria->compare('product_sku',$this->product_sku,true);
        $criteria->compare('published',$this->published);
        $criteria->compare('metadesc',$this->metadesc,true);
        $criteria->compare('metakey',$this->metakey,true);
        $criteria->compare('metatitle',$this->metatitle,true);
        $criteria->compare('firm_id',$this->firm_id);
        $criteria->compare('type_id',$this->type_id);
        $criteria->compare('protect_copy',$this->protect_copy);
        $criteria->compare('product_availability',$this->product_availability,true);
        $criteria->compare('manuf',$this->manuf,true);
        $criteria->compare('material',$this->material,true);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('in_stock',$this->in_stock,true);
        $criteria->compare('delivery',$this->delivery,true);
        $criteria->compare('prepayment',$this->prepayment,true);
		
		$sort->defaultOrder = '`product_id` DESC'; // устанавливаем сортировку по умолчанию
		
		

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'sort'=>$sort,
			
			'pagination'=>array(
				'pageSize' => $app->params->pagination['per_page'],
			),		
			
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShopProducts the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	protected function beforeSave()
	{
		if(parent::beforeSave())	{
			$app = Yii::app();
			
			//echo'<pre>';print_r($this->product_name);echo'</pre>';//die;
			
			//приводим название к верхнему регистру
			$this->product_name = mb_strtoupper($this->product_name, 'UTF-8');
			
			//echo'<pre>';print_r($this->product_name);echo'</pre>';die;
			
			$delete_foto = $app->request->getParam('delete_foto', array());
			
			//если не удаялем фото - то назначаем выбранное основным
			if(!count($delete_foto))	{
				$main_foto = $app->request->getParam('main_foto', 0);
				if($main_foto)	{
					$this->product_image = ShopProductsImages::model()->findByPk($main_foto)->image_file;
				}
			}
			return true;			
		}
	}
	
	public function afterSave()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		switch($this->operate_method)	{
			case 'insert':
				ShopProductsAdminCategories::model()->insertItemCategories($this->SelectedAdminCategories, $this->product_id, $connection);
				ShopProductsCategories::model()->insertItemCategories($this->SelectedCategories, $this->product_id, $connection);
				ShopProductsModelsAuto::model()->insertItemModels($this->SelectedModels, $this->product_id, $connection);
				ShopProductsBodies::model()->insertItemBodies($this->SelectedBodies, $this->product_id, $connection);
				break;
			
			case 'update':
				$this->checkProductAdminCategories($connection);
				$this->checkProductCategories($connection);
				$this->checkProductsModels($connection);
				$this->checkProductsBodies($connection);
				$this->checkMainFoto($app, $connection);
				$this->checkRelated($app, $connection);
				break;
		}
		
		//если нужно - загружаем и обрабатываем фото
		$no_watermark = $app->request->getParam('no_watermark', 0);
		//echo'<pre>';print_r($no_watermark);echo'</pre>';die;
		$this->uploadFoto($no_watermark);
	}
	
	//проверяем, не изменились ли адм. категории...
	function checkProductAdminCategories(&$connection)
	{
		$ProductsAdminCategories = $this->ProductsAdminCategories;
		if(count($ProductsAdminCategories))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		//проверяем, не изменились ли категории...
		if(count($ProductsAdminCategories) != count($this->SelectedAdminCategories))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsAdminCategories as $cat_item)	{
				$cat_is_present = false;
				foreach($this->SelectedAdminCategories as $key=>$val)	{
					if($cat_item['category']['id'] == $key)	{
						$cat_is_present = true;
					}
				}
				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}

		if($arrays_of_identical == false)	{
			ShopProductsAdminCategories::model()->clearItemCategories($this->product_id, $connection);
			ShopProductsAdminCategories::model()->insertItemCategories($this->SelectedAdminCategories, $this->product_id, $connection);
		}
	}
	
	//проверяем, не изменились ли категории...
	function checkProductCategories(&$connection)
	{
		$ProductsCategories = $this->ProductsCategories;
		if(count($ProductsCategories))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		//проверяем, не изменились ли категории...
		if(count($ProductsCategories) != count($this->SelectedCategories))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsCategories as $cat_item)	{
				$cat_is_present = false;
				foreach($this->SelectedCategories as $key=>$val)	{
					if($cat_item['category']['id'] == $key)	{
						$cat_is_present = true;
					}
				}
				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}

		if($arrays_of_identical == false)	{
			ShopProductsCategories::model()->clearItemCategories($this->product_id, $connection);
			ShopProductsCategories::model()->insertItemCategories($this->SelectedCategories, $this->product_id, $connection);
		}
	}
	
	//проверяем, не изменились ли модели авто...
	function checkProductsModels(&$connection)
	{
		$ProductsModels = $this->ProductsModelsAutos;

		if(count($ProductsModels))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		if(count($ProductsModels) != count($this->SelectedModels))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsModels as $cat_item)	{
				$cat_is_present = false;

				foreach($this->SelectedModels as $key=>$val)	{
					if($cat_item['model']['id'] == $key)	{
						$cat_is_present = true;
					}
				}

				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}

		if($arrays_of_identical == false)	{
			ShopProductsModelsAuto::model()->clearItemModels($this->product_id, $connection);
			ShopProductsModelsAuto::model()->insertItemModels($this->SelectedModels, $this->product_id, $connection);
		}
		
	}
	
	//проверяем, не изменились ли кузова...
	function checkProductsBodies(&$connection)
	{
		$ProductsBodies = $this->ProductsBodies;

		if(count($ProductsBodies))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		if(count($ProductsBodies) != count($this->SelectedBodies))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsBodies as $cat_item)	{
				$cat_is_present = false;

				foreach($this->SelectedBodies as $key=>$val)	{
					if($cat_item['body']['id'] == $key)	{
						$cat_is_present = true;
					}
				}

				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}
		//echo'<pre>';var_dump($arrays_of_identical);echo'</pre>';die;
		if($arrays_of_identical == false)	{
			ShopProductsBodies::model()->clearItemBodies($this->product_id, $connection);
			ShopProductsBodies::model()->insertItemBodies($this->SelectedBodies, $this->product_id, $connection);
		}
		
	}

	function checkMainFoto(&$app, &$connection)
	{
		$main_foto = $app->request->getParam('main_foto', 0);
		if($main_foto)	{
			ShopProductsImages::model()->setMainFoto($connection, $main_foto, $this->product_id);
			//$this->product_image = ShopProductsImages::model()->findByPk($main_foto)->image_file;
		}
	}
	
	function checkRelated(&$app, &$connection)
	{
		$related_product_ids = $app->request->getParam('related_product_ids', array());
		$RelatedProducts = $this->ProductsRelations;
		//echo'<pre>';print_r($related_product_ids);echo'</pre>';
		//echo'<pre>';print_r($RelatedProducts);echo'</pre>';
		//die;
		
		$arrays_of_identical = true;
		if(count($related_product_ids) != count($RelatedProducts))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($RelatedProducts as $item)	{
				$item_is_present = false;
				/*
				foreach($related_product_ids as $product_id)	{
					if($cat_item['body']['body_id'] == $key)	{
						$cat_is_present = true;
					}
				}
				*/
				if($item_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
			
		}
		
		if($arrays_of_identical == false)	{
			ShopProductsRelations::model()->clearRelatedProducts($this->product_id, $connection);
			ShopProductsRelations::model()->insertRelatedProducts($related_product_ids, $this->product_id, $connection);
		}
		

	}
			
    function getId(){
        return 'ShopProducts'.$this->product_id;
    }

    function getPrice()	{
		$product_price = $this->product_price;
		
		if($this->product_override_price != 0)
        	$product_price = $this->shopProductPrices->product_override_price;
		
		return $product_price;
    }	
	
	public function findProductsInCat($category_id = 0, $type = 0, $firm = 0, $body = 0, $model_ids = array())
	{		
		$app = Yii::app();
		$connection = $app->db;
		
		$criteria = new CDbCriteria();
		/*
		$criteria->select = "t.*, m.`file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = '
		inner join {{shop_products_categories}} AS pc USING (`product_id`) 
		INNER JOIN {{shop_products_medias}} AS pm USING (`product_id`) 
		INNER JOIN {{shop_medias}} AS m USING (`media_id`) 
		INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';
		*/
		
		$criteria->select = "t.product_id";
		$criteria->join = 'INNER JOIN {{shop_products_categories}} AS pc USING (`product_id`) ';
		
		
		//$criteria->condition = "pc.`category_id` = $category_id AND t.`published` = 1";
		$condition_arr = array();
		$condition_arr[] = "pc.`category_id` = $category_id";
		
		if(count($model_ids))	{
			$product_ids = ShopProductsModelsAuto::model()->getProductIdFromModels($connection, $model_ids);
			if(count($product_ids))	{
				$condition_arr[] = "t.`product_id` IN (".implode(', ', $product_ids).")";
			}
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = "pc.`ordering`, t.`product_id`";
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		
		//получаем сначала все позиции для получения их id без учета пагинации
		$rows = $this->findAll($criteria);
		
		if($type != 0)	{
			$condition_arr[] = "t.type_id = $type";
		}
		
		if($firm != 0)	{
			$condition_arr[] = "t.firm_id = $firm";
		}
		
		if($body != 0)	{
			$criteria->join .= ' INNER JOIN {{shop_products_bodies}} AS pb USING (`product_id`) ';
			$condition_arr[] = "pb.body_id = $body";
		}
		
		$criteria->condition = implode(' AND ', $condition_arr);
		
		$product_ids = $this->getProductIds($rows);
		/*
		if(count($rows))	{
			foreach($rows as $row)	{
				$product_ids[] = $row->product_id;
			}
		}
		*/
		//echo'<pre>';print_r(count($rows),0);echo'</pre>';
		//echo'<pre>';print_r(($rows),0);echo'</pre>';
		
		$criteria->select = "t.*";
		
		//$count = User::model()->count($criteria);
		$count = $this->count($criteria);
		$pages = new CPagination($count);
		//echo'<pre>';print_r($count,0);echo'</pre>';
		
		$pages->pageSize = Yii::app()->params->pagination['products_per_page']; // элементов на страницу
		$pages->applyLimit($criteria);
		$rows1 = $this->findAll($criteria);
		$rows = array();
		foreach($rows1 as $row)	{
			$rows[$row->product_id] = $row;
		}
		//echo'<pre>';print_r(count($rows),0);echo'</pre>';
		return array(
			'rows' => $rows, 
			'pages' => $pages,
			'product_ids' => $product_ids,
		);
	}

	public function findBySlug($slug)
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('shopProductPrices', 'shopProductsMediases');
		$criteria->condition = "`slug` = '$slug'";
		$row = $this->find($criteria);
		return $row;
	}
	
	// получает последние добавленные товары
	public function getLastAddedProducts()
	{		
		$criteria = new CDbCriteria();
		/*
		$criteria->select = "t.*, (SELECT m.`file_url_thumb` FROM `3hnspc_shop_medias` AS m INNER JOIN `3hnspc_shop_products_medias` AS pm USING (`media_id`) WHERE pm.`product_id` = t.`product_id` LIMIT 1) AS `file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = 'INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';
		*/

		$criteria->select = "t.*";

		
		
		//$criteria->condition = "t.`published` = 1 AND (t.`product_id` IN (117,112,158,288,2026,7292,1102))";
		$criteria->condition = "t.`published` = 1";
		$criteria->order = "t.`product_id` DESC";
		$criteria->limit = 7;
		//echo'<pre>';print_r($criteria, 0);echo'</pre>';

		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return $rows;
	}
	
	
	// получает последние просмотренные товары
	public function getLastViewedProducts()
	{		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*, (SELECT m.`file_url_thumb` FROM `3hnspc_shop_medias` AS m INNER JOIN `3hnspc_shop_products_medias` AS pm USING (`media_id`) WHERE pm.`product_id` = t.`product_id` LIMIT 1) AS `file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = 'INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';
		
		
		//$criteria->condition = "t.`published` = 1";
		$criteria->condition = "t.`published` = 1 AND (t.`product_id` IN (117,112,158,288,2026,1102))";
		$criteria->order = "t.`product_id` DESC";
		$criteria->limit = 3;
		//echo'<pre>';print_r($criteria, 0);echo'</pre>';

		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return $rows;
	}
	
	//загрузка фото
	public function uploadFoto($no_watermark = 0)
	{
		$app = Yii::app();
		if($this->uploading_foto != null)	{
			$product_imagePath = Yii::getPathOfAlias($app->params->product_imagePath);

			$file_extention = $this->getExtentionFromFileName($this->uploading_foto->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$file_path = $product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
			
			$this->uploading_foto->saveAs($file_path);

			
			$img_width_config = $app->params->product_tmb_params['width'];
			$img_height_config = $app->params->product_tmb_params['height'];
			
			if($no_watermark == 0)	{
				if($file_extention == '.jpg' || $file_extention == '.jpeg'){
					$img = imagecreatefromjpeg($file_path);
				} elseif($file_extention == '.png'){
					$img = imagecreatefrompng($file_path);
				}

				$water = imagecreatefrompng(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");
				$im = $this->create_watermark($img, $water);
				imagejpeg($im, $file_path);
			}
			
			$Image = $app->image->load($file_path);
			
			if(($Image->width/$Image->height) >= ($img_width_config/$img_height_config)){
				$Image -> resize($img_width_config, $img_height_config, Image::HEIGHT);
			}	else	{
				$Image -> resize($img_width_config, $img_height_config, Image::WIDTH);
			}
			//$Image->crop($img_width_config, $img_height_config, 'top', 'center')->quality(75);
			$Image->resize($img_width_config, $img_height_config)->quality(75);
			//echo'<pre>';print_r($app->params->product_tmb_params,0);echo'</pre>';die;
			$Image->save($product_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
			
			$foto = new ShopProductsImages;
			$foto->product_id = $this->product_id;
			$foto->image_file = $filename;
			$foto->save();
			
			$Images = $this->Images;
			//echo'<pre>';print_r($Images, 0);echo'</pre>';die;
			
			if(count($Images) == 1)	{
				$connection = $app->db;				
				
				ShopProductsImages::model()->setMainFoto($connection, $Images[0]->image_id, $this->product_id);
				
				$this->setProductImage($connection,  $Images[0]->image_file, $this->product_id);
			}
			
		}
	}
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
	//получает выбранные категории для товара
	function getSelectedCategories()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsCategories,0);echo'</pre>';die;
		
		foreach($this->ProductsCategories as $cat) {
			//echo'<pre>';print_r($cat,0);echo'</pre>';
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';die;
			$selectedValues[$cat['category']['id']] = Array ( 'selected' => 'selected' );
		}
		//die;
		$this->SelectedCategories = $selectedValues;		
	}
	
	//получает выбранные адм. категории для товара
	function getSelectedAdminCategories()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsCategories,0);echo'</pre>';die;
		
		foreach($this->ProductsAdminCategories as $cat) {
			//echo'<pre>';print_r($cat,0);echo'</pre>';
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';die;
			$selectedValues[$cat['category']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedAdminCategories = $selectedValues;		
	}
	
	//получает выбранные модели для товара
	function getSelectedModels()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsModelsAutos,0);echo'</pre>';die;
		
		foreach($this->ProductsModelsAutos as $row) {
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';
			$selectedValues[$row['model']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedModels = $selectedValues;
	}
	
	//получает выбранные модели для товара
	function getSelectedBodies()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsModelsAutos,0);echo'</pre>';die;
		
		foreach($this->ProductsBodies as $row) {
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';
			$selectedValues[$row['body']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedBodies = $selectedValues;
	}
	
	function getDropDownProductAvailability()
	{
		$result = CHtml::listData($this->ProductAvailabilityArray, 'id', 'name');
		return $result;
	}
	
	function getDropDownProductSide()
	{
		$result = CHtml::listData($this->ProductSideArray, 'id', 'name');
		return $result;
	}
	
	//копирование товара
	function copyProduct()
	{
		$app = Yii::app();
		//создаем копию изображений товара
		$command = $app->db->createCommand();
		
		$command->insert('{{shop_products}}', array(
			'product_s_desc' => $this->product_s_desc,
			'product_desc' => $this->product_desc,
			'product_name' => $this->product_name.' copy',
			'product_sku' => $this->product_sku,
			'manufacturer_id' => $this->manufacturer_id,
			'firm_id' => $this->firm_id,
			'type_id' => $this->type_id,
			'product_image' => $this->product_image,
			'metadesc' => $this->metadesc,
			'metakey' => $this->metakey,
			'metatitle' => $this->metatitle,
			'slug' => $this->slug,
			'product_type_id' => $this->product_type_id,
			'protect_copy' => $this->protect_copy,
			'product_ordered' => $this->product_ordered,
			'product_availability' => $this->product_availability,
			'manuf' => $this->manuf,
			'material' => $this->material,
			'code' => $this->code,
			'side' => $this->side,
			'lamps' => $this->lamps,
			'adjustment' => $this->adjustment,
			'in_stock' => $this->in_stock,
			'delivery' => $this->delivery,
			'prepayment' => $this->prepayment,
			'product_price' => $this->product_price,
			'override' => $this->override,
			'product_override_price' => $this->product_override_price,
		));
		$new_product_id = $app->db->getLastInsertId();
		
		$command->reset();
		
		
		// дублируем адм. категории товара
		$ProductsAdminCategories = $this->ProductsAdminCategories;
		if(count($ProductsAdminCategories))	{
			foreach($ProductsAdminCategories as $row)	{
				$command->insert('{{shop_products_admin_categories}}', array(
					'product_id' => $new_product_id,
					'category_id' => $row['category_id'],
					'ordering' => $row['ordering'],
				));
				$command->reset();
			}
		}
		
		// дублируем категории товара
		$ProductsCategories = $this->ProductsCategories;
		if(count($ProductsCategories))	{
			foreach($ProductsCategories as $row)	{
				$command->insert('{{shop_products_categories}}', array(
					'product_id' => $new_product_id,
					'category_id' => $row['category_id'],
					'ordering' => $row['ordering'],
				));
				$command->reset();
			}
		}
		
		// дублируем модельный ряд товара
		$ProductsModelsAutos = $this->ProductsModelsAutos;
		if(count($ProductsModelsAutos))	{
			foreach($ProductsModelsAutos as $row)	{
				$command->insert('{{shop_products_models_auto}}', array(
					'product_id' => $new_product_id,
					'model_id' => $row['model_id'],
					'ordering' => $row['ordering'],
				));
				$command->reset();
			}
		}
		
		// дублируем кузова товара
		$ProductsBodies = $this->ProductsBodies;
		if(count($ProductsBodies))	{
			foreach($ProductsBodies as $row)	{
				$command->insert('{{shop_products_bodies}}', array(
					'product_id' => $new_product_id,
					'body_id' => $row['body_id'],
				));
				$command->reset();
			}
		}
		
		// дублируем изображения товара
		$Images = $this->Images;
		if(count($Images))	{
			foreach($Images as $row)	{
				$filename = md5(date);
				
				
				$command->insert('{{shop_products_images}}', array(
					'product_id' => $new_product_id,
					'image_file' => $row['image_file'],
					'ordering' => $row['ordering'],
					'main_foto' => $row['main_foto'],
				));
				$command->reset();
			}
		}
		
		
		
		
		
		//echo'<pre>';print_r($Images[0]['image_file'],0);echo'</pre>';die;
	}

	
	function create_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 )
	{
		$alpha_level	/= 100;	# convert 0-100 (%) alpha to decimal

		# calculate our images dimensions
		$main_img_obj_w	= imagesx( $main_img_obj );
		$main_img_obj_h	= imagesy( $main_img_obj );
		$watermark_img_obj_w	= imagesx( $watermark_img_obj );
		$watermark_img_obj_h	= imagesy( $watermark_img_obj );
 
		# determine center position coordinates
		$main_img_obj_min_x	= floor( ( $main_img_obj_w / 2 ) - ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_max_x	= ceil( ( $main_img_obj_w / 2 ) + ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_min_y	= floor( ( $main_img_obj_h / 2 ) - ( $watermark_img_obj_h / 2 ) );
		$main_img_obj_max_y	= ceil( ( $main_img_obj_h / 2 ) + ( $watermark_img_obj_h / 2 ) ); 
		
		/*
		$main_img_obj_min_x_top_left = 0;		
		$main_img_obj_min_y_top_left = 0;
		
		$main_img_obj_min_x_bottom_right	= floor( ( $main_img_obj_w  ) - ( $watermark_img_obj_w  ) );
		$main_img_obj_min_y_bottom_right	= floor( ( $main_img_obj_h  ) - ( $watermark_img_obj_h  ) );
		*/

		# create new image to hold merged changes
		$return_img	= imagecreatetruecolor( $main_img_obj_w, $main_img_obj_h );
 
		# walk through main image
		for( $y = 0; $y < $main_img_obj_h; $y++ ) {
			for( $x = 0; $x < $main_img_obj_w; $x++ ) {
				$return_color	= NULL;
 
				# determine the correct pixel location within our watermark
				$watermark_x	= $x - $main_img_obj_min_x;
				$watermark_y	= $y - $main_img_obj_min_y;
 
				$watermark_x_top_left	= $x - $main_img_obj_min_x_top_left;
				$watermark_y_top_left	= $y - $main_img_obj_min_y_top_left;
 
				$watermark_x_bottom_right	= $x - $main_img_obj_min_x_bottom_right;
				$watermark_y_bottom_right	= $y - $main_img_obj_min_y_bottom_right;
 
				# fetch color information for both of our images
				$main_rgb = imagecolorsforindex( $main_img_obj, imagecolorat( $main_img_obj, $x, $y ) );
 
				# if our watermark has a non-transparent value at this pixel intersection
				# and we're still within the bounds of the watermark image
				if (
						($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h ) //||
						//($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h ) ||
						//($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )
					) {
					
					if($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x, $watermark_y ) );
					}/*	elseif	($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_top_left, $watermark_y_top_left ) );
					}	elseif($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_bottom_right, $watermark_y_bottom_right ) );
					}*/
 
					# using image alpha, and user specified alpha, calculate average
					$watermark_alpha	= round( ( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2 );
					$watermark_alpha	= $watermark_alpha * $alpha_level;
 
					# calculate the color 'average' between the two - taking into account the specified alpha level
					$avg_red		= $this->_get_ave_color( $main_rgb['red'],		$watermark_rbg['red'],		$watermark_alpha );
					$avg_green	= $this->_get_ave_color( $main_rgb['green'],	$watermark_rbg['green'],	$watermark_alpha );
					$avg_blue		= $this->_get_ave_color( $main_rgb['blue'],	$watermark_rbg['blue'],		$watermark_alpha );
 
					# calculate a color index value using the average RGB values we've determined
					$return_color	= $this->_get_image_color( $return_img, $avg_red, $avg_green, $avg_blue );
 
				# if we're not dealing with an average color here, then let's just copy over the main color
				} else {
					$return_color	= imagecolorat( $main_img_obj, $x, $y );
 
				} # END if watermark

				# draw the appropriate color onto the return image
				imagesetpixel( $return_img, $x, $y, $return_color );
 
			} # END for each X pixel
		} # END for each Y pixel
		

		# return the resulting, watermarked image for display
		return $return_img;
 
	} # END create_watermark()

	# average two colors given an alpha
	function _get_ave_color( $color_a, $color_b, $alpha_level ) {
		return round( ( ( $color_a * ( 1 - $alpha_level ) ) + ( $color_b	* $alpha_level ) ) );
	} # END _get_ave_color()

	# return closest pallette-color match for RGB values
	function _get_image_color($im, $r, $g, $b) {
		$c=imagecolorexact($im, $r, $g, $b);
		if ($c!=-1) return $c;
		$c=imagecolorallocate($im, $r, $g, $b);
		if ($c!=-1) return $c;
		return imagecolorclosest($im, $r, $g, $b);
	} # EBD _get_image_color()
	
	//устанавливает главное фото товара
	public function setProductImage(&$connection, $product_image, $product_id)
	{
		$sql = "UPDATE {{shop_products}} SET `product_image` = :product_image WHERE `product_id` = :product_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$command->bindParam(":product_image", $product_image);
		$res = $command->execute();
	}
	
	
	//устанавливает новую цену товара
	public function updateProductPrice(&$connection, $product_id, $product_price)
	{
		$sql = "UPDATE {{shop_products}} SET `product_price` = :product_price WHERE `product_id` = :product_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$command->bindParam(":product_price", $product_price);
		$res = $command->execute();
	}
	
	//возвращает массив id товаров
	public function getProductIds(&$rows)
	{
		$product_ids = array();
		if(count($rows))	{
			foreach($rows as $row)	{
				$product_ids[] = $row->product_id;
			}
		}
		return $product_ids;
		
	}
	
}