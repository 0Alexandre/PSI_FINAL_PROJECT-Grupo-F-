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
            // ADAPTAÇÃO: O nome da classe deve bater certo com o ficheiro da imagem (ModuleAPI.php)
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // IMPORTANTE: Adicionado para ler o JSON enviado pelo Android
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
                // --- REGRA 1: Login (AuthController) ---
                // Nota: Cria o ficheiro AuthController.php se ainda não o fizeste
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ],
                ],

                // --- REGRA 2: Reservas (com ação personalizada 'espacos') ---
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/reserva',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET' => 'index',
                        'POST' => 'create',
                        'DELETE {id}' => 'delete',
                        'GET espacos' => 'espacos', // Para o dropdown no Android
                    ],
                ],

                // --- REGRA 3: Restante Controladores da Imagem ---
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/anuncio',
                        'api/condominio',
                        'api/default',      // Estava na imagem
                        'api/espaco-comum', // O Yii converte EspacoComumController para espaco-comum
                        'api/faq',
                        'api/fracao',
                        'api/mensagem',
                        'api/perfil',       // Estava na imagem
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