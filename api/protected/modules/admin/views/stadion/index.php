<h1>Стадионы</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'stadion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
                    'name' => 'id',
                    'headerHtmlOptions' => array('width' => '20px'),
                    'filter' => false
                ),
		'name',
		'address',
		array(
			'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
		),
	),
)); ?>
