<?php

use app\models\Result;
use app\controllers\QuizController;

/* @var $result QuizController */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Quiz Name</th>
        <th scope="col">Min Correct Answer</th>
        <th scope="col">Your Correct Answer</th>
        <th scope="col">Quiz Pass Date</th>
    </tr>
    </thead>
    <?php $i = 1;
    foreach ($result as $res) :?>
        <tbody>

        <tr>
            <th scope="row"><?php echo $i;
                $i++ ?></th>
            <td><?php echo $res->quiz_name ?></td>
            <td><?php echo $res->min_correct_ans ?></td>
            <td><?php echo $res->correct_ans ?></td>
            <td><?php echo Yii::$app->formatter->asRelativeTime($res->created_at) ?></td>
        </tr>
        </tbody>
    <?php endforeach; ?>

</table>