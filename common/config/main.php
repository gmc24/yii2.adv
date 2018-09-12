<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            "on ". \common\services\ProjectService::EVENT_ASSIGN_ROLE => function(\common\services\AssignRoleEvent $e){
                Yii::$app->emailService->send($e->user->email, 'New role', );
            }
        ],
    ],
    'modules' => [
        'rchat' => [
            'class' => 'common\modules\rchat\Module',
        ],
    ],
];
