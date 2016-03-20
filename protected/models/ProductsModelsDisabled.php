<?php

/**
 * This is the model class for table "{{shop_products_models_auto_disabled}}".
 *
 * The followings are the available columns in table '{{shop_products_models_auto_disabled}}':
 * @property string $id
 * @property string $product_id
 * @property integer $model_id
 *
 * The followings are the available model relations:
 * @property ShopModelsAuto $model
 * @property ShopProducts $product
 */
class ProductsModelsDisabled extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_models_auto_disabled}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, model_id', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('product_id', 'length', 'max'=>11),
			array('id, product_id, model_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'model' => array(self::BELONGS_TO, 'ShopModelsAuto', 'model_id'),
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
			'model_id' => 'Model',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('model_id',$this->model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsModelsDisabled the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление категорий назначенных товару
	public function clearItemModels($product_id, &$connection)
	{
		$sql = 'DELETE FROM '.$this->tableName().' WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();		
	}
	
	//добавление моделей товару
	public function insertItemModels($rows, $product_id, &$connection)
	{
		if(count($rows))	{		
			$sql = 'INSERT INTO '.$this->tableName().' (`product_id`, `model_id`) VALUES ';
			foreach($rows as $key => $row)	{
				$sql .= "(".$product_id.",".$key."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	

	/**
	 * проверка на то, чтобы исключить некоторые товары из выдачи
	 *
	 * @param mixed $connection
	 * @param array $product_ids
	 * @param array $model_ids
	 * @return array
     */
	public function checkForExcludedProducts(&$connection, $product_ids = array(), $model_ids = array())
	{
		if(count($product_ids) == 0 || count($model_ids) == 0) return $product_ids;
		$rows = self::getExludedProductIds($connection, $model_ids);
		foreach($rows as $row)
			foreach($product_ids as $key=>$product_id)
				if($product_id == $row)
					unset($product_ids[$key]);

		return $product_ids;
	}

	/**
	 * возвращает ID товаров, которые нужно исключать из указанных моделей
	 * @param $connection
	 * @param array $model_ids
	 * @return array
     */
	public function getExludedProductIds($connection, $model_ids = array())
	{
		if(count($model_ids) == 0) return array();
		$sql = "SELECT `product_id` FROM ".$this->tableName()." WHERE model_id IN (" . implode(',', $model_ids) . ")";
		$command = $connection->createCommand($sql);
		return $command->queryColumn();
	}
	
}
