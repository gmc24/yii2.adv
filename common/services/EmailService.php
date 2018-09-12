<?php

namespace common\services;

use yii\base\Component;
use Yii;

class EmailService extends Component
{
    public function send($to. $subject, $views, $data) {
        \Yii::$app
->mailer
->compose($views, $data)
    -> setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
    ->sendTo($to)
    ->sendSubject($subject)
    ->send();
    }
}