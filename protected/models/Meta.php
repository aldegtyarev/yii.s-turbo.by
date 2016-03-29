<?php

/**
 * This is the model class for table "{{meta}}".
 *
 * The followings are the available columns in table '{{meta}}':
 * @property integer $id
 * @property string $name
 * @property string $cntr_act
 * @property string $metatitle
 * @property string $metakey
 * @property string $metadesc
 */
class Meta extends CActiveRecord
{
	const CACHE_META_INFO = 'CACHE_META_INFO_';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{meta}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, cntr_act, metatitle, metakey, metadesc', 'required'),
			array('name', 'length', 'max'=>64),
			array('cntr_act, metatitle, metakey', 'length', 'max'=>255),
			array('metadesc', 'length', 'max'=>1024),
			array('id, name, cntr_act, metatitle, metakey, metadesc', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'Name',
			'cntr_act' => 'Controller/Action',
			'metatitle' => 'Title',
			'metakey' => 'Keywords',
			'metadesc' => 'Description',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cntr_act',$this->cntr_act,true);
		$criteria->compare('metatitle',$this->metatitle,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	protected function afterSave() {
		parent::afterSave();

		$arr = explode('/', $this->cntr_act);
		$controller = $arr[0];
		$action = $arr[1];
		$cache_key = self::CACHE_META_INFO . $action . '_' . $controller;
		Yii::app()->cache->set($cache_key, false);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Meta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getMetaInfo()
	{
		$app = Yii::app();
		$action = $app->getController()->getAction()->getId();
		$controller =  $app->getController()->getId();

		$cache_key = self::CACHE_META_INFO . $action . '_' . $controller;

		//ищем такую модель в кеше
		$model = $app->cache->get($cache_key);
		if($model === false)	{
			$model = self::model()->find('cntr_act=:cntr_act', array(':cntr_act'=> $controller . '/' . $action));
			$app->cache->set($cache_key, $model, $app->params['cache_duration']);
		}
		return $model;
	}
}
