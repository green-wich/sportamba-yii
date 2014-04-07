<?php

class UserController extends AdminController
{
    public function actionIndex(){
        $users=new CActiveDataProvider('User', array(
            'criteria'=>array(
                'condition'=>'id!=1',
                'order'=>'created_at DESC',
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
        $this->render('index',array(
			'model'=>$users,
		));
    }
}

