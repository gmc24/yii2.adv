<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'avatar',
                'content' => function (\common\models\User $model) {
                    return Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_THUMB));
                }],
            'username',
            'email:email',
            ['attribute' => 'status',
                'filter' => \common\models\User::STATS_LABELS,
                'value' => function(\common\models\User $model) {
                    return \common\models\User::STATS_LABELS[$model->status];
                }],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
