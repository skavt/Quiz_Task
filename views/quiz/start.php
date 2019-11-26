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
/* @var $lastQuestion QuizController */
/* @var $progressLength QuizController */
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
<input id="id" value="<?php echo $quizModel->id ?>" hidden>
<input id="last_question" value="<?php echo $lastQuestion ?>" hidden>
<hr>
<label id="result" for="name">
    <br>
</label>
<form method="post">
    <div style="margin-left:30px">
        <a class="btn btn-danger" id="prev" type="submit">Prev</a>
        <a class="btn btn-success" id="next" type="submit">Next</a>
        <button class="btn btn-success" id="submit">Submit</button>
        <!--    --><?php //echo Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
</form>

<?php $form = ActiveForm::end() ?>

<?php try {
    $this->registerJsFile('@web/js/index.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
} catch (\yii\base\InvalidConfigException $e) {
} ?>
