<?php

class Stadion extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{stadion}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, address, lat, long', 'required'),
            array('name', 'length', 'max'=>60),
            array('address', 'length', 'max'=>200),
            array('lat, long', 'length', 'max'=>75),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address, lat, long', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
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
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
