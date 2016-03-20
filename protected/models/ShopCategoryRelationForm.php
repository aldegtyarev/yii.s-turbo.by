<?php

/**
 * ShopCategoryRelationForm class.
 */
class ShopCategoryRelationForm extends CFormModel
{
	public $category_id;
	public $category_related_id;
	public $model_ids = array();
	public $name;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('name', 'length', 'max'=>255),
			array('category_id, category_related_id', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'category_related_id'=>'Категория',
			'model_ids'=>'Список моделей',
			'name' => 'Текст ссылки',
		);
	}
}
