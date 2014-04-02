<h1>Стадионы</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'stadion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'address',
		'lat',
		'long',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
