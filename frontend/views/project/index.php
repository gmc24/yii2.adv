<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['attribute' => 'id',
//                'header' => 'ID',
                'headerOptions' => ['width'=>'20'],
                ],
            ['attribute' => 'title',
                'content' => function ($data) {
        return Html::a($data->title, ['view', 'id'=>$data->id]);},
                'label' => 'Project Title',
                ],
            [
                'attribute' => 'Your roles',
                'value' => function(\common\models\Project $model) {
                    return join(', ', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                }
            ],
            'description:ntext',
            ['attribute' => 'active',
                'filter' => \common\models\Project::STATUSES,
                'value' => function(\common\models\Project $model) {
                    return \common\models\Project::STATUSES[$model->active];
                }],
            ['attribute'=>'creator',
                'label'=>'Creator',
                'format' => 'html',
                'value' => function($data) { return $data->creator['username'] . '<br/>' . Yii::$app->formatter->format($data->created_at, 'datetime');},
            ],
            ['attribute'=>'updater.username',
                'label'=>'Updater',
                'format' => 'html',
                'value' => function($data) { return $data->updater['username'] . '<br/>' . Yii::$app->formatter->format($data->updated_at, 'datetime');},
            ],

            ['class' => 'yii\grid\ActionColumn',
//                'template' => '{view} {update}',
                'template' => '{view}',
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
