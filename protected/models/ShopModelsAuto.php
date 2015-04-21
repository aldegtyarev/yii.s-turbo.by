<?php

/**
 * This is the model class for table "{{shop_models_auto}}".
 *
 * The followings are the available columns in table '{{shop_models_auto}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $parent_id
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property string $path
 * @property integer $ordering
 * @property string $category_companies
 * @property integer $cat_column
 * @property string $anchor_css
 * @property integer $show_in_menu
 * @property string $category_description
 */
class ShopModelsAuto extends CActiveRecord
{
	
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $category_image;
	public $new_parentId;
	
	public $SelectedCategory;
	
	public $DropDownlistBodies;
	public $selectedBodies;
	public $body_ids;
	
	public $operate_method;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_models_auto}}';
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('root, lft, rgt, level, parent_id, name, title, keywords, description, alias, path, ordering, category_companies, cat_column, category_description', 'required'),
			array('name', 'required'),
			array('root, lft, rgt, level, parent_id', 'numerical', 'integerOnly'=>true),
			array('name, title, alias, fullname', 'length', 'max'=>255),
			array('keywords, description', 'length', 'max'=>7000),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'name'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('parentId, id, name, title, keywords, description, alias', 'safe', 'on'=>'search'),
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
            'ModelsBodies' => array(self::HAS_MANY, 'ModelsBodies', 'model_id'),
            'ProductsModelsAutos' => array(self::HAS_MANY, 'ShopProductsModelsAuto', 'model_id'),
        );	
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'parent_id' => 'Parent',
			'name' => 'Название',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'alias' => 'Alias',
			'path' => 'Path',
			'ordering' => 'Ordering',
			'category_companies' => 'Category Companies',
			'cat_column' => 'Cat Column',
			'anchor_css' => 'Anchor Css',
			'show_in_menu' => 'Show In Menu',
			'category_description' => 'Описание',
			'dropDownListTree' => 'Родитель',
			'body_ids' => 'Уточняющий год',
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
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		
		$sort = new CSort();
		
		$app = Yii::app();

		$this->SelectedCategory = 0;
		if(isset($app->session['ShopModelsAuto.selected_category']))	{
			$this->SelectedCategory = (int)$app->session['ShopModelsAuto.selected_category'];
		}

		if($this->SelectedCategory)	{
			//echo'<pre>';var_dump($SelectedCategory);echo'</pre>';
			$cat_ids = $this->getChildrensIds($this->SelectedCategory);
			//echo'<pre>';var_dump($cat_ids);echo'</pre>';
			//$this->catego_ids = ShopProductsCategories::model()->getProductIdsInCategories($cat_ids);
			//echo'<pre>';print_r($product_ids);echo'</pre>';
			if($cat_ids)	{
				$criteria->condition = "t.`id` IN ($cat_ids)";
			}
		}
		
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('path',$this->path,true);

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
		$connection = $app->db;
		
		switch($this->operate_method)	{
			case 'insert':
				ModelsBodies::model()->insertModelBody($this->selectedBodies, $this->id, $connection);
				break;
			
			case 'update':
				$this->checkModelsBodies($connection);
				break;
		}
		
		$this->setFullName($connection);
	}
	
	//проверяем, не изменились ли категории...
	function checkModelsBodies(&$connection)
	{
		$ModelsBodies = $this->ModelsBodies;
		if(count($ModelsBodies))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}
		//echo'<pre>';print_r($ModelsBodies);echo'</pre>';die;
		//проверяем, не изменились ли категории...
		if(count($ModelsBodies) != count($this->selectedBodies))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ModelsBodies as $cat_item)	{
				$cat_is_present = false;
				foreach($this->selectedBodies as $key=>$val)	{
					if($cat_item['body']['id'] == $key)	{
						$cat_is_present = true;
					}
				}
				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}

		if($arrays_of_identical == false)	{
			ModelsBodies::model()->clearModelBody($this->id, $connection);
			ModelsBodies::model()->insertModelBody($this->selectedBodies, $this->id, $connection);
		}
	}
	
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopModelsAuto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// возвращает дерево категорий
	public function getTreeCategories($id = 0)
	{
		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id AND `show_in_menu` = 1 AND `level` <= 4";
		}
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		$cat_arr = array();
		$cat_arr_inner = array();
		$level_arr = array();
		
		//echo'<pre>';print_r($_GET['path']);echo'</pre>';
		
		foreach($categories as $n=>$category)
		{
			//echo'<pre>';print_r($category->path);echo'</pre>';
			
			$pos = strpos($_GET['path'], $category->path);
			if($pos === false) {
				$active = false;
			} else {
				$active = true;
			}
			//echo'<pre>';var_dump($active);echo'</pre>';
			$cat_arr[$category->id]['label'] = CHtml::encode($category->name);
			$cat_arr[$category->id]['parent_id'] = CHtml::encode($category->parent_id);
			$cat_arr[$category->id]['url'] = array('/shopcategories/show/', 'path'=>$category->path);
			$cat_arr[$category->id]['active'] = $active;
			$cat_arr[$category->id]['itemOptions'] = array('class'=>'cat-'.$category->id);
		}

		$cat_arr = $this->mapTree($cat_arr);

		return $cat_arr[1]['items'];
	}
	
	function mapTree($dataset) {
		$tree = array();
		foreach ($dataset as $id=>&$node) {
			if (!$node['parent_id']) {
				$tree[$id] = &$node;
			}	else {
				$dataset[$node['parent_id']]['items'][$id] = &$node;
				//$dataset[$node['parent_id']]['items'][$id]['itemOptions'] = array('class'=>'menu111');
			}
		}
		return $tree;
	}
	
	
	// возвращает выпадающий список категорий для редактирования списка модельного ряда
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
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		$level = 0;
        $parent_name = array();
		
		foreach($categories as $c){

            //if($c->level == 1) $parent_name = $c->name;
            $parent_name[$c->level] = $c->name;
			
            if($c->level > 1)  {
                //$c->name = $parent_name . ' ' . $c->name;
            }
            
            $separator = '';
            
			for ($x=1; $x++ < $c->level;) $separator .= '-';
			
			$parent_name_str = '';
			
			//echo'<pre>';print_r($parent_name);echo'</pre>';
			
			for ($x=0; $x++ < $c->level;)	{
				if($parent_name[$x] != $c->name) {
					$parent_name_str .= $parent_name[$x].' ';
					//echo'<pre>';print_r($parent_name[$x].' '.$x);echo'</pre>';
				}
					
			}
			
            //$c->name = $separator.$c->name;
            $c->name = $separator.$parent_name_str.$c->name;
		}
		
		$result = CHtml::listData($categories, 'id','name');
		
		//Yii::app()->cache->set('DropDownlistCategories', $result, 300);		
		
		return $result;
	}
    
    public function getAllModelslist() {
		$criteria = new CDbCriteria;
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
        $parent_name = array();
        $result = array();
		foreach($categories as $c){

            //if($c->level == 1) $parent_name = $c->name;
			$parent_name[$c->level] = $c->name;
            
			/*
            if($c->level > 1)  {
                //$c->name = $parent_name . ' ' . $c->name;
            }
            
            
			*/
			
			$parent_name_str = '';
			
			//echo'<pre>';print_r($parent_name);echo'</pre>';
			
			for ($x=0; $x++ < $c->level;)	{
				if($parent_name[$x] != $c->name) {
					$parent_name_str .= $parent_name[$x].' ';
					//echo'<pre>';print_r($parent_name[$x].' '.$x);echo'</pre>';
				}
					
			}
			
            //$c->name = $separator.$c->name;
            $c->name = $separator.$parent_name_str.$c->name;
			
			$result[$c->id] = $c->name;
			
		}
		
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
		
		
		foreach($categories as $n=>$category)	{
			//$category
			//$category=Category::model()->findByPk(9);
			//$parent = $category->parent()->find();
			//$category->parent_id = $parent->id;
			//$category->save(false);
			//echo'<pre>';print_r($parent->id);echo'</pre>';
		}
		return true;
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
	
	public function getFullNameModel($model_id)
	{	
		$model = $this->findByPk($model_id);
		$ancestors = $model->ancestors()->findAll();
		$result = '';
		foreach($ancestors as $ancestor) {
			$result .= $ancestor->name.' ';
		}
		
		$result .= $model->name;
		return $result;
	}
	
	public function getModelIds(&$app)
	{	
		$model_ids = array();
		
		$model_id = 0;
		$find_descendants = true;
		if(isset($app->session['autofilter.marka'])) {
			$model_id = $app->session['autofilter.marka'];
		}

		if(isset($app->session['autofilter.model'])) {
			$model_id = $app->session['autofilter.model'];
		}

		if(isset($app->session['autofilter.year'])) {
			$model_id = $app->session['autofilter.year'];
			$find_descendants = false;
		}
		
		if($model_id) {
			$model_ids[] = $model_id;
			$model_ids[] = $app->params['universal_products'];
			$model = $this->findByPk($model_id);
			$descendants = $model->descendants()->findAll();
			//echo'<pre>';print_r(($model_id));echo'</pre>';
			//echo'<pre>';print_r(count($descendants));echo'</pre>';
			foreach($descendants as $row) {
				$model_ids[] = $row->id;
			}
			
		}
		return $model_ids;
	}
	
	public function getModelsLevel1(&$connection)
	{
		$sql = "SELECT `id`, `name` FROM ".$this->tableName()." WHERE `level`= 1";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		return CHtml::listData($rows, 'id','name');
	}

		
	public function getCategoryIdFromModels(&$connection, $model_ids)
	{
		$sql = "SELECT DISTINCT(`category_id`) FROM {{shop_products_categories}}
				WHERE `product_id` IN (SELECT `product_id` FROM {{shop_products_models_auto}}
				WHERE `model_id` IN (".implode(', ', $model_ids).")";
		
		$command = $connection->createCommand($sql);
		//$rows = $command->queryAll();
		return $command->queryAll();
	}
	
	//получает выбранные категории для товара
	function getSelectedBodies()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ModelsBodies,0);echo'</pre>';die;
		
		foreach($this->ModelsBodies as $cat) {
			//echo'<pre>';print_r($cat['body']['body_id'],0);echo'</pre>';//die;
			$selectedValues[$cat['body']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->selectedBodies = $selectedValues;		
	}
	
	
	public function setFullName(&$connection)
	{
		$ancestors = $this->ancestors()->findAll();
		$fullname = '';
		foreach($ancestors as $ancestor) {
			$fullname .= $ancestor->name.' ';
		}
		
		$fullname .= $this->name;
		
		$sql = "UPDATE ".$this->tableName()." SET `fullname` = '".$fullname."' WHERE `id` = ".$this->id;
		//echo'<pre>';print_r($sql,0);echo'</pre>';die;
		$command = $connection->createCommand($sql);
		return $command->execute();
	}
	
	
	
}
