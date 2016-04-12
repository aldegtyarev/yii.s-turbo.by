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

		'summ_usd',
		'summ_byr',
		'customer_info_ur_header',
		'name_ur',
		'address_ur',
		'unp',
		'okpo',
		'r_schet',
		'bank_name',
		'bank_address',
		'bank_code',
		'fio_director',
		'na_osnovanii',
		'doverennost_text',
		'svidetelstvo_text',
		'phone1_ur',

        'customer_info_header',
        'fio',
        'phone1',
        'phone2',
        'email',
        'comment',

        array(
            'name'=>'orderProducts',
            'type'=>'raw',
        ),
	),
)); ?>
