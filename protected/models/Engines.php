<?php

/**
 * This is the model class for table "{{engines}}".
 *
 * The followings are the available columns in table '{{engines}}':
 * @property integer $id
 * @property integer $model_id
 * @property string $name
 * @property string $image_title
 * @property string $image_file
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * The followings are the available model relations:
 * @property ShopModelsAuto $model
 * @property ShopProductsEngines[] $shopProductsEngines
 */
class Engines extends CActiveRecord
{
	
	public $fileImage = '';
	public $DropDownListModels;
	public $SelectedModels;
	public $model_ids;
	
	public $DropDownListEngines;
	public $SelectedEngines;
	public $engine_ids;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{engines}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_ids, name', 'required'),
			//array('model_id', 'numerical', 'integerOnly'=>true),
			array('name, image_title, title, keywords, description', 'length', 'max'=>255),
			array('image_file', 'length', 'max'=>64),
			array('fileImage', 'file', 'types'=>'JPEG,JPG,PNG,TIFF,BMP', 'minSize' => 1024,'maxSize' => (5*1024*1024), 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый размер 5Мб', 'on'=>'upload_file'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_id, name, image_title, image_file, title, keywords, description', 'safe', 'on'=>'search'),
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
			'productsEngines' => array(self::HAS_MANY, 'ShopProductsEngines', 'engine_id'),
			'enginesModels' => array(self::HAS_MANY, 'EnginesModels', 'engine_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model_id' => 'Model',
			'name' => 'Название',
			'image_title' => 'Заголовок изображения',
			'fileImage' => 'Изображение',
			'order' => 'Order',
			'dropDownListTree' => 'Родитель',
			'engine' => 'Объем двигателя',
			'title' => 'Meta Title',
			'keywords' => 'Meta Keywords',
			'description' => 'Meta Description',
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

		$criteria = new CDbCriteria;
		$sort = new CSort();
		
		$app = Yii::app();
		
		$selected_model = 0;
		if(isset($app->session['Engines.selected_model']) && $app->session['Engines.selected_model'] > 0)	{
			$selected_model = (int)$app->session['Engines.selected_model'];
		}
				
		$criteria->compare('id',$this->id);
		//$criteria->compare('model_id',$this->model_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image_title',$this->image_title,true);
		$criteria->compare('image_file',$this->image_file,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		
		
		if($selected_model > 0) {
			
			//находим дочерние элементы и тоже добавляем их в поиск
			$ShopModelAuto = ShopModelsAuto::model()->findByPk($selected_model);
			$descendants = $ShopModelAuto->descendants()->findAll();
			$children_ids = CHtml::listData($descendants, 'id','id');

			$model_ids = array($selected_model => $selected_model) + $children_ids;
			
			$criteria->distinct = true;
			$criteria->join = 'INNER JOIN {{engines_models}} AS em ON t.id = em.engine_id';
			$criteria->addInCondition("em.model_id", $model_ids);
		}
		
		$sort->defaultOrder = '`model_id` DESC'; // устанавливаем сортировку по умолчанию

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'sort'=>$sort,
			
			'pagination'=>array(
				'pageSize' => $app->params->pagination['products_per_page'],
			),		
			
		));
	}

	public function searchmodellist()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$app = Yii::app();

		$criteria->compare('id',$this->id);
		//$criteria->compare('model_id',$this->model_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image_title',$this->image_title,true);
		$criteria->compare('image_file',$this->image_file,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		
		$criteria->join = 'INNER JOIN {{engines_models}} as em ON t.id = em.engine_id';
		$criteria->addCondition("em.model_id = ".(int)$app->request->getParam('model_id', -1));
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			return true;
		}
	}
	
	public function afterSave()
	{
		$app = Yii::app();
		$connection = $app->db;
		$this->checkEnginesModels($connection);
		
		if($this->image_title == '' && $this->image_file != '') {
			// строим для заголовка картинки цепочку из названий
			$full_name = '';
			
			$models = $this->enginesModels;
			
			//echo'<pre>';print_r($models);echo'</pre>';die;		
			if(count($models)) {
				foreach($models as $row) {
					//echo'<pre>';print_r($row);echo'</pre>';die;		
					$model_info = ShopModelsAuto::model()->findByPk($row->model_id);
					
					$ancestors = $model_info->ancestors()->findAll();
					if(count($ancestors)) {
						$full_name_arr = array('Схема выхлопной системы для');
						
						foreach($ancestors as $ancestor) {
							$full_name_arr[] = $ancestor->name;
						}
						
						$full_name_arr[] = $model_info->name;
						$full_name_arr[] = $this->name;
						$row->image_title = implode(' ', $full_name_arr);
						$row->save(false);
					}

				}
			}
		}
		
	}
	
	//проверяем, не изменились ли объемы двигателей...
	function checkEnginesModels(&$connection)
	{
		$EnginesModels = $this->enginesModels;
		
		if(count($EnginesModels))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}
		
		//проверяем, не изменились ли категории...
		if(count($EnginesModels) != count($this->SelectedModels))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($EnginesModels as $cat_item)	{
				$cat_is_present = false;
				foreach($this->SelectedModels as $key=>$val)	{
					if($cat_item['model_id'] == $key)	{
						$cat_is_present = true;
					}
				}
				if($cat_is_present == false)	{
					$arrays_of_identical = false;
					break;
				}
			}
		}
		
		if($arrays_of_identical == false || $models_changed == true)	{
			EnginesModels::model()->clearItemEngines($this->id, $connection);
			EnginesModels::model()->insertItemEngines($this->SelectedModels, $this->id, $connection);
		}
	}
	
	// возвращает выпадающий список двигателей
	public function getDropDownlistEngines($selectedModels)
	{
		if(count($selectedModels))	{
			$model_ids = array();
			foreach($selectedModels as $k=>$i)
				$model_ids[] = $k;

			//echo'<pre>';print_r($model_ids);echo'</pre>';die;
			$list_data = $this->getDropDownlistItems($model_ids);
		}	else	{
			$list_data = array();
		}
		return $list_data;
	}
	
	public function getDropDownlistAllEngines($model_ids = array(0))
	{
		$rows = $this->findAll();
		foreach($rows as $row)	{
			$model_title = ShopModelsAuto::model()->getModelChain($row->model_id);
			$row->name = $model_title.' '.$row->name;
		}
		$result = CHtml::listData($rows, 'id','name');
		return $result;
	}
	
	public function getDropDownlistItems($model_ids = array(0))
	{
		//$base_memory_usage = memory_get_usage();
		//echo'<pre>';print_r($base_memory_usage);echo'</pre>';//die;
		
		$criteria = new CDbCriteria;
		
		//$criteria->distinct = true;
		//$criteria->join = 'INNER JOIN {{engines_models}} AS em ON t.id = em.engine_id';
		$criteria->condition = 'model_id IN ('.implode(',', $model_ids).')';
		$criteria->order = 'id';
		//$rows = $this->findAll($criteria);
		$rows = EnginesModels::model()->findAll($criteria);
		
		
		
//		$model_infos = array();
//		foreach($model_ids as $model_id) {
//			$model_infos[] = ShopModelsAuto::model()->findByPk($model_id);
//		}
		
		
		
		
		//echo'<pre>';print_r(count($rows));echo'</pre>';//die;
		//echo'<pre>';print_r(count($model_infos));echo'</pre>';//die;
		
//		echo "String memory usage test.\n\n";
		
		
		//$this->memoryUsage(memory_get_usage(), $base_memory_usage);
		
		//$i = 1;
		//$max = 50;
		
		foreach($rows as &$row)	{
			//echo'<pre>-------------------</pre>';
			//echo'<pre>';print_r($row->name);echo'</pre>';
			
			$model_title = ShopModelsAuto::model()->getModelChain($row->model_id);
			$row->name = $model_title.' '.$row->engine->name;
			/*
			foreach($model_infos as &$model_info) {
				$model_title = $model_info->getModelChain($row->model_id);
				$row->name = $model_title.' '.$row->engine->name;
				
				echo'<pre>';print_r($row->name);echo'</pre>';
				
				$this->memoryUsage(memory_get_usage(), $base_memory_usage);
				
				$i++;
				if($i > $max) break;
			}
			*/
			$i++;
			//if($i > $max) break;
			
			//echo'<pre>';print_r($row->name);echo'</pre>';
			//echo'<pre>-------------------</pre>';
			
			//if($i > $max) break;
		}
		
		//$this->memoryUsage(memory_get_usage(), $base_memory_usage);
		//4886376
		//4886056
		//4885336
		//echo'<pre>';print_r($rows);echo'</pre>';die;
		
		$result = CHtml::listData($rows, 'id','name');
		//echo'<pre>';print_r($result);echo'</pre>';die;
		return $result;
	}
	
	function memoryUsage($usage, $base_memory_usage) {
		echo'<pre>';printf("Bytes diff: %d\n", $usage - $base_memory_usage);echo'</pre>';
	}
	
	function someBigValue() {
		return str_repeat('SOME BIG STRING', 1024);
	}	
	
	public function getEnginesInfo($model_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT e.`id`, e.`name` FROM ".$this->tableName()." AS e INNER JOIN {{engines_models}} AS em ON e.id = em.engine_id  WHERE em.`model_id` = :model_id";
		$command = $connection->createCommand($sql);		
		$command->bindParam(":model_id", $model_id);
		
		//$rows = $command->queryAll();
		return $command->queryAll();
	}
	
	public function getEngineImage(&$connection, $engine_id)
	{
		$sql = "SELECT `image_file` FROM ".$this->tableName()." WHERE `id` = :engine_id";
		$command = $connection->createCommand($sql);		
		$command->bindParam(":engine_id", $engine_id);
		
		//$rows = $command->queryAll();
		return $command->queryScalar();
	}
	
	//получает выбранные модели
	function getSelectedModels()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->enginesModels);echo'</pre>';die;
		
		foreach($this->enginesModels as $row) {
			$selectedValues[$row['model_id']] = array( 'selected' => 'selected' );
		}
		$this->SelectedModels = $selectedValues;
	}
	
	//получает выбранные двигатели
	function getSelectedEngines()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->enginesModels);echo'</pre>';die;
		
		foreach($this->enginesModels as $row) {
			$selectedValues[$row['model_id']] = array( 'selected' => 'selected' );
		}
		$this->SelectedEngines = $selectedValues;
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
