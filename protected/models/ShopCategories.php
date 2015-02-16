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

	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	public $category_image;
	
	public $SelectedCategory;
	
	
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('root, lft, rgt, level, name, title, keywords, description, alias, ordering, category_companies, cat_column', 'required'),
			array('name', 'required'),
			array('root, lft, rgt, level, ordering, cat_column', 'numerical', 'integerOnly'=>true),
			array('name, title, alias, category_companies', 'length', 'max'=>255),
			array('category_description, keywords, description', 'length', 'max'=>7000),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'name'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('parentId, id, root, lft, rgt, level, name, title, keywords, description, alias, ordering, category_companies, cat_column, category_description', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'alias' => 'Alias',
			'ordering' => 'Ordering',
			'category_companies' => 'Category Companies',
			'cat_column' => 'Cat Column',
			'dropDownListTree' => 'Родительская категория',
			'category_description' => 'Описание категории',
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
		if(isset($app->session['ShopCategories.selected_category']))	{
			$this->SelectedCategory = (int)$app->session['ShopCategories.selected_category'];
		}
				
		//echo'<pre>';var_dump($this->SelectedCategory);echo'</pre>';

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
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
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
			
			//echo'<pre>';print_r($this->new_parentId);echo'</pre>';
			//echo'<pre>';print_r($this->parentId);echo'</pre>';
			//die;
			
			$this->saveNode();
		}
		
		return true;
	}	

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

		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id AND `show_in_menu` = 1 AND `level` <= 4";
		}
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		
		$cat_arr = array();
		$cat_arr_inner = array();
		$level_arr = array();
		
		$app = Yii::app();
		
		//получаем id текущей категории
		$current_category_id = $app->request->getParam('id', 0);
		
		//получаем всех предков текущей категории
		if($current_category_id)	{
			$current_category = $this->findByPk($current_category_id);
			$current_category_ancestors = $current_category->ancestors()->findAll();
		}	else	{
			$current_category_ancestors = array();
		}
		
		//echo'<pre>';print_r($_GET['path']);echo'</pre>';
		//echo'<pre>';print_r($current_category_id);echo'</pre>';
		//echo'<pre>';print_r(count($current_category_ancestors));echo'</pre>';
		
		
		foreach($categories as $n => $category)
		{
			//echo'<pre>';print_r($category->path);echo'</pre>';
			/*
			$pos = strpos($_GET['id'], $category->id);
			if($pos === false) {
				$active = false;
			} else {
				$active = true;
			}
			*/
			
			
			if($current_category_id == $category->id) {
				$active = true;
			} else {
				
				foreach($current_category_ancestors as $i)	{
					//echo'<pre>';print_r($i->id." | ".$category->id);echo'</pre>';
					if($i->id == $category->id)	{
						$active = true;
						break;
					}	else	{
						$active = false;
					}
				}
				
				
			}
			//echo'<pre>';var_dump($active);echo'</pre>';
			$cat_arr[$category->id]['label'] = CHtml::encode($category->name);
			$cat_arr[$category->id]['parent_id'] = CHtml::encode($category->parent_id);
			//$cat_arr[$category->id]['url'] = array('/shopcategories/show/', 'path'=>$category->path);
			$cat_arr[$category->id]['url'] = array('/shopcategories/show/', 'id'=>$category->id);
			$cat_arr[$category->id]['active'] = $active;
			$cat_arr[$category->id]['itemOptions'] = array('class'=>'cat-'.$category->id);
		}

		$cat_arr = $this->mapTree($cat_arr);
		
		//echo'<pre>';print_r($cat_arr);echo'</pre>';die;

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
	
		
}