<?php

use yii\helpers\Html;

/**
/* @var $this yii\web\View */
/* @var $project \common\models\Project */
/* @var $user common\models\User */
/* @var $role string */

?>
<h2>Hello <?= Html::encode($user->username) ?>,</h2>

<p>You just have assigned as <strong><?=$role ?></strong> in the <strong><?=$project->title ?></strong> project</p>.
