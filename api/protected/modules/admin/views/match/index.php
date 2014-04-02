

<h1>Матчи</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',
    array(
        'id' => 'employee-grid',
        'type' => TbHtml::GRID_TYPE_BORDERED,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns'=>array(
		'id'=> array(
                    'name' => 'id',
                    'headerHtmlOptions' => array('width' => '30px'),
                    'filter' => false
                ),
		'id_command_1' => array(
                    'name' => 'id_command_1',
                    'value'=> '$data->command_1->name',
                    'filter' => Command::all(),
                ),
		'id_command_2' => array(
                    'name' => 'id_command_2',
                    'value'=> '$data->command_2->name',
                    'filter' => Command::all(),
                ),
                'stadion_id' => array(
                    'name' => 'stadion_id',
                    'value'=> '$data->stadion->name',
                    'filter' => Stadion::all(),
                ),
		'date' => array(
                    'name' => 'date',
                    'value'=> $model->date,
                    'filter' => false
                ),
		array(
                      'name' => 'status',
                      'type' => 'raw',
                      'htmlOptions'=>array('style'=>'width:80px;text-align:center'),
                      'filter' => array(''=>'Все', 1 => 'Опубликованые', 0=> 'Не опубликованые'), 
                      'value' => function($data) {
                        $url = Yii::app()->controller->createUrl('updatestatus', array('id'=>$data->id, 'status'=>$data->status ? 0 : 1));
                        $src =  ($data->status ? $this->getModule()->assets.'/img/yes.png' : $this->getModule()->assets.'/img/no.png');
                        $title = $data->status ? 'Опубликован' : 'Не опубликован';
                        return CHtml::link(CHtml::image($src), $url, array('title'=>$title));
                    },
                ),
		array(
			'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
		),
	),
    )); ?>


