<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SPORTAMBA',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
    
        'aliases' => array(
            'xupload' => 'ext.xupload'
        ),

	'modules'=>array(
            
		'admin',
            
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1')
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
            
                'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                    'driver'=>'GD',
                    'params'=>array('directory'=>'/opt/local/bin'),
                ),
		// uncomment the following to enable URLs in path-format
		
                'hybridAuth'=>array(
                    'class'=>'ext.hybridAuth.CHybridAuth',
                    'enabled'=>true, // enable or disable this component
                    'config'=>array(
                         "base_url" => "http://". $_SERVER['HTTP_HOST'] ."/api/user/endpoint/", 
                         "providers" => array(
                               "Facebook" => array(
                                    "enabled" => true,
                                    "keys" => array("id" => "1473590889527791", "secret" => "3aae795dbaca2c02b735ac998ec5900c"),
                                ),
                               "Twitter" => array(
                                    "enabled" => true,
                                    "keys" => array("key" => "fWtblSRusCXOmu2K7kXVhw", "secret" => "MclNDKsjSXd0tJrgZ157DtRWr2BwNAFEURMg0zo0k4Y")
                               ),
                               "Vkontakte" => array ( 
                                        "enabled" => true,
                                        "keys"    => array ( "id" => "4210391", "secret" => "b2IAUDo82cBGiUw2zI8r" ), 
                                ),
                         ),
                         "debug_mode" => false,
                         "debug_file" => "",
                     ),
                 ),//end hybridAuth
            
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>require(dirname(__FILE__).'/routes.php'),
                        'showScriptName' => false,
		),
            
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sportamba-yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
                        'tablePrefix' => 'sport_'
		),
            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);