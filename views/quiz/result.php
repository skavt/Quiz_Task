<?php

use app\models\Quiz;

/* @var $model app\models\Answer */
/* @var $dataProvider Quiz */
?>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'headerRowOptions' =>
        [
            'style' => 'background-color:#ccf8fe; color:#0a73bb',
        ],
    'columns' =>
        [
            'quiz_name',
            'correct_ans',
            'min_correct_ans',
            'question_count',
            [
                'label' => 'Status',
                'value' => function ($model) {
                    if ($model->correct_ans >= $model->min_correct_ans) {
                        return 'passed';
                    } else {
                        return 'failed';
                    }
                },
                'contentOptions' => function ($model) {
                    return ['style' => 'color: ' . ($model->correct_ans >= $model->min_correct_ans ? 'green' : 'red')];
                }
            ],
            [
                'label' => 'Percentage',
                'value' => function ($model) {
                    return round(($model->correct_ans * 100) / $model->question_count) . ' %';
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return $model->createdBy->username;
                }
            ],
            [
                'attribute' => 'certification_valid',
                'value' => function ($model) {
                    if ($model->correct_ans < $model->min_correct_ans) {
                        return '';
                    } else if (time() > $model->certification_valid) {
                        return 'inactive ' . Yii::$app->formatter->asDate($model->certification_valid);
                    } else {
                        return 'active ' . Yii::$app->formatter->asDate($model->certification_valid);
                    }
                },
                'contentOptions' => function ($model) {
                    return ['style' => 'color: ' . (time() > $model->certification_valid ? 'red' : 'green')];
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at);
                }
            ],
        ]
]); ?>


