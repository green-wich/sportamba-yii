<?php

class UsermatchController extends Controller
{
    
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id=".Yii::app()->user->id;
        $matches = UserMatch::model()->findAll($criteria);
        echo '{"matches": ' . CJSON::encode($matches).'}';
        Yii::app()->end();
    }
    
    
}

