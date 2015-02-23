<?php

/**
 * This is the model class for table "{{shop_products_admin_categories}}".
 *
 * The followings are the available columns in table '{{shop_products_admin_categories}}':
 * @property string $id
 * @property string $product_id
 * @property integer $category_id
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property ShopAdminCategories $category
 * @property ShopProducts $product
 */
class ShopProductsAdminCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_admin_categories}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, category_id', 'required'),
			array('category_id, ordering', 'numerical', 'integerOnly'=>true),
			array('product_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, category_id, ordering', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'ShopAdminCategories', 'category_id'),
			'product' => array(self::BELONGS_TO, 'ShopProducts', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'category_id' => 'Category',
			'ordering' => 'Ordering',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('ordering',$this->ordering);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductsAdminCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление категорий назначенных товару
	public function clearItemCategories($product_id, &$connection)
	{
		$sql = 'DELETE FROM '.$this->tableName().' WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();		
	}
	
	//добавление категорий товару
	public function insertItemCategories($categories, $product_id, &$connection)
	{
		if(count($categories))	{
			$sql = 'INSERT INTO '.$this->tableName().' (`product_id`, `category_id`) VALUES ';	
			foreach($categories as $key => $cat)	{
				$sql .= "(".$product_id.",".$key."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	
	//получаем все товары назначенные данной категории
	public function getProducts($category_id, &$connection)
	{
	$sql = 	'
SELECT p.`product_id`, p.`product_price` 
FROM {{shop_products}}  AS p
INNER JOIN {{shop_products_admin_categories}} AS pc USING (`product_id`)
WHERE pc.`category_id` = :category_id';
	
		//$sql = 'DELETE FROM '.$this->tableName().' WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":category_id", $category_id);
		return $command->queryAll();		
		//echo'<pre>';print_r($rows);echo'</pre>';die;
	}
	
	
}
