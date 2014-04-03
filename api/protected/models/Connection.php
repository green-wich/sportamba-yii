<?php

class Connection extends CActiveRecord
{
    public function tableName()
    {
        return '{{connection}}';
    }

    public function rules()
    {

        return array(
            array('user_id_1, user_id_2', 'required'),
            array('user_id_1, user_id_2', 'length', 'max'=>11),
            array('id, user_id_1, user_id_2', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'user1' => array(self::BELONGS_TO, 'User', 'user_id_1'),
            'user2' => array(self::BELONGS_TO, 'User', 'user_id_2'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id_1' => 'User Id 1',
            'user_id_2' => 'User Id 2',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('user_id_1',$this->user_id_1,true);
        $criteria->compare('user_id_2',$this->user_id_2,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
