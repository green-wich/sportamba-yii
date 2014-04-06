<?php

class Command extends CActiveRecord
{
        const PATH_TO_IMG = "/../../uploads/commands/";
    
        public function tableName()
	{
		return '{{command}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => '#',
			'name' => 'Название команды',
			'img' => 'Логотип',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('img',$this->img,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                          'defaultOrder'=>array(
                          'id'=>"DESC"
                  ))
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function all()
        {
            return CHtml::listData(self::model()->findAll(array('order'=>'id DESC')), 'id', 'name');
        }
        
        public function afterSave() {
            $this->addImages();
            return parent::afterSave();
        }
        
        public function beforeSave() {
            if (!$this->isNewRecord){
                self::deleteImages(Yii::app( )->getBasePath( )."/../../uploads/commands/" . $this->id . '/');
            }
            return parent::beforeSave();
        }
        
        public function addImages(){
            if( Yii::app( )->user->hasState( 'images' ) ) {
                $userImages = Yii::app( )->user->getState( 'images' );
                
                $basePath = Yii::app()->getBasePath() . self::PATH_TO_IMG;
                $path = $basePath . $this->id . "/";
                self::createDir($path);
                $thumb_path = $path . "thumb/";
                self::createDir($thumb_path);
                
                foreach( $userImages as $image ) {
                    if( is_file( $image["path"] ) ) {
                        if( rename( $image["path"], $path.$image["filename"] ) ) {
                            chmod( $path.$image["filename"], 0777 );
                        }  
                        $thumbs = $image["thumb"];
                        if(rename($thumbs, $thumb_path.$image["filename"])){
                            chmod( $thumb_path.$image["filename"], 0777 );
                        }
                        // save to db
                        self::model()->updateByPk($this->id, array(
                            'img' => $image["filename"],
                        ));
                        $thumbs_images = array(
                            array('width'=>180, 'height'=>140, 'folder'=>$thumb_path . '180_140_'.$image["filename"])
                        );
                        $this->manipulate($thumbs_images, $path.$image["filename"]);
                    } else {
                        //You can also throw an execption here to rollback the transaction
                        Yii::log( $image["path"]." is not a file", CLogger::LEVEL_WARNING );
                    }
                }
            }
            //Clear the user's session
            Yii::app( )->user->setState( 'images', null );
        }
        
        public function manipulate($thumbs_images, $path)
        {
            foreach ($thumbs_images as $img){
                $image = Yii::app()->image->load($path);
                $image->smart_resize($img['width'], $img['height'])->quality(95)->sharpen(20);
                $image->save($img['folder']);
                chmod( $img['folder'], 0777 );
            }
        }
        
        public function beforeDelete()
        {
            self::deleteImages(Yii::app( )->getBasePath( ). self::PATH_TO_IMG . $this->id . '/', TRUE);
            return parent::beforeDelete();
        }
        
        public static function deleteImages($dir, $deleteDir = FALSE){
            if (is_dir($dir)) {
                $list = self::scanDir($dir);
                foreach ($list as $file)
                {
                    if (is_dir($dir.$file)){
                        self::deleteImages($dir.$file.'/', $deleteDir);
                    }else{
                        unlink($dir.$file);
                    }
                }
                if($deleteDir) rmdir($dir);
            }
        }
        
        public static function scanDir($dir){
            $list = scandir($dir);
            unset($list[0],$list[1]);
            return array_values($list);
        }
        
        public static function createDir($path){
            if( !is_dir( $path ) )
                mkdir( $path, 0777, TRUE );
        }
}
