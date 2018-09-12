<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \unclead\multipleinput;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $users array */
/* @var $form yii\bootstrap\ActiveForm */


?>

<div class="project-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
//                    'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUSES) ?>

    <?php if ($model->isNewRecord === false) : ?>
    <?= $form->field($model, \common\models\Project::REL_PROJECT_USERS)->widget(multipleinput\MultipleInput::className(), [
        'id' => 'project-users-widget',
        'max' => 4,
        'min' => 0,
        'addButtonPosition' => multipleinput\MultipleInput::POS_HEADER,
        'columns' => [
            [
                'name' => 'user_id',
                'type' => multipleinput\MultipleInputColumn::TYPE_STATIC,
                'value' => function ($data)
                {
                    return $data ? Html::a($data->user->username, ['user/view', 'id' => $data->user_id]): '';
                },
            ],
            [
                'name' => 'project_id',
                'type' => 'hiddenInput',
                'defaultValue' => $model->id
            ],
        [
                'name' => 'user_id',
                'type' => 'dropDownList',
                'title' => 'USER',
                'items' => $users
            ],
        [
                'name' => 'role',
                'type' => 'dropDownList',
                'title' => 'ROLE',
                'items' => \common\models\ProjectUser::ROLES
            ],
        ]]);
    ?>
<?php endif;?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
