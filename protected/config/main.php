<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => 'Кталог книг',
    'defaultController' => 'book',
    'language' => 'ru',
    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'ipFilters' => array('127.0.0.1','::1'),
        ),
    ),

    'components' => array(

        'user' => array(
            'allowAutoLogin' => true,
        ),

        'sms' => array(
           'class' => 'application.components.SmsService',
           'apiKey' => 'AW8HWBA09C41RI2H5K50835BGSJY1SIH5J87V4O8BL51I1B1SO6SWHKH7I766VA7'
        ),


        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'appendParams' => false,
            'rules' => array(
                '' => 'book/index',
                'books/top' => 'book/top',
                'books/subscribe' => 'book/subscribe',

                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),


        'db' => require(dirname(__FILE__).'/database.php'),

        'errorHandler' => array(
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),

    ),

    'params' => array(
        'adminEmail' => 'webmaster@example.com',
    ),
);
