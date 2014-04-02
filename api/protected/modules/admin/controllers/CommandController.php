<?php

class CommandController extends Controller
{
        public $layout = 'crud_layout';
	
	public function actionCreate()
	{
		$model=new Command;
                
                Yii::import( "xupload.models.XUploadForm" );
                $photos = new XUploadForm;

		if(isset($_POST['Command']))
		{
			$model->attributes=$_POST['Command'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
                        'photos' => $photos,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                
                Yii::import( "xupload.models.XUploadForm" );
                $photos = new XUploadForm;

		if(isset($_POST['Command']))
		{
			$model->attributes=$_POST['Command'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
                        'photos' => $photos,
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
		$model=new Command('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Command']))
			$model->attributes=$_GET['Command'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
	public function loadModel($id)
	{
		$model=Command::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='command-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionDeleteImg($id) {
            $command = Command::model()->findByPk($id);
            $command->img = '';
            $command->save();
            $this->redirect(array('update', 'id' => $id));
        }
        
        public function actionUpload() 
        {
            Yii::import( "xupload.models.XUploadForm" );
            //Here we define the paths where the files will be stored temporarily
            $path = Yii::app( )->getBasePath( )."/../../uploads/commands/tmp/";
            $publicPath = Yii::app( )->getBaseUrl( )."/../uploads/commands/tmp/";

            //This is for IE which doens't handle 'Content-type: application/json' correctly
            header( 'Vary: Accept' );
            if( isset( $_SERVER['HTTP_ACCEPT'] ) 
                && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
                header( 'Content-type: application/json' );
            } else {
                header( 'Content-type: text/plain' );
            }

            //Here we check if we are deleting and uploaded file
            if( isset( $_GET["_method"] ) ) {
                if( $_GET["_method"] == "delete" ) {
                    if( $_GET["file"][0] !== '.' ) {
                        $file = $path.$_GET["file"];
                        if( is_file( $file ) ) {
                            unlink( $file );
                        }
                        $thumbs = $path.'thumb/'.$_GET["file"];
                        if( is_file( $thumbs ) ) {
                            unlink( $thumbs );
                        }
                    }
                    echo json_encode( true );
                }
            } else {
                $model = new XUploadForm;
                $model->file = CUploadedFile::getInstance( $model, 'img' );
            
                //We check that the file was successfully uploaded
                if( $model->file !== null ) {
                    //Grab some data
                    $model->mime_type = $model->file->getType( );
                    $model->size = $model->file->getSize( );
                    $model->name = $model->file->getName( );
                    $name = $model->name;
                    //(optional) Generate a random name for our file
                    $filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
                    $filename .= ".".$model->file->getExtensionName( );
                    if( $model->validate( ) ) {
                        //Move our file to our temporary dir
                        $model->file->saveAs( $path.$filename );
                        chmod( $path.$filename, 0777 );
                        
                        $image = Yii::app()->image->load($path.$filename);
                        $image->smart_resize(110, 80)->quality(95)->sharpen(20);
                        $image->save($path.'thumb/'.$filename); 
                        chmod( $path.'thumb/'.$filename, 0777 );
                        
                      //  $imgState = $upload;
                        if( Yii::app( )->user->hasState( 'images' ) ) {
                            $userImages = Yii::app( )->user->getState( 'images' );
                        } else {
                            $userImages = array();
                        }
                         $userImages[] = array(
                            "path" => $path.$filename,
                            //the same file or a thumb version that you generated
                            "thumb" => $path.'thumb/'.$filename,
                            "filename" => $name,
                            'size' => $model->size,
                            'mime' => $model->mime_type,
                            'name' => $model->name,
                        );
                        
                        Yii::app( )->user->setState( 'images', $userImages );
                        
                        echo json_encode( array( array(
                                "name" => $model->name,
                                "type" => $model->mime_type,
                                "size" => $model->size,
                                "url" => $publicPath.$filename,
                                "thumbnail_url" => $publicPath."thumb/$filename",
                                "delete_url" => $this->createUrl( "upload", array(
                                    "_method" => "delete",
                                    "file" => $filename
                                ) ),
                                "delete_type" => "POST"
                            ) ) );
                    } else {
                        //If the upload failed for some reason we log some data and let the widget know
                        echo json_encode( array( 
                            array( "error" => $model->getErrors( 'file' ),
                        ) ) );
                        Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                            CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" 
                        );
                    }
                } else {
                    throw new CHttpException( 500, "Could not upload file" );
                }
            }
        }        
}
