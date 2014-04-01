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
        echo '{"match": ' .CJSON::encode($this->CreationRowMatch($match)).'}';
        Yii::app()->end();
    }
    
    private function CreationRowMatch($match){
        $row = array();
        $row['id'] = $match->id;
        $row['command_1'] = $match->command_1->name;
        $row['command_2'] = $match->command_2->name;
        $row['date'] = $match->date;
        return $row;
    }
}