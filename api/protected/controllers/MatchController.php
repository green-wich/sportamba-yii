<?php

class MatchController extends Controller
{
    const JSON_RESPONSE_ROOT_SINGLE='match';
    const JSON_RESPONSE_ROOT_PLURAL='matches';
    
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "status=1";
        $matches = Match::model()->findAll($criteria);
        $console = array();
        foreach ($matches as $match){
            $console[] = $this->CreationRowMatch($match);
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionGet($id){
        $match = Match::model()->findByPk($id);
        $row = $this->CreationRowMatch($match);
        $row['stadion'] = array(
            'name' => $match->stadion->name,
            'lat' => $match->stadion->lat,
            'long' => $match->stadion->long,
        );
        $result = array(self::JSON_RESPONSE_ROOT_SINGLE => $row);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    private function CreationRowMatch($match){
        $row = array();
        $row['id'] = $match->id;
        $row['command_1'] = $match->command_1;
        $row['command_2'] = $match->command_2;
        $row['date'] = Yii::app()->dateFormatter->format('dd/MM/yyyy', strtotime($match->date));
        return $row;
    }
}