<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class],
        'taskService' => [
            'class' => \common\services\TaskService::class],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            "on " . \common\services\ProjectService::EVENT_ASSIGN_ROLE => function (\common\services\AssignRoleEvent $e) {
                $views = ['html'=> 'assignRoleToUser-html', 'text' => 'assignRoleToUser-text'];
                $data = ['user' => $e->user, 'project' => $e->project, 'role' => $e->role];
                Yii::$app->emailService->send($e->user->email, 'New role', $views, $data);
            }
        ],
    ],
    'modules' => [
        'rchat' => [
            'class' => 'common\modules\rchat\Module',
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
    ],
];
