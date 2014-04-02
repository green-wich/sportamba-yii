<?php
/* @var $this StadionController */
/* @var $model Stadion */

$this->breadcrumbs=array(
	'Stadions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Stadion', 'url'=>array('index')),
	array('label'=>'Create Stadion', 'url'=>array('create')),
	array('label'=>'View Stadion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Stadion', 'url'=>array('admin')),
);
?>

<h1>Update Stadion <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>