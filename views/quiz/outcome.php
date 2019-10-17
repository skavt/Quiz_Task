<?php

use app\controllers\QuizController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $model app\models\Answer */
/* @var $failed QuizController */
/* @var $passed QuizController */
/* @var $quizModel QuizController */
/* @var $correctAnswer QuizController */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="question-index">

    <?php if ($failed == ' ') : ?>
        <div class="text-danger" style="font-size: 30px; text-align: center; margin-top: 20px">
            <p>
                <?php echo Html::encode('Loser. You failed ' . $quizModel->subject . ' Quiz ') ?>
            </p>
        </div>
        <hr>

        <div class="text-dark" style="text-align: center; font-size: 25px">
            <?php echo Html::encode('Your answer is ' . $correctAnswer . ' from ' . $quizModel->max_questions); ?>
            <br>
            <?php echo Html::encode('You needed ' . $quizModel->min_correct_ans . ' correct answer'); ?>
        </div>
    <?php endif; ?>
    <?php if ($passed == ' ') : ?>
        <div class="text-success" style="font-size: 30px; text-align: center; margin-top: 20px">
            <p>
                <?php echo Html::encode('Genius. You passed ' . $quizModel->subject . ' Quiz ') ?>
            </p>
        </div>
        <hr>

        <div class="text-dark" style="text-align: center; font-size: 25px">
            <?php echo Html::encode('Your answer is ' . $correctAnswer . ' from ' . $quizModel->max_questions); ?>
            <br>
            <?php echo Html::encode('You needed ' . $quizModel->min_correct_ans . ' correct answer'); ?>
        </div>
    <?php endif; ?>

</div>
