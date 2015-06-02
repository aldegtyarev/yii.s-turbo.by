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
	
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	
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
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'type_id' => 'id',
			'name' => 'Название',
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

		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('name',$this->name,true);
		
		$criteria->condition = 't.type_id > 0';
		
       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			
			//echo'<pre>';print_r($this->new_parentId);echo'</pre>';
			//echo'<pre>';print_r($this->parentId);echo'</pre>';
			//die;
			
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
	
	
	//получаем типы товаров для списка товаров категории
	public function getProductTypesForProductList(&$connection, $product_ids = array(), $get_null = false )
	{
		
/*
SELECT pr.`type_id` AS id, pt.`name` AS name, count(pr.`product_id`)  AS count

FROM `3hnspc_shop_products` AS pr INNER JOIN `3hnspc_shop_product_types` AS pt USING(`type_id`)

where pr.`product_id` IN (25,26,27,28,29,30)
group by pr.`type_id`
*/
		if(count($product_ids))	{
			$sql = "
SELECT pr.`type_id` AS id, pt.`name` AS name, pt.`parent_id`, count(pr.`product_id`)  AS count
FROM {{shop_products}} AS pr INNER JOIN {{shop_product_types}} AS pt USING(`type_id`)
WHERE pr.`product_id` IN (".implode(',', $product_ids).") ".($get_null ? " AND pt.`type_id` > 0" : "")."
GROUP BY pr.`type_id`
			";
			$command = $connection->createCommand($sql);
			//$command->bindParam(":product_id", $product_ids_str);
			$rows = $command->queryAll();
			
			
			
			$sql = "SELECT `type_id` AS id,`root`,`level`,`parent_id`,`name`, '0' AS count FROM {{shop_product_types}} WHERE `type_id` <> 0 ORDER BY root, lft";
			$command = $connection->createCommand($sql);
			$all_prod_types = $command->queryAll();
			//echo'<pre>';print_r($all_prod_types);echo'</pre>';
			
			
			$presented_ids = array();
			
			$parent_id = 0;
			$parent_level = -1;
			
			
			//foreach($rows as $row_key=>$row) {
				//echo'<p>'.$row['name'].'|'.$row['count'].'|'.$row['id'].'</p>';
			//}
			
			foreach($rows as $row_key=>$row) {
				foreach($all_prod_types as $prod_key=>&$prod_type) {
					if($prod_type['id'] == $row['id']) {
						$presented_ids[] = $prod_type['id'];
						$presented_ids[] = $prod_type['parent_id'];
						$parent_id = $prod_type['parent_id'];
						//$parent_level = $prod_type['level'];
						break;
					}
				}

				foreach($all_prod_types as $prod_key=>&$prod_type) {
					if($prod_type['id'] == $parent_id) {
						$presented_ids[] = $prod_type['id'];
						$parent_id = $prod_type['parent_id'];
						break;
					}
				}
				
				foreach($all_prod_types as $prod_key=>&$prod_type) {
					if($prod_type['id'] == $parent_id) {
						$presented_ids[] = $prod_type['id'];
						$parent_id = $prod_type['parent_id'];
						break;
					}
				}
				
				foreach($all_prod_types as $prod_key=>&$prod_type) {
					if($prod_type['id'] == $parent_id) {
						$presented_ids[] = $prod_type['id'];
						$parent_id = $prod_type['parent_id'];
						break;
					}
				}
			}
			
			$presented_ids = array_unique($presented_ids);
			//echo'<pre>';print_r($presented_ids);echo'</pre>';
			
			
			foreach($all_prod_types as $prod_key=>&$prod_type) {
				$is_present = false;
				
				foreach($presented_ids as $id) {
					if($prod_type['id'] == $id) {
						$is_present = true;
						break;
					}
				}
				if($is_present === false) {
					unset($all_prod_types[$prod_key]);
				}	else	{
					//echo'<pre>';print_r($prod_type['name'].' '.$prod_type['id']);echo'</pre>';
					foreach($rows as $row_key=>$row) {
						if($prod_type['id'] == $row['id']) {
							$prod_type['count'] = $row['count'];
							break;
						}
					}
				}
			}
			$rows = $all_prod_types;
			/*
Тюнинг
Внешний тюнинг
Бампер передний => 356 357 
Бампер задний=> 358 359 654
Накладки на пороги 362
Молдинги => 361 655				
			*/
			
			
			//echo'<pre>';print_r(($all_prod_types));echo'</pre>';
			
			/*
			$level=0;
			
			foreach($all_prod_types as $n=>$category)
			{
				if($category['level']==$level)
					echo CHtml::closeTag('li')."\n";
				else if($category['level'] >$level)
					echo CHtml::openTag('ul')."\n";
				else
				{
					echo CHtml::closeTag('li')."\n";

					for($i=$level-$category['level'];$i;$i--)
					{
						echo CHtml::closeTag('ul')."\n";
						echo CHtml::closeTag('li')."\n";
					}
				}

				echo CHtml::openTag('li');
				echo CHtml::encode($category['name'].'|'.$category['count']);
				$level=$category['level'];
			}

			for($i=$level;$i;$i--)
			{
				echo CHtml::closeTag('li')."\n";
				echo CHtml::closeTag('ul')."\n";
			}			
			*/
		}	else	{
			$rows = array();
		}
		//echo'<pre>';print_r($rows);echo'</pre>';
		
		
		return $rows;
	}
	
}
