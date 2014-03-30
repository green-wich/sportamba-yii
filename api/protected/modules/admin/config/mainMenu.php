<?php

return array(
    array(
        'label' => 'Команды',
        'plain' => false,
        'items' => array(
            array(
                'label' => 'Список команд',
                'url' => array('/admin/commands/index'),
                'activateOn' => array(
                    array('route' => '/admin\/commands\/index/',),
                ),
            ),
            array(
                'label' => 'Создание команды',
                'url' => array('/admin/commands/create'),
                'activateOn' => array(
                    array('route' => '/admin\/commands\/create/',),
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