<?php
/* @var $this CommandsController */
/* @var $model Commands */

$this->breadcrumbs=array(
	'Commands'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Commands', 'url'=>array('index')),
	array('label'=>'Manage Commands', 'url'=>array('admin')),
);
?>

<h1>Create Commands</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>