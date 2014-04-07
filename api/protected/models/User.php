<?php

class User extends CActiveRecord
{
    
    private static $_curreent_user;
    public $firstName;
    public $lastName;

    public static function getCurrentUser(){
        self::$_curreent_user = self::$_curreent_user ? self::$_curreent_user : self::model()->findByPk(Yii::app()->user->id);
        return self::$_curreent_user;
    }
    
    public function tableName()
    {
        return '{{user}}';
    }

    public function rules()
    {
        return array(
            array('username, password, session_data, provider, role', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('username, password', 'length', 'max'=>100),
            array('provider', 'length', 'max'=>20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, session_data, provider, role', 'safe', 'on'=>'search'),
        );
    }
    
    public function relations()
    {
        return array(
            'profile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
            'match' => array(self::HAS_MANY, 'UserMatch', 'match_id'),
            'connection' => array(self::HAS_MANY, 'Connection', 'user_id_2'),
            'news' => array(self::MANY_MANY, 'News', 'sport_user_news(user_id, news_id)')
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Полное имя',
            'password' => 'Password',
            'session_data' => 'Session Data',
            'created_at' => 'Created At',
            'provider' => 'Provider',
            'role' => 'Role',
            'status' => 'Status',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;        

        $criteria->compare('id',$this->id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('session_data',$this->session_data,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('provider',$this->provider,true);
        $criteria->compare('role',$this->role,true);
        $criteria->compare('status',$this->status);
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
    
    public function beforeSave() {
        if ($this->isNewRecord){
            $this->status = 1;
        } 
        return parent::beforeSave();
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