

<h1>Матчи</h1>

<?php $this->widget('BGridView',
    array(
        'id' => 'employee-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns'=>array(
		'id'=> array(
                    'name' => 'id',
                    'headerHtmlOptions' => array('width' => '30px'),
                    'filter' => false
                ),
		'id_command1',
		'id_command2',
		'date',
		'status',
		array(
			'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
		),
	),
    )); ?>


