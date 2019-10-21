<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */

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
    <br>
    <p calss="text-muted">
        <small>
            <i>
                <span>
                    Created At: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?> |
                    Updated At: <?php echo Yii::$app->formatter->asRelativeTime($model->updated_at) ?>
                </span>
                <br>
                <span>
                    Created By: <?php echo $model->createdBy->username ?> |
                    Updated By: <?php echo $model->createdBy->username ?>
                </span>
            </i>
        </small>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
                'subject',
                'min_correct_ans',
                'max_questions',
            ],
    ]) ?>

</div>
