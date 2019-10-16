<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $model app\models\Answer */
/* @var $newModel app\models\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = ['label' => 'Question', 'url' => ['question/index/', 'id' => $newModel->quiz_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <p>
            <?= Html::encode('You can\'t create new answer. Please return in Quiz or Question') ?>
        </p>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


</div>
