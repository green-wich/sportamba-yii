<?php

class MatchController extends AdminController
{
	public $layout = 'crud_layout';

	public function actionCreate()
	{
		$model=new Match;

		if(isset($_POST['Match']))
		{
			$model->attributes=$_POST['Match'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Match']))
		{
			$model->attributes=$_POST['Match'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	
	public function actionIndex()
	{
		$model=new Match('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Match']))
			$model->attributes=$_GET['Match'];
                
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Match::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='match-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionUpdateStatus($id, $status){
             Match::model()->updateByPk($id, array('status' => $status));
             $this->redirect(array('index'));
         }
}
