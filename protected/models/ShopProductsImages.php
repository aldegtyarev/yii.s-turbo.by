<?php

/**
 * This is the model class for table "{{shop_products_images}}".
 *
 * The followings are the available columns in table '{{shop_products_images}}':
 * @property integer $image_id
 * @property string $product_id
 * @property string $image_file
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property ShopProducts $product
 */
class ShopProductsImages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_products_images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, image_file', 'required'),
			array('ordering', 'numerical', 'integerOnly'=>true),
			array('product_id', 'length', 'max'=>11),
			array('image_file', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('image_id, product_id, image_file, ordering, main_foto', 'safe', 'on'=>'search'),
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
			'image_id' => 'Image',
			'product_id' => 'Product',
			'image_file' => 'Image File',
			'ordering' => 'Ordering',
			'main_foto' => 'main_foto',
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

		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('image_file',$this->image_file,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('main_foto',$this->main_foto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductsImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	//удаление фото
	public function deleteFoto($id)
	{
		$app = Yii::app();
		$connection = $app->db;

		$sql = "SELECT * FROM {{shop_products_images}} WHERE `image_id` = :id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":id", $id);
		$row = $command->queryRow();
		//echo'<pre>';print_r($row);echo'</pre>';
		
		//$full_imagePath = Yii::getPathOfAlias($app->params->catalog_full_imagePath);
		//$tmb_imagePath = Yii::getPathOfAlias($app->params->catalog_tmb_imagePath);
		$product_imagePath = Yii::getPathOfAlias($app->params->product_imagePath);
		if (file_exists($product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$row['image_file'])) {
			unlink($product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$row['image_file']);
		}
		
		if (file_exists($product_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$row['image_file'])) {
			unlink($product_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$row['image_file']);
		}
		
		$sql = "DELETE FROM {{shop_products_images}} WHERE `image_id` = :id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":id", $id);
		$res = $command->execute();
	}
	
	public function setMainFoto(&$connection, $image_id, $product_id)
	{
		/*
		echo'<pre>';print_r($image_id);echo'</pre>';
		echo'<pre>';print_r($product_id);echo'</pre>';
		die;
		*/
		$sql = "UPDATE {{shop_products_images}} SET `main_foto` = 0 WHERE `product_id` = :product_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();
		
		$sql = "UPDATE {{shop_products_images}} SET `main_foto` = 1 WHERE `image_id` = :image_id AND `product_id` = :product_id";
		//$sql = "UPDATE {{shop_products_images}} SET `main_foto` = 1 WHERE `image_id` =$image_id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":image_id", $image_id);
		$command->bindParam(":product_id", $product_id);
		$res = $command->execute();
	}
	
	//получаем фото товаров для списка товаров категории
	public function getFotoForProductList(&$connection, $product_ids = array() )
	{
		if(count($product_ids))	{
			$sql = "SELECT `image_id`, `product_id`, `image_file` FROM ". $this->tableName()." WHERE `main_foto` = 0 AND `product_id` IN (".implode(',', $product_ids).") ORDER BY `product_id`, `ordering`";
			$command = $connection->createCommand($sql);
			//$command->bindParam(":product_id", $product_ids_str);
			$rows = $command->queryAll();
		}	else	{
			$rows = array();
		}
		//echo'<pre>';print_r($product_ids_str);echo'</pre>';
		return $rows;
	}
	
	
}
