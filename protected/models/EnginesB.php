<?php

/**
 * This is the model class for table "{{engines}}".
 *
 * The followings are the available columns in table '{{engines}}':
 * @property string $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $parent_id
 * @property string $name
 * @property integer $order
 *
 * The followings are the available model relations:
 * @property ShopProductsEngines[] $shopProductsEngines
 */
class Engines extends CActiveRecord
{
	
	public $dropDownListTree;
	public $DropDownlistData;
	public $parentId;
	public $new_parentId;
	public $fileImage = '';
	
	public $SelectedCategory;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{engines}}';
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
			array('name, image_title', 'length', 'max'=>255),
			array('image_file', 'length', 'max'=>64),
			array('engine', 'numerical', 'integerOnly'=>true),
			array('fileImage', 'file', 'types'=>'JPEG,JPG,PNG,TIFF,BMP', 'minSize' => 1024,'maxSize' => (5*1024*1024), 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый размер 5Мб', 'on'=>'upload_file'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, root, lft, rgt, level, parent_id, name, order', 'safe', 'on'=>'search'),
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
			'shopProductsEngines' => array(self::HAS_MANY, 'ShopProductsEngines', 'engine_id'),
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
			'parent_id' => 'Parent',
			'name' => 'Название',
			'image_title' => 'Заголовок изображения',
			'fileImage' => 'Изображение',
			'order' => 'Order',
			'dropDownListTree' => 'Родитель',
			'engine' => 'Объем двигателя',
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
		
		$app = Yii::app();
		
		$this->SelectedCategory = 0;
		if(isset($app->session['Engines.backend.selected']))	{
			$this->SelectedCategory = (int)$app->session['Engines.backend.selected'];
		}
				
		if($this->SelectedCategory)	{
			//echo'<pre>';var_dump($SelectedCategory);echo'</pre>';
			$cat_ids = $this->getChildrensIds($this->SelectedCategory);
			//echo'<pre>';var_dump($cat_ids);echo'</pre>';
			//$this->catego_ids = ShopProductsCategories::model()->getProductIdsInCategories($cat_ids);
			//echo'<pre>';print_r($product_ids);echo'</pre>';
			if($cat_ids)	{
				$criteria->condition = "t.`id` IN ($cat_ids)";
			}
		}		

		$criteria->compare('id',$this->id,true);
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('order',$this->order);
		
		$criteria->order = $this->tree->hasManyRoots
			?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
			:$this->tree->leftAttribute;		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => $app->params->pagination['models_per_page'],
			),			
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Engines the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())	{
			if($this->image_title == '' && $this->image_file != '') {
				// строим для заголовка картинки цепочку из названий
				$full_name = '';
				$full_name_arr = array('Схема выхлопной системы для');
				$ancestors = $this->ancestors()->findAll();
				if(count($ancestors)) {
					foreach($ancestors as $row) {
						$full_name_arr[] = $row->name;
					}
					$full_name_arr[] = $this->name;
					$this->image_title = implode(' ', $full_name_arr);
				}
			}
			return true;
		}
	}
	
	
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
	
	public function getDropDownlistTypes()
	{
		return $this->getDropDownlistItems();
	}
	
	// возвращает выпадающий список категорий для редактирования категории
	public function getDropDownlistData()
	{
		$list_data1 = $this->getDropDownlistItems();
		
		$selected = 'Верхний уровень';
		$list_data = array(0 => $selected);
		
		$list_data = $list_data + $list_data1;
		
		$this->DropDownlistData = $list_data;
		
		return true;
	}
	
	// возвращает выпадающий список категорий для редактирования товара
	public function getDropDownlistDataProduct()
	{
		$list_data = $this->getDropDownlistItems();
		return $list_data;
	}
	
	public function getDropDownlistItems()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		$level = 0;
		foreach($categories as $c){
			$separator = '';
			for ($x=1; $x++ < $c->level;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$result = CHtml::listData($categories, 'id','name');
		
		//Yii::app()->cache->set('DropDownlistCategories', $result, 300);		
		
		return $result;
	}
	
	//получаем ID родительской категории
	public function getParentId()
	{	
		$parent = $this->parent()->find();
		$this->parentId = $parent->id ? $parent->id : 0;
	}
	
	//получает список id дочерних категорий и текущей
	public function getChildrensIds($parentId)
	{
		$category = $this->findByPk($parentId);
		$descendants = $category->descendants()->findAll();
		$ids_arr = array();
		$ids_arr[] = $parentId;
		foreach($descendants as $item)	{
			$ids_arr[] = $item->id;
		}
		
		return implode(',', $ids_arr);		
	}
	
	
	function setparentid()
	{
		$criteria = new CDbCriteria;
		if($id != 0) {
			$criteria->condition = "`root` = $id";
		}
		$criteria->order = 't.root, t.lft'; // или 't.root, t.lft' для множественных деревьев
		$categories = $this->findAll($criteria);
		return true;
	}
	
	
	
	//удаление файла изображения
	public function deleteFile()
	{
		$imagePath = Yii::getPathOfAlias(Yii::app()->params->product_imagePath);		
		if($this->image_file != '' && file_exists($imagePath . DIRECTORY_SEPARATOR . $this->image_file)) {
			unlink($imagePath . DIRECTORY_SEPARATOR . $this->image_file);
		}		
		$this->image_file = '';
	}
	
	//загрузка фото
	public function uploadFile()
	{
		if($this->fileImage != null)	{
			
			$this->deleteFile();	//удаляем предыдущий файл, если он есть
			
			$imagePath = Yii::getPathOfAlias(Yii::app()->params->product_imagePath);

			$file_extention = $this->getExtentionFromFileName($this->fileImage->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$file_path = $imagePath . DIRECTORY_SEPARATOR . $filename;
			
			$this->fileImage->saveAs($file_path);
			
			$this->image_file = $filename;
		}
	}
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
}
