<?php

/**
 * This is the model class for table "{{currencies}}".
 *
 * The followings are the available columns in table '{{currencies}}':
 * @property integer $currency_id
 * @property string $currency_name
 * @property string $currency_code
 * @property string $currency_code_iso
 * @property string $currency_code_num
 * @property integer $currency_ordering
 * @property string $currency_value
 * @property integer $currency_publish
 */
class Currencies extends CActiveRecord
{
	public $_dropDownCurrenciesList;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{currencies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('currency_name, currency_code, currency_code_iso, currency_code_num, currency_ordering, currency_value, currency_publish', 'required'),
			array('currency_ordering, currency_publish', 'numerical', 'integerOnly'=>true),
			array('currency_name', 'length', 'max'=>64),
			array('currency_code', 'length', 'max'=>20),
			array('currency_code_iso, currency_code_num', 'length', 'max'=>3),
			array('currency_value', 'length', 'max'=>14),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('currency_id, currency_name, currency_code, currency_code_iso, currency_code_num, currency_ordering, currency_value, currency_publish', 'safe', 'on'=>'search'),
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
			'currency_id' => 'Currency',
			'currency_name' => 'Currency Name',
			'currency_code' => 'Currency Code',
			'currency_code_iso' => 'Currency Code Iso',
			'currency_code_num' => 'Currency Code Num',
			'currency_ordering' => 'Currency Ordering',
			'currency_value' => 'Currency Value',
			'currency_publish' => 'Currency Publish',
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

		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('currency_name',$this->currency_name,true);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('currency_code_iso',$this->currency_code_iso,true);
		$criteria->compare('currency_code_num',$this->currency_code_num,true);
		$criteria->compare('currency_ordering',$this->currency_ordering);
		$criteria->compare('currency_value',$this->currency_value,true);
		$criteria->compare('currency_publish',$this->currency_publish);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function getDropDownCurrenciesList()
	{
		$result = CHtml::listData(self::findAll(), 'currency_id', 'currency_name');
		return $result;
	}
	
}
