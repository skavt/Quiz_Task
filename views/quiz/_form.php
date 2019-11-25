<?php

use app\controllers\QuizController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $form yii\widgets\ActiveForm */
/* @var $dropDownList QuizController */
?>

<div class="quiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_correct_ans')->textInput() ?>

    <?= $form->field($model, 'max_questions')->textInput() ?>

    <?= $form->field($model, 'certification_valid')->dropDownList($model->dropDownList()) ?>

    <div style="display:inline-block;  width:48.6%; float: left; margin-right: 30px;">
        <?= $form->field($model, 'quiz_time')->textInput() ?>
    </div>

    <div style="width:48.7%;display:inline-block; ">
        <?= $form->field($model, 'quiz_time_format')->dropDownList($model->timeChooserOptions()) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
