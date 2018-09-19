<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="container">
    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
            'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">

                    <?= $form->field($model, 'username')->textInput() ?>
<!--                    --><?//= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATS_LABELS) ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <?= Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_FULL), ['class' => 'img-thumbnail col-sm-offset-4', 'style' => 'margin-bottom: 15px;']) ?>
                    <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*'])->label(false, ['style' => 'display:none']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group text-right">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>