<?php

use app\controllers\QuizController;
use app\models\Answer;
use app\models\QuestionSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model QuestionSearch */
/* @var $answerModel QuizController */
?>
<?php $form = ActiveForm::begin() ?>

<div style="margin-left: 30px;">
    <h3 style="font-size: 30px; color: #23527c ;">
        <?php echo Html::encode($model->name) ?>
    </h3>
    <small><?php echo Html::encode($model->hint) ?></small>
</div>
<?php
$answerModel = Answer::find()->where(['question_id' => $model->id])->all();
foreach ($answerModel as $answer) : ?>

    <div class="radio">
        <label style="font-size: 20px; text-align: left;  margin-left: 60px;">
            <?php echo Html::radio("selected_{$model->quiz_id}", false, [
                'value' => $answer->id
            ]); ?>
            <?php echo $answer->name ?>
        </label>
    </div>

<?php endforeach; ?>
<div class="pull-right">
    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>
<?php $form = ActiveForm::end() ?>
