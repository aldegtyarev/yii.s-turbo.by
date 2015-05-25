<?php

/**
 * This is the model class for table "{{shop_bodies}}".
 *
 * The followings are the available columns in table '{{shop_bodies}}':
 * @property string $body_id
 * @property string $name
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property ShopProductsBodies[] $shopProductsBodies
 */
class ShopBodies extends CActiveRecord
{
	
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	
	public $SelectedCategory;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_bodies}}';
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
			array('name', 'required'),
			array('order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, order', 'safe', 'on'=>'search'),
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
			'shopProductsBodies' => array(self::HAS_MANY, 'ShopProductsBodies', 'body_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'name' => 'Название',
			'order' => 'Порядок',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('order',$this->order);
		
       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 50,
			),			
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopBodies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
				}	elseif($this->id != $this->root)	{
					$this->moveAsRoot();
				}
			}
			//echo'<pre>';print_r($this->parentId);echo'</pre>';
			//die;
			
			$this->saveNode();
		}
		
		return true;
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
	public function getDropDownlistBodies()
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

	
    
    	//получаем фирмы  для списка товаров категории
	public function getBodiesForProductList(&$connection, $product_ids = array(), $model_ids = array() )
	{
		if(count($product_ids))	{
			
			$model_ids_sql = '';
			if(count($model_ids))	{
				$model_ids_sql = " AND b.`id` IN (SELECT `body_id` FROM {{shop_models_bodies}} WHERE `model_id` IN (".implode(',' , $model_ids)."))";
			}
			
			$sql = "
SELECT pr.`body_id` AS id, b.`name` AS name, count(pr.`product_id`)  AS count
FROM {{shop_products_bodies}} AS pr INNER JOIN {{shop_bodies}} AS b ON pr.`body_id` = b.`id`
WHERE pr.`product_id` IN (".implode(',', $product_ids).") $model_ids_sql
GROUP BY pr.`body_id`
			";
			
/*
Е34
SELECT pr.`body_id` AS id, b.`name` AS name, count(pr.`product_id`) AS count
FROM 3hnspc_shop_products_bodies AS pr INNER JOIN 3hnspc_shop_bodies AS b USING(`body_id`)
WHERE pr.`product_id` IN (298,299) AND `body_id` IN (SELECT `body_id` FROM 3hnspc_shop_models_bodies WHERE `model_id` IN (103,1247))
GROUP BY pr.`body_id`

Е46
SELECT pr.`body_id` AS id, b.`name` AS name, count(pr.`product_id`) AS count
FROM 3hnspc_shop_products_bodies AS pr INNER JOIN 3hnspc_shop_bodies AS b USING(`body_id`)
WHERE pr.`product_id` IN (362) AND `body_id` IN (SELECT `body_id` FROM 3hnspc_shop_models_bodies WHERE `model_id` IN (97,1247))
GROUP BY pr.`body_id`

*/
			$command = $connection->createCommand($sql);
			//$command->bindParam(":product_id", $product_ids_str);
			$rows_ = $command->queryAll();
			$rows = array();
			foreach($rows_ as $row)	{
				$rows[$row['id']] = $row;
			}
		}	else	{
			$rows = array();
		}
		//echo'<pre>';print_r($product_ids_str);echo'</pre>';
		//echo'<pre>';print_r($sql);echo'</pre>';
		
		return $rows;
	}
	
}
