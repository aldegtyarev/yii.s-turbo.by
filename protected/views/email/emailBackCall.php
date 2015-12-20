<? /** @var dpsEmailController $this */
$this->setSubject('ЗАКАЗ ОБРАТНОГО ЗВОНКА'); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
//$params = $app->params;
?>
<div style="width:765px;">
	<p>Имя: <?= $model->name ?></p>
	<p>Телефон: <?= $model->phone ?></p>
	<p>Время звонка: <?= $model->time ?></p>
</div>