<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Ошибка '.$code;
$this->breadcrumbs=array(
	'Ошибка '.$code,
);
?>

<?/*<h2>Error <?php echo $code; ?></h2>*/?>

<?/*
<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
*/?>


<div class="page-cnt">
	<h1>Уважаемые клиенты!</h1>
	<div class="page-body clearfix">
		<p>Вы сейчас находитесь на нашем новом сайте. Если здесь Вы не нашли нужную деталь, зайдите на наш другой сайт<br><a href="http://old.s-turbo.by" rel="nofollow">OLD.S-TURBO.BY</a></p>
	</div>
</div>