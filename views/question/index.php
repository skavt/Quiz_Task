<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $newModel \app\models\Quiz */
/* @var $model app\models\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions for : ' . $newModel->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Create Question', ['create', 'id' => $_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            [
//                'attribute'=>'quiz_id',],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data, $id) {
                    return Html::a($data['name'], ['answer/index', 'id' => $id]);
                },
            ],
            'hint',
            'max_ans',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
