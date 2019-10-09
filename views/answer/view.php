<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['answer/index/', 'id' => $model->question_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">

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
    <p calss="text-muted">
        <small>
            Created At: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            <br>
            Updated At: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </small>
    </p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'question_id',
            'is_correct',
            'name',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
