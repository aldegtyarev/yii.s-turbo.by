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
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_bodies}}';
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
			array('body_id, name, order', 'safe', 'on'=>'search'),
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
			'body_id' => 'id',
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

		$criteria->compare('body_id',$this->body_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	
	// возвращает выпадающий список категорий для редактирования товара
	public function getDropDownlistBodies()
	{
		$list_data = $this->getDropDownlistItems();
		return $list_data;
	}
	
	public function getDropDownlistItems()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'body_id';
		$rows = $this->findAll($criteria);
		
		return CHtml::listData($rows, 'body_id','name');
	}
	
	
    
    	//получаем фирмы  для списка товаров категории
	public function getBodiesForProductList(&$connection, $product_ids = array() )
	{
		if(count($product_ids))	{
			$sql = "
SELECT pr.`body_id` AS id, b.`name` AS name, count(pr.`product_id`)  AS count
FROM `3hnspc_shop_products_bodies` AS pr INNER JOIN `3hnspc_shop_bodies` AS b USING(`body_id`)
WHERE pr.`product_id` IN (".implode(',', $product_ids).")
GROUP BY pr.`body_id`
			
			";
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
		//echo'<pre>';print_r($rows);echo'</pre>';
		
		return $rows;
	}
	
}
