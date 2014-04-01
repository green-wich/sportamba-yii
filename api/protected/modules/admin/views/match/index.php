

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
		'command_1',
		'command_2',
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


