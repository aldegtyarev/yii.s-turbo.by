<?php

class ProductCommentsForm extends ProductComments
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, name, email, comment', 'required'),
			array('product_id, marka, model, year', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('email', 'length', 'max'=>256),
			array('email', 'email'),
			array('product_url', 'length', 'max'=>512),
			array('comment', 'length', 'max'=>2048),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Товар',
			'name' => 'Имя',
			'email' => 'Email',
			'comment' => 'Ваш вопрос',
			'answer' => 'Ответ администрации',
		);
	}

    protected function beforeSave()
    {
        $app = Yii::app();

        if(parent::beforeSave())	{
            $url_params = UrlHelper::getSelectedAuto($app);	//это то что храниться в сессии

            $is_universal_product = ShopProductsModelsAuto::model()->isUniversalroduct($this->product_id);
            if($is_universal_product == 1) {
                $prod_params = array(
                    'uni' => 'uni',
                    'product'=> $this->product_id
                );
            }	else	{
                $prod_params = array(
                    'marka' => $url_params['marka'],
                    'model' => $url_params['model'],
                    'year' => $url_params['year'],
                    'product'=> $this->product_id
                );
            }

            $this->marka = $url_params['marka'];
            $this->model = $url_params['model'];
            $this->year = $url_params['year'];

            $this->product_url = Yii::app()->createUrl('shopproducts/detail', $prod_params);
            return true;
        }
    }

    protected function afterSave()
    {
        parent::afterSave();

        $to = array(Yii::app()->params['adminEmail']);

        $data = array('model' => $this);

        Yii::app()->dpsMailer->sendByView(
            $to, // определяем кому отправляется письмо
//            array('aldegtyarev@yandex.ru'), // определяем кому отправляется письмо
            'emailNewQuestion', // view шаблона письма
            $data
        );
    }






}
