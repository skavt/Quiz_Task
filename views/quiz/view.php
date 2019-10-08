<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quiz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <br>
        <p calss="text-muted">
            <small>
                Created At: <?php if(!Yii::$app->formatter->asDate($model->created_at)){
                    var_dump("5 minutes ago");
                } ?>
            </small>
        </p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'subject',
            'min_correct_ans',
            'max_questions',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
