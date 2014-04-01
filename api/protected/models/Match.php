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
                array('id_command_1, id_command_2, date, status', 'required'),
                array('id, id_command_1, id_command_2, date, status', 'safe', 'on'=>'search'),
            );
        }
        
	public function relations()
	{
            return array(
                'command_1' => array(self::BELONGS_TO, 'Command', 'id_command_1'),
                'command_2' => array(self::BELONGS_TO, 'Command', 'id_command_2'),
            );
	}
        
	public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'id_command_1' => 'Команда 1',
                'id_command_2' => 'Команда 2',
                'date' => 'Дата проведения матча',
                'status' => 'Статус',
            );
        }
        
	public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('id_command_1',$this->command_1,true);
            $criteria->compare('id_command_1',$this->command_2,true);
            $criteria->compare('date',$this->date,true);
            $criteria->compare('status',$this->status);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                          'defaultOrder'=>array(
                          'date'=>"DESC"
                  ))
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
