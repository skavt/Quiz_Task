<?php

use app\controllers\QuestionController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $quizModel QuestionController */
/* @var $model app\models\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions for : ' . $quizModel->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Question', ['create', 'id' => $_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>
            [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($data, $id) {
                        return Html::a($data['name'], ['answer/index', 'id' => $id]);
                    },
                    'contentOptions' => function () {
                        return ['title' => 'Create Answers'];
                    }
                ],
                'hint',
                'max_ans',

                [
                    'class' => 'yii\grid\ActionColumn'
                ],
            ],
    ]); ?>

</div>
