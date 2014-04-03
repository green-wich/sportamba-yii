<?php

class User extends CActiveRecord
{
    
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
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('session_data',$this->session_data,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('provider',$this->provider,true);
        $criteria->compare('role',$this->role,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
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
    
    
}