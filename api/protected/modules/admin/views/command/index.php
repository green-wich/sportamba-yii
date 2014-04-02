<h1>Команды</h1>
<?php $this->widget('bootstrap.widgets.TbGridView',
    array(
        'id' => 'command-grid',
        'type' => TbHtml::GRID_TYPE_BORDERED,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns'=>array(
		array(
                    'name' => 'id',
                    'headerHtmlOptions' => array('width' => '20px'),
                    'filter' => false
                ),
		'name',
                array(
                    'name'=>'img',
                    'type'=>'image',
                    'value'=> '"/uploads/commands/" . $data->id . "/thumb/180_140_" . $data->img',
                    'filter'=>'',
                    'headerHtmlOptions'=>array('width'=>'180px'),
                ),
		array(
			'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
		),
	),
    )); ?>
