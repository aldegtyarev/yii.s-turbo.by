<?php

/**
 * ShopProductTypeRelationForm class.
 */
class ShopProductTypeRelationForm extends CFormModel
{
	public $type_id;
	public $name;
	public $type_related_id;
	public $category_id;
	public $model_ids = array();

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('name', 'length', 'max'=>255),
			array('type_id, type_related_id, category_id', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'type_related_id'=>'Группа товаров',
			'model_ids'=>'Список моделей',
			'name' => 'Текст ссылки',
			'category_id' => 'Категория',
		);
	}
}
