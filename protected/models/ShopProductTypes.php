<?php

/**
 * This is the model class for table "{{shop_product_types}}".
 *
 * The followings are the available columns in table '{{shop_product_types}}':
 * @property integer $type_id
 * @property string $type_name
 *
 * The followings are the available model relations:
 * @property ShopProducts $type
 */
class ShopProductTypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_product_types}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_name', 'required'),
			array('type_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('type_id, type_name', 'safe', 'on'=>'search'),
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
			'type_name' => 'Название',
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
		$criteria->compare('type_name',$this->type_name,true);
		
		$criteria->condition = 't.type_id > 0';

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
	
	public function getDropDownlistTypes()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.type_id';
		$rows = $this->findAll($criteria);
		return CHtml::listData($rows, 'type_id','type_name');
	}
	
	//получаем фото товаров для списка товаров категории
	public function getProductTypesForProductList(&$connection, $product_ids = array() )
	{
		
/*
SELECT `type_id`, count(`product_id`) FROM `3hnspc_shop_products`

where `product_id` IN (132,4232,453121,64564,123213,5432)
group by `type_id`
*/
		if(count($product_ids))	{
			$sql = "SELECT `image_id`, `product_id`, `image_file` FROM ". $this->tableName()." WHERE `main_foto` = 0 AND `product_id` IN (".implode(',', $product_ids).") ORDER BY `product_id`, `ordering`";
			$command = $connection->createCommand($sql);
			//$command->bindParam(":product_id", $product_ids_str);
			$rows = $command->queryAll();
		}	else	{
			$rows = array();
		}
		//echo'<pre>';print_r($product_ids_str);echo'</pre>';
		return $rows;
	}
	
}
