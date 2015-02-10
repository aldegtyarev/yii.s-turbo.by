<?php

/**
 * This is the model class for table "{{shop_medias}}".
 *
 * The followings are the available columns in table '{{shop_medias}}':
 * @property string $media_id
 * @property string $file_title
 * @property string $file_mimetype
 * @property string $file_type
 * @property string $file_url
 * @property string $file_url_thumb
 * @property integer $published
 *
 * The followings are the available model relations:
 * @property ShopCategoriesMedias[] $shopCategoriesMediases
 * @property ShopProductsMedias[] $shopProductsMediases
 */
class ShopMedias extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_medias}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('published', 'numerical', 'integerOnly'=>true),
			array('file_title', 'length', 'max'=>126),
			array('file_mimetype', 'length', 'max'=>64),
			array('file_type', 'length', 'max'=>32),
			array('file_url_thumb', 'length', 'max'=>254),
			array('file_url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('media_id, file_title, file_mimetype, file_type, file_url, file_url_thumb, published', 'safe', 'on'=>'search'),
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
			'shopCategoriesMediases' => array(self::HAS_MANY, 'ShopCategoriesMedias', 'media_id'),
			'shopProductsMediases' => array(self::HAS_MANY, 'ShopProductsMedias', 'media_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'media_id' => 'Media',
			'file_title' => 'File Title',
			'file_mimetype' => 'File Mimetype',
			'file_type' => 'File Type',
			'file_url' => 'File Url',
			'file_url_thumb' => 'File Url Thumb',
			'published' => 'Published',
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

		$criteria->compare('media_id',$this->media_id,true);
		$criteria->compare('file_title',$this->file_title,true);
		$criteria->compare('file_mimetype',$this->file_mimetype,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('file_url',$this->file_url,true);
		$criteria->compare('file_url_thumb',$this->file_url_thumb,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopMedias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCategoriesMedias($ids = array())
	{
		$rows = array();
		if(count($ids))	{
			$connection = Yii::app()->db;
			$sql = "SELECT cm.`category_id`, m.`file_url` FROM {{shop_medias}} AS m INNER JOIN {{shop_categories_medias}} AS cm USING(`media_id`) WHERE cm.`category_id` IN(".(implode(',', $ids)).") ";
			$command = $connection->createCommand($sql);
			$rows_ = $command->queryAll();
			//echo'<pre>';print_r($rows_);echo'</pre>';
			foreach($rows_ as $r)	{
				$rows[$r['category_id']] = $r['file_url'];
			}
		}
		return $rows;
	}
	
	
}
