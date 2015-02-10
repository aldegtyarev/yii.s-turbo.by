<?php

/**
 * This is the model class for table "{{shop_product_prices}}".
 *
 * The followings are the available columns in table '{{shop_product_prices}}':
 * @property string $product_price_id
 * @property string $product_id
 * @property string $product_price
 * @property integer $override
 * @property string $product_override_price
 * @property integer $product_tax_id
 * @property integer $product_discount_id
 * @property integer $product_currency
 * @property string $product_price_vdate
 * @property string $product_price_edate
 * @property string $price_quantity_start
 * @property string $price_quantity_end
 *
 * The followings are the available model relations:
 * @property ShopProducts $product
 */
class ShopProductPrices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_product_prices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('override, product_tax_id, product_discount_id, product_currency', 'numerical', 'integerOnly'=>true),
			array('product_id', 'length', 'max'=>1),
			array('product_price, product_override_price', 'length', 'max'=>15),
			array('price_quantity_start, price_quantity_end', 'length', 'max'=>11),
			array('product_price_vdate, product_price_edate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_price_id, product_id, product_price, override, product_override_price, product_tax_id, product_discount_id, product_currency, product_price_vdate, product_price_edate, price_quantity_start, price_quantity_end', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'ShopProducts', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_price_id' => 'Product Price',
			'product_id' => 'Product',
			'product_price' => 'Product Price',
			'override' => 'Override',
			'product_override_price' => 'Product Override Price',
			'product_tax_id' => 'Product Tax',
			'product_discount_id' => 'Product Discount',
			'product_currency' => 'Product Currency',
			'product_price_vdate' => 'Product Price Vdate',
			'product_price_edate' => 'Product Price Edate',
			'price_quantity_start' => 'Price Quantity Start',
			'price_quantity_end' => 'Price Quantity End',
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

		$criteria->compare('product_price_id',$this->product_price_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('override',$this->override);
		$criteria->compare('product_override_price',$this->product_override_price,true);
		$criteria->compare('product_tax_id',$this->product_tax_id);
		$criteria->compare('product_discount_id',$this->product_discount_id);
		$criteria->compare('product_currency',$this->product_currency);
		$criteria->compare('product_price_vdate',$this->product_price_vdate,true);
		$criteria->compare('product_price_edate',$this->product_price_edate,true);
		$criteria->compare('price_quantity_start',$this->price_quantity_start,true);
		$criteria->compare('price_quantity_end',$this->price_quantity_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductPrices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
