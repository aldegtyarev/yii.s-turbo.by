 <div class="login2">
	<div class="ava">
		<img src="<?=Yii::app()->homeUrl . DIRECTORY_SEPARATOR .$_return_url.'forum/'.(empty($userInfoForum['filename'])?'images/misc/unknown.gif':'image.php?u='.$userInfoForum['userid'])?>" />
	</div>
	<div class="info">    
	<div class="login-greeting"><a href="<?=$_return_url.'forum/member.php?'.$userInfoForum['userid'].'-'.$userInfoForum['username']?>&tabid=34" class="user-link"><?=$userInfoForum['nameVB']; ?></a></div>

	<div class="logout-button"><a href="<?php echo $logoutURL?>" title="Выйти" class="button" style="height:auto;">Выйти</a></div>
	<div class="clr"></div>

	<div class="basket-link"><a href="<?=$_return_url.'forum/profile.php?do=editprofile'?>&tabid=34">Настройки</a></div>    
	<div class="basket-link"><a href="<?=$_return_url.'forum/private.php'?>">Личные сообщения <?=($userInfoForum['unread_messages'])?'('.$userInfoForum['unread_messages'].')':''?></a></div> 
	<?php if($CountSubscriptions)	{	?>
	<div class="basket-link"><a href="#">Мои подписки</a></div>
	<?	}	?>
	<?php if ($user->partner || $user->partner_free): ?>
	<div class="basket-link"><a href="#">Моя компания</a></div>
	<?php endif; ?>
	<div class="company"></div>
	<div class="overide">Перcональная скидка <?=$user->override;?>%</div>    
	</div>
</div>