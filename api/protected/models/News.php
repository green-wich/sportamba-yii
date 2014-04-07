<?php

class News extends CActiveRecord
{
    public function tableName()
    {
        return '{{news}}';
    }

    public function rules()
    {
        return array(
            array('text', 'required'),
            array('id, text, created_at, status', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'userNews' => array(self::HAS_MANY, 'UserNews', 'news_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'status' => 'Status',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
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
    
    public function beforeSave()
    {
        if ($this->isNewRecord){
            $this->created_at = date("Y-m-d H:i:s", time());
            $this->status = 1;
        }
        return parent::beforeSave();    
    }
    
}

