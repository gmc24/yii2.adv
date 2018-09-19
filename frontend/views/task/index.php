<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $projects array */
/* @var $executors array */


$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
$executors = Yii::$app->projectService->getActiveExecutorsInAvailableProjects(Yii::$app->user->identity);
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            'description:ntext',
            'estimation',
            ['attribute' => 'project_id',
                'label' => 'Project',
                'filter' => $projects,
                'format' => 'html',
                'content' => function($data) {
                    return Html::a($data->project['title'],  ['project/view', 'id' => $data->project_id]);},
                ],
            ['attribute'=>'executor_id',
                'label'=> 'Executor',
                'filter' => $executors,
                'format' => 'html',
                'value'=>function($data) { return (!$data->executor)? null : Html::a($data->executor['username'], ['user/view', 'id'=>$data->executor->id]);} ],
            'started_at:datetime',
            'completed_at:datetime',
            ['attribute'=>'created_by',
                'label'=>'Creator',
                'filter' => $executors,
                'format' => 'html',
                'value' => function($data) { return Html::a($data->creator['username'], ['user/view', 'id'=>$data->creator->id]) . '<br/>' . Yii::$app->formatter->format($data->created_at, 'datetime');},
                ],
            ['attribute'=>'updated_by',
                'label'=>'Updater',
                'filter' => $executors,
                'format' => 'html',
                'value' => function($data) { return Html::a($data->updater['username'], ['user/view', 'id'=>$data->updater->id]) . '<br/>' . Yii::$app->formatter->format($data->updated_at, 'datetime');},
                ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                    'headerOptions' => ['width'=>'40'],
                'template' => '{view} {update} {delete} {take} {finish}',
                'buttons' => [
                    'take' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('play');
                        return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                            'confirm' => 'Are you sure you want to take this task?',
                            'method' => 'post',
                        ],
                            'title'=>'Взять задачу']);
                    },
                 'finish' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('stop');
                        return Html::a($icon, ['task/finish', 'id' => $model->id], ['data' => [
                            'confirm' => 'Are you sure you want to complete this task?',
                            'method' => 'post',
                        ],
                            'title'=>'Завершить задачу']);
                    },
                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'take' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'finish' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    },

                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
<?//=\yii\helpers\VarDumper::dumpAsString($executors, 10, true)?>
</div>
