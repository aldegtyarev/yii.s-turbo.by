<?php

/**
 * This is the model class for table "{{shop_products_relations}}".
 *
 * The followings are the available columns in table '{{shop_products_relations}}':
 * @property integer $id
 * @property string $product_id
 * @property string $product_related_id
 *
 * The followings are the available model relations:
 * @property ShopProducts $productRelated
 * @property ShopProducts $product
 */
class ShopProductsRelations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_relations}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, product_related_id', 'required'),
			array('product_id, product_related_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, product_related_id', 'safe', 'on'=>'search'),
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
			'productRelated' => array(self::BELONGS_TO, 'ShopProducts', 'product_related_id'),
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
			'product_related_id' => 'Product Related',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('product_related_id',$this->product_related_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductsRelations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление сопутствующих товаров товара
	public function clearRelatedProducts($product_id, &$connection)
	{
		$sql = 'DELETE FROM {{shop_products_relations}} WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();		
	}
	
	//добавление сопутствующих товаров к товару
	public function insertRelatedProducts($rows, $product_id, &$connection)
	{
		if(count($rows))	{
			$sql = 'INSERT INTO {{shop_products_relations}} (`product_id`, `product_related_id`) VALUES ';
			foreach($rows as $row)	{
				$sql .= "(".$product_id.",".$row."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	
	//получает сопутствующие товары для frontend части сайта
	public function getRelatedProducts($product_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT p.`product_id`, p.`product_name`, p.`product_sku`, p.`product_image`, p.`manuf`, p.`product_price`, p.`product_availability`
				FROM `{{shop_products}}` AS p
				INNER JOIN `{{shop_products_relations}}` AS pr ON p.`product_id` = pr.`product_related_id`
				WHERE pr.`product_id` = :product_id";
		
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$rows = $command->queryAll();
		
		$result = array();
		
		foreach($rows as $row)	{
			$item = new StdClass;
			foreach($row as $fld=>$val)	{
				$item->$fld = $val;
			}
			
			$item->ProductAvailabilityArray = ShopProducts::model()->ProductAvailabilityArray;
			$result[] = $item;
		}
		//echo'<pre>';print_r($result);echo'</pre>';
		
		return $result;
	}
	
}
