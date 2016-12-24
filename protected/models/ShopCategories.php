<?php

/**
 * This is the model class for table "{{shop_categories}}".
 *
 * The followings are the available columns in table '{{shop_categories}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property integer $ordering
 * @property string $category_companies
 * @property integer $cat_column
 */
class ShopCategories extends CActiveRecord
{
	const SCENARIO_UPLOADING_FOTO = 'uploading_foto';
	
	const CACHE_getTreeCategories_model_ids = 'ShopCategories_getTreeCategories_model_ids';
	
	public $uploading_foto;

	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	public $category_image;
	
	public $SelectedCategory;
	public $cargo_type_old;

	public $update_price_value = 0;
	public $fake_discount = 0;
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_categories}}';
	}
	
	public function behaviors()
	{
		return array(
			'tree'=>array(
				'class'=>'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'level',
				'hasManyRoots'=>true,
			),
		);
	}		

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('root, lft, rgt, level, ordering, cat_column, currency_id, cargo_type, uni, update_price_value, fake_discount', 'numerical', 'integerOnly'=>true),
			array('name, name1, metatitle, alias, category_companies', 'length', 'max'=>255),
			array('category_description, metakey, metadesc', 'length', 'max'=>7000),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'name'), 
			array('parentId, id, root, lft, rgt, level, name, title, keywords, description, alias, ordering, category_companies, cat_column, category_description', 'safe', 'on'=>'search'),
			array('uploading_foto', 'file', 'types'=>'GIF,JPG,JPEG,PNG', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб', 'tooSmall' => 'Не формат', 'on'=>self::SCENARIO_UPLOADING_FOTO),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'shopCategoriesMediases' => array(self::HAS_MANY, 'ShopCategoriesMedias', 'category_id'),
			'shopCategoriesRelations' => array(self::HAS_MANY, 'ShopCategoriesRelations', 'category_related_id'),
			'сategoriesRelated' => array(self::HAS_MANY, 'ShopCategoriesRelations', 'category_id'),
			'shopProductsCategories' => array(self::HAS_MANY, 'ShopProductsCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'parentId' => 'parentId',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'name' => 'Название',
			'name1' => 'Название 1',
			'metatitle' => 'Title',
			'metakey' => 'Keywords',
			'metadesc' => 'Description',
			'alias' => 'Alias',
			'ordering' => 'Ordering',
			'category_companies' => 'Category Companies',
			'cat_column' => 'Cat Column',
			'dropDownListTree' => 'Родительская категория',
			'category_description' => 'Описание категории',
			'currency_id' => 'Валюта по умолчанию',
			'cargo_type' => 'Тип груза',
			'uni' => 'Универсальная категория',
			'update_price_value' => 'Изменить цену на товары в группе ("+" - изменятся основная цена; "-" - устанавливается скида на товар)',
			'fake_discount' => 'Фейковая скидка',

		);
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
		$criteria=new CDbCriteria;
		$sort = new CSort();
		$app = Yii::app();

		$this->SelectedCategory = 0;
		if(isset($app->session['ShopCategories.selected_category']))
			$this->SelectedCategory = (int)$app->session['ShopCategories.selected_category'];
				
		if($this->SelectedCategory)	{
			$cat_ids = $this->getChildrensIds($this->SelectedCategory);
			if($cat_ids) $criteria->condition = "t.`id` IN ($cat_ids)";
		}

		$criteria->compare('id',$this->id);
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('metatitle',$this->metatitle,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('category_companies',$this->category_companies,true);
		$criteria->compare('cat_column',$this->cat_column);
		
       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			
			'pagination' => array(
				'pageSize' => 50,
			),			
		));
	}
	
	public function findByPath($path)
	{
		//$path_arr = explode('/', $path);
		//echo'<pre>';print_r($path_arr);echo'</pre>';
		
		$criteria = new CDbCriteria;
		//$criteria->select = "id";
		$criteria->condition = "`path` = '$path'";
		//$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$category = $this->find($criteria);
		
		//echo'<pre>';print_r($criteria);echo'</pre>';
		//echo'<pre>';print_r($category->id);echo'</pre>';
		//$descendants = $category->children()->findAll();
		//echo'<pre>';print_r($descendants);echo'</pre>';
		
		return $category;
		
	}
	
	public function getDescendants($category)
	{
		$descendants = $category->children()->findAll();
		return $descendants;
	}
	
	
	
	public function save($runValidation = true, $attributes = null)
	{
		if($this->isNewRecord)	{
			switch($this->parentId)	{
				case 0:
					$this->saveNode();
					break;
				default:
					$root = $this->findByPk($this->parentId);
					if($root)	{
						$this->appendTo($root);
					}
					break;
			}
		
		}	else	{
			if($this->new_parentId != $this->parentId)	{
				if($this->new_parentId > 0)	{
					$root = $this->findByPk($this->new_parentId);
					$this->moveAsLast($root);
				}	else	{
					$this->moveAsRoot();
				}
			}
			$this->saveNode();
		}
		return true;
	}
	
	public function afterSave()
	{
		$app = Yii::app();
		//если нужно - загружаем и обрабатываем фото
		$no_watermark = $app->request->getParam('no_watermark', 0);
		//echo'<pre>';print_r($no_watermark);echo'</pre>';die;
		$this->uploadFoto($no_watermark);
		parent::afterSave();
	}
	
	public function removeFoto()
	{
		FilesHelper::removeFoto(Yii::app()->params->category_imagePath);
		$this->foto = '';
	}

    /**
     * загрузка фото
     *
     * @param int $no_watermark
     */
	public function uploadFoto($no_watermark = 0)
	{
		if($this->uploading_foto != null)	{
			$app = Yii::app();
			
			$pages_imagePath = Yii::getPathOfAlias($app->params->category_imagePath);

			$file_extention = FilesHelper::getExtentionFromFileName($this->uploading_foto->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
						
			$this->uploading_foto->saveAs($file_path);

			
			$img_width_config = $app->params->category_tmb_params['width'];
			$img_height_config = $app->params->category_tmb_params['height'];
			
			if($no_watermark == 0)	{
				if($file_extention == '.jpg' || $file_extention == '.jpeg'){
					$img = imagecreatefromjpeg($file_path);
				} elseif($file_extention == '.png'){
					$img = imagecreatefrompng($file_path);
				} elseif($file_extention == '.gif') {
					$img = imagecreatefromgif($file_path);
				}

				$water = imagecreatefrompng(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");
				$im = FilesHelper::create_watermark($img, $water);
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
			//echo'<pre>';print_r($filename);echo'</pre>';//die;
			//echo'<pre>';print_r($this->id);echo'</pre>';die;
			$Image->save($pages_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
			
			//удалям большое фото. оно нам не нужно.
			unlink($pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename);
			
			$connection = $app->db;
			FilesHelper::setFoto($connection, $filename, $this->id, $this->tableName());
		}
	}
	
	
	//сохранение имени файла фото для страницы
//	public function setFoto(&$connection, $filename, $id)
//	{
//		$sql = "UPDATE ".$this->tableName()." SET `foto` = :foto WHERE `id` = :id";
//		$command = $connection->createCommand($sql);
//		$command->bindParam(":id", $id);
//		$command->bindParam(":foto", $filename);
//		$res = $command->execute();		
//	}
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// возвращает дерево категорий
	public function getTreeCategories($id = 0)
	{
		$app = Yii::app();
		//$connection = $app->db;
		
		if(isset($app->session['autofilter.marka'])) $filtering = true;
			else $filtering = false;

		/*
		$model_ids = $app->cache->get(self::CACHE_getTreeCategories_model_ids);
		
		if($model_ids === false)	{
			$model_ids = ShopModelsAuto::model()->getModelIds($app);
			$app->cache->set(self::CACHE_getTreeCategories_model_ids, $model_ids, $app->params['cache_duration']);
		}
		*/
		$model_ids = ShopModelsAuto::model()->getModelIds($app);
		
		//echo'<pre>';print_r($model_ids);echo'</pre>';//die;
		/*
		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id AND `show_in_menu` = 1 AND `level` <= 4";
		}	else	{
			if(count($model_ids))	{
				$category_ids = $this->getCategoryIdFromModels($connection, $model_ids);
				//echo'<pre>';print_r($model_ids);echo'</pre>';
				if(count($category_ids)) {
					$criteria->condition = "(`level` = 2 OR `id` IN (".implode(',', $category_ids)."))";
				}	else	{
					$criteria->condition = "(`id` IN (0))";
				}
			}
		}
		
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		
		//$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM '.$this->tableName());
		//$categories = $this->cache($app->params['cache_duration'])->findAll($criteria);
		
		$categories = $this->findAll($criteria);
		*/
		$categories = $this->getCategoriesList($id, $model_ids);
		
		if(count($categories) == 0 && $filtering )	{
			$categories[0] = 'Не найдено';
			return $categories;
		}	else	{
			$cat_arr = array();
			$cat_arr_inner = array();
			$level_arr = array();
			
			foreach($categories as $n => $category) {
				if($category->level > 3)	{
					//$current_category = $this->findByPk($category->id);
					//$parent = $current_category->parent()->find();
					$parent = $category->parent()->find();
					$categories[count($categories)] = $parent;
				}
			}

			//получаем id текущей категории
			$current_category_id = $app->request->getParam('id', 0);

			//получаем всех предков текущей категории
			if($current_category_id)	{
				$current_category = $this->findByPk($current_category_id);

				if(!is_null($current_category)) $current_category_ancestors = $current_category->ancestors()->findAll();
					else $current_category_ancestors = array();

			}	else	{
				$current_category_ancestors = array();
			}

			$categories1 = $categories;
			
			$selected_auto = UrlHelper::getSelectedAuto($app);
			//echo'<pre>';print_r($selected_auto);echo'</pre>';
			
			foreach($categories as $n => $category)
			{
				if($current_category_id == $category->id) {
					$active = true;
				} else {
					foreach($current_category_ancestors as $i)	{
						if($i->id == $category->id)	{
							$active = true;
							break;
						}	else	{
							$active = false;
						}
					}
				}

				$add_category = true;

				if($category->level == 2) {
					$add_category = false;
					foreach($categories1 as $category1) {
						if($category1->parent_id == $category->id) {
							$add_category = true;
							break;
						}
					}
				}
				
				//$select_marka = isset($app->session['autofilter.marka']) ? $app->session['autofilter.marka'] : -1;
				//$select_model = isset($app->session['autofilter.model']) ? $app->session['autofilter.model'] : -1;
				//$select_year = isset($app->session['autofilter.year']) ? $app->session['autofilter.year'] : -1;

				if($add_category) {
					$url_params = UrlHelper::buildUrlParams($selected_auto, $category->id, $category->uni);
					//echo'<pre>';print_r($category->uni);echo'</pre>';
					//echo'<pre>';print_r($selected_auto);echo'</pre>';
					$cat_arr[$category->id]['label'] = CHtml::encode($category->name);
					$cat_arr[$category->id]['parent_id'] = CHtml::encode($category->parent_id);
					$cat_arr[$category->id]['url'] = $url_params;
					$cat_arr[$category->id]['active'] = $active;
					$cat_arr[$category->id]['itemOptions'] = array('class'=>'cat-'.$category->id);
				}
			}
			$cat_arr = $this->mapTree($cat_arr);
			return isset($cat_arr[1]['items']) ? $cat_arr[1]['items'] : array();
		}
	}
	
	public function getCategoriesList($id = 0, $model_ids = array())
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id AND `show_in_menu` = 1 AND `level` <= 4";
		}	else	{
			if(count($model_ids))	{
				$category_ids = $this->getCategoryIdFromModels($connection, $model_ids);
				if(count($category_ids)) {
					$criteria->condition = "(`level` = 2 OR `id` IN (".implode(',', $category_ids)."))";
				}	else	{
					$criteria->condition = "(`id` IN (0))";
				}
			}
		}
		
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		return $this->findAll($criteria);		
	}
	
	function mapTree($dataset) 
	{
		$tree = array();
		foreach ($dataset as $id=>&$node) {
			if (!$node['parent_id']) {
				$tree[$id] = &$node;
			}	else {
				$dataset[$node['parent_id']]['items'][$id] = &$node;
			}
		}
		return $tree;
	}
	
	
	// возвращает выпадающий список категорий для редактирования категории
	public function getDropDownlistData()
	{
		$list_data1 = $this->getDropDownlistItems();
		
		$selected = 'Верхний уровень';
		$list_data = array(0 => $selected);
		
		$list_data = $list_data + $list_data1;
		
		$this->DropDownlistData = $list_data;
		
		return true;
	}
	
	// возвращает выпадающий список категорий для редактирования товара
	public function getDropDownlistDataProduct()
	{
		$list_data = $this->getDropDownlistItems();
		return $list_data;
	}
	
	public function getDropDownlistItems()
	{
		$criteria = new CDbCriteria;
        //$criteria->condition = "`level` > 1";
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		$level = 0;
		foreach($categories as $c){
			$separator = '';
			for ($x=1; $x++ < $c->level;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$result = CHtml::listData($categories, 'id','name');
		
		//Yii::app()->cache->set('DropDownlistCategories', $result, 300);		
		
		return $result;
	}
	
	function setparentid()
	{
		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id";
		}
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		return true;
	}
	
	public function getCategoriesMedias(&$rows)
	{
		$ids = array();
		foreach($rows as $row)	{
			$ids[] = $row->id;
		}
		//echo'<pre>';print_r($ids);echo'</pre>';
		$medias = ShopMedias::model()->getCategoriesMedias($ids);
		foreach($rows as $row)	{
			$row->category_image = $medias[$row->id];
		}		
		
	}
	
	//получаем ID родительской категории
	public function getParentId()
	{	
		$parent = $this->parent()->find();
		$this->parentId = $parent->id ? $parent->id : 0;
	}
	
	//получает список id дочерних категорий и текущей
	public function getChildrensIds($parentId)
	{
		$category = $this->findByPk($parentId);
		$descendants = $category->descendants()->findAll();
		$ids_arr = array();
		$ids_arr[] = $parentId;
		foreach($descendants as $item)	{
			$ids_arr[] = $item->id;
		}
		
		return implode(',', $ids_arr);		
		//echo'<pre>';print_r($ids_arr);echo'</pre>';
	}
	
	public function getModelsLevel1(&$connection)
	{
		$sql = "SELECT `id`, `name` FROM ".$this->tableName()." WHERE `level`= 1";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		return CHtml::listData($rows, 'id','name');
	}
	
	public function getCategoryIdFromModels(&$connection, $model_ids = array())
	{
		$disabled_product_ids = ProductsModelsDisabled::model()->getExludedProductIds($connection, $model_ids);
		if(count($disabled_product_ids) == 0) $disabled_product_ids = array(0);

		$sql = "SELECT DISTINCT(`category_id`)
				FROM {{shop_products_categories}}
				WHERE `product_id` IN (SELECT `product_id` FROM {{shop_products_models_auto}} WHERE `model_id` IN (".implode(', ', $model_ids).") AND `product_id` NOT IN (".implode(', ', $disabled_product_ids)."))";
		
		$command = $connection->createCommand($sql);
		return $command->queryColumn();
	}	
	
	public function getCategoryCurrencyId(&$connection, $id = 0)
	{
		$sql = "SELECT `currency_id` FROM ".$this->tableName()." WHERE `id`=:id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":id", $id);
		//$rows = $command->queryAll();
		return $command->queryScalar();
	}	
	
	public function updateCargoType()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$descendants = $this->children()->findAll();
		$categories = array($this->id);
		
		foreach($descendants as $descendant) $categories[] = $descendant->id;
		
		$product_ids = ShopProductsCategories::model()->getProductIdsInCategories((implode(',', $categories)));
		
		$res = false;
		
		if($product_ids != '-1')	{
			$sql = 'UPDATE {{shop_products}} SET `cargo_type` = '.$this->cargo_type. ' WHERE `product_id` IN ('.$product_ids.')' ;
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
		
		return $res;
	}
	
	/**
	 * возвращает
	 * @return array
	 */
	public function getAllCategoriesUrls(&$controller, &$connection)
	{
		$categories_urls = array();
		$app = Yii::app();
		
		//header('Content-Type: text/html; charset=utf-8');
		
		$sql = "SELECT `id`, `level`, `name`, `uni` FROM {{shop_categories}} WHERE `id` > 1";
		$categories_list1 = $connection->createCommand($sql)->queryAll();
		
		$categories_list = array();
		foreach($categories_list1 as $c) $categories_list[$c['id']] = $c;
		
		$sql = "SELECT `product_id` FROM {{shop_products_models_auto}} WHERE `model_id` = :model_id";
		$commandModels = $connection->createCommand($sql);
				
		$homeUrl = substr(Yii::app()->homeUrl, 0, -1);
		
		//формируем урлы для универсальных категорий
		foreach($categories_list as $cat) {
			if($cat['level'] > 2 && $cat['uni'] == 1) {
				$url_params = array('id' => $cat['id']);
				$categories_urls[] = $homeUrl . $controller->createUrl('shopcategories/show', $url_params);
			}
		}
		
		//echo'<pre>';print_r(($categories_urls));echo'</pre>';//die;		
		$markaList = ShopModelsAuto::model()->getModelsLevel1($connection, false);

		foreach($markaList as $marka_id => $marka) {
			//if($marka_id != 31) continue;
			$modelModel = ShopModelsAuto::model()->findByPk($marka_id);
			$descendants = $modelModel->children()->findAll();
			$modelList = CHtml::listData($descendants, 'id','name');
			$descendants = null;
			
			foreach($modelList as $model_id => $model) {
				//if($model_id != 34) continue;
				$modelYear = ShopModelsAuto::model()->findByPk($model_id);
				$descendants = $modelYear->descendants()->findAll();
				$parent_id = 0;
				foreach($descendants as $k=>$c)
					if($c->disabled_in_dropdown == 1) unset($descendants[$k]);
				
				$yearsList = CHtml::listData($descendants, 'id','id');
				
				$descendants = null;
				
				foreach($yearsList as $year_id => $year) {
					//if($year_id != 2074) continue;
					$category_ids = $this->getCategoryIdFromModels($connection, array($year_id, Yii::app()->params['universal_products']));
					
					foreach($category_ids as $category_id) {
						if($categories_list[$category_id]['level'] > 2 && $categories_list[$category_id]['uni'] == 0) {							
							if($category_id != $app->params['shtatnie_glushiteli_id']) {
								$url_params = array(
									'id' => $category_id,
									'marka' => $marka_id,
									'model' => $model_id,
									'year' => $year_id,
								);
								
								$categories_urls[] = $homeUrl . $controller->createUrl('shopcategories/show', $url_params);
							}	else	{
								//если категория "Штатные глушители"
								$engines_info = Engines::model()->getEnginesInfo($year_id);
								
								foreach($engines_info as $engine) {
									$url_params = array(
										'id' => $category_id,
										'marka' => $marka_id,
										'model' => $model_id,
										'year' => $year_id,
										'engine' => $engine['id'],
									);
									$categories_urls[] = $homeUrl . $controller->createUrl('shopcategories/show', $url_params);									
								}
							}
						}
					}
					//echo'<pre>';print_r($categories_urls);echo'</pre>';die;
				}
			}
		}
		
		//echo'$rows<pre>';print_r(count($categories_urls));echo'</pre>';die;
		return $categories_urls;
	}

	/**
	 * обновляет цены на товары в указанно группе товаров и ее дочерних группах
	 * @return bool
	 */
	public function updatePricesInProducts()
	{
		$app = Yii::app();
		$connection = $app->db;

		$cat_ids = $this->getChildrensIds($this->id);
		//echo'updatePricesInProducts <pre>';print_r($cat_ids);echo'</pre>';die;

		$product_ids = ShopProductsCategories::model()->getProductIdsInCategories($cat_ids);
		//echo'updatePricesInProducts<pre>';print_r($product_ids);echo'</pre>';die;


		$where = array(' (`product_id` IN ('. $product_ids . ')) ');

		if($this->update_price_value > 0) {
			if($this->update_price_value == 100) {
				// если выбрано воостановление исходной цены
				$values = array(
					' `product_price` = `product_price_default` ',
					' `product_override_price` = 0 ',
					' `override` = 0 ',
					' `percent_discount` = 0',
				);
			}	else {
				$values = array(
					' `product_price` = (`product_price` + (`product_price` / 100 * ' . $this->update_price_value . ')) ',
				);
			}

		}	elseif($this->update_price_value < 0)	{
			$values = array(
				' `product_override_price` = (`product_price` + (`product_price` / 100 * ' . $this->update_price_value . ')) ',
				' `override` = 1 ',
				' `percent_discount` = ' . $this->update_price_value,
			);

		}	else	{
			$values = array(
				' `product_override_price` = 0 ',
				' `override` = 0 ',
				' `percent_discount` = 0',
			);
		}

		//echo'<pre>';print_r($values);echo'</pre>';//die;
		//echo'<pre>';print_r($where);echo'</pre>';die;

		$res = DBHelper::updateTbl($connection, ShopProducts::model()->tableName(), $values, $where);
		return $res;
	}

	/**
	 * добавляем к товарам фейковую скидку
	 * @return bool
	 */
	public function updateFakePricesInProducts()
	{
		$app = Yii::app();
		$connection = $app->db;

		$cat_ids = $this->getChildrensIds($this->id);
		//echo'updateFakePricesInProducts<pre>';print_r($cat_ids);echo'</pre>';die;

		$product_ids = ShopProductsCategories::model()->getProductIdsInCategories($cat_ids);

		//echo'updateFakePricesInProducts<pre>';print_r($product_ids);echo'</pre>';die;

		$where = array(' (`product_id` IN ('. $product_ids . ')) ');

		if($this->fake_discount < 0) {
			$values = array(
				' `product_override_price` = `product_price` ',
				' `product_price` = (`product_price` - (`product_price` / 100 * ' . $this->fake_discount . ')) ',
				' `override` = 1 ',
				' `percent_discount` = ' . $this->fake_discount,
			);
		}	elseif($this->fake_discount == 0)	{
			//если выбран откат скидки
			$values = array(
				' `product_price` = `product_override_price` ',
				' `product_override_price` = 0 ',
				' `override` = 0 ',
				' `percent_discount` = 0',
			);

			$where[] = ' (product_override_price <> 0) ';

		}	else	{
			return false;
		}

		$res = DBHelper::updateTbl($connection, ShopProducts::model()->tableName(), $values, $where);
		return $res;
	}
}
