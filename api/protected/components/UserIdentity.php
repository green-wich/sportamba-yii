<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    protected $_id;
    
    public function authenticate()
    {
        $user = User::model()->findByAttributes(['username' => $this->username]);
                
        if (isset($user)) {
            if ($this->password == $user->password) {
                $this->_id = $user->id;
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        return !$this->errorCode;
    }
    
    public function getId()
    {
        return $this->_id;
    }
}