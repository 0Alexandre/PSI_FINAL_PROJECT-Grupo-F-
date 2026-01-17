<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
                'path' => '/projeto_final/backend/web',
            ],
        ],
        'session' => [
            'name' => 'advanced-backend',
            'cookieParams' => [
                'path' => '/projeto_final/backend/web',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/matematica',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET raizdois' => 'raizdois',
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/reserva',
                    'pluralize' => false,
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/anuncio',
                        'api/condominio',
                        'api/default',
                        'api/espaco-comum',
                        'api/faq',
                        'api/fracao',
                        'api/mensagem',
                        'api/perfil',
                        'api/user',
                    ],
                    'pluralize' => false,
                ],
            ],
        ],
    ],

    'layout' => 'main-adminlte',

    'params' => $params,
];
