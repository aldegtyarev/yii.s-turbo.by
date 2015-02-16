<?
require_once($webroot.'/msi/config.php');
require_once($webroot.'/msi/languages/ru.php');

if ((isset($_POST['errorLogin']) || isset($_GET['errorLogin'])) || (isset($_POST['errorLoginNotActive']) || isset($_GET['errorLoginNotActive']))) :
	if(isset($_POST['errorLogin']) || isset($_GET['errorLogin'])){
		$htmlErrMsg = 'Авторизация не прошла, попробуйте еще раз или воспользуйтесь функцией напоминания пароля.';
	}	else	{
		$htmlErrMsg = 'Авторизация не прошла. Ваша учётная запись не активирована<br />перейдите по ссылке, полученной в письме после регистрации.';
	}
	$htmlErr ='<div id="pwdContent"><div class="ubox-tl"></div><div class="ubox-tc"></div><div class="ubox-tr"></div><div class="ubox-mr"></div><div class="ubox-br"></div><div class="ubox-bc"></div><div class="ubox-bl"></div><div class="ubox-ml"></div><a href="#close" id="msiClose"></a><div class="ubox-inner"><div class="block-1"><div id="msgBox"><span class="msgContent"></span></div><span style="color:#ff0000;">'.$htmlErrMsg.'</div></div></div></div>';
?>
	<script type="text/javascript">
	jQuery.noConflict();
		 jQuery(document).ready(function(){
						msiExecBox(1);
						msiPreBox('', '<?=$htmlErr?>');
						jQuery('#msiUniBox').hide().fadeIn(1000);
					//	jQuery('#msiMask').fadeOut(5000);
		 });
		 
	</script>					
<?php
endif;
?>
<div class="login-wrap floatRight">
	<script type="text/javascript">
		 $(document).ready(function(){
			$('#div-login').css('display','none')
		 });

		 function login_btn(){
			if($('#div-login').hasClass('open')){
				$('#div-login').slideUp(300)
				$('#div-login').removeClass('open')
			}	else	{
				$('#div-login').slideDown(300)
				$('#div-login').addClass('open')		
			}
			return false;
		 }
	</script>
	<form action="<?php echo $msiCFG['url']?>/remote.php?act=dologin<?='&redirect='.$return;?>" method="post" id="login-form" class="login-form floatLeft">
			<ul class="login">
				<li><a href="#login" name="login" id="log-in-btn" class="msiubox a1 log-in-btn">Войти</a></li>
				<li><a href="#register" id="reg-btn" name="reg" class="msiubox a1 reg-btn">Регистрация</a></li>
			</ul>    
	</form>
</div>

