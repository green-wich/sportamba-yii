<?php
/**
 * @var AdminController $this
 * @var AdminUser $model
 */
$this->pageTitle = 'Вход в систему управления сайтом';
$cs = Yii::app()->getClientScript();
$cs->registerCss('login_styles', "
.login{
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -135px;
        margin-left: -180px;
    }
");
$cs->registerCssFile($this->getModule()->assets . '/bootstrap/css/bootstrap.css');
$cs->registerCssFile($this->getModule()->assets . '/bootstrap/css/bootstrap-responsive.css');
?>

<div class="container-fluid">
    <?php
    /**
     * @var CActiveForm $form
     */
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'class' => 'form-horizontal login well'
        )));
    ?>
    <fieldset>
        <legend>Введите регистрационные данные</legend>

        <div class="control-group<?php if ($model->hasErrors('username')) echo ' error'?>">
            <?php echo $form->label($model, 'username', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'username', array('class' => 'input-medium')); ?>
            </div>
        </div>

        <div class="control-group<?php if ($model->hasErrors('password')) echo ' error'?>">
            <?php echo $form->label($model, 'password', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($model, 'password', array('class' => 'input-medium')); ?>
            </div>
        </div>
        <div class="control-group">

            <?php echo $form->label($model, 'rememberMe', array('class' => 'control-label')); ?>

            <div class="controls">
                <?php echo $form->checkBox($model, 'rememberMe'); ?>
            </div>
        </div>

        <div class="form-actions" style="margin-bottom: 0; padding-bottom: 0">
            <button type="submit" class="btn btn-large btn-primary">Вход</button>
        </div>
    </fieldset>
    <?php
    $this->endWidget();
    ?>
</div>