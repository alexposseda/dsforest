<?php
return [
    'name' => 'DsForestTrade',
    'language' => 'en',
    'sourceLanguage' => 'en',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en', 'ru', 'fr', 'de', 'it', 'pl', 'cs'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                ],
                'info' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations'
                ],
                'error' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations'
                ],
                'success' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations'
                ],
            ],
        ],
    ],
];
