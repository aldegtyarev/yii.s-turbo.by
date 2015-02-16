<?php

/**
 * This is the model class for table "{{shop_posts}}".
 *
 * The followings are the available columns in table '{{shop_posts}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 * @property string $introtext
 * @property string $fulltext
 * @property string $created
 * @property string $hits
 * @property string $metadesc
 * @property string $metadata
 * @property string $metakey
 */
class ShopPosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_posts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, introtext, fulltext', 'required'),
			array('published', 'numerical', 'integerOnly'=>true),
			array('title, alias, image', 'length', 'max'=>255),
			array('hits', 'length', 'max'=>10),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'title'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, alias, published, image, introtext, fulltext, created, hits, metadesc, metadata, metakey', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'alias' => 'Alias',
			'published' => 'Published',
			'image' => 'Image',
			'introtext' => 'Introtext',
			'fulltext' => 'Fulltext',
			'created' => 'Created',
			'hits' => 'Hits',
			'metadesc' => 'Metadesc',
			'metadata' => 'Metadata',
			'metakey' => 'Metakey',
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
		$criteria->compare('hits',$this->hits,true);
		$criteria->compare('metadesc',$this->metadesc,true);
		$criteria->compare('metadata',$this->metadata,true);
		$criteria->compare('metakey',$this->metakey,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopPosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->fulltext = str_replace('src="images/', 'src="uploads/images/', $this->fulltext);
			/*
			if(!$this->ordering)	{
				$this->ordering = $this->getNextOrdering();
			}
			
			if($this->isNewRecord)	{
				if($this->search_keywords == '') {
					$this->search_keywords = strip_tags($this->item_description);
				}
				$this->checkTime = Yii::app()->dateFormatter->format('yyyy-MM-dd', time());
			}	else	{
				$this->checkTime = Yii::app()->dateFormatter->format('yyyy-MM-dd', $this->checkTime);
			}
			*/
			return true;
		}	else	{
			return false;
		}
	}	
	
	/*
	public function save($runValidation = true, $attributes = null)
	{
		if($this->isNewRecord)	{
			switch($this->parentId)	{
				case 0:
					$this->saveNode();
					break;
				default:
					$root = $this->findByPk($this->parentId);
					if($root)	{
						$this->appendTo($root);
					}
					break;
			}
		
		}	else	{
			if($this->new_parentId != $this->parentId)	{
				if($this->new_parentId > 0)	{
					$root = $this->findByPk($this->new_parentId);
					$this->moveAsLast($root);
				}	else	{
					$this->moveAsRoot();
				}
			}
			
			$this->saveNode();
		}

		
		return true;
	}		
	*/
	
}
