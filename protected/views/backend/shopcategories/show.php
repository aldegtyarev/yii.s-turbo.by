<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs = $breadcrumbs;
/*
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$category->name,
);
*/

$app = Yii::app();
//$base_url = $app->getBaseUrl(true);
//echo'<pre>';print_r($base_url);echo'</pre>';
//echo'<pre>';print_r($app->homeUrl);echo'</pre>';

$clientScript = $app->clientScript;
$clientScript->registerCssFile('/css/shop.css', 'screen');
//echo'<pre>';print_r(count($descendants));echo'</pre>';
//echo'<pre>';print_r($descendants);echo'</pre>';
//echo'<pre>';print_r($products_and_pages);echo'</pre>';

$products = $products_and_pages['rows'];
$pages = $products_and_pages['pages'];

//echo'<pre>';print_r($category);echo'</pre>';

?>

<?	/*<h1><?php echo $category->name; ?></h1>	*/?>
<div class="category-view">
<?if(count($descendants) && $descendants[0]->category_image == null)	{
			$child_col0 = array();
			$child_col1 = array();
			$child_col2 = array();
			$child_col3 = array();		

			foreach ( $descendants as $category ) {
				//echo $category->cat_column.'<br />';
				switch($category->cat_column){
					case 0:
						$child_col0[] = $category;
						break;
					case 1:
						$child_col1[] = $category;
						break;
					case 2:
						$child_col2[] = $category;
						break;
					case 3:
						$child_col3[] = $category;
						break;
					default:
						break;
				}
			}

			?>
			<div class="item-page">
				<table class="child-categories">
					<tr>
						<td>
							<ul>
								<?php
									foreach($child_col1 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('path'=>$category->path));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
									foreach($child_col0 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('path'=>$category->path));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
						<td>
							<ul>
								<?php
									foreach($child_col2 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('path'=>$category->path));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
						<td>
							<ul>
								<?php
									foreach($child_col3 as $category){
										$caturl = $this->createUrl('/shopcategories/show/', array('path'=>$category->path));
										echo'<li><a href="'.$caturl.'">'.$category->name.'</a></li>';
									}
								?>
							</ul>
						</td>
					</tr>
				</table>
			</div>

<?

}	else	{



	// Category and Columns Counter
	$iCol = 1;
	$iCategory = 1;

	// Calculating Categories Per Row
	$categories_per_row = 4;
	$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

	// Separator
	$verticalseparator = " vertical-separator";
	
	if(count($descendants))	{	?>
		<p style="font-weight:bold;color:#2779B7;">Выберите категорию</p>
		<?
		foreach($descendants as $category)	{

				// this is an indicator wether a row needs to be opened or not
				if ($iCol == 1) { ?>
					<div class="row clearfix">
				<?php }
				// Show the vertical seperator
				if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
					$show_vertical_separator = ' ';
				} else {
					$show_vertical_separator = $verticalseparator;
				}
				
				$caturl = $this->createUrl('/shopcategories/show/', array('path'=>$category->path));
				?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer <?=($iCol ==  $categories_per_row)?'lastSpacer':''?>">
						<?
						//echo'<pre>';var_dump($category->category_image);echo'</pre>';
						
						?>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->name ?>">
							<?php
								if ($category->category_image){
									echo CHtml::image($app->homeUrl . DIRECTORY_SEPARATOR 	.$category->category_image).'<br />';
								} ?>
								<span><?php echo $category->name ?></span>
							</a>
					</div>
				</div>			

			
			<?
			$iCategory ++;
			// Do we need to close the current row now?
			if ($iCol == $categories_per_row) { ?>
				
				</div>
				<?php
				$iCol = 1;
			} else {
				$iCol ++;
			}		
		}
		if ($iCol != 1) { ?>
		
		</div>
		<?php }
	}
}

?>
</div>

<?if (!empty($products)) {?>
	<div class="browse-view">	
		<div class="products">
			<?
			// Category and Columns Counter
			$iBrowseCol = 1;
			$iBrowseProduct = 1;

			// Calculating Products Per Row
			//$BrowseProducts_per_row = $this->perRow;
			$BrowseProducts_per_row = 3;
			$Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );
			// Separator
			$verticalseparator = " vertical-separator";

			// Count products
			$BrowseTotalProducts = 0;
			foreach ( $products as $product ) {
			   $BrowseTotalProducts ++;
			}

			// Start the Output
			
			//$number = 1234.000;
			//$number = 55.00000;
			//echo'<pre>';print_r(number_format($number, 0, '.', ' '));echo'</pre>';
			
			//echo'<pre>';print_r($products[0],0);echo'</pre>';



			foreach ( $products as $product ) {
				$product_url = $this->createUrl('shopproducts/detail', array('path'=> $category->path.'/'.$product->slug.'-detail'));
				//echo'<pre>';print_r($product_url);echo'</pre>';
				// Show the horizontal seperator
				if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) { ?>
				<div class="clr"></div>
				<?php }
				// this is an indicator wether a row needs to be opened or not
				if ($iBrowseCol == 1) { ?>
				<div class="row">
				<?php }		
				// Show the vertical seperator
				if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
					$show_vertical_separator = ' ';
				} else {
					$show_vertical_separator = $verticalseparator;
				}
				// Show Products ?>
				<div class="spacer <?=$iBrowseProduct%$BrowseProducts_per_row==0?'lastSpacer':''?>">

					<div class="inner-spacer">
						<h3><?=CHtml::link($product->product_name, $product_url)?></h3>
						<div class="img">
							<?	echo CHtml::link(CHtml::image($app->homeUrl . DIRECTORY_SEPARATOR 	. $product->file_url_thumb), $product_url)	?>
							<div class="add_info">
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tbody>
										<tr>
											<td class="product_sku"><span class="infoArticle">код: </span><?=$product->product_sku?></td>
											<td class="mf_name"><span class="infoArticle">пр-во: </span><?=$product->manuf?></td>						
										</tr>
									</tbody>
							</table>
							</div>						
						</div>
						<table class="bottom" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody>
								<tr>
									<td class="td1" valign="middle">
										<?php
											if($product->product_availability)	{	
												echo CHtml::openTag('span', array('class'=>'status')).CHtml::image($app->homeUrl . DIRECTORY_SEPARATOR 	. "img/shop/availability/".$product->product_availability).CHtml::closeTag('span');
											}
										?>
										<div class="product-price marginbottom12" id="productPrice<?=$product->product_id?>">
											<div class="two-price">
												<?if($product->product_override_price)	{?>
													<div class="PricepriceWithoutTax">
														<span class="PricepriceWithoutTax"><?=number_format($product->product_price, 0, '.', ' ')?>$</span>
													</div>
													<div class="PricesalesPrice"> 
														<span class="PricesalesPrice"><?=number_format($product->product_override_price, 0, '.', ' ')?>$</span>
													</div>
												<?	}	else	{?>
													<div class="PricepriceWithoutTax">
														<span class="PricepriceWithoutTax"><?=number_format($product->product_price, 0, '.', ' ')?>$</span>
													</div>
												
												<?	}?>
											</div>
										</div>
									</td>
									<td width="30" valign="middle">
										<div class="prod_item_bottom">
											<span class="on_product_page">
												<?	echo CHtml::link(CHtml::image($app->homeUrl . DIRECTORY_SEPARATOR 	. "img/shop/on_product_page.png"), $product_url, array('title'=>$product->product_name))	?>
											</span>
										</div>
									</td>
								</tr>
							</tbody>
						</table>						
					</div>
				</div>
				<?	
				if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {?>
					<div class="clear"></div>
					</div> <!-- end of row -->
					<?php
					$iBrowseCol = 1;
				} else {
					$iBrowseCol ++;
				}
				$iBrowseProduct ++;			
			}	?>
		</div>
	</div>
<?	}	?>

<? if($category->category_description) { ?>
	<div class="category-description"><?=$category->category_description?></div>
<? } ?>

