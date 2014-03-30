<?php
/* @var $this CommandsController */
/* @var $model Commands */

$this->breadcrumbs=array(
	'Commands'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Commands', 'url'=>array('create')),
	array('label'=>'View Commands', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Commands', 'url'=>array('index')),
);
?>

<h1>Update Commands <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>