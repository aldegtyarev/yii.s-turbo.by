<?php

/**
 * This is the model class for table "{{categories}}".
 *
 * The followings are the available columns in table '{{categories}}':
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Categories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	 
	 
	public function tableName()
	{
		return '{{categories}}';
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
			//array('lft, rgt, level, name, title, keywords, description', 'required'),
			array('name', 'required'),
			array('id, lft, rgt, level', 'numerical', 'integerOnly'=>true),
			array('name, title, alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('parentId, id, lft, rgt, level, name, title, keywords, description, alias', 'safe', 'on'=>'search'),
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
			'parentId' => 'parentId',
			'id' => 'ID',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'name' => 'Name',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'alias' => 'Псевдоним',
			'dropDownListTree' => 'dropDownListTree',
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
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('alias',$this->alias,true);

       $criteria->order = $this->tree->hasManyRoots
                           ?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                           :$this->tree->leftAttribute;		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			),
		));
	}
	
	public function save($runValidation=true,$attributes=null)
	{
		//$new_Categories = $_POST['Categories'];
		//$this->attributes = $_POST['Categories'];
		//echo'<pre>';print_r($_POST['Categories']);echo'</pre>';
		//$this->parentId = $_POST['Categories']['parentId'];
		//echo'<pre>';print_r($this->attributes);echo'</pre>';
		
		if($this->isNewRecord)	{
			echo'<pre>';print_r('isNewRecord');echo'</pre>';
			switch($this->parentId)	{
				case 0:
					$this->saveNode();
					break;
				default:
					//echo'<pre>';print_r($new_Categories);echo'</pre>';
					//echo'<pre>';print_r($this->parentId);echo'</pre>';
					$root = Categories::model()->findByPk($this->parentId);
					//echo'root=<pre>';print_r($root);echo'</pre>';
					if($root)	{
						$this->appendTo($root);
					}
					break;
			}
		
		}	else	{
			//parent::save();
			//$this->save(false);
			$this->saveNode();
		}
		
		return true;
		/*
		echo 'save';
		$root = new Category;
		$root->title='Mobile Phones';
		$root->saveNode();
		$root=new Category;
		$root->title='Cars';
		$root->saveNode();		
		die;
		*/
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	// возвращает дерево категорий
	public function getTreeCategories()
	{
		$criteria=new CDbCriteria;
		$criteria->order='t.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories=$this->findAll($criteria);
		$level=0;
		
		foreach($categories as $n=>$category)
		{
			if($category->level==$level)
				echo CHtml::closeTag('li')."\n";
			else if($category->level>$level)
				echo CHtml::openTag('ul')."\n";
			else
			{
				echo CHtml::closeTag('li')."\n";

				for($i=$level-$category->level;$i;$i--)
				{
					echo CHtml::closeTag('ul')."\n";
					echo CHtml::closeTag('li')."\n";
				}
			}

			echo CHtml::openTag('li');
			echo CHtml::encode($category->name);
			$level=$category->level;
		}

		for($i=$level;$i;$i--)
		{
			echo CHtml::closeTag('li')."\n";
			echo CHtml::closeTag('ul')."\n";
		}	
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
