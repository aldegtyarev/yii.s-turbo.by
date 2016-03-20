<?php

/**
 * This is the model class for table "{{shop_categories_relations}}".
 *
 * The followings are the available columns in table '{{shop_categories_relations}}':
 * @property integer $id
 * @property integer $category_id
 * @property integer $category_related_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property ShopCategories $categoryRelated
 * @property ShopCategories $category
 * @property ShopCategoriesRelationsModels[] $shopCategoriesRelationsModels
 */
class ShopCategoriesRelations extends CActiveRecord
{
	public $modelIdsSelected = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_categories_relations}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, category_related_id', 'required'),
			array('category_id, category_related_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			array('id, category_id, category_related_id', 'safe', 'on'=>'search'),
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
			'categoryRelated' => array(self::BELONGS_TO, 'ShopCategories', 'category_related_id'),
			'category' => array(self::BELONGS_TO, 'ShopCategories', 'category_id'),
			'categoriesRelationsModels' => array(self::HAS_MANY, 'ShopCategoriesRelationsModels', 'category_relation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'category_related_id' => 'Category Related',
			'name' => 'Текст ссылки',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('category_related_id',$this->category_related_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterSave()
	{
		parent::afterSave();

		$connection = Yii::app()->db;
		$this->checkModels($connection);
	}


	/**
	 * проверяем, не изменились ли модели авто...
	 * @param mixed $connection
	 */
	public function checkModels(&$connection)
	{
		$categoriesRelationsModels = $this->categoriesRelationsModels;

		//если ничего до сохраниения не было добавлено
		// а теперь добавили то добавляем потомков добавленных моделей
		if(count($categoriesRelationsModels) == 0 && count($this->modelIdsSelected) != 0)
			$this->modelIdsSelected = ShopModelsAuto::model()->addDescedantsOfModels($this->modelIdsSelected);



		if(count($this->modelIdsSelected))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		if(count($categoriesRelationsModels) != count($this->modelIdsSelected))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($categoriesRelationsModels as $cat_item)	{
				$cat_is_present = false;
				foreach($this->modelIdsSelected as $key=>$val)	{
					if($cat_item->model_id == $val)	{
						$cat_is_present = true;
						break;
					}
				}

				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}
		//echo'<pre>';var_dump($arrays_of_identical);echo'</pre>';//die;
		//die;
		if($arrays_of_identical == false)	{
			ShopCategoriesRelationsModels::model()->clearItemModels($this->id, $connection);
			ShopCategoriesRelationsModels::model()->insertItemModels($this->modelIdsSelected, $this->id, $connection);
		}

	}

	/**
	 * устанавливает выбранные модели авто
	 * @param array $model_ids
	 */
	public function setSelectedModelIds($model_ids = array())
	{
		$this->modelIdsSelected = array();
		foreach($model_ids as $model_id)
			$this->modelIdsSelected[$model_id] = array('selected'=>'selected');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCategoriesRelations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * получает связанные категории в зависимости от выбранной модели
	 * @param mixed $connection
	 * @param int $category_id
	 * @param int $model_id
	 * @return array
	 */
	public static function getRelatedCategories($connection, $category_id = 0, $model_id = 0)
	{
		if(is_null($model_id)) return array();
		$sql = "
				SELECT cat.id, cat.name, cat.uni, cat_rel.name AS cat_rel_name
				FROM {{shop_categories}} AS cat
				INNER JOIN {{shop_categories_relations}} AS cat_rel ON cat.id = cat_rel.category_related_id
				INNER JOIN {{shop_categories_relations_models}} AS cat_rel_mod ON cat_rel.id = cat_rel_mod.category_relation_id
				WHERE cat_rel.category_id = $category_id AND cat_rel_mod.model_id = $model_id
				";
		$command = $connection->createCommand($sql);
		return $command->queryAll();
	}
}
