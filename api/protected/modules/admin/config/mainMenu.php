<?php

return array(
    array(
        'label' => 'Команды',
        'plain' => false,
        'items' => array(
            array(
                'label' => 'Список команд',
                'url' => array('/admin/command/index'),
                'activateOn' => array(
                    array('route' => '/admin\/command\/index/',),
                ),
            ),
            array(
                'label' => 'Создание команды',
                'url' => array('/admin/command/create'),
                'activateOn' => array(
                    array('route' => '/admin\/command\/create/',),
                ),
            ),
        ),
    ),
    array(
        'label' => 'Матчи',
        'plain' => false,
        'items' => array(
            array(
                'label' => 'Список матчей',
                'url' => array('/admin/match/index'),
                'activateOn' => array(
                    array('route' => '/admin\/match\/index/',),
                ),
            ),
            array(
                'label' => 'Добавить матч',
                'url' => array('/admin/match/create'),
                'activateOn' => array(
                    array('route' => '/admin\/match\/create/',),
                ),
            ),
        ),
    ),
    
);