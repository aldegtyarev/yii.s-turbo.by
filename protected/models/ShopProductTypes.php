<?php

/**
 * This is the model class for table "{{shop_product_types}}".
 *
 * The followings are the available columns in table '{{shop_product_types}}':
 * @property integer $type_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property ShopProducts $type
 */
class ShopProductTypes extends CActiveRecord
{
	const CACHE_PRODUCT_TYPE = 'product_type_';

	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	public $update_price_value = 0;
	public $fake_discount = 0;

	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_product_types}}';
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
			array('cargo_type, update_price_value, fake_discount', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('type_id, name', 'safe', 'on'=>'search'),
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
			'typesRelated' => array(self::HAS_MANY, 'ShopProductTypesRelations', 'type_id'),
			'products' => array(self::HAS_MANY, 'ShopProducts', 'type_id'),
		);	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'type_id' => 'id',
			'name' => 'Название',
			'cargo_type' => 'Тип груза',
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

		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('name',$this->name,true);
		
		$criteria->condition = 't.type_id > 0';
		
       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize' => 200,
			),

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductTypes the static model class
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
				}	else	{
					$this->moveAsRoot();
				}
			}
			
//			echo'<pre>';print_r($this->new_parentId);echo'</pre>';
//			echo'<pre>';print_r($this->parentId);echo'</pre>';
//			echo'<pre>';print_r($this);echo'</pre>';
//			die;
			
			$this->saveNode();
		}
		
		return true;
	}	
	
	public function getDropDownlistTypes()
	{
		return $this->getDropDownlistItems();
		/*
		$criteria = new CDbCriteria;
		$criteria->order = 't.type_id';
		$rows = $this->findAll($criteria);
		return CHtml::listData($rows, 'type_id','name');
		*/
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
		//echo'<pre>';print_r($categories);echo'</pre>';
		$level = 0;
		foreach($categories as $c){
			$separator = '';
			for ($x=1; $x++ < $c->level;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$result = CHtml::listData($categories, 'type_id','name');
        //echo'<pre>';print_r($result);echo'</pre>';
		
		//Yii::app()->cache->set('DropDownlistCategories', $result, 300);		
		
		return $result;
	}
	
	//получаем ID родительской категории
	public function getParentId()
	{	
		$parent = $this->parent()->find();
		$this->parentId = $parent->type_id ? $parent->type_id : 0;
	}
	
	function setparentid()
	{
		$criteria = new CDbCriteria;
		if($id != 0) $criteria->condition = "`root` = $id";
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		return true;
	}

	/**
	 * получаем типы товаров для списка товаров категории
     *
	 * @param $connection
	 * @param array $product_ids
	 * @param bool $get_null
	 * @return array
     */
	public function getProductTypesForProductList(&$connection, $product_ids = array(), $get_null = false )
	{
		if(count($product_ids))	{

			$sql = "
SELECT pr.`type_id` AS id, pt.`name` AS name, pt.`parent_id`, count(pr.`product_id`)  AS count
FROM {{shop_products}} AS pr INNER JOIN {{shop_product_types}} AS pt USING(`type_id`)
WHERE pr.`product_id` IN (".implode(',', $product_ids).") ".($get_null ? " AND pt.`type_id` > 0" : "")." 
GROUP BY pr.`type_id` ORDER BY pt.root, pt.lft
			";

			$command = $connection->createCommand($sql);
			$rows = $command->queryAll();
		}	else	{
			$rows = array();
		}
		return $rows;
	}

	/**
	 * @return mixed
     */
	public function updateCargoType()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		$sql = 'UPDATE {{shop_products}} SET `cargo_type` = '.$this->cargo_type. ' WHERE `type_id` = '.$this->type_id;
		$command = $connection->createCommand($sql);
		$res = $command->execute();
		
		return $res;
	}

	/**
	 * получает массив id дочерних групп товаров и текущей группы товаров
	 * @return array
     */
	public function getTypeIds()
	{
		$descendants = $this->descendants()->findAll();
		$type_ids = CHtml::listData($descendants, 'type_id','type_id');
		$type_ids[ $this->type_id] = $this->type_id;
		return $type_ids;
	}

	/**
	 * обновляет цены на товары в указанно группе товаров и ее дочерних группах
	 * @return bool
     */
	public function updatePricesInProducts()
	{
		$app = Yii::app();
		$connection = $app->db;

		$type_ids = $this->getTypeIds();
		//echo'<pre>';print_r($type_ids);echo'</pre>';die;
		$where = array(' (`type_id` IN ('. implode(',', $type_ids) . ')) ');

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

		$type_ids = $this->getTypeIds();

		$where = array(' (`type_id` IN ('. implode(',', $type_ids) . ')) ');

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

	/**
	 * возвращает название группы товаров
	 *
	 * @param mixed $app
	 * @param int $type_id
	 * @return string
	 */
	public function getProductTypeName($app, $type_id = 0)
	{
		$type_id = intval($type_id);

		$cacheId = self::CACHE_PRODUCT_TYPE . $type_id;
		$name = $app->cache->get($cacheId);
		if($name === false)	{
			$connection = $app->db;
			$sql = "SELECT `name` FROM " . self::tableName() . " WHERE `type_id` = " . $type_id;
			$command = $connection->createCommand($sql);
			$name = $command->queryScalar();
			$app->cache->set($cacheId, $name, $app->params['cache_duration']);
		}
		return $name;
	}
}
