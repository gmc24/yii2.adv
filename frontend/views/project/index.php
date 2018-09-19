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
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'title',
                'content' => function ($data) {
        return Html::a($data->title, ['view', 'id'=>$data->id]);},
                'label' => 'Project Title',
                ],
            [
                'attribute' => \common\models\Project::REL_PROJECT_USERS.' .role',
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
            ['attribute'=>'creator.username', 'label'=>'Creator'],
            ['attribute'=>'updater.username', 'label'=>'Updater'],
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
//                'template' => '{view} {update}',
                'template' => '{view}',
                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
