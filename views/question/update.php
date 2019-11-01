<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Update Question : ' . $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="question-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_ans', ['enableAjaxValidation' => true])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
