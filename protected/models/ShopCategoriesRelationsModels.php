<?php

/**
 * This is the model class for table "{{shop_categories_relations_models}}".
 *
 * The followings are the available columns in table '{{shop_categories_relations_models}}':
 * @property integer $id
 * @property integer $category_relation_id
 * @property integer $model_id
 *
 * The followings are the available model relations:
 * @property ShopModelsAuto $model
 * @property ShopCategoriesRelations $categoryRelation
 */
class ShopCategoriesRelationsModels extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_categories_relations_models}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_relation_id, model_id', 'required'),
			array('category_relation_id, model_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, category_relation_id, model_id', 'safe', 'on'=>'search'),
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
			'categoryRelation' => array(self::BELONGS_TO, 'ShopCategoriesRelations', 'category_relation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_relation_id' => 'Category Relation',
			'model_id' => 'Model',
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
		$criteria->compare('category_relation_id',$this->category_relation_id);
		$criteria->compare('model_id',$this->model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * удаление категорий назначенных товару
	 * @param int $category_related_id
	 * @param mixed $connection
	 * @return bool
	 */
	public function clearItemModels($category_related_id = 0, &$connection)
	{
		$sql = 'DELETE FROM '.$this->tableName().' WHERE `category_relation_id` = :category_relation_id';
		$command = $connection->createCommand($sql);
		$command->bindParam(":category_relation_id", $category_related_id);
		return $command->execute();
	}

	/**
	 * добавление моделей товару
	 * @param array $rows
	 * @param int $category_relation_id
	 * @param mixed $connection
	 * @return bool
	 */
	public function insertItemModels($rows = array(), $category_relation_id, &$connection)
	{
		$res = false;
		if(count($rows))	{
			$sql = 'INSERT INTO '.$this->tableName().' (`category_relation_id`, `model_id`) VALUES ';

			$values = array();
			foreach($rows as $key => $row)	{
				$values[] = "(".$category_relation_id.", ".$key.")";
			}
			$sql .= implode(', ', $values);
			//echo'<pre>';print_r($sql);echo'</pre>';die;
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}

		return $res;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCategoriesRelationsModels the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
