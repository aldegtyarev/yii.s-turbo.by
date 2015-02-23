<?php

/**
 * This is the model class for table "{{shop_firms}}".
 *
 * The followings are the available columns in table '{{shop_firms}}':
 * @property integer $firm_id
 * @property string $firm_name
 * @property string $firm_description
 * @property string $firm_logo
 *
 * The followings are the available model relations:
 * @property ShopProducts[] $shopProducts
 */
class ShopFirms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_firms}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firm_name', 'required'),
			array('firm_name, firm_logo', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('firm_id, firm_name, firm_description, firm_logo', 'safe', 'on'=>'search'),
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
			'shopProducts' => array(self::HAS_MANY, 'ShopProducts', 'firm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'firm_id' => 'id',
			'firm_name' => 'Название',
			'firm_description' => 'Описание',
			'firm_logo' => 'Лого',
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

		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('firm_name',$this->firm_name,true);
		$criteria->compare('firm_description',$this->firm_description,true);
		$criteria->compare('firm_logo',$this->firm_logo,true);
		
		$criteria->condition = 't.firm_id > 0';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopFirms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function getDropDownlistFirms()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.firm_id';
		$rows = $this->findAll($criteria);
		return CHtml::listData($rows, 'firm_id','firm_name');
	}
	
	//получаем фирмы  для списка товаров категории
	public function getFirmsForProductList(&$connection, $product_ids = array() )
	{
		if(count($product_ids))	{
			$sql = "
SELECT pr.`firm_id` AS id, f.`firm_name` AS name, count(pr.`product_id`)  AS count
FROM `3hnspc_shop_products` AS pr INNER JOIN `3hnspc_shop_firms` AS f USING(`firm_id`)
WHERE pr.`product_id` IN (".implode(',', $product_ids).")
GROUP BY pr.`firm_id`
			
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
