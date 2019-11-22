<?php

use app\models\Client;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $searchModel app\models\QuizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' =>
        [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'subject',
            'min_correct_ans',
            'max_questions',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' =>
                    [
                        'view' => function ($url, $model) {
                            if (\app\models\Progress::findOne(['created_by' => Yii::$app->user->id, 'quiz_id' => $model->id])) {
                                return Html::a('<span class="btn btn-success">Continue</span>', $url);
                            } else {
                                if(\app\models\Progress::findOne(['created_by' => Yii::$app->user->id])) {
                                    return Html::a('<span class="btn btn-success" disabled="true">Start</span>');
                                }else {
                                    return Html::a('<span class="btn btn-success">Start</span>', $url);
                                }
                            }
                        },
                    ],
                'urlCreator' => function ($action, $model) {
                    if ($action === 'view') {
                        $url = '/quiz/start?id=' . $model->id;
                        return $url;
                    };
                },
            ],
        ]
]); ?>
