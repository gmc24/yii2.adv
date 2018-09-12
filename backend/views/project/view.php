<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $users array */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            ['attribute' => 'active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUSES[$model->active];
                }],
            ['attribute' => 'creator.username',
                'label' => 'Creator',
                'format' => 'html',
                'value' => Html::a($users[$model->created_by], ['user/view', 'id' => $model->created_by])],
            ['attribute' => 'updater.username',
                'label' => 'Updater',
                'format' => 'html',
                'value' => Html::a($users[$model->updated_by], ['user/view', 'id' => $model->updated_by])],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>


    <h2>Project Team</h2>
    <?php
    echo \yii\grid\GridView::widget([
        'dataProvider' => $model->getProjectTeam(),
        'layout' => "{items}\n{pager}\n{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'user_id',
                'filter' => $users,
                'label' => 'User',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::a($data->getUserName(), ['user/view', 'id' => $data->user_id]);
                },

            ],
//        'user.username',
            'role:text',
        ],
    ]);
    ?>

</div>
