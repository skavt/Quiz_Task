<?php

use app\models\Result;
use app\controllers\QuizController;

/* @var $result QuizController */
/* @var $quiz QuizController */
/* @var $model app\models\Answer */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Quiz Name</th>
        <th scope="col">Correct Answer</th>
        <th scope="col">Min Correct Answer</th>
        <th scope="col">Questions</th>
        <th scope="col">Status</th>
        <th scope="col">Percentage</th>
        <th scope="col">Name</th>
        <th scope="col">Pass Date</th>
    </tr>
    </thead>

    <?php foreach ($result as $value) : ?>
        <tbody>
        <tr>
            <td><?php echo $value->quiz_name ?></td>
            <td><?php echo $value->correct_ans ?></td>
            <td><?php echo $value->min_correct_ans ?></td>
            <td><?php echo $value->question_count ?></td>
            <td><?php if ($value->correct_ans >= $value->min_correct_ans) {
                    echo '<span style = "color: green;">passed</span>';
                } else {
                    echo '<span style = "color: red;">failed</span>';
                } ?></td>
            <td><?php echo round(($value->correct_ans * 100) / $value->question_count) . ' %'; ?></td>
            <td><?php echo $value->createdBy->username ?></td>
            <td><?php echo Yii::$app->formatter->asDatetime($value->created_at) ?></td>
        </tr>
        </tbody>
    <?php endforeach; ?>

</table>

