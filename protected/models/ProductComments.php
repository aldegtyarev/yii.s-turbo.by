<?php

/**
 * This is the model class for table "{{product_comments}}".
 *
 * The followings are the available columns in table '{{product_comments}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $marka
 * @property integer $model
 * @property integer $year
 * @property string $product_url
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property string $answer
 * @property integer $created
 * @property integer $modified
 *
 * The followings are the available model relations:
 * @property ShopProducts $product
 *
 * @property string $commentator
 */
class ProductComments extends CActiveRecord
{
    const CACHE_META_INFO = 'ProductCommentsCount-';

    private $_modelName;

    private $_commentator;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_comments}}';
	}

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

    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, marka, model, year, name, comment, answer', 'required'),
			array('product_id, marka, model, year', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('email', 'length', 'max'=>256),
			array('comment, answer', 'length', 'max'=>2048),
			// The following rule is used by search().
			array('id, product_id, conamemment, email', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'product_id' => 'Товар',
			'name' => 'Имя',
			'email' => 'Email',
			'comment' => 'Комментарий',
			'answer' => 'Ответ',
			'commentator' => 'Комментатор',
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
	public function search($pageSize = 0, $withAnswerOnly = false)
	{
        $app = Yii::app();

		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('product_url',$this->product_url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('answer',$this->answer,false);

        if($withAnswerOnly === true) $criteria->addCondition('answer <> ""');

        $sort = new CSort();
        $sort->defaultOrder = '`id` DESC'; // устанавливаем сортировку по умолчанию


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,

            'pagination'=>array(
                'pageSize' => $pageSize ? $pageSize : $app->params->pagination['products_per_page'],
            ),
        ));
	}

	public function getCommentator()
    {
        if (is_null($this->_commentator)) {
            //$this->_commentator = 'Commentator';
        }

        return 'Commentator';
    }

    public function getModelName()
    {
        if(is_null($this->_modelName)) {
            if($this->marka != 0 && $this->model && $this->year) {
                $app = Yii::app();
                $connection = $app->db;
                $url_params = array(
                    'marka' => $this->marka,
                    'model' => $this->model,
                    'year' => $this->year,
                );

                $this->_modelName = ShopProducts::model()->buildModelInfo($app, $connection, $url_params);
            } else {
                $this->_modelName = '';
            }

            $result = $this->_modelName;
        } else {
            $result = $this->_modelName;
        }

        return $result;
    }


    public function getProductComments($productId)
    {
        $model = new self();
        $model->product_id = $productId;
//        $model->answer = '<>""';
        return $model->search(1000, true);
    }

    protected function afterSave()
    {
        parent::afterSave();
        $cache_key = self::buildCacheKey($this->product_id);
        Yii::app()->cache->set($cache_key, false);

        if ($this->email != '' && $this->answer != '') {
            // отправляем пользователю уведомление об ответе

            $to = array($this->email);
            $data = array('model' => $this);

            Yii::app()->dpsMailer->sendByView(
                $to, // определяем кому отправляется письмо
//            array('aldegtyarev@yandex.ru'), // определяем кому отправляется письмо
                'emailAnswerOnQuestion', // view шаблона письма
                $data
            );

        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getProductQuestionsCount($models, $connection, $app)
    {
        $arProductIds = $res = array();

        foreach ($models as $model) {
            $cache_key = self::buildCacheKey($model->product_id);
            $questionsCount = $app->cache->get($cache_key);
            if($questionsCount === false || is_null($questionsCount))	{
                $arProductIds[] = $model->product_id;
            } else {
                $res[$model->product_id] = $questionsCount;
            }
        }

//        echo'<pre>';print_r($res);echo'</pre>';

        if(count($arProductIds)) {
            $sql = "SELECT `product_id`, count(`id`) AS count FROM {{product_comments}} WHERE `product_id` IN (" . implode(',', $arProductIds) . ") AND `answer` <> '' GROUP BY `product_id";
            $command = $connection->createCommand($sql);
            $rows = $command->queryAll();

            foreach ($rows as $row) {
                $res[$row['product_id']] = $row['count'];

                $cache_key = self::buildCacheKey($row['product_id']);
                $app->cache->set($cache_key, $row['count'], $app->params['cache_duration']);
            }
        }

//        echo'<pre>';print_r($res);echo'</pre>';

        return $res;
    }

    public static function buildCacheKey($productId)
    {
        return self::CACHE_META_INFO . $productId;
    }




}
