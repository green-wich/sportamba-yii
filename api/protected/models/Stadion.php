<?php

class Stadion extends CActiveRecord
{
    
    public function tableName()
    {
        return '{{stadion}}';
    }

    public function rules()
    {
        return array(
            array('name, address', 'required'),
            array('lat, long', 'validAdress'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address, lat, long', 'safe', 'on'=>'search'),
        );
    }
    
    public function validAdress($attribute,$params)
    {
        if($this->$attribute == '')
            $this->addError($attribute, 'Нужно локализовать стадион на карте!');
        
    }

    public function relations()
    {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '#',
            'name' => 'Название страдиона',
            'address' => 'Адрес',
            'lat' => 'Lat',
            'long' => 'Long',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('address',$this->address,true);
        $criteria->compare('lat',$this->lat,true);
        $criteria->compare('long',$this->long,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>'20'),
            'sort'=>array(
                          'defaultOrder'=>array(
                          'id'=>"DESC"
                  ))
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function all()
    {
        return CHtml::listData(self::model()->findAll(array('order'=>'id DESC')), 'id', 'name');
    }
}
