<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $created_at
 * @property integer $status
 */
class User extends CActiveRecord
{
    
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, session_data, provider', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('username, password', 'length', 'max'=>100),
            array('provider', 'length', 'max'=>20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, session_data, provider', 'safe', 'on'=>'search'),
        );
    }
    
    public function relations()
    {
        return array(
            'profile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
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