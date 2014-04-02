<?php

class StadionController extends AdminController
{
	public $layout = 'crud_layout';
        
	public function actionCreate()
	{
		$model=new Stadion;

		if(isset($_POST['Stadion']))
		{
			$model->attributes=$_POST['Stadion'];
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

		if(isset($_POST['Stadion']))
		{
			$model->attributes=$_POST['Stadion'];
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
		$model=new Stadion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stadion']))
			$model->attributes=$_GET['Stadion'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Stadion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stadion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
