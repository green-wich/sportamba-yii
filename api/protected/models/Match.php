<?php

class Match extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{match}}';
	}

	public function rules()
        {
            return array(
                array('command_1, command_2, date, status', 'required'),
                array('status', 'numerical', 'integerOnly'=>true),
                array('command_1, command_2', 'length', 'max'=>100),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('id, command_1, command_2, date, status', 'safe', 'on'=>'search'),
            );
        }
        
	public function relations()
	{
		return array(
		);
	}
        
	public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'command_1' => 'Команда 1',
                'command_2' => 'Команда 2',
                'date' => 'Дата проведения матча',
                'status' => 'Статус',
            );
        }
        
	public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('command_1',$this->command_1,true);
            $criteria->compare('command_2',$this->command_2,true);
            $criteria->compare('date',$this->date,true);
            $criteria->compare('status',$this->status);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSave() {
            $this->date = Yii::app()->dateFormatter->format('yyyy.MM.dd HH:mm', strtotime($this->date));
            return parent::beforeSave();
        }
        
}
