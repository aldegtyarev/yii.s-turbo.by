<?php

/**
 * This is the model class for table "{{shop_firms}}".
 *
 * The followings are the available columns in table '{{shop_firms}}':
 * @property integer $firm_id
 * @property integer $category_id
 * @property string $firm_name
 * @property string $alias
 * @property string $firm_description
 * @property string $firm_logo
 * @property string $url
 *
 * The followings are the available model relations:
 * @property ShopProducts[] $shopProducts
 */
class ShopFirms extends CActiveRecord
{
    const SCENARIO_UPLOADING_FOTO = 'uploading_foto';

    public $uploading_foto;

    private $_categoriesList;


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_firms}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firm_name, category_id', 'required'),
			array('firm_name, firm_logo', 'length', 'max'=>255),
			array('url', 'length', 'max'=>1024),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('firm_description', 'length', 'max'=>20480),
            array('alias','ext.LocoTranslitFilter','translitAttribute'=>'firm_name'),
            array('uploading_foto', 'file', 'types'=>'GIF,JPG,JPEG,PNG', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб', 'tooSmall' => 'Не формат', 'on'=>self::SCENARIO_UPLOADING_FOTO),
			array('firm_id, firm_name, firm_description, firm_logo', 'safe', 'on'=>'search'),
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
			'shopProducts' => array(self::HAS_MANY, 'ShopProducts', 'firm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'firm_id' => 'id',
			'firm_name' => 'Название',
			'category_id' => 'Группа',
			'alias' => 'Псевдоним',
			'firm_description' => 'Описание',
			'firm_logo' => 'Лого',
			'url' => 'Ссылка на сайт',
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

		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('firm_name',$this->firm_name,true);
		$criteria->compare('firm_description',$this->firm_description,true);
		$criteria->compare('firm_logo',$this->firm_logo,true);
		
		$criteria->condition = 't.firm_id > 0';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopFirms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave()
    {
        $app = Yii::app();
        //если нужно - загружаем и обрабатываем фото
        $no_watermark = $app->request->getParam('no_watermark', 0);
        //echo'<pre>';print_r($no_watermark);echo'</pre>';die;
        $this->uploadFoto($no_watermark);
        parent::afterSave();
    }

	
	public function getDropDownlistFirms()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.firm_id';
		$rows = $this->findAll($criteria);
		return CHtml::listData($rows, 'firm_id','firm_name');
	}
	
	//получаем фирмы  для списка товаров категории
	public function getFirmsForProductList(&$connection, $product_ids = array() )
	{
		if(count($product_ids))	{
			$sql = "
SELECT pr.`firm_id` AS id, f.`firm_name` AS name, count(pr.`product_id`)  AS count
FROM `3hnspc_shop_products` AS pr INNER JOIN `3hnspc_shop_firms` AS f USING(`firm_id`)
WHERE pr.`product_id` IN (".implode(',', $product_ids).")
GROUP BY pr.`firm_id`
			
			";
			$command = $connection->createCommand($sql);
			//$command->bindParam(":product_id", $product_ids_str);
			$rows_ = $command->queryAll();
			$rows = array();
			foreach($rows_ as $row)	{
				$rows[$row['id']] = $row;
			}
		}	else	{
			$rows = array();
		}
		//echo'<pre>';print_r($product_ids_str);echo'</pre>';
		//echo'<pre>';print_r($rows);echo'</pre>';
		
		return $rows;
	}

    /**
     * загрузка фото
     *
     * @param int $no_watermark
     */
    public function uploadFoto($no_watermark = 0)
    {
        if($this->uploading_foto != null)	{
            $app = Yii::app();

            $pages_imagePath = Yii::getPathOfAlias($app->params->brands_imagePath);

            $file_extention = FilesHelper::getExtentionFromFileName($this->uploading_foto->name);

//            $filename = md5(strtotime('now')).$file_extention;
            $filename = $this->alias . $file_extention;

//            $file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
            $file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;

            $this->uploading_foto->saveAs($file_path);

            $img_width_config = $app->params->category_tmb_params['width'];
            $img_height_config = $app->params->category_tmb_params['height'];

            if($no_watermark == 0)	{
                if($file_extention == '.jpg' || $file_extention == '.jpeg'){
                    $img = imagecreatefromjpeg($file_path);
                } elseif($file_extention == '.png'){
                    $img = imagecreatefrompng($file_path);
                } elseif($file_extention == '.gif') {
                    $img = imagecreatefromgif($file_path);
                }

                $water = imagecreatefrompng(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");
                $im = FilesHelper::create_watermark($img, $water);
                imagejpeg($im, $file_path);
            }

            $Image = $app->image->load($file_path);

            if(($Image->width/$Image->height) >= ($img_width_config/$img_height_config)){
                $Image -> resize($img_width_config, $img_height_config, Image::HEIGHT);
            }	else	{
                $Image -> resize($img_width_config, $img_height_config, Image::WIDTH);
            }
            //$Image->crop($img_width_config, $img_height_config, 'top', 'center')->quality(75);
            $Image->resize($img_width_config, $img_height_config)->quality(100);
            //echo'<pre>';print_r($filename);echo'</pre>';//die;
            //echo'<pre>';print_r($this->id);echo'</pre>';die;
            $Image->save($pages_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename);

            //удалям большое фото. оно нам не нужно.
//            unlink($pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename);

            $connection = $app->db;
            FilesHelper::setFoto($connection, $filename, $this->firm_id, $this->tableName(), 'firm_logo', 'firm_id');
        }
    }

    public function removeFoto()
    {
        FilesHelper::removeFoto(Yii::app()->params->brands_imagePath);
        $this->firm_logo = '';
    }

    public function getCategoriesList()
    {
        if(is_null($this->_categoriesList)) {
            $this->_categoriesList = ShopFirmsCategory::model()->getCategoriesList();
        } else {

        }

        return $this->_categoriesList;
    }

    public function findByAlias($alias)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "`alias` = '$alias'";
        $model = $this->find($criteria);
        return $model;
    }

}
