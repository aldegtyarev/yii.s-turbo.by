<?php

class FilesHelper
{
	
	/**
	 *
	 */	
	public static function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
	/**
	 *
	 */
	public static function create_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 )
	{
		$alpha_level	/= 100;	# convert 0-100 (%) alpha to decimal

		# calculate our images dimensions
		$main_img_obj_w	= imagesx( $main_img_obj );
		$main_img_obj_h	= imagesy( $main_img_obj );
		$watermark_img_obj_w	= imagesx( $watermark_img_obj );
		$watermark_img_obj_h	= imagesy( $watermark_img_obj );
 
		# determine center position coordinates
		$main_img_obj_min_x	= floor( ( $main_img_obj_w / 2 ) - ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_max_x	= ceil( ( $main_img_obj_w / 2 ) + ( $watermark_img_obj_w / 2 ) );
		$main_img_obj_min_y	= floor( ( $main_img_obj_h / 2 ) - ( $watermark_img_obj_h / 2 ) );
		$main_img_obj_max_y	= ceil( ( $main_img_obj_h / 2 ) + ( $watermark_img_obj_h / 2 ) ); 
		
		/*
		$main_img_obj_min_x_top_left = 0;		
		$main_img_obj_min_y_top_left = 0;
		
		$main_img_obj_min_x_bottom_right	= floor( ( $main_img_obj_w  ) - ( $watermark_img_obj_w  ) );
		$main_img_obj_min_y_bottom_right	= floor( ( $main_img_obj_h  ) - ( $watermark_img_obj_h  ) );
		*/

		# create new image to hold merged changes
		$return_img	= imagecreatetruecolor( $main_img_obj_w, $main_img_obj_h );
 
		# walk through main image
		for( $y = 0; $y < $main_img_obj_h; $y++ ) {
			for( $x = 0; $x < $main_img_obj_w; $x++ ) {
				$return_color	= NULL;
 
				# determine the correct pixel location within our watermark
				$watermark_x	= $x - $main_img_obj_min_x;
				$watermark_y	= $y - $main_img_obj_min_y;
 
				$watermark_x_top_left	= $x - $main_img_obj_min_x_top_left;
				$watermark_y_top_left	= $y - $main_img_obj_min_y_top_left;
 
				$watermark_x_bottom_right	= $x - $main_img_obj_min_x_bottom_right;
				$watermark_y_bottom_right	= $y - $main_img_obj_min_y_bottom_right;
 
				# fetch color information for both of our images
				$main_rgb = imagecolorsforindex( $main_img_obj, imagecolorat( $main_img_obj, $x, $y ) );
 
				# if our watermark has a non-transparent value at this pixel intersection
				# and we're still within the bounds of the watermark image
				if (
						($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h ) //||
						//($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h ) ||
						//($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )
					) {
					
					if($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&	$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x, $watermark_y ) );
					}/*	elseif	($watermark_x_top_left >= 0 && $watermark_x_top_left < $watermark_img_obj_w &&	$watermark_y_top_left >= 0 && $watermark_y_top_left < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_top_left, $watermark_y_top_left ) );
					}	elseif($watermark_x_bottom_right >= 0 && $watermark_x_bottom_right < $watermark_img_obj_w &&	$watermark_y_bottom_right >= 0 && $watermark_y_bottom_right < $watermark_img_obj_h )	{
						$watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x_bottom_right, $watermark_y_bottom_right ) );
					}*/
 
					# using image alpha, and user specified alpha, calculate average
					$watermark_alpha	= round( ( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2 );
					$watermark_alpha	= $watermark_alpha * $alpha_level;
 
					# calculate the color 'average' between the two - taking into account the specified alpha level
					$avg_red		= self::_get_ave_color( $main_rgb['red'],		$watermark_rbg['red'],		$watermark_alpha );
					$avg_green	= self::_get_ave_color( $main_rgb['green'],	$watermark_rbg['green'],	$watermark_alpha );
					$avg_blue		= self::_get_ave_color( $main_rgb['blue'],	$watermark_rbg['blue'],		$watermark_alpha );
 
					# calculate a color index value using the average RGB values we've determined
					$return_color	= self::_get_image_color( $return_img, $avg_red, $avg_green, $avg_blue );
 
				# if we're not dealing with an average color here, then let's just copy over the main color
				} else {
					$return_color	= imagecolorat( $main_img_obj, $x, $y );
 
				} # END if watermark

				# draw the appropriate color onto the return image
				imagesetpixel( $return_img, $x, $y, $return_color );
 
			} # END for each X pixel
		} # END for each Y pixel
		

		# return the resulting, watermarked image for display
		return $return_img;
 
	} # END create_watermark()

	/**
	 * сохранение имени файла фото
	 */
	public static function setFoto(&$connection, $filename, $id, $table)
	{
		$sql = "UPDATE $table SET `foto` = :foto WHERE `id` = :id";
		$command = $connection->createCommand($sql);
		$command->bindParam(":id", $id);
		$command->bindParam(":foto", $filename);
		$res = $command->execute();		
	}
	
	public static function removeFoto($path)
	{
		$app = Yii::app();
		$pages_imagePath = Yii::getPathOfAlias($path);
		
		$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
		if(file_exists($file_path)) unlink($file_path);
		
		$file_path = $pages_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename;
		if(file_exists($file_path)) unlink($file_path);
		return true;
	}
	
	
	/**
	 * average two colors given an alpha
	 */
	private static function _get_ave_color( $color_a, $color_b, $alpha_level ) {
		return round( ( ( $color_a * ( 1 - $alpha_level ) ) + ( $color_b	* $alpha_level ) ) );
	} # END _get_ave_color()
	
	/**
	 * return closest pallette-color match for RGB values
	 */
	private static function _get_image_color($im, $r, $g, $b) {
		$c=imagecolorexact($im, $r, $g, $b);
		if ($c!=-1) return $c;
		$c=imagecolorallocate($im, $r, $g, $b);
		if ($c!=-1) return $c;
		return imagecolorclosest($im, $r, $g, $b);
	} # EBD _get_image_color()
	
	
	
}

