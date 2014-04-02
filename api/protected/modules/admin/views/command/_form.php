<?php
/* @var $this CommandsController */
/* @var $model Commands */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'command-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
    
        <?php if(empty($model->img)): ?>
        <div class="row" id="single-photo-upload">
        <?php echo $form->labelEx($model,'img'); ?>
            <?php
            $this->widget( 'xupload.XUpload', array(
                'url' => Yii::app( )->createUrl("admin/command/upload", array('upload' => 'single')),
                //our XUploadForm
                'model' => $photos,
                'showForm'=> false,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'single-photo-upload'),
                'attribute' => 'img',
                'multiple' => false,
                )    
            );
            ?>
        </div>
        <?php endif; ?>
            
        <?php if(!empty($model->img)): ?>
        <table class="table table-striped" id="single">
                <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
                    <tr class="template-download fade in">
                        <td class="preview">
                            <?php echo CHtml::image("/uploads/commands/" . $model->id . "/thumb/180_140_" . $model->img, '', array("width"=> "200px")); ?>
                        </td>
                        <td class="delete">
                           <?php  echo CHtml::ajaxLink(
                                'Удалить',
                                $this->createUrl('deleteimg', array('id'=>$model->id)),
                                array(
                                    'update'=>'.form'
                                ),
                                array('class'=>'btn btn-danger')
                            ); 
                           ?>
                        </td>
                    </tr>
                </tbody>
        </table>
        <?php endif; ?>

	<div class="row buttons">
                <?php echo TbHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class"=>"btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->