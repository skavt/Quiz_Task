<?php

use app\models\Result;
use app\controllers\QuizController;

/* @var $result QuizController */
/* @var $quiz QuizController */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Quiz Name</th>
        <th scope="col">Min Correct Answer</th>
        <th scope="col">Correct Answer</th>
        <th scope="col">Max Questions</th>
        <th scope="col">Status</th>
        <th scope="col">Percentage</th>
        <th scope="col">Pass Date</th>
    </tr>
    </thead>
    <?php foreach ($quiz as $key) :?>

    <?php endforeach; ?>
    <?php foreach ($result as $value) :?>

    <tbody>

            <tr>
                <td><?php echo $key->subject ?></td>
                <td><?php echo $value->min_correct_ans ?></td>
                <td><?php echo $value->correct_ans ?></td>
                <td><?php echo $key->max_questions ?></td>
                <td><?php if($value->correct_ans >= $value->min_correct_ans){
                    echo '<span style = "color: green;">passed</span>';
                    }else {
                    echo '<span style = "color: red;">failed</span>';
                    }  ?></td>
                <td><?php echo ($value->correct_ans * $key->max_questions) . ' %'; ?></td>
                <td><?php echo Yii::$app->formatter->asDatetime($value->created_at) ?></td>
        </tr>
    </tbody>
    <?php endforeach; ?>

</table>
<?php
//
//use app\models\Client;
//use yii\helpers\Html;
//use yii\widgets\DetailView;
//use yii\grid\GridView;
//
//
///* @var $this yii\web\View */
///* @var $model app\models\Quiz */
///* @var $searchModel app\models\QuizSearch */
///* @var $dataProvider yii\data\ActiveDataProvider */
//
//?>
<?php // echo GridView::widget([
//    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
//    'columns' => [
//        ['class' => 'yii\grid\SerialColumn'],
//        [
//            'attribute' => 'quiz_id',
//            'label' => 'Quiz Name',
//        ],
//
//        'min_correct_ans',
//        ['attribute' => 'correct_ans',
//            'label' => 'Correct Answer',
//        ],
//
//        [
//            'label' => 'Max Question',
//            'format' => 'raw',
//        ],
//        [
//                'label' => 'Percentage',
//            'format' => 'raw',
//],
//        [
//            'label' => 'Status',
//            'format' => 'raw',
//        ],
//        'created_at:datetime',
//
//    ]
//]); ?>

