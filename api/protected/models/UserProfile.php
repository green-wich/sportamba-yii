<?php

/**
 * This is the model class for table "{{user_profile}}".
 *
 * The followings are the available columns in table '{{user_profile}}':
 * @property string $id
 * @property integer $user_id
 * @property string $profileUrl
 * @property string $photoUrl
 * @property string $displayName
 * @property string $firstName
 * @property string $lastName
 * @property string $gender
 * @property string $region
 * @property string $email
 */
class UserProfile extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_profile}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, profileUrl, photoUrl, firstName, lastName, gender', 'required'),
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('profileUrl, photoUrl', 'length', 'max'=>200),
            array('displayName, email', 'length', 'max'=>100),
            array('firstName, lastName', 'length', 'max'=>60),
            array('gender', 'length', 'max'=>30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, profileUrl, photoUrl, displayName, firstName, lastName, gender, region, email', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'profileUrl' => 'Profile Url',
            'photoUrl' => 'Photo Url',
            'displayName' => 'Display Name',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'gender' => 'Gender',
            'region' => 'Region',
            'email' => 'Email',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('profileUrl',$this->profileUrl,true);
        $criteria->compare('photoUrl',$this->photoUrl,true);
        $criteria->compare('displayName',$this->displayName,true);
        $criteria->compare('firstName',$this->firstName,true);
        $criteria->compare('lastName',$this->lastName,true);
        $criteria->compare('gender',$this->gender,true);
        $criteria->compare('region',$this->region,true);
        $criteria->compare('email',$this->email,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserProfile the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}