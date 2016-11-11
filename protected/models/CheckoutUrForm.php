<?php
/**
 * CheckoutForm class.
 */
class CheckoutUrForm extends CFormModel
{
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
	
	
	public $fio;
	public $phone1;
	public $phone2;	
	public $email;
	public $comment;
    public $post_code;

    public $positions;


    public function rules()
	{
		return array(
			array('name_ur, address_ur, unp, r_schet, bank_name, bank_address, bank_code, fio_director, na_osnovanii, phone1_ur, fio, phone1, email', 'required', 'message'=>'Укажите "{attribute}"'),
			
			array('doverennost_text', 'required', 'on'=>'na_osnovanii_doverennosti', 'message'=>'Укажите "{attribute}"'),
			array('svidetelstvo_text', 'required', 'on'=>'na_osnovanii_svidetelstva', 'message'=>'Укажите "{attribute}"'),
			
			array('name_ur, address_ur, unp, okpo, r_schet, bank_name, bank_code, fio_director, na_osnovanii, doverennost_text, svidetelstvo_text, phone1_ur, fio, phone1, phone2', 'length', 'max'=>255),
			
			array('email', 'email'),
			
			array('comment', 'length', 'max'=>1024),
            array('post_code', 'length', 'max'=>6),

            array('positions', 'required', 'message'=>'Ошибка формирования заказа. Попробуйте добавить товар еще раз.'),
            array('positions', 'numerical', 'integerOnly'=>true),

		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
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
			'fio'=>'Имя',
			'phone1'=>'Моб. телефон',
			'phone2'=>'Доп. телефон',
			'email'=>'E-mail',
			'comment'=>'Комментарий к заказу',
            'post_code'=>'Почтовый индекс <span class="required">*</span>',
			//''=>'',
		);
	}
	
	public function getNaOsnovaniiRadioList() {
		return array(
			1 => 'устава',
			2 => 'доверенности',
			3 => 'свидетельства (для ИП)',
		);
	}
}
