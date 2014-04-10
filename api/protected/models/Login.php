<?php

class Login extends CActiveRecord
{    
    public $firstName;
    public $lastName;
    
    public function tableName()
    {
        return '{{login}}';
    }

    public function rules()
    {
        return array(
            array('user_id, username, password, session_data, provider', 'required'),
            array('user_id', 'length', 'max'=>11),
            array('username, password', 'length', 'max'=>100),
            array('provider', 'length', 'max'=>20),
            array('id, user_id, username, password, session_data, provider', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'profile' => array(self::HAS_ONE, 'UserProfile', 'login_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'username' => 'Username',
            'password' => 'Password',
            'session_data' => 'Session Data',
            'created_at' => 'Created At',
            'provider' => 'Provider',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('session_data',$this->session_data,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('provider',$this->provider,true);

        $criteria->with = array('profile');
        $criteria->compare('profile.firstName', $this->firstName, true);
        $criteria->compare('profile.lastName', $this->lastName, true);        

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>'20'),    
            'sort'=>array(
                          'defaultOrder'=>array(
                          'created_at'=>"DESC"
                  ))
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function behaviors() {  
        return array(  
            'AutoTimestampBehavior' => array(  
                'class' => 'zii.behaviors.CTimestampBehavior',  
                'createAttribute' => 'created_at',
                'updateAttribute' => null,
                'setUpdateOnCreate' => false,  
            )
        );  
    }
    
    public function findByAuthUser($provider, $identifier){
        return $this->findByAttributes(array(
                 'provider' => $provider,
                 'username' => $identifier,
         ));  
    }
    
    public function getFullName()
    {
        return $this->profile->firstName . ' ' . $this->profile->lastName;
    }
}

