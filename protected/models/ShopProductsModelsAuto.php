<?php

/**
 * This is the model class for table "{{shop_products_models_auto}}".
 *
 * The followings are the available columns in table '{{shop_products_models_auto}}':
 * @property string $id
 * @property string $product_id
 * @property integer $model_id
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property ShopModelsAuto $model
 * @property ShopProducts $product
 */
class ShopProductsModelsAuto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_models_auto}}';
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
			array('model_id, ordering', 'numerical', 'integerOnly'=>true),
			array('product_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, model_id, ordering', 'safe', 'on'=>'search'),
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
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('ordering',$this->ordering);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductsModelsAuto the static model class
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
	
	//добавление моелей товару
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
	
	//получает ID товаров из выбранных моделей
	public function getProductIdsInCategories($categories)
	{
		$result = '-1';
		if($categories)	{
			$connection = Yii::app()->db;
			
			$sql = "SELECT distinct(`product_id`) FROM ".$this->tableName()." WHERE `model_id` IN ($categories) ";
			//echo'<pre>';print_r($sql);echo'</pre>';die;
			$command = $connection->createCommand($sql);
			$rows = $command->queryColumn();
			//echo'<pre>';print_r($rows);echo'</pre>';
			
			if(count($rows))	{
				$result = implode(',', $rows);
			}
		}
		return $result;
	}
	
	public function getModelIdsFromProduct($product_id)
	{
		$connection = Yii::app()->db;

		$sql = "SELECT distinct(`model_id`) FROM ".$this->tableName()." WHERE `product_id` = :product_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		//$rows = $command->queryColumn();
		//echo'<pre>';print_r($rows);echo'</pre>';
			
		return $command->queryColumn();
	}
	
	public function getModelsFullNames($product_id, $model_ids = array())
	{
		$connection = Yii::app()->db;

		//$sql = "SELECT distinct(pma.`model_id`), ma.`fullname` FROM ".$this->tableName()." AS pma INNER JOIN {{shop_models_auto}} AS ma ON ma.`id` = pma.`model_id` WHERE `product_id` = :product_id";
		
		$sql = "SELECT distinct(pma.`model_id`), ma.`name` AS fullname FROM ".$this->tableName()." AS pma INNER JOIN {{shop_models_auto}} AS ma ON ma.`id` = pma.`model_id` WHERE `product_id` = :product_id";
		if(count($model_ids) > 0 ) $sql .= " AND `model_id` IN (".implode(',', $model_ids).")";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		//$rows = $command->queryColumn();
		//echo'<pre>';print_r($rows);echo'</pre>';
			
		return $command->queryAll();
	}
	
	public function getModelsFullNamesFull($product_id, $model_ids = array())
	{
		$connection = Yii::app()->db;

		$sql = "SELECT distinct(pma.`model_id`), ma.`fullname` FROM ".$this->tableName()." AS pma INNER JOIN {{shop_models_auto}} AS ma ON ma.`id` = pma.`model_id` WHERE `product_id` = :product_id";
		
		//$sql = "SELECT distinct(pma.`model_id`), ma.`name` AS fullname FROM ".$this->tableName()." AS pma INNER JOIN {{shop_models_auto}} AS ma ON ma.`id` = pma.`model_id` WHERE `product_id` = :product_id";
		if(count($model_ids) > 0 ) $sql .= " AND `model_id` IN (".implode(',', $model_ids).")";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		//$rows = $command->queryColumn();
		//echo'<pre>';print_r($rows);echo'</pre>';
			
		return $command->queryAll();
	}
	
	public function getModelsIdsForProductList(&$connection, $product_ids)
	{
		$connection = Yii::app()->db;

		$sql = "SELECT distinct(`model_id`) FROM ".$this->tableName()." WHERE `product_id` = :product_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		//$rows = $command->queryColumn();
		//echo'<pre>';print_r($rows);echo'</pre>';
			
		return $command->queryAll();
	}
	
	public function getProductIdFromModels(&$connection, $model_ids)
	{
		$sql = "SELECT DISTINCT (`product_id`) FROM ".$this->tableName()."
				WHERE `model_id` IN (".implode(', ', $model_ids).")";
		
		$command = $connection->createCommand($sql);
		//$rows = $command->queryAll();
		return $command->queryColumn();
	}
	
	/**
	 * проверяет,является ли товар с заданным id универсальным товаром
	 *
	 * @param $id integer
	 * @return boolean
	 */
	public function isUniversalroduct($id = 0)
	{
		$res = false;
		$connection = Yii::app()->db;
		$sql = "SELECT `id` FROM ".$this->tableName()." WHERE `product_id` = :id AND `model_id` = :model_id";
		$command = $connection->createCommand($sql);		
		$command->bindParam(":id", $id);
		$command->bindParam(":model_id", Yii::app()->params['universal_products']);
		$value = $command->queryScalar();
		//echo'<pre>';var_dump($value);echo'</pre>';die;
		if($value !== false) $res = true;
		return $res;
	}
	
}
