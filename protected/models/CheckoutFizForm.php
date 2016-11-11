<?php
/**
 * CheckoutForm class.
 */
class CheckoutFizForm extends CFormModel
{
    const DELIVERY_BY_POST = 'delivery_by_post';

	public $fio;
	public $town;
	public $address1;
	public $address2;
	public $address3;
	public $phone1;
	public $phone2;
	public $email;
	public $comment;
	public $post_code;
	public $positions;


	public function rules()
	{
		return array(
			array('fio, town, address1, address2, phone1', 'required', 'message'=>'Укажите "{attribute}"'),
			array('fio, town, address1, address2, address3, phone1, phone2', 'length', 'max'=>255),
			array('positions', 'required', 'message'=>'Ошибка формирования заказа. Попробуйте добавить товар еще раз.'),
            array('positions', 'numerical', 'integerOnly'=>true),
			array('email', 'email'),
//			array('post_code', 'required', 'message'=>'Укажите "{attribute}"', 'on'=>'delivery_by_post'),
			array('post_code', 'length', 'max'=>6),
			array('comment', 'length', 'max'=>1024),

		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fio'=>'Фамилия, Имя, Отчество',
			'town'=>'Город / населенный пункт',
			'address1'=>'Улица',
			'address2'=>'Дом',
			'address3'=>'Квартира',
			'phone1'=>'Моб. телефон',
			'phone2'=>'Доп. телефон',
			'email'=>'E-mail',
			'comment'=>'Комментарий к заказу',
            'post_code'=>'Почтовый индекс <span class="required">*</span>',
		);
	}
}
