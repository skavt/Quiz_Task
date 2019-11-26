<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="quiz-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' =>
            [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
    ]) ?>

    <p></p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
                'subject',
                'min_correct_ans',
                'max_questions',
                [
                    'attribute' => 'certification_valid',
                    'value' => function ($model) {
                        return $model->certification_valid . ' Months';
                    }
                ],
                [
                    'attribute' => 'quiz_time',
                    'value' => function ($model) {
                        return $model->quiz_time . ' ' . $model->quiz_time_format;
                    }
                ],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return $model->createdBy->username;
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return $model->updatedBy->username;
                    }
                ],
            ],
    ]) ?>
    <h1>Questions</h1>
    <p>
        <?= Html::a('Create Question', ['/question/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model) {
                        return "/question/$action?id=" . $model->id;
                    },
                ],
            ],
    ]); ?>

</div>
