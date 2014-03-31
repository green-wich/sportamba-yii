<?php

class UserController extends Controller
{
    public function actionCreate(){
       // $user = $this->getInputAsJson();
        $userInput = $_REQUEST;
        $username = $userInput['username'];
        
        $user = User::model()->findByAttributes(['username' => $username]);
        
        if($user){
            return $user->login();
        }else{
            $model = new User;
            $model->username = $username;
            $model->password = $userInput['password'];
            $model->status = 1;
            if($model->save()){
                return $model->login ();
            }
            else 
                return false;
        }
    }
    
    public function actionGet($id){
        $user = User::model()->findByPk($id);
        echo '{"user": ' . CJSON::encode($user) . '}';
        Yii::app()->end();
    }
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
    }
    
}

