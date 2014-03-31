<?php
return [
    array('api/user/login',      'pattern'=>'api/user/login',            'verb'=>'GET'),
    array('api/user/logout',     'pattern'=>'api/user/logout',           'verb'=>'GET'),
    array('<controller>/delete', 'pattern'=>'<controller:\w+>/<id:\d+>', 'verb'=>'DELETE'),
    array('<controller>/update', 'pattern'=>'<controller:\w+>/<id:\d+>', 'verb'=>'PUT'),
    array('<controller>/list',   'pattern'=>'<controller:\w+>',          'verb'=>'GET'),
    array('<controller>/get',    'pattern'=>'<controller:\w+>/<id:\d+>', 'verb'=>'GET'),
    array('<controller>/create', 'pattern'=>'<controller:\w+>',          'verb'=>'POST'),
    
];
