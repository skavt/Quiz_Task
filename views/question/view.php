<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index', 'id' => $model->quiz_id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="question-view">

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
                'name',
                'hint',
                'max_ans',
            ],
    ]) ?>

</div>
