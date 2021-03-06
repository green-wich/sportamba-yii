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
        $connections = Connection::model()->getMyFriends();
        $console = array();
        foreach ($connections as $connection){
            $console[] = $this->createRow($connection);
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionUsers(){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id_2=".Yii::app()->user->id;
        $connections = Connection::model()->findAll($criteria);
        $console = array();
        foreach ($connections as $connection){
            $console[] = $this->createRow($connection, true);
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionDelete($id){
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id_1=".Yii::app()->user->id." && user_id_2=".$id;
        $result = Connection::model()->deleteAll($criteria);
        if($result)
            $this->sendResponse(200, TRUE);
        else 
            $this->sendResponse(401);
    }
    
    private function createRow($params, $type = false){
        $row['id'] = $type ? $params->user_id_1 : $params->user_id_2;
        $row['name'] = $type ? $params->user1->login[0]->getFullName() : $params->user2->login[0]->getFullName();
        $row['photoUrl'] = $type ? $params->user1->login[0]->profile->photoUrl : $params->user2->login[0]->profile->photoUrl;
        return $row;
    }
    
}

