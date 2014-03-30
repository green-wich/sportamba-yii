<?php
/**
 * @var AdminController $this
 * @var string $code
 * @var string $message
 */
$this->pageTitle = 'Панель управления - Ошибка!';
$this->breadcrumbs = array(
    'Ошибка',
);
?>

<h1>Ошибка! <?php echo $code; ?></h1>


<p><?php echo CHtml::encode($message); ?></p>
<?php echo CHtml::link('На главную страницу', array('default/index')) ?>