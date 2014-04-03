<?php

class UsermatchController extends Controller
{
    const JSON_RESPONSE_ROOT_SINGLE='usermatch';
    const JSON_RESPONSE_ROOT_PLURAL='usermatches';
   
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id=".Yii::app()->user->id;
        $usermatches = UserMatch::model()->findAll($criteria);
        $row = array();
        $console = array();
        foreach ($usermatches as $usermatch){
            $row['id'] = $usermatch->id;
            $row['match'] = array(
                'id' => $usermatch->match->id,
                'command_1' => $usermatch->match->command_1,
                'command_2' => $usermatch->match->command_2,
                'date' => $usermatch->match->date
            );
            $console[] = $row;
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionCreate(){
        $consoles=$this->getInputAsJson();
        $model = new UserMatch();
        $model->setAttributes($consoles[self::JSON_RESPONSE_ROOT_SINGLE], false);
        $usermatch = array(self::JSON_RESPONSE_ROOT_SINGLE => $model);
        if (!$model->save()) {
            $this->sendResponse(401);
        }
        $this->sendResponse(200, CJSON::encode($usermatch));
    }
    
    public function actionGet($id){
        $usermatch = UserMatch::model()->findByPk($id);
        
        $row = [];
        $row['id'] = $id;
        $row['match'] = [
            'id' => $usermatch->match->id,
            'command_1' => $usermatch->match->command_1,
            'command_2' => $usermatch->match->command_1,
            'date' => $usermatch->match->date,
            'stadion' => $usermatch->match->stadion->name,
        ];
        $row['command'] = $usermatch->command;
        $row['type_place_viewing'] = $usermatch->type_place_viewing;
        $row['place_viewing'] = $usermatch->place_viewing;
        
        $usermatch = array(self::JSON_RESPONSE_ROOT_SINGLE => $row);
        $this->sendResponse(200, CJSON::encode($usermatch));
    }
    
    public function actionUpdate($id){
        $consoles=$this->getInputAsJson();
        $model = UserMatch::model()->findByPk($id);
        $model->setAttributes($consoles[self::JSON_RESPONSE_ROOT_SINGLE], false);
        $usermatch = array(self::JSON_RESPONSE_ROOT_SINGLE => $model);
        if (!$model->save()) {
            $this->sendResponse(401);
        }
        $this->sendResponse(200, CJSON::encode($usermatch));
    }
 
}
