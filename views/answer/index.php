<?php

use app\controllers\AnswerController;
use app\models\Question;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $questionModel AnswerController */
/* @var $model Question */
/* @var $searchModel app\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answers for : ' . $questionModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/', 'id' => $questionModel->id]];
$this->params['breadcrumbs'][] = ['label' => 'Question', 'url' => ['question/index/', 'id' => $questionModel->quiz_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="answer-index">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <p>
        <?php echo Html::a('Create Answer', ['create', 'id' => $_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>
            [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                'is_correct',
                'name',

                [
                    'class' => 'yii\grid\ActionColumn'
                ],
            ],
    ]); ?>

</div>
