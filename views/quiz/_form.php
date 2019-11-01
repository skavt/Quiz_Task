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

    <?= $form->field($model, 'certification_valid')->dropDownList((array)$dropDownList) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
