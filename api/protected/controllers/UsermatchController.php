<?php

class UsermatchController extends Controller
{
    const JSON_RESPONSE_ROOT_SINGLE='usermatch';
    const JSON_RESPONSE_ROOT_PLURAL='usermatches';
   
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id=".Yii::app()->user->id;
        
        $usermatches = UserMatch::model()->findAll($criteria);
        foreach ($usermatches as $usermatch){
            $row[] = [
                'id' => $usermatch->id,
                'match' => [
                    'id' => $usermatch->match->id,
                    'command_1' => $usermatch->match->command_1->name,
                    'command_2' => $usermatch->match->command_2->name,
                    'date' => $usermatch->match->date,
                ]
            ];
        }
        echo '{"usermatches": ' . CJSON::encode($row).'}';
        Yii::app()->end();
    }
    
    public function actionCreate(){
        $params = $_REQUEST;
        
        $usermatch = new UserMatch;
        $usermatch->match_id = $params['match_id'];
        $usermatch->user_id = Yii::app()->user->id;
        $usermatch->command_id = $params['command_id'];
        $usermatch->type_place_viewing = $params['type_place_viewing'];
        $usermatch->place_viewing = $params['place_viewing'];
        
        if($usermatch->save()){
            $this->sendResponse(200, TRUE);
        }
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
        
        echo '{"usermatch": ' . CJSON::encode($row).'}';
        Yii::app()->end();
    }
    
    public function actionUpdate($id){
        $consoles=$this->getInputAsJson();
        $model = UserMatch::model()->findByPk($id);
        $model->setAttributes($consoles[self::JSON_RESPONSE_ROOT_SINGLE], false);
        $data = $this->getInputAsJson();
        $usermatch = UserMatch::model()->findByPk($id);
        
        

    }
 
}
