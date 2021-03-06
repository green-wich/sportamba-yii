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

	<?php //echo $form->errorSummary($model); ?>
    
        <div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
                <?php
                    Yii::import('admin.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
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
		<?php echo $form->labelEx($model,'id_command_1'); ?>
            <?php
                $all_post = Command::All();
            
                $this->widget('admin.extensions.select2.ESelect2',array(
                    'model'=>$model,
                    'attribute'=>'id_command_1',
                    'data'=>$all_post,
                    'options'  => array(
                        'width' => '300px',
                        'display'=> 'inline-block',
                    )
                ));     
                ?>
		<?php echo $form->error($model,'id_command_1'); ?> <br />
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_command_2'); ?>
                <?php
                $this->widget('admin.extensions.select2.ESelect2',array(
                    'model'=>$model,
                    'attribute'=>'id_command_2',
                    'data'=>$all_post,
                    'options'  => array(
                        'width' => '300px',
                        'display'=> 'inline-block',
                    )
                ));     
                ?>
		<?php echo $form->error($model,'id_command_2'); ?><br />
	</div>
    
        <div class="row">
                <?php echo $form->labelEx($model,'stadion_id'); ?>
                <?php
                $this->widget('admin.extensions.select2.ESelect2',array(
                    'model'=>$model,
                    'attribute'=>'stadion_id',
                    'data'=> Stadion::all(),
                    'options'  => array(
                        'width' => '300px',
                        'display'=> 'inline-block',
                    )
                ));     
                ?>
		<?php echo $form->error($model,'id_command_2'); ?><br />
        </div>
    
         <div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array('1'=> 'Опубликовано','0'=>'Неопубликовано')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class"=>"btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->