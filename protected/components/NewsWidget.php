<?php
// виджет выводит блок "НОВЫЕ ПОСТУПЛЕНИЯ"
class NewsWidget extends CWidget {
	
	public $type = 2;
	
	public $block_title = array(
		2 => 'Новости магазина',
		3 => 'Наши работы',
	);
	
	public $url_path = array(
		2 => 'news',
		3 => 'our',
	);
	
	public $url_title = array(
		2 => 'Все новости магазина',
		3 => 'Все наши работы',
	);
	
	
    public function run() {
		
		$app = Yii::app();
		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*";
		$criteria->condition = "t.`type` = ".$this->type;
		$criteria->order = "t.`created` DESC";
		$criteria->limit = 7;

        $dataProvider = new CActiveDataProvider('Pages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>7,
				'pageVar' =>'page',
            ),
        ));
		
		foreach($dataProvider->data as &$row)	{
			//$row->page_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id));
			$row->foto = $app->params->pages_images_liveUrl.($row->foto ? 'thumb_'.$row->foto : 'noimage.jpg');
		}
		
		
		$data = array(
			'block_title' => $this->block_title[$this->type],
			'url_path' => $this->url_path[$this->type],
			'url_title' => $this->url_title[$this->type],
			'dataProvider' => $dataProvider,
		);
		
		
		$this->render('NewsWidget', $data);
    }
}
?>