<?php

/**
 * This is the model class for table "{{delivery}}".
 *
 * The followings are the available columns in table '{{delivery}}':
 * @property integer $id
 * @property integer $name
 * @property string $options
 */
class DeliveryForm extends CFormModel
{
	public $units_qty12 = array();
	public $units_qty3 = array();
	
	public $units_qty12_q = array();
	public $units_qty3_q = array();
	
	public $cargo_types = array();
	public $free;
	public $name;
	public $ico;
	public $id;
	public $options;
	
	/**
	 * @return array validation rules
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, options, ico', 'length', 'max'=>2048),
			array('free', 'numerical', 'integerOnly'=>true),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'ico' => 'Иконка',
			'options' => 'Options',
			'units_qty12' => '1-2 товара',
			'units_qty3' => 'От 3 товаров и выше',
			'units_qty12_q' => '1-2 товара',
			'units_qty3_q' => 'От 3 товаров и выше',
			'free' => 'Бесплатная доставка свыше',
		);
	}
}
