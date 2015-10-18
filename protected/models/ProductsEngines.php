<?php

/**
 * This is the model class for table "{{shop_products_engines}}".
 *
 * The followings are the available columns in table '{{shop_products_engines}}':
 * @property integer $id
 * @property string $product_id
 * @property string $engine_id
 *
 * The followings are the available model relations:
 * @property Engines $engine
 * @property ShopProducts $product
 */
class ProductsEngines extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_engines}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, engine_id', 'required'),
			array('product_id, engine_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, engine_id', 'safe', 'on'=>'search'),
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
			'engine' => array(self::BELONGS_TO, 'Engines', 'engine_id'),
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
			'engine_id' => 'Engine',
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
		$criteria->compare('engine_id',$this->engine_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsEngines the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление объемов назначенных товару
	public function clearItemEngines($product_id, &$connection)
	{
		$sql = 'DELETE FROM '.$this->tableName().' WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();		
	}
	
	//добавление объемов товару
	public function insertItemEngines($categories, $product_id, &$connection)
	{
		if(count($categories))	{
			$sql = 'INSERT INTO '.$this->tableName().' (`product_id`, `engine_id`) VALUES ';	
			foreach($categories as $key => $cat)	{
				$sql .= "(".$product_id.",".$key."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	
	public function getProductIds($engine_ids=array(0) )
	{
		$connection = Yii::app()->db;
		return $this->getProductIdFromEngines($connection, $engine_ids );
	}
	
	public function getProductIdFromEngines(&$connection, $engine_ids=array(0) )
	{
		$sql = 'SELECT DISTINCT (`product_id`) FROM '.$this->tableName().' WHERE `engine_id` IN ('.implode(', ', $engine_ids).')';		
		$command = $connection->createCommand($sql);
		$rows = $command->queryColumn();
		if(count($rows) == 0) $rows = array(0);
		//echo'<pre>';print_r($rows);echo'</pre>';
		return $rows;
		//return $command->queryColumn();
	}
	
	//меняет порядок отображения товаров
	public function movePosition(&$connection, $direction = 'up', $product_id = 0, $category_id = 0, $model_id = 0, $engine_id = 0 )
	{
		//echo'<pre>';print_r($product_id);echo'</pre>';
		
		if($product_id == 0 || $category_id = 0 || $model_id == 0 || $engine_id == 0)
			return;
		
		$sql = "
SELECT eng.* FROM `{{shop_products_engines}}` AS eng
INNER JOIN `{{shop_products_models_auto}}` AS model ON eng.`product_id` = model.`product_id`
INNER JOIN `{{shop_products_categories}}` AS cat ON eng.`product_id` = cat.`product_id`

WHERE eng.`engine_id` = $engine_id AND model.model_id = $model_id AND cat.category_id = $category_id

ORDER BY eng.order ASC, eng.product_id ASC";		
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		
		//echo'<pre>';print_r($rows);echo'</pre>';
		//die;
		
		switch($direction) {
			case 'up':
				if($rows[0]['product_id'] == $product_id)
					return;
				break;
			case 'down':
				if($rows[(count($rows)-1)]['product_id'] == $product_id)
					return;
				break;
		}
		
		$is_moved = false;
		for ($key=0; $key<count($rows); $key++) {
			$rows[$key]['order'] = $key;
			
			if($rows[$key]['product_id'] == $product_id && $is_moved == false) {
				switch($direction) {
					case 'up':
						$rows[$key]['order'] = $key-1;
						$rows[$key-1]['order'] = $key;
						$is_moved = true;
						break;
					case 'down':
						$rows[$key]['order'] = $key+1;
						$rows[$key+1]['order'] = $key;
						$is_moved = true;
						$key++;
						break;
				}
			}
		}
		
		//echo'<pre>';print_r($rows);echo'</pre>';
		
		foreach($rows as $row) {
			$sql = "UPDATE ".$this->tableName()." SET `order` = '".$row['order']."' WHERE `id` = ".$row['id'];
			$command = $connection->createCommand($sql);
			$command->execute();			
		}
		//die;
		return;
	}
	
}
