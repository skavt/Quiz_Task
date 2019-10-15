<?php

use app\controllers\QuizController;
use app\controllers\QuestionController;
use app\models\Answer;
use app\models\Question;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuizSearch */
/* @var $quizModel QuizController */
/* @var $questionModel QuizController */
/* @var $answerModel QuizController */
/* @var $model QuestionController */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Quiz \'' . $quizModel->subject . '\'';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>
<?php foreach ($questionModel as $question) : ?>

    <label for="name" style="margin-left: 500px; font-size: 20px">
        <?php echo $question->name ?>
        <br>
        <small style="font-size: 10px">
            <?php echo $question->hint?>
        </small>
    </label>
        <?php
        $answerModel = Answer::find()->where(['question_id' => $question->id])->all();
        foreach ($answerModel as $answer) :
            ?>
        <div class="radio">
            <label style="margin-left: 500px; font-size: 15px">
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                <?php echo $answer->name ?>
            </label>
        </div>
    <?php endforeach; ?>

<?php endforeach; ?>
