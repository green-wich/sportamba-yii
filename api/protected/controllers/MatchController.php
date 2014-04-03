<?php

class MatchController extends Controller
{
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "status=1";
        $matches = Match::model()->findAll($criteria);
        $matchesToJson = array();
        foreach ($matches as $match){
            $matchesToJson[] = $this->CreationRowMatch($match);
        }
        echo '{"matches": ' .CJSON::encode($matchesToJson).'}';
        Yii::app()->end();
    }
    
    public function actionGet($id){
        $match = Match::model()->findByPk($id);
        $row['id'] = $match->id;
        $row['command_1'] = array(
            'id' => $match->command_1->id,
            'name' => $match->command_1->name,
            'image' => $match->command_1->img
        );
        $row['command_2'] = array(
            'id' => $match->command_1->id,
            'name' => $match->command_2->name,
            'image' => $match->command_2->img
        );
        $row['date'] = $match->date;
        $row['stadion'] = array(
            'name' => $match->stadion->name,
            'lat' => $match->stadion->lat,
            'long' => $match->stadion->long,
        );
        echo '{"match": ' .CJSON::encode($row).'}';
        Yii::app()->end();
    }
    
    private function CreationRowMatch($match){
        $row = array();
        $row['id'] = $match->id;
        $row['command_1'] = $match->command_1;
        $row['command_2'] = $match->command_2;
        $row['date'] = $match->date;
        return $row;
    }
}