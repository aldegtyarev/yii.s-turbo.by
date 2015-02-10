<?php

/**
 * This is the model class for table "{{companies_categories}}".
 *
 * The followings are the available columns in table '{{companies_categories}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property CompaniesCategoriesMap[] $companiesCategoriesMaps
 */
class CompaniesCategories extends CActiveRecord
{
	
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	//public $category_image;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{companies_categories}}';
	}
	
	public function behaviors()
	{
		return array(
			'tree'=>array(
				'class'=>'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'level',
				'hasManyRoots'=>true,
			),
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
			array('name', 'required'),
			array('root, lft, rgt, level, ordering', 'numerical', 'integerOnly'=>true),
			array('name, title, alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, root, lft, rgt, level, name, title, keywords, description, alias, ordering', 'safe', 'on'=>'search'),
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
			'companiesCategoriesMaps' => array(self::HAS_MANY, 'CompaniesCategoriesMap', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'name' => 'Name',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'alias' => 'Alias',
			'ordering' => 'Ordering',
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
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('ordering',$this->ordering);
		
       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CompaniesCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function save($runValidation=true,$attributes=null)
	{
		//var_dump($this->parentId);
		//var_dump($this->isNewRecord);
		if($this->isNewRecord)	{
			switch($this->parentId)	{
				case 0:
					$this->saveNode();
					break;
				default:
					echo '*/*/*';
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
	
	// возвращает выпадающий список категорий
	public function getDropDownlistData()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		$level=0;
		foreach($categories as $c){
			$separator = '';
			for ($x=1; $x++ < $c->level;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		

		$list_data1 = CHtml::listData($categories, 'id','name');
		//echo'<pre>';print_r($list_data1);echo'</pre>';
		
		$selected = 'Верхний уровень';
		$list_data = array(0 => $selected);
		//$list_data = array_merge($list_data, $list_data1);
		$list_data = $list_data + $list_data1;
		//echo'<pre>';print_r($list_data);echo'</pre>';
		//echo'<pre>';print_r($list_data + $list_data1);echo'</pre>';
		
		//$this->dropDownListTree = CHtml::dropDownList($name = 'parent_level', $selected, $list_data, $htmlOptions = array());
		$this->DropDownlistData = $list_data;
		//echo'<pre>';print_r($this->DropDownlistData);echo'</pre>';
		//echo'<pre>';print_r($list_data);echo'</pre>';
		//return CHtml::dropDownList($name = 'parent_level', $selected, $list_data, $htmlOptions = array());
		return true;
	}
	
	
}
