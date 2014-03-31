<?php

class UserController extends Controller
{
    public function actionCreate(){
       // $user = $this->getInputAsJson();
        $user = $_REQUEST;
        $model = new User;
        $model->username = $user['username'];
        $model->password = $user['password'];
        $model->status = 1;
        if($model->save())
            return true;
        else 
            return false;
    }
    
}

