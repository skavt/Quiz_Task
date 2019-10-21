<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['answer/index/', 'id' => $model->question_id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="answer-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

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
                    Updated By: <?php echo $model->updatedBy->username ?>
                </span>
            </i>
        </small>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
                'is_correct',
                'name',
            ],
    ]) ?>

</div>
