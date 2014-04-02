<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
     <meta charset="utf-8">
    <?php Yii::app()->bootstrap->register(); ?>
    <style type="text/css">
        body {
            padding-top: <?php echo empty($this->module->sectionMenu) ? '60px' : '96px'?>;
            /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link rel="stylesheet" href="<?php echo $this->getModule()->assets . '/css/admin.css'?>"/>
    <title><?php echo $this->pageTitle;?></title>
    <link rel="shortcut icon" href="<?php echo $this->getModule()->assets;?>/favicon.ico"/>

</head>
<body>
<div class="navbar navbar-fixed-top" style="z-index: 1031;">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <?php echo CHtml::link("Админка " . Yii::app()->name, array('/admin/default/index'), array('class' => 'brand'))?>

            <div class="nav-collapse">
                <?php
                $this->widget('BHorizontalMenu', array(
                    'items' => $this->module->mainMenu,
                ));
                ?>
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#"
                           class="dropdown-toggle"
                           data-toggle="dropdown">Админ
                            <?php // echo Yii::app()->user->fullName ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo CHtml::link('Управление пользователями', array('/admin/user/admin'))?></li>
                        </ul>
                    </li>
                    <li class="divider-vertical"></li>

                    <li><?php echo CHtml::link('Выход', array('/admin/default/logout'))?></li>
                </ul>
            </div>


            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<?php if (!empty($this->module->sectionMenu)): ?>
<div class="subnav subnav-fixed">
    <?php
    $this->widget('BHorizontalMenu', array(
        'items' => $this->module->sectionMenu,
        'class' => 'nav nav-pills',
        'style' => 'width:1170px;',
    ));
    ?>
</div>
    <?php endif;?>

<?php echo $content ?>
</body>
</html>