<?php
/**
 * CheckoutForm class.
 */
class CheckoutForm extends CFormModel
{
	public $region;
	public $town;
	public $post_index;
	public $address;
	public $fio;
	public $phone;
	public $email;
	public $comment;


	public function rules()
	{
		return array(
			array('region, town, post_index, address, fio, phone, email', 'required'),
			array('region, town, post_index, address, fio, phone', 'length', 'max'=>255),
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
			'region'=>'Область',
			'town'=>'Город',
			'post_index'=>'Индекс',
			'address'=>'Улица, дом',
			'fio'=>'ФИО',
			'phone'=>'Телефон',
			'email'=>'e-mail',
			'comment'=>'Комментарий к заказу',
		);
	}
}
