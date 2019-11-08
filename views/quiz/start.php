<?php

use app\controllers\QuizController;
use app\controllers\QuestionController;
use app\models\Answer;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
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
<h1 style="text-align: center" id="title">
    <?php echo Html::encode($this->title) ?>
</h1>
<hr>
<label id="result" for="name">

    <br>

</label>
<div style="margin-left:30px">
    <a class="btn btn-danger" id="prev">Prev</a>
    <a class="btn btn-success" id="next">Next</a>
    <button class="btn btn-success" id="submit">Submit</button>
</div>
<?php $form = ActiveForm::end() ?>
<?php try {
    $this->registerJsFile('@web/js/index.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
} catch (\yii\base\InvalidConfigException $e) {
} ?>

<?php //$form = ActiveForm::begin() ?>
<!--<h1 style="text-align: center">--><?php //echo Html::encode($this->title) ?><!--</h1>-->
<!--<hr>-->
<!---->
<?php //foreach ($questionModel as $question) : ?>
<!---->
<!--    <label for="name" style="font-size: 30px; margin-left: 30px; color: #23527c ;">-->
<!--        --><?php //echo $question->name ?>
<!--        <br>-->
<!--        <small style="font-size: 10px">-->
<!--            --><?php //echo $question->hint ?>
<!--        </small>-->
<!--    </label>-->
<!--    --><?php
//    $answerModel = Answer::find()->where(['question_id' => $question->id])->all();
//    foreach ($answerModel as $answer) : ?>
<!---->
<!--        <div class="radio">-->
<!--            <label style="font-size: 20px; text-align: left;  margin-left: 60px;">-->
<!--                --><?php //echo Html::radio("selected_{$question->id}", false, [
//                    'value' => $answer->id
//                ]); ?>
<!--                --><?php //echo $answer->name ?>
<!--            </label>-->
<!--        </div>-->
<!---->
<!--    --><?php //endforeach; ?>
<!---->
<?php //endforeach; ?>
<!---->
<!--<div class="pull-right">-->
<!--    --><?php //echo Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
<!--</div>-->
<?php //$form = ActiveForm::end() ?>
