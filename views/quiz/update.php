<?php

use app\controllers\QuizController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $dropDownList QuizController */

$this->title = 'Update Quiz: ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_correct_ans')->textInput() ?>

    <?= $form->field($model, 'max_questions', ['enableAjaxValidation' => true])->textInput() ?>

    <?= $form->field($model, 'certification_valid')->dropDownList((array)$dropDownList) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
