<?php
// виджет выводит блок "ВЫ НЕДАВНО ПРОСМАТРИВАЛИ"
class LastViewedProductsWidget extends CWidget {
    public function run() {
		
		
		$app = Yii::app();

		$shopProductsIds = isset($app->session['shopProducts.ids']) ? $app->session['shopProducts.ids'] : array() ;
		//echo'<pre>';print_r($shopProductsIds);echo'</pre>';//die;
		
		$shopProductsIds_m = array();
		
		if(!count($shopProductsIds))	{
			$product_ids = array(0);
		}	else	{
			foreach($shopProductsIds as $i) {
				$product_ids[] = $i['id'];
				$shopProductsIds_m[$i['id']] = $i;
			}
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->condition = 'product_id IN ('.implode(',', $product_ids).')';
		$criteria->order = 'FIELD(product_id, '.implode(',', $product_ids).')';

        $dataProvider = new CActiveDataProvider('ShopProducts', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$app->params['count_last_viewed_in_widget'],
				'pageVar' =>'page',
            ),
        ));
		
		if(count($dataProvider->data) == 0) return;
		$app->params->images_live_url;
		foreach($dataProvider->data as &$model)	{
			if($shopProductsIds_m[$model->product_id]['uni'] == 1) {
				$prod_params = array(
					'uni' => 'uni',
					'product'=> $model->product_id,
				);					
			}	else	{
				$prod_params = array(
					'marka' => $shopProductsIds_m[$model->product_id]['marka'],
					'model' => $shopProductsIds_m[$model->product_id]['model'],
					'year' => $shopProductsIds_m[$model->product_id]['year'],
					'year' => $shopProductsIds_m[$model->product_id]['year'],
					'product'=> $model->product_id,
				);
			}
			
			$model->product_url = $this->controller->createUrl('shopproducts/detail', $prod_params);
			$model->file_url_thumb = $model->product_image ? ($app->params['product_images_liveUrl'].'thumb_'.$model->product_image) : ($app->params->images_live_url.'noimage.jpg') ;
		}
		
		$currency_info = Currencies::model()->loadCurrenciesList();
		
		$data = array(
			'dataProvider' => $dataProvider,
			'currency_info' => $currency_info,
		);
		
		$this->render('LastViewedProductsWidget', $data);
    }
}
?>