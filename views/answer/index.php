<?php

use app\models\Question;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $newModel Question */
/* @var $model Question */
/* @var $searchModel app\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answers for : ' . $newModel->name ;
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/', 'id' => $newModel->id]];
$this->params['breadcrumbs'][] = ['label' => 'Question', 'url' => ['question/index/', 'id' => $newModel->quiz_id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Create Answer', ['create', 'id' => $_GET['id']], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'question_id',
            'is_correct',
            'name',
//            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
