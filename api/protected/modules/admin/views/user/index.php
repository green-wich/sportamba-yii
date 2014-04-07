<h1>Пользователи</h1>
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
		array(
                    'name' => 'profile.firstName',
                    'value'=> '$data->profile->firstName . " " . $data->profile->lastName',
                    'filter' => false,
                ),
		'url' => array(
                    'name' => 'url-ссылка',
                    'type' => 'raw',
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    'value'=> function($data) {
                            $url = $data->profile->profileUrl;
                            return CHtml::link($url, $url, array('target'=>'blank'));
                        },
                    'filter' => false,
                ),
//		'photoUrl' => array(
//                   //   'name' => 'Фото',
//                      'type' => 'raw',
//                      'htmlOptions'=>array('style'=>'width:180px;text-align:center'),
//                      'filter' => false, 
//                      'value' => function($data) {
//                            $url = $data->profile->photoUrl;
//                            return CHtml::image($url);
//                    },
//                ),
                'provider' => array(
                      'name' => 'provider',
                      'value' => '$data->provider',
                      'filter' =>  array(''=>'Все', 'Facebook'=>'Facebook', 'Vkontakte'=>'Vkontakte') 
                      
                ),
	),
    )); ?>


