<?php
// виджет выводит блок "ВЫ НЕДАВНО ПРОСМАТРИВАЛИ"
class LastViewedProductsWidget extends CWidget {
    public function run() {
		
		$app = Yii::app();

		$cs = $app->getClientScript();
		$cs->registerCoreScript('jcarousel-new-positions');
		
		$shopProductsIds = isset($app->session['shopProducts.ids']) ? $app->session['shopProducts.ids'] : array() ;
		//echo'<pre>';print_r($shopProductsIds);echo'</pre>';
		if(!count($shopProductsIds))	{
			$shopProductsIds = array(0);
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->condition = 'product_id IN ('.implode(',', $shopProductsIds).')';
		
		//$rows = ShopProducts::model()->getLastViewedProducts();
		
        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>3,
				'pageVar' =>'page',
            ),
        ));
		
		if(count($dataProvider->data) == 0) return;
		$app->params->images_live_url;
		foreach($dataProvider->data as &$model)	{
			$model->product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $model->product_id));
			$model->file_url_thumb = $model->product_image ? ($app->params['product_images_liveUrl'].'thumb_'.$model->product_image) : ($app->params->images_live_url.'noimage.jpg') ;
		}
		
		
		$data = array(
			//'rows' => $rows,
			'dataProvider' => $dataProvider,
			'shopProductsIds' => $shopProductsIds,
		);
		
		
		$this->render('LastViewedProductsWidget', $data);
    }
}
?>