<?php
/* @var $this MatchController */
/* @var $model Match */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'match-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_command1'); ?>
            <?php
                $all_post = Commands::All();
            
                $this->widget('ext.select2.ESelect2',array(
                    'model'=>$model,
                    'attribute'=>'id_command1',
                    'data'=>$all_post,
                    'options'  => array(
                        'width' => '300px',
                        'display'=> 'inline-block',
                    )
                ));     
                ?>
		<?php echo $form->error($model,'id_command1'); ?> <br />
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_command2'); ?>
                <?php
                $this->widget('ext.select2.ESelect2',array(
                    'model'=>$model,
                    'attribute'=>'id_command2',
                    'data'=>$all_post,
                    'options'  => array(
                        'width' => '300px',
                        'display'=> 'inline-block',
                    )
                ));     
                ?>
		<?php echo $form->error($model,'id_command2'); ?><br />
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
                <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $this->widget('CJuiDateTimePicker',array(
                        'model'=>$model, 
                        'attribute'=>'date', 
                        'mode'=>'datetime', 
                        'language'=>'ru',
                        'options'=>array() 
                    ));
                ?>
		<?php echo $form->error($model,'date'); ?>
	</div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'url'); ?>
            <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'url'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'text'); ?>
            <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'img'); ?>
            <?php echo $form->textField($model,'img',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'img'); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->