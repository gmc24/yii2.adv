<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity)) : ?>
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
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'estimation',
            ['attribute' => 'project_id',
                'label' => 'Project',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a($model->project['title'],  ['project/view', 'id' => $model->project_id]);},
            ],
            ['attribute'=>'executor_id',
                'label'=> 'Executor',
                'format' => 'html',
                'value'=>function($data) { return (!$data->executor)? null : Html::a($data->executor['username'], ['user/view', 'id'=>$data->executor->id]);} ],
            'started_at:datetime',
            'completed_at:datetime',
            ['attribute'=>'created_by',
                'label'=>'Creator',
                'format' => 'html',
                'value' => function($data) { return Html::a($data->creator['username'], ['user/view', 'id'=>$data->creator->id]);},
            ],
            ['attribute'=>'updated_by',
                'label'=>'Updater',
                'format' => 'html',
                'value' => function($data) { return Html::a($data->updater['username'], ['user/view', 'id'=>$data->updater->id]);},
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>
</div>
