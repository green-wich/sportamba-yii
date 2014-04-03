<?php

class ConnectionController extends Controller
{
    const JSON_RESPONSE_ROOT_SINGLE='connection';
    const JSON_RESPONSE_ROOT_PLURAL='connections';
    
    public function actionCreate(){
        $consoles=$this->getInputAsJson();
        $model = new Connection();
        $model->setAttributes($consoles[self::JSON_RESPONSE_ROOT_SINGLE], false);
        if (!$model->save()) {
            $this->sendResponse(401);
        }
        $this->sendResponse(200, TRUE);
    }
    
    public function actionList(){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id_1=".Yii::app()->user->id;
        $connections = Connection::model()->findAll($criteria);
        $row = array();
        $console = array();
        foreach ($connections as $connection){
            $row['id'] = $connection->user_id_2;
            $row['name'] = $connection->user2->getFullName();
            $row['photoUrl'] = $connection->user2->profile->photoUrl;
            $console[] = $row;
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
}

