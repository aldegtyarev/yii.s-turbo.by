<?php
/**
 * CheckoutForm class.
 */
class CheckoutFizForm extends CFormModel
{
	public $fio;
	public $town;
	public $address;
	public $phone1;
	public $phone2;
	public $email;
	public $comment;


	public function rules()
	{
		return array(
			array('fio, town, address, phone1', 'required', 'message'=>'Укажите "{attribute}"'),
			array('fio, town, address, phone1, phone2', 'length', 'max'=>255),
			array('email', 'email'),
			array('comment', 'length', 'max'=>1024),

		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fio'=>'Фамилия, Имя',
			'town'=>'Город / населенный пункт',
			'address'=>'Адрес',
			'phone1'=>'Моб. телефон',
			'phone2'=>'Доп. телефон',
			'email'=>'E-mail',
			'comment'=>'Комментарий к заказу',
		);
	}
}
