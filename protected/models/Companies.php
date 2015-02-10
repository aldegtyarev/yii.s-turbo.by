<?php

/**
 * This is the model class for table "{{companies}}".
 *
 * The followings are the available columns in table '{{companies}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 * @property string $introtext
 * @property string $fulltext
 * @property string $created
 * @property integer $user_id
 * @property integer $trash
 * @property integer $ordering
 * @property integer $featured
 * @property integer $featured_ordering
 * @property string $hits
 * @property string $params
 * @property string $metadesc
 * @property string $metadata
 * @property string $metakey
 * @property string $section
 * @property integer $region
 * @property integer $city
 * @property string $address
 * @property string $email
 * @property string $site
 * @property string $phone_mts
 * @property string $phone_vel
 * @property string $phone
 * @property integer $subscribers
 * @property integer $company_comments
 * @property double $company_rating
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Companies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{companies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, introtext, fulltext, created, hits, params, metadesc, metadata, metakey, address, email, site, phone_mts, phone_vel, phone', 'required'),
			array('published, user_id, trash, ordering, featured, featured_ordering, region, city, subscribers, company_comments', 'numerical', 'integerOnly'=>true),
			array('company_rating', 'numerical'),
			array('title, alias', 'length', 'max'=>255),
			array('hits', 'length', 'max'=>10),
			array('section, address, phone_mts, phone_vel, phone', 'length', 'max'=>1000),
			array('email, site', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, alias, published, introtext, fulltext, created, user_id, trash, ordering, featured, featured_ordering, hits, params, metadesc, metadata, metakey, section, region, city, address, email, site, phone_mts, phone_vel, phone, subscribers, company_comments, company_rating', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'alias' => 'Alias',
			'published' => 'Published',
			'introtext' => 'Introtext',
			'fulltext' => 'Fulltext',
			'created' => 'Created',
			'user_id' => 'User',
			'trash' => 'Trash',
			'ordering' => 'Ordering',
			'featured' => 'Featured',
			'featured_ordering' => 'Featured Ordering',
			'hits' => 'Hits',
			'params' => 'Params',
			'metadesc' => 'Metadesc',
			'metadata' => 'Metadata',
			'metakey' => 'Metakey',
			'section' => 'Section',
			'region' => 'Region',
			'city' => 'City',
			'address' => 'Address',
			'email' => 'Email',
			'site' => 'Site',
			'phone_mts' => 'Phone Mts',
			'phone_vel' => 'Phone Vel',
			'phone' => 'Phone',
			'subscribers' => 'Subscribers',
			'company_comments' => 'Company Comments',
			'company_rating' => 'Company Rating',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('introtext',$this->introtext,true);
		$criteria->compare('fulltext',$this->fulltext,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('trash',$this->trash);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('featured',$this->featured);
		$criteria->compare('featured_ordering',$this->featured_ordering);
		$criteria->compare('hits',$this->hits,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('metadata',$this->metadata,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('region',$this->region);
		$criteria->compare('city',$this->city);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('phone_mts',$this->phone_mts,true);
		$criteria->compare('phone_vel',$this->phone_vel,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('subscribers',$this->subscribers);
		$criteria->compare('company_comments',$this->company_comments);
		$criteria->compare('company_rating',$this->company_rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Companies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @Возвращает массив компаний
	 */

	public function getAllCompanies()
	{
		$criteria = new CDbCriteria();
		$criteria->select = "*";
		$criteria->condition = "`trash` = 0 AND `published` = 1";
		$criteria->order = "`featured` DESC, `ordering` DESC, `company_rating` DESC";
		//echo'<pre>';print_r($criteria,0);echo'</pre>';

		//$count = User::model()->count($criteria);
		$count = $this->count($criteria);
		$pages = new CPagination($count);
		$pages->pageSize = Yii::app()->params->pagination['products_per_page']; // элементов на страницу
		$pages->applyLimit($criteria);
		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return array('rows' => $rows, 'pages' => $pages);
		
	}
}
