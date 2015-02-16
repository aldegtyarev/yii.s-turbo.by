<?php

/**
 * This is the model class for table "{{shop_products_bodies}}".
 *
 * The followings are the available columns in table '{{shop_products_bodies}}':
 * @property string $id
 * @property string $product_id
 * @property string $body_id
 *
 * The followings are the available model relations:
 * @property ShopBodies $body
 * @property ShopProducts $product
 */
class ShopProductsBodies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_bodies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, body_id', 'required'),
			array('product_id, body_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, body_id', 'safe', 'on'=>'search'),
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
			'body' => array(self::BELONGS_TO, 'ShopBodies', 'body_id'),
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
			'body_id' => 'Body',
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
		$criteria->compare('body_id',$this->body_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductsBodies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление кузовов назначенных товару
	public function clearItemBodies($product_id, &$connection)
	{
		$sql = 'DELETE FROM {{shop_products_bodies}} WHERE `product_id` = :product_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();		
	}
	
	//добавление кузовов товару
	public function insertItemBodies($rows, $product_id, &$connection)
	{
		if(count($rows))	{
			$sql = 'INSERT INTO {{shop_products_bodies}} (`product_id`, `body_id`) VALUES ';
			foreach($rows as $key => $row)	{
				$sql .= "(".$product_id.",".$key."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	
}
