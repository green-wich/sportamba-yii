<?php

/**
 * This is the model class for table "{{match}}".
 *
 * The followings are the available columns in table '{{match}}':
 * @property integer $id
 * @property integer $id_command1
 * @property integer $id_command2
 * @property string $date
 * @property integer $status
 */
class Match extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{match}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_command1, id_command2, date, url, title, text, img', 'required'),
			array('id_command1, id_command2, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_command1, id_command2, date, status, url, title, text, img', 'safe', 'on'=>'search'),
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
        
        public function getCommand1(){
            $model = Commands::model()->findByPk($this->id_command1);
            return $model->name;
        }
        
        public function getCommand2(){
            $model = Commands::model()->findByPk($this->id_command2);
            return $model->name;
        }

        /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_command1' => 'Команда 1',
			'id_command2' => 'Команда 2',
			'date' => 'Дата матча',
			'status' => 'Status',
                        'url' => 'Url',
			'title' => 'Title',
			'text' => 'Text',
			'img' => 'Img',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_command1',$this->id_command1);
		$criteria->compare('id_command2',$this->id_command2);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status);
                $criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('img',$this->img,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Match the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
