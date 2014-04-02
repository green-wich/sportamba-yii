<?php
Yii::app()->clientScript->registerScriptFile('//maps.googleapis.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($this->getModule()->assets . '/js/google_dynamic_map.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($this->getModule()->assets . '/js/map.js', CClientScript::POS_END);
?>
<div class="form">
    
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_VERTICAL,
    'id'=>'stadion-form',
    'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<?php echo $form->textFieldControlGroup($model,'name',array()); ?>
	</div>

	<div class="row">
		<?php echo $form->textFieldControlGroup($model,'address',array('id'=>'address')); ?>
	</div>
        
        <div class="row">
            <?php echo TbHtml::button('Поиск на карте', array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'class'=>'show-map')); ?>
        </div>
    
    <div class="row" style="width: 450px">
            <?php echo $form->hiddenField($model, 'lat', array('id'=>"lat")); ?>
            <?php echo $form->hiddenField($model, 'long', array('id'=>"long")); ?>
            <?php if($form->error($model,'lat') || $form->error($model,'long')) 
                    echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, $form->error($model,'lat') ?  $form->error($model,'lat') : $form->error($model,'long')); ?>
            
            <div id="map_canvas">

            </div>
            
            <div id="not_found" style="display: none;"><?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, 'Адрес не найден, проверьте еще раз!'); ?></div>
        </div>

        <div class="row">
            <?php echo TbHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->