<?php

class UserMatch extends CActiveRecord
{
    
    public function tableName()
    {
        return '{{user_match}}';
    }

    public function rules()
    {
        return array(
            array('match_id, command_id, type_place_viewing, place_viewing', 'required'),
            array('match_id, command_id', 'length', 'max'=>11),
            array('type_place_viewing', 'length', 'max'=>1),
            array('place_viewing', 'length', 'max'=>75),
            array('id, match_id, command_id, type_place_viewing, place_viewing', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'match' => array(self::BELONGS_TO, 'Match', 'match_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'command' => array(self::BELONGS_TO, 'Command', 'command_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'match_id' => 'Match',
            'user_id' => 'User',
            'command_id' => 'Command',
            'type_place_viewing' => 'Type Place Viewing',
            'place_viewing' => 'Place Viewing',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('match_id',$this->match_id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('command_id',$this->command_id,true);
        $criteria->compare('type_place_viewing',$this->type_place_viewing,true);
        $criteria->compare('place_viewing',$this->place_viewing,true);
        $criteria->compare('permission_post',$this->permission_post);
        $criteria->compare('result_post',$this->result_post,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function beforeSave() {
        if ($this->isNewRecord){
            $this->user_id = Yii::app()->user->id;
            $provider = $this->user->provider;
            if($this->permission_post && $provider == 'Facebook'){
                $message = "Я запланировал матч ".$this->match->getCommands();
                $message .= ", который состоится " . $this->match->getDate();
                $message .= " на стадионе " . $this->match->stadion->name . ".";
                try{
                    Yii::app()->hybridAuth->getHybridAuth()->getAdapter($provider)->setUserStatus($message);
                    $this->result_post = "successful";
                }catch(Exception $e){
                    $this->result_post = $e;
                }
            }
        } 
        return parent::beforeSave();
    }
    
}

