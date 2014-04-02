<?php
/* @var $this MatchController */
/* @var $model Match */

$this->breadcrumbs=array(
	'Matches'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Match', 'url'=>array('index')),
	array('label'=>'Create Match', 'url'=>array('create')),
	array('label'=>'Update Match', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Match', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Match', 'url'=>array('admin')),
);
?>

<h1>View Match #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_command1',
		'id_command2',
		'date',
		'status',
	),
)); ?>
