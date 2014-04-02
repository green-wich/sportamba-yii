<?php
Yii::app()->clientScript->registerScriptFile('//maps.googleapis.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/app.js', CClientScript::POS_END);
?>
<div class="form">
    
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_VERTICAL,
    'id'=>'stadion-form',
    'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<?php echo $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->textFieldControlGroup($model,'address',array('size'=>60,'maxlength'=>200)); ?>
	</div>

        <div class="row">
            <?php echo TbHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->