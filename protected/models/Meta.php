<?php

/**
 * This is the model class for table "{{meta}}".
 *
 * The followings are the available columns in table '{{meta}}':
 * @property integer $id
 * @property string $name
 * @property string $cntr_act
 * @property string $category_id
 * @property string $model_id
 * @property string $type_id
 * @property string $metatitle
 * @property string $metakey
 * @property string $metadesc
 * @property string $descr
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

	/*
	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => 'modified',
			)
		);
	}
	*/


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, metatitle, metakey, metadesc', 'required'),
			array('name', 'length', 'max'=>255),
			array('category_id, model_id, type_id, published', 'numerical', 'integerOnly'=>true),
			array('cntr_act, metatitle, metakey', 'length', 'max'=>255),
			array('metadesc', 'length', 'max'=>1024),
			array('descr', 'length', 'max'=>2048),
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
			'published' => 'Опубликовано',
			'cntr_act' => 'Controller/Action',
			'category_id' => 'Категория',
			'model_id' => 'Модель',
			'type_id' => 'Группа',
			'metatitle' => 'Title',
			'metakey' => 'Keywords',
			'metadesc' => 'Description',
			'descr' => 'SEO текст',
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
        $app = Yii::app();

        $criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cntr_act',$this->cntr_act,true);
		$criteria->compare('metatitle',$this->metatitle,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize' => $app->params->pagination['products_per_page'],
            ),

        ));
	}


	protected function afterSave() {
		parent::afterSave();

		if($this->cntr_act != '') {
			$arr = explode('/', $this->cntr_act);
			$controller = $arr[0];
			$action = $arr[1];
			$cache_key = self::CACHE_META_INFO . $action . '_' . $controller;
		}	else	{
			$cache_key = self::CACHE_META_INFO;
			$cache_key_arr = array();

			//$cache_key = self::CACHE_META_INFO . $params['id'] . '_' . $params['year'];
			//if(!is_null($params['type'])) $cache_key .=  '_' . $params['type'];

			if($this->category_id != 0) $cache_key_arr[] = $this->category_id;
				else $cache_key_arr[] = 0;

			if($this->model_id != 0) $cache_key_arr[] = $this->model_id;
				else $cache_key_arr[] = 0;

			if($this->type_id != 0) $cache_key_arr[] = $this->type_id;
				else $cache_key_arr[] = 0;

			if(count($cache_key_arr) != 0) $cache_key .= implode('_', $cache_key_arr);
		}

		//echo'<pre>';var_dump($cache_key);echo'</pre>';die;
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

	/**
	 * получает мета информацию по паре $action / $controller
	 * @return mixed
	 */
	public static function getMetaInfoControllerAction()
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

	/**
	 * получает мета информацию по категории указанному авто и группе товаров
	 *
	 * @param $params
	 * @return mixed
	 */
	public static function getMetaInfoCategoryModel($params, $is_uni = false)
	{
		//echo'<pre>';print_r($params);echo'</pre>';//die;

		$app = Yii::app();

		$cache_key = self::buildCacheKey($params, $is_uni);
		//echo'<pre>';var_dump($cache_key);echo'</pre>';//die;

		//ищем такую модель в кеше
		$model = $app->cache->get($cache_key);

		if($model === false || is_null($model))	{
			$condition_arr = array('published = 1');
			$params_arr = array();


            $condition_arr[] = 'category_id = :category_id';
            if(!is_null($params['id'])) {
				$params_arr[':category_id'] = strip_tags($params['id']);
			}   else    {
                $params_arr[':category_id'] = 0;
            }

            $condition_arr[] = 'model_id = :model_id';
            if($is_uni === false) {
                if (!is_null($params['year'])) {
                    $params_arr[':model_id'] = strip_tags($params['year']);
                }   else    {
                    $params_arr[':model_id'] = 0;
                }
            }   else    {
                $params_arr[':model_id'] = 0;
            }

            $condition_arr[] = 'type_id = :type_id';
            if (!is_null($params['type'])) {
                $params_arr[':type_id'] = strip_tags($params['type']);
            }   else    {
                $params_arr[':type_id'] = 0;
            }


			//echo'<pre>';print_r($condition_arr);echo'</pre>';//die;
			//echo'<pre>';print_r($params_arr);echo'</pre>';//die;

			if(count($condition_arr)) {
				$model = self::model()->find(implode(' AND ', $condition_arr), $params_arr);
				$app->cache->set($cache_key, $model, $app->params['cache_duration']);
			}
		}

        //echo'<pre>';var_dump($model);echo'</pre>';//die;

        return $model;
	}

    /**
     * строит ключ для поиска в кеше сохраненных данных
     *
     * @param array $params
     * @param bool $is_uni
     * @return string
     */
    public static function buildCacheKey($params = array(), $is_uni = false)
	{
		//$cache_key = self::CACHE_META_INFO . $params['id'] . '_' . $params['year'];
		$cache_key = self::CACHE_META_INFO;
		$cache_key_arr = array();
		if(!is_null($params['id'])) $cache_key_arr[] = $params['id'];
			else $cache_key_arr[] = 0;

		if(!is_null($params['year']) && $is_uni === false) $cache_key_arr[] = $params['year'];
			else $cache_key_arr[] = 0;

		if(!is_null($params['type'])) $cache_key_arr[] = $params['type'];
			else $cache_key_arr[] = 0;

		return $cache_key . implode('_', $cache_key_arr);
	}
}
