<?php

class UsermatchController extends Controller
{
    
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
        echo '{"matches": ' . CJSON::encode($row).'}';
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
    
}
