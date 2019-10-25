<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>
            [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                [
                    'attribute' => 'subject',
                    'format' => 'raw',
                    'value' => function ($data, $id) {
                        return Html::a($data['subject'], ['question/index', 'id' => $id]);
                    },
                ],
                'min_correct_ans',
                'max_questions',
                [
                    'class' => 'yii\grid\ActionColumn'
                ],
            ],
    ]); ?>

</div>
