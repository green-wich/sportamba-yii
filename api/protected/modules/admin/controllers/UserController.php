<?php

class UserController extends AdminController
{
    public function actionIndex(){
        $model=new Login('search');
        $model->unsetAttributes();
        $model->profile = new UserProfile('search');
        
        if(isset($_GET['User']))
                $model->attributes=$_GET['User'];
        $this->render('index',array(
			'model'=>$model,
		));
    }
}

