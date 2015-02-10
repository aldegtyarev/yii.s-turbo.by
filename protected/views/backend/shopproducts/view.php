<?php
/* @var $this ShopProductsController */
/* @var $model ShopProducts */

$this->breadcrumbs = $breadcrumbs;
/*
$this->breadcrumbs=array(
	'Shop Products'=>array('index'),
	$model->product_id,
);
*/

$app = Yii::app();
$baseUrl = $app->getBaseUrl(true).'/';

//echo'<pre>';print_r($baseUrl);echo'</pre>';
//echo'<pre>';print_r($model->shopProductsMediases);echo'</pre>';
//echo'<pre>';print_r($model->shopProductPrices);echo'</pre>';
?>


<div class="productdetails-view">
	<div class="head clearfix">
		<div class="w600 floatleft">
			<?if (!empty($model->shopProductsMediases[0])) {?>
				<div class="main-image">
					<a class="fancybox" rel="group" href="<?=$baseUrl.$model->shopProductsMediases[0]->media->file_url?>"><img src="<?=$baseUrl.$model->shopProductsMediases[0]->media->file_url?>" alt="" class="medium-image" id="medium-image"></a>
				</div>
				<?unset($model->shopProductsMediases[0])?>
			<?	}	?>

			<?if(count($model->shopProductsMediases))	{?>
			
			<div class="wrapper-slider">		
				<div class="slider-images clearfix">
					<ul>
					<?foreach($model->shopProductsMediases as $media_item)	{?>
					<li><a class="fancybox" rel="group" href="<?=$baseUrl.$media_item->media->file_url?>"><img src="<?=$baseUrl.$media_item->media->file_url_thumb?>"></a></li>
					<?	}	?>
				</div>
			</div>
			
			<?	}	?>
		</div>

		<div class="w260 floatright">
			<div class="spacer-buy-area">
				<h1><?php echo $model->product_name; ?></h1>
				<div class="charact"></div>   
				<?php if (!empty ($model->product_charact))	{	?>
					<h3>Основные характеристики</h3>
					<div class="charact"><?=$model->product_charact?></div>
				<? }	?>				
				<div class="fields">
					<?if(!empty($model->manuf))	{	?>
					<div class="row clearfix">
						<span class="label">Производитель:</span>
						<span class="value"><?=$model->manuf?></span>
					</div>
					<?	}	?>

					<?if(!empty($model->material))	{	?>
					<div class="row clearfix">
						<span class="label">Материал:</span>
						<span class="value"><?=$model->material?></span>
					</div>
					<?	}	?>

					<?if(!empty($model->code))	{	?>
					<div class="row clearfix">
						<span class="label">Код товара:</span>
						<span class="value"><?=$model->code?></span>
					</div>
					<?	}	?>

					<?if(!empty($model->in_stock))	{	?>
					<div class="row clearfix">
						<span class="label">Наличие:</span>
						<span class="value">
							<?
								if ($model->product_in_stock != 0)	{
									echo '<span style="color:green">В наличии</span>';
								}	else	{
									echo $model->in_stock;
								}
							?>
						</span>
					</div>
					<?	}	?>

					<?if(!empty($model->delivery))	{	?>
					<div class="row clearfix">
						<span class="label">Доставка:</span>
						<span class="value"><?=$model->delivery?></span>
					</div>
					<?	}	?>

					<?if(!empty($model->prepayment))	{	?>
					<div class="row clearfix">
						<span class="label">Предоплата:</span>
						<span class="value"><?=$model->prepayment?></span>
					</div>
					<?	}	?>
				</div>

				<div class="action-block clearfix">
					<div class="product-price" id="productPrice<?=$model->product_id?>">
						
						<?if($model->shopProductPrices->product_override_price != 0)	{?>
							<div class="two-price">
								<div class="PricepriceWithoutTax"> <span class="PricepriceWithoutTax"><?=number_format($model->shopProductPrices->product_price, 0, '.', ' ')?>$</span></div>
								<div class="PricesalesPrice"> <span class="PricesalesPrice"><?=number_format($model->shopProductPrices->product_override_price, 0, '.', ' ')?>$</span></div>
							</div>
						<?	}	else	{?>
							<div class="one-price">
								<div class="PricepriceWithoutTax"> <span class="PricepriceWithoutTax"><?=number_format($model->shopProductPrices->product_price, 0, '.', ' ')?>$</span></div>
							</div>
						<?	}	?>
						
					</div>
					
					
					<form method="post" class="product js-recalculate" action="index.php">
						<input type="hidden" name="quantity" id="quantity" value="1">
						<input type="submit" name="addtocart" id="addtocart" class="addtocart-button add button" title="Добавить этот товар в корзину" value=" ">
						<input type="hidden" name="product_id" id="product_id" value="<?=$model->product_id?>">
					</form>
				</div>
				
				<div class="cart-popup-wr hidden">
					<div id="cart-popup" class="cart-popup" >
						<div id="cart-popup-info" class="cart-popup-info">Количество товара было обновлено.</div>
						<a class="continue close" href="javascript:void(0)" onclick="ClosePopUp();">Продолжить покупки</a>
						<? /*<a class="showcart floatright" href="/magazin-tyuninga/cart.html">Оформить заказ</a> */ ?>
						<?echo CHtml::link('Оформить заказ', $this->createUrl('/cart/showcart', array()), array('class'=>'showcart floatright')); ?>
						
					</div>
				</div>
				<?
				echo CHtml::link('Сообщение корзины', '#cart-popup', array('id'=>'cart-message', 'class'=>'fancybox cart-message hidden')); 
				?>


				<div class="ask-a-question">
					<a class="ask-a-question" href="/tyuning-bmw/3-series/e91/avtomobilnyj-chekhol-tent-vodonepronitsaemyj-car001-detail.html?task=askquestion&amp;tmpl=component">Задайте вопрос по этому товару</a>
				</div>


			</div>
		</div>
	</div>
	
<?
				$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Описание товара"));
				echo $model->product_desc;
				$this->endWidget();				
				
				$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Отзывы покупателей"));
				echo "Отзывы покупателей";
				$this->endWidget();
	
				$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>"Где можно установить эту деталь?"));
				echo "Где можно установить эту деталь?";
				$this->endWidget();
				
				$tabParameters = array();
				
			$i=0;
			foreach($this->clips as $key=>$clip)	{
				
					
						//$tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
						$tabParameters['tab_'.$i] = array('title'=>$key, 'content'=>$clip);
						$i++;
					
				
			}
			//$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, 'cssFile'=>"/css/gorizontal_tab.css", 'htmlOptions'=>array('class'=>'yiiTab clearfix'), 'activeTab'=>"tab_$category_id"));
			$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, 'cssFile'=>"/css/gorizontal_tab.css", 'htmlOptions'=>array('class'=>'yiiTab clearfix'), 'activeTab'=>"0"));				
	
		/*
		if(count($model->itemsDescriptions))	{
			//echo'<pre>';print_r($model->itemCategories);echo'</pre>';
			foreach($model->itemsDescriptions as $cat)	{
				$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>$cat->description_name));
				echo $cat->description;
				$this->endWidget();
				
				if($keyword)	{
					$pos = strpos($cat->description, $keyword);
					if ($pos === false) {
						$pos = strpos($cat->search_keywords, $keyword);
						if ($pos === false) {
						} else {
							$active_tab_id = $cat->id;
						}					
					} else {
						$active_tab_id = $cat->id;
					}

				}
			}
			$tabParameters = array();
			
			
			foreach($this->clips as $key=>$clip)	{
				foreach($model->itemsDescriptions	as $cat)	{
					if($cat->description_name == $key)	{
						//$tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
						$tabParameters['tab_'.$cat->id] = array('title'=>$key, 'content'=>$clip);
					}
				}
			}
			//$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, 'cssFile'=>"/css/gorizontal_tab.css", 'htmlOptions'=>array('class'=>'yiiTab clearfix'), 'activeTab'=>"tab_$category_id"));
			$this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters, 'cssFile'=>"/css/gorizontal_tab.css", 'htmlOptions'=>array('class'=>'yiiTab clearfix'), 'activeTab'=>"tab_$active_tab_id"));
		}
		*/
		
?>	






	
</div>
