<?php

use yii\helpers\Html;

/**
/* @var $this yii\web\View */
/* @var $project \common\models\Project */
/* @var $user common\models\User */
/* @var $role string */

?>

Hello <?= Html::encode($user->username) ?>,

You just have assigned as <?=$role ?> in the <?=$project->title ?> project.
