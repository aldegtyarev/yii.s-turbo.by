<?php
class MsiLogin extends CWidget {

	var $_msiURL;
	var $_msiURLalias;
	var $_redirect;
	
	var $_return_url;
	var $_logoutURL;

	public function __construct()
	{
		global $msiClient;
		$this->_msiURL = $msiClient->_cfg['url'];
	}

    public function run() {
	
		$webroot = Yii::getPathOfAlias('webroot');
		
		global $msiClient;
		
		
		require($webroot."/msiyii/init.php");
		//echo'<pre>';print_r($msiClient->core);echo'</pre>';
		$buffer = '';
		$buffer = $msiClient->core->renderSysEngine($buffer);
		
		$app = Yii::app();
		$connection = Yii::app()->db;
		
		$_return_url = $app->request->hostInfo.$app->request->requestUri;
		//Yii::app()->request->requestUri
		/*
		echo'<pre>';print_r($_return_url);echo'</pre>';
		echo'<pre>';print_r($app->request->requestUri);echo'</pre>';
		echo'<pre>';print_r($app->homeUrl);echo'</pre>';
		echo'<pre>';print_r($app->request->hostInfo);echo'</pre>';
		*/
		
		$_logoutURL = $msiClient->_cfg['url']."/login.php?act=logout&amp;redirect=".$msiClient->encodeStr($_return_url);
		$type = $this->getType($app);
		
		if($app->user->isGuest)	{
			$userInfoForum = array();
		}	else	{
			$userInfoForum = $this->getUserInfoFromForum($app->user, $connection);
			$this->checkNickName($user, $userInfoForum, $connection);
		}		
		
		$requestUri = $app->request->requestUri;
		
		//echo'<pre>';print_r($app->user->override);echo'</pre>';
		
		
		$this->render('MsiLogin',array	(	'return' => $_return_url,
											'logoutURL' => $_logoutURL,
											'typeForm' => $type,
											'webroot' => $webroot,
											'requestUri' => $requestUri,
											'userInfoForum' => $userInfoForum,
											'user' => $app->user,
										));
    }
		
		
	static function getType($app)
	{
		return (!$app->user->isGuest) ? 'logout' : 'login';
	}
	
	static function getUserInfoFromForum($user, &$connection)
	{
		
		$sql = "SELECT 
					u.`userid`, u.`username`, av.`filename`, 
					(SELECT count(pm.`pmid`) FROM `vb_pm` AS pm WHERE u.`userid` = pm.`userid` AND pm.`messageread` = 0) AS unread_messages, 
					(SELECT count(sub.`id`) FROM {{subscribers}} AS sub WHERE sub.`user_id` = u.userid) as CountSubscriptions,
					(SELECT `field12` FROM `vb_userfield` WHERE `userid` = u.userid) AS nameVB,
					(SELECT `nickname` FROM `msi_member` WHERE `email` = u.`email`) AS nameCore
				FROM `vb_user` AS u INNER JOIN `vb_customavatar` AS av USING(`userid`) WHERE u.`email` = '$user->email'";
		$command = $connection->createCommand($sql);
		$row = $command->queryRow();
		//echo'<pre>';print_r($row);echo'</pre>';
		return $row;
	}
	
	static function checkNickName($user, $userInfoForum, &$connection)
	{
		if ($userInfoForum['nameCore'] != $userInfoForum['nameVB']){
			//Обновляем значение имени и в ядре и в Joomla
			$sql = "UPDATE `msi_member` SET `nickname` = '".$userInfoForum['nameVB']."' WHERE `email` = '$user->email'";
			$command = $connection->createCommand($sql);
			$res = $command->execute();
			$sql = "UPDATE {{users}} SET `username` = '".$userInfoForum['nameVB']."' WHERE `email` = '$user->email'";
			$command = $connection->createCommand($sql);
			$res = $command->execute();
		}
		
	}
}
?>