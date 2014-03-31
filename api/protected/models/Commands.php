<?php

/**
 * This is the model class for table "{{commands}}".
 *
 * The followings are the available columns in table '{{commands}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $img
 */
class Commands extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{commands}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'img' => 'Img',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('img',$this->img,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Commands the static model class
	 */
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
        
        public function addImages( ) 
        {
            if( Yii::app( )->user->hasState( 'images' ) ) {
                $userImages = Yii::app( )->user->getState( 'images' );
                
                $path = Yii::app( )->getBasePath( )."/../../uploads/commands/".$this->id."/";
                if( !is_dir( $path ) ) {
                    mkdir( $path );
                    chmod( $path, 0777 );
                }
                $thumb_path = Yii::app( )->getBasePath( )."/../../uploads/commands/".$this->id."/thumb/";
                if( !is_dir( $thumb_path ) ) {
                    mkdir( $thumb_path );
                    chmod( $thumb_path, 0777 );
                }
                
                foreach( $userImages as $image ) {
                    if( is_file( $image["path"] ) ) {
                        $name = $image["path"];
                        if( rename( $image["path"], $path.$image["filename"] ) ) {
                            chmod( $path.$image["filename"], 0777 );
                        }  
                        $thumbs = $image["thumb"];
                        if(rename($thumbs, $thumb_path.$image["filename"])){
                            chmod( $thumb_path.$image["filename"], 0777 );
                        }
                        
                    
                    // save db
                    $publicPath = "/uploads/commands/".$this->id."/";
                    self::model()->updateByPk($this->id, array(
                        'img' => $image["filename"],
                    ));
                    
                    $thumbs_images = array(
                        array('width'=>180, 'height'=>140, 'folder'=>$path.'thumb/180_140_'.$image["filename"])
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
                $image->save($img['folder']); // or $image->save('images/small.jpg');
            }
        }
}
