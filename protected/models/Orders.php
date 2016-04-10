<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property integer $id
 * @property integer $created
 * @property string $summ_usd
 * @property string $summ_byr
 * @property string $delivery_id
 * @property string $delivery_quick
 * @property string $payment_id
 * @property string $customer
 *
 * The followings are the available model relations:
 * @property OrdersProducts[] $ordersProducts
 */
class Orders extends CActiveRecord
{
	const CUSTOMER_TYPE_FIZ = 1;
	const CUSTOMER_TYPE_UR = 2;

    public $customer_info;

    public $type;


    public $fio;
    public $town;
    public $address1;
    public $address2;
    public $address3;
    public $phone1;
    public $phone2;
    public $email;
    public $comment;

    private $_deliveryName;

    // юр.лицо
    public $name_ur;
    public $address_ur;
    public $unp;
    public $okpo;
    public $r_schet;
    public $bank_name;
    public $bank_address;
    public $bank_code;
    public $fio_director;
    public $na_osnovanii;
    public $doverennost_text;
    public $svidetelstvo_text;
    public $phone1_ur;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created, summ_usd, summ_byr, customer', 'required'),
			array('created', 'numerical', 'integerOnly'=>true),
			array('summ_usd, summ_byr', 'length', 'max'=>10),
			array('customer', 'length', 'max'=>10000),
			// The following rule is used by search().
			array('id, created, summ_usd, summ_byr, customer', 'safe', 'on'=>'search'),
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
			'ordersProducts' => array(self::HAS_MANY, 'OrdersProducts', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created' => 'Created',
			'summ_usd' => 'Summ USD',
			'summ_byr' => 'Summ BYR',
			'customer' => 'Customer',

            'name_ur'=>'Название организации',
            'address_ur'=>'Юридический адрес',
            'unp'=>'УНП',
            'okpo'=>'ОКПО',
            'r_schet'=>'Расчетный счет',
            'bank_name'=>'Название банка',
            'bank_address'=>'Адрес банка',
            'bank_code'=>'Код банка',
            'fio_director'=>'ФИО руководителя',
            'na_osnovanii'=>'Работает на основании',
            'doverennost_text'=>'№, от даты, кому выдана и пр.',
            'svidetelstvo_text'=>'когда и кем выдано',
            'phone1_ur'=>'Телефон / факс',

            'fio'=>'Фамилия, Имя',
            'town'=>'Город / населенный пункт',
            'address1'=>'Улица',
            'address2'=>'Дом',
            'address3'=>'Квартира',
            'phone1'=>'Моб. телефон',
            'phone2'=>'Доп. телефон',
            'email'=>'E-mail',
            'comment'=>'Комментарий к заказу',


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

        $sort = new CSort();
        $sort->defaultOrder = '`id` DESC'; // устанавливаем сортировку по умолчанию

		$criteria->compare('id',$this->id);
		$criteria->compare('created',$this->created);
		$criteria->compare('summ_usd',$this->summ_usd,true);
		$criteria->compare('summ_byr',$this->summ_byr,true);
		$criteria->compare('customer',$this->customer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * загружает информацию о пакупателе
     */
    public function loadCustomerInfo()
    {
        $customer_info = json_decode($this->customer, 1);
        foreach ($customer_info as $fld=>$item) {
            $this->$fld = $item;
        }
        
    }
}
