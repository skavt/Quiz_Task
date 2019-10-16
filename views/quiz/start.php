<?php

use app\controllers\QuizController;
use app\controllers\QuestionController;
use app\models\Answer;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuizSearch */
/* @var $quizModel QuizController */
/* @var $questionModel QuizController */
/* @var $answerModel QuizController */
/* @var $model QuestionController */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Quiz \'' . $quizModel->subject . '\'';

?>

<?php $form = ActiveForm::begin() ?>
    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>    <hr>
<?php foreach ($questionModel as $question) : ?>

    <label for="name" style="font-size: 30px">
        <?php echo $question->name ?>
        <br>
        <small style="font-size: 10px">
            <?php echo $question->hint ?>
        </small>
    </label>
    <?php
    $answerModel = Answer::find()->where(['question_id' => $question->id])->all();
    foreach ($answerModel as $answer) :
        ?>

        <div class="radio">
            <label style="font-size: 18px">
                <?php echo Html::radio("selected_{$question->id}", false, [
                    'value' => $answer->id
                ]); ?>
                <?php echo $answer->name ?>
            </label>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

    <div class="pull-right">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
<?php $form = ActiveForm::end() ?>