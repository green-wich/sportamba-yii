<?php

class MatchController extends Controller
{
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "status=1";
        $matches = Match::model()->findAll($criteria);
        echo '{"matches": ' .CJSON::encode($matches).'}';
        Yii::app()->end();
    }
}