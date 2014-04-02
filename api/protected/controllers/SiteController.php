<?php

class SiteController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
            )
        );
    }
	
    public function actionIndex()
    {
        $this->sendResponse(401, 'Unauthorized');
        Yii::app()->end();
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            echo CJSON::encode($error);
            Yii::app()->end();
        }
    }

}