<?php
// виджет выводит блок "НОВЫЕ ПОСТУПЛЕНИЯ"
class NewProductsWidget extends CWidget {
    public function run() {
		
		$app = Yii::app();
		$connection = $app->db;

		$cs = $app->getClientScript();
		$cs->registerCoreScript('jcarousel-new-positions');
		
		$rows = ShopProducts::model()->getLastAddedProducts();
		//echo'<pre>';print_r($rows);echo'</pre>';
		$product_ids = ShopProducts::model()->getProductIds($rows);
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->condition = "t.`published` = 1";
		$criteria->order = "t.`product_id` DESC";
		$criteria->limit = 7;


        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>7,
				'pageVar' =>'page',
            ),
        ));
		
		$product_ids = ShopProducts::model()->getProductIds($dataProvider->data);
		
		

		$firms = ShopFirms::model()->getFirmsForProductList($connection, $product_ids);
		//echo'<pre>';print_r($firms);echo'</pre>';
		
		foreach($dataProvider->data as $row)	{
			$product_ids[] = $row->product_id;
			$row->product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id));
			$row->product_image = $app->params->product_images_liveUrl.($row->product_image ? 'thumb_'.$row->product_image : 'noimage.jpg');
			$row->firm_name = $firms[$row->firm_id]['name'];
			//$row->product_availability_str = $firms[$row->firm_id]['name'];
		}
		
		
		$data = array(
			'rows' => $rows,
			'firms' => $firms,
			'dataProvider' => $dataProvider,
		);
		
		
		$this->render('NewProductsWidget', $data);
    }
}
?>