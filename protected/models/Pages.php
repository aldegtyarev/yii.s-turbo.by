<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $text
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 */
class Pages extends CActiveRecord
{
	const SCENARIO_UPLOADING_FOTO = 'uploading_foto';
	
	public $uploading_foto;
	
	private $_categoriesDropDownList;
	
	
	
//	public $typePage = array(
//		1=>'Статичная страница',
//		2=>'Новости магазина',
//		3=>'Наши работы',
//	);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pages}}';
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
			array('name, text', 'required'),
			array('name, alias, metatitle, metakey, metadesc', 'length', 'max'=>255),
			array('intro', 'length', 'max'=>2000),
			array('alias','ext.LocoTranslitFilter','translitAttribute'=>'name'), 
			array('type', 'numerical', 'integerOnly'=>true),
			array('id, name, alias, text, meta_title, meta_keywords, meta_description', 'safe', 'on'=>'search'),
			array('uploading_foto', 'file', 'types'=>'GIF,JPG,JPEG,PNG', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб', 'tooSmall' => 'Не формат', 'on'=>self::SCENARIO_UPLOADING_FOTO),
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
			'name' => 'Заголовок',
			'alias' => 'Alias',
			'intro' => 'Анонс',
			'text' => 'Текст',
			'type' => 'Рубрика',
			'metatitle' => 'Meta Title',
			'metakey' => 'Meta Keywords',
			'metadesc' => 'Meta Description',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		
		$criteria->compare('text',$this->text,true);
		$criteria->compare('metatitle',$this->metatitle,true);
		$criteria->compare('metakey',$this->metakey,true);
		$criteria->compare('metadesc',$this->metadesc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
				'pageSize' => Yii::app()->params->pagination['products_per_page'],
			),		
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function findByAlias($alias)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = "`alias` = '$alias'";
		$model = $this->find($criteria);
		return $model;
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
	
	public function getCategoriesDropDownList()
	{
		$rows = PagesCategories::model()->findAll();
		return CHtml::listData($rows, 'id','name');
	}
	
	public function removeFoto()
	{
		$app = Yii::app();
		$pages_imagePath = Yii::getPathOfAlias($app->params->pages_imagePath);
		
		$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
		if(file_exists($file_path)) unlink($file_path);
		
		$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename;
		if(file_exists($file_path)) unlink($file_path);
		$this->foto = '';
	}
	
    /**
     * возвращает список страниц заданной рубрики
     *
     * @param int $category_id
     * @return CActiveDataProvider
     */
	public function loadPages($category_id = 1)
	{
		$app = Yii::app();
		$criteria = new CDbCriteria();

		$condition_arr = array(
			'type = '.$category_id,
		);

		$criteria->condition = implode(' AND ', $condition_arr);
		$criteria->order = 'created DESC';
		
        $dataProvider = new CActiveDataProvider('Pages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
				'pageSize'=>Yii::app()->params->pagination['products_per_page'],
				//'pageSize'=>3,
				'pageVar' =>'page',
            ),
        ));
		
		foreach($dataProvider->data as $row)	{
			$row->foto = $app->params->pages_images_liveUrl.($row->foto ? 'thumb_'.$row->foto : 'noimage.jpg');
		}
		
		return $dataProvider;
	}
	
	
    /**
     * загрузка фото
     *
     * @param int $no_watermark
     */
	public function uploadFoto($no_watermark = 0)
	{
		$app = Yii::app();
		if($this->uploading_foto != null)	{
			$pages_imagePath = Yii::getPathOfAlias($app->params->pages_imagePath);

			$file_extention = $this->getExtentionFromFileName($this->uploading_foto->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
			
			$this->uploading_foto->saveAs($file_path);

			
			$img_width_config = $app->params->page_tmb_params['width'];
			$img_height_config = $app->params->page_tmb_params['height'];
			
			if($no_watermark == 0)	{
				if($file_extention == '.jpg' || $file_extention == '.jpeg'){
					$img = imagecreatefromjpeg($file_path);
				} elseif($file_extention == '.png'){
					$img = imagecreatefrompng($file_path);
				} elseif($file_extention == '.gif') {
					$img = imagecreatefromgif($file_path);
				}

				$water = imagecreatefrompng(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");
				$im = $this->create_watermark($img, $water);
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
			
			$connection = $app->db;
			$this->setFoto($connection, $filename, $this->id);
		}
	}
	
	
	//сохранение имени файла фото для страницы
	public function setFoto(&$connection, $filename, $id)
	{
		$sql = "UPDATE ".$this->tableName()." SET `foto` = :foto WHERE `id` = :id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":id", $id);
		$command->bindParam(":foto", $filename);
		$res = $command->execute();		
	}
	
	/**
	 * возвращает текст материала с заданным id
	 *
	 * @param $id integer
	 * @return string
	 */
	public function getPageText($id = 0)
	{
		$connection = Yii::app()->db;
		$sql = "SELECT `text` FROM ".$this->tableName()." WHERE `id` = :id";
		$command = $connection->createCommand($sql);		
		$command->bindParam(":id", $id);
		return $command->queryScalar();
	}
	
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
	public function create_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 )
	{
		$alpha_level	/= 100;	# convert 0-100 (%) alpha to decimal

		# calculate our images dimensions
		$main_img_obj_w	= imagesx( $main_img_obj );
		$main_img_obj_h	= imagesy( $main_img_obj );
		$watermark_img_obj_w	= imagesx( $watermark_img_obj );
		$watermark_img_obj_h	= imagesy( $watermark_img_obj );
 
		# determine center position coordinates
		$main_img_obj_min_x	= floor( ( $main_img_obj_w / 2 ) - ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_max_x	= ceil( ( $main_img_obj_w / 2 ) + ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_min_y	= floor( ( $main_img_obj_h / 2 ) - ( $watermark_img_obj_h / 2 ) );
		$main_img_obj_max_y	= ceil( ( $main_img_obj_h / 2 ) + ( $watermark_img_obj_h / 2 ) ); 
		
		/*
		$main_img_obj_min_x_top_left = 0;		
		$main_img_obj_min_y_top_left = 0;
		
		$main_img_obj_min_x_bottom_right	= floor( ( $main_img_obj_w  ) - ( $watermark_img_obj_w  ) );
		$main_img_obj_min_y_bottom_right	= floor( ( $main_img_obj_h  ) - ( $watermark_img_obj_h  ) );
		*/

		# create new image to hold merged changes
		$return_img	= imagecreatetruecolor( $main_img_obj_w, $main_img_obj_h );
 
		# walk through main image
		for( $y = 0; $y < $main_img_obj_h; $y++ ) {
			for( $x = 0; $x < $main_img_obj_w; $x++ ) {
				$return_color	= NULL;
 
				# determine the correct pixel location within our watermark
				$watermark_x	= $x - $main_img_obj_min_x;
				$watermark_y	= $y - $main_img_obj_min_y;
 
				$watermark_x_top_left	= $x - $main_img_obj_min_x_top_left;
				$watermark_y_top_left	= $y - $main_img_obj_min_y_top_left;
 
				$watermark_x_bottom_right	= $x - $main_img_obj_min_x_bottom_right;
				$watermark_y_bottom_right	= $y - $main_img_obj_min_y_bottom_right;
 
				# fetch color information for both of our images
				$main_rgb = imagecolorsforindex( $main_img_obj, imagecolorat( $main_img_obj, $x, $y ) );
 
				# if our watermark has a non-transparent value at this pixel intersection
				# and we're still within the bounds of the watermark image
				if (
						($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h ) //||
						//($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h ) ||
						//($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )
					) {
					
					if($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x, $watermark_y ) );
					}/*	elseif	($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_top_left, $watermark_y_top_left ) );
					}	elseif($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_bottom_right, $watermark_y_bottom_right ) );
					}*/
 
					# using image alpha, and user specified alpha, calculate average
					$watermark_alpha	= round( ( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2 );
					$watermark_alpha	= $watermark_alpha * $alpha_level;
 
					# calculate the color 'average' between the two - taking into account the specified alpha level
					$avg_red		= $this->_get_ave_color( $main_rgb['red'],		$watermark_rbg['red'],		$watermark_alpha );
					$avg_green	= $this->_get_ave_color( $main_rgb['green'],	$watermark_rbg['green'],	$watermark_alpha );
					$avg_blue		= $this->_get_ave_color( $main_rgb['blue'],	$watermark_rbg['blue'],		$watermark_alpha );
 
					# calculate a color index value using the average RGB values we've determined
					$return_color	= $this->_get_image_color( $return_img, $avg_red, $avg_green, $avg_blue );
 
				# if we're not dealing with an average color here, then let's just copy over the main color
				} else {
					$return_color	= imagecolorat( $main_img_obj, $x, $y );
 
				} # END if watermark

				# draw the appropriate color onto the return image
				imagesetpixel( $return_img, $x, $y, $return_color );
 
			} # END for each X pixel
		} # END for each Y pixel
		

		# return the resulting, watermarked image for display
		return $return_img;
 
	} # END create_watermark()

	# average two colors given an alpha
    public function _get_ave_color( $color_a, $color_b, $alpha_level ) {
		return round( ( ( $color_a * ( 1 - $alpha_level ) ) + ( $color_b	* $alpha_level ) ) );
	} # END _get_ave_color()

	# return closest pallette-color match for RGB values
    public function _get_image_color($im, $r, $g, $b) {
		$c=imagecolorexact($im, $r, $g, $b);
		if ($c!=-1) return $c;
		$c=imagecolorallocate($im, $r, $g, $b);
		if ($c!=-1) return $c;
		return imagecolorclosest($im, $r, $g, $b);
	} # EBD _get_image_color()
	
    /**
     * возвращает ссылки на все материалы по сайту
     *
     * @param $controller
     * @param $connection
     * @return array
     */
	public function getAllUrlsForSitemap(&$controller, &$connection)
	{
		$urls = array();
		$homeUrl = substr(Yii::app()->homeUrl, 0, -1);
		
		$categories = PagesCategories::model()->findAll();
		
		$sql = "SELECT `id`, `alias` FROM ".$this->tableName()." WHERE `type` = :type";
		$commandModels = $connection->createCommand($sql);
		
		//echo'<pre>';print_r($categories);echo'</pre>';die;
		
		foreach($categories as $cat) {
			if($cat->id != 1) {
				$commandModels->bindParam(":type", $cat->id);
				$url_path = $cat->alias;
				$pages = $commandModels->queryAll();
				foreach($pages as $p) {
					$urls[] = $homeUrl . $controller->createUrl('pages/'.$url_path, array('alias'=>$p['alias']));
				}
			}
		}
		
		$urls[] = $homeUrl . $controller->createUrl('pages/dostavka');
		$urls[] = $homeUrl . $controller->createUrl('pages/oplata');
		$urls[] = $homeUrl . $controller->createUrl('pages/kontakty');
		$urls[] = $homeUrl . $controller->createUrl('pages/onas');
		
		//echo'<pre>';print_r($urls);echo'</pre>';die;
		
		return $urls;
	}
	
}
