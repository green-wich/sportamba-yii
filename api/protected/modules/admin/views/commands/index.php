
<h1>Комманды</h1>
<?php $this->widget('BGridView',
    array(
        'id' => 'command-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns'=>array(
		array(
                    'name' => 'id',
                    'headerHtmlOptions' => array('width' => '20px'),
                    'filter' => false
                ),
		'name',
		'description',
		'img',
		array(
			'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
		),
	),
    )); ?>
