<?php

/**
 * This is the model class for table "{{delivery}}".
 *
 * The followings are the available columns in table '{{delivery}}':
 * @property integer $id
 * @property integer $name
 * @property string $options
 */
class Delivery extends CActiveRecord
{
	const DELIVERY_SMALL_CARGOES_ID = 1;
	const DELIVERY_MEDIUM_CARGOES_ID = 2;
	const DELIVERY_LARGE_CARGOES_ID = 3;
	
	const DELIVERY_SMALL_CARGOES_LBL = 'мелкогабаритный груз';
	const DELIVERY_MEDIUM_CARGOES_LBL = 'среднегабаритный груз';
	const DELIVERY_LARGE_CARGOES_LBL = 'крупногабаритный груз';
	
	private $_cargoTypesList;
	
	public $params;
	
	public $delivery_normal;
	public $delivery_quick;
	public $delivery_free;
	public $delivery_no;
	
	public $delivery_normal_lbl;
	public $delivery_quick_lbl;
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{delivery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, options', 'required'),
			array('name, ico', 'length', 'max'=>2048),
			//array('name', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, options', 'safe', 'on'=>'search'),
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
			'name' => 'Название',
			'ico' => 'Иконка при оформлении заказа',
			'options' => 'Options',
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
		$criteria->compare('name',$this->name);
		$criteria->compare('options',$this->options,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Delivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCargoTypesList()
	{
		return array(
			self::DELIVERY_SMALL_CARGOES_ID => self::DELIVERY_SMALL_CARGOES_LBL,
			self::DELIVERY_MEDIUM_CARGOES_ID => self::DELIVERY_MEDIUM_CARGOES_LBL,
			self::DELIVERY_LARGE_CARGOES_ID => self::DELIVERY_LARGE_CARGOES_LBL,
		);
	}
	
	/**
	 * получает список видов доставки и подготавливает параметры для работы
	 */
	public function loadDeliveryList()
	{
		$rows = $this->findAll();
		
		foreach($rows as &$row)
			$row->params = json_decode($row->options, true);
		
		return $rows;
	}
	
	/**
	 * получает вид доставки и подготавливает параметры для работы
	 */
	public function loadDelivery($id)
	{
		$row = $this->findByPk($id);
		
		$row->params = json_decode($row->options, true);
		
		return $row;
	}
	
	/**
	 * получает список видов доставки и рассчитывает стоимости в зависимости от товаров в корзине
	 */
	public function loadCalculatedDeliveryList($positions, $currency_info, $for_product = false)
	{
		$rows = $this->loadDeliveryList();
		
		$qty_for_delivery = 0;
		
		if($for_product === true) {
			$total_summ = $positions[0]->product_price;
			$price = PriceHelper::getPricePosition($positions[0]);
			$total_summ = PriceHelper::formatPrice($price, $positions[0]->currency_id, 3, $currency_info, true, true);
			$qty_for_delivery = 1;
		}	else	{
			$total_in_cart = PriceHelper::calculateTotalInCart($positions, $currency_info);
			//$total_summ = $total_in_cart['summ'];
			$total_summ = $total_in_cart['summ_for_delivery'];
			$qty_for_delivery = $total_in_cart['qtyTotal_for_delivery'];
			//echo'<pre>';print_r($total_in_cart);echo'</pre>';//die;
		}
		
		//echo'<pre>';print_r($total_summ);echo'</pre>';//die;
		//echo'<pre>';print_r($qty_for_delivery);echo'</pre>';//die;
		
		foreach($rows as &$row) 
			$row = $this->calculateDelivery($row, $positions, $currency_info, $total_summ, $qty_for_delivery);
		
		//die;
		return $rows;
	}
	
	/**
	 * рассчитывает стоимости в зависимости от товаров в корзине
	 */
	public function calculateDelivery($row, $positions, $currency_info, $total_summ, $count_positions_for_delivery = 0)
	{
		$row->delivery_free = false;
		//echo'<pre>';print_r($row);echo'</pre>';//die;

		//проверяем на бесплатность доставки по сумме в корзине
		if($total_summ >= $row->params['free'] || $total_summ == 0) $row->delivery_free = true;

		//рассчитаем стомость доставки в зависимости от габаритов товаров
		if($count_positions_for_delivery > 0) $count_positions = $count_positions_for_delivery;
			else $count_positions = count($positions);

		if($count_positions <= 2)	{
			$index = 'units_qty12';
			$index_quick = 'units_qty12_q';
		}	else	{
			$index = 'units_qty3';
			$index_quick = 'units_qty3_q';
		}

		$max_delivery_price = 0;
		$max_delivery_price_q = 0;
		$row->delivery_no = false;
		foreach($positions as $position) {
			
				if($row->params[$index][$position->cargo_type] == '-') {
					$row->delivery_no = true;
				}	elseif($row->params[$index][$position->cargo_type] > $max_delivery_price)	{
					if($position->free_delivery == 0) {
						$max_delivery_price = $row->params[$index][$position->cargo_type];
					}
				}	elseif($row->params[$index][$position->cargo_type] == 0)	{
					$row->delivery_free = true;
				}

				if($row->params[$index_quick][$position->cargo_type] == '-') {
					$row->delivery_no = true;
				}	elseif((int)$row->params[$index_quick][$position->cargo_type] > $max_delivery_price)	{
					if($position->free_delivery == 0) {
						$max_delivery_price_q = $row->params[$index_quick][$position->cargo_type];
					}
				}	elseif((int)$row->params[$index_quick][$position->cargo_type] == 0 && $row->params[$index_quick][$position->cargo_type] != '')	{
					//echo'<pre>';var_dump($row->params[$index_quick][$position->cargo_type]);echo'</pre>';die;
					$row->delivery_free = true;
				}
			
			//echo'<pre>';var_dump($row->delivery_free);echo'</pre>';die;
		}

		$row->delivery_normal = $max_delivery_price;
		$row->delivery_quick = $max_delivery_price_q;
		$row->delivery_normal_lbl = $row->params['delivery_normal_lbl'];
		$row->delivery_quick_lbl = $row->params['delivery_quick_lbl'];
		
//		echo'<pre>';var_dump($row->delivery_no);echo'</pre>';//die;
//		echo'<pre>';print_r($row->delivery_quick);echo'</pre>';//die;
		
		return $row;
	}
	
	/**
	 * возвращает название доставки
	 */
	public function getDeliveryNameForEmail($id, $is_quick)
	{
		$row = $this->findByPk($id);
		
		$row->params = json_decode($row->options, true);
		
		$res = $row->name;
		if($is_quick == 1) $res .= ' (ускоренная)';
		
		return $res;
	}
	
	/**
	 * возвращает название доставки
	 */
	public function getFreeDeliveryLimit()
	{
		$rows = $this->findAll();
		if(count($rows) > 0) {
			$options = json_decode($rows[0]->options, true);
			if(isset($options['free'])) $res = $options['free'];
				else $res = 0;
		}	else {
			$res = 0;
		}
		
		return $res;
	}
	
}
