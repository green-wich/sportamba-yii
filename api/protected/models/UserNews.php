<?php

class UserNews extends CActiveRecord
{
    public function tableName()
    {
        return '{{user_news}}';
    }

    public function rules()
    {
        return array(
            array('user_id, news_id', 'required'),
            array('user_id, news_id', 'length', 'max'=>11),
            array('id, user_id, news_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'news' => array(self::BELONGS_TO, 'News', 'news_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'news_id' => 'News',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('news_id',$this->news_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

