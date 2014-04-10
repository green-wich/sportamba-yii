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
            array('role', 'required'),
            array('role', 'length', 'max'=>10),
            array('id, role, status', 'safe', 'on'=>'search'),
        );
    }
    
    public function relations()
    {
        return array(
            'connections' => array(self::HAS_MANY, 'Connection', 'user_id_2'),
            'login' => array(self::HAS_MANY, 'Login', 'user_id'),
            'match' => array(self::HAS_MANY, 'UserMatch', 'user_id'),
            'news' => array(self::MANY_MANY, 'News','sport_user_news(user_id, news_id)'),
        );
    }

    public function attributeLabels()
    {
         return array(
            'id' => 'ID',
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
       
    public function beforeSave() {
        if ($this->isNewRecord){
            $this->status = 1;
        } 
        return parent::beforeSave();
    }
        
    
}