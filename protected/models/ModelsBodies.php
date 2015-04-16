<?php

/**
 * This is the model class for table "{{shop_models_bodies}}".
 *
 * The followings are the available columns in table '{{shop_models_bodies}}':
 * @property integer $id
 * @property integer $model_id
 * @property string $body_id
 *
 * The followings are the available model relations:
 * @property ShopBodies $body
 * @property ShopModelsAuto $model
 */
class ModelsBodies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_models_bodies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id, body_id', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('body_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_id, body_id', 'safe', 'on'=>'search'),
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
			'model' => array(self::BELONGS_TO, 'ShopModelsAuto', 'model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model_id' => 'Model',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('body_id',$this->body_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelsBodies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//удаление категорий назначенных товару
	public function clearModelBody($model_id, &$connection)
	{
		$sql = 'DELETE FROM {{shop_models_bodies}} WHERE `model_id` = :model_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":model_id", $model_id);
		$res = $command->execute();		
	}
	
	//добавление категорий товару
	public function insertModelBody($body_ids, $model_id, &$connection)
	{
		if(count($body_ids))	{
			$sql = 'INSERT INTO {{shop_models_bodies}} (`model_id`, `body_id`) VALUES ';	
			foreach($body_ids as $key => $cat)	{
				$sql .= "(".$model_id.",".$key."),";
			}
			$sql = substr($sql, 0, -1);
			//echo'<pre>';print_r($sql);echo'</pre>';
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
	}
	
}
