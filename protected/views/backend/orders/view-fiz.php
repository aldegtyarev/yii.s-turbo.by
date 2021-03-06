<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Заказы'=>array('admin'),
	'Заказ №'.$model->id,
);

$this->menu=array(
	array('label'=>'Orders', 'url'=>array('admin')),
);
?>

<h1>Заказ №<?php echo $model->id; ?></h1>

<? //echo'<pre>';print_r($model->orderProducts);echo'</pre>';//die;?>
<? //echo $model->orderProducts;//die;?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'name'=>'created',
            'value'=>date("d.m.Y", $model->created),
        ),

		'customer_info_header',
		'fio',
		'town',
		'address1',
		'address2',
		'address3',
		'phone1',
		'phone2',
		'email',
		'comment',
        array(
            'name'=>'orderProducts',
            'type'=>'raw',
        ),

        array(
            'name'=>'summ_usd',
            'value'=>number_format($model->summ_usd, 2, '.', ' ') . ' $',
        ),

        array(
            'name'=>'summ_byr',
            'value'=>number_format($model->summ_byr, 0, '.', ' ') . ' руб',
        ),

        'deliveryName',
        'paymentName',

	),
)); ?>
