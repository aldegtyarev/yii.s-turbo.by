<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
//class MsiUserIdentity extends CUserIdentity
class MsiUserIdentity extends UserIdentity
{

	const ERROR_NOT_AUTHENTICATED = 3;
	
	protected $email;
	protected $_id;
	
	public $create_at;
	public $lastvisit_at;
	
	public function __construct($email) {
        $this->email = $email;
    }
	
	
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        
        $email = strtolower($this->email);
        $user = User::model()->find('LOWER(email)=?',array($email));
		//echo"<pre>/////////";print_r($user);echo"</pre>";
		//echo'<pre>*/*/*/*getAttributes';print_r($user->profile->getAttributes());echo'</pre>';
		$app = Yii::app();	
		
		if($user===null)	{
			
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}	else	{
			$this->errorCode=self::ERROR_NONE;
			$this->_id=$user->id;
			$this->username=$user->username;
			//$this->override=$user->override;
			//$this->create_at = $user->create_at;
			//$this->lastvisit_at = $user->lastvisit_at;
			
			//$this->setState('id', $user->id);
            //$this->setState('name', $user->username);		
			//$app->user->login($this);
		}
		
        return !$this->errorCode;	
	}
	
	public function getId()
	{
		return $this->_id;
	}	
}