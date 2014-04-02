<?php
/* @var $this StadionController */
/* @var $model Stadion */

$this->breadcrumbs=array(
	'Stadions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Stadion', 'url'=>array('index')),
	array('label'=>'Create Stadion', 'url'=>array('create')),
	array('label'=>'Update Stadion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Stadion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stadion', 'url'=>array('admin')),
);
?>

<h1>View Stadion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'lat',
		'long',
	),
)); ?>
