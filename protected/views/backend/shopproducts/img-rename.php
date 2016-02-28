<? 
if($count > 0) {
	$autostart = true;
}	else	{
	$autostart = false;
}

?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />            
	</head>
	

	<body <? if($autostart === true) { ?>onload="document.forms['adminForm'].submit()" <? } ?> >
		<form action="" method="post" name="adminForm">
			<h1>Processing <?= $start_at ?></h1>

			<input type="hidden" name="start_at" value="<?= $start_at ?>" />
			<?/*<input type="hidden" name="limit" value="<?= $limit ?>" />*/?>
			<input type="submit" name="go" value="go" id="go" style="display:--none;" />
		</form>
		
		<? if($autostart === false) { ?>
			<? foreach($image_file_name_arr as $k=>$v) {
					//echo'<pre>';print_r($k . ' - ' . $v);echo'</pre>';//die;
				}	
			?>
			
		<? } ?>
	</body>

</html>